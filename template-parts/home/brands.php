<?php
$brands = ttc_brand_catalog();
?>
<section class="ttc-home-section ttc-home-brands" id="thuong-hieu">
	<div class="ttc-container">
		<div class="ttc-home-section__head">
			<h2>Thương hiệu nổi bật</h2>
		</div>
		<div class="ttc-home-brands__grid">
			<?php foreach ($brands as $brand) :
				$url = add_query_arg('ttc_brand', $brand['slug'], wc_get_page_permalink('shop'));
				$label = $brand['label'] ?? $brand['name'];
				?>
				<a class="ttc-home-brands__tile" href="<?php echo esc_url($url); ?>">
					<img src="<?php echo esc_url($brand['img']); ?>" alt="<?php echo esc_attr($label); ?>" loading="lazy" />
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
