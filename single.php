<?php
/**
 * Single posts — technical knowledge article layout.
 * Pages use page.php. Guard here because Blocksy page.php may call get_template_part('single').
 */

/* Dự án (CPT ttc_project) — dedicated detail layout: breadcrumb + title +
 * cover + KPI + content + support band. Reuses .ttc-article / .ttc-home-project
 * styles so it stays consistent with the rest of the site. */
if (is_singular('ttc_project')) {
	get_header();
	while (have_posts()) :
		the_post();
		$pid = get_the_ID();
		$cover = get_the_post_thumbnail_url($pid, 'large');
		$stat = get_post_meta($pid, '_ttc_stat', true);
		$stat_label = get_post_meta($pid, '_ttc_stat_label', true);
		$days = get_post_meta($pid, '_ttc_days', true);
		$days_label = get_post_meta($pid, '_ttc_days_label', true);
		?>
		<article class="ttc-knowledge ttc-project-detail">
			<div class="ttc-container">
				<div class="ttc-project-detail__body">
					<nav class="ttc-knowledge__breadcrumb" aria-label="Breadcrumb">
						<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
						<span>/</span>
						<a href="<?php echo esc_url(home_url('/#du-an')); ?>">Dự án tiêu biểu</a>
					</nav>
					<header class="ttc-article__header">
						<h1><?php echo esc_html(get_the_title()); ?></h1>
					</header>
					<?php if ($cover) : ?>
						<figure class="ttc-project-detail__cover">
							<img src="<?php echo esc_url($cover); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
						</figure>
					<?php endif; ?>
					<?php if ($stat || $days) : ?>
						<div class="ttc-home-project__metrics ttc-project-detail__metrics">
							<?php if ($stat) : ?>
								<div class="ttc-home-project__metric"><strong><?php echo esc_html($stat); ?></strong><span><?php echo esc_html($stat_label ?: 'Kết quả'); ?></span></div>
							<?php endif; ?>
							<?php if ($days) : ?>
								<div class="ttc-home-project__metric ttc-home-project__metric--muted"><strong><?php echo esc_html($days); ?></strong><span><?php echo esc_html($days_label ?: 'Thời gian triển khai'); ?></span></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="ttc-article__content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
			<?php get_template_part('template-parts/shop', 'support'); ?>
		</article>
		<?php
	endwhile;
	get_footer();
	return;
}

if (!is_singular('post')) {
	get_header();
	?>
	<div class="ttc-page<?php echo is_front_page() ? ' ttc-page--home' : ''; ?>">
		<?php
		while (have_posts()) :
			the_post();
			the_content();
		endwhile;
		?>
	</div>
	<?php
	get_footer();
	return;
}

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
	$article = ttc_prepare_article_content($post_id);
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

					<?php get_template_part('template-parts/article', 'toc', ['items' => $article['items']]); ?>

					<div class="ttc-article__content">
						<?php echo $article['html']; ?>
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
