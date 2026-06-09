<?php
/**
 * Cart API Controller
 *
 * Handles cart endpoints:
 * - GET /api/cart - Get cart contents
 * - POST /api/cart/items - Add item to cart
 * - PUT /api/cart/items/:productId - Update item quantity
 * - DELETE /api/cart/items/:productId - Remove item from cart
 */

require_once APP_PATH . '/controllers/api/ApiController.php';
require_once APP_PATH . '/models/Product.php';

class CartApiController extends ApiController {

    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    /**
     * Get cart contents
     */
    public function index() {
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            foreach ($cart as $productId => $quantity) {
                $product = $this->productModel->getById($productId);
                if ($product) {
                    $subtotal = $product['price'] * $quantity;
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal
                    ];
                    $total += $subtotal;
                }
            }
        }

        $this->success([
            'items' => $cartItems,
            'total' => $total
        ]);
    }

    /**
     * Add item to cart
     */
    public function add() {
        $input = $this->getInput();
        $productId = isset($input['product_id']) ? (int)$input['product_id'] : 0;
        $quantity = isset($input['quantity']) ? (int)$input['quantity'] : 1;

        if ($productId <= 0 || $quantity <= 0) {
            $this->error('Invalid product ID or quantity', 422);
        }

        // Check if product exists and has stock
        $product = $this->productModel->getById($productId);
        if (!$product) {
            $this->error('Product not found', 404);
        }

        // Initialize cart if needed
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add or update item
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }

        $this->success(null, 'Item added to cart');
    }

    /**
     * Update item quantity in cart
     */
    public function update() {
        $input = $this->getInput();
        $productId = isset($input['product_id']) ? (int)$input['product_id'] : 0;
        $quantity = isset($input['quantity']) ? (int)$input['quantity'] : 0;

        if ($productId <= 0) {
            $this->error('Invalid product ID', 422);
        }

        // Initialize cart if needed
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if ($quantity <= 0) {
            // Remove item if quantity is zero or less
            unset($_SESSION['cart'][$productId]);
        } else {
            // Check stock
            $product = $this->productModel->getById($productId);
            if ($product && $quantity > $product['quantity']) {
                $this->error('Insufficient stock', 422);
            }
            // Update quantity
            $_SESSION['cart'][$productId] = $quantity;
        }

        $this->success(null, 'Cart updated');
    }

    /**
     * Remove item from cart
     */
    public function remove() {
        $input = $this->getInput();
        $productId = isset($input['id']) ? (int)$input['id'] : 0;

        if ($productId <= 0) {
            $this->error('Invalid product ID', 422);
        }

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        $this->success(null, 'Item removed from cart');
    }
}
?>