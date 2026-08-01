document.addEventListener('DOMContentLoaded', () => {

    /* ==============================================================
       1. CHỨC NĂNG GIỎ HÀNG VÀ WISHLIST (KẾT HỢP BACKEND & LOCALSTORAGE)
       ============================================================== */
    const cartBadges = document.querySelectorAll('.action-item .badge');
    
    // Lấy số lượng từ LocalStorage để đồng bộ UI ban đầu
    let storedCart = parseInt(localStorage.getItem('cartCount')) || 0;
    let storedWishlist = parseInt(localStorage.getItem('wishCount')) || 0;
    
    const updateBadgeUI = () => {
        // cartBadges[0] là Wishlist, cartBadges[1] là Cart
        if (cartBadges[0]) cartBadges[0].innerText = storedWishlist;
        if (cartBadges[1]) cartBadges[1].innerText = storedCart;
    };
    updateBadgeUI(); // Khởi tạo UI lần đầu

    // 1.1 Sự kiện bấm "Add to Cart" - GỌI API BACKEND THỰC TẾ
    const addCartBtns = document.querySelectorAll('.add-cart-btn');
    addCartBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault(); // Ngăn trình duyệt nhảy trang
            
            // Lấy ID sản phẩm từ nút wishlist bên cạnh hoặc trực tiếp từ nút bấm
            const productCard = btn.closest('.product-card');
            const wishlistBtn = productCard ? productCard.querySelector('.wishlist-btn') : null;
            const productId = wishlistBtn ? wishlistBtn.getAttribute('data-id') : btn.getAttribute('data-id');

            if (!productId) {
                alert('Không tìm thấy mã sản phẩm!');
                return;
            }

            // Gửi dữ liệu qua Fetch API tới file backend giỏ hàng
            fetch('/BanSach/Back_end/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'product_id=' + productId
            })
            .then(response => response.json())
            .then(data => {
                // Kiểm tra nếu chưa đăng nhập
                if (data.status === 'unauthorized') {
                    alert(data.message);
                    window.location.href = '/BanSach/Front_end/login.php';
                    return;
                }

                if (data.status === 'success') {
                    // Cập nhật số lượng giỏ hàng thực tế từ cơ sở dữ liệu trả về
                    storedCart = data.total_cart;
                    localStorage.setItem('cartCount', storedCart);
                    updateBadgeUI();
                    
                    alert('Đã thêm sản phẩm vào giỏ hàng thành công!');
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi khi thêm vào giỏ hàng:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            });
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
                // Kiểm tra nếu chưa đăng nhập
                if (data.status === 'unauthorized') {
                    alert(data.message);
                    window.location.href = '/BanSach/Front_end/login.php';
                    return;
                }

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