<?php
/**
 * Default pages (incl. homepage) — Gutenberg content, full width.
 *
 * Blocksy parent page.php does get_template_part('single'), and our single.php
 * is the knowledge article layout. Own page.php so pages are not squeezed
 * into the article + sidebar column.
 *
 * Use <div> not <main> — Blocksy header already opens <main id="main">.
 */

get_header();
?>
<div id="ttc-content" class="ttc-page<?php echo is_front_page() ? ' ttc-page--home' : ''; ?>">
	<?php
	while (have_posts()) :
		the_post();
		the_content();
	endwhile;
	?>
</div>
<?php
get_footer();
