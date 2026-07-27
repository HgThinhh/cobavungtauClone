<?php
require_once __DIR__ . '/function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $booking_id = (int)($_POST['booking_id'] ?? 0);
    $status = $_POST['status'] ?? 'pending';
    if ($booking_id > 0) {
        updateBookingStatus($booking_id, $status);
        header('Location: admin.php?updated=1');
        exit;
    }
}

$bookings = getAllBookings();
$subscribers = getAllSubscribers();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đặt Bàn & Đăng Ký Nhận Tin - Cô Ba Vũng Tàu</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header-bg { background-color: #6c4b2b; color: white; padding: 20px 0; }
        .card-custom { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-confirmed { background-color: #198754; color: #fff; }
        .badge-cancelled { background-color: #dc3545; color: #fff; }
    </style>
</head>
<body>
    <div class="header-bg mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h2><i class="bi bi-calendar-check"></i> Quản Lý Đặt Bàn - Cô Ba Vũng Tàu</h2>
            <div>
                <a href="admin_news.php" class="btn btn-warning btn-sm me-2 fw-semibold">Quản lý Tin Tức</a>
                <a href="index.html" class="btn btn-outline-light btn-sm">Xem Trang Chủ</a>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Đã cập nhật trạng thái đơn thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- TABLE QUẢN LÝ ĐẶT BÀN -->
        <div class="card card-custom p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="m-0 text-dark fw-bold">Danh sách yêu cầu đặt bàn (<?= count($bookings) ?>)</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#ID</th>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Chi nhánh</th>
                            <th>Ngày đặt</th>
                            <th>Giờ đặt</th>
                            <th>Số người</th>
                            <th>Ghi chú</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">Chưa có dữ liệu đặt bàn nào trong CSDL.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $b): ?>
                                <tr>
                                    <td><strong>#<?= $b['id'] ?></strong></td>
                                    <td><?= htmlspecialchars($b['fullname']) ?></td>
                                    <td><a href="tel:<?= htmlspecialchars($b['phone']) ?>"><?= htmlspecialchars($b['phone']) ?></a></td>
                                    <td><?= htmlspecialchars($b['branch']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($b['booking_date'])) ?></td>
                                    <td><?= date('H:i', strtotime($b['booking_time'])) ?></td>
                                    <td><span class="badge bg-secondary"><?= $b['guests'] ?> người</span></td>
                                    <td><small><?= htmlspecialchars($b['note'] ?? '-') ?></small></td>
                                    <td>
                                        <?php if ($b['status'] === 'confirmed'): ?>
                                            <span class="badge badge-confirmed">Đã xác nhận</span>
                                        <?php elseif ($b['status'] === 'cancelled'): ?>
                                            <span class="badge badge-cancelled">Đã hủy</span>
                                        <?php else: ?>
                                            <span class="badge badge-pending">Chờ xử lý</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="POST" action="admin.php" class="d-flex gap-1">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="pending" <?= $b['status'] === 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                                <option value="confirmed" <?= $b['status'] === 'confirmed' ? 'selected' : '' ?>>Xác nhận</option>
                                                <option value="cancelled" <?= $b['status'] === 'cancelled' ? 'selected' : '' ?>>Hủy bàn</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="m-0 text-dark fw-bold">✉️ Danh sách Email Đăng Ký Nhận Tin (Trang Chờ) (<?= count($subscribers) ?>)</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#ID</th>
                            <th>Địa chỉ Email</th>
                            <th>Thời gian đăng ký</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($subscribers)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Chưa có email nào đăng ký nhận tin.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($subscribers as $s): ?>
                                <tr>
                                    <td><strong>#<?= $s['id'] ?></strong></td>
                                    <td><a href="mailto:<?= htmlspecialchars($s['email']) ?>" class="fw-bold text-primary"><?= htmlspecialchars($s['email']) ?></a></td>
                                    <td><small class="text-muted"><?= date('H:i d/m/Y', strtotime($s['created_at'])) ?></small></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
