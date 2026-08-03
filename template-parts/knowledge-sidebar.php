<?php
$current_id = get_queried_object_id();
$popular = ttc_popular_articles(3, $current_id ? [$current_id] : []);
$catalog_items = ttc_catalog_sidebar_items();
?>
<aside class="ttc-knowledge-sidebar">
	<section class="ttc-knowledge-catalog">
		<h2>Danh mục sản phẩm</h2>
		<ul>
			<?php foreach ($catalog_items as $item) : ?>
				<li>
					<a href="<?php echo esc_url($item['url']); ?>">
						<span><?php echo esc_html($item['label']); ?></span>
						<i aria-hidden="true"></i>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>

	<?php if ($popular) : ?>
		<section class="ttc-knowledge-popular">
			<h2>Xem nhiều</h2>
			<div class="ttc-knowledge-popular__list">
				<?php foreach ($popular as $popular_post) : ?>
					<a href="<?php echo esc_url(get_permalink($popular_post)); ?>">
						<img src="<?php echo esc_url(ttc_article_image($popular_post->ID, 'medium')); ?>" alt="" width="120" height="82" loading="lazy" />
						<strong><?php echo esc_html(get_the_title($popular_post)); ?></strong>
					</a>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>
</aside>
