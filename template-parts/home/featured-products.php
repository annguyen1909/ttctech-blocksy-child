<?php
$products = ttc_home_featured_products(6);
$banner = ttc_home_img('home/banner.jpg');
$shop = wc_get_page_permalink('shop');
?>
<section class="ttc-home-section ttc-home-products">
	<div class="ttc-container">
		<div class="ttc-home-section__head ttc-home-section__head--left">
			<h2>Sản phẩm tiêu biểu</h2>
		</div>
		<figure class="ttc-home-products__banner">
			<img src="<?php echo esc_url($banner); ?>" alt="Gia công cơ khí" loading="eager" decoding="async" width="1280" height="420" />
		</figure>
		<?php if ($products) : ?>
			<ul class="ttc-home-products__grid">
				<?php foreach ($products as $product) :
					$brand = ttc_brand_image_for_product($product->get_id());
					$img = $product->get_image_id()
						? wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_single')
						: wc_placeholder_img_src('woocommerce_single');
					if (!$img && $product->get_image_id()) {
						$img = wp_get_attachment_image_url($product->get_image_id(), 'large');
					}
					?>
					<li class="ttc-home-product">
						<a class="ttc-home-product__media" href="<?php echo esc_url($product->get_permalink()); ?>">
							<img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" loading="eager" decoding="async" />
						</a>
						<?php if ($brand) : ?>
							<span class="ttc-home-product__brand">
								<img src="<?php echo esc_url($brand['img']); ?>" alt="<?php echo esc_attr($brand['name']); ?>" />
							</span>
						<?php else : ?>
							<span class="ttc-home-product__brand ttc-home-product__brand--text">TTCTECH</span>
						<?php endif; ?>
						<h3><a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($product->get_name()); ?></a></h3>
						<a class="ttc-home-product__more" href="<?php echo esc_url($product->get_permalink()); ?>">Chi tiết</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="ttc-home-section__cta">
			<a class="ttc-btn ttc-btn--primary" href="<?php echo esc_url($shop); ?>">Xem tất cả</a>
		</div>
	</div>
</section>
