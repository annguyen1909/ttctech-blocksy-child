<?php
$brand = ttc_selected_brand();
if (!$brand) {
	return;
}
$selected_type = isset($_GET['ttc_type']) ? sanitize_title(wp_unslash($_GET['ttc_type'])) : '';
$types = [
	['Milling', 'milling'],
	['Exchange drill', 'exchange-drill'],
	['Phần mềm', 'phan-mem'],
];
$hero = TTC_THEME_URI . '/assets/img/brand-hero-sandvik.png';
?>
<section class="ttc-brand-showcase">
	<div class="ttc-brand-showcase__media" style="--ttc-brand-hero: url('<?php echo esc_url($hero); ?>')">
		<span class="ttc-brand-showcase__logo">
			<img src="<?php echo esc_url($brand['img']); ?>" alt="<?php echo esc_attr($brand['name']); ?>" />
		</span>
	</div>
	<form class="ttc-brand-showcase__types" method="get" action="<?php echo esc_url(home_url('/shop/')); ?>">
		<input type="hidden" name="ttc_brand" value="<?php echo esc_attr($brand['slug']); ?>" />
		<strong>Loại sản phẩm:</strong>
		<?php foreach ($types as [$label, $slug]) : ?>
			<label>
				<input type="checkbox" name="ttc_type" value="<?php echo esc_attr($slug); ?>" <?php checked($selected_type, $slug); ?> onchange="this.form.submit()" />
				<span><?php echo esc_html($label); ?></span>
			</label>
		<?php endforeach; ?>
	</form>
</section>
