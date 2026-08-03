<?php
/**
 * Careers page.
 */

get_header();

while (have_posts()) :
	the_post();
	?>
	<div class="ttc-careers">
		<section class="ttc-careers__hero">
			<div class="ttc-container ttc-careers__hero-grid">
				<div class="ttc-careers__hero-copy">
					<p class="ttc-careers__eyebrow">Cơ hội nghề nghiệp</p>
					<h1>Phát triển cùng đội ngũ kỹ thuật TTCTECH</h1>
					<p>Chúng tôi tìm kiếm những đồng nghiệp chủ động, yêu thích công nghệ và muốn tạo ra giá trị thực tế cho ngành sản xuất.</p>
					<div class="ttc-careers__actions">
						<a class="ttc-btn ttc-btn--primary" href="mailto:info@ttctech.vn?subject=Ứng tuyển tại TTCTECH">Gửi hồ sơ ứng tuyển</a>
						<a class="ttc-careers__contact" href="<?php echo esc_url(ttc_contact_url()); ?>">Liên hệ TTCTECH →</a>
					</div>
				</div>
				<div class="ttc-careers__hero-image" role="img" aria-label="Đội ngũ kỹ thuật TTCTECH cùng trao đổi giải pháp"></div>
			</div>
		</section>

		<section class="ttc-container ttc-careers__culture">
			<div class="ttc-careers__section-heading">
				<p class="ttc-careers__eyebrow">Làm việc tại TTCTECH</p>
				<h2>Nơi chuyên môn tạo ra giá trị</h2>
				<p>Mỗi thành viên được khuyến khích hiểu sâu vấn đề, phối hợp thẳng thắn và theo đuổi giải pháp phù hợp nhất cho khách hàng.</p>
			</div>
			<div class="ttc-careers__values">
				<article>
					<span>01</span>
					<h3>Gắn với thực tế</h3>
					<p>Công việc tập trung vào nhu cầu thật trong sản xuất và gia công cơ khí.</p>
				</article>
				<article>
					<span>02</span>
					<h3>Học hỏi liên tục</h3>
					<p>Cùng cập nhật kiến thức sản phẩm, công nghệ và phương pháp làm việc hiệu quả.</p>
				</article>
				<article>
					<span>03</span>
					<h3>Phối hợp rõ ràng</h3>
					<p>Trao đổi trực tiếp, tôn trọng chuyên môn và cùng chịu trách nhiệm về kết quả.</p>
				</article>
			</div>
		</section>

		<section class="ttc-careers__openings">
			<div class="ttc-container ttc-careers__openings-inner">
				<div>
					<p class="ttc-careers__eyebrow">Vị trí đang tuyển</p>
					<h2>Hiện chưa có vị trí tuyển dụng được công bố</h2>
					<p>Bạn vẫn có thể gửi hồ sơ chủ động. TTCTECH sẽ liên hệ khi có cơ hội phù hợp với kinh nghiệm của bạn.</p>
				</div>
				<a class="ttc-btn ttc-btn--primary" href="mailto:info@ttctech.vn?subject=Hồ sơ ứng tuyển chủ động">Gửi hồ sơ chủ động</a>
			</div>
		</section>
	</div>
	<?php
endwhile;

get_footer();
