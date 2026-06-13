<?php
/**
 * Cấu hình ứng dụng chính
 * 
 * File này khởi tạo các cấu hình cơ bản cho ứng dụng:
 * - Cấu hình hiển thị lỗi (error reporting)
 * - Cấu hình múi giờ
 * - Cấu hình session bảo mật
 * - Include các file cấu hình và helper cần thiết
 */

// Cấu hình hiển thị lỗi tùy theo môi trường
if (($_ENV['ENVIRONMENT'] ?? 'development') === 'development') {
    // Môi trường development: hiển thị tất cả lỗi
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // Môi trường production: tắt hiển thị lỗi
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Thiết lập múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Cấu hình session bảo mật
ini_set('session.cookie_httponly', 1); // Cookie chỉ accessible qua HTTP (không qua JavaScript)
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'); // Chỉ gửi cookie qua HTTPS
ini_set('session.use_only_cookies', 1); // Chỉ sử dụng cookie để lưu session ID

// Khởi động session nếu chưa được khởi động
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include các file cấu hình và helper cần thiết
require_once __DIR__ . '/database.php'; // Kết nối database
require_once __DIR__ . '/constants.php'; // Các hằng số ứng dụng
require_once APP_PATH . '/helpers/functions.php'; // Các hàm helper chung
require_once APP_PATH . '/helpers/validation.php'; // Các hàm validation
require_once APP_PATH . '/helpers/security.php'; // Các hàm bảo mật
?>
