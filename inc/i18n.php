<?php
/**
 * Vietnamese UI strings (site locale is still en_US).
 * ponytail: gettext map instead of full vi_VN pack.
 */

add_filter('gettext', function ($translated, $text, $domain) {
	static $map = [
		'Default sorting' => 'Sắp xếp mặc định',
		'Sort by popularity' => 'Sắp xếp theo độ phổ biến',
		'Sort by average rating' => 'Sắp xếp theo đánh giá',
		'Sort by latest' => 'Sắp xếp theo mới nhất',
		'Sort by price: low to high' => 'Giá: thấp đến cao',
		'Sort by price: high to low' => 'Giá: cao đến thấp',
		'Shop order' => 'Thứ tự sản phẩm',
		'Next' => 'Sau',
		'Previous' => 'Trước',
		'Read more' => 'Xem thêm',
		'Skip to content' => 'Chuyển tới nội dung',
		'Uncategorized' => 'Chưa phân loại',
		'No products were found matching your selection.' => 'Không tìm thấy sản phẩm phù hợp.',
		'Search results' => 'Kết quả tìm kiếm',
		'Showing the single result' => 'Hiển thị 1 kết quả',
		'Showing all %d results' => 'Hiển thị tất cả %d kết quả',
		'Showing %1$d&ndash;%2$d of %3$d results' => 'Hiển thị %1$d&ndash;%2$d trên tổng %3$d kết quả',
	];

	if (isset($map[$text])) {
		return $map[$text];
	}

	// WooCommerce: "Read more about “%s”"
	if ($domain === 'woocommerce' && str_starts_with($text, 'Read more about')) {
		return 'Xem thêm về “%s”';
	}

	return $translated;
}, 20, 3);

add_filter('ngettext', function ($translated, $single, $plural, $number, $domain) {
	if ($domain !== 'woocommerce') {
		return $translated;
	}
	if ($single === 'Showing the single result') {
		return 'Hiển thị 1 kết quả';
	}
	if ($single === 'Showing all %d results') {
		return 'Hiển thị tất cả %d kết quả';
	}
	return $translated;
}, 20, 5);

add_filter('gettext_with_context', function ($translated, $text, $context, $domain) {
	if ($text === 'Next' && $context === 'Next post') {
		return 'Sau';
	}
	if ($text === 'Previous' && $context === 'Previous post') {
		return 'Trước';
	}
	return $translated;
}, 20, 4);
