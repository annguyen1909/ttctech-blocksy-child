<?php
/**
 * Enqueue + replace Blocksy header/footer with TTCTECH chrome.
 */

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'blocksy-parent',
		get_template_directory_uri() . '/style.css',
		[],
		null
	);

	wp_enqueue_style(
		'ttc-fonts',
		'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap',
		[],
		null
	);

	wp_enqueue_style(
		'ttc-main',
		TTC_THEME_URI . '/assets/css/ttc.css',
		['blocksy-parent', 'ttc-fonts'],
		TTC_THEME_VERSION
	);

	wp_enqueue_script(
		'ttc-main',
		TTC_THEME_URI . '/assets/js/ttc.js',
		[],
		TTC_THEME_VERSION,
		true
	);
});

add_filter('blocksy:builder:header:enabled', '__return_false');
add_filter('blocksy:builder:footer:enabled', '__return_false');

add_action('blocksy:header:before', function () {
	get_template_part('template-parts/header');
});

add_action('blocksy:footer:before', function () {
	get_template_part('template-parts/footer');
});

add_action('after_setup_theme', function () {
	register_nav_menus([
		'ttc_primary' => 'TTCTECH Primary',
		'ttc_footer_cats' => 'TTCTECH Footer Categories',
		'ttc_footer_support' => 'TTCTECH Footer Support',
	]);
});
