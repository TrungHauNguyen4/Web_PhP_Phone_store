<?php
/**
 * View Orders - Danh sách đơn hàng của user
 * 
 * File này hiển thị danh sách đơn hàng của người dùng với:
 * - Danh sách đơn hàng với trạng thái
 * - Chi tiết đơn hàng (collapsible)
 * - Thông tin giao hàng
 * - Chi tiết sản phẩm trong đơn hàng
 * 
 * Dữ liệu được truyền từ OrderController:
 * - $orders: Mảng các đơn hàng của user
 * - $user: Thông tin user hiện tại
 * - $orderModel: Order model để lấy chi tiết đơn hàng
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
    <h1 class="mb-4">Đơn hàng của tôi</h1>

    <?php if (empty($orders)): ?>
        <div class="card text-center">
            <div class="card-body py-5">
                <p class="mb-4">Bạn chưa có đơn hàng nào</p>
                <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-primary">→ Mua sắm ngay</a>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VNĐ</td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch ($order['status']) {
                                            case 'pending':
                                                $statusClass = 'bg-warning text-dark';
                                                $statusText = 'Chờ xử lý';
                                                break;
                                            case 'processing':
                                                $statusClass = 'bg-info text-dark';
                                                $statusText = 'Đang xử lý';
                                                break;
                                            case 'shipped':
                                                $statusClass = 'bg-primary';
                                                $statusText = 'Đang giao';
                                                break;
                                            case 'completed':
                                                $statusClass = 'bg-success';
                                                $statusText = 'Hoàn thành';
                                                break;
                                            case 'cancelled':
                                                $statusClass = 'bg-danger';
                                                $statusText = 'Đã hủy';
                                                break;
                                            default:
                                                $statusClass = 'bg-secondary';
                                                $statusText = $order['status'];
                                        }
                                        ?>
                                        <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#order-details-<?php echo $order['id']; ?>">
                                            Xem chi tiết
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="p-0">
                                        <div class="collapse" id="order-details-<?php echo $order['id']; ?>">
                                            <div class="p-3 bg-light">
                                                <?php
                                                $orderDetails = $orderModel->getOrderDetails($order['id']);
                                                if (!empty($orderDetails)):
                                                ?>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <h6 class="fw-bold mb-2">Thông tin đơn hàng</h6>
                                                            <table class="table table-sm mb-0">
                                                                <tr>
                                                                    <td style="width: 120px;">Mã đơn:</td>
                                                                    <td>#<?php echo $order['id']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Ngày đặt:</td>
                                                                    <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Phương thức thanh toán:</td>
                                                                    <td>
                                                                        <?php
                                                                        $paymentMethods = [
                                                                            'transfer' => 'Chuyển khoản',
                                                                            'cod' => 'Thanh toán khi nhận hàng',
                                                                            'wallet' => 'Ví điện tử'
                                                                        ];
                                                                        $paymentMethod = $order['payment_method'] ?? 'transfer';
                                                                        echo $paymentMethods[$paymentMethod] ?? $paymentMethod;
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="fw-bold mb-2">Thông tin giao hàng</h6>
                                                            <table class="table table-sm mb-0">
                                                                <tr>
                                                                    <td style="width: 120px;">Người nhận:</td>
                                                                    <td><?php echo escape($order['shipping_fullname'] ?? $user['fullname'] ?? $user['username']); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Số điện thoại:</td>
                                                                    <td><?php echo escape($order['shipping_phone'] ?? $user['phone'] ?? 'Chưa cập nhật'); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Địa chỉ:</td>
                                                                    <td><?php echo escape($order['shipping_address'] ?? $user['address'] ?? 'Chưa cập nhật'); ?></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h6 class="fw-bold mb-2">Chi tiết sản phẩm</h6>
                                                    <table class="table table-sm mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Sản phẩm</th>
                                                                <th class="text-center">Số lượng</th>
                                                                <th class="text-end">Đơn giá</th>
                                                                <th class="text-end">Thành tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($orderDetails as $item): ?>
                                                                <tr>
                                                                    <td>
                                                                        <strong><?php echo escape($item['name']); ?></strong>
                                                                        <?php if (!empty($item['image'])): ?>
                                                                            <br><img src="<?php echo getBaseUrl(); ?>/assets/images/<?php echo escape($item['image']); ?>" 
                                                                                   alt="<?php echo escape($item['name']); ?>" 
                                                                                   style="max-width: 60px; max-height: 60px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
                                                                        <?php endif; ?>
                                                                        <?php if (!empty($item['cpu']) || !empty($item['bo_nho_trong']) || !empty($item['pin'])): ?>
                                                                            <br><small class="text-muted">
                                                                                CPU: <?php echo escape($item['cpu'] ?? '-'); ?> |
                                                                                Bộ nhớ: <?php echo escape($item['bo_nho_trong'] ?? '-'); ?> |
                                                                                Pin: <?php echo escape($item['pin'] ?? '-'); ?>
                                                                            </small>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                                                    <td class="text-end"><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                                                    <td class="text-end fw-bold"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ</td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            <tr class="table-light">
                                                                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                                                                <td class="text-end fw-bold text-primary"><?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VNĐ</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                <?php else: ?>
                                                    <p>Không có chi tiết đơn hàng</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
