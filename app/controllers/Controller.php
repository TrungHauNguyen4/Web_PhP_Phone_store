<?php
/**
 * BaseController - Controller cơ sở cho toàn bộ hệ thống
 * 
 * Đây là class cha của tất cả các controller trong ứng dụng.
 * Nó cung cấp các phương thức tiện ích chung được sử dụng bởi
 * các controller con để tránh lặp lại code và đảm bảo tính nhất quán.
 * 
 * Các chức năng chính:
 * - view(): Load và render view file với dữ liệu được truyền vào
 * - redirect(): Chuyển hướng người dùng đến URL khác
 * - isLoggedIn(): Kiểm tra xem người dùng đã đăng nhập chưa
 * - isAdmin(): Kiểm tra xem người dùng có quyền admin không
 * - getCurrentUserId(): Lấy ID của người dùng đang đăng nhập
 * - setMessage(): Lưu thông báo flash vào session
 * - getMessage(): Lấy và xóa thông báo flash từ session
 * - isMethod(): Kiểm tra phương thức HTTP của request (GET, POST, v.v.)
 * - input(): Lấy dữ liệu từ request (POST hoặc GET)
 * - validateRequired(): Validate các trường bắt buộc
 * 
 * @package App\Controllers
 */

class Controller {
    /**
     * Load và render view file
     * 
     * Phương thức này nhận đường dẫn đến view file và mảng dữ liệu,
     * sau đó extract dữ liệu để các biến có sẵn trong scope của view,
     * và require view file để hiển thị.
     * 
     * @param string $view Đường dẫn đến view file (tương đối từ app/views/)
     *                      Ví dụ: 'products/list.php' sẽ load app/views/products/list.php
     * @param array $data Mảng dữ liệu truyền cho view. Các key sẽ trở thành tên biến trong view.
     *                    Ví dụ: ['products' => $products] sẽ tạo biến $products trong view.
     * @return void
     * @throws Exception Nếu view file không tồn tại
     */
    protected function view($view, $data = []) {
        // Extract mảng data để các key trở thành biến có sẵn trong view
        // Ví dụ: ['products' => $products] -> biến $products có sẵn trong view
        extract($data);
        
        // Xây dựng đường dẫn đầy đủ đến view file từ APP_PATH
        $view_file = APP_PATH . '/views/' . $view;
        
        // Kiểm tra xem view file có tồn tại không
        if (file_exists($view_file)) {
            // Require view file để render
            require $view_file;
        } else {
            // Ném exception nếu view không tồn tại
            throw new Exception("View file not found: {$view_file}");
        }
    }
    
    /**
     * Chuyển hướng người dùng đến URL khác
     * 
     * Phương thức này sử dụng header HTTP Location để redirect
     * và gọi exit để dừng thực thi script sau khi redirect.
     * 
     * @param string $url URL đích để chuyển hướng
     *                    Có thể là URL tuyệt đối hoặc tương đối
     * @return void
     */
    protected function redirect($url) {
        // Gửi header Location để redirect
        header("Location: {$url}");
        // Dừng thực thi script để đảm bảo redirect xảy ra
        exit;
    }
    
    /**
     * Kiểm tra xem người dùng đã đăng nhập chưa
     * 
     * Phương thức này kiểm tra xem session có chứa user_id không.
     * Nếu có, người dùng đã đăng nhập, ngược lại chưa.
     * 
     * @return bool Trả về true nếu người dùng đã đăng nhập, false nếu chưa
     */
    protected function isLoggedIn() {
        // Kiểm tra xem session có key 'user_id' không
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Kiểm tra xem người dùng có quyền admin không
     * 
     * Phương thức này kiểm tra xem session có chứa role='admin' không.
     * Chỉ những người dùng có role admin mới có quyền truy cập
     * các trang quản trị.
     * 
     * @return bool Trả về true nếu người dùng là admin, false nếu không
     */
    protected function isAdmin() {
        // Kiểm tra xem session có key 'role' và giá trị là 'admin' không
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    /**
     * Lấy ID của người dùng đang đăng nhập
     * 
     * Phương thức này trả về ID của người dùng hiện tại từ session.
     * Nếu người dùng chưa đăng nhập, trả về null.
     * 
     * @return int|null ID của người dùng nếu đã đăng nhập, null nếu chưa
     */
    protected function getCurrentUserId() {
        // Trả về user_id từ session hoặc null nếu không tồn tại
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Lưu thông báo flash vào session
     * 
     * Flash message là thông báo tạm thời được lưu trong session
     * và hiển thị một lần sau đó bị xóa. Thường dùng để hiển thị
     * thông báo thành công/lỗi sau khi thực hiện action.
     * 
     * @param string $message Nội dung thông báo cần hiển thị
     * @param string $type Loại thông báo: 'success' (thành công), 'error' (lỗi),
     *                      'info' (thông tin), 'warning' (cảnh báo). Mặc định là 'info'.
     * @return void
     */
    protected function setMessage($message, $type = 'info') {
        // Lưu thông báo vào session dưới dạng mảng
        $_SESSION['flash_message'] = [
            'message' => $message,
            'type' => $type
        ];
    }
    
    /**
     * Lấy và xóa thông báo flash từ session
     * 
     * Phương thức này lấy thông báo flash từ session, xóa nó khỏi session
     * (để chỉ hiển thị một lần), và trả về thông báo đó.
     * Nếu không có thông báo, trả về null.
     * 
     * @return array|null Mảng chứa 'message' và 'type' nếu có, null nếu không
     */
    protected function getMessage() {
        // Kiểm tra xem session có flash message không
        if (isset($_SESSION['flash_message'])) {
            // Lưu message vào biến tạm
            $message = $_SESSION['flash_message'];
            // Xóa message khỏi session để chỉ hiển thị một lần
            unset($_SESSION['flash_message']);
            // Trả về message
            return $message;
        }
        // Trả về null nếu không có message
        return null;
    }
    
    /**
     * Kiểm tra phương thức HTTP của request
     * 
     * Phương thức này so sánh phương thức của request hiện tại
     * với phương thức được chỉ định. Thường dùng để kiểm tra
     * xem request là GET hay POST.
     * 
     * @param string $method Phương thức cần kiểm tra: 'GET', 'POST', 'PUT', 'DELETE', v.v.
     * @return bool Trả về true nếu phương thức khớp, false nếu không
     */
    protected function isMethod($method) {
        // So sánh REQUEST_METHOD với phương thức được chỉ định (chuyển sang chữ hoa)
        return $_SERVER['REQUEST_METHOD'] === strtoupper($method);
    }
    
    /**
     * Lấy dữ liệu input từ request
     * 
     * Phương thức này lấy dữ liệu từ POST hoặc GET dựa trên key.
     * Ưu tiên POST trước, sau đó GET. Nếu không tìm thấy,
     * trả về giá trị mặc định.
     * 
     * @param string $key Key của dữ liệu cần lấy (tên field trong form hoặc query parameter)
     * @param mixed $default Giá trị mặc định trả về nếu key không tồn tại
     * @return mixed Giá trị của input hoặc giá trị mặc định
     */
    protected function input($key, $default = null) {
        // Ưu tiên lấy từ POST, nếu không có thì lấy từ GET, nếu không có thì trả về default
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
    
    /**
     * Validate các trường bắt buộc
     * 
     * Phương thức này kiểm tra xem các trường được chỉ định có rỗng không.
     * Nếu có trường nào rỗng, thêm thông báo lỗi vào mảng errors.
     * 
     * @param array $fields Mảng các tên trường cần validate
     *                      Ví dụ: ['username', 'password', 'email']
     * @return array Mảng chứa các thông báo lỗi. Rỗng nếu không có lỗi.
     */
    protected function validateRequired($fields) {
        // Khởi tạo mảng errors rỗng
        $errors = [];
        
        // Duyệt qua từng trường cần validate
        foreach ($fields as $field) {
            // Lấy giá trị của trường
            $value = $this->input($field);
            // Kiểm tra xem giá trị có rỗng không (sau khi trim khoảng trắng)
            if (empty(trim($value))) {
                // Nếu rỗng, thêm thông báo lỗi vào mảng
                $errors[] = "Vui lòng nhập {$field}";
            }
        }
        
        // Trả về mảng errors
        return $errors;
    }
}
