<?php
// 1. Kết nối Database
require_once '../config/db.php';

// 2. Lấy tham số 'cat' (category) từ URL nếu người dùng bấm vào Menu con
// Ví dụ URL: books.php?cat=kinh-te
$cat_slug = isset($_GET['cat']) ? $_GET['cat'] : '';

// 3. Khởi tạo câu truy vấn SQL cơ bản (Chỉ lấy loại 'book')
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE c.type = 'book'";

// Tiêu đề trang (Sẽ thay đổi nếu có lọc)
$page_title = "Tất Cả Sách";

// 4. Nếu có lọc theo danh mục, bổ sung điều kiện vào chuỗi SQL
if ($cat_slug == 'ky-nang') {
    $sql .= " AND c.name LIKE '%Kỹ Năng%'";
    $page_title = "Sách Kỹ Năng - Sống Đẹp";
} elseif ($cat_slug == 'kinh-te') {
    $sql .= " AND c.name LIKE '%Kinh Tế%'";
    $page_title = "Kinh Tế - Quản Lý";
} elseif ($cat_slug == 'van-hoc-trong-nuoc') {
    $sql .= " AND c.name LIKE '%Trong Nước%'";
    $page_title = "Văn Học Trong Nước";
} elseif ($cat_slug == 'van-hoc-nuoc-ngoai') {
    $sql .= " AND c.name LIKE '%Nước Ngoài%'";
    $page_title = "Văn Học Nước Ngoài";
} elseif ($cat_slug == 'tam-ly') {
    $sql .= " AND c.name LIKE '%Tâm Lý%'";
    $page_title = "Tâm Lý - Kỹ Năng Sống";
}

// Thêm sắp xếp mặc định (mới nhất lên đầu)
$sql .= " ORDER BY p.id DESC";

// 5. Thực thi câu truy vấn
$stmt = $conn->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Đếm tổng số sách tìm được
$total_books = count($books);

// 6. Gọi Header
include 'includes/header.php';
?>

<!-- Main Content Area: Books -->
<div class="container shop-container-full" style="margin-top: 30px; margin-bottom: 50px;">
    <main class="shop-main">
        
        <!-- Toolbar Control -->
        <div class="shop-toolbar" style="display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 15px 20px; border: 1px solid var(--border-color); border-radius: var(--radius-md); margin-bottom: 20px;">
            <div class="toolbar-left">
                <!-- Hiển thị Tiêu đề Động và Tổng số sản phẩm -->
                <h2 style="font-size: 18px; color: var(--primary-color);">
                    <?php echo $page_title; ?> 
                    <small style="font-size: 12px; color: var(--text-gray); font-weight: normal;">
                        (Hiển thị <?php echo $total_books; ?> sản phẩm)
                    </small>
                </h2>
            </div>
            <div class="toolbar-right" style="display: flex; align-items: center; gap: 10px; font-size: 13px;">
                <label for="sortSelect">Sắp xếp theo:</label>
                <!-- JS sẽ tự động nhận diện ID này để sắp xếp giá -->
                <select id="sortSelect" class="sort-select" style="padding: 6px 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;">
                    <option value="default" selected disabled>Chọn mức giá...</option>
                    <option value="price-low">Giá: Thấp đến Cao</option>
                    <option value="price-high">Giá: Cao đến Thấp</option>
                </select>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="product-grid product-grid-full">
            
            <?php if($total_books > 0): ?>
                <?php foreach($books as $item): ?>
                    <div class="product-card">
                        
                        <?php if($item['discount_percent'] > 0): ?>
                            <span class="discount-tag">-<?php echo $item['discount_percent']; ?>%</span>
                        <?php endif; ?>
                        
                        <button class="wishlist-btn"><i class="fa-regular fa-heart"></i></button>
                        
                        <div class="product-img">
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        </div>
                        
                        <div class="product-details">
                            <!-- Hiển thị tên sách -->
                            <h4 class="book-title"><?php echo htmlspecialchars($item['title']); ?></h4>
                            <!-- Hiển thị tác giả -->
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
                <!-- Thông báo khi chọn danh mục không có sách -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px 0; color: var(--text-gray);">
                    <i class="fa-solid fa-box-open" style="font-size: 40px; margin-bottom: 15px; color: #cbd5e1;"></i>
                    <p>Hiện chưa có sản phẩm nào trong danh mục này.</p>
                    <a href="books.php" style="color: var(--primary-color); text-decoration: underline; margin-top: 10px; display: inline-block;">Xem tất cả sách</a>
                </div>
            <?php endif; ?>

        </div>

        <!-- Pagination (Tạm thời để tĩnh, xử lý động sau nếu dữ liệu lớn) -->
        <?php if($total_books > 0): ?>
        <div class="pagination">
            <a href="#" class="page-link disabled"><i class="fa-solid fa-chevron-left"></i></a>
            <a href="#" class="page-link active">1</a>
            <a href="#" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
        </div>
        <?php endif; ?>
        
    </main>
</div>

<?php 
// 7. Gọi Footer
include 'includes/footer.php'; 
?>