<?php
/**
 * View Register - Trang đăng ký
 * 
 * File này hiển thị form đăng ký với:
 * - Input tên đăng nhập
 * - Input email
 * - Input mật khẩu
 * - Input xác nhận mật khẩu
 * - Link đến trang đăng nhập
 */

include APP_PATH . '/views/layouts/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Đăng ký</h2>

                    <!-- Form đăng ký -->
                    <form method="POST" action="#">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', this)">
                                    👁️
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirm', this)">
                                    👁️
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg">Đăng ký</button>
                    </form>

                    <!-- Link đến trang đăng nhập -->
                    <p class="text-center mt-4 mb-0">
                        Đã có tài khoản?
                        <a href="<?php echo getBaseUrl(); ?>/?page=auth&action=login" class="fw-bold">Đăng nhập tại đây</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
