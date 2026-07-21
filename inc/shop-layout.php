<?php
/**
 * Shop page sections matching TTCTECH catalog mockup.
 */

add_action('woocommerce_before_main_content', function () {
	if (!is_shop() && !is_product_taxonomy()) {
		return;
	}
	echo '<div class="ttc-shop">';
}, 5);

add_action('woocommerce_after_main_content', function () {
	if (!is_shop() && !is_product_taxonomy()) {
		return;
	}

	if (is_shop()) {
		get_template_part('template-parts/shop', 'featured');
		get_template_part('template-parts/shop', 'blog');
		get_template_part('template-parts/shop', 'support');
	}

	echo '</div>';
}, 50);

add_action('woocommerce_archive_description', function () {
	if (!is_shop() && !is_product_taxonomy()) {
		return;
	}
	get_template_part('template-parts/shop', 'toolbar');
	get_template_part('template-parts/shop', 'brands');
}, 20);

add_filter('woocommerce_show_page_title', function ($show) {
	if (is_shop()) {
		return false; // title rendered in toolbar partial
	}
	return $show;
});

/** Hide Blocksy default hero section on shop/archive — we use our own toolbar. */
add_filter('blocksy:hero:custom-source', function ($source) {
	if (function_exists('is_shop') && (is_shop() || is_product_taxonomy())) {
		return false;
	}
	return $source;
});

add_filter('loop_shop_columns', function () {
	return 4;
});

add_filter('loop_shop_per_page', function () {
	return 12;
}, 20);

/** Avoid duplicate sort dropdown (we render it in toolbar). */
add_action('wp', function () {
	if (!is_shop() && !is_product_taxonomy()) {
		return;
	}
	remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
	remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
});

add_action('woocommerce_before_shop_loop_item_title', function () {
	$brand = ttc_brand_image_for_product();
	if ($brand) {
		echo '<span class="ttc-card-brand"><img src="' . esc_url($brand['img']) . '" alt="' . esc_attr($brand['name']) . '" width="72" height="24" loading="lazy" /></span>';
		return;
	}
	$name = ttc_product_brand_name();
	if ($name) {
		echo '<span class="ttc-card-brand ttc-card-brand--text">' . esc_html($name) . '</span>';
	}
}, 5);

/** Simple brand / category GET filters on shop. */
add_action('pre_get_posts', function ($q) {
	if (is_admin() || !$q->is_main_query()) {
		return;
	}
	if (!is_shop() && !is_product_taxonomy()) {
		return;
	}

	$tax_query = (array) $q->get('tax_query');

	if (!empty($_GET['ttc_brand']) && !is_product_tag()) {
		$tax_query[] = [
			'taxonomy' => 'product_tag',
			'field' => 'slug',
			'terms' => sanitize_title(wp_unslash($_GET['ttc_brand'])),
		];
	}

	if (!empty($_GET['ttc_type']) && !is_product_category()) {
		$tax_query[] = [
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => sanitize_title(wp_unslash($_GET['ttc_type'])),
		];
	}

	if (count($tax_query) > 0) {
		$q->set('tax_query', $tax_query);
	}

	if (!empty($_GET['s']) && (is_shop() || is_product_taxonomy())) {
		$q->set('s', sanitize_text_field(wp_unslash($_GET['s'])));
	}
});
