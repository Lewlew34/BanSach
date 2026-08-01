<?php
// 1. Kết nối cơ sở dữ liệu
require_once '../config/db.php';

// 2. Truy vấn lấy danh sách sản phẩm trong wishlist
// Kết nối bảng wishlist (w) và products (p) dựa trên product_id
$stmt = $conn->prepare("
    SELECT p.* 
    FROM wishlist w 
    JOIN products p ON w.product_id = p.id 
    ORDER BY w.id DESC
");
$stmt->execute();
$wishlist_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Đếm tổng số sản phẩm trong wishlist
$total_items = count($wishlist_items);

// 3. Gọi file Header dùng chung
include 'includes/header.php';
?>

<!-- Main Content Area: Wishlist -->
<div class="container wishlist-container" style="margin-top: 30px; margin-bottom: 50px;">
    
    <div class="wishlist-header">
        <h2>Danh Sách Yêu Thích <i class="fa-solid fa-heart" style="color:#e11d48;"></i></h2>
        <!-- Hiển thị số lượng động -->
        <p>Bạn đã lưu <strong><?php echo $total_items; ?></strong> sản phẩm để mua sau.</p>
    </div>

    <div class="product-grid product-grid-full">
        
        <?php if($total_items > 0): ?>
            <!-- Lặp qua từng sản phẩm lấy từ Database -->
            <?php foreach($wishlist_items as $item): ?>
                <div class="product-card wishlist-card" id="wishlist-item-<?php echo $item['id']; ?>">
                    
                    <!-- Nút bỏ thích (Đã thêm data-id và class active để có màu đỏ mặc định) -->
                    <button class="wishlist-btn active" data-id="<?php echo $item['id']; ?>">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                    
                    <div class="product-img">
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    </div>
                    
                    <div class="product-details">
                        <h4 class="book-title"><?php echo htmlspecialchars($item['title']); ?></h4>
                        <p class="author"><?php echo htmlspecialchars($item['author']); ?></p>
                        
                        <div class="price-wrap">
                            <span class="current-price"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</span>
                            <?php if($item['old_price'] > 0): ?>
                                <span class="old-price"><?php echo number_format($item['old_price'], 0, ',', '.'); ?>đ</span>
                            <?php endif; ?>
                        </div>
                        
                        <p class="stock-status in-stock"><i class="fa-solid fa-check"></i> Còn hàng</p>
                        <button class="add-cart-btn"><i class="fa-solid fa-cart-shopping"></i> ADD TO CART</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Giao diện khi Wishlist trống -->
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0; color: var(--text-gray);">
                <i class="fa-regular fa-heart" style="font-size: 50px; margin-bottom: 15px; color: #cbd5e1;"></i>
                <h3 style="color: #333; margin-bottom: 10px;">Danh sách yêu thích trống</h3>
                <p>Bạn chưa lưu sản phẩm nào vào danh sách yêu thích.</p>
                <a href="index.php" style="color: var(--primary-color); text-decoration: underline; margin-top: 15px; display: inline-block;">Tiếp tục mua sắm</a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php 
// 4. Gọi file Footer dùng chung
include 'includes/footer.php'; 
?>