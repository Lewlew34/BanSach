<?php
include 'includes/header.php';
?>

<div class="container" style="max-width: 500px; margin: 50px auto; background: #fff; padding: 30px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
    
    <!-- Tab chuyển đổi Đăng nhập / Đăng ký -->
    <div style="display: flex; margin-bottom: 25px; border-bottom: 2px solid #f1f5f9;">
        <button id="tabLoginBtn" style="flex: 1; padding: 10px; background: none; border: none; font-weight: bold; font-size: 16px; cursor: pointer; color: var(--primary-color); border-bottom: 2px solid var(--primary-color);">Đăng Nhập</button>
        <button id="tabRegisterBtn" style="flex: 1; padding: 10px; background: none; border: none; font-weight: bold; font-size: 16px; cursor: pointer; color: var(--text-gray);">Đăng Ký</button>
    </div>

    <!-- Form Đăng Nhập -->
    <form id="loginForm">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
            <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;">
        </div>
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Mật khẩu</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;">
        </div>
        <button type="submit" style="width: 100%; padding: 12px; background: var(--primary-color); color: #fff; border: none; border-radius: var(--radius-sm); font-weight: bold; cursor: pointer;">ĐĂNG NHẬP</button>
    </form>

    <!-- Form Đăng Ký (Ẩn mặc định) -->
    <form id="registerForm" style="display: none;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Họ và tên</label>
            <input type="text" name="fullname" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
            <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;">
        </div>
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Mật khẩu</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); outline: none;">
        </div>
        <button type="submit" style="width: 100%; padding: 12px; background: var(--primary-color); color: #fff; border: none; border-radius: var(--radius-sm); font-weight: bold; cursor: pointer;">ĐĂNG KÝ TÀI KHOẢN</button>
    </form>

</div>

<script>
// Xử lý chuyển tab qua lại giữa Đăng nhập và Đăng ký
const tabLoginBtn = document.getElementById('tabLoginBtn');
const tabRegisterBtn = document.getElementById('tabRegisterBtn');
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');

tabLoginBtn.addEventListener('click', () => {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
    tabLoginBtn.style.color = 'var(--primary-color)';
    tabLoginBtn.style.borderBottom = '2px solid var(--primary-color)';
    tabRegisterBtn.style.color = 'var(--text-gray)';
    tabRegisterBtn.style.borderBottom = 'none';
});

tabRegisterBtn.addEventListener('click', () => {
    registerForm.style.display = 'block';
    loginForm.style.display = 'none';
    tabRegisterBtn.style.color = 'var(--primary-color)';
    tabRegisterBtn.style.borderBottom = '2px solid var(--primary-color)';
    tabLoginBtn.style.color = 'var(--text-gray)';
    tabLoginBtn.style.borderBottom = 'none';
});

// Xử lý Ajax Đăng nhập
loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new URLSearchParams(new FormData(this));
    formData.append('action', 'login');

    fetch('/BanSach/Back_end/auth_process.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Đăng nhập thành công!');
            window.location.href = 'index.php';
        } else {
            alert(data.message);
        }
    });
});

// Xử lý Ajax Đăng ký
registerForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new URLSearchParams(new FormData(this));
    formData.append('action', 'register');

    fetch('/BanSach/Back_end/auth_process.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === 'success') {
            location.reload();
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>