<?php

$heading = blocksy_default_akg('socials_heading', $atts, 'Mạng xã hội');
$facebook = blocksy_default_akg('socials_facebook', $atts, 'https://www.facebook.com/ttctech.vn/');
$zalo = blocksy_default_akg('socials_zalo', $atts, 'https://zalo.me/0968310354');
$whatsapp = blocksy_default_akg('socials_whatsapp', $atts, 'https://wa.me/0968310354');
?>
<div class="ttc-footer__social" <?php echo blocksy_attr_to_html($attr); ?>>
	<?php if ($heading) : ?>
		<h3 class="ttc-footer__heading"><?php echo esc_html($heading); ?></h3>
	<?php endif; ?>
	<ul class="ttc-footer__social-list">
		<?php if ($facebook) : ?>
			<li>
				<a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener" aria-label="Facebook">
					<img src="<?php echo esc_url(TTC_THEME_URI . '/assets/img/icons/facebook.svg'); ?>" alt="Facebook" width="28" height="28" />
				</a>
			</li>
		<?php endif; ?>
		<?php if ($zalo) : ?>
			<li>
				<a href="<?php echo esc_url($zalo); ?>" target="_blank" rel="noopener" aria-label="Zalo">
					<img src="<?php echo esc_url(TTC_THEME_URI . '/assets/img/icons/zalo.svg'); ?>" alt="Zalo" width="28" height="28" />
				</a>
			</li>
		<?php endif; ?>
		<?php if ($whatsapp) : ?>
			<li>
				<a href="<?php echo esc_url($whatsapp); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
					<img src="<?php echo esc_url(TTC_THEME_URI . '/assets/img/icons/whatsapp.svg'); ?>" alt="WhatsApp" width="28" height="28" />
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>
