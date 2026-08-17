<?php
global $product;

$shop_url = home_url('/shop/');
$brand = ttc_brand_image_for_product($product->get_id());
$brand_slug = $brand['slug'] ?? '';
$primary_category = wp_get_post_terms($product->get_id(), 'product_cat');
$primary_category = !is_wp_error($primary_category) && $primary_category
	? $primary_category[0]->name
	: 'Dụng cụ cắt';
?>
<div class="ttc-product-toolbar">
	<nav class="ttc-breadcrumb" aria-label="Đường dẫn">
		<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
		<span>/</span>
		<a href="<?php echo esc_url($shop_url); ?>">Sản phẩm</a>
		<span>/</span>
		<span><?php echo esc_html($primary_category === 'Chưa phân loại' ? 'Dụng cụ cắt' : $primary_category); ?></span>
		<span>/</span>
		<strong><?php echo esc_html($product->get_name()); ?></strong>
	</nav>

	<form class="ttc-filters" method="get" action="<?php echo esc_url($shop_url); ?>">
		<label class="ttc-filters__search">
			<span class="screen-reader-text">Tìm sản phẩm</span>
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
			<input type="search" name="s" placeholder="Gõ tên dụng cụ, sản phẩm,..." />
		</label>

		<label class="ttc-filters__select">
			<span class="screen-reader-text">Hãng</span>
			<svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 6h3m4 0h9M7 3v6M4 12h9m4 0h3m-3-3v6M4 18h3m4 0h9M7 15v6"/></svg>
			<select name="ttc_brand" onchange="this.form.submit()">
				<option value="">Hãng</option>
				<?php foreach (ttc_brand_catalog() as $item) : ?>
					<option value="<?php echo esc_attr($item['slug']); ?>" <?php selected($brand_slug, $item['slug']); ?>>
						<?php echo esc_html($item['label'] ?? $item['name']); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>

		<label class="ttc-filters__select">
			<span class="screen-reader-text">Loại công cụ</span>
			<svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 6h3m4 0h9M7 3v6M4 12h9m4 0h3m-3-3v6M4 18h3m4 0h9M7 15v6"/></svg>
			<select name="ttc_type" onchange="this.form.submit()">
				<option value="">Loại công cụ</option>
				<?php
				$terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
				if (!is_wp_error($terms)) :
					foreach ($terms as $term) :
						if ($term->slug === 'uncategorized') {
							continue;
						}
						?>
						<option value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></option>
						<?php
					endforeach;
				endif;
				?>
			</select>
		</label>
	</form>
</div>
