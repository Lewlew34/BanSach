<?php
// Khởi tạo session để kiểm tra trạng thái đăng nhập ở mọi trang
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKORA - Read. Learn. Create.</title>
    <!-- FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/BanSach/Front_end/css/style.css">
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="top-bar">
        <div class="container top-bar-content">
            <p><i class="fa-solid fa-truck"></i> Free shipping for orders over 300.000đ</p>
            <p class="welcome-msg">Welcome to BOOKORA - Read. Learn. Create.</p>
            <div class="top-links">
                <span>Hotline: 1900 636 081</span>
                <span>|</span>
                <a href="/BanSach/Front_end/contact.php">Help & Support</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="container header-wrapper">
            <!-- Logo -->
            <a href="/BanSach/Front_end/index.php" class="logo">
                <img src="images/logo.jpg" alt="BOOKORA Logo">
            </a>

            <!-- Search Bar Đã Fix -->
            <form action="/BanSach/Front_end/search.php" method="GET" class="search-box">
                <!-- Thuộc tính name="q" chứa từ khóa tìm kiếm -->
                <input type="text" name="q" placeholder="Search books, stationery, and more..." 
                       value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" required>
                
                <!-- Thuộc tính name="type" chứa phân loại danh mục -->
                <select name="type" class="category-select">
                    <option value="all" <?php echo (isset($_GET['type']) && $_GET['type'] == 'all') ? 'selected' : ''; ?>>All categories</option>
                    <option value="book" <?php echo (isset($_GET['type']) && $_GET['type'] == 'book') ? 'selected' : ''; ?>>Books</option>
                    <option value="stationery" <?php echo (isset($_GET['type']) && $_GET['type'] == 'stationery') ? 'selected' : ''; ?>>Stationery</option>
                    <option value="combo" <?php echo (isset($_GET['type']) && $_GET['type'] == 'combo') ? 'selected' : ''; ?>>Combos</option>
                </select>
                <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <!-- Header Actions -->
            <div class="header-actions">
                <a href="/BanSach/Front_end/wishlist.php" class="action-item">
                    <div class="icon-wrap">
                        <i class="fa-regular fa-heart"></i>
                        <span class="badge">0</span>
                    </div>
                    <span>Wishlist</span>
                </a>
                <a href="/BanSach/Front_end/cart.php" class="action-item">
                    <div class="icon-wrap">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="badge">0</span>
                    </div>
                    <span>Cart</span>
                </a>

                <!-- Phần Quản Lý Tài Khoản (My Account / Đăng Nhập) -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="action-item user-dropdown-wrap" style="position: relative; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <i class="fa-solid fa-user-check user-icon" style="color: var(--primary-color);"></i>
                        <div class="user-text">
                            <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                            <small style="color: var(--primary-color);">Đã đăng nhập</small>
                        </div>
                        <!-- Menu thu nhỏ khi rê chuột vào -->
                        <div class="user-dropdown-menu" style="display: none; position: absolute; top: 100%; right: 0; background: #fff; border: 1px solid var(--border-color); padding: 10px 15px; width: 160px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: var(--radius-sm); z-index: 100;">
                            <a href="#" id="logoutBtn" style="display: block; padding: 6px 0; color: #e11d48; font-size: 14px; text-decoration: none; border-top: 1px solid #f1f5f9; margin-top: 4px;">Đăng xuất</a>
                        </div>
                    </div>

                    <script>
                        // Hiệu ứng ẩn hiện menu tài khoản
                        const dropdownWrap = document.querySelector('.user-dropdown-wrap');
                        const dropdownMenu = document.querySelector('.user-dropdown-menu');
                        if(dropdownWrap && dropdownMenu) {
                            dropdownWrap.addEventListener('mouseenter', () => dropdownMenu.style.display = 'block');
                            dropdownWrap.addEventListener('mouseleave', () => dropdownMenu.style.display = 'none');
                        }

                        // Xử lý nút Đăng xuất
                        const logoutBtn = document.getElementById('logoutBtn');
                        if(logoutBtn) {
                            logoutBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                fetch('/BanSach/Back_end/auth_process.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: 'action=logout'
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if(data.status === 'success') {
                                        localStorage.clear();
                                        window.location.href = '/BanSach/Front_end/index.php';
                                    }
                                });
                            });
                        }
                    </script>
                <?php else: ?>
                    <a href="/BanSach/Front_end/login.php" class="action-item">
                        <i class="fa-regular fa-user user-icon"></i>
                        <div class="user-text">
                            <strong>My Account</strong>
                            <small>Login / Sign up</small>
                        </div>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav class="main-nav">
        <div class="container">
            <?php 
                $current_page = basename($_SERVER['PHP_SELF']); 
            ?>
            <ul class="nav-list">
                <!-- Home -->
                <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                    <a href="/BanSach/Front_end/index.php"><i class="fa-solid fa-house"></i> Home</a>
                </li>
                
                <!-- Books -->
                <li class="dropdown <?php echo ($current_page == 'books.php') ? 'active' : ''; ?>">
                    <a href="/BanSach/Front_end/books.php"><i class="fa-solid fa-book"></i> Books <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/BanSach/Front_end/books.php">Tất cả sách</a></li>
                        <li><a href="/BanSach/Front_end/books.php?cat=ky-nang">Sách Kỹ Năng - Sống Đẹp</a></li>
                        <li><a href="/BanSach/Front_end/books.php?cat=kinh-te">Kinh Tế - Quản Lý</a></li>
                        <li><a href="/BanSach/Front_end/books.php?cat=van-hoc-trong-nuoc">Văn Học Trong Nước</a></li>
                        <li><a href="/BanSach/Front_end/books.php?cat=van-hoc-nuoc-ngoai">Văn Học Nước Ngoài</a></li>
                        <li><a href="/BanSach/Front_end/books.php?cat=tam-ly">Tâm Lý - Kỹ Năng Sống</a></li>
                        <li><a href="/BanSach/Front_end/books.php?cat=ngoai-ngu">Ngoại Ngữ</a></li>
                    </ul>
                </li>
                
                <!-- Stationery -->
                <li class="dropdown <?php echo ($current_page == 'stationery.php') ? 'active' : ''; ?>">
                    <a href="/BanSach/Front_end/stationery.php"><i class="fa-solid fa-pen-nib"></i> Stationery <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/BanSach/Front_end/stationery.php">Tất cả Văn phòng phẩm</a></li>
                        <li><a href="/BanSach/Front_end/stationery.php?cat=but-viet">Bút viết các loại</a></li>
                        <li><a href="/BanSach/Front_end/stationery.php?cat=so-tay">Sổ tay & Giấy note</a></li>
                        <li><a href="/BanSach/Front_end/stationery.php?cat=hoa-cu">Họa cụ & Màu vẽ</a></li>
                    </ul>
                </li>
                
                <!-- Combos -->
                <li class="dropdown <?php echo ($current_page == 'combos.php') ? 'active' : ''; ?>">
                    <a href="/BanSach/Front_end/combos.php"><i class="fa-solid fa-box-open"></i> Combos <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="/BanSach/Front_end/combos.php">Tất cả Combos</a></li>
                        <li><a href="/BanSach/Front_end/combos.php?cat=tiet-kiem">Combo Sách Tiết Kiệm</a></li>
                        <li><a href="/BanSach/Front_end/combos.php?cat=qua-tang">Combo Quà Tặng</a></li>
                        <li><a href="/BanSach/Front_end/combos.php?cat=back-to-school">Combo Back To School</a></li>
                    </ul>
                </li>
                
                <!-- About Us -->
                <li class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">
                    <a href="/BanSach/Front_end/about.php">About Us</a>
                </li>

                <!-- Contact -->
                <li class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">
                    <a href="/BanSach/Front_end/contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </nav>