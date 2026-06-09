<?php
/**
 * Layout Header - Header chung cho tất cả các trang
 * 
 * File này chứa:
 * - Cache control headers cho các trang đã đăng nhập (bảo mật)
 * - HTML head với meta tags, CSS
 * - Navigation bar với menu điều hướng
 * - Hiển thị thông báo (flash messages)
 */

// Ngăn trình duyệt cache các trang đã đăng nhập (bảo mật)
if (isLoggedIn()) {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Phone Store - Cửa hàng bán điện thoại chất lượng cao">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Phone Store</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo getAssetUrl('css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo getAssetUrl('css/responsive.css'); ?>">
</head>
<body>
    <!-- Header với Navigation Bar -->
    <?php
    // Lấy trang hiện tại để highlight menu active
    $currentPage = $_GET['page'] ?? 'home';
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo getBaseUrl(); ?>/?page=home">
                <img src="<?php echo getAssetUrl('images/logophonestore.png'); ?>" alt="Phone Store Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'home' ? 'active' : ''); ?>" href="<?php echo getBaseUrl(); ?>/?page=home">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'products' ? 'active' : ''); ?>" href="<?php echo getBaseUrl(); ?>/?page=products">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'cart' ? 'active' : ''); ?>" href="<?php echo getBaseUrl(); ?>/?page=cart">Giỏ hàng</a>
                    </li>

                    <?php if (isLoggedIn()): ?>
                        <!-- Menu chỉ hiển thị khi đã đăng nhập -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($currentPage === 'orders' ? 'active' : ''); ?>" href="<?php echo getBaseUrl(); ?>/?page=orders">Đơn hàng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($currentPage === 'profile' ? 'active' : ''); ?>" href="<?php echo getBaseUrl(); ?>/?page=profile">Thông tin</a>
                        </li>
                    <?php endif; ?>

                    <?php if (isLoggedIn()): ?>
                        <?php if (isAdmin()): ?>
                            <!-- Menu admin chỉ hiển thị cho admin -->
                            <li class="nav-item">
                                <a class="nav-link <?php echo ($currentPage === 'admin' ? 'active' : ''); ?>" href="<?php echo getBaseUrl(); ?>/?page=admin">Quản trị</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo getBaseUrl(); ?>/?page=auth&action=logout">Đăng xuất</a>
                        </li>
                    <?php else: ?>
                        <!-- Menu đăng nhập/đăng ký khi chưa đăng nhập -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($currentPage === 'auth' ? 'active' : ''); ?>" href="<?php echo getBaseUrl(); ?>/?page=auth&action=login">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($currentPage === 'auth' ? 'active' : ''); ?>" href="<?php echo getBaseUrl(); ?>/?page=auth&action=register">Đăng ký</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="py-4">
        <div class="container">
            <?php
            // Hiển thị flash message (thông báo từ session)
            $message = getMessage();
            if (!empty($message['message'])):
            ?>
                <div class="alert alert-<?php echo escape($message['type']); ?> alert-dismissible fade show">
                    <?php echo escape($message['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>


