<?php
$img = TTC_THEME_URI . '/assets/img/support-team.jpg';
?>
<section class="ttc-support" style="--ttc-support-img: url('<?php echo esc_url($img); ?>')">
	<div class="ttc-container ttc-support__inner">
		<div class="ttc-support__copy">
			<h2>Hỗ trợ giải pháp gia công toàn diện</h2>
			<p>Đội ngũ kỹ sư giàu kinh nghiệm của chúng tôi luôn sẵn sàng hỗ trợ khách hàng tối ưu hóa quy trình sản xuất, nâng cao tuổi thọ dao cụ và giảm thiểu tối đa chi phí vận hành.</p>
			<p class="ttc-support__phone">Business: 0977 020 209</p>
		</div>
		<form class="ttc-support__form" action="<?php echo esc_url(ttc_contact_url()); ?>" method="get">
			<p>Vui lòng điền đầy đủ thông tin để nhận được sự hỗ trợ nhanh nhất từ đội ngũ của chúng tôi.</p>
			<input type="text" name="name" placeholder="Họ và tên *" required />
			<input type="email" name="email" placeholder="Email *" required />
			<input type="tel" name="phone" placeholder="Số điện thoại *" required />
			<input type="text" name="company" placeholder="Tên công ty" />
			<select name="service"><option value="">Dịch vụ bạn quan tâm *</option><option>Tư vấn dụng cụ</option><option>Hỗ trợ kỹ thuật</option><option>Yêu cầu báo giá</option></select>
			<button type="submit">Submit</button>
		</form>
	</div>
</section>
