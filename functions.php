<?php
/**
 * TTCTECH Blocksy child theme.
 */

if (!defined('ABSPATH')) {
	exit;
}

define('TTC_THEME_VERSION', '2.3.10');
define('TTC_THEME_URI', get_stylesheet_directory_uri());
define('TTC_THEME_DIR', get_stylesheet_directory());

require_once TTC_THEME_DIR . '/inc/setup.php';
require_once TTC_THEME_DIR . '/inc/brands.php';
require_once TTC_THEME_DIR . '/inc/catalog.php';
require_once TTC_THEME_DIR . '/inc/shop-layout.php';
require_once TTC_THEME_DIR . '/inc/acf-catalogue.php';
require_once TTC_THEME_DIR . '/inc/product-layout.php';
require_once TTC_THEME_DIR . '/inc/blog.php';
require_once TTC_THEME_DIR . '/inc/chrome.php';
require_once TTC_THEME_DIR . '/inc/i18n.php';
