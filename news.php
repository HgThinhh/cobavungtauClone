<?php
ob_start();
require_once __DIR__ . '/function.php';

$action = $_REQUEST['action'] ?? 'get_all';

if ($action === 'get_all') {
    $newsList = getAllNews();
    sendResponse('success', 'Lấy danh sách tin tức thành công', $newsList);
}

if ($action === 'get_detail') {
    $id = (int)($_GET['id'] ?? 0);
    $news = getNewsById($id);
    if ($news) {
        sendResponse('success', 'Lấy chi tiết tin tức thành công', $news);
    } else {
        sendResponse('error', 'Bài viết không tồn tại!');
    }
}

// Xử lý POST request: Thêm / Sửa / Xóa bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add' || $action === 'edit') {
        $id      = (int)($_POST['id'] ?? 0);
        $title   = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if (empty($title)) {
            sendResponse('error', 'Vui lòng nhập tiêu đề bài viết!');
        }

        if (empty($summary)) {
            sendResponse('error', 'Vui lòng nhập tóm tắt bài viết!');
        }

        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/public/uploads/news/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileExt  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($fileExt, $allowed)) {
                sendResponse('error', 'Chỉ chấp nhận file ảnh định dạng JPG, PNG, GIF, WEBP!');
            }

            $newFileName = 'news_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;
            $targetFile  = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = 'public/uploads/news/' . $newFileName;
            } else {
                sendResponse('error', 'Không thể tải ảnh lên thư mục server!');
            }
        }

        if ($action === 'add') {
            if (empty($imagePath)) {
                sendResponse('error', 'Vui lòng chọn ảnh đại diện cho bài viết!');
            }
            $res = addNews($title, $summary, $content, $imagePath);
            if ($res['success']) {
                sendResponse('success', 'Thêm bài viết mới thành công! Bài viết đã được đưa lên vị trí ĐẦU TIÊN.');
            } else {
                sendResponse('error', 'Lỗi khi thêm bài viết: ' . $res['error']);
            }
        } elseif ($action === 'edit') {
            if ($id <= 0) {
                sendResponse('error', 'ID bài viết không hợp lệ!');
            }
            $res = updateNews($id, $title, $summary, $content, $imagePath);
            if ($res['success']) {
                sendResponse('success', 'Cập nhật bài viết thành công!');
            } else {
                sendResponse('error', 'Lỗi khi cập nhật bài viết: ' . $res['error']);
            }
        }
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            sendResponse('error', 'ID bài viết không hợp lệ!');
        }
        $deleted = deleteNews($id);
        if ($deleted) {
            sendResponse('success', 'Đã xóa bài viết thành công!');
        } else {
            sendResponse('error', 'Không thể xóa bài viết!');
        }
    }
}
?>
