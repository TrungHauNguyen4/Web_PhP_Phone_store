<?php
/**
 * View Admin Product Form - Form thêm/sửa sản phẩm (Admin)
 *
 * File này hiển thị form để thêm hoặc sửa sản phẩm với:
 * - Upload ảnh sản phẩm
 * - Nhập thông tin sản phẩm (tên, hãng, giá, số lượng, mô tả)
 *
 * Dữ liệu được truyền từ AdminController:
 * - $task: 'add' hoặc 'edit'
 * - $product: Thông tin sản phẩm (nếu đang sửa)
 * - $errors: Mảng lỗi validate (nếu có)
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

$title = $task === 'add' ? 'Thêm sản phẩm mới' : 'Sửa sản phẩm';
?>

<h2><?php echo $title; ?></h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error" style="margin: 1.5rem 0;">
        <ul style="margin: 0; padding-left: 1.5rem;">
            <?php foreach ($errors as $error): ?>
                <li><?php echo escape($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div style="background: white; padding: 2rem; border-radius: 8px; max-width: 600px;">
    <form method="POST" enctype="multipart/form-data" style="display: grid; gap: 1.5rem;">
        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">📱 Tên sản phẩm *</label>
            <input type="text" name="name" value="<?php echo escape($product['name'] ?? ''); ?>"
                   required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">🏢 Hãng</label>
            <input type="text" name="brand" value="<?php echo escape($product['brand'] ?? ''); ?>"
                   placeholder="Apple, Samsung, Xiaomi..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">⚙️ Chip</label>
                <input type="text" name="cpu" value="<?php echo escape($product['cpu'] ?? ''); ?>"
                       placeholder="A17 Pro, Snapdragon..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">💾 Bộ nhớ trong</label>
                <input type="text" name="bo_nho_trong" value="<?php echo escape($product['bo_nho_trong'] ?? ''); ?>"
                       placeholder="128GB, 256GB..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">🔋 Pin</label>
                <input type="text" name="pin" value="<?php echo escape($product['pin'] ?? ''); ?>"
                       placeholder="4000 mAh, 5000 mAh..." style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
        </div>

        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">🖼️ Ảnh sản phẩm</label>
            <input type="file" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                   style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            <small style="color: #666; font-size: 0.85rem;">Chấp nhận: JPG, JPEG, PNG, GIF, WEBP (tối đa 5MB)</small>
            <?php if ($task === 'edit' && !empty($product['image'])): ?>
                <div style="margin-top: 0.5rem;">
                    <small style="color: #666;">Ảnh hiện tại:</small><br>
                    <img src="<?php echo getBaseUrl(); ?>/assets/images/<?php echo escape($product['image']); ?>"
                         alt="<?php echo escape($product['name']); ?>"
                         style="max-width: 150px; max-height: 150px; margin-top: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            <?php endif; ?>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">💰 Giá (VNĐ) *</label>
                <input type="number" name="price" value="<?php echo escape($product['price'] ?? ''); ?>" 
                       required min="0" step="1000" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">📦 Số lượng *</label>
                <input type="number" name="quantity" value="<?php echo escape($product['quantity'] ?? '0'); ?>" 
                       required min="0" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>
        </div>

        <div>
            <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">📝 Mô tả</label>
            <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; font-family: inherit;"><?php echo escape($product['description'] ?? ''); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <button type="submit" style="padding: 0.75rem; background: #27ae60; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold;">
                <?php echo $task === 'add' ? '✅ Thêm sản phẩm' : '✅ Cập nhật sản phẩm'; ?>
            </button>
            <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=products" 
               style="padding: 0.75rem; background: #95a5a6; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold; text-decoration: none; text-align: center; display: inline-block;">
                ← Quay lại
            </a>
        </div>
    </form>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
