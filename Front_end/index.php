<?php
require_once '../config/db.php';

$stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 6");
$stmt->execute();
$best_sellers = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>      

<!-- Main Banner Section -->
<section class="hero-banner">
    <div class="container banner-wrapper">
        <button class="slider-btn prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
        
        <div class="banner-content">
            <div class="banner-text">
                <small>DISCOVER YOUR NEXT</small>
                <h1>FAVORITE BOOK</h1>
                <p>Explore books, stationery, and creative essentials designed for your learning journey.</p>
                <a href="books.php" class="btn-shop">SHOP NOW <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="banner-image">
                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80" alt="Books">
            </div>
        </div>

        <button class="slider-btn next-btn"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</section>

<!-- Category Feature Cards -->
<section class="category-cards container">
    <div class="cat-card">
        <div class="cat-icon green"><i class="fa-solid fa-book-open"></i></div>
        <div class="cat-info">
            <h3>BOOKS</h3>
            <p>Discover stories, knowledge, and inspiration.</p>
            <a href="books.php" class="cat-link green-text">SHOP NOW &rarr;</a>
        </div>
    </div>
    <div class="cat-card">
        <div class="cat-icon orange"><i class="fa-solid fa-pencil"></i></div>
        <div class="cat-info">
            <h3>STATIONERY</h3>
            <p>Make your study time more organized.</p>
            <a href="stationery.php" class="cat-link orange-text">SHOP NOW &rarr;</a>
        </div>
    </div>
    <div class="cat-card">
        <div class="cat-icon purple"><i class="fa-solid fa-gift"></i></div>
        <div class="cat-info">
            <h3>COMBOS</h3>
            <p>Everything you need, packed together.</p>
            <a href="combos.php" class="cat-link purple-text">SHOP NOW &rarr;</a>
        </div>
    </div>
    <div class="cat-card">
        <div class="cat-icon yellow"><i class="fa-solid fa-award"></i></div>
        <div class="cat-info">
            <h3>BEST SELLERS</h3>
            <p>Popular products loved by our customers.</p>
            <a href="books.php" class="cat-link yellow-text">SHOP NOW &rarr;</a>
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="products-section container">
    <div class="section-layout">
        
        <div class="products-main">
            <div class="section-title">
                <h2>BEST SELLERS</h2>
            </div>
            
            <div class="product-grid">
                <?php foreach($best_sellers as $item): ?>
                    <div class="product-card">
                        
                        <?php if($item['discount_percent'] > 0): ?>
                            <span class="discount-tag">-<?php echo $item['discount_percent']; ?>%</span>
                        <?php endif; ?>
                        
                        <!-- Đã fix: Bổ sung data-id vào nút thả tim -->
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
            </div>
        </div>

        <!-- Side Widgets -->
        <div class="sidebar-promos">
            <div class="widget flash-sale-widget">
                <div class="widget-header">
                    <h3>SPECIAL OFFERS</h3>
                    <a href="books.php" class="view-all">View all &rarr;</a>
                </div>
                <div class="widget-body">
                    <span class="badge-red">FLASH SALE</span>
                    <h4>Up to 30% OFF</h4>
                    <p class="sub-text">selected items</p>

                    <div class="countdown-timer">
                        <div class="time-box"><span id="days">02</span><small>DAYS</small></div>
                        <div class="time-box"><span id="hours">14</span><small>HRS</small></div>
                        <div class="time-box"><span id="mins">37</span><small>MINS</small></div>
                        <div class="time-box"><span id="secs">52</span><small>SECS</small></div>
                    </div>

                    <a href="books.php" class="btn-widget-shop">SHOP NOW &rarr;</a>
                </div>
            </div>

            <div class="widget student-widget">
                <h3>STUDENT DISCOUNT</h3>
                <h2>10% OFF</h2>
                <p>for all students</p>
                <a href="#" class="verify-link">VERIFY NOW &rarr;</a>
            </div>
        </div>

    </div>
</section>

<?php 
include 'includes/footer.php'; 
?>