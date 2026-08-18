<?php
get_header();

$paged = max(1, (int) get_query_var('paged'));
$highlights = get_posts([
	'numberposts' => ttc_knowledge_highlight_count(),
	'post_status' => 'publish',
]);
$featured = $highlights[1] ?? ($highlights[0] ?? null);
$secondary = array_values(array_filter($highlights, static fn ($post) => !$featured || $post->ID !== $featured->ID));
$highlight_ids = wp_list_pluck($highlights, 'ID');
$articles = new WP_Query([
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => ttc_knowledge_posts_per_page(),
	'paged' => $paged,
	'post__not_in' => $highlight_ids,
]);
?>
<div class="ttc-knowledge">
	<div class="ttc-container">
		<nav class="ttc-knowledge__breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url(home_url('/')); ?>">Trang chủ</a>
			<span>/</span>
			<strong>Kiến thức kỹ thuật</strong>
		</nav>

		<div class="ttc-knowledge__layout">
			<div class="ttc-knowledge__main">
				<?php if ($featured && $paged === 1) : ?>
					<section class="ttc-knowledge-lead" aria-label="Bài viết nổi bật">
						<a class="ttc-knowledge-lead__feature" href="<?php echo esc_url(get_permalink($featured)); ?>">
							<img src="<?php echo esc_url(ttc_article_image($featured->ID, 'large')); ?>" alt="" width="820" height="440" fetchpriority="high" />
							<span class="ttc-knowledge-lead__badge">Nổi bật</span>
							<h1><?php echo esc_html(get_the_title($featured)); ?></h1>
						</a>
						<div class="ttc-knowledge-lead__secondary">
							<?php foreach ($secondary as $post) : ?>
								<a href="<?php echo esc_url(get_permalink($post)); ?>">
									<img src="<?php echo esc_url(ttc_article_image($post->ID, 'medium')); ?>" alt="" width="190" height="120" loading="lazy" />
									<h2><?php echo esc_html(get_the_title($post)); ?></h2>
								</a>
							<?php endforeach; ?>
						</div>
					</section>
				<?php endif; ?>

				<?php if ($articles->have_posts()) : ?>
					<div class="ttc-knowledge-list">
						<?php while ($articles->have_posts()) : $articles->the_post(); ?>
							<article class="ttc-knowledge-card">
								<a class="ttc-knowledge-card__media" href="<?php the_permalink(); ?>">
									<img src="<?php echo esc_url(ttc_article_image(get_the_ID(), 'medium_large')); ?>" alt="" width="360" height="220" loading="lazy" />
								</a>
								<div class="ttc-knowledge-card__body">
									<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p><?php echo esc_html(ttc_article_excerpt(get_the_ID(), 25)); ?></p>
								</div>
							</article>
						<?php endwhile; ?>
					</div>

					<nav class="ttc-knowledge-pagination" aria-label="Phân trang">
						<?php
						echo wp_kses_post(paginate_links([
							'total' => $articles->max_num_pages,
							'current' => $paged,
							'prev_text' => '‹',
							'next_text' => '›',
						]));
						?>
					</nav>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>

			<?php get_template_part('template-parts/knowledge', 'sidebar'); ?>
		</div>
	</div>

	<?php get_template_part('template-parts/shop', 'support'); ?>
</div>
<?php get_footer(); ?>
