<?php
/**
 * View Admin Statistics - Thống kê (Admin)
 * 
 * File này hiển thị thống kê cho admin với:
 * - Tổng quan (sản phẩm, người dùng, đơn hàng, doanh thu)
 * - Phân bố sản phẩm (có sẵn, hết hàng)
 * - Phân bố người dùng (admin, user)
 */

include APP_PATH . '/views/layouts/header.php';
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/Order.php';
require_once APP_PATH . '/models/User.php';

// Kiểm tra quyền admin
if (!isAdmin()) {
    redirect(APP_URL . '/');
}

$productModel = new Product();
$userModel = new User();
$orderModel = new Order();

// Lấy dữ liệu thống kê
$allProducts = $productModel->getAll();
$allUsers = $userModel->getAll();
$allOrders = $orderModel->getAll();

$totalProducts = count($allProducts);
$totalUsers = count($allUsers);
$totalOrders = count($allOrders);

// Tính tổng doanh thu
$totalRevenue = 0;
foreach ($allOrders as $order) {
    $totalRevenue += $order['total_amount'];
}
?>

<h2>📊 Thống kê</h2>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem; border-radius: 8px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 1rem 0; font-size: 2rem;">📦</h3>
        <h2 style="margin: 0; font-size: 2.5rem;"><?php echo $totalProducts; ?></h2>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Tổng sản phẩm</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 2rem; border-radius: 8px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 1rem 0; font-size: 2rem;">👥</h3>
        <h2 style="margin: 0; font-size: 2.5rem;"><?php echo $totalUsers; ?></h2>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Tổng người dùng</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 2rem; border-radius: 8px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 1rem 0; font-size: 2rem;">0</h3>
        <h2 style="margin: 0; font-size: 2.5rem;"><?php echo $totalOrders; ?></h2>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Tổng đơn hàng</p>
    </div>
    
    <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 2rem; border-radius: 8px; color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 1rem 0; font-size: 2rem;">💰</h3>
        <h2 style="margin: 0; font-size: 2.5rem;"><?php echo number_format($totalRevenue, 0, ',', '.'); ?> VNĐ</h2>
        <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Tổng doanh thu</p>
    </div>
</div>

<div style="background: white; padding: 2rem; border-radius: 8px; margin: 2rem 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h3 style="margin-top: 0; border-bottom: 2px solid #ecf0f1; padding-bottom: 1rem;">📈 Phân bố sản phẩm</h3>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #f8f9fa; border-bottom: 2px solid #ddd;">
            <tr>
                <th style="padding: 1rem; text-align: left;">Tiêu chí</th>
                <th style="padding: 1rem; text-align: right;">Số lượng</th>
                <th style="padding: 1rem; text-align: right;">Phần trăm</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid #ecf0f1;">
                <td style="padding: 1rem;">Sản phẩm có sẵn</td>
                <td style="padding: 1rem; text-align: right; font-weight: bold;">
                    <?php echo count(array_filter($allProducts, fn($p) => $p['quantity'] > 0)); ?>
                </td>
                <td style="padding: 1rem; text-align: right;">
                    <?php echo $totalProducts > 0 ? round(count(array_filter($allProducts, fn($p) => $p['quantity'] > 0)) / $totalProducts * 100) : 0; ?>%
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #ecf0f1;">
                <td style="padding: 1rem;">Sản phẩm hết hàng</td>
                <td style="padding: 1rem; text-align: right; font-weight: bold;">
                    <?php echo count(array_filter($allProducts, fn($p) => $p['quantity'] === 0)); ?>
                </td>
                <td style="padding: 1rem; text-align: right;">
                    <?php echo $totalProducts > 0 ? round(count(array_filter($allProducts, fn($p) => $p['quantity'] === 0)) / $totalProducts * 100) : 0; ?>%
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <h3 style="margin-top: 0; border-bottom: 2px solid #ecf0f1; padding-bottom: 1rem;">👥 Phân bố người dùng</h3>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background: #f8f9fa; border-bottom: 2px solid #ddd;">
            <tr>
                <th style="padding: 1rem; text-align: left;">Loại</th>
                <th style="padding: 1rem; text-align: right;">Số lượng</th>
                <th style="padding: 1rem; text-align: right;">Phần trăm</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid #ecf0f1;">
                <td style="padding: 1rem;">👑 Admin</td>
                <td style="padding: 1rem; text-align: right; font-weight: bold;">
                    <?php echo count(array_filter($allUsers, fn($u) => $u['role'] === 'admin')); ?>
                </td>
                <td style="padding: 1rem; text-align: right;">
                    <?php echo $totalUsers > 0 ? round(count(array_filter($allUsers, fn($u) => $u['role'] === 'admin')) / $totalUsers * 100) : 0; ?>%
                </td>
            </tr>
            <tr>
                <td style="padding: 1rem;">👤 User</td>
                <td style="padding: 1rem; text-align: right; font-weight: bold;">
                    <?php echo count(array_filter($allUsers, fn($u) => $u['role'] === 'user')); ?>
                </td>
                <td style="padding: 1rem; text-align: right;">
                    <?php echo $totalUsers > 0 ? round(count(array_filter($allUsers, fn($u) => $u['role'] === 'user')) / $totalUsers * 100) : 0; ?>%
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
