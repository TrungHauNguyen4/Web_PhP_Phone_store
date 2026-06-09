<?php
/**
 * Product API Controller
 *
 * Handles product endpoints:
 * - GET /api/products - Get product list (with search & filter)
 * - GET /api/products/:id - Get product detail
 */

require_once APP_PATH . '/controllers/api/ApiController.php';
require_once APP_PATH . '/models/Product.php';

class ProductApiController extends ApiController {

    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    /**
     * Get product list with search and filter
     */
    public function index() {
        $input = $this->getInput();
        $search = $input['search'] ?? '';
        $brand = $input['brand'] ?? '';

        // Get products
        if (!empty($search)) {
            $products = $this->productModel->search($search);
        } elseif (!empty($brand)) {
            $products = $this->productModel->getByBrand($brand);
        } else {
            $products = $this->productModel->getAll();
        }

        // Sort products by price then name
        if (!empty($products)) {
            usort($products, function($a, $b) {
                if ($a['price'] != $b['price']) {
                    return $a['price'] - $b['price'];
                }
                return strcmp($a['name'], $b['name']);
            });
        }

        // Get all brands for filter
        $brands = $this->productModel->getAllBrands();

        $this->success([
            'products' => $products,
            'brands' => $brands
        ]);
    }

    /**
     * Get product detail by ID
     */
    public function detail() {
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
}
?>