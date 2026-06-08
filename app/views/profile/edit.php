<?php
/**
 * View Profile Edit - Chỉnh sửa thông tin cá nhân
 * 
 * File này hiển thị form chỉnh sửa thông tin cá nhân với:
 * - Cập nhật thông tin cơ bản (họ tên, email, phone, address)
 * - Đổi mật khẩu (tùy chọn)
 * 
 * Dữ liệu được truyền từ UserController:
 * - $user: Thông tin user hiện tại
 * - $errors: Mảng lỗi validate (nếu có)
 * - $success: Biến flag nếu cập nhật thành công
 */

// Kiểm tra tính hợp lệ của session trước khi include header
if (isLoggedIn()) {
    // Regenerate session ID để ngăn chặn session fixation
    if (!isset($_SESSION['regenerated'])) {
        session_regenerate_id(true);
        $_SESSION['regenerated'] = true;
    }
}

include APP_PATH . '/views/layouts/header.php';
?>

<div class="container">
    <h1 class="mb-4">Chỉnh sửa thông tin cá nhân</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p class="mb-1"><?php echo escape($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input type="text" id="username" value="<?php echo escape($user['username']); ?>" class="form-control" disabled
                           style="background-color: #e9ecef; cursor: not-allowed;">
                    <small class="text-muted">Không thể thay đổi tên đăng nhập</small>
                </div>

                <div class="mb-3">
                    <label for="fullname" class="form-label">Họ tên *</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo escape($user['fullname'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo escape($user['email']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo escape($user['phone'] ?? ''); ?>" 
                           pattern="[0-9]{9,11}" title="Số điện thoại phải từ 9-11 chữ số">
                    <small class="text-muted">Chỉ được nhập số (9-11 chữ số)</small>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ</label>
                    <textarea id="address" name="address" class="form-control" rows="3"><?php echo escape($user['address'] ?? ''); ?></textarea>
                </div>

                <hr class="my-4">

                <h4 class="mb-3">Đổi mật khẩu</h4>
                <p class="text-muted mb-3">Để trống nếu không muốn đổi mật khẩu</p>

                <div class="mb-3">
                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                    <input type="password" id="current_password" name="current_password" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" minlength="6">
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" minlength="6">
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="<?php echo getBaseUrl(); ?>/?page=home" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
