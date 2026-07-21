<?php
$shop_url = wc_get_page_permalink('shop');
$brand = isset($_GET['ttc_brand']) ? sanitize_title(wp_unslash($_GET['ttc_brand'])) : '';
$type = isset($_GET['ttc_type']) ? sanitize_title(wp_unslash($_GET['ttc_type'])) : '';
$q = isset($_GET['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';

$brand_terms = [];
foreach (ttc_brand_catalog() as $b) {
	$term = get_term_by('slug', $b['slug'], 'product_tag');
	if ($term && !is_wp_error($term)) {
		$brand_terms[] = $term;
	} else {
		// fuzzy match by name
		$all = get_terms(['taxonomy' => 'product_tag', 'hide_empty' => false, 'number' => 100]);
		if (!is_wp_error($all)) {
			foreach ($all as $t) {
				if (strcasecmp($t->name, $b['name']) === 0) {
					$brand_terms[] = $t;
					break;
				}
			}
		}
	}
}

$cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
$total = (int) wc_get_loop_prop('total');
$showing = (int) $GLOBALS['wp_query']->post_count;
?>
<div class="ttc-shop-hero">
	<nav class="ttc-breadcrumb" aria-label="Đường dẫn">
		<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
		<span>/</span>
		<span>Tất cả sản phẩm</span>
	</nav>

	<div class="ttc-shop-hero__row">
		<h1 class="ttc-shop-title">Tất cả sản phẩm</h1>
		<div class="ttc-shop-hero__aside">
			<?php woocommerce_catalog_ordering(); ?>
			<p class="ttc-results-count">
				Hiển thị <?php echo esc_html((string) $showing); ?> trên tổng số <?php echo esc_html((string) $total); ?> kết quả
			</p>
		</div>
	</div>

	<form class="ttc-filters" method="get" action="<?php echo esc_url($shop_url); ?>">
		<label class="ttc-filters__search">
			<span class="screen-reader-text">Tìm sản phẩm</span>
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
			<input type="search" name="s" value="<?php echo esc_attr($q); ?>" placeholder="Gõ tên dụng cụ, sản phẩm..." />
		</label>

		<label class="ttc-filters__select">
			<span class="screen-reader-text">Hãng</span>
			<select name="ttc_brand" onchange="this.form.submit()">
				<option value="">Hãng</option>
				<?php foreach ($brand_terms as $term) : ?>
					<option value="<?php echo esc_attr($term->slug); ?>" <?php selected($brand, $term->slug); ?>>
						<?php echo esc_html($term->name); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>

		<label class="ttc-filters__select">
			<span class="screen-reader-text">Loại dụng cụ</span>
			<select name="ttc_type" onchange="this.form.submit()">
				<option value="">Loại dụng cụ</option>
				<?php if (!is_wp_error($cats)) : foreach ($cats as $term) :
					if ($term->slug === 'uncategorized') continue; ?>
					<option value="<?php echo esc_attr($term->slug); ?>" <?php selected($type, $term->slug); ?>>
						<?php echo esc_html($term->name); ?>
					</option>
				<?php endforeach; endif; ?>
			</select>
		</label>
	</form>
</div>
