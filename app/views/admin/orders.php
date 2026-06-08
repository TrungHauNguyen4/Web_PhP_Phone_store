<?php
/**
 * View Admin Orders - Quản lý đơn hàng (Admin)
 * 
 * File này hiển thị danh sách đơn hàng cho admin với:
 * - Danh sách tất cả đơn hàng
 * - Cập nhật trạng thái đơn hàng
 * - Xem chi tiết đơn hàng
 * - Xóa đơn hàng (chỉ khi hoàn thành hoặc đã hủy)
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
require_once APP_PATH . '/models/Order.php';
require_once APP_PATH . '/models/Product.php';

// Kiểm tra quyền admin
if (!isAdmin()) {
    redirect(APP_URL . '/');
}

$orderModel = new Order();
$productModel = new Product();
?>

<h2 class="mb-4">📋 Quản lý đơn hàng</h2>

<div class="card">
    <div class="card-body">
        <?php
        $orders = $orderModel->getAll();
        if (empty($orders)):
        ?>
            <div class="alert alert-warning text-center py-4">⚠️ Hiện chưa có đơn hàng nào</div>
        <?php else: ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th class="text-end">Tổng tiền (VNĐ)</th>
                        <th class="text-center">Phương thức</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong>#<?php echo escape($order['id']); ?></strong></td>
                        <td><?php echo escape($order['user_id']); ?></td>
                        <td class="text-end">
                            <strong><?php echo number_format($order['total_amount'], 0, ',', '.'); ?></strong>
                        </td>
                        <td class="text-center">
                            Chuyển khoản
                        </td>
                        <td class="text-center">
                            <?php
                            $status_classes = [
                                'pending' => 'bg-warning text-dark',
                                'confirmed' => 'bg-info text-dark',
                                'shipped' => 'bg-primary',
                                'completed' => 'bg-success',
                                'cancelled' => 'bg-danger'
                            ];
                            $status_labels = [
                                'pending' => 'Chờ xác nhận',
                                'confirmed' => 'Đã xác nhận',
                                'shipped' => 'Đang giao',
                                'completed' => 'Hoàn thành',
                                'cancelled' => 'Đã hủy'
                            ];
                            $status = $order['status'];
                            $class = $status_classes[$status] ?? 'bg-secondary';
                            $label = $status_labels[$status] ?? $status;
                            ?>
                            <span class="badge <?php echo $class; ?>"><?php echo escape($label); ?></span>
                        </td>
                        <td class="text-center">
                            <?php
                            $date = new DateTime($order['created_at']);
                            echo escape($date->format('d/m/Y H:i'));
                            ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=orders&task=view&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary me-1">👁️ Xem</a>
                            <?php if ($order['status'] === 'completed' || $order['status'] === 'cancelled'): ?>
                                <form method="POST" action="<?php echo getBaseUrl(); ?>/?page=admin&action=orders" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác.');">
                                    <input type="hidden" name="delete_order" value="1">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Xóa</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php endif; ?>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
