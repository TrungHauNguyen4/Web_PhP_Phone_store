<?php
/**
 * Các hằng số ứng dụng
 * 
 * File này định nghĩa các hằng số được sử dụng trong toàn bộ ứng dụng:
 * - Thông tin ứng dụng
 * - Đường dẫn hệ thống
 * - Cấu hình session
 * - Cấu hình phân trang
 * - Cấu hình sản phẩm
 * - Vai trò người dùng
 * - Trạng thái đơn hàng
 * - Phương thức thanh toán
 * - Thông báo lỗi và thành công
 */

// Thông tin ứng dụng
define('APP_NAME', 'Laptop Store'); // Tên ứng dụng
define('APP_VERSION', '1.0.0'); // Phiên bản ứng dụng

// Tự động xác định APP_URL để chạy được trên điện thoại và nhiều môi trường
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:3000';
define('APP_URL', $protocol . '://' . $host);

// Đường dẫn hệ thống (ROOT_PATH được định nghĩa trong public/index.php)
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(dirname(dirname(__FILE__)))); // Đường dẫn gốc của dự án
}
define('APP_PATH', ROOT_PATH . '/app'); // Đường dẫn thư mục app
define('PUBLIC_PATH', ROOT_PATH . '/public'); // Đường dẫn thư mục public
define('UPLOADS_PATH', PUBLIC_PATH . '/assets/images'); // Đường dẫn thư mục lưu ảnh sản phẩm

// Cấu hình session
define('SESSION_TIMEOUT', 3600); // Thời gian timeout của session (1 giờ = 3600 giây)
define('REMEMBER_ME_DURATION', 604800); // Thời gian nhớ đăng nhập (7 ngày = 604800 giây)

// Cấu hình phân trang
define('ITEMS_PER_PAGE', 12); // Số lượng item hiển thị trên mỗi trang

// Cấu hình sản phẩm
define('MAX_PRODUCT_UPLOAD_SIZE', 5242880); // Kích thước tối đa cho file upload sản phẩm (5MB)
define('ALLOWED_IMAGE_TYPES', array('jpg', 'jpeg', 'png', 'gif')); // Các định dạng ảnh được phép

// Vai trò người dùng
define('ROLE_ADMIN', 'admin'); // Vai trò quản trị viên
define('ROLE_USER', 'user'); // Vai trò người dùng thường

// Trạng thái đơn hàng
define('ORDER_PENDING', 'pending'); // Đơn hàng chờ xử lý
define('ORDER_PROCESSING', 'processing'); // Đơn hàng đang xử lý
define('ORDER_COMPLETED', 'completed'); // Đơn hàng đã hoàn thành
define('ORDER_CANCELLED', 'cancelled'); // Đơn hàng đã hủy

// Phương thức thanh toán
define('PAYMENT_CREDIT_CARD', 'credit_card'); // Thẻ tín dụng
define('PAYMENT_BANK_TRANSFER', 'bank_transfer'); // Chuyển khoản ngân hàng
define('PAYMENT_COD', 'cod'); // Thanh toán khi nhận hàng (Cash on Delivery)
define('PAYMENT_E_WALLET', 'e_wallet'); // Ví điện tử

// Thông báo lỗi
define('ERROR_REQUIRED_FIELD', 'This field is required'); // Lỗi trường bắt buộc
define('ERROR_INVALID_EMAIL', 'Invalid email address'); // Lỗi email không hợp lệ
define('ERROR_PASSWORD_MISMATCH', 'Passwords do not match'); // Lỗi mật khẩu không khớp
define('ERROR_USER_EXISTS', 'User already exists'); // Lỗi người dùng đã tồn tại
define('ERROR_INVALID_CREDENTIALS', 'Invalid username or password'); // Lỗi thông tin đăng nhập không đúng
define('ERROR_UNAUTHORIZED', 'You are not authorized to access this resource'); // Lỗi không có quyền truy cập
define('ERROR_FILE_NOT_FOUND', 'File not found'); // Lỗi không tìm thấy file

// Thông báo thành công
define('SUCCESS_LOGIN', 'Login successful'); // Đăng nhập thành công
define('SUCCESS_LOGOUT', 'Logout successful'); // Đăng xuất thành công
define('SUCCESS_REGISTER', 'Registration successful'); // Đăng ký thành công
define('SUCCESS_PRODUCT_ADDED', 'Product added successfully'); // Thêm sản phẩm thành công
define('SUCCESS_PRODUCT_UPDATED', 'Product updated successfully'); // Cập nhật sản phẩm thành công
define('SUCCESS_PRODUCT_DELETED', 'Product deleted successfully'); // Xóa sản phẩm thành công
define('SUCCESS_ORDER_CREATED', 'Order created successfully'); // Tạo đơn hàng thành công
?>
