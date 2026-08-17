<?php

$placeholder = blocksy_default_akg('search_placeholder', $atts, 'Tìm kiếm sản phẩm...');
$shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/');
$attr['data-width'] = 'stretch';
?>
<div class="ttc-header-search" <?php echo blocksy_attr_to_html($attr); ?>>
	<form class="ttc-search" role="search" method="get" action="<?php echo esc_url($shop); ?>">
		<button type="submit" aria-label="<?php esc_attr_e('Tìm kiếm', 'blocksy-child'); ?>">
			<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
		</button>
		<input type="search" name="s" placeholder="<?php echo esc_attr($placeholder); ?>" value="<?php echo esc_attr(get_search_query()); ?>" />
		<input type="hidden" name="post_type" value="product" />
	</form>
</div>
