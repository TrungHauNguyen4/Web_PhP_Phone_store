<?php
/**
 * API Entry Point - Router for REST API
 *
 * This file is the entry point for all API requests.
 * It routes requests to the appropriate API controller.
 */

// Bắt đầu output buffering
ob_start();

// Định nghĩa đường dẫn gốc
define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));

// Load cấu hình ứng dụng
require_once ROOT_PATH . '/app/config/app.php';

// Set JSON content type for all API responses
header('Content-Type: application/json; charset=utf-8');

// Handle CORS (Cross-Origin Resource Sharing)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// Lấy tham số từ URL
$endpoint = $_GET['endpoint'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

// Sanitize endpoint
$endpoint = preg_replace('/[^a-zA-Z0-9_\/-]/', '', $endpoint);

// Router
try {
    switch ($endpoint) {
        case 'auth/register':
            require_once APP_PATH . '/controllers/api/AuthApiController.php';
            $controller = new AuthApiController();
            if ($method === 'POST') {
                $controller->register();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'auth/login':
            require_once APP_PATH . '/controllers/api/AuthApiController.php';
            $controller = new AuthApiController();
            if ($method === 'POST') {
                $controller->login();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'auth/logout':
            require_once APP_PATH . '/controllers/api/AuthApiController.php';
            $controller = new AuthApiController();
            if ($method === 'POST') {
                $controller->logout();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'products':
            require_once APP_PATH . '/controllers/api/ProductApiController.php';
            $controller = new ProductApiController();
            if ($method === 'GET') {
                $controller->index();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case (preg_match('/^products\/(\d+)$/', $endpoint, $matches) ? true : false):
            require_once APP_PATH . '/controllers/api/ProductApiController.php';
            $controller = new ProductApiController();
            if ($method === 'GET') {
                $_GET['id'] = $matches[1];
                $controller->detail();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'cart':
            require_once APP_PATH . '/controllers/api/CartApiController.php';
            $controller = new CartApiController();
            if ($method === 'GET') {
                $controller->index();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'cart/items':
            require_once APP_PATH . '/controllers/api/CartApiController.php';
            $controller = new CartApiController();
            if ($method === 'POST') {
                $controller->add();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case (preg_match('/^cart\/items\/(\d+)$/', $endpoint, $matches) ? true : false):
            require_once APP_PATH . '/controllers/api/CartApiController.php';
            $controller = new CartApiController();
            $productId = $matches[1];
            if ($method === 'PUT') {
                $_GET['product_id'] = $productId;
                $controller->update();
            } elseif ($method === 'DELETE') {
                $_GET['id'] = $productId;
                $controller->remove();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'orders':
            require_once APP_PATH . '/controllers/api/OrderApiController.php';
            $controller = new OrderApiController();
            if ($method === 'GET') {
                $controller->index();
            } elseif ($method === 'POST') {
                $controller->checkout();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case (preg_match('/^orders\/(\d+)$/', $endpoint, $matches) ? true : false):
            require_once APP_PATH . '/controllers/api/OrderApiController.php';
            $controller = new OrderApiController();
            if ($method === 'GET') {
                $_GET['id'] = $matches[1];
                $controller->detail();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'users/profile':
            require_once APP_PATH . '/controllers/api/UserApiController.php';
            $controller = new UserApiController();
            if ($method === 'GET') {
                $controller->profile();
            } elseif ($method === 'PUT') {
                $controller->updateProfile();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'users/password':
            require_once APP_PATH . '/controllers/api/UserApiController.php';
            $controller = new UserApiController();
            if ($method === 'PUT') {
                $controller->changePassword();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'admin/dashboard':
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            if ($method === 'GET') {
                $controller->dashboard();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'admin/products':
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            if ($method === 'GET') {
                $controller->products();
            } elseif ($method === 'POST') {
                $controller->createProduct();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case (preg_match('/^admin\/products\/(\d+)$/', $endpoint, $matches) ? true : false):
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            $productId = $matches[1];
            if ($method === 'GET') {
                $_GET['id'] = $productId;
                $controller->getProduct();
            } elseif ($method === 'PUT') {
                $_GET['id'] = $productId;
                $controller->updateProduct();
            } elseif ($method === 'DELETE') {
                $_GET['id'] = $productId;
                $controller->deleteProduct();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'admin/orders':
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            if ($method === 'GET') {
                $controller->orders();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case (preg_match('/^admin\/orders\/(\d+)$/', $endpoint, $matches) ? true : false):
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            $orderId = $matches[1];
            if ($method === 'GET') {
                $_GET['id'] = $orderId;
                $controller->getOrder();
            } elseif ($method === 'DELETE') {
                $_GET['id'] = $orderId;
                $controller->deleteOrder();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case (preg_match('/^admin\/orders\/(\d+)\/status$/', $endpoint, $matches) ? true : false):
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            $orderId = $matches[1];
            if ($method === 'PUT') {
                $_GET['order_id'] = $orderId;
                $controller->updateOrderStatus();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'admin/users':
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            if ($method === 'GET') {
                $controller->users();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case (preg_match('/^admin\/users\/(\d+)$/', $endpoint, $matches) ? true : false):
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            $userId = $matches[1];
            if ($method === 'GET') {
                $_GET['id'] = $userId;
                $controller->getUser();
            } elseif ($method === 'PUT') {
                $_GET['id'] = $userId;
                $controller->updateUser();
            } elseif ($method === 'DELETE') {
                $_GET['id'] = $userId;
                $controller->deleteUser();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case (preg_match('/^admin\/users\/(\d+)\/password$/', $endpoint, $matches) ? true : false):
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            $userId = $matches[1];
            if ($method === 'PUT') {
                $_GET['user_id'] = $userId;
                $controller->resetUserPassword();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        case 'admin/statistics':
            require_once APP_PATH . '/controllers/api/AdminApiController.php';
            $controller = new AdminApiController();
            if ($method === 'GET') {
                $controller->statistics();
            } else {
                $controller->methodNotAllowed();
            }
            break;

        default:
            require_once APP_PATH . '/controllers/api/ApiController.php';
            $controller = new ApiController();
            $controller->notFound();
            break;
    }
} catch (Exception $e) {
    require_once APP_PATH . '/controllers/api/ApiController.php';
    $controller = new ApiController();
    $controller->error($e->getMessage(), 500);
}

ob_end_flush();
?>