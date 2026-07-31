<?php
$host = "localhost";
$dbname = "bookora_db";
$username = "root"; // Tên đăng nhập mặc định của XAMPP
$password = "";     // Mật khẩu mặc định là rỗng

try {
    // Khởi tạo kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Thiết lập chế độ báo lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>