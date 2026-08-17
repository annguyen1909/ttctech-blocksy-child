<?php
/**
 * Brands = product tags that have a logo (ACF / thumbnail).
 * Add/remove: WooCommerce → Tags → upload logo.
 */

function ttc_brand_image_url($term): string {
	if (!$term instanceof WP_Term) {
		return '';
	}
	if (function_exists('get_field')) {
		$img = get_field('ttc_brand_logo', 'product_tag_' . $term->term_id);
		if (is_array($img) && !empty($img['url'])) {
			return (string) $img['url'];
		}
		if (is_numeric($img) && $img) {
			$url = wp_get_attachment_image_url((int) $img, 'medium');
			if ($url) {
				return $url;
			}
		}
		if (is_string($img) && $img !== '') {
			return $img;
		}
	}
	$thumb = (int) get_term_meta($term->term_id, 'thumbnail_id', true);
	if ($thumb) {
		$url = wp_get_attachment_image_url($thumb, 'medium');
		if ($url) {
			return $url;
		}
	}
	return '';
}

function ttc_brand_from_term(WP_Term $term): ?array {
	$img = ttc_brand_image_url($term);
	if ($img === '') {
		return null;
	}
	return [
		'name' => $term->name,
		'label' => $term->name,
		'slug' => $term->slug,
		'img' => $img,
		'term_id' => $term->term_id,
	];
}

/**
 * Curated display order for the brand strip (homepage + shop filter).
 * Slugs not listed here fall to the end, alphabetically.
 */
function ttc_brand_order() {
	return [
		'sandvik', 'taegutec', 'osg', 'yg', 'guhring', 'widin',
		'ufs', 'zcc', 'sec', 'mahr', 'dasqua', 'samchully',
	];
}

function ttc_brand_catalog() {
	$terms = get_terms([
		'taxonomy' => 'product_tag',
		'hide_empty' => false,
	]);
	if (is_wp_error($terms) || !$terms) {
		return [];
	}
	$out = [];
	foreach ($terms as $term) {
		$brand = ttc_brand_from_term($term);
		if ($brand) {
			$out[] = $brand;
		}
	}
	$order = array_flip(ttc_brand_order());
	$big = count($out) + 1;
	usort($out, static function ($a, $b) use ($order, $big) {
		$ra = $order[$a['slug']] ?? $big;
		$rb = $order[$b['slug']] ?? $big;
		if ($ra === $rb) {
			return strcasecmp($a['label'], $b['label']);
		}
		return $ra <=> $rb;
	});
	return $out;
}

function ttc_selected_brand() {
	$slug = isset($_GET['ttc_brand']) ? sanitize_title(wp_unslash($_GET['ttc_brand'])) : '';
	if (!$slug && function_exists('is_product_tag') && is_product_tag()) {
		$term = get_queried_object();
		$slug = $term instanceof WP_Term ? $term->slug : '';
	}
	if ($slug === '') {
		return null;
	}
	$term = get_term_by('slug', $slug, 'product_tag');
	return $term instanceof WP_Term ? ttc_brand_from_term($term) : null;
}

function ttc_brand_image_for_product($product_id = 0) {
	$terms = wp_get_post_terms($product_id ?: get_the_ID(), 'product_tag');
	if (is_wp_error($terms) || !$terms) {
		return null;
	}
	foreach ($terms as $term) {
		$brand = ttc_brand_from_term($term);
		if ($brand) {
			return $brand;
		}
	}
	return null;
}

add_shortcode('ttc_brands', function () {
	$brands = ttc_brand_catalog();
	if (!$brands) {
		return '';
	}
	$shop = wc_get_page_permalink('shop');
	ob_start();
	echo '<div class="ttc-home-brands__grid">';
	foreach ($brands as $brand) {
		$url = add_query_arg('ttc_brand', $brand['slug'], $shop);
		printf(
			'<a class="ttc-home-brands__tile" href="%s"><img src="%s" alt="%s" loading="lazy" /></a>',
			esc_url($url),
			esc_url($brand['img']),
			esc_attr($brand['label'])
		);
	}
	echo '</div>';
	return ob_get_clean();
});
