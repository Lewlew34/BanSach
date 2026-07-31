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

            <!-- Search Bar -->
            <div class="search-box">
                <input type="text" placeholder="Search books, stationery, and more...">
                <select class="category-select">
                    <option value="0">All categories</option>
                    <option value="1">Books</option>
                    <option value="2">Stationery</option>
                    <option value="3">Combos</option>
                </select>
                <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

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
                <a href="/BanSach/Front_end/account.php" class="action-item">
                    <i class="fa-regular fa-user user-icon"></i>
                    <div class="user-text">
                        <strong>My Account</strong>
                        <small>Login / Sign up</small>
                    </div>
                </a>
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