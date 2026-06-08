<?php
/**
 * View Admin Products - Quản lý sản phẩm (Admin)
 * 
 * File này hiển thị danh sách sản phẩm cho admin với:
 * - Danh sách tất cả sản phẩm (bao gồm hết hàng)
 * - Thêm sản phẩm mới
 * - Sửa sản phẩm
 * - Xóa sản phẩm
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
require_once APP_PATH . '/models/Product.php';

// Kiểm tra quyền admin
if (!isAdmin()) {
    redirect(APP_URL . '/');
}

$productModel = new Product();
$products = $productModel->getAllIncludingSoldOut();
?>

<h2 class="mb-4">📦 Quản lý sản phẩm</h2>

<div class="mb-4">
    <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=products&task=add" class="btn btn-success">+ Thêm sản phẩm mới</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th class="text-center">Hãng</th>
                        <th class="text-center">Giá (VNĐ)</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><strong><?php echo escape($product['name']); ?></strong></td>
                            <td class="text-center"><?php echo escape($product['brand'] ?? 'N/A'); ?></td>
                            <td class="text-center"><?php echo formatPrice($product['price']); ?></td>
                            <td class="text-center">
                                <span class="badge <?php echo $product['quantity'] > 0 ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $product['quantity']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=products&task=edit&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary me-1">✏️ Sửa</a>
                                <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=products&task=delete&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa?');">🗑️ Xóa</a>
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
