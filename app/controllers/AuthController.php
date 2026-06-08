<?php
/**
 * AuthController - Controller xử lý authentication (xác thực người dùng)
 * 
 * Controller này chịu trách nhiệm xử lý tất cả các chức năng liên quan đến
 * xác thực người dùng trong hệ thống, bao gồm:
 * - Đăng nhập (login): Xác thực thông tin người dùng và tạo session
 * - Đăng ký (register): Tạo tài khoản người dùng mới
 * - Đăng xuất (logout): Hủy session và xóa thông tin người dùng
 * 
 * Các phương thức chính:
 * - login(): Hiển thị form đăng nhập và xử lý logic đăng nhập
 * - register(): Hiển thị form đăng ký và xử lý logic đăng ký
 * - logout(): Xóa session và đăng xuất người dùng
 * 
 * @package App\Controllers
 */

require_once APP_PATH . '/controllers/Controller.php';
require_once APP_PATH . '/models/User.php';

class AuthController extends Controller {
    
    /**
     * Hiển thị trang đăng nhập và xử lý logic đăng nhập
     * 
     * Phương thức này thực hiện hai nhiệm vụ:
     * 1. Nếu request là GET: Hiển thị form đăng nhập
     * 2. Nếu request là POST: Xử lý logic đăng nhập
     *    - Lấy username và password từ form
     *    - Tìm user trong database theo username
     *    - Verify password sử dụng password_verify()
     *    - Nếu thành công: Lưu thông tin vào session và redirect
     *    - Nếu thất bại: Hiển thị thông báo lỗi
     * 
     * @return void
     */
    public function login() {
        // Kiểm tra xem request có phải là POST không (người dùng đã submit form)
        if ($this->isMethod('POST')) {
            // Lấy và làm sạch dữ liệu từ form
            $username = trim($this->input('username'));
            $password = trim($this->input('password'));
            
            // Kiểm tra xem username và password có được nhập không
            if (!empty($username) && !empty($password)) {
                // Tạo instance của User model để truy vấn database
                $userModel = new User();
                // Tìm user trong database theo username
                $user = $userModel->getByUsername($username);
                
                // Kiểm tra xem user có tồn tại và password có đúng không
                if ($user && password_verify($password, $user['password'])) {
                    // Đăng nhập thành công - Lưu thông tin user vào session
                    $_SESSION['user_id'] = $user['id'];          // ID của user
                    $_SESSION['username'] = $user['username'];    // Tên đăng nhập
                    $_SESSION['role'] = $user['role'];            // Vai trò (admin/user)
                    
                    // Đặt thông báo thành công
                    $this->setMessage('Đăng nhập thành công', 'success');
                    // Redirect về trang chủ
                    $this->redirect(APP_URL . '/');
                    // Dừng thực thi để không render view
                    return;
                } else {
                    // Đăng nhập thất bại - Đặt thông báo lỗi
                    $this->setMessage('Tên đăng nhập hoặc mật khẩu không đúng', 'error');
                }
            }
        }
        
        // Nếu request là GET hoặc đăng nhập thất bại, hiển thị form đăng nhập
        $this->view('auth/login.php');
    }
    
    /**
     * Hiển thị trang đăng ký và xử lý logic đăng ký
     * 
     * Phương thức này thực hiện hai nhiệm vụ:
     * 1. Nếu request là GET: Hiển thị form đăng ký
     * 2. Nếu request là POST: Xử lý logic đăng ký
     *    - Lấy dữ liệu từ form (username, email, password, password_confirm)
     *    - Validate dữ liệu đầu vào
     *    - Kiểm tra username và email đã tồn tại chưa
     *    - Nếu hợp lệ: Tạo user mới trong database
     *    - Nếu thành công: Redirect đến trang đăng nhập
     *    - Nếu thất bại: Hiển thị thông báo lỗi
     * 
     * @return void
     */
    public function register() {
        // Kiểm tra xem request có phải là POST không (người dùng đã submit form)
        if ($this->isMethod('POST')) {
            // Lấy và làm sạch dữ liệu từ form
            $username = trim($this->input('username'));
            $email = trim($this->input('email'));
            $password = trim($this->input('password'));
            $password_confirm = trim($this->input('password_confirm'));
            
            // Khởi tạo mảng errors để lưu các lỗi validate
            $errors = [];
            
            // Validate username
            if (empty($username)) {
                $errors[] = 'Vui lòng nhập tên đăng nhập';
            } elseif (strlen($username) < 4) {
                $errors[] = 'Tên đăng nhập phải có ít nhất 4 ký tự';
            }
            
            // Validate email
            if (empty($email)) {
                $errors[] = 'Vui lòng nhập email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            
            // Validate password
            if (empty($password)) {
                $errors[] = 'Vui lòng nhập mật khẩu';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
            }
            
            // Validate password confirmation
            if ($password !== $password_confirm) {
                $errors[] = 'Mật khẩu xác nhận không khớp';
            }
            
            // Nếu không có lỗi validate, tiếp tục xử lý
            if (empty($errors)) {
                // Tạo instance của User model
                $userModel = new User();
                
                // Kiểm tra username đã tồn tại trong database chưa
                $existingUser = $userModel->getByUsername($username);
                if ($existingUser) {
                    // Username đã tồn tại - Đặt thông báo lỗi
                    $this->setMessage('Tên đăng nhập đã tồn tại', 'error');
                } else {
                    // Kiểm tra email đã tồn tại trong database chưa
                    $existingEmail = $userModel->getByEmail($email);
                    if ($existingEmail) {
                        // Email đã tồn tại - Đặt thông báo lỗi
                        $this->setMessage('Email đã được sử dụng', 'error');
                    } else {
                        // Tạo user mới trong database
                        $result = $userModel->create([
                            'username' => $username,
                            'email' => $email,
                            'password' => $password,  // Mật khẩu sẽ được hash trong model
                            'fullname' => $username    // Sử dụng username làm fullname mặc định
                        ]);
                        
                        // Kiểm tra xem tạo user thành công không
                        if ($result) {
                            // Đăng ký thành công - Đặt thông báo thành công
                            $this->setMessage('Đăng ký thành công! Vui lòng đăng nhập.', 'success');
                            // Redirect đến trang đăng nhập
                            $this->redirect(APP_URL . '/?page=auth&action=login');
                            // Dừng thực thi để không render view
                            return;
                        } else {
                            // Đăng ký thất bại - Đặt thông báo lỗi
                            $this->setMessage('Lỗi khi đăng ký. Vui lòng thử lại!', 'error');
                        }
                    }
                }
            } else {
                // Có lỗi validate - Hiển thị các lỗi
                $this->setMessage(implode('<br>', $errors), 'error');
            }
        }
        
        // Nếu request là GET hoặc có lỗi, hiển thị form đăng ký
        $this->view('auth/register.php');
    }
    
    /**
     * Xử lý đăng xuất người dùng
     * 
     * Phương thức này thực hiện các bước sau để đăng xuất an toàn:
     * 1. Xóa toàn bộ dữ liệu trong session
     * 2. Xóa cookie session (nếu có)
     * 3. Hủy session hoàn toàn
     * 4. Thiết lập các header để ngăn browser cache trang
     * 5. Redirect về trang chủ
     * 
     * Việc xóa cache header là quan trọng để ngăn người dùng
     * sử dụng nút Back để quay lại trang sau khi đăng xuất.
     * 
     * @return void
     */
    public function logout() {
        // Xóa toàn bộ dữ liệu trong session
        $_SESSION = [];
        
        // Xóa cookie session nếu tồn tại
        // Điều này ngăn việc session được khôi phục từ cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        
        // Hủy session hoàn toàn
        session_destroy();
        
        // Thiết lập các header để ngăn browser cache trang
        // Điều này ngăn người dùng sử dụng nút Back để quay lại trang sau khi đăng xuất
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        
        // Redirect về trang chủ
        $this->redirect(APP_URL . '/');
    }
}
