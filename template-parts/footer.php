<?php
$logo = TTC_THEME_URI . '/assets/img/logo.png';
$info = [
	['Giới thiệu', home_url('/gioi-thieu/')],
	['Cẩm nang kỹ thuật', home_url('/kinh-nghiem-ky-thuat/')],
	['Dự án', home_url('/#du-an')],
	['Tuyển dụng', home_url('/tuyen-dung/')],
	['Liên hệ', ttc_contact_url()],
	['FAQs', home_url('/faqs/')],
];
$quick = [
	['Sản phẩm', wc_get_page_permalink('shop')],
	['Chính sách bảo hành', home_url('/chinh-sach-bao-hanh/')],
	['Chính sách vận chuyển', home_url('/chinh-sach-van-chuyen/')],
	['Yêu cầu kỹ thuật', home_url('/ho-tro-ky-thuat/')],
	['Yêu cầu báo giá', home_url('/yeu-cau-bao-gia/')],
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
			</ul>
		</div>

		<div>
			<h3 class="ttc-footer__heading">Thông tin</h3>
			<ul class="ttc-footer__links">
				<?php foreach ($info as [$label, $url]) : ?>
					<li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h3 class="ttc-footer__heading">Liên kết nhanh</h3>
			<ul class="ttc-footer__links">
				<?php foreach ($quick as [$label, $url]) : ?>
					<li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="ttc-footer__social">
			<h3 class="ttc-footer__heading">Kết nối</h3>
			<ul class="ttc-footer__social-list">
				<li>
					<a href="https://www.facebook.com/ttctech.vn" target="_blank" rel="noopener" aria-label="Facebook">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H8v3h3v7h3v-7h3l1-3h-4V9c0-.6.4-1 1-1z"/></svg>
					</a>
				</li>
				<li>
					<a href="#" target="_blank" rel="noopener" aria-label="YouTube">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 12s0-3.5-.45-5.18a2.62 2.62 0 0 0-1.84-1.85C18.94 4.5 12 4.5 12 4.5s-6.94 0-8.71.47A2.62 2.62 0 0 0 1.45 6.82 27.5 27.5 0 0 0 1 12a27.5 27.5 0 0 0 .45 5.18 2.62 2.62 0 0 0 1.84 1.85C5.06 19.5 12 19.5 12 19.5s6.94 0 8.71-.47a2.62 2.62 0 0 0 1.84-1.85C23 15.5 23 12 23 12zM9.75 15.27V8.73L15.5 12z"/></svg>
					</a>
				</li>
				<li>
					<a href="#" target="_blank" rel="noopener" aria-label="LinkedIn">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.94 5A1.94 1.94 0 1 1 3 5a1.94 1.94 0 0 1 3.94 0zM3.28 8.48h3.4V21h-3.4zM9.4 8.48h3.26v1.71h.05c.45-.86 1.56-1.77 3.21-1.77 3.43 0 4.06 2.26 4.06 5.2V21h-3.4v-4.62c0-1.1-.02-2.52-1.53-2.52s-1.77 1.2-1.77 2.44V21H9.4z"/></svg>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="ttc-footer__bottom">
		<div class="ttc-container">
			© Bản quyền thuộc về TTC Technology Việt Nam.
		</div>
	</div>
</footer>
