<?php
/**
 * TTCTECH single-product layout.
 *
 * @var WC_Product $product
 */

defined('ABSPATH') || exit;

global $product;

if (!$product || !is_a($product, WC_Product::class)) {
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('ttc-product', $product); ?>>
	<div class="ttc-product-shell">
		<?php get_template_part('template-parts/product', 'toolbar'); ?>
		<?php get_template_part('template-parts/product', 'detail'); ?>
	</div>
</div>
