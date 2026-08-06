<?php
$posts = ttc_home_posts(4);
if (!$posts) {
	return;
}
$feature = array_shift($posts);
$archive = get_permalink(get_option('page_for_posts')) ?: home_url('/kinh-nghiem-ky-thuat/');
?>
<section class="ttc-home-section ttc-home-knowledge">
	<div class="ttc-container">
		<div class="ttc-home-section__head ttc-home-section__head--left">
			<h2>Chia sẻ kinh nghiệm kỹ thuật</h2>
		</div>
		<div class="ttc-home-knowledge__layout">
			<a class="ttc-home-knowledge__feature" href="<?php echo esc_url(get_permalink($feature)); ?>">
				<?php
				$thumb = get_the_post_thumbnail_url($feature, 'large') ?: ttc_home_img('home/projects/p2.jpg');
				?>
				<img src="<?php echo esc_url($thumb); ?>" alt="" loading="eager" decoding="async" />
				<span class="ttc-home-knowledge__feature-copy">
					<strong><?php echo esc_html(get_the_title($feature)); ?></strong>
					<em>Xem chi tiết</em>
				</span>
			</a>
			<?php if ($posts) : ?>
				<ul class="ttc-home-knowledge__list">
					<?php foreach ($posts as $post) :
						$thumb = get_the_post_thumbnail_url($post, 'medium') ?: ttc_home_img('home/projects/p1.jpg');
						?>
						<li>
							<a href="<?php echo esc_url(get_permalink($post)); ?>">
								<img src="<?php echo esc_url($thumb); ?>" alt="" loading="eager" decoding="async" width="140" height="96" />
								<span><?php echo esc_html(get_the_title($post)); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<div class="ttc-home-section__cta">
			<a class="ttc-btn ttc-btn--primary" href="<?php echo esc_url($archive); ?>">Xem tất cả</a>
		</div>
	</div>
</section>
