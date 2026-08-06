<?php
$shop = wc_get_page_permalink('shop');
$bg = ttc_home_img('home/hero.jpg');
?>
<section class="ttc-home-hero" style="--ttc-home-hero: url('<?php echo esc_url($bg); ?>')">
	<div class="ttc-home-hero__inner">
		<h1>Giải Pháp Công Cụ Cắt Gọt &amp; Thiết Bị Gia Công Cơ Khí Chính Hãng</h1>
		<p>Đối tác tin cậy cung cấp dụng cụ cắt, thiết bị đo và giải pháp gia công giúp nhà máy tối ưu năng suất và chi phí.</p>
		<a class="ttc-btn ttc-btn--primary" href="<?php echo esc_url(ttc_contact_url()); ?>">Liên hệ tư vấn</a>
	</div>
</section>
