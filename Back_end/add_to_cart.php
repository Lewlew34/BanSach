<?php
session_start();
require_once '../config/db.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'unauthorized', 'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!']);
    exit;
}

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    try {
        // 1. Kiểm tra xem sản phẩm này đã có trong giỏ hàng chưa
        $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart_item) {
            // Nếu đã có trong giỏ -> Tăng số lượng lên 1
            $new_qty = $cart_item['quantity'] + 1;
            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE product_id = ?");
            $update->execute([$new_qty, $product_id]);
        } else {
            // Nếu chưa có -> Thêm mới với số lượng mặc định là 1
            $insert = $conn->prepare("INSERT INTO cart (product_id, quantity) VALUES (?, 1)");
            $insert->execute([$product_id]);
        }

        // Lấy tổng số lượng sản phẩm hiện tại trong giỏ để cập nhật lên badge giao diện
        $count_stmt = $conn->query("SELECT SUM(quantity) as total FROM cart");
        $total_count = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        echo json_encode(['status' => 'success', 'total_cart' => intval($total_count)]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>