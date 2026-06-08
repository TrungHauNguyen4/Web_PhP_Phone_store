<?php
/**
 * View Admin Order View - Chi tiết đơn hàng (Admin)
 * 
 * File này hiển thị chi tiết đơn hàng cho admin với:
 * - Thông tin đơn hàng (mã, tổng tiền, phương thức thanh toán, trạng thái, ngày tạo)
 * - Thông tin người mua
 * - Form cập nhật trạng thái đơn hàng
 * - Chi tiết sản phẩm trong đơn hàng
 * 
 * Dữ liệu được truyền từ AdminController:
 * - $order: Thông tin đơn hàng
 * - $user: Thông tin người mua
 * - $order_items: Chi tiết sản phẩm trong đơn hàng
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

<h2>📋 Chi tiết đơn hàng #<?php echo $order['id']; ?></h2>

<div style="background: white; padding: 2rem; border-radius: 8px; margin: 2rem 0;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div>
            <h3 style="margin-bottom: 1rem; color: #34495e;">Thông tin đơn hàng</h3>
            <table style="width: 100%;">
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 0.75rem 0; font-weight: bold; width: 150px;">Mã đơn hàng:</td>
                    <td style="padding: 0.75rem 0;">#<?php echo $order['id']; ?></td>
                </tr>
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 0.75rem 0; font-weight: bold;">Tổng tiền:</td>
                    <td style="padding: 0.75rem 0; color: #e74c3c; font-weight: bold;">
                        <?php echo number_format($order['total_amount'], 0, ',', '.'); ?> VNĐ
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 0.75rem 0; font-weight: bold;">Phương thức thanh toán:</td>
                    <td style="padding: 0.75rem 0;">
                        <?php
                        $paymentMethods = [
                            'transfer' => 'Chuyển khoản',
                            'cod' => 'Thanh toán khi nhận hàng',
                            'wallet' => 'Ví điện tử'
                        ];
                        echo $paymentMethods[$order['payment_method']] ?? $order['payment_method'];
                        ?>
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 0.75rem 0; font-weight: bold;">Trạng thái:</td>
                    <td style="padding: 0.75rem 0;">
                        <?php
                        $status_colors = [
                            'pending' => '#f39c12',
                            'confirmed' => '#3498db',
                            'shipped' => '#9b59b6',
                            'completed' => '#27ae60',
                            'cancelled' => '#e74c3c'
                        ];
                        $status_labels = [
                            'pending' => 'Chờ xác nhận',
                            'confirmed' => 'Đã xác nhận',
                            'shipped' => 'Đang giao',
                            'completed' => 'Hoàn thành',
                            'cancelled' => 'Đã hủy'
                        ];
                        $status = $order['status'];
                        $color = $status_colors[$status] ?? '#95a5a6';
                        $label = $status_labels[$status] ?? $status;
                        ?>
                        <span style="background: <?php echo $color; ?>; color: white; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.9rem;">
                            <?php echo $label; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem 0; font-weight: bold;">Ngày tạo:</td>
                    <td style="padding: 0.75rem 0;">
                        <?php 
                        $date = new DateTime($order['created_at']);
                        echo $date->format('d/m/Y H:i');
                        ?>
                    </td>
                </tr>
            </table>
        </div>
        
        <div>
            <h3 style="margin-bottom: 1rem; color: #34495e;">Thông tin người mua</h3>
            <table style="width: 100%;">
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 0.75rem 0; font-weight: bold; width: 150px;">Tên đăng nhập:</td>
                    <td style="padding: 0.75rem 0;"><?php echo escape($user['username']); ?></td>
                </tr>
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 0.75rem 0; font-weight: bold;">Họ tên:</td>
                    <td style="padding: 0.75rem 0;"><?php echo escape($user['fullname'] ?? 'Chưa cập nhật'); ?></td>
                </tr>
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 0.75rem 0; font-weight: bold;">Email:</td>
                    <td style="padding: 0.75rem 0;"><?php echo escape($user['email']); ?></td>
                </tr>
                <tr style="border-bottom: 1px solid #ecf0f1;">
                    <td style="padding: 0.75rem 0; font-weight: bold;">Số điện thoại:</td>
                    <td style="padding: 0.75rem 0;"><?php echo escape($user['phone'] ?? 'Chưa cập nhật'); ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem 0; font-weight: bold;">Địa chỉ:</td>
                    <td style="padding: 0.75rem 0;"><?php echo escape($user['address'] ?? 'Chưa cập nhật'); ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div style="margin-bottom: 2rem;">
        <h3 style="margin-bottom: 1rem; color: #34495e;">Cập nhật trạng thái</h3>
        <form method="POST" action="<?php echo getBaseUrl(); ?>/?page=admin&action=orders" style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; display: inline-block;">
            <div style="margin-bottom: 1rem;">
                <label for="status" style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Trạng thái mới:</label>
                <select id="status" name="status" style="width: 100%; padding: 0.75rem; border: 1px solid #bdc3c7; border-radius: 4px;">
                    <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                    <option value="confirmed" <?php echo $order['status'] === 'confirmed' ? 'selected' : ''; ?>>Đã xác nhận</option>
                    <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Đang giao</option>
                    <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                    <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                </select>
            </div>
            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
            <input type="hidden" name="update_status" value="1">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">Cập nhật</button>
        </form>
    </div>
    
    <h3 style="margin-bottom: 1rem; color: #34495e;">Sản phẩm trong đơn hàng</h3>
    <table style="width: 100%; border-collapse: collapse; background: white;">
        <thead style="background: #34495e; color: white;">
            <tr>
                <th style="padding: 1rem; text-align: left;">Sản phẩm</th>
                <th style="padding: 1rem; text-align: center;">Số lượng</th>
                <th style="padding: 1rem; text-align: right;">Đơn giá</th>
                <th style="padding: 1rem; text-align: right;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($order_items)): ?>
                <?php foreach ($order_items as $item): ?>
                    <tr style="border-bottom: 1px solid #ecf0f1;">
                        <td style="padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?php echo getBaseUrl(); ?>/assets/images/<?php echo escape($item['image']); ?>" 
                                         alt="<?php echo escape($item['name']); ?>" 
                                         style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                                <?php else: ?>
                                    <div style="width: 80px; height: 80px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #999;">
                                        No Image
                                    </div>
                                <?php endif; ?>
                                <div style="flex: 1;">
                                    <strong><?php echo escape($item['name']); ?></strong><br>
                                    <small style="color: #7f8c8d;">
                                        Hãng: <?php echo escape($item['brand'] ?? 'N/A'); ?><br>
                                        Chip: <?php echo escape($item['cpu'] ?? 'N/A'); ?><br>
                                        Bộ nhớ: <?php echo escape($item['bo_nho_trong'] ?? 'N/A'); ?> | Pin: <?php echo escape($item['pin'] ?? 'N/A'); ?>
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1rem; text-align: center;"><?php echo $item['quantity']; ?></td>
                        <td style="padding: 1rem; text-align: right;">
                            <?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ
                        </td>
                        <td style="padding: 1rem; text-align: right; font-weight: bold;">
                            <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #7f8c8d;">Không có sản phẩm nào</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 2rem;">
        <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=orders" class="btn btn-secondary" 
           style="display: inline-block; padding: 0.75rem 1.5rem; background: #95a5a6; color: white; text-decoration: none; border-radius: 4px;">
            ← Quay lại danh sách
        </a>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
