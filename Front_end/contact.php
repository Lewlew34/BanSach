<?php
// 1. Kết nối cơ sở dữ liệu nếu cần
require_once '../config/db.php';

// 2. Gọi file Header dùng chung (Chứa sẵn CSS, Logo, Menu đồng bộ)
include 'includes/header.php';
?>

<!-- Nội dung trang Contact -->
<section class="contact-section container" style="margin-top: 30px; margin-bottom: 50px;">
    <div class="contact-wrapper">
        
        <!-- Cột trái: Thông tin liên hệ -->
        <div class="contact-info">
            <h3>Thông Tin Liên Hệ</h3>
            
            <div class="info-item">
                <i class="fa-solid fa-location-dot"></i>
                <div class="info-text">
                    <h4>Địa chỉ cửa hàng</h4>
                    <p>123 Đường sách Nguyễn Văn Bình<br>Quận 1, TP. Hồ Chí Minh, Việt Nam</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fa-solid fa-phone"></i>
                <div class="info-text">
                    <h4>Điện thoại</h4>
                    <p>Hotline: 1900 636 081<br>Hỗ trợ: 0987 654 321</p>
                </div>
            </div>
            
            <div class="info-item">
                <i class="fa-solid fa-envelope"></i>
                <div class="info-text">
                    <h4>Email</h4>
                    <p>cskh@bookora.vn<br>hoptac@bookora.vn</p>
                </div>
            </div>

            <div class="info-item">
                <i class="fa-regular fa-clock"></i>
                <div class="info-text">
                    <h4>Giờ mở cửa</h4>
                    <p>Thứ 2 - Thứ 6: 08:00 - 21:00<br>Thứ 7 - CN: 09:00 - 22:00</p>
                </div>
            </div>
        </div>

        <!-- Cột phải: Form liên hệ -->
        <div class="contact-form">
            <h3>Gửi Lời Nhắn Cho Chúng Tôi</h3>
            <form action="#" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Họ và Tên *</label>
                        <input type="text" id="name" class="form-control" placeholder="Nhập họ tên của bạn" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Địa chỉ Email *</label>
                        <input type="email" id="email" class="form-control" placeholder="email@example.com" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="subject">Chủ đề</label>
                    <input type="text" id="subject" class="form-control" placeholder="Bạn cần hỗ trợ vấn đề gì?">
                </div>

                <div class="form-group">
                    <label for="message">Nội dung lời nhắn *</label>
                    <textarea id="message" class="form-control" placeholder="Viết chi tiết nội dung cần hỗ trợ..." required></textarea>
                </div>

                <button type="submit" class="btn-submit"><i class="fa-solid fa-paper-plane"></i> GỬI LỜI NHẮN</button>
            </form>
        </div>

    </div>
</section>

<?php 
// 3. Gọi file Footer dùng chung
include 'includes/footer.php'; 
?>