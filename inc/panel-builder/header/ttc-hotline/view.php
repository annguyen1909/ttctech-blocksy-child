<?php

$label = blocksy_default_akg('hotline_label', $atts, 'Hotline');
?>
<a class="ttc-hotline" href="<?php echo esc_attr(ttc_phone_href()); ?>" <?php echo blocksy_attr_to_html($attr); ?>>
	<span class="ttc-hotline__icon">
		<img src="<?php echo esc_url(TTC_THEME_URI . '/assets/img/icons/phone-header.svg'); ?>" alt="" width="18" height="18" />
	</span>
	<span class="ttc-hotline__text">
		<em class="ttc-hotline__label"><?php echo esc_html($label); ?></em>
		<strong class="ttc-hotline__number"><?php echo esc_html(ttc_phone()); ?></strong>
	</span>
</a>
