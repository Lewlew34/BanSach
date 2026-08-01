<?php
// 1. Kết nối DB
require_once '../config/db.php';

// 2. Lấy từ khóa và danh mục từ URL (nếu có)
$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'all';

// 3. Xây dựng câu truy vấn SQL tìm kiếm bằng LIKE
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE (p.title LIKE :keyword OR p.author LIKE :keyword)";

// Lọc theo loại sản phẩm nếu người dùng không chọn "All categories"
if ($type !== 'all') {
    $sql .= " AND c.type = :type";
}
$sql .= " ORDER BY p.id DESC";

// 4. Thực thi truy vấn với PDO (Chống SQL Injection)
$stmt = $conn->prepare($sql);
$params = [':keyword' => '%' . $keyword . '%'];
if ($type !== 'all') {
    $params[':type'] = $type;
}

$stmt->execute($params);
$search_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_items = count($search_results);

// Gọi Header
include 'includes/header.php';
?>

<!-- Main Content Area: Search Results -->
<div class="container shop-container-full" style="margin-top: 30px; margin-bottom: 50px;">
    <main class="shop-main">
        
        <!-- Toolbar Control -->
        <div class="shop-toolbar" style="display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 15px 20px; border: 1px solid var(--border-color); border-radius: var(--radius-md); margin-bottom: 20px;">
            <div class="toolbar-left">
                <h2 style="font-size: 18px; color: var(--primary-color);">
                    Kết quả tìm kiếm cho: "<span style="color: #333;"><?php echo htmlspecialchars($keyword); ?></span>"
                    <small style="font-size: 12px; color: var(--text-gray); font-weight: normal; margin-left: 5px;">
                        (Tìm thấy <?php echo $total_items; ?> sản phẩm)
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
                <?php foreach($search_results as $item): ?>
                    <div class="product-card">
                        <?php if($item['discount_percent'] > 0): ?>
                            <span class="discount-tag">-<?php echo $item['discount_percent']; ?>%</span>
                        <?php endif; ?>
                        
                        <button class="wishlist-btn" data-id="<?php echo $item['id']; ?>">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        
                        <div class="product-img">
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" onerror="this.src='https://placehold.co/300x400/eeeeee/999999?text=No+Image';">
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
                            
                            <!-- Thêm data-id để add-to-cart Javascript hoạt động -->
                            <button class="add-cart-btn" data-id="<?php echo $item['id']; ?>">
                                <i class="fa-solid fa-cart-shopping"></i> ADD TO CART
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Giao diện khi không tìm thấy kết quả -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0; color: var(--text-gray); background: #fff; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                    <i class="fa-solid fa-magnifying-glass" style="font-size: 50px; margin-bottom: 15px; color: #cbd5e1;"></i>
                    <h3 style="color: #333; margin-bottom: 10px;">Rất tiếc, không tìm thấy sản phẩm nào!</h3>
                    <p>Hãy thử sử dụng các từ khóa chung chung hơn hoặc kiểm tra lại lỗi chính tả.</p>
                    <a href="index.php" style="color: var(--primary-color); text-decoration: underline; margin-top: 15px; display: inline-block;">Quay lại trang chủ</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php 
// Gọi Footer
include 'includes/footer.php'; 
?>