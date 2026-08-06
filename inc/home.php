<?php
/**
 * Homepage data helpers.
 */

function ttc_home_img($file) {
	return TTC_THEME_URI . '/assets/img/' . ltrim($file, '/');
}

function ttc_home_categories() {
	$shop = wc_get_page_permalink('shop');
	$icons = TTC_THEME_URI . '/assets/img/home/cat';
	$labels = [
		['Dụng cụ cắt', 'cat-1.png'],
		['Dụng cụ đo', 'cat-2.png'],
		['Gá kẹp dao', 'cat-3.png'],
		['Gá kẹp phôi', 'cat-4.png'],
		['Dầu cắt gọt', 'cat-5.png'],
		['Dụng cụ phụ trợ', 'cat-6.png'],
		['Máy công cụ', 'cat-7.png'],
		['Dịch vụ', 'cat-8.png'],
	];
	$out = [];
	foreach ($labels as [$label, $file]) {
		$path = TTC_THEME_DIR . '/assets/img/home/cat/' . $file;
		$out[] = [
			'label' => $label,
			'url' => $shop,
			'img' => file_exists($path) ? "$icons/$file" : ttc_home_img('home/projects/p1.jpg'),
		];
	}
	return $out;
}

function ttc_home_featured_products($limit = 6) {
	if (!function_exists('wc_get_products')) {
		return [];
	}
	$featured = wc_get_products([
		'limit' => $limit,
		'status' => 'publish',
		'featured' => true,
		'orderby' => 'date',
		'order' => 'DESC',
	]);
	if (count($featured) >= $limit) {
		return $featured;
	}
	$ids = array_map(static fn($p) => $p->get_id(), $featured);
	$more = wc_get_products([
		'limit' => $limit - count($featured),
		'status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'exclude' => $ids,
	]);
	return array_merge($featured, $more);
}

function ttc_home_posts($limit = 4) {
	return get_posts([
		'numberposts' => $limit,
		'post_status' => 'publish',
		'post_type' => 'post',
	]);
}

function ttc_home_projects() {
	$contact = ttc_contact_url();
	return [
		[
			'title' => 'Gia công khuôn mẫu chính xác',
			'excerpt' => 'Cung cấp dao phay và dụng cụ đo cho dây chuyền gia công khuôn mẫu yêu cầu độ chính xác cao.',
			'stat' => 'Sai số ± 0.005 mm',
			'stat_label' => 'Độ chính xác',
			'days' => '45 ngày',
			'days_label' => 'Thời gian triển khai',
			'img' => ttc_home_img('home/projects/p1.jpg'),
			'url' => $contact,
		],
		[
			'title' => 'Sản xuất linh kiện hàng không',
			'excerpt' => 'Đồng bộ dụng cụ cắt và quy trình kiểm soát chất lượng cho linh kiện đạt tiêu chuẩn khắt khe.',
			'stat' => '100% đạt chuẩn',
			'stat_label' => 'Tỷ lệ đạt',
			'days' => '60 ngày',
			'days_label' => 'Thời gian triển khai',
			'img' => ttc_home_img('home/projects/p2.jpg'),
			'url' => $contact,
		],
		[
			'title' => 'Dây chuyền CNC tự động',
			'excerpt' => 'Tư vấn dao cụ và thông số cắt tối ưu năng suất cho dây chuyền CNC vận hành liên tục.',
			'stat' => '+30% năng suất',
			'stat_label' => 'Hiệu suất',
			'days' => '90 ngày',
			'days_label' => 'Thời gian triển khai',
			'img' => ttc_home_img('home/projects/p3.jpg'),
			'url' => $contact,
		],
		[
			'title' => 'Gia công chi tiết y tế',
			'excerpt' => 'Lựa chọn dụng cụ và grade phù hợp cho chi tiết y tế yêu cầu độ bóng bề mặt cao.',
			'stat' => 'Ra ≤ 0.4 μm',
			'stat_label' => 'Độ bóng bề mặt',
			'days' => '30 ngày',
			'days_label' => 'Thời gian triển khai',
			'img' => ttc_home_img('home/projects/p4.jpg'),
			'url' => $contact,
		],
	];
}

function ttc_home_about() {
	return [
		'intro' => 'TTCTECH cung cấp dụng cụ cắt gọt, thiết bị đo lường và giải pháp gia công cơ khí chính hãng, đồng hành cùng doanh nghiệp tối ưu năng suất và chi phí vận hành.',
		'mission_title' => 'Sứ mệnh của chúng tôi',
		'mission_body' => 'Mang đến sản phẩm chính hãng cùng giải pháp kỹ thuật tối ưu, giúp khách hàng nâng cao hiệu quả sản xuất và năng lực cạnh tranh.',
		'values_title' => 'Giá trị cốt lõi',
		'values' => [
			['Chính hãng & chất lượng', 'Phân phối dụng cụ cắt và đo lường chính hãng từ các thương hiệu hàng đầu.'],
			['Đội ngũ kỹ thuật', 'Kỹ sư giàu kinh nghiệm hỗ trợ ứng dụng và tối ưu quy trình tại xưởng.'],
			['Đồng hành cùng khách hàng', 'Tư vấn và giao hàng trên toàn quốc, gắn bó lâu dài cùng doanh nghiệp.'],
		],
		'stats' => [
			['20+', 'Năm kinh nghiệm'],
			['45+', 'Thương hiệu'],
			['58+', 'Chuyên gia kỹ thuật'],
		],
		'image' => ttc_home_img('home/about-front.jpg'),
	];
}
