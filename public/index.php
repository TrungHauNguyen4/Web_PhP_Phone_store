<?php
/**
 * Entry Point - Điểm nhập chính của ứng dụng (Router)
 * 
 * File này là điểm nhập duy nhất cho tất cả request đến ứng dụng.
 * Nó đóng vai trò như một router đơn giản, phân phối request đến
 * controller tương ứng dựa trên tham số 'page' và 'action' trong URL.
 * 
 * Cấu trúc URL:
 * - http://domain.com/?page=xxx&action=yyy
 * - page: Xác định controller nào sẽ xử lý request
 * - action: Xác định phương thức nào trong controller sẽ được gọi
 * 
 * Các trang được hỗ trợ:
 * - home: Trang chủ (ProductController::home())
 * - products: Danh sách sản phẩm (ProductController::index())
 * - product: Chi tiết sản phẩm (ProductController::detail())
 * - auth: Đăng nhập/Đăng ký (AuthController::login(), register(), logout())
 * - cart: Giỏ hàng (CartController::index(), add(), remove(), update())
 * - checkout: Thanh toán (OrderController::checkout())
 * - orders: Đơn hàng (OrderController::index())
 * - profile: Thông tin cá nhân (UserController::edit())
 * - admin: Admin panel (AdminController::index(), products(), orders(), users(), statistics())
 * 
 * Các chức năng chính:
 * - Khởi tạo output buffering để quản lý output headers
 * - Định nghĩa các hằng số đường dẫn (ROOT_PATH, APP_PATH, APP_URL)
 * - Load cấu hình ứng dụng (database, constants, helpers)
 * - Sanitize tham số đầu vào để ngăn chặn path traversal attacks
 * - Routing: Phân phối request đến controller tương ứng
 * - Xử lý exception và hiển thị lỗi 500 nếu có lỗi xảy ra
 */

// Bắt đầu output buffering
// Điều này cho phép chúng ta quản lý output headers trước khi gửi nội dung đến browser
// Giúp tránh lỗi "headers already sent" và cho phép redirect sau khi đã output dữ liệu
ob_start();

// Định nghĩa đường dẫn gốc của dự án
// ROOT_PATH trỏ đến thư mục gốc của dự án (d:\Web-PHP\BT_Cuoi_Ky)
define('ROOT_PATH', dirname(dirname(__FILE__)));

// Load cấu hình ứng dụng
// File app.php load các cấu hình quan trọng:
// - Kết nối database
// - Định nghĩa các hằng số (APP_PATH, APP_URL)
// - Load các helper functions (escape(), formatPrice(), getBaseUrl(), isLoggedIn(), v.v.)
require_once ROOT_PATH . '/app/config/app.php';

// Lấy tham số page và action từ query parameters
// page: Xác định trang/controller cần load (mặc định là 'home' - trang chủ)
// action: Xác định action/phương thức cần gọi trong controller (mặc định là 'index')
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Sanitize page và action để ngăn chặn path traversal attacks
// Chỉ cho phép các ký tự an toàn: chữ cái, số, dấu gạch dưới, dấu gạch ngang
// Điều này ngăn chặn các tấn công như: page=../../../etc/passwd
$page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
$action = preg_replace('/[^a-zA-Z0-9_-]/', '', $action);

// Router đơn giản - Phân phối request đến controller tương ứng
// Sử dụng switch case để xác định controller dựa trên tham số page
// Mỗi case load controller tương ứng và gọi phương thức phù hợp
try {
    switch ($page) {
        case 'home':
            // Trang chủ - Sử dụng ProductController
            // Gọi phương thức home() để hiển thị trang chủ với carousel và sản phẩm nổi bật
            require_once APP_PATH . '/controllers/ProductController.php';
            $controller = new ProductController();
            $controller->home();
            break;
            
        case 'products':
            // Danh sách sản phẩm - Sử dụng ProductController
            // Gọi phương thức index() để hiển thị danh sách sản phẩm với tìm kiếm và lọc
            require_once APP_PATH . '/controllers/ProductController.php';
            $controller = new ProductController();
            $controller->index();
            break;
            
        case 'product':
            // Chi tiết sản phẩm - Sử dụng ProductController
            // Gọi phương thức detail() để hiển thị chi tiết một sản phẩm cụ thể
            // ID sản phẩm được lấy từ tham số 'id' trong URL
            require_once APP_PATH . '/controllers/ProductController.php';
            $controller = new ProductController();
            $controller->detail();
            break;
            
        case 'auth':
            // Authentication (Đăng nhập/Đăng ký/Đăng xuất) - Sử dụng AuthController
            // Kiểm tra xem action có tồn tại trong controller không
            // Nếu có, gọi phương thức tương ứng (login, register, logout)
            // Nếu không, mặc định gọi login()
            require_once APP_PATH . '/controllers/AuthController.php';
            $controller = new AuthController();
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                $controller->login();
            }
            break;
            
        case 'cart':
            // Giỏ hàng - Sử dụng CartController
            // Kiểm tra xem action có tồn tại trong controller không
            // Nếu có, gọi phương thức tương ứng (index, add, remove, update)
            // Nếu không, mặc định gọi index() để hiển thị giỏ hàng
            require_once APP_PATH . '/controllers/CartController.php';
            $controller = new CartController();
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                $controller->index();
            }
            break;
            
        case 'checkout':
            // Thanh toán - Sử dụng OrderController
            // Gọi phương thức checkout() để hiển thị form thanh toán và xử lý tạo đơn hàng
            require_once APP_PATH . '/controllers/OrderController.php';
            $controller = new OrderController();
            $controller->checkout();
            break;
            
        case 'orders':
            // Đơn hàng - Sử dụng OrderController
            // Gọi phương thức index() để hiển thị danh sách đơn hàng của người dùng
            require_once APP_PATH . '/controllers/OrderController.php';
            $controller = new OrderController();
            $controller->index();
            break;
            
        case 'profile':
            // Thông tin cá nhân - Sử dụng UserController
            // Gọi phương thức edit() để hiển thị form chỉnh sửa thông tin cá nhân
            require_once APP_PATH . '/controllers/UserController.php';
            $controller = new UserController();
            $controller->edit();
            break;
            
        case 'admin':
            // Admin panel - Sử dụng AdminController
            // Kiểm tra xem action có tồn tại trong controller không
            // Nếu có, gọi phương thức tương ứng (index, products, orders, users, statistics)
            // Nếu không, mặc định gọi index() để hiển thị dashboard
            require_once APP_PATH . '/controllers/AdminController.php';
            $controller = new AdminController();
            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                $controller->index();
            }
            break;
            
        default:
            // Trang chủ mặc định - Sử dụng ProductController
            // Nếu page không khớp với bất kỳ case nào, hiển thị trang chủ
            // Điều này đảm bảo người dùng luôn thấy trang thay vì lỗi 404
            require_once APP_PATH . '/controllers/ProductController.php';
            $controller = new ProductController();
            $controller->home();
            break;
    }
} catch (Exception $e) {
    // Xử lý exception nếu có lỗi xảy ra
    // Thiết lập HTTP response code thành 500 (Internal Server Error)
    http_response_code(500);
    
    // Hiển thị trang lỗi thân thiện với người dùng
    // Sử dụng hàm escape() để ngăn chặn XSS attacks
    echo '<div style="text-align: center; padding: 50px; font-family: Arial;">
        <h1>500 - Internal Server Error</h1>
        <p>' . escape($e->getMessage()) . '</p>
        <a href="' . APP_URL . '/" style="color: #3498db;">Quay lại trang chủ</a>
    </div>';
}

// Kết thúc output buffering và flush output
// Gửi tất cả nội dung đã được buffer đến browser
ob_end_flush();
?>
