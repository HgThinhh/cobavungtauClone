<?php
ob_start();
require_once __DIR__ . '/function.php';

$uploadDir = __DIR__ . '/public/uploads/news/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$msg    = '';
$msgType = 'success';
$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Xóa bài viết
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if (deleteNews($id)) {
            $msg = 'Đã xóa bài viết #' . $id . ' thành công!';
        } else {
            $msg = 'Không thể xóa bài viết này!';
            $msgType = 'danger';
        }
    }

    if ($action === 'add' || $action === 'edit') {
        $id      = (int)($_POST['id'] ?? 0);
        $title   = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if (empty($title) || empty($summary)) {
            $msg = 'Tiêu đề và Tóm tắt không được để trống!';
            $msgType = 'danger';
        } else {

        $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (!in_array($fileExt, $allowed)) {
                    $msg = 'Chỉ chấp nhận file ảnh JPG, PNG, GIF, WEBP!';
                    $msgType = 'danger';
                } else {
                    $newFileName = 'news_' . time() . '_' . rand(1000, 9999) . '.' . $fileExt;
                    $targetFile  = $uploadDir . $newFileName;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $imagePath = 'public/uploads/news/' . $newFileName;
                    } else {
                        $msg = 'Không thể tải ảnh lên thư mục server!';
                        $msgType = 'danger';
                    }
                }
            }

            if (empty($msg)) {
                if ($action === 'add') {
                    if (empty($imagePath)) {
                        $msg = 'Vui lòng chọn ảnh đại diện cho bài viết!';
                        $msgType = 'danger';
                    } else {
                        $res = addNews($title, $summary, $content, $imagePath);
                        if ($res['success']) {
                            $msg = 'Thêm bài viết mới thành công! Bài viết đã được đưa lên ĐẦU TIÊN trong danh sách.';
                        } else {
                            $msg = 'Lỗi khi thêm bài viết: ' . $res['error'];
                            $msgType = 'danger';
                        }
                    }
                } else {
                    $res = updateNews($id, $title, $summary, $content, $imagePath);
                    if ($res['success']) {
                        $msg = 'Cập nhật bài viết #' . $id . ' thành công!';
                    } else {
                        $msg = 'Lỗi khi cập nhật bài viết: ' . $res['error'];
                        $msgType = 'danger';
                    }
                }
            }
        }
    }
}

if (isset($_GET['edit_id'])) {
    $editItem = getNewsById((int)$_GET['edit_id']);
}


$newsList = getAllNews();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tin Tức - Cô Ba Vũng Tàu</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <style>
        body { background-color: #f5f5f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header-bar { background: #6c4b2b; padding: 16px 0; color: #fff; }
        .header-bar h4 { margin: 0; font-size: 20px; }
        .card-admin { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); }
        .news-thumb { width: 70px; height: 55px; object-fit: cover; border-radius: 5px; }
        .btn-brown { background: #8d5023; color: #fff; border: none; }
        .btn-brown:hover { background: #6c3c17; color: #fff; }
        label { font-weight: 600; font-size: 14px; }
        .news-form-card { background: #fff; border-radius: 10px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); }
        #imagePreviewWrap { display: none; margin-top: 8px; }
        #imagePreview { max-width: 100%; max-height: 180px; border-radius: 6px; border: 1px solid #eee; }
        .table td, .table th { vertical-align: middle; font-size: 13.5px; }
        .badge-new { background: #8d5023; color: #fff; font-size: 11px; padding: 3px 8px; border-radius: 10px; }
    </style>
</head>
<body>
<div class="header-bar mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h4>Quản Lý Tin Tức — Cô Ba Vũng Tàu</h4>
        <div class="d-flex gap-2">
            <a href="admin.php" class="btn btn-outline-light btn-sm">Quản lý Đặt bàn</a>
            <a href="index.html" class="btn btn-outline-light btn-sm">Trang chủ</a>
        </div>
    </div>
</div>

<div class="container pb-5">
    <?php if (!empty($msg)): ?>
        <div class="alert alert-<?= $msgType ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($msg) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- FORM THÊM / SỬA bài viết -->
        <div class="col-lg-4">
            <div class="news-form-card">
                <?php if ($editItem): ?>
                    <h5 class="fw-bold mb-3" style="color:#8d5023;">Sửa bài viết #<?= $editItem['id'] ?></h5>
                <?php else: ?>
                    <h5 class="fw-bold mb-3" style="color:#8d5023;">Thêm bài viết mới</h5>
                <?php endif; ?>

                <form method="POST" action="admin_news.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
                    <?php if ($editItem): ?>
                        <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề bài viết *</label>
                        <input type="text" class="form-control form-control-sm" name="title"
                               value="<?= $editItem ? htmlspecialchars($editItem['title']) : '' ?>"
                               placeholder="Nhập tiêu đề..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tóm tắt (hiển thị dưới ảnh) *</label>
                        <textarea class="form-control form-control-sm" name="summary" rows="3"
                                  placeholder="Nhập tóm tắt ngắn gọn..." required><?= $editItem ? htmlspecialchars($editItem['summary']) : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung chi tiết</label>
                        <textarea class="form-control form-control-sm" name="content" rows="5"
                                  placeholder="Nhập nội dung đầy đủ bài viết..."><?= $editItem ? htmlspecialchars($editItem['content'] ?? '') : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Ảnh đại diện <?= $editItem ? '(Bỏ trống nếu không đổi ảnh)' : '*' ?>
                        </label>
                        <input type="file" class="form-control form-control-sm" name="image"
                               id="imageInput" accept="image/*" <?= !$editItem ? 'required' : '' ?>
                               onchange="previewImage(this)">
                        <div id="imagePreviewWrap">
                            <img id="imagePreview" src="" alt="Preview">
                        </div>
                        <?php if ($editItem && !empty($editItem['image'])): ?>
                            <div class="mt-2">
                                <small class="text-muted">Ảnh hiện tại:</small><br>
                                <img src="<?= htmlspecialchars($editItem['image']) ?>" style="max-height:100px; border-radius:6px; margin-top:4px;" alt="">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-brown btn-sm px-4">
                            <?= $editItem ? 'Lưu thay đổi' : 'Thêm bài viết' ?>
                        </button>
                        <?php if ($editItem): ?>
                            <a href="admin_news.php" class="btn btn-secondary btn-sm px-3">Hủy</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-admin p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold m-0" style="color:#6c4b2b;">
                        Danh sách tin tức
                        <span class="badge-new ms-2"><?= count($newsList) ?> bài</span>
                    </h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Tóm tắt</th>
                                <th>Ngày đăng</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($newsList)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Chưa có bài viết nào.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($newsList as $i => $n): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= htmlspecialchars($n['image']) ?>"
                                                 class="news-thumb"
                                                 alt=""
                                                 onerror="this.src='public/img/LogoHeader.png'">
                                        </td>
                                        <td>
                                            <?php if ($i === 0): ?>
                                                <span class="badge-new me-1">MỚI NHẤT</span>
                                            <?php endif; ?>
                                            <strong><?= htmlspecialchars(mb_substr($n['title'], 0, 60)) ?>...</strong>
                                        </td>
                                        <td><small class="text-muted"><?= htmlspecialchars(mb_substr($n['summary'], 0, 80)) ?>...</small></td>
                                        <td><small><?= date('d/m/Y', strtotime($n['created_at'])) ?></small></td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="detailnews.html?id=<?= $n['id'] ?>"
                                                   target="_blank" class="btn btn-outline-info btn-sm" title="Xem bài viết">Xem</a>
                                                <a href="admin_news.php?edit_id=<?= $n['id'] ?>"
                                                   class="btn btn-outline-warning btn-sm" title="Sửa bài viết">Sửa</a>
                                                <form method="POST" action="admin_news.php"
                                                      onsubmit="return confirm('Bạn chắc chắn muốn xóa bài viết này?')">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $n['id'] ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa bài viết">Xoá</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="public/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage(input) {
        const wrap = document.getElementById('imagePreviewWrap');
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                wrap.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>
