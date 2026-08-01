<?php
require_once '../config/db.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // 1. Xử lý tăng hoặc giảm số lượng
    if ($action == 'update_qty' && isset($_POST['cart_id'], $_POST['type'])) {
        $cart_id = intval($_POST['cart_id']);
        $type = $_POST['type'];

        // Lấy số lượng hiện tại
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE id = ?");
        $stmt->execute([$cart_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $qty = $item['quantity'];
            if ($type == 'plus') {
                $qty++;
            } elseif ($type == 'minus' && $qty > 1) {
                $qty--;
            }

            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $update->execute([$qty, $cart_id]);
            echo json_encode(['status' => 'success']);
        }
        exit;
    }

    // 2. Xử lý xóa 1 sản phẩm
    if ($action == 'remove_item' && isset($_POST['cart_id'])) {
        $cart_id = intval($_POST['cart_id']);
        $del = $conn->prepare("DELETE FROM cart WHERE id = ?");
        $del->execute([$cart_id]);
        echo json_encode(['status' => 'success']);
        exit;
    }

    // 3. Xử lý xóa tất cả giỏ hàng
    if ($action == 'clear_cart') {
        $conn->query("DELETE FROM cart");
        echo json_encode(['status' => 'success']);
        exit;
    }
}
?>