<?php
/**
 * Seed Woo cats, brand logos, projects, support reusable block, FAQ + homepage dynamic sections.
 *
 * wp eval-file wp-content/themes/blocksy-child/bin/seed-dynamic-content.php
 */

if (!defined('ABSPATH')) {
	exit(1);
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$admin = get_users(['role' => 'administrator', 'number' => 1]);
if ($admin) {
	wp_set_current_user($admin[0]->ID);
}

function ttc_seed_attach($relative, $title) {
	static $cache = null;
	if ($cache === null) {
		$cache = get_option('ttc_seed_media', []);
	}
	if (!empty($cache[$relative])) {
		$id = (int) $cache[$relative];
		if (wp_get_attachment_url($id)) {
			return $id;
		}
	}
	$path = TTC_THEME_DIR . '/assets/img/' . ltrim($relative, '/');
	if (!is_readable($path)) {
		WP_CLI::warning("Missing $relative");
		return 0;
	}
	$tmp = wp_tempnam($path);
	copy($path, $tmp);
	$id = media_handle_sideload([
		'name' => basename($path),
		'tmp_name' => $tmp,
	], 0, $title);
	if (is_wp_error($id)) {
		WP_CLI::warning($id->get_error_message());
		return 0;
	}
	$cache[$relative] = $id;
	update_option('ttc_seed_media', $cache, false);
	return (int) $id;
}

$uri = get_stylesheet_directory_uri();
$shop_e = esc_url(wc_get_page_permalink('shop'));
$contact_e = esc_url(function_exists('ttc_contact_url') ? ttc_contact_url() : home_url('/lien-he/'));
$posts_e = esc_url(get_permalink((int) get_option('page_for_posts')) ?: home_url('/kinh-nghiem-ky-thuat/'));
$hero = esc_url("$uri/assets/img/home/hero.jpg");
$banner = esc_url("$uri/assets/img/home/banner.jpg");
$support_img = esc_url("$uri/assets/img/support-team.jpg");
$faq_img = esc_url("$uri/assets/img/faq-engineering-team.png");

/* —— 1. Product categories —— */
$cats = [
	['dung-cu-cat', 'Dụng cụ cắt', 'home/cat/cat-1.png'],
	['dung-cu-do', 'Dụng cụ đo', 'home/cat/cat-2.png'],
	['ga-kep-dao', 'Gá kẹp dao', 'home/cat/cat-3.png'],
	['ga-kep-phoi', 'Gá kẹp phôi', 'home/cat/cat-4.png'],
	['dau-cat-got', 'Dầu cắt gọt', 'home/cat/cat-5.png'],
	['dung-cu-phu-tro', 'Dụng cụ phụ trợ', 'home/cat/cat-6.png'],
	['may-cong-cu', 'Máy công cụ', 'home/cat/cat-7.png'],
	['dich-vu', 'Dịch vụ', 'home/cat/cat-8.png'],
];
foreach ($cats as [$slug, $name, $file]) {
	$term = get_term_by('slug', $slug, 'product_cat');
	if (!$term) {
		$created = wp_insert_term($name, 'product_cat', ['slug' => $slug]);
		if (is_wp_error($created)) {
			WP_CLI::warning($created->get_error_message());
			continue;
		}
		$term_id = (int) $created['term_id'];
	} else {
		$term_id = (int) $term->term_id;
	}
	$attach = ttc_seed_attach($file, $name);
	if ($attach) {
		update_term_meta($term_id, 'thumbnail_id', $attach);
	}
}
WP_CLI::success('Product categories ready.');

/* —— 2. Brand logos on product tags —— */
$brand_files = [
	'sandvik' => 'brands/brand_1.jpg',
	'taegutec' => 'brands/brand_2.jpg',
	'osg' => 'brands/brand_3.jpg',
	'yg' => 'brands/brand_4.jpg',
	'guhring' => 'brands/brand_5.jpg',
	'widin' => 'brands/brand_6.jpg',
	'ufs' => 'brands/brand_7.jpg',
	'zcc' => 'brands/brand_8.jpg',
	'sec' => 'brands/brand_9.jpg',
	'mahr' => 'brands/brand_10.jpg',
	'dasqua' => 'brands/brand_11.jpg',
	'samchully' => 'brands/brand_16.jpg',
];
foreach ($brand_files as $slug => $file) {
	$term = get_term_by('slug', $slug, 'product_tag');
	if (!$term) {
		$created = wp_insert_term(ucfirst($slug), 'product_tag', ['slug' => $slug]);
		if (is_wp_error($created)) {
			continue;
		}
		$term = get_term((int) $created['term_id']);
	}
	$attach = ttc_seed_attach($file, $term->name);
	if (!$attach) {
		continue;
	}
	update_term_meta($term->term_id, 'thumbnail_id', $attach);
	if (function_exists('update_field')) {
		update_field('ttc_brand_logo', $attach, 'product_tag_' . $term->term_id);
	}
}
WP_CLI::success('Brand logos on product tags.');

/* —— 5. Projects CPT (with KPI meta) —— */
$projects = [
	['title' => 'Gia công khuôn mẫu chính xác', 'desc' => 'Cung cấp dao phay và dụng cụ đo cho dây chuyền gia công khuôn mẫu yêu cầu độ chính xác cao.', 'stat' => 'Sai số ± 0.005 mm', 'stat_label' => 'Độ chính xác', 'days' => '45 ngày', 'days_label' => 'Thời gian triển khai', 'img' => 'home/projects/p1.jpg'],
	['title' => 'Sản xuất linh kiện hàng không', 'desc' => 'Đồng bộ dụng cụ cắt và quy trình kiểm soát chất lượng cho linh kiện đạt tiêu chuẩn khắt khe.', 'stat' => '100% đạt chuẩn', 'stat_label' => 'Tỷ lệ đạt', 'days' => '60 ngày', 'days_label' => 'Thời gian triển khai', 'img' => 'home/projects/p2.jpg'],
	['title' => 'Dây chuyền CNC tự động', 'desc' => 'Tư vấn dao cụ và thông số cắt tối ưu năng suất cho dây chuyền CNC vận hành liên tục.', 'stat' => '+30% năng suất', 'stat_label' => 'Hiệu suất', 'days' => '90 ngày', 'days_label' => 'Thời gian triển khai', 'img' => 'home/projects/p3.jpg'],
	['title' => 'Gia công chi tiết y tế', 'desc' => 'Lựa chọn dụng cụ và grade phù hợp cho chi tiết y tế yêu cầu độ bóng bề mặt cao.', 'stat' => 'Ra ≤ 0.4 μm', 'stat_label' => 'Độ bóng bề mặt', 'days' => '30 ngày', 'days_label' => 'Thời gian triển khai', 'img' => 'home/projects/p4.jpg'],
];
foreach ($projects as $p) {
	$found = get_posts(['post_type' => 'ttc_project', 'post_status' => 'any', 'numberposts' => 1, 'title' => $p['title']]);
	if ($found) {
		$id = $found[0]->ID;
	} else {
		$id = wp_insert_post([
			'post_type' => 'ttc_project',
			'post_status' => 'publish',
			'post_title' => $p['title'],
			'post_excerpt' => $p['desc'] . ' ' . $p['stat'] . ' · ' . $p['days'],
			'post_content' => $p['desc'],
		]);
		if (is_wp_error($id) || !$id) {
			continue;
		}
		$attach = ttc_seed_attach($p['img'], $p['title']);
		if ($attach) {
			set_post_thumbnail($id, $attach);
		}
	}
	update_post_meta($id, '_ttc_stat', $p['stat']);
	update_post_meta($id, '_ttc_stat_label', $p['stat_label']);
	update_post_meta($id, '_ttc_days', $p['days']);
	update_post_meta($id, '_ttc_days_label', $p['days_label']);
}
WP_CLI::success('Projects ready with KPI meta.');

/* —— 4. Support reusable block —— */
$support_id = (int) get_option('ttc_support_block_id');
$support_content = <<<HTML
<!-- wp:cover {"url":"{$support_img}","dimRatio":60,"minHeight":420,"minHeightUnit":"px","isDark":true,"className":"ttc-support","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-cover is-dark ttc-support" style="min-height:420px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-60 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="{$support_img}" data-object-fit="cover"/><div class="wp-block-cover__inner-container">
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
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="{$contact_e}">Gửi yêu cầu hỗ trợ</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div></div>
<!-- /wp:cover -->
HTML;

if ($support_id && get_post($support_id)) {
	wp_update_post(['ID' => $support_id, 'post_content' => $support_content]);
} else {
	$support_id = wp_insert_post([
		'post_type' => 'wp_block',
		'post_status' => 'publish',
		'post_title' => 'TTC Support',
		'post_content' => $support_content,
	]);
	update_option('ttc_support_block_id', (int) $support_id, false);
}
WP_CLI::success("Support reusable block #{$support_id}.");

/* —— FAQ Gutenberg —— */
$faqs = [
	['Thời gian bảo hành thiết bị đo lường là bao lâu?', '<p>TTC Tech VN chuyên cung cấp các giải pháp toàn diện về Cơ khí - Điện tử và Tự động hoá, bao gồm:</p><ul><li>Thiết kế, chế tạo máy móc và thiết bị công nghiệp theo yêu cầu.</li><li>Tích hợp hệ thống điện - điện tử, tủ điện điều khiển, lập trình PLC/SCADA.</li><li>Tối ưu hóa và nâng cấp dây chuyền sản xuất tự động.</li><li>Dịch vụ bảo trì, sửa chữa và cải tiến hệ thống kỹ thuật.</li></ul>'],
	['Công ty có nhận thiết kế giải pháp riêng (Customized Solution) cho từng nhà máy không?', '<p>Có. Đội ngũ kỹ thuật sẽ khảo sát yêu cầu, điều kiện vận hành và mục tiêu sản xuất trước khi đề xuất cấu hình, phạm vi triển khai và phương án phù hợp cho từng nhà máy.</p>'],
	['Đối tượng khách hàng chính của TTC Tech VN là ai?', '<p>Khách hàng chính là các nhà máy và doanh nghiệp sản xuất cần dụng cụ cắt, thiết bị đo lường, giải pháp gá kẹp, máy công cụ, tự động hóa và hỗ trợ kỹ thuật.</p>'],
	['Quy trình triển khai một dự án tại TTC Tech VN diễn ra như thế nào?', '<p>Quy trình gồm tiếp nhận yêu cầu, khảo sát hiện trạng, đề xuất giải pháp và báo giá, triển khai - nghiệm thu, sau đó bàn giao tài liệu và hỗ trợ vận hành.</p>'],
	['Thời gian hoàn thành một dự án thường mất bao lâu?', '<p>Tiến độ phụ thuộc vào phạm vi công việc, thiết bị, mức độ tùy chỉnh và điều kiện tại nhà máy. Thời gian cụ thể được xác nhận trong đề xuất kỹ thuật sau bước khảo sát.</p>'],
	['Khách hàng làm thế nào để nhận báo giá chi tiết?', '<p>Khách hàng có thể gửi yêu cầu qua trang Liên hệ, email info@ttctech.vn hoặc hotline. Vui lòng cung cấp bản vẽ, thông số kỹ thuật, số lượng và thời gian mong muốn để báo giá chính xác hơn.</p>'],
	['Các sản phẩm của TTC Tech VN có đạt tiêu chuẩn chất lượng không?', '<p>Sản phẩm được cung cấp theo thông số và tài liệu của từng nhà sản xuất. Tiêu chuẩn, chứng từ và điều kiện kiểm tra cụ thể sẽ được xác nhận trong báo giá hoặc hồ sơ giao hàng.</p>'],
	['Chính sách bảo hành sản phẩm/dịch vụ tại TTC Tech VN như thế nào?', '<p>Điều kiện và thời hạn bảo hành được áp dụng theo nhà sản xuất, loại sản phẩm hoặc phạm vi dịch vụ đã thỏa thuận. Bộ phận hỗ trợ sẽ hướng dẫn quy trình tiếp nhận và xử lý từng trường hợp.</p>'],
	['Khi hệ thống gặp sự cố khẩn cấp, công ty xử lý ra sao?', '<p>Đội ngũ kỹ thuật tiếp nhận thông tin, phân loại mức độ ảnh hưởng và hỗ trợ chẩn đoán từ xa trước. Khi cần thiết, phương án xử lý tại hiện trường sẽ được thống nhất với khách hàng.</p>'],
	['Sau khi hết thời hạn bảo hành, TTC Tech VN có hỗ trợ tiếp không?', '<p>Có. Khách hàng có thể tiếp tục sử dụng dịch vụ bảo trì, sửa chữa, cung cấp phụ tùng và hỗ trợ kỹ thuật theo phạm vi được hai bên xác nhận.</p>'],
];

ob_start();
?>
<!-- wp:cover {"url":"<?php echo $faq_img; ?>","dimRatio":50,"minHeight":1160,"minHeightUnit":"px","isDark":true,"className":"ttc-faq-page","layout":{"type":"constrained","contentSize":"900px"}} -->
<div class="wp-block-cover is-dark ttc-faq-page" style="min-height:1160px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-50 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo $faq_img; ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container">

<!-- wp:group {"className":"ttc-faq-intro","layout":{"type":"constrained"}} -->
<div class="wp-block-group ttc-faq-intro">
<!-- wp:heading {"textAlign":"center","level":1,"textColor":"white"} -->
<h1 class="wp-block-heading has-text-align-center has-white-color has-text-color">Hỗ trợ giải pháp gia công toàn diện</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color">Đội ngũ kỹ sư giàu kinh nghiệm của chúng tôi luôn sẵn sàng hỗ trợ khách hàng tối ưu hóa quy trình sản xuất, nâng cao tuổi thọ dao cụ và giảm thiểu tối đa chi phí vận hành.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"align":"center","className":"ttc-faq-phone","textColor":"white"} -->
<p class="has-text-align-center ttc-faq-phone has-white-color has-text-color">Business: 0977 020 209</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-faq-list","layout":{"type":"constrained"}} -->
<div class="wp-block-group ttc-faq-list">
<?php foreach ($faqs as $i => [$q, $a]) :
	$open = $i === 0 ? ' {"showContent":true}' : '';
	?>
<!-- wp:details<?php echo $open; ?> -->
<details class="wp-block-details"<?php echo $i === 0 ? ' open' : ''; ?>><summary><?php echo esc_html($q); ?></summary>
<!-- wp:html -->
<div class="ttc-faq-answer"><?php echo $a; ?></div>
<!-- /wp:html -->
</details>
<!-- /wp:details -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

</div></div>
<!-- /wp:cover -->
<?php
$faq_content = ob_get_clean();
wp_update_post(['ID' => 904, 'post_content' => $faq_content]);
WP_CLI::success('FAQ page is Gutenberg Cover + details.');

/* —— Homepage dynamic sections —— */
ob_start();
?>
<!-- wp:group {"className":"ttc-home","layout":{"type":"default"}} -->
<div class="wp-block-group ttc-home">

<!-- wp:cover {"url":"<?php echo $hero; ?>","dimRatio":55,"overlayColor":"contrast","minHeight":640,"minHeightUnit":"px","isDark":true,"className":"ttc-home-hero","layout":{"type":"constrained","contentSize":"820px"}} -->
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
<!-- wp:shortcode -->
[ttc_home_categories]
<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-home-section ttc-home-brands","anchor":"thuong-hieu","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-brands" id="thuong-hieu">
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Thương hiệu nổi bật</h2>
<!-- /wp:heading -->
<!-- wp:shortcode -->
[ttc_brands]
<!-- /wp:shortcode -->
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
<!-- wp:shortcode -->
[ttc_home_about]
<!-- /wp:shortcode -->
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
[ttc_home_products]
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
<!-- wp:shortcode -->
[ttc_home_projects]
<!-- /wp:shortcode -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"ttc-home-section ttc-home-knowledge","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group ttc-home-section ttc-home-knowledge">
<!-- wp:heading -->
<h2 class="wp-block-heading">Chia sẻ kinh nghiệm kỹ thuật</h2>
<!-- /wp:heading -->
<!-- wp:shortcode -->
[ttc_home_knowledge]
<!-- /wp:shortcode -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"ttc-home-section__cta"} -->
<div class="wp-block-buttons ttc-home-section__cta">
<!-- wp:button {"className":"ttc-btn ttc-btn--primary is-style-fill"} -->
<div class="wp-block-button ttc-btn ttc-btn--primary is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo $posts_e; ?>">Xem tất cả</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[ttc_support]
<!-- /wp:shortcode -->

</div>
<!-- /wp:group -->
<?php
$home = ob_get_clean();
$home_id = (int) get_option('page_on_front') ?: 930;
wp_update_post(['ID' => $home_id, 'post_content' => $home]);
WP_CLI::success("Homepage #{$home_id} uses dynamic cats/brands/projects/support.");
flush_rewrite_rules(false);
