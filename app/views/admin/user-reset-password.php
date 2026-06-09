<?php require_once APP_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">🔐 Đặt lại mật khẩu</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo escape($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <div class="alert alert-info">
                        <strong>Người dùng:</strong> <?php echo escape($user['username']); ?> (<?php echo escape($user['fullname']); ?>)
                    </div>
                    
                    <form method="POST" action="<?php echo getBaseUrl(); ?>/?page=admin&action=users">
                        <input type="hidden" name="user_id" value="<?php echo escape($user['id']); ?>">
                        <input type="hidden" name="reset_password" value="1">
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" 
                                       required minlength="6" placeholder="Nhập mật khẩu mới (ít nhất 6 ký tự)">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password', this)">
                                    👁️
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                       required minlength="6" placeholder="Nhập lại mật khẩu mới">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password', this)">
                                    👁️
                                </button>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                🔐 Đặt lại mật khẩu
                            </button>
                            <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=users" class="btn btn-secondary">
                                ← Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validate password confirmation
document.querySelector('form').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Mật khẩu xác nhận không khớp!');
    }
});
</script>

<?php require_once APP_PATH . '/views/layouts/footer.php'; ?>
