<?php
$cats = ttc_home_categories();
$shop = wc_get_page_permalink('shop');
?>
<section class="ttc-home-section ttc-home-cats">
	<div class="ttc-container">
		<div class="ttc-home-section__head ttc-home-section__head--row">
			<h2>Danh mục sản phẩm</h2>
			<a class="ttc-home-link" href="<?php echo esc_url($shop); ?>">Xem tất cả</a>
		</div>
		<ul class="ttc-home-cats__grid">
			<?php foreach ($cats as $cat) : ?>
				<li>
					<a href="<?php echo esc_url($cat['url']); ?>">
						<span class="ttc-home-cats__icon">
							<img src="<?php echo esc_url($cat['img']); ?>" alt="" width="96" height="96" loading="eager" decoding="async" />
						</span>
						<span class="ttc-home-cats__label"><?php echo esc_html($cat['label']); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
