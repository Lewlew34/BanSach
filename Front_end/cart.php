<?php
// 1. Kết nối cơ sở dữ liệu nếu cần
require_once '../config/db.php';

// 2. Gọi file Header dùng chung (Chứa sẵn CSS, Logo, Menu đồng bộ)
include 'includes/header.php';
?>

<!-- Main Content Area: Cart -->
<div class="container cart-container" style="margin-top: 30px; margin-bottom: 50px;">
    
    <div class="cart-header">
        <h2>Giỏ Hàng Của Bạn</h2>
        <p>Có <strong>2</strong> sản phẩm trong giỏ hàng</p>
    </div>

    <div class="cart-layout">
        <!-- Cột trái: Danh sách sản phẩm -->
        <div class="cart-items">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th class="col-product">Sản phẩm</th>
                        <th class="col-price">Đơn giá</th>
                        <th class="col-qty">Số lượng</th>
                        <th class="col-subtotal">Thành tiền</th>
                        <th class="col-action">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Item 1 -->
                    <tr>
                        <td class="col-product">
                            <div class="cart-product-info">
                                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=100&q=80" alt="Atomic Habits">
                                <div>
                                    <a href="#" class="cart-title">Atomic Habits</a>
                                    <p class="cart-author">James Clear</p>
                                </div>
                            </div>
                        </td>
                        <td class="col-price">135.000đ</td>
                        <td class="col-qty">
                            <div class="qty-control">
                                <button class="qty-btn minus">-</button>
                                <input type="text" value="1" readonly>
                                <button class="qty-btn plus">+</button>
                            </div>
                        </td>
                        <td class="col-subtotal"><strong>135.000đ</strong></td>
                        <td class="col-action"><button class="btn-remove"><i class="fa-solid fa-trash-can"></i></button></td>
                    </tr>

                    <!-- Item 2 -->
                    <tr>
                        <td class="col-product">
                            <div class="cart-product-info">
                                <img src="https://images.unsplash.com/photo-1585336261022-680e295ce3fe?auto=format&fit=crop&w=100&q=80" alt="Bút Lamy">
                                <div>
                                    <a href="#" class="cart-title">Bút Mực Lamy Safari</a>
                                    <p class="cart-author">Stationery</p>
                                </div>
                            </div>
                        </td>
                        <td class="col-price">550.000đ</td>
                        <td class="col-qty">
                            <div class="qty-control">
                                <button class="qty-btn minus">-</button>
                                <input type="text" value="2" readonly>
                                <button class="qty-btn plus">+</button>
                            </div>
                        </td>
                        <td class="col-subtotal"><strong>1.100.000đ</strong></td>
                        <td class="col-action"><button class="btn-remove"><i class="fa-solid fa-trash-can"></i></button></td>
                    </tr>
                </tbody>
            </table>
            
            <div class="cart-actions-bottom">
                <a href="index.php" class="btn-continue-shopping"><i class="fa-solid fa-arrow-left"></i> Tiếp tục mua sắm</a>
                <button class="btn-clear-cart">Xóa tất cả</button>
            </div>
        </div>

        <!-- Cột phải: Tổng tiền & Thanh toán -->
        <div class="cart-summary">
            <h3>Tóm tắt đơn hàng</h3>
            
            <div class="summary-line">
                <span>Tạm tính:</span>
                <span>1.235.000đ</span>
            </div>
            <div class="summary-line">
                <span>Phí vận chuyển:</span>
                <span class="free-shipping">Miễn phí</span>
            </div>
            <div class="summary-line discount">
                <span>Giảm giá:</span>
                <span>- 0đ</span>
            </div>
            
            <div class="summary-total">
                <span>Tổng cộng:</span>
                <span class="total-price">1.235.000đ</span>
            </div>

            <div class="promo-code-box">
                <input type="text" placeholder="Nhập mã giảm giá...">
                <button>Áp dụng</button>
            </div>

            <button class="btn-checkout">TIẾN HÀNH THANH TOÁN</button>
            
            <div class="payment-methods">
                <p>Hỗ trợ thanh toán:</p>
                <div class="payment-icons">
                    <i class="fa-brands fa-cc-visa"></i>
                    <i class="fa-brands fa-cc-mastercard"></i>
                    <i class="fa-brands fa-cc-paypal"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// 3. Gọi file Footer dùng chung
include 'includes/footer.php'; 
?>