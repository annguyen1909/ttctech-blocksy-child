<?php
global $product, $post;

$product_id = $product->get_id();
$brand = ttc_brand_image_for_product($product_id);
$brand_label = $brand['label'] ?? strtoupper($brand['name'] ?? ttc_product_brand_name($product_id) ?: 'TTCTECH');
$detail = ttc_product_detail_data($product);
$gallery = array_slice($detail['gallery'], 0, 5);
$features = $detail['features'];
$applications = $detail['applications'];
?>
<section class="ttc-product-overview">
	<div class="ttc-product-gallery">
		<div class="ttc-product-gallery__stage">
			<?php if (count($gallery) > 1) : ?><button class="ttc-product-gallery__arrow ttc-product-gallery__arrow--prev" type="button" aria-label="Ảnh trước">‹</button><?php endif; ?>
			<img class="ttc-product-gallery__main" src="<?php echo esc_url($gallery[0]); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" />
			<?php if (count($gallery) > 1) : ?><button class="ttc-product-gallery__arrow ttc-product-gallery__arrow--next" type="button" aria-label="Ảnh tiếp theo">›</button><?php endif; ?>
		</div>
		<div class="ttc-product-gallery__thumbs" style="--ttc-thumb-count: <?php echo esc_attr((string) count($gallery)); ?>" aria-label="Ảnh sản phẩm">
			<?php foreach ($gallery as $index => $image) : ?>
				<button class="ttc-product-thumb<?php echo $index === 0 ? ' is-current' : ''; ?>" type="button" data-image="<?php echo esc_url($image); ?>" aria-label="Xem ảnh <?php echo esc_attr((string) ($index + 1)); ?>" aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>">
					<img src="<?php echo esc_url($image); ?>" alt="" />
				</button>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="ttc-product-summary">
		<h1><?php echo esc_html($product->get_name()); ?></h1>
		<a class="ttc-product-summary__price" href="<?php echo esc_url(ttc_contact_url()); ?>">Giá: Liên hệ</a>
		<p class="ttc-product-summary__meta">
			<span>Thương hiệu: <strong><?php echo esc_html($brand_label); ?></strong></span>
			<i aria-hidden="true"></i>
			<span>Tình trạng: <strong><?php echo $product->is_in_stock() ? 'Còn hàng' : 'Liên hệ'; ?></strong></span>
		</p>

		<?php if ($features) : ?><div class="ttc-product-fact">
			<h2>
				<span class="ttc-product-fact__icon ttc-product-fact__icon--star" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
				</span>
				Tính năng chính
			</h2>
			<ul>
				<?php foreach (array_slice($features, 0, 4) as $feature) : ?><li><?php echo esc_html($feature); ?></li><?php endforeach; ?>
			</ul>
		</div><?php endif; ?>

		<?php if ($applications) : ?><div class="ttc-product-fact">
			<h2>
				<span class="ttc-product-fact__icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94Z"/></svg>
				</span>
				Ứng dụng
			</h2>
			<ul>
				<?php foreach (array_slice($applications, 0, 4) as $application) : ?><li><?php echo esc_html($application); ?></li><?php endforeach; ?>
			</ul>
		</div><?php endif; ?>
	</div>
</section>

<section class="ttc-product-description" id="product-description">
	<div class="ttc-product-tabs" role="tablist" aria-label="Thông tin sản phẩm">
		<button type="button" role="tab" id="ttc-tab-description-<?php echo esc_attr((string) $product_id); ?>" aria-selected="true" tabindex="0" aria-controls="ttc-description-<?php echo esc_attr((string) $product_id); ?>" data-product-tab="description">Mô tả sản phẩm</button>
		<button type="button" role="tab" id="ttc-tab-specifications-<?php echo esc_attr((string) $product_id); ?>" aria-selected="false" tabindex="-1" aria-controls="ttc-specifications-<?php echo esc_attr((string) $product_id); ?>" data-product-tab="specifications">Thông số kỹ thuật</button>
		<button type="button" role="tab" id="ttc-tab-downloads-<?php echo esc_attr((string) $product_id); ?>" aria-selected="false" tabindex="-1" aria-controls="ttc-downloads-<?php echo esc_attr((string) $product_id); ?>" data-product-tab="downloads">Tải file PDF</button>
	</div>

	<div class="ttc-product-description__body ttc-product-tab-panel" id="ttc-description-<?php echo esc_attr((string) $product_id); ?>" data-product-panel="description" role="tabpanel" tabindex="0" aria-labelledby="ttc-tab-description-<?php echo esc_attr((string) $product_id); ?>">
		<h2><?php echo esc_html($detail['heading']); ?></h2>
		<?php if ($detail['intro']) : ?><p><?php echo esc_html($detail['intro']); ?></p><?php endif; ?>
		<div class="ttc-product-video">
			<?php if ($detail['video_url']) : ?>
				<iframe src="<?php echo esc_url($detail['video_url']); ?>" title="<?php echo esc_attr($product->get_name()); ?>" loading="lazy" allowfullscreen></iframe>
			<?php else : ?>
				<img src="<?php echo esc_url($detail['detail_image']); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" />
			<?php endif; ?>
		</div>
		<?php if ($detail['caption']) : ?><p class="ttc-product-description__caption"><?php echo esc_html($detail['caption']); ?></p><?php endif; ?>

		<div class="ttc-product-more" id="ttc-product-more" hidden>
			<?php if ($features) : ?>
				<h2>Tính năng và lợi ích</h2>
				<ul><?php foreach (array_slice($features, 0, 8) as $feature) : ?><li><?php echo esc_html($feature); ?></li><?php endforeach; ?></ul>
			<?php endif; ?>
			<img class="ttc-product-more__image" src="<?php echo esc_url($detail['detail_image']); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" />
			<?php if ($applications) : ?>
				<h2>Ứng dụng</h2>
				<ul><?php foreach (array_slice($applications, 0, 8) as $application) : ?><li><?php echo esc_html($application); ?></li><?php endforeach; ?></ul>
			<?php endif; ?>
		</div>

		<button class="ttc-product-more-toggle" type="button" aria-expanded="false" aria-controls="ttc-product-more">
			<span>Tìm hiểu thêm</span><i aria-hidden="true"></i>
		</button>
	</div>

	<div class="ttc-product-description__body ttc-product-tab-panel" id="ttc-specifications-<?php echo esc_attr((string) $product_id); ?>" data-product-panel="specifications" role="tabpanel" tabindex="0" aria-labelledby="ttc-tab-specifications-<?php echo esc_attr((string) $product_id); ?>" hidden>
		<h2>Thông số kỹ thuật</h2>
		<?php if ($detail['specifications']) : ?>
			<div class="ttc-product-specifications">
				<?php foreach ($detail['specifications'] as $group) : ?>
					<section>
						<h3><?php echo esc_html($group['label']); ?></h3>
						<ul><?php foreach ($group['items'] as $item) : ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?></ul>
					</section>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p>Thông số kỹ thuật đang được cập nhật.</p>
		<?php endif; ?>
	</div>

	<div class="ttc-product-description__body ttc-product-tab-panel" id="ttc-downloads-<?php echo esc_attr((string) $product_id); ?>" data-product-panel="downloads" role="tabpanel" tabindex="0" aria-labelledby="ttc-tab-downloads-<?php echo esc_attr((string) $product_id); ?>" hidden>
		<h2>Tài liệu sản phẩm</h2>
		<?php if ($detail['pdfs']) : ?>
			<ul class="ttc-product-downloads">
				<?php foreach ($detail['pdfs'] as $pdf) : ?><li><a href="<?php echo esc_url($pdf['url']); ?>" target="_blank" rel="noopener"><?php echo esc_html($pdf['label']); ?></a></li><?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p>Vui lòng <a href="<?php echo esc_url(ttc_contact_url()); ?>">liên hệ TTCTECH</a> để nhận catalogue và tài liệu kỹ thuật.</p>
		<?php endif; ?>
	</div>
</section>

<section class="ttc-product-related">
	<div class="ttc-product-related__inner">
		<h2 class="ttc-section-title">Sản phẩm liên quan</h2>
		<?php
		$related_ids = wc_get_related_products($product_id, 8);
		if ($related_ids) :
			woocommerce_product_loop_start();
			$original_post = $post;
			foreach ($related_ids as $related_id) :
				$post = get_post($related_id);
				setup_postdata($post);
				wc_get_template_part('content', 'product');
			endforeach;
			$post = $original_post;
			wp_reset_postdata();
			woocommerce_product_loop_end();
		endif;
		?>
	</div>
</section>

<?php get_template_part('template-parts/shop', 'support'); ?>
