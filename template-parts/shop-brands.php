<?php
$shop = home_url('/shop/');
$brands = ttc_brand_catalog();
$brands[] = $brands[0]; // reference strip closes with Sandvik.
?>
<section class="ttc-brands">
	<h2 class="ttc-section-title">Tìm theo thương hiệu</h2>
	<div class="ttc-brands__grid">
		<?php foreach ($brands as $brand) :
			$slug = $brand['slug'];
			$term = get_term_by('name', $brand['name'], 'product_tag');
			if ($term && !is_wp_error($term)) {
				$slug = $term->slug;
			}
			?>
			<a class="ttc-brand-tile" href="<?php echo esc_url(add_query_arg('ttc_brand', $slug, $shop)); ?>" title="<?php echo esc_attr($brand['name']); ?>">
				<img src="<?php echo esc_url($brand['img']); ?>" alt="<?php echo esc_attr($brand['name']); ?>" loading="lazy" width="120" height="40" />
			</a>
		<?php endforeach; ?>
	</div>
</section>
