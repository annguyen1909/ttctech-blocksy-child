<?php
/**
 * ACF catalogue fields for Woo products.
 * ponytail: free ACF = one primary URL+label (no repeater). Multi-PDF → ACF Pro repeater later.
 */

if (!defined('ABSPATH')) {
	exit;
}

add_action('acf/init', function () {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group([
		'key' => 'group_ttc_catalogue',
		'title' => 'TTC Catalogue',
		'fields' => [
			[
				'key' => 'field_ttc_catalogue_label',
				'label' => 'Catalogue label',
				'name' => 'ttc_catalogue_label',
				'type' => 'text',
				'instructions' => 'Link text on product downloads (e.g. Datasheet Digimar 814 SR).',
			],
			[
				'key' => 'field_ttc_catalogue_url',
				'label' => 'Catalogue URL',
				'name' => 'ttc_catalogue_url',
				'type' => 'url',
				'instructions' => 'Official PDF / datasheet URL. Preferred over links parsed from description.',
			],
			[
				'key' => 'field_ttc_catalogue_label_2',
				'label' => 'Catalogue label (2)',
				'name' => 'ttc_catalogue_label_2',
				'type' => 'text',
				'instructions' => 'Optional second link (free ACF; use Pro repeater if you need many).',
			],
			[
				'key' => 'field_ttc_catalogue_url_2',
				'label' => 'Catalogue URL (2)',
				'name' => 'ttc_catalogue_url_2',
				'type' => 'url',
			],
		],
		'location' => [[
			[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			],
		]],
		'position' => 'side',
		'style' => 'default',
		'active' => true,
	]);
});

/**
 * ACF catalogues for a product (empty if none / ACF missing).
 *
 * @return list<array{label:string,url:string}>
 */
function ttc_product_acf_catalogues(WC_Product $product): array {
	if (!function_exists('get_field')) {
		return [];
	}

	$id = $product->get_id();
	$out = [];
	foreach ([
		['ttc_catalogue_label', 'ttc_catalogue_url'],
		['ttc_catalogue_label_2', 'ttc_catalogue_url_2'],
	] as [$label_key, $url_key]) {
		$url = trim((string) get_field($url_key, $id));
		if ($url === '') {
			continue;
		}
		$label = trim((string) get_field($label_key, $id));
		$out[] = [
			'label' => $label !== '' ? $label : basename((string) wp_parse_url($url, PHP_URL_PATH)),
			'url' => $url,
		];
	}
	return $out;
}
