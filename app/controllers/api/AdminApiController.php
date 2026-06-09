<?php
/**
 * Admin API Controller
 *
 * Handles admin endpoints:
 * - Dashboard, Products, Orders, Users, Statistics
 */

require_once APP_PATH . '/controllers/api/ApiController.php';
require_once APP_PATH . '/models/Product.php';
require_once APP_PATH . '/models/Order.php';
require_once APP_PATH . '/models/User.php';

class AdminApiController extends ApiController {

    private $productModel;
    private $orderModel;
    private $userModel;

    public function __construct() {
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->userModel = new User();
    }

    // ==================== DASHBOARD ====================

    /**
     * Get dashboard statistics
     */
    public function dashboard() {
        $this->requireAdmin();

        $products = $this->productModel->getAll();
        $users = $this->userModel->getAll();
        $orders = $this->orderModel->getAll();

        $totalRevenue = 0;
        foreach ($orders as $order) {
            $totalRevenue += $order['total_amount'];
        }

        $this->success([
            'totalProducts' => count($products),
            'totalUsers' => count($users),
            'totalOrders' => count($orders),
            'totalRevenue' => $totalRevenue
        ]);
    }

    // ==================== PRODUCTS ====================

    /**
     * Get all products (including out of stock)
     */
    public function products() {
        $this->requireAdmin();
        $products = $this->productModel->getAllIncludingSoldOut();
        $this->success(['products' => $products]);
    }

    /**
     * Get single product
     */
    public function getProduct() {
        $this->requireAdmin();
        $input = $this->getInput();
        $productId = isset($input['id']) ? (int)$input['id'] : 0;

        if ($productId <= 0) {
            $this->error('Invalid product ID', 422);
        }

        $product = $this->productModel->getById($productId);
        if (!$product) {
            $this->error('Product not found', 404);
        }

        $this->success(['product' => $product]);
    }

    /**
     * Create new product
     */
    public function createProduct() {
        $this->requireAdmin();
        $input = $this->getInput();
        $errors = [];

        // Validate input
        if (empty($input['name'])) {
            $errors[] = 'Product name is required';
        }
        if (empty($input['price']) || !is_numeric($input['price']) || $input['price'] <= 0) {
            $errors[] = 'Valid price is required';
        }
        if (!isset($input['quantity']) || !is_numeric($input['quantity']) || $input['quantity'] < 0) {
            $errors[] = 'Valid quantity is required';
        }

        if (!empty($errors)) {
            $this->error('Validation failed', 422, $errors);
        }

        // Handle image upload (if any) - note: file uploads need special handling
        $image = $input['image'] ?? null;

        $data = [
            'name' => $input['name'],
            'brand' => $input['brand'] ?? null,
            'cpu' => $input['cpu'] ?? null,
            'bo_nho_trong' => $input['bo_nho_trong'] ?? null,
            'pin' => $input['pin'] ?? null,
            'price' => $input['price'],
            'quantity' => $input['quantity'],
            'description' => $input['description'] ?? null,
            'image' => $image
        ];

        $result = $this->productModel->create($data);

        if ($result) {
            $this->success(null, 'Product created successfully', 201);
        } else {
            $this->error('Product creation failed', 500);
        }
    }

    /**
     * Update product
     */
    public function updateProduct() {
        $this->requireAdmin();
        $input = $this->getInput();
        $productId = isset($input['id']) ? (int)$input['id'] : 0;
        $errors = [];

        if ($productId <= 0) {
            $this->error('Invalid product ID', 422);
        }

        $existingProduct = $this->productModel->getById($productId);
        if (!$existingProduct) {
            $this->error('Product not found', 404);
        }

        // Validate input
        if (empty($input['name'])) {
            $errors[] = 'Product name is required';
        }
        if (empty($input['price']) || !is_numeric($input['price']) || $input['price'] <= 0) {
            $errors[] = 'Valid price is required';
        }
        if (!isset($input['quantity']) || !is_numeric($input['quantity']) || $input['quantity'] < 0) {
            $errors[] = 'Valid quantity is required';
        }

        if (!empty($errors)) {
            $this->error('Validation failed', 422, $errors);
        }

        $data = [
            'name' => $input['name'],
            'brand' => $input['brand'] ?? null,
            'cpu' => $input['cpu'] ?? null,
            'bo_nho_trong' => $input['bo_nho_trong'] ?? null,
            'pin' => $input['pin'] ?? null,
            'price' => $input['price'],
            'quantity' => $input['quantity'],
            'description' => $input['description'] ?? null,
            'image' => $input['image'] ?? $existingProduct['image']
        ];

        $result = $this->productModel->update($productId, $data);

        if ($result) {
            $this->success(null, 'Product updated successfully');
        } else {
            $this->error('Product update failed', 500);
        }
    }

    /**
     * Delete product
     */
    public function deleteProduct() {
        $this->requireAdmin();
        $input = $this->getInput();
        $productId = isset($input['id']) ? (int)$input['id'] : 0;

        if ($productId <= 0) {
            $this->error('Invalid product ID', 422);
        }

        $result = $this->productModel->delete($productId);

        if ($result) {
            $this->success(null, 'Product deleted successfully');
        } else {
            $this->error('Product deletion failed', 500);
        }
    }

    // ==================== ORDERS ====================

    /**
     * Get all orders
     */
    public function orders() {
        $this->requireAdmin();
        $orders = $this->orderModel->getAll();
        $this->success(['orders' => $orders]);
    }

    /**
     * Get single order with details
     */
    public function getOrder() {
        $this->requireAdmin();
        $input = $this->getInput();
        $orderId = isset($input['id']) ? (int)$input['id'] : 0;

        if ($orderId <= 0) {
            $this->error('Invalid order ID', 422);
        }

        $order = $this->orderModel->getById($orderId);
        if (!$order) {
            $this->error('Order not found', 404);
        }

        $user = $this->userModel->getById($order['user_id']);
        $orderDetails = $this->orderModel->getOrderDetails($orderId);

        $this->success([
            'order' => $order,
            'user' => $user,
            'order_details' => $orderDetails
        ]);
    }

    /**
     * Update order status
     */
    public function updateOrderStatus() {
        $this->requireAdmin();
        $input = $this->getInput();
        $orderId = isset($input['order_id']) ? (int)$input['order_id'] : 0;
        $status = $input['status'] ?? 'pending';

        if ($orderId <= 0) {
            $this->error('Invalid order ID', 422);
        }

        $result = $this->orderModel->updateStatusWithStockReturn($orderId, $status);

        if ($result) {
            $this->success(null, 'Order status updated successfully');
        } else {
            $this->error('Order status update failed', 500);
        }
    }

    /**
     * Delete order
     */
    public function deleteOrder() {
        $this->requireAdmin();
        $input = $this->getInput();
        $orderId = isset($input['id']) ? (int)$input['id'] : 0;

        if ($orderId <= 0) {
            $this->error('Invalid order ID', 422);
        }

        $result = $this->orderModel->delete($orderId);

        if ($result) {
            $this->success(null, 'Order deleted successfully');
        } else {
            $this->error('Order deletion failed', 500);
        }
    }

    // ==================== USERS ====================

    /**
     * Get all users
     */
    public function users() {
        $this->requireAdmin();
        $users = $this->userModel->getAll();
        $this->success(['users' => $users]);
    }

    /**
     * Get single user
     */
    public function getUser() {
        $this->requireAdmin();
        $input = $this->getInput();
        $userId = isset($input['id']) ? (int)$input['id'] : 0;

        if ($userId <= 0) {
            $this->error('Invalid user ID', 422);
        }

        $user = $this->userModel->getById($userId);
        if (!$user) {
            $this->error('User not found', 404);
        }

        $this->success(['user' => $user]);
    }

    /**
     * Update user
     */
    public function updateUser() {
        $this->requireAdmin();
        $input = $this->getInput();
        $userId = isset($input['id']) ? (int)$input['id'] : 0;

        if ($userId <= 0) {
            $this->error('Invalid user ID', 422);
        }

        $existingUser = $this->userModel->getById($userId);
        if (!$existingUser) {
            $this->error('User not found', 404);
        }

        $data = [
            'fullname' => $input['fullname'] ?? $existingUser['fullname'],
            'phone' => $input['phone'] ?? $existingUser['phone'],
            'address' => $input['address'] ?? $existingUser['address']
        ];

        $result = $this->userModel->update($userId, $data);

        if ($result) {
            $this->success(null, 'User updated successfully');
        } else {
            $this->error('User update failed', 500);
        }
    }

    /**
     * Reset user password
     */
    public function resetUserPassword() {
        $this->requireAdmin();
        $input = $this->getInput();
        $userId = isset($input['user_id']) ? (int)$input['user_id'] : 0;
        $errors = [];

        if ($userId <= 0) {
            $this->error('Invalid user ID', 422);
        }

        $existingUser = $this->userModel->getById($userId);
        if (!$existingUser) {
            $this->error('User not found', 404);
        }

        if (empty($input['new_password'])) {
            $errors[] = 'New password is required';
        } elseif (strlen($input['new_password']) < 6) {
            $errors[] = 'New password must be at least 6 characters';
        }

        if (empty($input['password_confirm']) || $input['new_password'] !== $input['password_confirm']) {
            $errors[] = 'Password confirmation does not match';
        }

        if (!empty($errors)) {
            $this->error('Validation failed', 422, $errors);
        }

        $result = $this->userModel->update($userId, [
            'password' => $input['new_password']
        ]);

        if ($result) {
            $this->success(null, 'Password reset successfully');
        } else {
            $this->error('Password reset failed', 500);
        }
    }

    /**
     * Delete user
     */
    public function deleteUser() {
        $this->requireAdmin();
        $input = $this->getInput();
        $userId = isset($input['id']) ? (int)$input['id'] : 0;
        $currentUserId = $this->getCurrentUserId();

        if ($userId <= 0) {
            $this->error('Invalid user ID', 422);
        }

        // Don't allow deleting yourself
        if ($userId === $currentUserId) {
            $this->error('Cannot delete your own account', 403);
        }

        $result = $this->userModel->delete($userId);

        if ($result) {
            $this->success(null, 'User deleted successfully');
        } else {
            $this->error('User deletion failed', 500);
        }
    }

    // ==================== STATISTICS ====================

    /**
     * Get detailed statistics
     */
    public function statistics() {
        $this->requireAdmin();

        $products = $this->productModel->getAll();
        $users = $this->userModel->getAll();
        $orders = $this->orderModel->getAll();

        $totalRevenue = 0;
        foreach ($orders as $order) {
            $totalRevenue += $order['total_amount'];
        }

        $this->success([
            'allProducts' => $products,
            'allUsers' => $users,
            'allOrders' => $orders,
            'totalProducts' => count($products),
            'totalUsers' => count($users),
            'totalOrders' => count($orders),
            'totalRevenue' => $totalRevenue
        ]);
    }
}
?>