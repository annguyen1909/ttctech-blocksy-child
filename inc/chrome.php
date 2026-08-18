<?php
/**
 * Blocksy Header/Footer Builder chrome for TTCTECH.
 *
 * Layout lives in Customizer (header_placements / footer_placements).
 * Custom builder items keep shop search, hotline (ACF phone), brand and
 * socials as first-class Header/Footer Builder elements — not HTML shortcodes.
 */

if (!defined('ABSPATH')) {
	exit;
}

const TTC_CHROME_SEED = 'ttc_blocksy_chrome_v3';
const TTC_NAVY = '#003875';
const TTC_NAVY_MID = '#006699';

add_filter('blocksy:header:items-paths', static function ($paths) {
	$paths[] = TTC_THEME_DIR . '/inc/panel-builder/header';
	return $paths;
});

add_filter('blocksy:footer:items-paths', static function ($paths) {
	$paths[] = TTC_THEME_DIR . '/inc/panel-builder/footer';
	return $paths;
});

add_filter('blocksy:footer:selective_refresh', static function ($partials) {
	foreach (['ttc-cats', 'ttc-help', 'ttc-brand', 'ttc-socials'] as $id) {
		$partials[] = [
			'id' => 'footer_placements_item:' . $id,
			'fallback_refresh' => false,
			'container_inclusive' => true,
			'selector' => '#main-container > footer.ct-footer',
			'loader_selector' => '[data-id="' . $id . '"]',
			'settings' => ['footer_placements'],
			'render_callback' => static function () {
				echo Blocksy_Manager::instance()->footer_builder->render();
			},
		];
	}
	return $partials;
});

add_action('wp_loaded', 'ttc_seed_blocksy_chrome', 30);
add_action('wp_loaded', 'ttc_normalize_footer_placements', 31);
add_action('customize_save_after', 'ttc_normalize_footer_placements', 20);

/**
 * One-time Customizer + menu seed. Does not overwrite a header/footer the
 * client already saved in Customizer.
 */
function ttc_seed_blocksy_chrome($force = false) {
	if (!$force && get_option(TTC_CHROME_SEED)) {
		return;
	}

	if (!function_exists('blocksy_manager')) {
		return;
	}

	ttc_ensure_site_logo();
	$menus = ttc_ensure_chrome_menus();

	set_theme_mod('maxSiteWidth', 1280);
	set_theme_mod('colorPalette', ttc_color_palette());
	set_theme_mod('fontColor', [
		'default' => ['color' => '#141e27'],
	]);
	set_theme_mod('linkColor', [
		'default' => ['color' => TTC_NAVY_MID],
		'hover' => ['color' => TTC_NAVY],
	]);

	$header = get_theme_mod('header_placements');
	if ($force || empty($header['sections'])) {
		set_theme_mod(
			'header_placements',
			ttc_header_placements(blocksy_manager()->header_builder, $menus['primary'])
		);
	}

	$footer = get_theme_mod('footer_placements');
	if ($force || empty($footer['sections'])) {
		set_theme_mod('footer_placements', ttc_footer_placements());
	}

	$locations = get_theme_mod('nav_menu_locations', []);
	$locations['menu_1'] = $menus['primary'];
	$locations['menu_mobile'] = $menus['primary'];
	$locations['footer'] = $menus['cats'];
	$locations['ttc_primary'] = $menus['primary'];
	$locations['ttc_footer_cats'] = $menus['cats'];
	$locations['ttc_footer_support'] = $menus['support'];
	set_theme_mod('nav_menu_locations', $locations);

	ttc_clear_footer_widgets();
	ttc_flush_blocksy_css();
	update_option(TTC_CHROME_SEED, time(), false);
}

function ttc_color_palette() {
	return [
		'color1' => ['color' => TTC_NAVY_MID],
		'color2' => ['color' => TTC_NAVY],
		'color3' => ['color' => '#141e27'],
		'color4' => ['color' => '#001d3d'],
		'color5' => ['color' => '#e5e6ea'],
		'color6' => ['color' => '#f8f7fa'],
		'color7' => ['color' => '#fafbfc'],
		'color8' => ['color' => '#ffffff'],
	];
}

function ttc_navy_background() {
	return blocksy_background_default_value([
		'backgroundColor' => [
			'default' => ['color' => TTC_NAVY],
		],
	]);
}

function ttc_header_placements($builder, $primary_menu_id = 0) {
	$section = $builder->get_structure_for([
		'id' => 'type-1',
		'mode' => 'placements',
		'items' => [
			'desktop' => [
				'middle-row' => [
					'start' => ['logo'],
					'middle' => ['ttc-search'],
					'end' => ['ttc-hotline'],
				],
				'bottom-row' => [
					'start' => ['menu'],
				],
			],
			'mobile' => [
				'middle-row' => [
					'start' => ['logo'],
					'end' => ['trigger'],
				],
				'offcanvas' => [
					'start' => ['mobile-menu', 'ttc-hotline'],
				],
			],
		],
	]);

	$menu_value = $primary_menu_id ? (string) $primary_menu_id : 'blocksy_location';
	$row_height = static function ($desktop, $mobile) {
		return [
			'desktop' => $desktop,
			'tablet' => $desktop,
			'mobile' => $mobile,
		];
	};

	$section['items'] = [
		[
			'id' => 'logo',
			'values' => [
				'logoMaxHeight' => $row_height(40, 38),
				'has_site_title' => 'no',
				'has_tagline' => 'no',
			],
		],
		[
			'id' => 'ttc-search',
			'values' => [
				'search_placeholder' => 'Tìm kiếm sản phẩm...',
			],
		],
		[
			'id' => 'ttc-hotline',
			'values' => [
				'hotline_label' => 'Hotline',
			],
		],
		[
			'id' => 'menu',
			'values' => [
				'menu' => $menu_value,
				'header_menu_type' => 'type-1',
				'headerMenuItemsSpacing' => 30,
				'headerMenuFont' => blocksy_typography_default_values([
					'size' => '13px',
					'variation' => 'n6',
					'line-height' => '1.3',
					'letter-spacing' => '0em',
					'text-transform' => 'none',
				]),
				'menuFontColor' => [
					'default' => ['color' => '#141e27'],
					'hover' => ['color' => TTC_NAVY_MID],
					'active' => ['color' => TTC_NAVY_MID],
				],
			],
		],
		[
			'id' => 'mobile-menu',
			'values' => [
				'menu' => $menu_value,
			],
		],
		[
			'id' => 'middle-row',
			'values' => [
				'headerRowHeight' => $row_height(80, 68),
			],
		],
		[
			'id' => 'bottom-row',
			'values' => [
				'headerRowHeight' => $row_height(52, 52),
			],
		],
		[
			'id' => 'trigger',
			'values' => [],
		],
	];

	return [
		'current_section' => 'type-1',
		'sections' => [$section],
	];
}

function ttc_footer_placements(array $menus = []) {
	$builder = blocksy_manager()->footer_builder;
	$default = $builder->get_default_value();
	$section = $builder->get_structure_for([
		'id' => 'type-1',
		'rows' => [
			'middle-row' => [
				'columns' => [
					['ttc-brand'],
					['ttc-cats'],
					['ttc-help'],
					['ttc-socials'],
				],
			],
			'bottom-row' => [
				'columns' => [
					['copyright'],
				],
			],
		],
	]);

	$section['settings'] = [
		'footerBackground' => ttc_navy_background(),
	];

	$section['items'] = ttc_key_builder_items([
		[
			'id' => 'middle-row',
			'values' => [
				'items_per_row' => '4',
				'4_columns_layout' => [
					'desktop' => '2fr 1fr 1fr 1fr',
					'tablet' => 'repeat(2, 1fr)',
					'mobile' => 'initial',
				],
				'footerItemsGap' => [
					'desktop' => 48,
					'tablet' => 40,
					'mobile' => 32,
				],
				'rowTopBottomSpacing' => [
					'desktop' => '56px',
					'tablet' => '40px',
					'mobile' => '32px',
				],
				'footer_row_vertical_alignment' => 'flex-start',
			],
		],
		[
			'id' => 'bottom-row',
			'values' => [
				'rowTopBottomSpacing' => [
					'desktop' => '24px',
					'tablet' => '20px',
					'mobile' => '16px',
				],
			],
		],
		[
			'id' => 'ttc-brand',
			'values' => [],
		],
		[
			'id' => 'ttc-cats',
			'values' => ttc_footer_link_values(
				ttc_footer_category_links(),
				'Danh mục sản phẩm',
				'yes',
				8
			),
		],
		[
			'id' => 'ttc-help',
			'values' => ttc_footer_link_values(
				ttc_footer_support_links(),
				'Hỗ trợ khách hàng',
				'no',
				6
			),
		],
		[
			'id' => 'ttc-socials',
			'values' => [],
		],
		[
			'id' => 'copyright',
			'values' => [
				'copyright_text' => '© Bản quyền thuộc về TTC Technology Việt Nam.',
				'footerCopyrightAlignment' => 'center',
				'copyrightFont' => blocksy_typography_default_values([
					'size' => '12px',
					'variation' => 'n4',
					'line-height' => '1.4',
				]),
				'copyrightColor' => [
					'default' => ['color' => 'rgba(255,255,255,0.8)'],
					'link_initial' => ['color' => 'rgba(255,255,255,0.8)'],
					'link_hover' => ['color' => '#ffffff'],
				],
			],
		],
	]);

	$default['current_section'] = 'type-1';
	$default['sections'][0] = $section;
	return $default;
}

function ttc_ensure_site_logo() {
	if ((int) get_theme_mod('custom_logo')) {
		return;
	}

	$path = TTC_THEME_DIR . '/assets/img/logo.png';
	if (!is_readable($path)) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_bits('ttc-logo.png', null, file_get_contents($path));
	if (!empty($upload['error'])) {
		return;
	}

	$attachment_id = wp_insert_attachment([
		'post_mime_type' => 'image/png',
		'post_title' => 'TTCTECH',
		'post_status' => 'inherit',
	], $upload['file']);

	if (is_wp_error($attachment_id) || !$attachment_id) {
		return;
	}

	wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));
	set_theme_mod('custom_logo', $attachment_id);
}

function ttc_footer_category_links() {
	$shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
	$cat_defs = [
		'dung-cu-cat' => 'Dụng cụ cắt',
		'dung-cu-do' => 'Dụng cụ đo',
		'ga-kep-dao' => 'Gá kẹp dao',
		'ga-kep-phoi' => 'Gá kẹp phôi',
		'dau-cat-got' => 'Dầu cắt gọt',
		'dung-cu-phu-tro' => 'Dụng cụ phụ trợ',
		'may-cong-cu' => 'Máy công cụ',
		'dich-vu' => 'Dịch vụ',
	];
	$links = [];
	foreach ($cat_defs as $slug => $label) {
		$term = get_term_by('slug', $slug, 'product_cat');
		$url = ($term && !is_wp_error($term)) ? get_term_link($term) : $shop;
		$links[] = [$label, is_wp_error($url) ? $shop : $url];
	}
	return $links;
}

/**
 * Build the "Sản phẩm" dropdown by attaching the product categories as child
 * menu items. Content comes from ttc_footer_category_links() — the single
 * source of truth shared with the footer — so the nav never drifts from the
 * shop taxonomy. WordPress then flags the parent `menu-item-has-children` and
 * Blocksy renders / reveals the dropdown natively.
 */
add_filter('wp_get_nav_menu_items', 'ttc_attach_product_dropdown', 20, 3);

function ttc_attach_product_dropdown($items, $menu, $args) {
	if (is_admin() || !is_array($items) || $items === []) {
		return $items;
	}

	$parent = null;
	foreach ($items as $item) {
		if (in_array('ttc-nav__product', (array) ($item->classes ?? []), true)) {
			$parent = $item;
			break;
		}
	}
	if (!$parent) {
		return $items;
	}

	// Never inject twice (real children win if the client ever adds them).
	foreach ($items as $item) {
		if ((int) $item->menu_item_parent === (int) $parent->ID) {
			return $items;
		}
	}

	$order = 1000;
	foreach (ttc_footer_category_links() as $i => [$label, $url]) {
		$items[] = ttc_make_custom_menu_item([
			'ID' => (int) $parent->ID * 100 + $i + 1,
			'title' => $label,
			'url' => $url,
			'menu_item_parent' => (int) $parent->ID,
			'menu_order' => $order++,
			'classes' => ['ttc-nav__product-cat'],
		]);
	}

	return $items;
}

/**
 * A fully-formed custom nav menu item that renders without touching the DB.
 * wp_setup_nav_menu_item() reads post meta, so it can't build a virtual item;
 * we fill every property the walker reads by hand instead.
 */
function ttc_make_custom_menu_item(array $props) {
	$item = (object) array_merge([
		'ID' => 0,
		'db_id' => 0,
		'menu_item_parent' => 0,
		'object_id' => 0,
		'object' => 'custom',
		'type' => 'custom',
		'type_label' => __('Custom Link', 'blocksy-child'),
		'title' => '',
		'url' => '',
		'target' => '',
		'attr_title' => '',
		'description' => '',
		'classes' => [],
		'xfn' => '',
		'current' => false,
		'current_item_ancestor' => false,
		'current_item_parent' => false,
		'menu_order' => 0,
		'post_parent' => 0,
		'post_type' => 'nav_menu_item',
		'post_status' => 'publish',
		'status' => 'publish',
	], $props);

	$item->db_id = $item->db_id ?: $item->ID;
	$item->object_id = $item->object_id ?: $item->ID;

	return $item;
}

function ttc_footer_support_links() {
	return [
		['Chính sách bảo hành', home_url('/chinh-sach-bao-hanh/')],
		['Chính sách vận chuyển', home_url('/chinh-sach-van-chuyen/')],
		['Yêu cầu kỹ thuật', home_url('/ho-tro-ky-thuat/')],
	];
}

function ttc_footer_link_values(array $pairs, $heading, $columns, $slots) {
	$values = [
		'menu_heading' => $heading,
		'menu_columns' => $columns,
	];
	for ($i = 1; $i <= $slots; $i++) {
		$values['link_' . $i . '_label'] = $pairs[$i - 1][0] ?? '';
		$values['link_' . $i . '_url'] = $pairs[$i - 1][1] ?? '';
	}
	return $values;
}

function ttc_footer_link_field_options($heading, $columns, $slots) {
	$options = [
		'menu_heading' => [
			'label' => __('Tiêu đề cột', 'blocksy-child'),
			'type' => 'text',
			'value' => $heading,
			'design' => 'block',
			'setting' => ['transport' => 'postMessage'],
		],
		'menu_columns' => [
			'label' => __('Hai cột', 'blocksy-child'),
			'type' => 'ct-switch',
			'value' => $columns,
			'setting' => ['transport' => 'postMessage'],
		],
	];

	for ($i = 1; $i <= $slots; $i++) {
		$options['link_' . $i . '_label'] = [
			'label' => sprintf(__('Liên kết %d — nhãn', 'blocksy-child'), $i),
			'type' => 'text',
			'value' => '',
			'design' => 'block',
			'divider' => $i === 1 ? 'top' : '',
			'setting' => ['transport' => 'postMessage'],
		];
		$options['link_' . $i . '_url'] = [
			'label' => sprintf(__('Liên kết %d — URL', 'blocksy-child'), $i),
			'type' => 'text',
			'value' => '',
			'design' => 'block',
			'setting' => ['transport' => 'postMessage'],
		];
	}

	return $options;
}

function ttc_render_footer_link_column($atts, $attr, array $args) {
	$heading = blocksy_default_akg('menu_heading', $atts, $args['heading']);
	$columns = blocksy_default_akg('menu_columns', $atts, $args['columns']) === 'yes';
	$slots = (int) $args['slots'];
	$list_class = 'ttc-footer__links' . ($columns ? ' ttc-footer__links--cols' : '');
	?>
<div class="ttc-footer-col" <?php echo blocksy_attr_to_html($attr); ?>>
	<?php if ($heading) : ?>
		<h3 class="ttc-footer__heading"><?php echo esc_html($heading); ?></h3>
	<?php endif; ?>
	<ul class="<?php echo esc_attr($list_class); ?>">
		<?php for ($i = 1; $i <= $slots; $i++) :
			$label = trim((string) blocksy_default_akg('link_' . $i . '_label', $atts, ''));
			$url = trim((string) blocksy_default_akg('link_' . $i . '_url', $atts, ''));
			if ($label === '' || $url === '') {
				continue;
			}
			?>
			<li>
				<a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
			</li>
		<?php endfor; ?>
	</ul>
</div>
	<?php
}

/**
 * Blocksy's footer Customizer reducer stores items as an object keyed by id.
 * A PHP list ([0], [1], [2]...) is sent to JS as a JSON array. The first
 * keystroke then replaces the whole items object with only the field being
 * edited — which is why typing in Customizer made both columns disappear.
 */
function ttc_key_builder_items($items) {
	if (!is_array($items)) {
		return [];
	}

	$keyed = [];
	foreach ($items as $key => $item) {
		if (!is_array($item)) {
			continue;
		}

		$id = $item['id'] ?? '';
		if ($id === '' && is_string($key) && !ctype_digit($key)) {
			$id = $key;
		}
		if ($id === '' || $id === 'ttc-menu' || str_starts_with((string) $id, 'ttc-menu')) {
			continue;
		}

		$item['id'] = $id;
		if (!isset($item['values']) || !is_array($item['values'])) {
			$item['values'] = [];
		}
		$keyed[$id] = $item;
	}

	return $keyed;
}

function ttc_builder_items_are_list($items) {
	if (!is_array($items) || $items === []) {
		return false;
	}

	foreach (array_keys($items) as $key) {
		if (is_int($key) || (is_string($key) && ctype_digit($key))) {
			return true;
		}
	}

	return false;
}

/**
 * True when a Blocksy background still has the factory light/empty fill.
 * Does not treat a client-chosen color as unset.
 */
function ttc_footer_background_is_unset($background) {
	if (!is_array($background) || $background === []) {
		return true;
	}

	if (isset($background['desktop'])) {
		return ttc_footer_background_is_unset($background['desktop']);
	}

	$color = $background['backgroundColor']['default']['color'] ?? '';
	if (!is_string($color) || $color === '') {
		return true;
	}

	$color = strtolower(preg_replace('/\s+/', '', $color));
	$blank = [
		'ct_css_skip_rule',
		'transparent',
		'inherit',
		'initial',
		'#fff',
		'#ffffff',
		'#f8f9fb',
		'var(--theme-palette-color-6)',
		'var(--theme-palette-color-7)',
		'var(--theme-palette-color-8)',
	];

	return in_array($color, $blank, true);
}

function ttc_normalize_footer_placements() {
	if (!function_exists('blocksy_manager')) {
		return;
	}

	$footer = get_theme_mod('footer_placements');
	if (!is_array($footer) || empty($footer['sections'][0])) {
		return;
	}

	$fresh_items = null;
	$required = ['middle-row', 'bottom-row', 'ttc-brand', 'ttc-cats', 'ttc-help', 'ttc-socials', 'copyright'];
	$changed = false;

	foreach ($footer['sections'] as &$section) {
		if (!isset($section['settings']) || !is_array($section['settings'])) {
			$section['settings'] = [];
		}

		if (ttc_footer_background_is_unset($section['settings']['footerBackground'] ?? null)) {
			$section['settings']['footerBackground'] = ttc_navy_background();
			$changed = true;
		}

		$original = $section['items'] ?? [];
		$items = ttc_key_builder_items($original);
		$items_changed = ttc_builder_items_are_list($original);

		foreach ($required as $id) {
			if (isset($items[$id])) {
				continue;
			}
			if ($fresh_items === null) {
				$fresh_items = ttc_key_builder_items(ttc_footer_placements()['sections'][0]['items']);
			}
			if (isset($fresh_items[$id])) {
				$items[$id] = $fresh_items[$id];
				$items_changed = true;
			}
		}

		if ($items_changed) {
			$section['items'] = $items;
			$changed = true;
		}

		if (empty($section['rows']) || !is_array($section['rows'])) {
			continue;
		}

		foreach ($section['rows'] as &$row) {
			if (($row['id'] ?? '') !== 'middle-row') {
				continue;
			}

			$placed = [];
			foreach ($row['columns'] ?? [] as $column) {
				foreach ((array) $column as $item_id) {
					$placed[] = $item_id;
				}
			}

			if (!in_array('ttc-cats', $placed, true) || !in_array('ttc-help', $placed, true)) {
				$row['columns'] = [
					['ttc-brand'],
					['ttc-cats'],
					['ttc-help'],
					['ttc-socials'],
				];
				$changed = true;
			}
		}
		unset($row);
	}
	unset($section);

	if (!$changed) {
		return;
	}

	set_theme_mod('footer_placements', $footer);
	ttc_flush_blocksy_css();
}

function ttc_ensure_chrome_menus() {
	$shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
	$contact = function_exists('ttc_contact_url') ? ttc_contact_url() : home_url('/lien-he/');

	$primary = [
		['Trang chủ', home_url('/')],
		['Giới thiệu', home_url('/gioi-thieu/')],
		['Sản phẩm', $shop, 'ttc-nav__product'],
		['Cẩm nang kỹ thuật', home_url('/kinh-nghiem-ky-thuat/')],
		['Tuyển dụng', home_url('/tuyen-dung/')],
		['FAQ', home_url('/faqs/')],
		['Liên hệ', $contact],
	];

	return [
		'primary' => ttc_get_or_create_menu('TTCTECH Primary', $primary),
		'cats' => ttc_get_or_create_menu('TTCTECH Footer Categories', ttc_footer_category_links()),
		'support' => ttc_get_or_create_menu('TTCTECH Footer Support', ttc_footer_support_links()),
	];
}

function ttc_get_or_create_menu($name, array $items) {
	$existing = wp_get_nav_menu_object($name);
	if ($existing) {
		return (int) $existing->term_id;
	}

	$menu_id = wp_create_nav_menu($name);
	if (is_wp_error($menu_id)) {
		return 0;
	}

	$position = 1;
	foreach ($items as $item) {
		[$title, $url] = $item;
		$args = [
			'menu-item-title' => $title,
			'menu-item-url' => $url,
			'menu-item-status' => 'publish',
			'menu-item-type' => 'custom',
			'menu-item-position' => $position++,
		];
		if (!empty($item[2])) {
			$args['menu-item-classes'] = $item[2];
		}
		wp_update_nav_menu_item($menu_id, 0, $args);
	}

	return (int) $menu_id;
}

function ttc_clear_footer_widgets() {
	$sidebars = get_option('sidebars_widgets', []);
	if (!is_array($sidebars)) {
		return;
	}

	foreach (['ct-footer-sidebar-1', 'ct-footer-sidebar-2', 'ct-footer-sidebar-3', 'ct-footer-sidebar-4'] as $id) {
		$sidebars[$id] = [];
	}

	update_option('sidebars_widgets', $sidebars);
}

function ttc_flush_blocksy_css() {
	if (function_exists('blocksy_manager') && isset(blocksy_manager()->db)) {
		blocksy_manager()->db->wipe_cache();
	}
	delete_transient('blocksy_dynamic_styles_descriptor');
	do_action('blocksy:dynamic-css:refresh-caches');
}
