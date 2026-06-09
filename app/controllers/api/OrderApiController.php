<?php
/**
 * Order API Controller
 *
 * Handles order endpoints:
 * - GET /api/orders - Get user's order history
 * - POST /api/orders - Create new order (checkout)
 * - GET /api/orders/:id - Get order detail
 */

require_once APP_PATH . '/controllers/api/ApiController.php';
require_once APP_PATH . '/models/Order.php';
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/User.php';

class OrderApiController extends ApiController {

    private $orderModel;
    private $productModel;
    private $userModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->productModel = new Product();
        $this->userModel = new User();
    }

    /**
     * Get user's order history
     */
    public function index() {
        $this->requireAuth();
        $userId = $this->getCurrentUserId();
        $orders = $this->orderModel->getByUserId($userId);
        $this->success(['orders' => $orders]);
    }

    /**
     * Create new order (checkout)
     */
    public function checkout() {
        $this->requireAuth();
        $input = $this->getInput();
        $errors = [];

        // Get cart
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $this->error('Cart is empty', 422);
        }

        // Validate shipping info
        if (empty($input['shipping_fullname'])) {
            $errors[] = 'Full name is required';
        }
        if (empty($input['shipping_phone'])) {
            $errors[] = 'Phone number is required';
        }
        if (empty($input['shipping_email']) || !filter_var($input['shipping_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
        if (empty($input['shipping_address'])) {
            $errors[] = 'Shipping address is required';
        }

        if (!empty($errors)) {
            $this->error('Validation failed', 422, $errors);
        }

        // Calculate total and prepare cart items data
        $cartItemsData = [];
        $total = 0;
        foreach ($cart as $productId => $quantity) {
            $product = $this->productModel->getById($productId);
            if ($product) {
                $cartItemsData[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product['price']
                ];
                $total += $product['price'] * $quantity;
            }
        }

        // Prepare order data
        $orderData = [
            'user_id' => $this->getCurrentUserId(),
            'total_amount' => $total,
            'payment_method' => $input['payment_method'] ?? 'transfer',
            'shipping_fullname' => $input['shipping_fullname'],
            'shipping_phone' => $input['shipping_phone'],
            'shipping_email' => $input['shipping_email'],
            'shipping_address' => $input['shipping_address']
        ];

        // Create order with transaction
        $orderId = $this->orderModel->createWithTransaction($orderData, $cartItemsData);

        if ($orderId) {
            // Clear cart
            unset($_SESSION['cart']);

            // Get created order
            $order = $this->orderModel->getById($orderId);
            $orderDetails = $this->orderModel->getOrderDetails($orderId);
            $this->success([
                'order' => $order,
                'order_details' => $orderDetails
            ], 'Order created successfully', 201);
        } else {
            $this->error('Order creation failed (insufficient stock)', 422);
        }
    }

    /**
     * Get order detail by ID
     */
    public function detail() {
        $this->requireAuth();
        $input = $this->getInput();
        $orderId = isset($input['id']) ? (int)$input['id'] : 0;
        $userId = $this->getCurrentUserId();

        if ($orderId <= 0) {
            $this->error('Invalid order ID', 422);
        }

        $order = $this->orderModel->getById($orderId);

        if (!$order) {
            $this->error('Order not found', 404);
        }

        // Check if order belongs to current user
        if ($order['user_id'] !== $userId && !$this->isAdmin()) {
            $this->forbidden();
        }

        $orderDetails = $this->orderModel->getOrderDetails($orderId);

        $this->success([
            'order' => $order,
            'order_details' => $orderDetails
        ]);
    }
}
?>