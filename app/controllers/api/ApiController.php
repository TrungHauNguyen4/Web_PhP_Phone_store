<?php
/**
 * Base API Controller
 *
 * Provides common methods for all API controllers:
 * - JSON response handling
 * - Input parsing (JSON, form data)
 * - Authentication checks
 */

require_once APP_PATH . '/controllers/Controller.php';

class ApiController extends Controller {

    /**
     * Send a success JSON response
     *
     * @param mixed $data Data to send
     * @param string $message Success message
     * @param int $statusCode HTTP status code (default: 200)
     */
    protected function success($data = null, $message = 'Success', $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send an error JSON response
     *
     * @param string $message Error message
     * @param int $statusCode HTTP status code (default: 400)
     * @param array $errors Additional error details
     */
    protected function error($message = 'Error', $statusCode = 400, $errors = []) {
        http_response_code($statusCode);
        echo json_encode([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send a 404 Not Found response
     */
    public function notFound() {
        $this->error('Resource not found', 404);
    }

    /**
     * Send a 405 Method Not Allowed response
     */
    public function methodNotAllowed() {
        $this->error('Method not allowed', 405);
    }

    /**
     * Send a 401 Unauthorized response
     */
    protected function unauthorized() {
        $this->error('Unauthorized', 401);
    }

    /**
     * Send a 403 Forbidden response
     */
    protected function forbidden() {
        $this->error('Forbidden', 403);
    }

    /**
     * Get input data from request (supports JSON and form data)
     *
     * @return array Input data
     */
    protected function getInput() {
        $input = [];
        
        // Check for JSON input
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (strpos($contentType, 'application/json') !== false) {
            $jsonInput = file_get_contents('php://input');
            $input = json_decode($jsonInput, true) ?? [];
        }
        
        // Merge with POST data
        $input = array_merge($input, $_POST);
        
        // Merge with GET data
        $input = array_merge($input, $_GET);
        
        return $input;
    }

    /**
     * Require authentication
     */
    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            $this->unauthorized();
        }
    }

    /**
     * Require admin role
     */
    protected function requireAdmin() {
        $this->requireAuth();
        if (!$this->isAdmin()) {
            $this->forbidden();
        }
    }
}
?>