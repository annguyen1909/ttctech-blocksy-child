<?php
/**
 * Data helpers for the technical-knowledge archive and article templates.
 */

if (!defined('ABSPATH')) {
	exit;
}

function ttc_knowledge_posts_per_page(): int {
	return 8;
}

function ttc_knowledge_highlight_count(): int {
	return 4;
}

// Main query must allow at least as many pages as home.php's custom list,
// otherwise /page/3/ 404s while paginate_links still prints "3".
// Blocksy sets posts_per_page on parse_tax_query (not pre_get_posts), so override after it.
add_action('parse_tax_query', function ($query) {
	if (is_admin() || !$query->is_main_query() || !$query->is_home()) {
		return;
	}
	$query->set('posts_per_page', ttc_knowledge_posts_per_page());
}, 20);

function ttc_knowledge_url(): string {
	$page_id = (int) get_option('page_for_posts');
	return $page_id ? (string) get_permalink($page_id) : home_url('/');
}

function ttc_article_title(int $post_id): string {
	$content = (string) get_post_field('post_content', $post_id);
	if (preg_match('/<h1\b[^>]*>(.*?)<\/h1>/is', $content, $match)) {
		return trim(wp_strip_all_tags($match[1]));
	}
	return get_the_title($post_id);
}

function ttc_article_body(int $post_id): string {
	return (string) preg_replace(
		'/<h1\b[^>]*>.*?<\/h1>/is',
		'',
		(string) get_post_field('post_content', $post_id),
		1
	);
}

function ttc_heading_anchor(string $text, array &$used): string {
	$base = sanitize_title($text);
	if ($base === '') {
		$base = 'section';
	}
	$id = $base;
	$n = 2;
	while (isset($used[$id])) {
		$id = $base . '-' . $n++;
	}
	$used[$id] = true;
	return $id;
}

/**
 * Inject heading IDs and build a numbered TOC (h2 / h3), matching Uno-Tech blog.
 *
 * @return array{html: string, items: array<int, array{id: string, text: string, level: int, num: string}>}
 */
function ttc_prepare_article_content(int $post_id): array {
	$html = (string) apply_filters('the_content', ttc_article_body($post_id));
	$used = [];
	$items = [];
	$h2 = 0;
	$h3 = 0;

	$html = (string) preg_replace_callback(
		'/<h([23])(\b[^>]*)>(.*?)<\/h\1>/is',
		static function ($match) use (&$used, &$items, &$h2, &$h3) {
			$level = (int) $match[1];
			$attrs = $match[2];
			$inner = $match[3];
			$text = trim(preg_replace('/\s+/u', ' ', wp_strip_all_tags($inner)));
			if ($text === '') {
				return $match[0];
			}

			$id = '';
			if (preg_match('/\bid\s*=\s*([\'"])([^\'"]+)\1/i', $attrs, $id_match)) {
				$id = sanitize_title($id_match[2]);
			}
			if ($id === '') {
				$id = ttc_heading_anchor($text, $used);
				$attrs .= ' id="' . esc_attr($id) . '"';
			} else {
				$used[$id] = true;
			}

			if ($level === 2) {
				$h2++;
				$h3 = 0;
				$num = $h2 . '.';
			} else {
				$h3++;
				$num = max(1, $h2) . '.' . $h3;
			}

			$items[] = [
				'id' => $id,
				'text' => $text,
				'level' => $level,
				'num' => $num,
			];

			return '<h' . $level . $attrs . '>' . $inner . '</h' . $level . '>';
		},
		$html
	);

	return [
		'html' => $html,
		'items' => $items,
	];
}

function ttc_article_excerpt(int $post_id, int $words = 24): string {
	// ponytail: always first real <p> in body — post_excerpt titles are inconsistent after import/translate.
	$body = ttc_article_body($post_id);
	$excerpt = '';
	if (preg_match_all('/<p\b[^>]*>(.*?)<\/p>/is', $body, $matches)) {
		foreach ($matches[1] as $html) {
			$text = trim(preg_replace('/\x{00A0}+/u', ' ', wp_strip_all_tags($html)));
			if ($text !== '') {
				$excerpt = $text;
				break;
			}
		}
	}
	if ($excerpt === '') {
		$excerpt = trim(preg_replace('/\x{00A0}+/u', ' ', wp_strip_all_tags($body)));
	}
	return wp_trim_words($excerpt, $words);
}

function ttc_article_image(int $post_id, string $size = 'large'): string {
	$image = get_the_post_thumbnail_url($post_id, $size);
	if ($image) {
		return $image;
	}

	if (preg_match('/<img\b[^>]*\bsrc=["\']([^"\']+)["\']/i', (string) get_post_field('post_content', $post_id), $match)) {
		return $match[1];
	}

	return TTC_THEME_URI . '/assets/img/logo.png';
}

function ttc_popular_articles(int $limit = 3, array $exclude = []): array {
	return get_posts([
		'numberposts' => $limit,
		'post_status' => 'publish',
		'post__not_in' => array_map('intval', $exclude),
		'orderby' => [
			'comment_count' => 'DESC',
			'date' => 'DESC',
		],
	]);
}

function ttc_catalog_sidebar_items(): array {
	$items = [];
	$terms = get_terms([
		'taxonomy' => 'product_cat',
		'hide_empty' => true,
		'parent' => 0,
	]);

	if (!is_wp_error($terms)) {
		foreach ($terms as $term) {
			if ($term->slug === 'uncategorized') {
				continue;
			}
			$items[] = [
				'label' => $term->name,
				'url' => get_term_link($term),
			];
		}
	}

	if ($items) {
		return $items;
	}

	// ponytail: the import has no usable product categories yet; replace this fallback automatically once taxonomy data exists.
	$shop_url = wc_get_page_permalink('shop');
	foreach (['Tất cả sản phẩm', 'Dụng cụ cắt', 'Dụng cụ đo', 'Gá kẹp dao', 'Gá kẹp phôi', 'Dầu cắt gọt', 'Dụng cụ phụ trợ', 'Máy công cụ', 'Dịch vụ'] as $label) {
		$items[] = [
			'label' => $label,
			'url' => $shop_url,
		];
	}
	return $items;
}

add_filter('blocksy:single:has-default-hero', function ($show) {
	return is_singular('post') ? false : $show;
});

add_filter('comments_open', function ($open, $post_id) {
	return get_post_type($post_id) === 'post' ? false : $open;
}, 10, 2);
