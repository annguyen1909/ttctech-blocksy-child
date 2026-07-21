<?php
$posts = get_posts([
	'numberposts' => 4,
	'post_status' => 'publish',
]);
if (!$posts) {
	return;
}
$featured = array_shift($posts);
$blog_url = get_permalink((int) get_option('page_for_posts')) ?: home_url('/');
?>
<section class="ttc-blog">
	<div class="ttc-featured__head">
		<h2 class="ttc-section-title">Chia sẻ kinh nghiệm kỹ thuật</h2>
		<a class="ttc-link-all" href="<?php echo esc_url($blog_url); ?>">Xem tất cả</a>
	</div>

	<div class="ttc-blog__layout">
		<article class="ttc-blog__feature">
			<a href="<?php echo esc_url(get_permalink($featured)); ?>">
				<div class="ttc-blog__feature-media">
					<?php echo get_the_post_thumbnail($featured, 'large', ['loading' => 'lazy']); ?>
					<div class="ttc-blog__feature-overlay">
						<span class="ttc-blog__tag">Kinh nghiệm công nghệ</span>
						<h3><?php echo esc_html(get_the_title($featured)); ?></h3>
					</div>
				</div>
			</a>
		</article>

		<div class="ttc-blog__list">
			<?php foreach ($posts as $post) : ?>
				<article class="ttc-blog__item">
					<a href="<?php echo esc_url(get_permalink($post)); ?>">
						<?php echo get_the_post_thumbnail($post, 'thumbnail', ['loading' => 'lazy']); ?>
						<h3><?php echo esc_html(get_the_title($post)); ?></h3>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
