<?php
/**
 * Brand logo map (Sapo theme assets, mirrored locally).
 */
function ttc_brand_catalog() {
	$base = TTC_THEME_URI . '/assets/img/brands';
	return [
		['name' => 'Sandvik', 'label' => 'SANDVIK COROMANT', 'slug' => 'sandvik', 'img' => "$base/brand_1.jpg"],
		['name' => 'Taegutec', 'slug' => 'taegutec', 'img' => "$base/brand_2.jpg"],
		['name' => 'OSG', 'slug' => 'osg', 'img' => "$base/brand_3.jpg"],
		['name' => 'YG', 'slug' => 'yg', 'img' => "$base/brand_4.jpg"],
		['name' => 'Guhring', 'slug' => 'guhring', 'img' => "$base/brand_5.jpg"],
		['name' => 'Widin', 'slug' => 'widin', 'img' => "$base/brand_6.jpg"],
		['name' => 'UFS', 'slug' => 'ufs', 'img' => "$base/brand_7.jpg"],
		['name' => 'ZCC', 'slug' => 'zcc', 'img' => "$base/brand_8.jpg"],
		['name' => 'SEC', 'slug' => 'sec', 'img' => "$base/brand_9.jpg"],
		['name' => 'Mahr', 'slug' => 'mahr', 'img' => "$base/brand_10.jpg"],
		['name' => 'Dasqua', 'slug' => 'dasqua', 'img' => "$base/brand_11.jpg"],
		['name' => 'Samchully', 'slug' => 'samchully', 'img' => "$base/brand_16.jpg"],
	];
}

function ttc_selected_brand() {
	$slug = isset($_GET['ttc_brand']) ? sanitize_title(wp_unslash($_GET['ttc_brand'])) : '';
	if (!$slug && function_exists('is_product_tag') && is_product_tag()) {
		$term = get_queried_object();
		$slug = $term instanceof WP_Term ? $term->slug : '';
	}
	foreach (ttc_brand_catalog() as $brand) {
		if ($brand['slug'] === $slug) {
			return $brand;
		}
	}
	return null;
}

function ttc_brand_image_for_product($product_id = 0) {
	$tags = wp_get_post_terms($product_id ?: get_the_ID(), 'product_tag', ['fields' => 'names']);
	if (is_wp_error($tags) || !$tags) {
		return null;
	}
	foreach (ttc_brand_catalog() as $brand) {
		foreach ($tags as $tag) {
			if (stripos($tag, $brand['name']) !== false || strcasecmp($tag, $brand['name']) === 0) {
				return $brand;
			}
		}
	}
	return null;
}
