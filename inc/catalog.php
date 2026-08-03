<?php
/**
 * B2B catalog mode: hide prices / cart, show "Liên hệ".
 */

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// ponytail: shop cards use contain/1:1 — disable WC hover zoom on single (too aggressive).
add_filter('theme_mod_has_product_single_zoom', static fn () => 'no');
add_action('after_setup_theme', static function () {
	remove_theme_support('wc-product-gallery-zoom');
}, 20);

add_action('init', function () {
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
});

add_filter('woocommerce_is_purchasable', '__return_false');

add_action('woocommerce_after_shop_loop_item', function () {
	$contact = ttc_contact_url();
	echo '<a class="ttc-contact-link" href="' . esc_url($contact) . '">Liên hệ <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg></a>';
}, 15);

add_action('woocommerce_single_product_summary', function () {
	$contact = ttc_contact_url();
	echo '<p class="ttc-single-contact"><a class="ttc-btn ttc-btn--primary" href="' . esc_url($contact) . '">Yêu cầu báo giá</a></p>';
}, 30);

function ttc_contact_url() {
	$page = get_page_by_path('lien-he');
	return $page ? get_permalink($page) : home_url('/lien-he/');
}

function ttc_quote_url() {
	$page = get_page_by_path('yeu-cau-bao-gia');
	return $page ? get_permalink($page) : ttc_contact_url();
}

/** Brand label from first matching product tag (known brands). */
function ttc_product_brand_name($product_id = 0) {
	static $brands = null;
	if ($brands === null) {
		$brands = [
			'Sandvik', 'Taegutec', 'Dasqua', 'Mahr', 'Guhring', 'OSG', 'Widin',
			'YG', 'YG Tooling', 'ZCC', 'SEC', 'UFS', 'DURA', 'Dongsan',
			'Jingchi tool', 'Niigataseiki', 'Samchully', 'Nine9', 'TTC',
		];
	}

	$tags = wp_get_post_terms($product_id ?: get_the_ID(), 'product_tag', ['fields' => 'names']);
	if (is_wp_error($tags) || !$tags) {
		return '';
	}

	foreach ($brands as $brand) {
		foreach ($tags as $tag) {
			if (strcasecmp($tag, $brand) === 0) {
				return $tag;
			}
		}
	}

	return $tags[0];
}
