<?php
// 1. Kết nối cơ sở dữ liệu
require_once '../config/db.php';

// 2. Lấy danh sách sản phẩm trong giỏ hàng
// Kết nối bảng cart (c) và products (p) dựa trên cart.id
$stmt = $conn->prepare("
    SELECT c.id as cart_id, c.quantity, p.* 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    ORDER BY c.id DESC
");
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Tính toán tổng số lượng và tổng tiền
$total_items = 0;
$total_price = 0;
foreach ($cart_items as $item) {
    $total_items += $item['quantity'];
    $total_price += ($item['price'] * $item['quantity']);
}

// 4. Gọi file Header
include 'includes/header.php';
?>

<!-- Main Content Area: Cart -->
<div class="container cart-container" style="margin-top: 30px; margin-bottom: 50px;">
    
    <div class="cart-header">
        <h2>Giỏ Hàng Của Bạn</h2>
        <p>Có <strong><?php echo $total_items; ?></strong> sản phẩm trong giỏ hàng</p>
    </div>

    <?php if (count($cart_items) > 0): ?>
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
                        <?php foreach ($cart_items as $item): ?>
                            <?php 
                                // Tính thành tiền cho từng dòng
                                $subtotal = $item['price'] * $item['quantity']; 
                            ?>
                            <tr>
                                <td class="col-product">
                                    <div class="cart-product-info">
                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                                        <div>
                                            <a href="#" class="cart-title"><?php echo htmlspecialchars($item['title']); ?></a>
                                            <p class="cart-author"><?php echo htmlspecialchars($item['author']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-price"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                <td class="col-qty">
                                    <!-- Truyền cart_id vào data-id -->
                                    <div class="qty-control">
                                        <button class="qty-btn minus" data-id="<?php echo $item['cart_id']; ?>">-</button>
                                        <input type="text" value="<?php echo $item['quantity']; ?>" readonly>
                                        <button class="qty-btn plus" data-id="<?php echo $item['cart_id']; ?>">+</button>
                                    </div>
                                </td>
                                <td class="col-subtotal"><strong><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</strong></td>
                                <td class="col-action">
                                    <!-- Truyền cart_id vào nút xóa -->
                                    <button class="btn-remove" data-id="<?php echo $item['cart_id']; ?>">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
                    <span><?php echo number_format($total_price, 0, ',', '.'); ?>đ</span>
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
                    <span class="total-price"><?php echo number_format($total_price, 0, ',', '.'); ?>đ</span>
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
    <?php else: ?>
        <!-- Giao diện khi giỏ hàng trống -->
        <div style="text-align: center; padding: 60px 0; background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius-md);">
            <i class="fa-solid fa-cart-shopping" style="font-size: 50px; margin-bottom: 15px; color: #cbd5e1;"></i>
            <h3 style="color: #333; margin-bottom: 10px;">Giỏ hàng của bạn đang trống</h3>
            <p>Hãy chọn thêm sản phẩm để tiến hành thanh toán nhé!</p>
            <a href="index.php" style="color: var(--primary-color); text-decoration: underline; margin-top: 15px; display: inline-block;">Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript xử lý tương tác giỏ hàng -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Tăng / Giảm số lượng (+ / -)
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.getAttribute('data-id');
            const type = this.classList.contains('plus') ? 'plus' : 'minus';

            fetch('/BanSach/Back_end/update_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=update_qty&cart_id=${cartId}&type=${type}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload(); // Reload lại trang để cập nhật lại tổng tiền & số lượng
                }
            });
        });
    });

    // 2. Xóa từng sản phẩm (Nút thùng rác)
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) return;
            
            const cartId = this.getAttribute('data-id');

            fetch('/BanSach/Back_end/update_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=remove_item&cart_id=${cartId}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                }
            });
        });
    });

    // 3. Xóa tất cả giỏ hàng
    const clearCartBtn = document.querySelector('.btn-clear-cart');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function() {
            if (!confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) return;

            fetch('/BanSach/Back_end/update_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=clear_cart'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    localStorage.setItem('cartCount', 0);
                    location.reload();
                }
            });
        });
    }

    // 4. Nút tiến hành thanh toán
    // 4. Nút tiến hành thanh toán
    const checkoutBtn = document.querySelector('.btn-checkout');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            // Thay vì dùng alert() dính chữ localhost, ta dùng thông báo tùy chỉnh giao diện
            showBookoraAlert('Cảm ơn bạn đã đặt hàng tại Nhà sách BOOKORA! Đơn hàng của bạn đã được ghi nhận.');
            
            // Xóa sạch giỏ hàng sau khi thanh toán thành công
            fetch('/BanSach/Back_end/update_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=clear_cart'
            })
            .then(() => {
                localStorage.setItem('cartCount', 0);
                setTimeout(() => {
                    window.location.href = 'index.php'; // Chuyển về trang chủ sau khi khách đọc xong
                }, 2000);
            });
        });
    }

// Hàm phụ trợ tạo bảng thông báo mang thương hiệu BOOKORA
function showBookoraAlert(message) {
    const existingModal = document.getElementById('bookoraAlertModal');
    if (existingModal) existingModal.remove();

    const modal = document.createElement('div');
    modal.id = 'bookoraAlertModal';
    modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 9999;';
    
    modal.innerHTML = `
        <div style="background: #fff; padding: 25px 30px; border-radius: 8px; width: 400px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            <h3 style="color: var(--primary-color); margin-bottom: 10px; font-size: 18px;"><i class="fa-solid fa-store"></i> Nhà sách BOOKORA</h3>
            <p style="color: #333; margin-bottom: 20px; font-size: 14px; line-height: 1.5;">${message}</p>
            <button id="closeBookoraAlert" style="background: var(--primary-color); color: #fff; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-weight: bold;">OK</button>
        </div>
    `;
    
    document.body.appendChild(modal);
    document.getElementById('closeBookoraAlert').addEventListener('click', () => modal.remove());
}

});
</script>

<?php 
// 5. Gọi file Footer
include 'includes/footer.php'; 
?>