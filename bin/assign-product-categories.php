<?php
/**
 * Assign Woo product_cat from the Sapo import CSV + name heuristics.
 * Local-only: run via WP-CLI against ttctech.local. Does not touch remote.
 *
 * wp eval-file wp-content/themes/blocksy-child/bin/assign-product-categories.php
 */

if (!defined('ABSPATH')) {
	exit(1);
}

require_once TTC_THEME_DIR . '/inc/product-category-map.php';

$csv = WP_CONTENT_DIR . '/uploads/woo-import-from-sapo.csv';
if (!is_readable($csv)) {
	WP_CLI::error("Missing $csv");
}

$by_alias = [];
$handle = fopen($csv, 'r');
$header = fgetcsv($handle);
$header[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $header[0]);
while (($row = fgetcsv($handle)) !== false) {
	$item = array_combine($header, $row);
	if (!$item) {
		continue;
	}
	$alias = trim((string) ($item['Meta: _sapo_alias'] ?? ''));
	if ($alias === '') {
		continue;
	}
	$by_alias[$alias] = [
		'category' => trim((string) ($item['Categories'] ?? '')),
		'name' => trim((string) ($item['Name'] ?? '')),
	];
}
fclose($handle);

$q = new WP_Query([
	'post_type' => 'product',
	'post_status' => 'any',
	'posts_per_page' => -1,
	'fields' => 'ids',
]);

$counts = array_fill_keys(ttc_product_category_slugs(), 0);
$assigned = 0;
$skipped = 0;

foreach ($q->posts as $id) {
	$alias = (string) get_post_meta($id, '_sapo_alias', true);
	$name = get_the_title($id);
	$sapo = $by_alias[$alias]['category'] ?? '';
	$slug = ttc_map_product_category_slug($sapo, $name, $alias);
	$result = wp_set_object_terms($id, $slug, 'product_cat');
	if (is_wp_error($result)) {
		$skipped++;
		WP_CLI::warning($name . ': ' . $result->get_error_message());
		continue;
	}
	$assigned++;
	$counts[$slug] = ($counts[$slug] ?? 0) + 1;
}

WP_CLI::success("Assigned $assigned products locally. Skipped $skipped.");
foreach ($counts as $slug => $n) {
	WP_CLI::log(sprintf('  %-20s %d', $slug, $n));
}
