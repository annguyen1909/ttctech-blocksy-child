<?php
/**
 * Assets + Blocksy header/footer builder (customer-editable chrome).
 */

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'ttc-fonts',
		'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'ttc-main',
		TTC_THEME_URI . '/assets/css/ttc.css',
		['ct-main-styles', 'ttc-fonts'],
		filemtime(TTC_THEME_DIR . '/assets/css/ttc.css')
	);

	wp_enqueue_script(
		'ttc-main',
		TTC_THEME_URI . '/assets/js/ttc.js',
		[],
		filemtime(TTC_THEME_DIR . '/assets/js/ttc.js'),
		true
	);
});

add_action('after_setup_theme', function () {
	register_nav_menus([
		'ttc_primary' => 'TTCTECH Primary',
		'ttc_footer_cats' => 'TTCTECH Footer Categories',
		'ttc_footer_support' => 'TTCTECH Footer Support',
	]);
});

add_filter('body_class', function (array $classes): array {
	if (is_page('lien-he')) {
		$classes[] = 'ttc-contact-page';
	}
	return $classes;
});
