<?php
/**
 * View Admin User Edit - Chỉnh sửa thông tin người dùng (Admin)
 * 
 * File này hiển thị form chỉnh sửa thông tin người dùng cho admin với:
 * - Hiển thị thông tin cơ bản của user
 * - Cập nhật thông tin (fullname, phone, address)
 * 
 * Dữ liệu được truyền từ AdminController:
 * - $user: Thông tin người dùng
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

<h2>✏️ Chỉnh sửa thông tin người dùng</h2>

<div style="background: white; padding: 2rem; border-radius: 8px; margin: 2rem 0; max-width: 600px;">
    <div style="margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1rem; color: #34495e;">Thông tin cơ bản</h3>
        <table style="width: 100%;">
            <tr style="border-bottom: 1px solid #ecf0f1;">
                <td style="padding: 0.75rem 0; font-weight: bold; width: 150px;">ID:</td>
                <td style="padding: 0.75rem 0;"><?php echo $user['id']; ?></td>
            </tr>
            <tr style="border-bottom: 1px solid #ecf0f1;">
                <td style="padding: 0.75rem 0; font-weight: bold;">Tên đăng nhập:</td>
                <td style="padding: 0.75rem 0;"><?php echo escape($user['username']); ?></td>
            </tr>
            <tr style="border-bottom: 1px solid #ecf0f1;">
                <td style="padding: 0.75rem 0; font-weight: bold;">Email:</td>
                <td style="padding: 0.75rem 0;"><?php echo escape($user['email']); ?></td>
            </tr>
            <tr>
                <td style="padding: 0.75rem 0; font-weight: bold;">Vai trò:</td>
                <td style="padding: 0.75rem 0;">
                    <span style="background: <?php echo $user['role'] === 'admin' ? '#cfe2ff' : '#e7d4f5'; ?>; padding: 0.5rem 1rem; border-radius: 4px; font-size: 0.9rem;">
                        <?php echo $user['role'] === 'admin' ? '👑 Admin' : '👤 User'; ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
    
    <form method="POST" style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px;">
        <h3 style="margin-top: 0; margin-bottom: 1rem; color: #34495e;">Cập nhật thông tin</h3>
        
        <div style="margin-bottom: 1rem;">
            <label for="fullname" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Họ tên:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo escape($user['fullname'] ?? ''); ?>" 
                   style="width: 100%; padding: 0.75rem; border: 1px solid #bdc3c7; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Số điện thoại:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo escape($user['phone'] ?? ''); ?>" 
                   placeholder="09xxxxxxxxx" pattern="[0-9]{9,11}" title="Số điện thoại phải từ 9-11 chữ số"
                   style="width: 100%; padding: 0.75rem; border: 1px solid #bdc3c7; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label for="address" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Địa chỉ:</label>
            <textarea id="address" name="address" rows="3"
                      style="width: 100%; padding: 0.75rem; border: 1px solid #bdc3c7; border-radius: 4px; font-family: inherit;"><?php echo escape($user['address'] ?? ''); ?></textarea>
        </div>
        
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" name="update_user" class="btn btn-primary" 
                    style="flex: 1; padding: 0.75rem; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                💾 Lưu thay đổi
            </button>
            <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=users" 
               style="flex: 1; padding: 0.75rem; background: #95a5a6; color: white; text-decoration: none; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                ← Hủy
            </a>
        </div>
    </form>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
