document.addEventListener('DOMContentLoaded', () => {

    /* ==============================================================
       1. CHỨC NĂNG GIỎ HÀNG VÀ WISHLIST (LƯU LOCALSTORAGE)
       ============================================================== */
    const cartBadges = document.querySelectorAll('.action-item .badge');
    
    // Lấy số lượng từ LocalStorage
    let storedCart = parseInt(localStorage.getItem('cartCount')) || 0;
    let storedWishlist = parseInt(localStorage.getItem('wishCount')) || 0;
    
    const updateBadgeUI = () => {
        // cartBadges[0] là Wishlist, cartBadges[1] là Cart
        if (cartBadges[0]) cartBadges[0].innerText = storedWishlist;
        if (cartBadges[1]) cartBadges[1].innerText = storedCart;
    };
    updateBadgeUI(); // Khởi tạo UI lần đầu

    // 1.1 Sự kiện bấm "Add to Cart"
    const addCartBtns = document.querySelectorAll('.add-cart-btn');
    addCartBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault(); // Ngăn trình duyệt nhảy trang nếu là thẻ <a>
            storedCart++;
            localStorage.setItem('cartCount', storedCart);
            updateBadgeUI();
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        });
    });

    // 1.2 Sự kiện bấm Tim (Wishlist)
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Kiểm tra xem nút này đã được bấm tim chưa (dựa vào class 'active')
            if (this.classList.contains('active')) {
                // Nếu đã tim -> Bỏ tim
                this.classList.remove('active');
                
                // Đổi icon lại thành viền rỗng
                const icon = this.querySelector('i');
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');

                // Giảm số lượng
                if(storedWishlist > 0) storedWishlist--;
            } else {
                // Nếu chưa tim -> Thả tim
                this.classList.add('active');
                
                // Đổi icon thành khối đặc
                const icon = this.querySelector('i');
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');

                // Tăng số lượng
                storedWishlist++;
            }
            
            // Lưu lại vào trình duyệt và cập nhật UI
            localStorage.setItem('wishCount', storedWishlist);
            updateBadgeUI();
        });
    });


    /* ==============================================================
       2. TÍNH NĂNG SẮP XẾP SẢN PHẨM THEO GIÁ (TRANG SẢN PHẨM)
       ============================================================== */
    const sortSelect = document.getElementById('sortSelect');
    const productGrid = document.querySelector('.product-grid-full') || document.querySelector('.product-grid');

    if (sortSelect && productGrid) {
        sortSelect.addEventListener('change', function() {
            const sortType = this.value;
            const products = Array.from(productGrid.querySelectorAll('.product-card'));

            products.sort((a, b) => {
                const priceTextA = a.querySelector('.current-price').innerText;
                const priceTextB = b.querySelector('.current-price').innerText;

                const priceA = parseInt(priceTextA.replace(/\./g, '').replace('đ', ''));
                const priceB = parseInt(priceTextB.replace(/\./g, '').replace('đ', ''));

                if (sortType === 'price-low') {
                    return priceA - priceB;
                } else if (sortType === 'price-high') {
                    return priceB - priceA;
                }
                return 0;
            });

            productGrid.innerHTML = '';
            products.forEach(product => {
                productGrid.appendChild(product);
            });
        });
    }

    /* ==============================================================
       3. TÍNH NĂNG COUNTDOWN FLASH SALE (TRANG CHỦ INDEX)
       ============================================================== */
    const updateCountdown = () => {
        const secs = document.getElementById('secs');
        if (!secs) return;

        let currentSec = parseInt(secs.innerText);
        if (currentSec > 0) {
            secs.innerText = String(currentSec - 1).padStart(2, '0');
        } else {
            secs.innerText = '59';
        }
    };
    setInterval(updateCountdown, 1000);

});