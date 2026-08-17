<?php

$tagline = blocksy_default_akg('brand_tagline', $atts, 'Where innovation meets!');
$hn = blocksy_default_akg('brand_address_hn', $atts, 'HN: Tầng 4, nhà số 5, ngõ 72, Miếu Đầm, phường Từ Liêm, Hà Nội.');
$hcm = blocksy_default_akg('brand_address_hcm', $atts, 'TP.HCM: Tầng 3, 29 đường số 5, KDC Vạn Phúc, phường Hiệp Bình, TP.HCM');
$email = blocksy_default_akg('brand_email', $atts, 'ttctech@ttctech.vn');
$website = blocksy_default_akg('brand_website', $atts, 'https://ttctech.vn');
$website_label = preg_replace('#^https?://#', '', untrailingslashit($website));
$logo_id = (int) get_theme_mod('custom_logo');
$src = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : TTC_THEME_URI . '/assets/img/logo.png';

$icon = static function ($name, $size) {
	return sprintf(
		'<img class="ttc-footer__contact-icon" src="%s" alt="" width="%d" height="%d" />',
		esc_url(TTC_THEME_URI . '/assets/img/icons/' . $name . '.svg'),
		$size,
		$size
	);
};
?>
<div class="ttc-footer__brand" <?php echo blocksy_attr_to_html($attr); ?>>
	<a class="ttc-logo ttc-logo--footer" href="<?php echo esc_url(home_url('/')); ?>">
		<img src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" height="40" />
	</a>
	<?php if ($tagline) : ?>
		<p class="ttc-footer__tagline"><?php echo esc_html($tagline); ?></p>
	<?php endif; ?>
	<ul class="ttc-footer__contact">
		<?php if ($hn) : ?>
			<li><?php echo $icon('map-pin', 14); ?><span><?php echo esc_html($hn); ?></span></li>
		<?php endif; ?>
		<?php if ($hcm) : ?>
			<li><?php echo $icon('map-pin', 14); ?><span><?php echo esc_html($hcm); ?></span></li>
		<?php endif; ?>
		<?php if ($email) : ?>
			<li><?php echo $icon('mail', 20); ?><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li>
		<?php endif; ?>
		<?php if ($website) : ?>
			<li><?php echo $icon('globe', 20); ?><a href="<?php echo esc_url($website); ?>" target="_blank" rel="noopener"><?php echo esc_html($website_label); ?></a></li>
		<?php endif; ?>
		<li><?php echo $icon('phone', 20); ?><a href="<?php echo esc_attr(ttc_phone_href()); ?>"><?php echo esc_html(ttc_phone()); ?></a></li>
	</ul>
</div>
