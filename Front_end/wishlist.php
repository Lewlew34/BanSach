<?php
// 1. Kết nối cơ sở dữ liệu nếu cần
require_once '../config/db.php';

// 2. Gọi file Header dùng chung (Chứa sẵn CSS, Logo, Menu)
include 'includes/header.php';
?>

<!-- Main Content Area: Wishlist -->
<div class="container wishlist-container" style="margin-top: 30px; margin-bottom: 50px;">
    
    <div class="wishlist-header">
        <h2>Danh Sách Yêu Thích <i class="fa-solid fa-heart" style="color:#e11d48;"></i></h2>
        <p>Bạn đã lưu <strong>2</strong> sản phẩm để mua sau.</p>
    </div>

    <div class="product-grid product-grid-full">
        
        <!-- Item Wishlist 1 -->
        <div class="product-card wishlist-card">
            <button class="wishlist-btn active"><i class="fa-solid fa-heart"></i></button>
            <div class="product-img">
                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=300&q=80" alt="Atomic Habits">
            </div>
            <div class="product-details">
                <h4 class="book-title">Atomic Habits</h4>
                <p class="author">James Clear</p>
                <div class="price-wrap">
                    <span class="current-price">135.000đ</span>
                </div>
                <p class="stock-status in-stock"><i class="fa-solid fa-check"></i> Còn hàng</p>
                <button class="add-cart-btn"><i class="fa-solid fa-cart-shopping"></i> ADD TO CART</button>
            </div>
        </div>

        <!-- Item Wishlist 2 -->
        <div class="product-card wishlist-card">
            <button class="wishlist-btn active"><i class="fa-solid fa-heart"></i></button>
            <div class="product-img">
                <img src="https://images.unsplash.com/photo-1592496431122-2349e0fbc666?auto=format&fit=crop&w=300&q=80" alt="Psychology of Money">
            </div>
            <div class="product-details">
                <h4 class="book-title">The Psychology of Money</h4>
                <p class="author">Morgan Housel</p>
                <div class="price-wrap">
                    <span class="current-price">125.000đ</span>
                </div>
                <p class="stock-status out-stock"><i class="fa-solid fa-xmark"></i> Hết hàng</p>
                <button class="add-cart-btn disabled" disabled><i class="fa-solid fa-cart-shopping"></i> ADD TO CART</button>
            </div>
        </div>

    </div>

</div>

<?php 
// 3. Gọi file Footer dùng chung
include 'includes/footer.php'; 
?>