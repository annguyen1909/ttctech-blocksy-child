<?php
/**
 * Seed homepage (page_on_front) with Gutenberg blocks.
 * Static sections = HTML blocks (same markup/CSS). Products + posts = shortcode / Query Loop.
 *
 * Usage: wp eval-file wp-content/themes/blocksy-child/bin/seed-homepage.php
 */

if (!defined('ABSPATH')) {
	exit(1);
}

$page_id = (int) get_option('page_on_front');
if (!$page_id) {
	WP_CLI::error('page_on_front is not set.');
}

$uri = get_stylesheet_directory_uri();
$shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$contact = function_exists('ttc_contact_url') ? ttc_contact_url() : home_url('/lien-he/');
$about_url = home_url('/gioi-thieu/');
$posts_url = get_permalink((int) get_option('page_for_posts')) ?: home_url('/kinh-nghiem-ky-thuat/');
$hero = esc_url("$uri/assets/img/home/hero.jpg");
$about_img = esc_url("$uri/assets/img/home/about-front.jpg");
$banner = esc_url("$uri/assets/img/home/banner.jpg");
$support = esc_url("$uri/assets/img/support-team.jpg");
$cat_base = "$uri/assets/img/home/cat";
$proj_base = "$uri/assets/img/home/projects";
$brand_base = "$uri/assets/img/brands";

$cats = [
	['Dụng cụ cắt', 'cat-1.png'],
	['Dụng cụ đo', 'cat-2.png'],
	['Gá kẹp dao', 'cat-3.png'],
	['Gá kẹp phôi', 'cat-4.png'],
	['Dầu cắt gọt', 'cat-5.png'],
	['Dụng cụ phụ trợ', 'cat-6.png'],
	['Máy công cụ', 'cat-7.png'],
	['Dịch vụ', 'cat-8.png'],
];

$brands = function_exists('ttc_brand_catalog') ? ttc_brand_catalog() : [];

$projects = [
	['Gia công khuôn mẫu chính xác', 'Cung cấp dao phay và dụng cụ đo cho dây chuyền gia công khuôn mẫu yêu cầu độ chính xác cao.', 'Sai số ± 0.005 mm', 'Độ chính xác', '45 ngày', 'Thời gian triển khai', 'p1.jpg'],
	['Sản xuất linh kiện hàng không', 'Đồng bộ dụng cụ cắt và quy trình kiểm soát chất lượng cho linh kiện đạt tiêu chuẩn khắt khe.', '100% đạt chuẩn', 'Tỷ lệ đạt', '60 ngày', 'Thời gian triển khai', 'p2.jpg'],
	['Dây chuyền CNC tự động', 'Tư vấn dao cụ và thông số cắt tối ưu năng suất cho dây chuyền CNC vận hành liên tục.', '+30% năng suất', 'Hiệu suất', '90 ngày', 'Thời gian triển khai', 'p3.jpg'],
	['Gia công chi tiết y tế', 'Lựa chọn dụng cụ và grade phù hợp cho chi tiết y tế yêu cầu độ bóng bề mặt cao.', 'Ra ≤ 0.4 μm', 'Độ bóng bề mặt', '30 ngày', 'Thời gian triển khai', 'p4.jpg'],
];

$shop_e = esc_url($shop);
$contact_e = esc_url($contact);
$about_e = esc_url($about_url);
$posts_e = esc_url($posts_url);

ob_start();
?>
<!-- wp:group {"className":"ttc-home","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-home">

<!-- wp:html -->
<section class="ttc-home-hero" style="--ttc-home-hero: url('<?php echo $hero; ?>')">
	<div class="ttc-home-hero__inner">
		<h1>Giải Pháp Công Cụ Cắt Gọt &amp; Thiết Bị Gia Công Cơ Khí Chính Hãng</h1>
		<p>Đối tác tin cậy cung cấp dụng cụ cắt, thiết bị đo và giải pháp gia công giúp nhà máy tối ưu năng suất và chi phí.</p>
		<a class="ttc-btn ttc-btn--primary" href="<?php echo $contact_e; ?>">Liên hệ tư vấn</a>
	</div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="ttc-home-section ttc-home-cats">
	<div class="ttc-container">
		<div class="ttc-home-section__head ttc-home-section__head--row">
			<h2>Danh mục sản phẩm</h2>
			<a class="ttc-home-link" href="<?php echo $shop_e; ?>">Xem tất cả</a>
		</div>
		<ul class="ttc-home-cats__grid">
			<?php foreach ($cats as [$label, $file]) :
				$img = esc_url("$cat_base/$file");
				?>
				<li>
					<a href="<?php echo $shop_e; ?>">
						<span class="ttc-home-cats__icon">
							<img src="<?php echo $img; ?>" alt="" width="96" height="96" loading="eager" decoding="async" />
						</span>
						<span class="ttc-home-cats__label"><?php echo esc_html($label); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="ttc-home-section ttc-home-brands" id="thuong-hieu">
	<div class="ttc-container">
		<div class="ttc-home-section__head">
			<h2>Thương hiệu nổi bật</h2>
		</div>
		<div class="ttc-home-brands__grid">
			<?php foreach ($brands as $brand) :
				$url = esc_url(add_query_arg('ttc_brand', $brand['slug'], $shop));
				$label = $brand['label'] ?? $brand['name'];
				?>
				<a class="ttc-home-brands__tile" href="<?php echo $url; ?>">
					<img src="<?php echo esc_url($brand['img']); ?>" alt="<?php echo esc_attr($label); ?>" loading="lazy" />
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="ttc-home-section ttc-home-about">
	<div class="ttc-container">
		<div class="ttc-home-section__head">
			<h2>Về chúng tôi</h2>
			<p>TTCTECH cung cấp dụng cụ cắt gọt, thiết bị đo lường và giải pháp gia công cơ khí chính hãng, đồng hành cùng doanh nghiệp tối ưu năng suất và chi phí vận hành.</p>
		</div>
		<div class="ttc-home-about__grid">
			<div class="ttc-home-about__media">
				<img class="ttc-home-about__img" src="<?php echo $about_img; ?>" alt="Đội ngũ kỹ thuật TTCTECH" loading="lazy" decoding="async" width="560" height="440" />
			</div>
			<div class="ttc-home-about__copy">
				<h3 class="ttc-home-about__subtitle">Sứ mệnh của chúng tôi</h3>
				<p class="ttc-home-about__body">Mang đến sản phẩm chính hãng cùng giải pháp kỹ thuật tối ưu, giúp khách hàng nâng cao hiệu quả sản xuất và năng lực cạnh tranh.</p>
				<div class="ttc-home-about__values">
					<p class="ttc-home-about__values-title">Giá trị cốt lõi</p>
					<ul>
						<li>
							<span class="ttc-home-about__values-icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></span>
							<span class="ttc-home-about__values-text"><strong>Chính hãng &amp; chất lượng</strong><em>Phân phối dụng cụ cắt và đo lường chính hãng từ các thương hiệu hàng đầu.</em></span>
						</li>
						<li>
							<span class="ttc-home-about__values-icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></span>
							<span class="ttc-home-about__values-text"><strong>Đội ngũ kỹ thuật</strong><em>Kỹ sư giàu kinh nghiệm hỗ trợ ứng dụng và tối ưu quy trình tại xưởng.</em></span>
						</li>
						<li>
							<span class="ttc-home-about__values-icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg></span>
							<span class="ttc-home-about__values-text"><strong>Đồng hành cùng khách hàng</strong><em>Tư vấn và giao hàng trên toàn quốc, gắn bó lâu dài cùng doanh nghiệp.</em></span>
						</li>
					</ul>
				</div>
				<div class="ttc-home-about__stats">
					<div><strong>20+</strong><span>Năm kinh nghiệm</span></div>
					<div><strong>45+</strong><span>Thương hiệu</span></div>
					<div><strong>58+</strong><span>Chuyên gia kỹ thuật</span></div>
				</div>
				<a class="ttc-btn ttc-btn--primary" href="<?php echo $about_e; ?>">Tìm hiểu thêm</a>
			</div>
		</div>
	</div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="ttc-home-section ttc-home-products">
	<div class="ttc-container">
		<div class="ttc-home-section__head ttc-home-section__head--left">
			<h2>Sản phẩm tiêu biểu</h2>
		</div>
		<figure class="ttc-home-products__banner">
			<img src="<?php echo $banner; ?>" alt="Gia công cơ khí" loading="eager" decoding="async" width="1280" height="420" />
		</figure>
	</div>
</section>
<!-- /wp:html -->

<!-- wp:group {"className":"ttc-home-products ttc-home-products--woo","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-products ttc-home-products--woo">
<!-- wp:shortcode -->
[products limit="6" columns="3" orderby="date" order="DESC"]
<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:html -->
<section class="ttc-home-section ttc-home-products ttc-home-products--cta-only">
	<div class="ttc-container">
		<div class="ttc-home-section__cta">
			<a class="ttc-btn ttc-btn--primary" href="<?php echo $shop_e; ?>">Xem tất cả</a>
		</div>
	</div>
</section>
<!-- /wp:html -->

<!-- wp:html -->
<section class="ttc-home-section ttc-home-projects" id="du-an">
	<div class="ttc-container">
		<div class="ttc-home-section__head">
			<p class="ttc-home-eyebrow">Giải pháp gia công của TTCTECH</p>
			<h2>Dự án tiêu biểu</h2>
			<p>Một số hạng mục TTCTECH đã đồng hành cùng khách hàng trong gia công và trang bị dụng cụ.</p>
		</div>
		<ul class="ttc-home-projects__grid">
			<?php foreach ($projects as [$title, $excerpt, $stat, $stat_label, $days, $days_label, $file]) :
				$img = esc_url("$proj_base/$file");
				?>
				<li class="ttc-home-project">
					<a class="ttc-home-project__media" href="<?php echo $contact_e; ?>">
						<img src="<?php echo $img; ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" decoding="async" />
					</a>
					<div class="ttc-home-project__body">
						<h3><?php echo esc_html($title); ?></h3>
						<p><?php echo esc_html($excerpt); ?></p>
						<div class="ttc-home-project__metrics">
							<div class="ttc-home-project__metric">
								<strong><?php echo esc_html($stat); ?></strong>
								<span><?php echo esc_html($stat_label); ?></span>
							</div>
							<div class="ttc-home-project__metric ttc-home-project__metric--muted">
								<strong><?php echo esc_html($days); ?></strong>
								<span><?php echo esc_html($days_label); ?></span>
							</div>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="ttc-home-section__cta">
			<a class="ttc-btn ttc-btn--primary" href="<?php echo esc_url(home_url('/#du-an')); ?>">Xem tất cả dự án</a>
		</div>
	</div>
</section>
<!-- /wp:html -->

<!-- wp:group {"className":"ttc-home-section ttc-home-knowledge","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-knowledge">
<!-- wp:heading {"className":"ttc-home-knowledge__heading"} -->
<h2 class="wp-block-heading ttc-home-knowledge__heading">Chia sẻ kinh nghiệm kỹ thuật</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":31,"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"ttc-home-knowledge__query"} -->
<div class="wp-block-query ttc-home-knowledge__query">
<!-- wp:post-template {"className":"ttc-home-knowledge__grid","layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"className":"ttc-home-knowledge__card","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group ttc-home-knowledge__card">
<!-- wp:post-featured-image {"isLink":true,"width":"140px","height":"96px"} /-->
<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"left"}} -->
<div class="wp-block-group">
<!-- wp:post-title {"isLink":true,"fontSize":"medium"} /-->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo $posts_e; ?>">Xem tất cả</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:html -->
<section class="ttc-support" style="--ttc-support-img: url('<?php echo $support; ?>')">
	<div class="ttc-container ttc-support__inner">
		<div class="ttc-support__copy">
			<h2>Hỗ trợ giải pháp gia công toàn diện</h2>
			<p>Đội ngũ kỹ sư giàu kinh nghiệm của chúng tôi luôn sẵn sàng hỗ trợ khách hàng tối ưu hóa quy trình sản xuất, nâng cao tuổi thọ dao cụ và giảm thiểu tối đa chi phí vận hành.</p>
			<p class="ttc-support__phone">Business: 0977 020 209</p>
		</div>
		[ttc_support_form]
	</div>
</section>
<!-- /wp:html -->

</div>
<!-- /wp:group -->
<?php
$content = ob_get_clean();

$result = wp_update_post([
	'ID' => $page_id,
	'post_content' => $content,
], true);

if (is_wp_error($result)) {
	WP_CLI::error($result->get_error_message());
}

WP_CLI::success("Seeded homepage page #{$page_id} (" . strlen($content) . ' bytes).');
