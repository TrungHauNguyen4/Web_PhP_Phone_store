<?php
/**
 * OrderController - Controller xử lý đơn hàng
 * 
 * Controller này chịu trách nhiệm xử lý tất cả các chức năng liên quan đến
 * đơn hàng trong hệ thống, bao gồm:
 * - Thanh toán: Hiển thị form thanh toán và tạo đơn hàng từ giỏ hàng
 * - Danh sách đơn hàng: Hiển thị các đơn hàng của người dùng hiện tại
 * 
 * Các phương thức chính:
 * - checkout(): Hiển thị trang thanh toán và xử lý logic tạo đơn hàng
 * - index(): Hiển thị danh sách đơn hàng của người dùng
 * 
 * @package App\Controllers
 */

require_once APP_PATH . '/controllers/Controller.php';
require_once APP_PATH . '/models/Order.php';
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/User.php';

class OrderController extends Controller {
    
    /**
     * Hiển thị trang thanh toán và xử lý logic tạo đơn hàng
     * 
     * Phương thức này thực hiện hai nhiệm vụ:
     * 1. Nếu request là GET: Hiển thị form thanh toán với thông tin giỏ hàng
     * 2. Nếu request là POST: Xử lý logic tạo đơn hàng
     *    - Validate thông tin người mua
     *    - Tạo đơn hàng trong database
     *    - Thêm chi tiết sản phẩm vào đơn hàng
     *    - Xóa giỏ hàng sau khi đặt hàng thành công
     *    - Redirect về trang chủ
     * 
     * @return void
     */
    public function checkout() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        // Chỉ người dùng đã đăng nhập mới có thể đặt hàng
        if (!$this->isLoggedIn()) {
            $this->redirect(APP_URL . '/?page=auth&action=login');
            return;
        }
        
        // Tạo instance của các model cần thiết
        $productModel = new Product();
        $userModel = new User();
        
        // Lấy giỏ hàng từ session, nếu không có thì mảng rỗng
        $cart = $_SESSION['cart'] ?? [];
        
        // Kiểm tra xem giỏ hàng có trống không
        if (empty($cart)) {
            // Giỏ hàng trống - Hiển thị thông báo và link đến trang sản phẩm
            echo '<div class="container"><div class="card text-center"><div class="card-body">';
            echo '<p class="mb-4">Giỏ hàng của bạn đang trống</p>';
            echo '<a href="' . APP_URL . '/?page=products" class="btn btn-primary btn-lg">→ Tiếp tục mua sắm</a>';
            echo '</div></div></div>';
            return;
        }
        
        // Lấy chi tiết sản phẩm trong giỏ hàng và tính tổng tiền
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $product_id => $quantity) {
            // Lấy thông tin chi tiết của sản phẩm từ database
            $product = $productModel->getById($product_id);
            if ($product) {
                // Thêm sản phẩm vào danh sách với thông tin chi tiết
                $cartItems[] = [
                    'product' => $product,                              // Thông tin sản phẩm
                    'quantity' => $quantity,                            // Số lượng
                    'subtotal' => $product['price'] * $quantity         // Thành tiền
                ];
                // Cộng dồn vào tổng tiền
                $total += $product['price'] * $quantity;
            }
        }
        
        // Xử lý submit đơn hàng (nếu người dùng đã submit form)
        $submitted = false;
        $isPost = $this->isMethod('POST');
        $hasSubmitOrder = $this->input('submit_order');

        if ($isPost && $hasSubmitOrder) {
            $submitted = true;
            // Lấy thông tin người mua từ form
            $fullname = trim($this->input('fullname'));
            $phone = trim($this->input('phone'));
            $email = trim($this->input('email'));
            $address = trim($this->input('address'));
            $payment_method = trim($this->input('payment_method', 'transfer'));

            // Validate thông tin form
            $errors = [];
            if (empty($fullname)) $errors[] = 'Vui lòng nhập họ tên';
            if (empty($phone) || !preg_match('/^[0-9]{9,11}$/', preg_replace('/[^0-9]/', '', $phone))) $errors[] = 'Vui lòng nhập số điện thoại hợp lệ';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Vui lòng nhập email hợp lệ';
            if (empty($address)) $errors[] = 'Vui lòng nhập địa chỉ giao hàng';

            // Nếu không có lỗi validate, tiếp tục xử lý
            if (empty($errors)) {
                // Tạo instance của Order model
                $orderModel = new Order();

                // Chuẩn bị dữ liệu cho đơn hàng với transaction
                $orderData = [
                    'user_id' => $this->getCurrentUserId(),
                    'total_amount' => $total,
                    'payment_method' => $payment_method,
                    'shipping_fullname' => $fullname,
                    'shipping_phone' => $phone,
                    'shipping_email' => $email,
                    'shipping_address' => $address
                ];

                // Chuẩn bị dữ liệu chi tiết sản phẩm (lưu đơn giá, không phải subtotal)
                $cartItemsData = [];
                foreach ($cartItems as $item) {
                    $cartItemsData[] = [
                        'product_id' => $item['product']['id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['product']['price'] // Lưu đơn giá
                    ];
                }

                // Tạo đơn hàng với transaction, kiểm tra tồn kho và trừ kho
                $order_id = $orderModel->createWithTransaction($orderData, $cartItemsData);

                // Kiểm tra xem tạo đơn hàng thành công không
                if ($order_id) {
                    // Xóa giỏ hàng sau khi đặt hàng thành công
                    unset($_SESSION['cart']);

                    // Đặt thông báo thành công với mã đơn hàng vào session
                    $this->setMessage('Đơn hàng của bạn đã được tạo thành công! Mã đơn hàng: #' . $order_id, 'success');

                    // Redirect về trang đơn hàng (PRG pattern - Post/Redirect/Get)
                    // Điều này ngăn chặn trình duyệt resubmit form khi người dùng nhấn nút quay lại
                    $this->redirect(APP_URL . '/?page=orders');
                    return;
                } else {
                    // Tạo đơn hàng thất bại - Đặt thông báo lỗi
                    $this->setMessage('Lỗi khi tạo đơn hàng. Có thể do không đủ hàng tồn kho. Vui lòng thử lại!', 'error');
                    $submitted = true;
                }
            } else {
                // Có lỗi validate - Đánh dấu là đã submit để hiển thị lỗi
                $submitted = true;
            }
        }
        
        // Lấy thông tin user để điền vào form (tự động điền thông tin đã có)
        $user = $userModel->getById($this->getCurrentUserId());
        
        // Truyền dữ liệu cho view để hiển thị
        $this->view('checkout/index.php', [
            'cartItems' => $cartItems,        // Danh sách sản phẩm trong giỏ
            'total' => $total,               // Tổng tiền
            'user' => $user,                 // Thông tin người dùng
            'submitted' => $submitted,       // Biến flag nếu form đã được submit
            'errors' => $errors ?? [],       // Mảng lỗi validate (nếu có)
            'debugInfo' => $debugInfo ?? []  // Debug info
        ]);
    }
    
    /**
     * Hiển thị danh sách đơn hàng của người dùng
     * 
     * Phương thức này thực hiện các chức năng:
     * 1. Kiểm tra xem người dùng đã đăng nhập chưa
     * 2. Lấy danh sách đơn hàng của người dùng từ database
     * 3. Truyền dữ liệu cho view để hiển thị
     * 
     * @return void
     */
    public function index() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!$this->isLoggedIn()) {
            // Chưa đăng nhập - Redirect đến trang đăng nhập
            $this->redirect(APP_URL . '/?page=auth&action=login');
            return;
        }
        
        // Tạo instance của các model cần thiết
        $orderModel = new Order();
        $userModel = new User();
        
        // Lấy ID của người dùng hiện tại
        $user_id = $this->getCurrentUserId();
        
        // Lấy thông tin chi tiết của người dùng
        $user = $userModel->getById($user_id);
        
        // Lấy danh sách đơn hàng của người dùng từ database
        $orders = $orderModel->getByUserId($user_id);
        
        // Truyền dữ liệu cho view để hiển thị
        $this->view('orders/index.php', [
            'orders' => $orders,         // Danh sách đơn hàng của người dùng
            'user' => $user,             // Thông tin người dùng
            'orderModel' => $orderModel  // Order model để lấy chi tiết đơn hàng
        ]);
    }
}
