<?php
/**
 * Product-detail shell matching the TTCTECH reference.
 */

add_filter('blocksy:hero:custom-source', function ($source) {
	return function_exists('is_product') && is_product() ? false : $source;
}, 20);

add_action('wp', function () {
	if (!is_product()) {
		return;
	}
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
});

/**
 * Normalize existing WooCommerce content into the fields used by the mock.
 * Product data remains owned by WooCommerce; this only changes presentation.
 */
function ttc_product_detail_data(WC_Product $product) {
	$html = $product->get_description();
	$data = [
		'gallery' => [],
		'features' => [],
		'applications' => [],
		'heading' => $product->get_name(),
		'intro' => wp_strip_all_tags($product->get_short_description()),
		'caption' => '',
		'video_url' => '',
		'detail_image' => '',
		'pdfs' => [],
		'specifications' => [],
	];

	$seen_images = [];
	$add_image = static function ($url) use (&$data, &$seen_images) {
		if (!$url) {
			return;
		}
		$path = rawurldecode((string) wp_parse_url($url, PHP_URL_PATH));
		$key = preg_replace('/-\d+x\d+(?=\.[^.]+$)/', '', strtolower(basename($path)));
		$key = preg_replace('/[^a-z0-9]+/', '', $key);
		if (!$key || isset($seen_images[$key])) {
			return;
		}
		$seen_images[$key] = true;
		$data['gallery'][] = $url;
	};

	foreach (array_filter(array_merge([$product->get_image_id()], $product->get_gallery_image_ids())) as $image_id) {
		$add_image(wp_get_attachment_image_url($image_id, 'full'));
	}

	if ($html && class_exists('DOMDocument')) {
		libxml_use_internal_errors(true);
		$document = new DOMDocument();
		$document->loadHTML('<?xml encoding="utf-8" ?><body>' . $html . '</body>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		$xpath = new DOMXPath($document);
		$text = static fn ($node) => trim(preg_replace('/\s+/u', ' ', html_entity_decode($node->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
		$list_items = static function ($list) use ($xpath, $text) {
			$items = [];
			foreach ($xpath->query('./li', $list) as $item) {
				$value = $text($item);
				if ($value !== '') {
					$items[] = $value;
				}
			}
			return $items;
		};

		foreach ($xpath->query('//img[@src]') as $image) {
			$add_image($image->getAttribute('src'));
		}

		$video = $xpath->query('//iframe[@src] | //video[@src] | //video/source[@src]')->item(0);
		if ($video) {
			$data['video_url'] = $video->getAttribute('src');
		}

		$lead_paragraphs = [];
		foreach ($xpath->query('//p') as $paragraph) {
			$value = $text($paragraph);
			if (mb_strlen($value) >= 20 && !preg_match('/^(tính năng|ứng dụng|catalogue|dải sản phẩm)\b/iu', $value)) {
				$lead_paragraphs[] = $value;
			}
		}
		if (!$data['intro'] && $lead_paragraphs) {
			$data['intro'] = $lead_paragraphs[0];
		}

		$detail_heading = null;
		$product_name_key = sanitize_title(str_replace('®', '', $product->get_name()));
		foreach ($xpath->query('//h1 | //h2 | //h3 | //h4') as $heading) {
			$value = $text($heading);
			if (
				$value !== ''
				&& sanitize_title(str_replace('®', '', $value)) !== $product_name_key
				&& !preg_match('/^(ứng dụng|dải sản phẩm|tính năng|các ứng dụng|vật liệu|catalogue)/iu', $value)
			) {
				$detail_heading = $heading;
				$data['heading'] = $value;
				break;
			}
		}
		if ($detail_heading) {
			$next_paragraph = $xpath->query('following::p[normalize-space()][1]', $detail_heading)->item(0);
			$value = $next_paragraph ? $text($next_paragraph) : '';
			if (mb_strlen($value) >= 20) {
				$data['intro'] = $value;
			}
		}
		foreach ($lead_paragraphs as $paragraph) {
			if ($paragraph !== $data['intro']) {
				$data['caption'] = $paragraph;
				break;
			}
		}
		if (!$data['caption']) {
			$data['caption'] = $data['intro'];
		}

		$feature_marker = null;
		$application_marker = null;
		$range_marker = null;
		foreach ($xpath->query('//h1 | //h2 | //h3 | //h4 | //p') as $node) {
			$value = $text($node);
			if (!$feature_marker && preg_match('/tính năng/iu', $value)) {
				$feature_marker = $node;
			}
			if (!$application_marker && preg_match('/^ứng dụng\b/iu', $value)) {
				$application_marker = $node;
			}
			if (!$range_marker && preg_match('/^dải sản phẩm\b/iu', $value)) {
				$range_marker = $node;
			}
		}

		if ($feature_marker) {
			$list = $xpath->query('following::ul[1]', $feature_marker)->item(0);
			$data['features'] = $list ? $list_items($list) : [];
		}
		if ($application_marker) {
			$list = $xpath->query('following::ul[1]', $application_marker)->item(0);
			$data['applications'] = $list ? $list_items($list) : [];
			$image = $xpath->query('following::img[1]', $application_marker)->item(0);
			$data['detail_image'] = $image ? $image->getAttribute('src') : '';
		}

		if (!$data['features']) {
			$first_list = $xpath->query('//ul')->item(0);
			$data['features'] = $first_list ? $list_items($first_list) : [];
		}
		if (!$data['features']) {
			foreach ($xpath->query('//p') as $paragraph) {
				$value = ltrim($text($paragraph), "• \t\n\r\0\x0B");
				if ($value !== $text($paragraph) && $value !== '') {
					$data['features'][] = $value;
				}
			}
		}

		if ($range_marker) {
			$current_label = '';
			foreach ($xpath->query('following::*[self::h3 or self::h4 or self::ul]', $range_marker) as $node) {
				if (in_array(strtolower($node->nodeName), ['h3', 'h4'], true)) {
					$current_label = $text($node);
					continue;
				}
				$items = $list_items($node);
				if ($items) {
					$data['specifications'][] = [
						'label' => $current_label ?: 'Thông số',
						'items' => $items,
					];
					$current_label = '';
				}
			}
		}
		if (!$data['specifications']) {
			foreach ($xpath->query('//h3 | //h4') as $heading) {
				$label = $text($heading);
				if (!preg_match('/(thân dao|đài dao|mảnh dao|insert|thông số|kích thước)/iu', $label)) {
					continue;
				}
				$list = $xpath->query('following::ul[1]', $heading)->item(0);
				$items = $list ? $list_items($list) : [];
				if ($items) {
					$data['specifications'][] = ['label' => $label, 'items' => $items];
				}
			}
		}

		foreach ($xpath->query('//a[@href]') as $link) {
			$href = $link->getAttribute('href');
			if (preg_match('/\.pdf(?:$|[?#])/i', $href) || preg_match('/(pdf|catalogue|tải file)/iu', $text($link))) {
				$data['pdfs'][] = [
					'label' => $text($link) ?: basename((string) wp_parse_url($href, PHP_URL_PATH)),
					'url' => $href,
				];
			}
		}
		libxml_clear_errors();
	}

	// ponytail: ACF catalogues win; description PDFs are fallback only.
	$acf_pdfs = function_exists('ttc_product_acf_catalogues') ? ttc_product_acf_catalogues($product) : [];
	if ($acf_pdfs) {
		$data['pdfs'] = $acf_pdfs;
	}

	foreach ($product->get_attributes() as $attribute) {
		$values = $attribute->is_taxonomy()
			? wc_get_product_terms($product->get_id(), $attribute->get_name(), ['fields' => 'names'])
			: $attribute->get_options();
		if ($values) {
			$data['specifications'][] = [
				'label' => wc_attribute_label($attribute->get_name()),
				'items' => array_map('strval', $values),
			];
		}
	}

	if (!$data['gallery']) {
		$data['gallery'][] = wc_placeholder_img_src('woocommerce_single');
	}
	if (!$data['detail_image']) {
		$data['detail_image'] = $data['gallery'][0];
	}

	return $data;
}
