document.addEventListener('DOMContentLoaded', () => {

    /* ==============================================================
       1. CHỨC NĂNG GIỎ HÀNG (DÙNG CHUNG BẰNG LOCALSTORAGE)
       ============================================================== */
    const cartBadges = document.querySelectorAll('.action-item .badge');
    
    // Lấy số lượng giỏ hàng hiện tại từ LocalStorage để đồng bộ giữa các trang
    let storedCart = parseInt(localStorage.getItem('cartCount')) || 0;
    
    const updateBadgeUI = () => {
        // Có 2 badge (Wishlist và Cart), badge Cart ở vị trí index 1
        if (cartBadges[1]) {
            cartBadges[1].innerText = storedCart;
        }
    };
    updateBadgeUI(); // Khởi tạo UI lần đầu

    // Sự kiện bấm "Add to Cart"
    const addCartBtns = document.querySelectorAll('.add-cart-btn');
    addCartBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            storedCart++;
            localStorage.setItem('cartCount', storedCart); // Lưu vào bộ nhớ trình duyệt
            updateBadgeUI();
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        });
    });


    /* ==============================================================
       2. TÍNH NĂNG SẮP XẾP SẢN PHẨM THEO GIÁ (TRANG BOOKS)
       ============================================================== */
    const sortSelect = document.getElementById('sortSelect');
    // Hỗ trợ cả 2 layout: trang có sidebar (product-grid) và trang full (product-grid-full)
    const productGrid = document.querySelector('.product-grid-full') || document.querySelector('.product-grid');

    if (sortSelect && productGrid) {
        sortSelect.addEventListener('change', function() {
            const sortType = this.value;
            
            // Lấy tất cả các thẻ sản phẩm (.product-card) hiện có thành 1 mảng
            const products = Array.from(productGrid.querySelectorAll('.product-card'));

            // Sắp xếp mảng products
            products.sort((a, b) => {
                // Lấy chuỗi giá tiền (VD: "135.000đ")
                const priceTextA = a.querySelector('.current-price').innerText;
                const priceTextB = b.querySelector('.current-price').innerText;

                // Chuyển chuỗi "135.000đ" thành số nguyên 135000 để so sánh
                const priceA = parseInt(priceTextA.replace(/\./g, '').replace('đ', ''));
                const priceB = parseInt(priceTextB.replace(/\./g, '').replace('đ', ''));

                if (sortType === 'price-low') {
                    return priceA - priceB; // Giá thấp -> cao
                } else if (sortType === 'price-high') {
                    return priceB - priceA; // Giá cao -> thấp
                }
                return 0; // Default
            });

            // Xóa rỗng lưới sản phẩm cũ trên màn hình
            productGrid.innerHTML = '';

            // Đổ lại các sản phẩm đã được sắp xếp vào lưới
            products.forEach(product => {
                productGrid.appendChild(product);
            });
        });
    }

    /* ==============================================================
       3. TÍNH NĂNG COUNTDOWN FLASH SALE (CHO TRANG CHỦ INDEX)
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