<?php
$logo = TTC_THEME_URI . '/assets/img/logo.png';
$cats = ['Dụng cụ cắt', 'Gá kẹp dao', 'Dụng cụ đo', 'Dầu cắt gọt', 'Gá kẹp phôi', 'Dịch vụ'];
$support = [
	['Chính sách vận chuyển', 'chinh-sach-van-chuyen'],
	['Chính sách thanh toán', 'chinh-sach-thanh-toan'],
	['Chính sách bảo hành', 'chinh-sach-bao-hanh'],
	['Hỗ trợ kỹ thuật', 'ho-tro-ky-thuat'],
];
?>
<footer class="ttc-footer">
	<div class="ttc-container ttc-footer__grid">
		<div class="ttc-footer__brand">
			<a class="ttc-logo ttc-logo--footer" href="<?php echo esc_url(home_url('/')); ?>">
				<img src="<?php echo esc_url($logo); ?>" alt="TTCTECH" width="140" height="43" />
			</a>
			<p class="ttc-footer__tagline">Nơi công nghệ gặp đổi mới</p>
			<ul class="ttc-footer__contact">
				<li>Địa chỉ: Hà Nội, Việt Nam</li>
				<li>Điện thoại: <a href="tel:02462931272">024 6293 1272</a></li>
				<li>Email: <a href="mailto:info@ttctech.vn">info@ttctech.vn</a></li>
				<li>Website: <a href="https://ttctech.vn" target="_blank" rel="noopener">ttctech.vn</a></li>
			</ul>
		</div>

		<div>
			<h3 class="ttc-footer__heading">Danh mục sản phẩm</h3>
			<ul class="ttc-footer__links">
				<?php foreach ($cats as $cat) : ?>
					<li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"><?php echo esc_html($cat); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h3 class="ttc-footer__heading">Hỗ trợ khách hàng</h3>
			<ul class="ttc-footer__links">
				<?php foreach ($support as [$label, $slug]) : ?>
					<li><a href="<?php echo esc_url(home_url('/' . $slug . '/')); ?>"><?php echo esc_html($label); ?></a></li>
				<?php endforeach; ?>
				<li><a href="<?php echo esc_url(ttc_contact_url()); ?>">Liên hệ</a></li>
			</ul>
		</div>
	</div>
	<div class="ttc-footer__bottom">
		<div class="ttc-container">
			© <?php echo esc_html(gmdate('Y')); ?> TTCTECH. Bảo lưu mọi quyền.
		</div>
	</div>
</footer>
