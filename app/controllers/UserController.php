<?php
/**
 * UserController - Controller xử lý thông tin người dùng
 * 
 * Controller này chịu trách nhiệm xử lý các chức năng liên quan đến
 * thông tin cá nhân của người dùng trong hệ thống, bao gồm:
 * - Chỉnh sửa thông tin cá nhân: Cập nhật họ tên, email, số điện thoại, địa chỉ
 * - Đổi mật khẩu: Cho phép người dùng thay đổi mật khẩu của mình
 * 
 * Các phương thức chính:
 * - edit(): Hiển thị form chỉnh sửa thông tin cá nhân và xử lý logic cập nhật
 * 
 * @package App\Controllers
 */

require_once APP_PATH . '/controllers/Controller.php';
require_once APP_PATH . '/models/User.php';

class UserController extends Controller {
    
    /**
     * Hiển thị trang chỉnh sửa thông tin cá nhân và xử lý logic cập nhật
     * 
     * Phương thức này thực hiện hai nhiệm vụ:
     * 1. Nếu request là GET: Hiển thị form chỉnh sửa thông tin cá nhân
     * 2. Nếu request là POST: Xử lý logic cập nhật thông tin
     *    - Validate thông tin cơ bản (họ tên, email, số điện thoại, địa chỉ)
     *    - Validate đổi mật khẩu (nếu người dùng muốn đổi)
     *    - Kiểm tra email đã tồn tại chưa (nếu đang thay đổi)
     *    - Cập nhật thông tin trong database
     *    - Refresh dữ liệu user sau khi cập nhật thành công
     * 
     * @return void
     */
    public function edit() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$this->isLoggedIn()) {
            // Chưa đăng nhập - Redirect đến trang đăng nhập
            $this->redirect(APP_URL . '/?page=auth&action=login');
            return;
        }
        
        // Tạo instance của User model
        $userModel = new User();
        
        // Lấy ID của người dùng hiện tại
        $user_id = $this->getCurrentUserId();
        
        // Lấy thông tin chi tiết của người dùng từ database
        $user = $userModel->getById($user_id);
        
        // Khởi tạo biến để lưu lỗi và trạng thái thành công
        $errors = [];
        $success = false;
        
        // Xử lý submit form (nếu người dùng đã submit)
        if ($this->isMethod('POST')) {
            // Lấy thông tin từ form
            $fullname = trim($this->input('fullname'));
            $phone = trim($this->input('phone'));
            $address = trim($this->input('address'));
            $email = trim($this->input('email'));
            $current_password = trim($this->input('current_password'));
            $new_password = trim($this->input('new_password'));
            $confirm_password = trim($this->input('password_confirm'));
            
            // Validate thông tin cơ bản
            if (empty($fullname)) {
                $errors[] = 'Vui lòng nhập họ tên';
            }
            
            // Validate email
            if (empty($email)) {
                $errors[] = 'Vui lòng nhập email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email không hợp lệ';
            }
            
            // Validate số điện thoại (nếu có nhập)
            if (!empty($phone)) {
                // Xóa tất cả ký tự không phải số
                $phoneClean = preg_replace('/[^0-9]/', '', $phone);
                // Kiểm tra độ dài số điện thoại (9-11 chữ số)
                if (!preg_match('/^[0-9]{9,11}$/', $phoneClean)) {
                    $errors[] = 'Số điện thoại phải từ 9-11 chữ số';
                }
            }
            
            // Kiểm tra email đã tồn tại chưa nếu đang thay đổi email
            if ($email !== $user['email']) {
                $existingEmail = $userModel->getByEmail($email);
                if ($existingEmail) {
                    $errors[] = 'Email đã được sử dụng bởi tài khoản khác';
                }
            }
            
            // Validate đổi mật khẩu (nếu người dùng muốn đổi mật khẩu)
            if (!empty($new_password)) {
                // Kiểm tra xem người dùng có nhập mật khẩu hiện tại không
                if (empty($current_password)) {
                    $errors[] = 'Vui lòng nhập mật khẩu hiện tại để đổi mật khẩu';
                } elseif (!password_verify($current_password, $user['password'])) {
                    // Kiểm tra mật khẩu hiện tại có đúng không
                    $errors[] = 'Mật khẩu hiện tại không đúng';
                } elseif (strlen($new_password) < 6) {
                    // Kiểm tra độ dài mật khẩu mới
                    $errors[] = 'Mật khẩu mới phải có ít nhất 6 ký tự';
                } elseif ($new_password !== $confirm_password) {
                    // Kiểm tra mật khẩu xác nhận có khớp không
                    $errors[] = 'Mật khẩu xác nhận không khớp';
                }
            }
            
            // Nếu không có lỗi validate, tiếp tục xử lý
            if (empty($errors)) {
                // Chuẩn bị dữ liệu để cập nhật
                $updateData = [
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone' => $phoneClean ?? $phone,  // Sử dụng số đã làm sạch hoặc nguyên bản
                    'address' => $address
                ];
                
                // Nếu người dùng muốn đổi mật khẩu, thêm vào dữ liệu cập nhật
                if (!empty($new_password)) {
                    $updateData['password'] = $new_password;  // Mật khẩu sẽ được hash trong model
                }
                
                // Cập nhật thông tin trong database
                $result = $userModel->update($user_id, $updateData);
                
                // Kiểm tra xem cập nhật thành công không
                if ($result) {
                    // Cập nhật thành công - Đặt flag success
                    $success = true;
                    
                    // Refresh dữ liệu user để hiển thị thông tin mới nhất
                    $user = $userModel->getById($user_id);
                    
                    // Đặt thông báo thành công
                    $this->setMessage('Cập nhật thông tin thành công!', 'success');
                } else {
                    // Cập nhật thất bại - Thêm thông báo lỗi
                    $errors[] = 'Lỗi khi cập nhật thông tin. Vui lòng thử lại!';
                }
            }
        }
        
        // Truyền dữ liệu cho view để hiển thị
        $this->view('profile/edit.php', [
            'user' => $user,         // Thông tin người dùng hiện tại
            'errors' => $errors,     // Mảng lỗi validate (nếu có)
            'success' => $success    // Biến flag nếu cập nhật thành công
        ]);
    }
}
