<?php
// 1. Kết nối Database
require_once '../config/db.php';

// 2. Lấy tham số 'cat' từ URL
$cat_slug = isset($_GET['cat']) ? $_GET['cat'] : '';

// 3. SQL cơ bản: Chỉ lấy loại 'combo'
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE c.type = 'combo'";

$page_title = "Combos & Quà Tặng";

// 4. Lọc theo danh mục con của Combo
if ($cat_slug == 'tiet-kiem') {
    $sql .= " AND c.name LIKE '%Tiết Kiệm%'";
    $page_title = "Combo Sách Tiết Kiệm";
} elseif ($cat_slug == 'qua-tang') {
    $sql .= " AND c.name LIKE '%Quà Tặng%'";
    $page_title = "Combo Quà Tặng";
} elseif ($cat_slug == 'back-to-school') {
    $sql .= " AND c.name LIKE '%Back To School%'";
    $page_title = "Combo Back To School";
}

$sql .= " ORDER BY p.id DESC";

// 5. Thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->execute();
$combos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_items = count($combos);

// 6. Gọi Header
include 'includes/header.php';
?>

<!-- Main Content Area -->
<div class="container shop-container-full" style="margin-top: 30px; margin-bottom: 50px;">
    <main class="shop-main">
        
        <!-- Toolbar Control -->
        <div class="shop-toolbar" style="display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 15px 20px; border: 1px solid var(--border-color); border-radius: var(--radius-md); margin-bottom: 20px;">
            <div class="toolbar-left">
                <h2 style="font-size: 18px; color: var(--primary-color);">
                    <?php echo $page_title; ?> 
                    <small style="font-size: 12px; color: var(--text-gray); font-weight: normal;">
                        (Hiển thị <?php echo $total_items; ?> sản phẩm)
                    </small>
                </h2>
            </div>
            <div class="toolbar-right" style="display: flex; align-items: center; gap: 10px; font-size: 13px;">
                <label for="sortSelect">Sắp xếp theo:</label>
                <select id="sortSelect" class="sort-select" style="padding: 6px 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;">
                    <option value="default" selected disabled>Chọn mức giá...</option>
                    <option value="price-low">Giá: Thấp đến Cao</option>
                    <option value="price-high">Giá: Cao đến Thấp</option>
                </select>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="product-grid product-grid-full">
            
            <?php if($total_items > 0): ?>
                <?php foreach($combos as $item): ?>
                    <div class="product-card">
                        <?php if($item['discount_percent'] > 0): ?>
                            <span class="discount-tag">-<?php echo $item['discount_percent']; ?>%</span>
                        <?php endif; ?>
                        
                        <!-- Đã bổ sung data-id vào nút thả tim -->
                        <button class="wishlist-btn" data-id="<?php echo $item['id']; ?>">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        
                        <div class="product-img">
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        </div>
                        
                        <div class="product-details">
                            <h4 class="book-title"><?php echo htmlspecialchars($item['title']); ?></h4>
                            <p class="author"><?php echo htmlspecialchars($item['author']); ?></p>
                            
                            <div class="rating">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                                <span>(<?php echo $item['review_count']; ?>)</span>
                            </div>
                            
                            <div class="price-wrap">
                                <span class="current-price"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</span>
                                <?php if($item['old_price'] > 0): ?>
                                    <span class="old-price"><?php echo number_format($item['old_price'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                            
                            <button class="add-cart-btn"><i class="fa-solid fa-cart-shopping"></i> ADD TO CART</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px 0; color: var(--text-gray);">
                    <i class="fa-solid fa-box-open" style="font-size: 40px; margin-bottom: 15px; color: #cbd5e1;"></i>
                    <p>Hiện chưa có sản phẩm nào trong danh mục này.</p>
                    <a href="combos.php" style="color: var(--primary-color); text-decoration: underline; margin-top: 10px; display: inline-block;">Xem tất cả</a>
                </div>
            <?php endif; ?>

        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>