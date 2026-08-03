<?php
$logo = TTC_THEME_URI . '/assets/img/logo.png';
$cats = ['Dụng cụ cắt', 'Dụng cụ đo', 'Gá kẹp dao', 'Gá kẹp phôi', 'Dầu cắt gọt', 'Dụng cụ phụ trợ', 'Máy công cụ', 'Dịch vụ'];
$support = [
	['Chính sách bảo hành', 'chinh-sach-bao-hanh'],
	['Chính sách vận chuyển', 'chinh-sach-van-chuyen'],
	['Yêu cầu kỹ thuật', 'ho-tro-ky-thuat'],
];
?>
<footer class="ttc-footer">
	<div class="ttc-container ttc-footer__grid">
		<div class="ttc-footer__brand">
			<a class="ttc-logo ttc-logo--footer" href="<?php echo esc_url(home_url('/')); ?>">
				<img src="<?php echo esc_url($logo); ?>" alt="TTCTECH" width="140" height="43" />
			</a>
			<p class="ttc-footer__tagline">Where innovation meets!</p>
			<ul class="ttc-footer__contact">
				<li>HN: Tầng 4, nhà số 5, ngõ 72, Miêu Đàm, phường Từ Liêm, Hà Nội.</li>
				<li>TP.HCM: Tầng 3, 29 đường số 5, KDC Vạn Phúc, phường Hiệp Bình, TP.HCM</li>
				<li><a href="mailto:info@ttctech.vn">info@ttctech.vn</a></li>
				<li><a href="https://ttctech.vn" target="_blank" rel="noopener">www.ttctech.vn</a></li>
				<li><a href="https://www.facebook.com/ttctech.vn" target="_blank" rel="noopener">www.facebook.com/ttctech.vn</a></li>
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
			© Bản quyền thuộc về TTC Technology Việt Nam.
		</div>
	</div>
</footer>
