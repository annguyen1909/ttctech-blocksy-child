<?php
/**
 * FAQs page — content is managed in the WordPress page body.
 */

get_header();

while (have_posts()) :
	the_post();
	?>
	<section class="ttc-faq-page" style="--ttc-faq-bg: url('<?php echo esc_url(TTC_THEME_URI . '/assets/img/faq-engineering-team.png'); ?>')">
		<div class="ttc-faq-page__overlay">
			<div class="ttc-container ttc-faq-page__content">
				<?php the_content(); ?>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
