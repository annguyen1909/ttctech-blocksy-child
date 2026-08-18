<?php
/**
 * Mapping tests: Sapo type / product name → 8 Woo product_cat slugs.
 *
 * php wp-content/themes/blocksy-child/bin/test-product-category-map.php
 */

$map_file = dirname(__DIR__) . '/inc/product-category-map.php';
if (!is_readable($map_file)) {
	fwrite(STDERR, "FAIL: missing $map_file\n");
	exit(1);
}
require_once $map_file;

$cases = [
	// Sapo types → 8 shop categories
	['Milling', 'Dao phay Alu-wave', '', 'dung-cu-cat'],
	['Drill', 'AeroX', '', 'dung-cu-cat'],
	['Endmill', 'Dao phay V7', '', 'dung-cu-cat'],
	['Insert', 'Mảnh dao CBN', '', 'dung-cu-cat'],
	['Tap', 'Taro A-Tap', '', 'dung-cu-cat'],
	['Turning', 'WIN-TURN (TNMV)', '', 'dung-cu-cat'],
	['Cưa đĩa', 'Dao cưa đĩa carbide', '', 'dung-cu-cat'],
	['Gun drill', 'Mũi khoan gun drill 1 me cắt', '', 'dung-cu-cat'],
	['Reamer', 'Dao doa', '', 'dung-cu-cat'],
	['Threadmill', 'Dao phay ren TS-Thread', '', 'dung-cu-cat'],
	['Gauge', 'Ke vuông', '', 'dung-cu-do'],
	['Millimar', 'Bộ khuếch đại tín hiệu cỡ nhỏ Millimar C1202', '', 'dung-cu-do'],
	['Đồng hồ so', 'Đồng hồ so MarCator 803 A', '', 'dung-cu-do'],
	['Thước cặp', 'Thước cặp điện tử Marcal 16 ER', '', 'dung-cu-do'],
	['Probe', 'Đầu đo Millimar P1300 MA', '', 'dung-cu-do'],
	['Panme', 'Panme điện tử Micromar 40 ER', '', 'dung-cu-do'],
	['High gauge', 'Digimar 814 SR', '', 'dung-cu-do'],
	['Máy đo nhám', 'Máy đo độ nhám cầm tay', '', 'dung-cu-do'],
	['Tooling', 'Chuôi kẹp dao ER collet', '', 'ga-kep-dao'],
	['Chuck', 'Mâm cặp cường lực 3 chấu tiêu chuẩn HC (tâm đóng)', '', 'ga-kep-phoi'],
	['Đồ gá', 'Bộ đồ gá Flexfix', '', 'ga-kep-phoi'],
	['Xe đẩy dụng cụ CNC', 'Xe đẩy dụng cụ', '', 'dung-cu-phu-tro'],
	['Phụ kiện', 'Phụ kiện khoan gun drill', '', 'dung-cu-phu-tro'],
	['Máy mài dao', 'MÁY MÀI DAO TỰ ĐỘNG CNC', '', 'may-cong-cu'],
	['Phần mềm', 'Phần mềm tiện ren', '', 'dich-vu'],

	// Name wins over a generic Sapo type
	['Tooling', 'Tủ dụng cụ thông minh MATRIX / TTMB', 'tu-dung-cu', 'dung-cu-phu-tro'],
	['Thiết bị', 'Thiết bị làm mát phun sương Spray Mist System', '', 'dau-cat-got'],

	// Empty Sapo category → infer from name / alias
	['', 'Tủ dao ngăn kéo dọc', 'tu-de-dao-dung', 'dung-cu-phu-tro'],
	['', 'Bàn hút chân không', 'ban-hut-chan-khong', 'ga-kep-phoi'],
	['', 'Mũi khoan BTA', 'mui-khoan-bta', 'dung-cu-cat'],
	['', 'Dao phay vát mép', 'dao-phay-vat-mep', 'dung-cu-cat'],
	['', 'Cưa đĩa IWASAW', 'cua-dia-iwasaw', 'dung-cu-cat'],
	['', 'Dao tiện phải', 'dao-tien-phai', 'dung-cu-cat'],
	['', 'Swiss Type CNC Head-Sliding Lathe Tool', 'swiss-type-cnc-head-sliding-lathe-tool', 'ga-kep-dao'],
	['', 'Panme', 'panme', 'dung-cu-do'],
	['', 'Thước cặp', 'thuoc-cap', 'dung-cu-do'],
	['', 'Dưỡng kiểm vòng RING GAUGE', 'duong-kiem-ring-gauge', 'dung-cu-do'],
	['', 'Dao doa tinh', 'dao-doa-tinh', 'dung-cu-cat'],
];

$fail = 0;
foreach ($cases as [$sapo, $name, $alias, $want]) {
	if (!function_exists('ttc_map_product_category_slug')) {
		fwrite(STDERR, "FAIL: ttc_map_product_category_slug() is not defined\n");
		exit(1);
	}
	$got = ttc_map_product_category_slug($sapo, $name, $alias);
	if ($got !== $want) {
		$fail++;
		fwrite(STDERR, "FAIL: sapo=" . json_encode($sapo) . " name=" . json_encode($name) . " → $got (want $want)\n");
	}
}

if ($fail) {
	fwrite(STDERR, "$fail failed\n");
	exit(1);
}

echo 'OK ' . count($cases) . " cases\n";
