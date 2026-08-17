<?php
/**
 * Seed homepage + careers with visual Gutenberg blocks (no Custom HTML).
 *
 * wp eval-file wp-content/themes/blocksy-child/bin/seed-gutenberg-pages.php
 */

if (!defined('ABSPATH')) {
	exit(1);
}

$uri = get_stylesheet_directory_uri();
$shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$contact = function_exists('ttc_contact_url') ? ttc_contact_url() : home_url('/lien-he/');
$about = home_url('/gioi-thieu/');
$posts = get_permalink((int) get_option('page_for_posts')) ?: home_url('/kinh-nghiem-ky-thuat/');

$hero = esc_url("$uri/assets/img/home/hero.jpg");
$about_img = esc_url("$uri/assets/img/home/about-front.jpg");
$banner = esc_url("$uri/assets/img/home/banner.jpg");
$support_img = esc_url("$uri/assets/img/support-team.jpg");
$faq_img = esc_url("$uri/assets/img/faq-engineering-team.png");
$cat_base = "$uri/assets/img/home/cat";
$proj_base = "$uri/assets/img/home/projects";
$brand_base = "$uri/assets/img/brands";

$shop_e = esc_url($shop);
$contact_e = esc_url($contact);
$about_e = esc_url($about);
$posts_e = esc_url($posts);

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

/* —— Careers —— */
ob_start();
?>
<!-- wp:group {"className":"ttc-careers","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-careers">

<!-- wp:group {"className":"ttc-careers__hero","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-careers__hero">

<!-- wp:columns {"className":"ttc-careers__hero-grid"} -->
<div class="wp-block-columns ttc-careers__hero-grid">

<!-- wp:column {"width":"44%","className":"ttc-careers__hero-copy"} -->
<div class="wp-block-column ttc-careers__hero-copy" style="flex-basis:44%">

<!-- wp:paragraph {"className":"ttc-careers__eyebrow"} -->
<p class="ttc-careers__eyebrow">Cơ hội nghề nghiệp</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Phát triển cùng đội ngũ kỹ thuật TTCTECH</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Chúng tôi tìm kiếm những đồng nghiệp chủ động, yêu thích công nghệ và muốn tạo ra giá trị thực tế cho ngành sản xuất.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"ttc-careers__actions"} -->
<div class="wp-block-buttons ttc-careers__actions">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="mailto:info@ttctech.vn?subject=%E1%BB%A8ng%20tuy%E1%BB%83n%20t%E1%BA%A1i%20TTCTECH">Gửi hồ sơ ứng tuyển</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"ttc-careers__contact is-style-outline"} -->
<div class="wp-block-button ttc-careers__contact is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo $contact_e; ?>">Liên hệ TTCTECH →</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:column -->

<!-- wp:column {"width":"56%"} -->
<div class="wp-block-column" style="flex-basis:56%">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ttc-careers__hero-image"} -->
<figure class="wp-block-image size-large ttc-careers__hero-image"><img src="<?php echo $faq_img; ?>" alt="Đội ngũ kỹ thuật TTCTECH cùng trao đổi giải pháp"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-careers__culture ttc-container","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-careers__culture ttc-container">

<!-- wp:group {"className":"ttc-careers__section-heading","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-careers__section-heading">
<!-- wp:paragraph {"className":"ttc-careers__eyebrow"} -->
<p class="ttc-careers__eyebrow">Làm việc tại TTCTECH</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Nơi chuyên môn tạo ra giá trị</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Mỗi thành viên được khuyến khích hiểu sâu vấn đề, phối hợp thẳng thắn và theo đuổi giải pháp phù hợp nhất cho khách hàng.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"className":"ttc-careers__values"} -->
<div class="wp-block-columns ttc-careers__values">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"ttc-careers__value","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-careers__value">
<!-- wp:paragraph {"className":"ttc-careers__value-num"} -->
<p class="ttc-careers__value-num">01</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Gắn với thực tế</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Công việc tập trung vào nhu cầu thật trong sản xuất và gia công cơ khí.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"ttc-careers__value","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-careers__value">
<!-- wp:paragraph {"className":"ttc-careers__value-num"} -->
<p class="ttc-careers__value-num">02</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Học hỏi liên tục</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Cùng cập nhật kiến thức sản phẩm, công nghệ và phương pháp làm việc hiệu quả.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"ttc-careers__value","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-careers__value">
<!-- wp:paragraph {"className":"ttc-careers__value-num"} -->
<p class="ttc-careers__value-num">03</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Phối hợp rõ ràng</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Trao đổi trực tiếp, tôn trọng chuyên môn và cùng chịu trách nhiệm về kết quả.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-careers__openings","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-careers__openings">

<!-- wp:group {"className":"ttc-careers__openings-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group ttc-careers__openings-head">
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"className":"ttc-careers__eyebrow"} -->
<p class="ttc-careers__eyebrow">Vị trí đang tuyển</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Cơ hội hợp tác cùng TTCTECH</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Chọn vị trí phù hợp hoặc gửi hồ sơ chủ động — chúng tôi sẽ liên hệ khi có matching.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="mailto:info@ttctech.vn?subject=H%E1%BB%93%20s%C6%A1%20%E1%BB%A9ng%20tuy%E1%BB%83n%20ch%E1%BB%A7%20%C4%91%E1%BB%99ng">Gửi hồ sơ chủ động</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-careers__jobs","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-careers__jobs">

<!-- wp:group {"className":"ttc-careers__job","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group ttc-careers__job">
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Kỹ sư ứng dụng dụng cụ cắt</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Tư vấn giải pháp dao cụ tại hiện trường, hỗ trợ khách hàng tối ưu thông số cắt và quy trình gia công.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"ttc-careers__job-meta"} -->
<p class="ttc-careers__job-meta">Toàn thời gian · TP. Hồ Chí Minh</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="mailto:info@ttctech.vn?subject=%E1%BB%A8ng%20tuy%E1%BB%83n%20K%E1%BB%B9%20s%C6%B0%20%E1%BB%A9ng%20d%E1%BB%A5ng">Ứng tuyển</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-careers__job","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group ttc-careers__job">
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Nhân viên kinh doanh kỹ thuật</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Phát triển khách hàng doanh nghiệp, phối hợp kỹ thuật để đề xuất giải pháp và theo dõi đơn hàng.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"ttc-careers__job-meta"} -->
<p class="ttc-careers__job-meta">Toàn thời gian · Hà Nội / HCM</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="mailto:info@ttctech.vn?subject=%E1%BB%A8ng%20tuy%E1%BB%83n%20Kinh%20doanh%20k%E1%BB%B9%20thu%E1%BA%ADt">Ứng tuyển</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
<?php
$careers = ob_get_clean();

/* —— Homepage —— */
ob_start();
?>
<!-- wp:group {"className":"ttc-home","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-home">

<!-- wp:cover {"url":"<?php echo $hero; ?>","dimRatio":55,"overlayColor":"contrast","minHeight":640,"minHeightUnit":"px","contentPosition":"center center","isDark":true,"className":"ttc-home-hero","layout":{"type":"constrained","contentSize":"820px"}} -->
<div class="wp-block-cover is-dark ttc-home-hero" style="min-height:640px"><span aria-hidden="true" class="wp-block-cover__background has-contrast-background-color has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo $hero; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">

<!-- wp:heading {"textAlign":"center","level":1,"textColor":"white"} -->
<h1 class="wp-block-heading has-text-align-center has-white-color has-text-color">Giải Pháp Công Cụ Cắt Gọt &amp; Thiết Bị Gia Công Cơ Khí Chính Hãng</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color">Đối tác tin cậy cung cấp dụng cụ cắt, thiết bị đo và giải pháp gia công giúp nhà máy tối ưu năng suất và chi phí.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo $contact_e; ?>">Liên hệ tư vấn</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div></div>
<!-- /wp:cover -->

<!-- wp:group {"className":"ttc-home-section ttc-home-cats","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-cats">

<!-- wp:group {"className":"ttc-home-section__head ttc-home-section__head--row","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group ttc-home-section__head ttc-home-section__head--row">
<!-- wp:heading -->
<h2 class="wp-block-heading">Danh mục sản phẩm</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"ttc-home-link"} -->
<p class="ttc-home-link"><a href="<?php echo $shop_e; ?>">Xem tất cả</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"className":"ttc-home-cats__grid"} -->
<div class="wp-block-columns ttc-home-cats__grid">
<?php foreach ($cats as [$label, $file]) :
	$img = esc_url("$cat_base/$file");
	?>
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"ttc-home-cats__item","layout":{"type":"constrained"}} -->
<div class="wp-block-group ttc-home-cats__item">
<!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"ttc-home-cats__icon"} -->
<figure class="wp-block-image size-full ttc-home-cats__icon"><a href="<?php echo $shop_e; ?>"><img src="<?php echo $img; ?>" alt="<?php echo esc_attr($label); ?>"/></a></figure>
<!-- /wp:image -->
<!-- wp:paragraph {"align":"center","className":"ttc-home-cats__label"} -->
<p class="has-text-align-center ttc-home-cats__label"><a href="<?php echo $shop_e; ?>"><?php echo esc_html($label); ?></a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-home-section ttc-home-brands","anchor":"thuong-hieu","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-brands" id="thuong-hieu">
<!-- wp:heading {"textAlign":"center","className":"ttc-home-section__head"} -->
<h2 class="wp-block-heading has-text-align-center ttc-home-section__head">Thương hiệu nổi bật</h2>
<!-- /wp:heading -->
<!-- wp:gallery {"columns":6,"linkTo":"none","sizeSlug":"medium","className":"ttc-home-brands__grid"} -->
<figure class="wp-block-gallery has-nested-images columns-6 is-cropped ttc-home-brands__grid">
<?php foreach ($brands as $brand) :
	$url = esc_url(add_query_arg('ttc_brand', $brand['slug'], $shop));
	$label = $brand['label'] ?? $brand['name'];
	?>
<!-- wp:image {"sizeSlug":"medium","linkDestination":"custom","className":"ttc-home-brands__tile"} -->
<figure class="wp-block-image size-medium ttc-home-brands__tile"><a href="<?php echo $url; ?>"><img src="<?php echo esc_url($brand['img']); ?>" alt="<?php echo esc_attr($label); ?>"/></a></figure>
<!-- /wp:image -->
<?php endforeach; ?>
</figure>
<!-- /wp:gallery -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-home-section ttc-home-about","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-about">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Về chúng tôi</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">TTCTECH cung cấp dụng cụ cắt gọt, thiết bị đo lường và giải pháp gia công cơ khí chính hãng, đồng hành cùng doanh nghiệp tối ưu năng suất và chi phí vận hành.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"ttc-home-about__grid"} -->
<div class="wp-block-columns ttc-home-about__grid">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"ttc-home-about__img"} -->
<figure class="wp-block-image size-large ttc-home-about__img"><img src="<?php echo $about_img; ?>" alt="Đội ngũ kỹ thuật TTCTECH"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
<!-- wp:column {"className":"ttc-home-about__copy"} -->
<div class="wp-block-column ttc-home-about__copy">
<!-- wp:heading {"level":3,"className":"ttc-home-about__subtitle"} -->
<h3 class="wp-block-heading ttc-home-about__subtitle">Sứ mệnh của chúng tôi</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"ttc-home-about__body"} -->
<p class="ttc-home-about__body">Mang đến sản phẩm chính hãng cùng giải pháp kỹ thuật tối ưu, giúp khách hàng nâng cao hiệu quả sản xuất và năng lực cạnh tranh.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"ttc-home-about__values-title"} -->
<p class="ttc-home-about__values-title">Giá trị cốt lõi</p>
<!-- /wp:paragraph -->
<!-- wp:list {"className":"ttc-home-about__values-list"} -->
<ul class="wp-block-list ttc-home-about__values-list">
<!-- wp:list-item -->
<li><strong>Chính hãng &amp; chất lượng</strong><br>Phân phối dụng cụ cắt và đo lường chính hãng từ các thương hiệu hàng đầu.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong>Đội ngũ kỹ thuật</strong><br>Kỹ sư giàu kinh nghiệm hỗ trợ ứng dụng và tối ưu quy trình tại xưởng.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong>Đồng hành cùng khách hàng</strong><br>Tư vấn và giao hàng trên toàn quốc, gắn bó lâu dài cùng doanh nghiệp.</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:columns {"className":"ttc-home-about__stats"} -->
<div class="wp-block-columns ttc-home-about__stats">
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph --><p><strong>20+</strong><br>Năm kinh nghiệm</p><!-- /wp:paragraph --></div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph --><p><strong>45+</strong><br>Thương hiệu</p><!-- /wp:paragraph --></div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph --><p><strong>58+</strong><br>Chuyên gia kỹ thuật</p><!-- /wp:paragraph --></div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo $about_e; ?>">Tìm hiểu thêm</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-home-section ttc-home-products","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-products">
<!-- wp:heading -->
<h2 class="wp-block-heading">Sản phẩm tiêu biểu</h2>
<!-- /wp:heading -->
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"ttc-home-products__banner"} -->
<figure class="wp-block-image size-full ttc-home-products__banner"><img src="<?php echo $banner; ?>" alt="Gia công cơ khí"/></figure>
<!-- /wp:image -->
<!-- wp:shortcode -->
[products limit="6" columns="3" orderby="date" order="DESC"]
<!-- /wp:shortcode -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"ttc-home-section__cta"} -->
<div class="wp-block-buttons ttc-home-section__cta">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo $shop_e; ?>">Xem tất cả</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-home-section ttc-home-projects","anchor":"du-an","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-projects" id="du-an">
<!-- wp:paragraph {"align":"center","className":"ttc-home-eyebrow"} -->
<p class="has-text-align-center ttc-home-eyebrow">Giải pháp gia công của TTCTECH</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Dự án tiêu biểu</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Một số hạng mục TTCTECH đã đồng hành cùng khách hàng trong gia công và trang bị dụng cụ.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"ttc-home-projects__grid"} -->
<div class="wp-block-columns ttc-home-projects__grid">
<?php
// First row of 2 — closed below, second row opens another columns block
$row1 = array_slice($projects, 0, 2);
$row2 = array_slice($projects, 2, 2);
foreach ($row1 as [$title, $excerpt, $stat, $stat_label, $days, $days_label, $file]) :
	$img = esc_url("$proj_base/$file");
	?>
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"ttc-home-project","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-home-project">
<!-- wp:image {"sizeSlug":"large","linkDestination":"custom","className":"ttc-home-project__media"} -->
<figure class="wp-block-image size-large ttc-home-project__media"><a href="<?php echo $contact_e; ?>"><img src="<?php echo $img; ?>" alt="<?php echo esc_attr($title); ?>"/></a></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"ttc-home-project__body","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-home-project__body">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html($title); ?></h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html($excerpt); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"ttc-home-project__metrics"} -->
<p class="ttc-home-project__metrics"><strong><?php echo esc_html($stat); ?></strong> · <?php echo esc_html($stat_label); ?> · <strong><?php echo esc_html($days); ?></strong> · <?php echo esc_html($days_label); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->

<!-- wp:columns {"className":"ttc-home-projects__grid"} -->
<div class="wp-block-columns ttc-home-projects__grid">
<?php foreach ($row2 as [$title, $excerpt, $stat, $stat_label, $days, $days_label, $file]) :
	$img = esc_url("$proj_base/$file");
	?>
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"ttc-home-project","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-home-project">
<!-- wp:image {"sizeSlug":"large","linkDestination":"custom","className":"ttc-home-project__media"} -->
<figure class="wp-block-image size-large ttc-home-project__media"><a href="<?php echo $contact_e; ?>"><img src="<?php echo $img; ?>" alt="<?php echo esc_attr($title); ?>"/></a></figure>
<!-- /wp:image -->
<!-- wp:group {"className":"ttc-home-project__body","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-home-project__body">
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php echo esc_html($title); ?></h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html($excerpt); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"ttc-home-project__metrics"} -->
<p class="ttc-home-project__metrics"><strong><?php echo esc_html($stat); ?></strong> · <?php echo esc_html($stat_label); ?> · <strong><?php echo esc_html($days); ?></strong> · <?php echo esc_html($days_label); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<?php endforeach; ?>
</div>
<!-- /wp:columns -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"ttc-home-section__cta"} -->
<div class="wp-block-buttons ttc-home-section__cta">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(home_url('/#du-an')); ?>">Xem tất cả dự án</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-home-section ttc-home-knowledge","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-knowledge">
<!-- wp:heading -->
<h2 class="wp-block-heading">Chia sẻ kinh nghiệm kỹ thuật</h2>
<!-- /wp:heading -->
<!-- wp:query {"queryId":31,"query":{"perPage":4,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"ttc-home-knowledge__query"} -->
<div class="wp-block-query ttc-home-knowledge__query">
<!-- wp:post-template {"className":"ttc-home-knowledge__grid","layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"className":"ttc-home-knowledge__card","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group ttc-home-knowledge__card">
<!-- wp:post-featured-image {"isLink":true,"width":"140px","height":"96px"} /-->
<!-- wp:post-title {"isLink":true,"fontSize":"medium"} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"ttc-home-section__cta"} -->
<div class="wp-block-buttons ttc-home-section__cta">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo $posts_e; ?>">Xem tất cả</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:cover {"url":"<?php echo $support_img; ?>","dimRatio":60,"minHeight":420,"minHeightUnit":"px","contentPosition":"center center","isDark":true,"className":"ttc-support","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-cover is-dark ttc-support" style="min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-60 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo $support_img; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
<!-- wp:columns {"className":"ttc-support__inner"} -->
<div class="wp-block-columns ttc-support__inner">
<!-- wp:column {"className":"ttc-support__copy"} -->
<div class="wp-block-column ttc-support__copy">
<!-- wp:heading {"textColor":"white"} -->
<h2 class="wp-block-heading has-white-color has-text-color">Hỗ trợ giải pháp gia công toàn diện</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"white"} -->
<p class="has-white-color has-text-color">Đội ngũ kỹ sư giàu kinh nghiệm của chúng tôi luôn sẵn sàng hỗ trợ khách hàng tối ưu hóa quy trình sản xuất, nâng cao tuổi thọ dao cụ và giảm thiểu tối đa chi phí vận hành.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"ttc-support__phone","textColor":"white"} -->
<p class="ttc-support__phone has-white-color has-text-color">Business: 0977 020 209</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"textColor":"white"} -->
<p class="has-white-color has-text-color">Liên hệ nhanh để nhận hỗ trợ kỹ thuật và báo giá.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo $contact_e; ?>">Gửi yêu cầu hỗ trợ</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div></div>
<!-- /wp:cover -->

</div>
<!-- /wp:group -->
<?php
$home = ob_get_clean();

$home_id = (int) get_option('page_on_front') ?: 930;
$careers_id = 906;

foreach ([$home_id => $home, $careers_id => $careers] as $id => $content) {
	$result = wp_update_post(['ID' => $id, 'post_content' => $content], true);
	if (is_wp_error($result)) {
		WP_CLI::error("#{$id}: " . $result->get_error_message());
	}
	WP_CLI::success("Seeded page #{$id} with Gutenberg blocks (" . strlen($content) . ' bytes).');
}
