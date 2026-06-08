<?php
/**
 * AdminController - Controller xử lý admin panel
 * 
 * Controller này chịu trách nhiệm xử lý tất cả các chức năng liên quan đến
 * quản trị trong hệ thống, bao gồm:
 * - Dashboard: Hiển thị thống kê tổng quan (sản phẩm, người dùng, đơn hàng, doanh thu)
 * - Quản lý sản phẩm: Thêm, sửa, xóa sản phẩm
 * - Quản lý đơn hàng: Xem danh sách, chi tiết, cập nhật trạng thái, xóa đơn hàng
 * - Quản lý người dùng: Xem danh sách, chỉnh sửa thông tin người dùng
 * - Thống kê: Hiển thị thống kê chi tiết
 * 
 * Các phương thức chính:
 * - index(): Hiển thị dashboard admin với thống kê tổng quan
 * - products(): Quản lý sản phẩm (list, add, edit, delete)
 * - orders(): Quản lý đơn hàng (list, view, update status, delete)
 * - users(): Quản lý người dùng (list, edit)
 * - statistics(): Hiển thị thống kê chi tiết
 * 
 * @package App\Controllers
 */

require_once APP_PATH . '/controllers/Controller.php';
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/Order.php';
require_once APP_PATH . '/models/User.php';

class AdminController extends Controller {
    
    /**
     * Kiểm tra quyền admin cho tất cả các action
     * 
     * Phương thức này kiểm tra xem người dùng hiện tại có quyền admin không.
     * Nếu không, hiển thị thông báo lỗi và redirect về trang chủ.
     * Phương thức này được gọi ở đầu mỗi action admin để bảo mật.
     * 
     * @return void
     */
    private function checkAdmin() {
        // Kiểm tra xem người dùng có quyền admin không
        if (!$this->isAdmin()) {
            // Không có quyền - Đặt thông báo lỗi
            $this->setMessage('Unauthorized access', 'error');
            // Redirect về trang chủ
            $this->redirect(APP_URL . '/');
            // Dừng thực thi script
            exit;
        }
    }
    
    /**
     * Hiển thị dashboard admin với thống kê tổng quan
     * 
     * Phương thức này thực hiện các chức năng:
     * 1. Lấy thống kê số lượng sản phẩm
     * 2. Lấy thống kê số lượng người dùng
     * 3. Lấy thống kê số lượng đơn hàng
     * 4. Tính tổng doanh thu từ tất cả đơn hàng
     * 5. Truyền dữ liệu thống kê cho view để hiển thị
     * 
     * @return void
     */
    public function index() {
        // Kiểm tra quyền admin
        $this->checkAdmin();
        
        // Tạo instance của các model cần thiết
        $productModel = new Product();
        $orderModel = new Order();
        $userModel = new User();
        
        // Lấy tất cả sản phẩm và đếm số lượng
        $allProducts = $productModel->getAll();
        $totalProducts = count($allProducts);
        
        // Lấy tất cả người dùng và đếm số lượng
        $allUsers = $userModel->getAll();
        $totalUsers = count($allUsers);
        
        // Lấy tất cả đơn hàng và đếm số lượng
        $allOrders = $orderModel->getAll();
        $totalOrders = count($allOrders);
        
        // Tính tổng doanh thu từ tất cả đơn hàng
        $totalRevenue = 0;
        foreach ($allOrders as $order) {
            $totalRevenue += $order['total_amount'];
        }
        
        // Truyền dữ liệu thống kê cho view
        $this->view('admin/dashboard.php', [
            'totalProducts' => $totalProducts,    // Tổng số sản phẩm
            'totalUsers' => $totalUsers,            // Tổng số người dùng
            'totalOrders' => $totalOrders,          // Tổng số đơn hàng
            'totalRevenue' => $totalRevenue         // Tổng doanh thu
        ]);
    }
    
    /**
     * Quản lý sản phẩm (list, add, edit, delete)
     * 
     * Phương thức này xử lý các chức năng quản lý sản phẩm:
     * - task='list': Hiển thị danh sách sản phẩm
     * - task='add': Hiển thị form thêm sản phẩm mới
     * - task='edit': Hiển thị form sửa sản phẩm
     * - task='delete': Xóa sản phẩm
     * 
     * @return void
     */
    public function products() {
        // Kiểm tra quyền admin
        $this->checkAdmin();
        
        // Tạo instance của Product model
        $productModel = new Product();
        
        // Lấy task từ tham số request (mặc định là 'list')
        $task = $this->input('task', 'list');
        
        // Xử lý xóa sản phẩm
        if ($task === 'delete' && $this->input('id')) {
            // Gọi phương thức delete của model
            if ($productModel->delete($this->input('id'))) {
                $this->setMessage('Xóa sản phẩm thành công!', 'success');
            } else {
                $this->setMessage('Lỗi khi xóa sản phẩm', 'error');
            }
            // Redirect về trang danh sách sản phẩm
            $this->redirect(APP_URL . '/?page=admin&action=products');
            return;
        }
        
        // Xử lý thêm hoặc sửa sản phẩm
        if ($task === 'add' || $task === 'edit') {
            // Hiển thị form thêm/sửa sản phẩm
            $product = null;
            
            // Nếu đang sửa, lấy thông tin sản phẩm
            if ($task === 'edit' && $this->input('id')) {
                $product = $productModel->getById($this->input('id'));
                if (!$product) {
                    // Sản phẩm không tồn tại
                    $this->setMessage('Sản phẩm không tồn tại', 'error');
                    $this->redirect(APP_URL . '/?page=admin&action=products');
                    return;
                }
            }
            
            // Xử lý submit form (nếu người dùng đã submit)
            if ($this->isMethod('POST')) {
                // Lấy thông tin từ form
                $name = trim($this->input('name'));
                $brand = trim($this->input('brand'));
                $cpu = trim($this->input('cpu'));
                $bo_nho_trong = trim($this->input('bo_nho_trong'));
                $pin = trim($this->input('pin'));
                $price = floatval($this->input('price', 0));
                $quantity = intval($this->input('quantity', 0));
                $description = trim($this->input('description'));
                $image = '';
                $errors = [];
                
                // Xử lý upload ảnh
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = APP_PATH . '/../public/assets/images/';
                    $fileTmpPath = $_FILES['image']['tmp_name'];
                    $fileName = $_FILES['image']['name'];
                    $fileSize = $_FILES['image']['size'];
                    $fileNameCmps = explode('.', $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    
                    // Các định dạng ảnh được phép
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (in_array($fileExtension, $allowedExtensions)) {
                        // Validate kích thước file (tối đa 5MB)
                        if ($fileSize <= 5 * 1024 * 1024) {
                            // Tạo tên file duy nhất
                            $newFileName = uniqid('product_', true) . '.' . $fileExtension;
                            $destPath = $uploadDir . $newFileName;
                            
                            // Di chuyển file từ temp đến đích
                            if (move_uploaded_file($fileTmpPath, $destPath)) {
                                $image = $newFileName;
                            } else {
                                $errors[] = 'Lỗi khi tải ảnh lên. Vui lòng thử lại!';
                            }
                        } else {
                            $errors[] = 'Kích thước ảnh không được vượt quá 5MB';
                        }
                    } else {
                        $errors[] = 'Định dạng ảnh không hợp lệ. Chỉ chấp nhận: JPG, JPEG, PNG, GIF, WEBP';
                    }
                }
                
                // Giữ nguyên ảnh cũ nếu đang sửa và không upload ảnh mới
                if ($task === 'edit' && empty($image) && isset($product['image'])) {
                    $image = $product['image'];
                }
                
                // Validate dữ liệu
                if (empty($name)) $errors[] = 'Vui lòng nhập tên sản phẩm';
                if ($price <= 0) $errors[] = 'Giá phải lớn hơn 0';
                if ($quantity < 0) $errors[] = 'Số lượng không được âm';
                if (!is_numeric($price)) $errors[] = 'Giá phải là số';
                if (!is_numeric($quantity)) $errors[] = 'Số lượng phải là số';
                
                // Nếu không có lỗi, tiếp tục xử lý
                if (empty($errors)) {
                    // Chuẩn bị dữ liệu để lưu
                    $data = [
                        'name' => $name,
                        'brand' => $brand,
                        'cpu' => $cpu,
                        'bo_nho_trong' => $bo_nho_trong,
                        'pin' => $pin,
                        'price' => $price,
                        'quantity' => $quantity,
                        'description' => $description,
                        'image' => $image
                    ];
                    
                    // Xử lý thêm sản phẩm mới
                    if ($task === 'add') {
                        if ($productModel->create($data)) {
                            $this->setMessage('Thêm sản phẩm thành công!', 'success');
                            $this->redirect(APP_URL . '/?page=admin&action=products');
                            return;
                        } else {
                            $this->setMessage('Lỗi khi thêm sản phẩm', 'error');
                        }
                    } elseif ($task === 'edit' && $this->input('id')) {
                        // Xử lý cập nhật sản phẩm
                        if ($productModel->update($this->input('id'), $data)) {
                            $this->setMessage('Cập nhật sản phẩm thành công!', 'success');
                            $this->redirect(APP_URL . '/?page=admin&action=products');
                            return;
                        } else {
                            $this->setMessage('Lỗi khi cập nhật sản phẩm', 'error');
                        }
                    }
                }
            }
            
            // Truyền dữ liệu cho view form
            $this->view('admin/product-form.php', [
                'task' => $task,              // 'add' hoặc 'edit'
                'product' => $product,         // Thông tin sản phẩm (nếu đang sửa)
                'errors' => $errors ?? []     // Mảng lỗi validate (nếu có)
            ]);
        } else {
            // Hiển thị danh sách sản phẩm
            $products = $productModel->getAllIncludingSoldOut();
            $this->view('admin/products.php', ['products' => $products]);
        }
    }
    
    /**
     * Quản lý đơn hàng (list, view, update status, delete)
     * 
     * Phương thức này xử lý các chức năng quản lý đơn hàng:
     * - task='list': Hiển thị danh sách đơn hàng
     * - task='view': Hiển thị chi tiết đơn hàng
     * - POST update_status: Cập nhật trạng thái đơn hàng
     * - POST delete_order: Xóa đơn hàng
     * 
     * @return void
     */
    public function orders() {
        // Kiểm tra quyền admin
        $this->checkAdmin();
        
        // Tạo instance của Order model
        $orderModel = new Order();
        
        // Lấy task từ tham số request (mặc định là 'list')
        $task = $this->input('task', 'list');
        
        // Xử lý POST cập nhật trạng thái đơn hàng
        if ($this->isMethod('POST') && $this->input('update_status')) {
            $order_id = (int)$this->input('order_id', 0);
            $status = $this->input('status', 'pending');

            if ($order_id > 0) {
                // Gọi phương thức updateStatusWithStockReturn của model
                // Method này sẽ tự động hoàn trả kho khi đơn hàng bị hủy
                $result = $orderModel->updateStatusWithStockReturn($order_id, $status);
                if ($result) {
                    $this->setMessage('Cập nhật trạng thái đơn hàng thành công!', 'success');
                } else {
                    $this->setMessage('Lỗi khi cập nhật trạng thái. Vui lòng thử lại!', 'error');
                }
            }
            $this->redirect(APP_URL . '/?page=admin&action=orders');
            return;
        }
        
        // Xử lý POST xóa đơn hàng
        if ($this->isMethod('POST') && $this->input('delete_order')) {
            $order_id = (int)$this->input('order_id', 0);

            if ($order_id > 0) {
                // Gọi phương thức delete của model
                $result = $orderModel->delete($order_id);
                if ($result) {
                    $this->setMessage('Xóa đơn hàng thành công!', 'success');
                } else {
                    $this->setMessage('Lỗi khi xóa đơn hàng. Vui lòng thử lại!', 'error');
                }
            }
            $this->redirect(APP_URL . '/?page=admin&action=orders');
            return;
        }

        // Xử lý POST sửa lại tổng tiền đơn hàng
        if ($this->isMethod('POST') && $this->input('recalculate_total')) {
            $order_id = (int)$this->input('order_id', 0);

            if ($order_id > 0) {
                // Tính toán lại tổng tiền
                $newTotal = $orderModel->recalculateOrderTotal($order_id);
                // Cập nhật tổng tiền
                $result = $orderModel->updateOrderTotal($order_id, $newTotal);
                if ($result) {
                    $this->setMessage('Đã sửa lại tổng tiền đơn hàng thành công!', 'success');
                } else {
                    $this->setMessage('Lỗi khi sửa tổng tiền đơn hàng. Vui lòng thử lại!', 'error');
                }
            }
            $this->redirect(APP_URL . '/?page=admin&action=orders');
            return;
        }
        
        // Xử lý xem chi tiết đơn hàng
        if ($task === 'view' && $this->input('id')) {
            // Tạo instance của User model
            $userModel = new User();

            // Lấy thông tin đơn hàng
            $order = $orderModel->getById($this->input('id'));

            // Kiểm tra xem đơn hàng có tồn tại không
            if (!$order) {
                $this->setMessage('Đơn hàng không tồn tại', 'error');
                $this->redirect(APP_URL . '/?page=admin&action=orders');
                return;
            }

            // Lấy thông tin người mua
            $user = $userModel->getById($order['user_id']);

            // Lấy chi tiết sản phẩm trong đơn hàng
            require_once APP_PATH . '/config/database.php';
            $db = Database::getInstance()->getConnection();

            $order_details_sql = "SELECT od.*, p.name, p.brand, p.cpu, p.bo_nho_trong, p.pin, p.image
                                 FROM order_details od
                                 JOIN products p ON od.product_id = p.id
                                 WHERE od.order_id = ?";
            $stmt = $db->prepare($order_details_sql);
            $stmt->execute([$this->input('id')]);
            $order_items = $stmt->fetchAll();

            // Truyền dữ liệu cho view
            $this->view('admin/order-view.php', [
                'order' => $order,           // Thông tin đơn hàng
                'user' => $user,             // Thông tin người mua
                'order_items' => $order_items // Chi tiết sản phẩm trong đơn hàng
            ]);
        } else {
            // Hiển thị danh sách đơn hàng
            $orders = $orderModel->getAll();
            $this->view('admin/orders.php', ['orders' => $orders]);
        }
    }
    
    /**
     * Quản lý người dùng (list, edit, reset password)
     * 
     * Phương thức này xử lý các chức năng quản lý người dùng:
     * - task='list': Hiển thị danh sách người dùng
     * - task='edit': Hiển thị form chỉnh sửa thông tin người dùng
     * - task='reset_password': Hiển thị form reset mật khẩu
     * - POST update_user: Cập nhật thông tin người dùng
     * - POST reset_password: Reset mật khẩu người dùng
     * 
     * @return void
     */
    public function users() {
        // Kiểm tra quyền admin
        $this->checkAdmin();
        
        // Tạo instance của User model
        $userModel = new User();
        
        // Lấy task từ tham số request (mặc định là 'list')
        $task = $this->input('task', 'list');
        
        // Xử lý POST xóa user
        if ($this->isMethod('POST') && $this->input('delete_user')) {
            $user_id = (int)$this->input('user_id', 0);

            if ($user_id > 0) {
                // Không cho phép xóa chính mình
                if ($user_id === $this->getCurrentUserId()) {
                    $this->setMessage('Không thể xóa tài khoản của chính bạn!', 'error');
                } else {
                    // Xóa user
                    $result = $userModel->delete($user_id);
                    if ($result) {
                        $this->setMessage('Xóa người dùng thành công!', 'success');
                    } else {
                        $this->setMessage('Lỗi khi xóa người dùng. Vui lòng thử lại!', 'error');
                    }
                }
            }
            $this->redirect(APP_URL . '/?page=admin&action=users');
            return;
        }

        // Xử lý POST reset mật khẩu
        if ($this->isMethod('POST') && $this->input('reset_password')) {
            $user_id = (int)$this->input('user_id', 0);
            $new_password = trim($this->input('new_password'));
            $confirm_password = trim($this->input('confirm_password'));
            $errors = [];

            if ($user_id > 0) {
                // Validate mật khẩu
                if (empty($new_password)) {
                    $errors[] = 'Vui lòng nhập mật khẩu mới';
                } elseif (strlen($new_password) < 6) {
                    $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự';
                } elseif ($new_password !== $confirm_password) {
                    $errors[] = 'Mật khẩu xác nhận không khớp';
                }

                if (empty($errors)) {
                    // Reset mật khẩu
                    $result = $userModel->update($user_id, [
                        'password' => $new_password
                    ]);

                    if ($result) {
                        $this->setMessage('Đặt lại mật khẩu thành công!', 'success');
                        $this->redirect(APP_URL . '/?page=admin&action=users');
                        return;
                    } else {
                        $this->setMessage('Lỗi khi đặt lại mật khẩu. Vui lòng thử lại!', 'error');
                    }
                }
            }

            // Nếu có lỗi, hiển thị lại form với lỗi
            $user = $userModel->getById($user_id);
            $this->view('admin/user-reset-password.php', [
                'user' => $user,
                'errors' => $errors
            ]);
            return;
        }

        // Xử lý POST cập nhật thông tin user
        if ($this->isMethod('POST') && $this->input('update_user')) {
            $user_id = (int)$this->input('user_id', 0);
            $fullname = trim($this->input('fullname'));
            $phone = trim($this->input('phone'));
            $address = trim($this->input('address'));
            
            if ($user_id > 0) {
                // Làm sạch số điện thoại (xóa ký tự không phải số)
                $phoneClean = preg_replace('/[^0-9]/', '', $phone);
                
                // Cập nhật thông tin trong database
                $result = $userModel->update($user_id, [
                    'fullname' => $fullname,
                    'phone' => $phoneClean,
                    'address' => $address
                ]);
                
                if ($result) {
                    $this->setMessage('Cập nhật thông tin người dùng thành công!', 'success');
                } else {
                    $this->setMessage('Lỗi khi cập nhật thông tin. Vui lòng thử lại!', 'error');
                }
            }
            $this->redirect(APP_URL . '/?page=admin&action=users');
            return;
        }
        
        // Xử lý xem form reset mật khẩu
        if ($task === 'reset_password' && $this->input('id')) {
            $user = $userModel->getById($this->input('id'));
            $this->view('admin/user-reset-password.php', [
                'user' => $user,
                'errors' => []
            ]);
            return;
        }
        
        // Xử lý xem form chỉnh sửa user
        if ($task === 'edit' && $this->input('id')) {
            // Lấy thông tin user
            $user = $userModel->getById($this->input('id'));
            $this->view('admin/user-edit.php', ['user' => $user]);
        } else {
            // Hiển thị danh sách user
            $users = $userModel->getAll();
            $this->view('admin/users.php', ['users' => $users]);
        }
    }
    
    /**
     * Hiển thị thống kê chi tiết
     * 
     * Phương thức này thực hiện các chức năng:
     * 1. Lấy tất cả dữ liệu (sản phẩm, người dùng, đơn hàng)
     * 2. Tính toán các thống kê
     * 3. Truyền dữ liệu chi tiết cho view để hiển thị biểu đồ
     * 
     * @return void
     */
    public function statistics() {
        // Kiểm tra quyền admin
        $this->checkAdmin();
        
        // Tạo instance của các model cần thiết
        $productModel = new Product();
        $userModel = new User();
        $orderModel = new Order();
        
        // Lấy tất cả dữ liệu
        $allProducts = $productModel->getAll();
        $allUsers = $userModel->getAll();
        $allOrders = $orderModel->getAll();
        
        // Tính toán thống kê
        $totalProducts = count($allProducts);
        $totalUsers = count($allUsers);
        $totalOrders = count($allOrders);
        
        // Tính tổng doanh thu
        $totalRevenue = 0;
        foreach ($allOrders as $order) {
            $totalRevenue += $order['total_amount'];
        }
        
        // Truyền dữ liệu chi tiết cho view
        $this->view('admin/statistics.php', [
            'allProducts' => $allProducts,    // Tất cả sản phẩm
            'allUsers' => $allUsers,            // Tất cả người dùng
            'allOrders' => $allOrders,          // Tất cả đơn hàng
            'totalProducts' => $totalProducts,  // Tổng số sản phẩm
            'totalUsers' => $totalUsers,        // Tổng số người dùng
            'totalOrders' => $totalOrders,      // Tổng số đơn hàng
            'totalRevenue' => $totalRevenue     // Tổng doanh thu
        ]);
    }
}
