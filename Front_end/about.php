<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Về Chúng Tôi - BOOKORA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
// 1. Kết nối cơ sở dữ liệu nếu cần
require_once '../config/db.php';

// 2. Gọi file Header dùng chung (Chứa sẵn CSS, Logo, Menu đồng bộ)
include 'includes/header.php';
?>

<!-- Nội dung trang About Us -->
<section class="about-section container" style="margin-top: 30px; margin-bottom: 50px;">
    <div class="about-grid">
        <div class="about-img">
            <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80" alt="Về BOOKORA">
        </div>
        <div class="about-text">
            <h2>Câu chuyện của BOOKORA</h2>
            <p>Khởi nguồn từ niềm đam mê đọc sách và yêu thích sự sáng tạo, <strong>BOOKORA</strong> được thành lập với mục tiêu trở thành không gian tri thức truyền cảm hứng cho tất cả mọi người. Chúng tôi không chỉ bán sách, chúng tôi trao gửi những giá trị tinh thần.</p>
            <p>Tại BOOKORA, bạn có thể tìm thấy hàng ngàn tựa sách từ văn học, kinh tế đến kỹ năng sống, cùng với những bộ văn phòng phẩm thiết kế độc đáo giúp khơi dậy nguồn cảm hứng sáng tạo trong học tập và làm việc mỗi ngày.</p>
            <p>Sứ mệnh của chúng tôi là: <em>"Đọc để thấu hiểu - Học để phát triển - Sáng tạo để bứt phá"</em> (Read. Learn. Create).</p>
        </div>
    </div>

    <div class="values-grid">
        <div class="value-card">
            <i class="fa-solid fa-book-open-reader value-icon"></i>
            <h3>Đa Dạng Tựa Sách</h3>
            <p>Luôn cập nhật những tựa sách mới nhất, hot nhất trên thị trường với chất lượng in ấn và bản quyền đảm bảo.</p>
        </div>
        <div class="value-card">
            <i class="fa-solid fa-truck-fast value-icon"></i>
            <h3>Giao Hàng Nhanh Chóng</h3>
            <p>Hệ thống đóng gói chuyên nghiệp, giao hàng siêu tốc và miễn phí vận chuyển cho đơn hàng từ 300K.</p>
        </div>
        <div class="value-card">
            <i class="fa-solid fa-headset value-icon"></i>
            <h3>Hỗ Trợ Tận Tâm</h3>
            <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng tư vấn, giải đáp thắc mắc của bạn 24/7 một cách nhiệt tình nhất.</p>
        </div>
    </div>
</section>

<?php 
// 3. Gọi file Footer dùng chung
include 'includes/footer.php'; 
?>
    