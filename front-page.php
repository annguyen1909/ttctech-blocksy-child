<?php
/**
 * Marketing homepage.
 */

get_header();
?>
<main class="ttc-home">
	<?php
	get_template_part('template-parts/home/hero');
	get_template_part('template-parts/home/categories');
	get_template_part('template-parts/home/brands');
	get_template_part('template-parts/home/about');
	get_template_part('template-parts/home/featured-products');
	get_template_part('template-parts/home/projects');
	get_template_part('template-parts/home/knowledge');
	get_template_part('template-parts/shop-support');
	?>
</main>
<?php
get_footer();
