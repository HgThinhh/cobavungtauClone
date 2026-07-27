<?php
require_once __DIR__ . '/function.php';

$menus = [
    'vung_tau' => [
        'title' => 'Menu Chi Nhánh Vũng Tàu',
        'items' => [
            ['name' => 'Bánh Khọt Tôm Đặt Biệt', 'price' => '75.000đ', 'image' => 'public/img/LogoHeader.png'],
            ['name' => 'Bánh Khọt Mực Dồn Tôm', 'price' => '85.000đ', 'image' => 'public/img/LogoHeader.png'],
            ['name' => 'Bánh Xèo Hải Sản Cô Ba', 'price' => '110.000đ', 'image' => 'public/img/LogoHeader.png'],
            ['name' => 'Gỏi Cuốn Tôm Thịt (3 cuốn)', 'price' => '45.000đ', 'image' => 'public/img/LogoHeader.png']
        ]
    ],
    'hcm' => [
        'title' => 'Menu Chi Nhánh Hồ Chí Minh',
        'items' => [
            ['name' => 'Bánh Khọt Tôm Thịt', 'price' => '80.000đ', 'image' => 'public/img/LogoHeader.png'],
            ['name' => 'Bánh Khọt Chay Đặc Biệt', 'price' => '65.000đ', 'image' => 'public/img/LogoHeader.png'],
            ['name' => 'Bún Thịt Nướng Chả Giờ', 'price' => '65.000đ', 'image' => 'public/img/LogoHeader.png'],
            ['name' => 'Chả Giờ Cô Ba (6 cuốn)', 'price' => '70.000đ', 'image' => 'public/img/LogoHeader.png']
        ]
    ]
];

$branch_key = $_GET['branch'] ?? 'vung_tau';
$response_data = $menus[$branch_key] ?? $menus['vung_tau'];

sendResponse('success', 'Lấy danh sách thực đơn thành công', $response_data);
?>
