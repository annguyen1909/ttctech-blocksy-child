<?php
get_header();

while (have_posts()) :
	the_post();
	$post_id = get_the_ID();
	$categories = wp_get_post_categories($post_id);
	$related = get_posts([
		'numberposts' => 3,
		'post_status' => 'publish',
		'post__not_in' => [$post_id],
		'category__in' => $categories,
	]);
	if (!$related) {
		$related = ttc_popular_articles(3, [$post_id]);
	}
	$share_url = rawurlencode(get_permalink());
	$share_title = rawurlencode(ttc_article_title($post_id));
	$weekdays = [1 => 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
	$article_date = $weekdays[(int) get_the_date('N')] . ', ' . get_the_date('j/n/Y, H:i') . ' (GMT+7)';
	?>
	<article class="ttc-knowledge ttc-knowledge--detail">
		<div class="ttc-container">
			<nav class="ttc-knowledge__breadcrumb" aria-label="Breadcrumb">
				<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
				<span>/</span>
				<a href="<?php echo esc_url(ttc_knowledge_url()); ?>">Kiến thức kỹ thuật</a>
			</nav>

			<div class="ttc-knowledge__layout">
				<div class="ttc-article">
					<header class="ttc-article__header">
						<h1><?php echo esc_html(ttc_article_title($post_id)); ?></h1>
						<div class="ttc-article__meta">
							<time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html($article_date); ?></time>
							<span class="ttc-article__share-label">Chia sẻ</span>
							<a href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $share_url); ?>" target="_blank" rel="noopener" aria-label="Chia sẻ Facebook">f</a>
							<a href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url); ?>" target="_blank" rel="noopener" aria-label="Chia sẻ LinkedIn">in</a>
							<a href="<?php echo esc_url('mailto:?subject=' . $share_title . '&body=' . $share_url); ?>" aria-label="Chia sẻ qua email">↗</a>
						</div>
					</header>

					<div class="ttc-article__content">
						<?php echo apply_filters('the_content', ttc_article_body($post_id)); ?>
					</div>

					<footer class="ttc-article__author">
						<span>Tác giả</span>
						<strong><?php echo esc_html(get_the_author()); ?></strong>
						<div class="ttc-article__share">
							<span>Chia sẻ</span>
							<a href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $share_url); ?>" target="_blank" rel="noopener" aria-label="Chia sẻ Facebook">f</a>
							<a href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url); ?>" target="_blank" rel="noopener" aria-label="Chia sẻ LinkedIn">in</a>
							<a href="<?php echo esc_url('mailto:?subject=' . $share_title . '&body=' . $share_url); ?>" aria-label="Chia sẻ qua email">↗</a>
						</div>
					</footer>
				</div>

				<?php get_template_part('template-parts/knowledge', 'sidebar'); ?>
			</div>
		</div>

		<?php if ($related) : ?>
			<section class="ttc-knowledge-related">
				<div class="ttc-container">
					<h2>Bài viết liên quan</h2>
					<div class="ttc-knowledge-related__grid">
						<?php foreach ($related as $related_post) : ?>
							<article>
								<a href="<?php echo esc_url(get_permalink($related_post)); ?>">
									<img src="<?php echo esc_url(ttc_article_image($related_post->ID, 'medium_large')); ?>" alt="" width="400" height="230" loading="lazy" />
									<h3><?php echo esc_html(get_the_title($related_post)); ?></h3>
									<p><?php echo esc_html(ttc_article_excerpt($related_post->ID, 20)); ?></p>
								</a>
							</article>
						<?php endforeach; ?>
					</div>
					<a class="ttc-knowledge-related__all" href="<?php echo esc_url(ttc_knowledge_url()); ?>">Xem tất cả</a>
				</div>
			</section>
		<?php endif; ?>

		<?php get_template_part('template-parts/shop', 'support'); ?>
	</article>
<?php endwhile; ?>
<?php get_footer(); ?>
