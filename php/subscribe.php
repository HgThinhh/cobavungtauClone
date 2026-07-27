<?php
ob_start();
require_once __DIR__ . '/function.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        sendResponse('error', 'Vui lòng nhập địa chỉ email!');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendResponse('error', 'Địa chỉ email không hợp lệ!');
    }

    $res = addSubscriber($email);

    if ($res['success']) {
        sendResponse('success', $res['message'] ?? 'Đăng ký thành công!');
    } else {
        sendResponse('error', $res['error'] ?? 'Không thể lưu email vào hệ thống!');
    }
} else {
    sendResponse('error', 'Phương thức yêu cầu không hợp lệ!');
}
?>
