<?php
require_once __DIR__ . '/config.php';

if (!function_exists('sendResponse')) {
    function sendResponse($status, $message, $data = null, $detail = null) {
        if (ob_get_length()) ob_clean(); 
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
            'detail'  => $detail
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}


function getBranches() {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return [];

        $stmt = $conn->prepare("SELECT * FROM branches ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}


function saveBooking($fullname, $phone, $branch, $booking_date, $booking_time, $guests, $note) {
    $db = new Database();
    $conn = $db->connect();

    if (!$conn) {
        return [
            'success' => false,
            'error'   => 'Lỗi kết nối CSDL MySQL: ' . ($db->error ?? 'Không thể kết nối đến localhost')
        ];
    }

    try {
        $sql = "INSERT INTO bookings (fullname, phone, branch, booking_date, booking_time, guests, note) 
                VALUES (:fullname, :phone, :branch, :booking_date, :booking_time, :guests, :note)";
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ':fullname'     => $fullname,
            ':phone'        => $phone,
            ':branch'       => $branch,
            ':booking_date' => $booking_date,
            ':booking_time' => $booking_time,
            ':guests'       => (int)$guests,
            ':note'         => $note
        ]);

        return [
            'success' => $result,
            'error'   => null
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'error'   => 'Lỗi truy vấn SQL: ' . $e->getMessage()
        ];
    }
}

function getAllBookings() {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return [];

        $stmt = $conn->prepare("SELECT * FROM bookings ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}


function updateBookingStatus($id, $status) {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return false;

        $stmt = $conn->prepare("UPDATE bookings SET status = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $id]);
    } catch (PDOException $e) {
        return false;
    }
}


function getAllNews() {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return [];

        $stmt = $conn->prepare("SELECT * FROM news ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}


function getNewsById($id) {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return null;

        $stmt = $conn->prepare("SELECT * FROM news WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => (int)$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}


function addNews($title, $summary, $content, $imagePath) {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return ['success' => false, 'error' => 'Không thể kết nối CSDL'];

        $sql = "INSERT INTO news (title, summary, content, image, created_at) 
                VALUES (:title, :summary, :content, :image, NOW())";
        
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([
            ':title'   => $title,
            ':summary' => $summary,
            ':content' => $content,
            ':image'   => $imagePath
        ]);

        return ['success' => $res, 'error' => null];
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Lỗi SQL: ' . $e->getMessage()];
    }
}


function updateNews($id, $title, $summary, $content, $imagePath = null) {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return ['success' => false, 'error' => 'Không thể kết nối CSDL'];

        if (!empty($imagePath)) {
            $sql = "UPDATE news SET title = :title, summary = :summary, content = :content, image = :image WHERE id = :id";
            $params = [
                ':title'   => $title,
                ':summary' => $summary,
                ':content' => $content,
                ':image'   => $imagePath,
                ':id'      => (int)$id
            ];
        } else {
            $sql = "UPDATE news SET title = :title, summary = :summary, content = :content WHERE id = :id";
            $params = [
                ':title'   => $title,
                ':summary' => $summary,
                ':content' => $content,
                ':id'      => (int)$id
            ];
        }

        $stmt = $conn->prepare($sql);
        $res = $stmt->execute($params);
        return ['success' => $res, 'error' => null];
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Lỗi SQL: ' . $e->getMessage()];
    }
}


function deleteNews($id) {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return false;

        $stmt = $conn->prepare("DELETE FROM news WHERE id = :id");
        return $stmt->execute([':id' => (int)$id]);
    } catch (PDOException $e) {
        return false;
    }
}


function addSubscriber($email) {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return ['success' => false, 'error' => 'Không thể kết nối CSDL'];

        // Kiểm tra xem email đã tồn tại chưa
        $stmtCheck = $conn->prepare("SELECT id FROM subscribers WHERE email = :email LIMIT 1");
        $stmtCheck->execute([':email' => $email]);
        if ($stmtCheck->fetch()) {
            return ['success' => true, 'message' => 'Email này đã đăng ký nhận tin trước đó!'];
        }

        $stmt = $conn->prepare("INSERT INTO subscribers (email, created_at) VALUES (:email, NOW())");
        $res = $stmt->execute([':email' => $email]);
        return ['success' => $res, 'error' => null];
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Lỗi CSDL: ' . $e->getMessage()];
    }
}


function getAllSubscribers() {
    try {
        $db = new Database();
        $conn = $db->connect();
        if (!$conn) return [];

        $stmt = $conn->prepare("SELECT * FROM subscribers ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
?>
