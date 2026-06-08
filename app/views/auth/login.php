<?php
/**
 * View Login - Trang đăng nhập
 * 
 * File này hiển thị form đăng nhập với:
 * - Input tên đăng nhập
 * - Input mật khẩu
 * - Link đến trang đăng ký
 */

include APP_PATH . '/views/layouts/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Đăng nhập</h2>

                    <!-- Form đăng nhập -->
                    <form id="loginForm" method="POST" action="<?php echo getBaseUrl(); ?>/?page=auth&action=login">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">Đăng nhập</button>
                    </form>

                    <!-- Link đến trang đăng ký -->
                    <p class="text-center mt-4 mb-0">
                        Chưa có tài khoản?
                        <a href="<?php echo getBaseUrl(); ?>/?page=auth&action=register" class="fw-bold">Đăng ký tại đây</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
