<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // 1. ĐĂNG KÝ
    if ($action === 'register') {
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu bảo mật

        try {
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$fullname, $email, $password]);
            echo json_encode(['status' => 'success', 'message' => 'Đăng ký thành công! Vui lòng đăng nhập.']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Email này đã được sử dụng!']);
        }
        exit;
    }

    // 2. ĐĂNG NHẬP
    if ($action === 'login') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Lưu thông tin vào Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_email'] = $user['email'];

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email hoặc mật khẩu không chính xác!']);
        }
        exit;
    }

    // 3. ĐĂNG XUẤT
    if ($action === 'logout') {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();
        echo json_encode(['status' => 'success']);
        exit;
    }
}
?>