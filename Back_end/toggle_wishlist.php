<?php
// Đường dẫn lùi ra 1 cấp (..) để vào thư mục config
require_once '../config/db.php'; 

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    try {
        $stmt = $conn->prepare("SELECT id FROM wishlist WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $exists = $stmt->fetch();

        if ($exists) {
            // Xóa khỏi wishlist
            $del = $conn->prepare("DELETE FROM wishlist WHERE product_id = ?");
            $del->execute([$product_id]);
            echo json_encode(['status' => 'removed', 'message' => 'Đã xóa khỏi yêu thích']);
        } else {
            // Thêm vào wishlist
            $ins = $conn->prepare("INSERT INTO wishlist (product_id) VALUES (?)");
            $ins->execute([$product_id]);
            echo json_encode(['status' => 'added', 'message' => 'Đã thêm vào yêu thích']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>