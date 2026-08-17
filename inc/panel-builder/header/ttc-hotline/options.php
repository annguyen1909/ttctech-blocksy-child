<?php

$options = [
	'hotline_label' => [
		'label' => __('Label', 'blocksy-child'),
		'type' => 'text',
		'value' => 'Hotline',
		'design' => 'block',
		'desc' => __('Số điện thoại lấy từ field ACF “Số điện thoại” trên trang chủ.', 'blocksy-child'),
		'setting' => ['transport' => 'postMessage'],
	],
];
