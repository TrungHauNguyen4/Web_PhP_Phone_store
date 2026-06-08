<?php
/**
 * View Admin Dashboard - Bảng điều khiển Admin
 * 
 * File này hiển thị dashboard admin với:
 * - Thống kê tổng quan (đơn hàng, doanh thu, sản phẩm, người dùng)
 * - Các shortcut đến các trang quản lý
 * - Tổng quan hoạt động của hệ thống
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
require_once APP_PATH . '/models/Order.php';
require_once APP_PATH . '/models/User.php';

// Kiểm tra quyền admin
if (!isAdmin()) {
    echo '<div class="container"><div class="alert alert-danger">Bạn không có quyền truy cập trang này</div></div>';
    include APP_PATH . '/views/layouts/footer.php';
    exit;
}

// Lấy thống kê
$productModel = new Product();
$orderModel = new Order();
$userModel = new User();

// Lấy số lượng sản phẩm
$allProducts = $productModel->getAll();
$totalProducts = count($allProducts);

// Lấy số lượng người dùng
$allUsers = $userModel->getAll();
$totalUsers = count($allUsers);

// Lấy số lượng đơn hàng và tổng doanh thu
$allOrders = $orderModel->getAll();
$totalOrders = count($allOrders);
$totalRevenue = 0;
foreach ($allOrders as $order) {
    $totalRevenue += $order['total_amount'];
}
?>

<div class="container">
    <h1 class="mb-4">Bảng điều khiển Admin</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Tổng đơn hàng</h5>
                    <p class="card-text display-4 fw-bold"><?php echo $totalOrders; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Tổng doanh thu</h5>
                    <p class="card-text fs-4 fw-bold"><?php echo number_format($totalRevenue, 0, ',', '.'); ?> VNĐ</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Tổng sản phẩm</h5>
                    <p class="card-text display-4 fw-bold"><?php echo $totalProducts; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Tổng người dùng</h5>
                    <p class="card-text display-4 fw-bold"><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title mb-4">📋 Quản lý</h3>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body">
                            <h4 class="card-title">📦 Quản lý sản phẩm</h4>
                            <p class="card-text">Thêm, sửa, xóa sản phẩm</p>
                            <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=products" class="btn btn-light w-100">Quản lý →</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="card-body">
                            <h4 class="card-title">📦 Quản lý đơn hàng</h4>
                            <p class="card-text">Xem, cập nhật trạng thái đơn hàng</p>
                            <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=orders" class="btn btn-light w-100">Quản lý →</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="card-body">
                            <h4 class="card-title">👥 Quản lý người dùng</h4>
                            <p class="card-text">Xem, khóa, gỡ khóa người dùng</p>
                            <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=users" class="btn btn-light w-100">Quản lý →</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card text-white" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <div class="card-body">
                            <h4 class="card-title">📊 Xem thống kê</h4>
                            <p class="card-text">Xem báo cáo doanh thu, bán hàng</p>
                            <a href="<?php echo getBaseUrl(); ?>/?page=admin&action=statistics" class="btn btn-light w-100">Xem →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
