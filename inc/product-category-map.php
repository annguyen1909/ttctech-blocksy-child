<?php
/**
 * Map a Sapo product type + name to one of the 8 Woo product_cat slugs.
 * Pure PHP — no WordPress dependency.
 */

function ttc_product_category_slugs(): array {
	return [
		'dung-cu-cat',
		'dung-cu-do',
		'ga-kep-dao',
		'ga-kep-phoi',
		'dau-cat-got',
		'dung-cu-phu-tro',
		'may-cong-cu',
		'dich-vu',
	];
}

function ttc_map_product_category_slug(string $sapo_category, string $name, string $alias = ''): string {
	$hay = ttc_cat_haystack($name . ' ' . $alias);

	$from_name = ttc_map_category_from_name($hay);
	if ($from_name !== null) {
		return $from_name;
	}

	$from_sapo = ttc_map_category_from_sapo($sapo_category);
	if ($from_sapo !== null) {
		return $from_sapo;
	}

	$from_fallback = ttc_map_category_from_fallback_name($hay);
	if ($from_fallback !== null) {
		return $from_fallback;
	}

	return 'dung-cu-cat';
}

function ttc_cat_haystack(string $text): string {
	$text = mb_strtolower($text, 'UTF-8');
	$map = [
		'à' => 'a', 'á' => 'a', 'ạ' => 'a', 'ả' => 'a', 'ã' => 'a',
		'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ậ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a',
		'ă' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ặ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a',
		'è' => 'e', 'é' => 'e', 'ẹ' => 'e', 'ẻ' => 'e', 'ẽ' => 'e',
		'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ệ' => 'e', 'ể' => 'e', 'ễ' => 'e',
		'ì' => 'i', 'í' => 'i', 'ị' => 'i', 'ỉ' => 'i', 'ĩ' => 'i',
		'ò' => 'o', 'ó' => 'o', 'ọ' => 'o', 'ỏ' => 'o', 'õ' => 'o',
		'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ộ' => 'o', 'ổ' => 'o', 'ỗ' => 'o',
		'ơ' => 'o', 'ờ' => 'o', 'ớ' => 'o', 'ợ' => 'o', 'ở' => 'o', 'ỡ' => 'o',
		'ù' => 'u', 'ú' => 'u', 'ụ' => 'u', 'ủ' => 'u', 'ũ' => 'u',
		'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ự' => 'u', 'ử' => 'u', 'ữ' => 'u',
		'ỳ' => 'y', 'ý' => 'y', 'ỵ' => 'y', 'ỷ' => 'y', 'ỹ' => 'y',
		'đ' => 'd',
	];
	return strtr($text, $map);
}

function ttc_hay_has(string $hay, array $needles): bool {
	foreach ($needles as $needle) {
		if ($needle !== '' && str_contains($hay, $needle)) {
			return true;
		}
	}
	return false;
}

/**
 * Specific names that override a generic Sapo type (cabinet vs tooling, mist vs thiết bị).
 */
function ttc_map_category_from_name(string $hay): ?string {
	$rules = [
		'dich-vu' => ['phan mem'],
		'may-cong-cu' => ['may mai dao'],
		'dau-cat-got' => ['phun suong', 'dau cat got', 'dau cat'],
		'ga-kep-phoi' => ['mam cap', 'do ga', 'ban hut', 'flexfix'],
		'dung-cu-phu-tro' => ['tu dung cu', 'tu dao', 'tu de dao', 'xe day'],
		'ga-kep-dao' => ['chuoi kep', 'collet', 'chuoi dao', 'swiss type', 'lathe tool'],
		'dung-cu-do' => [
			'thuoc cap', 'thuoc do', 'thuoc do sau', 'dong ho so', 'dong ho xo',
			'panme', 'duong kiem', 'gauge', 'dau do millimar', 'do nham',
			'digimar', 'millimar', 'marcal', 'marcator', 'micromar', 'levelnic',
		],
	];
	foreach ($rules as $slug => $needles) {
		if (ttc_hay_has($hay, $needles)) {
			return $slug;
		}
	}
	return null;
}

function ttc_map_category_from_sapo(string $sapo_category): ?string {
	$key = trim(ttc_cat_haystack($sapo_category));
	if ($key === '') {
		return null;
	}

	$map = [
		'milling' => 'dung-cu-cat',
		'drill' => 'dung-cu-cat',
		'endmill' => 'dung-cu-cat',
		'insert' => 'dung-cu-cat',
		'tap' => 'dung-cu-cat',
		'turning' => 'dung-cu-cat',
		'cua dia' => 'dung-cu-cat',
		'gun drill' => 'dung-cu-cat',
		'exchange drill' => 'dung-cu-cat',
		'dao dac biet' => 'dung-cu-cat',
		'reamer' => 'dung-cu-cat',
		'threadmill' => 'dung-cu-cat',
		'threading' => 'dung-cu-cat',
		'grooving' => 'dung-cu-cat',
		't-cutter' => 'dung-cu-cat',
		'burr' => 'dung-cu-cat',
		'counterbore' => 'dung-cu-cat',
		'chamfer' => 'dung-cu-cat',
		'center drill' => 'dung-cu-cat',
		'nc spot drill' => 'dung-cu-cat',
		'dao lan bong' => 'dung-cu-cat',
		'dao chuot quay' => 'dung-cu-cat',
		'lan nham' => 'dung-cu-cat',
		'gauge' => 'dung-cu-do',
		'millimar' => 'dung-cu-do',
		'dong ho so' => 'dung-cu-do',
		'thuoc cap' => 'dung-cu-do',
		'probe' => 'dung-cu-do',
		'high gauge' => 'dung-cu-do',
		'may do nham' => 'dung-cu-do',
		'panme' => 'dung-cu-do',
		'tooling' => 'ga-kep-dao',
		'chuck' => 'ga-kep-phoi',
		'do ga' => 'ga-kep-phoi',
		'xe day dung cu cnc' => 'dung-cu-phu-tro',
		'phu kien' => 'dung-cu-phu-tro',
		'may mai dao' => 'may-cong-cu',
		'thiet bi' => 'may-cong-cu',
		'phan mem' => 'dich-vu',
	];

	return $map[$key] ?? null;
}

function ttc_map_category_from_fallback_name(string $hay): ?string {
	$rules = [
		'dung-cu-do' => ['thuoc', 'dong ho', 'panme', 'duong', 'probe', 'nham'],
		'ga-kep-dao' => ['kep dao', 'chuoi'],
		'ga-kep-phoi' => ['kep phoi', 'do ga'],
		'dung-cu-phu-tro' => ['phu kien', 'tu ', 'xe day'],
		'may-cong-cu' => ['may mai', 'may cong'],
		'dich-vu' => ['dich vu'],
		'dung-cu-cat' => [
			'dao ', 'dao-', 'mui khoan', 'khoan', 'taro', 'cua', 'insert',
			'manh dao', 'doa', 'phay', 'tien', 'tap', 'ream',
		],
	];
	foreach ($rules as $slug => $needles) {
		if (ttc_hay_has($hay, $needles)) {
			return $slug;
		}
	}
	return null;
}
