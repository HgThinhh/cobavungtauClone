<?php
ob_start(); 
require_once 'function.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse('error', 'Phương thức truy cập không hợp lệ! Vui lòng gửi dữ liệu bằng POST.');
}

$rawInput  = file_get_contents('php://input');
$jsonInput = json_decode($rawInput, true) ?? [];

$fullname     = trim($_POST['fullname'] ?? $jsonInput['fullname'] ?? '');
$phone        = trim($_POST['phone'] ?? $jsonInput['phone'] ?? '');
$branch       = trim($_POST['branch'] ?? $jsonInput['branch'] ?? '');
$booking_date = trim($_POST['booking_date'] ?? $jsonInput['booking_date'] ?? '');
$booking_time = trim($_POST['booking_time'] ?? $jsonInput['booking_time'] ?? '');
$guests       = trim($_POST['guests'] ?? $jsonInput['guests'] ?? 1);
$note         = trim($_POST['note'] ?? $jsonInput['note'] ?? '');

if (empty($fullname)) {
    sendResponse('error', 'Vui lòng nhập họ và tên của quý khách!');
}

if (empty($phone)) {
    sendResponse('error', 'Vui lòng nhập số điện thoại liên hệ!');
}

if (!preg_match('/^[0-9]{9,11}$/', $phone)) {
    sendResponse('error', 'Số điện thoại không hợp lệ! Vui lòng nhập từ 9 đến 11 chữ số (ví dụ: 0912345678).');
}

if (empty($branch)) {
    sendResponse('error', 'Vui lòng chọn chi nhánh nhà hàng!');
}

if (empty($booking_date)) {
    sendResponse('error', 'Vui lòng chọn ngày đặt bàn!');
}

if (empty($booking_time)) {
    sendResponse('error', 'Vui lòng chọn giờ đặt bàn!');
}

if (empty($guests) || !is_numeric($guests) || (int)$guests < 1) {
    sendResponse('error', 'Số lượng người đặt bàn phải là số nguyên dương!');
}

// Gọi hàm lưu vào Cơ sở dữ liệu
$res = saveBooking($fullname, $phone, $branch, $booking_date, $booking_time, $guests, $note);

if ($res['success']) {
    sendResponse('success', 'Đặt bàn thành công! Nhà hàng Cô Ba Vũng Tàu sẽ liên hệ với quý khách trong thời gian sớm nhất.');
} else {
    sendResponse('error', 'Lỗi khi lưu đơn đặt bàn: ' . $res['error']);
}
?>
