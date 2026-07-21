<?php
$img = TTC_THEME_URI . '/assets/img/featured-machining.jpg';
$products = wc_get_products([
	'limit' => 4,
	'status' => 'publish',
	'featured' => true,
	'orderby' => 'rand',
]);
?>
<section class="ttc-featured">
	<div class="ttc-featured__head">
		<h2 class="ttc-section-title">Sản phẩm tiêu biểu</h2>
		<a class="ttc-link-all" href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">Xem tất cả</a>
	</div>

	<figure class="ttc-featured__banner">
		<img src="<?php echo esc_url($img); ?>" alt="Gia công cơ khí" loading="lazy" width="1400" height="420" />
	</figure>

	<?php if ($products) : ?>
		<ul class="products columns-4">
			<?php
			global $post, $product;
			foreach ($products as $product) {
				$post = get_post($product->get_id());
				setup_postdata($post);
				wc_setup_product_data($post);
				wc_get_template_part('content', 'product');
			}
			wp_reset_postdata();
			?>
		</ul>
	<?php endif; ?>
</section>
