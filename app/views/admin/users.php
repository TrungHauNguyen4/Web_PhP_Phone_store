<?php
/**
 * View Admin Users - Quản lý người dùng (Admin)
 * 
 * File này hiển thị danh sách người dùng cho admin với:
 * - Danh sách tất cả người dùng
 * - Thông tin user (username, email, fullname, role)
 * - Sửa thông tin user
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
require_once APP_PATH . '/models/User.php';

// Kiểm tra quyền admin
if (!isAdmin()) {
    redirect(APP_URL . '/');
}

$userModel = new User();
$users = $userModel->getAll();
?>

<h2 class="mb-4">👥 Quản lý người dùng</h2>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Họ tên</th>
                        <th class="text-center">Vai trò</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><strong><?php echo escape($user['username']); ?></strong></td>
                            <td><?php echo escape($user['email']); ?></td>
                            <td><?php echo escape($user['fullname'] ?? 'N/A'); ?></td>
                            <td class="text-center">
                                <span class="badge <?php echo $user['role'] === 'admin' ? 'bg-primary' : 'bg-secondary'; ?>">
                                    <?php echo $user['role'] === 'admin' ? '👑 Admin' : '👤 User'; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php echo isset($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : 'N/A'; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                    <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=users&task=edit&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-primary me-1">✏️ Sửa</a>
                                    <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=users&task=reset_password&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-warning me-1">🔐 Reset mật khẩu</a>
                                    <form method="POST" action="<?php echo getBaseUrl(); ?>/?page=admin&action=users" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác.');">
                                        <input type="hidden" name="delete_user" value="1">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Xóa</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
