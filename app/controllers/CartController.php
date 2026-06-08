<?php
/**
 * CartController - Controller xử lý giỏ hàng
 * 
 * Controller này chịu trách nhiệm xử lý tất cả các chức năng liên quan đến
 * giỏ hàng trong hệ thống, bao gồm:
 * - Hiển thị giỏ hàng: Liệt kê các sản phẩm đã thêm và tính tổng tiền
 * - Thêm sản phẩm: Thêm sản phẩm vào giỏ hàng hoặc tăng số lượng
 * - Xóa sản phẩm: Xóa sản phẩm khỏi giỏ hàng
 * - Cập nhật số lượng: Thay đổi số lượng của các sản phẩm trong giỏ
 * 
 * Giỏ hàng được lưu trong session với cấu trúc:
 * $_SESSION['cart'] = [
 *     product_id => quantity,
 *     product_id => quantity,
 *     ...
 * ]
 * 
 * Các phương thức chính:
 * - index(): Hiển thị trang giỏ hàng với danh sách sản phẩm và tổng tiền
 * - add(): Thêm sản phẩm vào giỏ hàng (chỉ chấp nhận POST)
 * - remove(): Xóa sản phẩm khỏi giỏ hàng
 * - update(): Cập nhật số lượng sản phẩm trong giỏ hàng (chỉ chấp nhận POST)
 * 
 * @package App\Controllers
 */

require_once APP_PATH . '/controllers/Controller.php';
require_once APP_PATH . '/models/Product.php';

class CartController extends Controller {
    
    /**
     * Hiển thị trang giỏ hàng
     * 
     * Phương thức này thực hiện các chức năng:
     * 1. Lấy giỏ hàng từ session (mảng product_id => quantity)
     * 2. Duyệt qua từng sản phẩm trong giỏ để lấy thông tin chi tiết
     * 3. Tính tổng tiền của giỏ hàng
     * 4. Truyền dữ liệu cho view để hiển thị
     * 
     * @return void
     */
    public function index() {
        // Tạo instance của Product model để lấy thông tin sản phẩm
        $productModel = new Product();
        
        // Lấy giỏ hàng từ session, nếu không có thì mảng rỗng
        $cart = $_SESSION['cart'] ?? [];
        
        // Khởi tạo biến để lưu tổng tiền và danh sách sản phẩm
        $total = 0;
        $cartItems = [];
        
        // Nếu giỏ hàng không rỗng, xử lý từng sản phẩm
        if (!empty($cart)) {
            foreach ($cart as $product_id => $quantity) {
                // Lấy thông tin chi tiết của sản phẩm từ database
                $product = $productModel->getById($product_id);
                
                // Nếu sản phẩm tồn tại, thêm vào danh sách
                if ($product) {
                    $cartItems[] = [
                        'product' => $product,                              // Thông tin sản phẩm
                        'quantity' => $quantity,                            // Số lượng
                        'subtotal' => $product['price'] * $quantity         // Thành tiền (giá x số lượng)
                    ];
                    // Cộng dồn vào tổng tiền
                    $total += $product['price'] * $quantity;
                }
            }
        }
        
        // Truyền dữ liệu cho view để hiển thị
        $this->view('cart/index.php', [
            'cartItems' => $cartItems,    // Danh sách sản phẩm trong giỏ với thông tin chi tiết
            'total' => $total             // Tổng tiền của giỏ hàng
        ]);
    }
    
    /**
     * Thêm sản phẩm vào giỏ hàng
     * 
     * Phương thức này thực hiện các chức năng:
     * 1. Kiểm tra request có phải POST không (chỉ chấp nhận POST)
     * 2. Lấy product_id và quantity từ form
     * 3. Validate product_id và quantity (phải > 0)
     * 4. Nếu sản phẩm đã có trong giỏ: Tăng số lượng
     * 5. Nếu sản phẩm chưa có: Thêm mới vào giỏ
     * 6. Redirect về trang giỏ hàng
     * 
     * @return void
     */
    public function add() {
        // Chỉ chấp nhận request POST để bảo mật
        if (!$this->isMethod('POST')) {
            $this->redirect(APP_URL . '/?page=cart');
            return;
        }
        
        // Lấy product_id và quantity từ form
        $product_id = (int)$this->input('product_id', 0);
        $quantity = (int)$this->input('quantity', 1);
        
        // Validate product_id và quantity
        if ($product_id > 0 && $quantity > 0) {
            // Khởi tạo giỏ hàng nếu chưa tồn tại trong session
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            // Kiểm tra xem sản phẩm đã có trong giỏ chưa
            if (isset($_SESSION['cart'][$product_id])) {
                // Sản phẩm đã có - Tăng số lượng
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Sản phẩm chưa có - Thêm mới vào giỏ
                $_SESSION['cart'][$product_id] = $quantity;
            }
            
            // Đặt thông báo thành công
            $this->setMessage('Đã thêm vào giỏ hàng thành công', 'success');
        }
        
        // Redirect về trang giỏ hàng
        $this->redirect(APP_URL . '/?page=cart');
    }
    
    /**
     * Xóa sản phẩm khỏi giỏ hàng
     * 
     * Phương thức này thực hiện các chức năng:
     * 1. Lấy product_id từ tham số request
     * 2. Kiểm tra sản phẩm có trong giỏ không
     * 3. Nếu có: Xóa khỏi giỏ và đặt thông báo
     * 4. Redirect về trang giỏ hàng
     * 
     * @return void
     */
    public function remove() {
        // Lấy product_id từ tham số request
        $product_id = (int)$this->input('id', 0);
        
        // Kiểm tra xem sản phẩm có trong giỏ không
        if (isset($_SESSION['cart'][$product_id])) {
            // Xóa sản phẩm khỏi giỏ
            unset($_SESSION['cart'][$product_id]);
            // Đặt thông báo
            $this->setMessage('Đã xóa sản phẩm khỏi giỏ hàng', 'info');
        }
        
        // Redirect về trang giỏ hàng
        $this->redirect(APP_URL . '/?page=cart');
    }
    
    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     *
     * Phương thức này thực hiện các chức năng:
     * 1. Kiểm tra request có phải POST không (chỉ chấp nhận POST)
     * 2. Lấy mảng quantity từ form (product_id => quantity)
     * 3. Duyệt qua từng sản phẩm để cập nhật số lượng
     * 4. Kiểm tra số lượng không vượt quá tồn kho
     * 5. Nếu quantity <= 0: Xóa sản phẩm khỏi giỏ
     * 6. Nếu quantity > 0: Cập nhật số lượng
     * 7. Redirect về trang giỏ hàng
     *
     * @return void
     */
    public function update() {
        // Chỉ chấp nhận request POST để bảo mật
        if (!$this->isMethod('POST')) {
            $this->redirect(APP_URL . '/?page=cart');
            return;
        }

        // Khởi tạo giỏ hàng nếu chưa tồn tại
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Tạo instance của Product model để kiểm tra tồn kho
        $productModel = new Product();

        // Lấy mảng quantity từ form (product_id => quantity)
        $quantities = $this->input('quantity', []);

        $errors = [];

        // Duyệt qua từng sản phẩm để cập nhật số lượng
        foreach ($quantities as $product_id => $quantity) {
            // Ép kiểu sang int
            $product_id = (int)$product_id;
            $quantity = (int)$quantity;

            // Nếu số lượng <= 0, xóa sản phẩm khỏi giỏ
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                // Kiểm tra tồn kho trước khi cập nhật
                $product = $productModel->getById($product_id);
                if ($product) {
                    if ($quantity > $product['quantity']) {
                        // Số lượng yêu cầu vượt quá tồn kho
                        $errors[] = "Sản phẩm '{$product['name']}' chỉ còn {$product['quantity']} trong kho";
                        // Giới hạn số lượng bằng tồn kho
                        $_SESSION['cart'][$product_id] = $product['quantity'];
                    } else {
                        // Nếu số lượng hợp lệ, cập nhật số lượng
                        $_SESSION['cart'][$product_id] = $quantity;
                    }
                } else {
                    // Sản phẩm không tồn tại, xóa khỏi giỏ
                    unset($_SESSION['cart'][$product_id]);
                }
            }
        }

        // Đặt thông báo
        if (!empty($errors)) {
            $this->setMessage('Cập nhật giỏ hàng với một số giới hạn: ' . implode(', ', $errors), 'warning');
        } else {
            $this->setMessage('Cập nhật giỏ hàng thành công', 'success');
        }

        // Kiểm tra xem có redirect đến checkout không
        $redirectToCheckout = $this->input('redirect_to_checkout', 0);
        if ($redirectToCheckout) {
            $this->redirect(APP_URL . '/?page=checkout');
        } else {
            // Redirect về trang giỏ hàng
            $this->redirect(APP_URL . '/?page=cart');
        }
    }
}
