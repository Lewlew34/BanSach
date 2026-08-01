document.addEventListener('DOMContentLoaded', () => {

    /* ==============================================================
       1. CHỨC NĂNG GIỎ HÀNG VÀ WISHLIST (KẾT HỢP BACKEND & LOCALSTORAGE)
       ============================================================== */
    const cartBadges = document.querySelectorAll('.action-item .badge');
    
    // Lấy số lượng từ LocalStorage (Giỏ hàng vẫn lưu tạm, Wishlist sẽ đồng bộ UI)
    let storedCart = parseInt(localStorage.getItem('cartCount')) || 0;
    let storedWishlist = parseInt(localStorage.getItem('wishCount')) || 0;
    
    const updateBadgeUI = () => {
        // cartBadges[0] là Wishlist, cartBadges[1] là Cart
        if (cartBadges[0]) cartBadges[0].innerText = storedWishlist;
        if (cartBadges[1]) cartBadges[1].innerText = storedCart;
    };
    updateBadgeUI(); // Khởi tạo UI lần đầu

    // 1.1 Sự kiện bấm "Add to Cart" (Tạm lưu LocalStorage)
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

    // 1.2 Sự kiện bấm Tim (Wishlist) - GỌI API BACKEND THỰC TẾ
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-id');
            const icon = this.querySelector('i');

            if (!productId) {
                console.error('Lỗi: Nút này chưa được gắn data-id của sản phẩm!');
                return;
            }

            // Gửi dữ liệu qua AJAX (Fetch API) tới thư mục Back_end
            fetch('/BanSach/Back_end/toggle_wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'product_id=' + productId
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    // Trạng thái: Đã thêm -> Đổi thành tim đỏ đặc
                    this.classList.add('active');
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    icon.style.color = '#e11d48';

                    // Tăng số lượng UI
                    storedWishlist++;
                } 
                else if (data.status === 'removed') {
                    // Trạng thái: Đã xóa -> Đổi lại thành tim rỗng
                    this.classList.remove('active');
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    icon.style.color = '';

                    // Giảm số lượng UI
                    if(storedWishlist > 0) storedWishlist--;
                }
                
                // Lưu trạng thái số lượng mới vào LocalStorage và cập nhật Badge
                localStorage.setItem('wishCount', storedWishlist);
                updateBadgeUI();
            })
            .catch(error => {
                console.error('Lỗi khi gọi API Wishlist:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại sau!');
            });
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