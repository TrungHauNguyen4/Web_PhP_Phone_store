<?php
/**
 * Auth API Controller
 *
 * Handles authentication endpoints:
 * - POST /api/auth/register - Register new user
 * - POST /api/auth/login - Login user
 * - POST /api/auth/logout - Logout user
 */

require_once APP_PATH . '/controllers/api/ApiController.php';
require_once APP_PATH . '/models/User.php';

class AuthApiController extends ApiController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Register a new user
     */
    public function register() {
        $input = $this->getInput();
        $errors = [];

        // Validate input
        if (empty($input['username'])) {
            $errors[] = 'Username is required';
        } elseif (strlen($input['username']) < 4) {
            $errors[] = 'Username must be at least 4 characters';
        }

        if (empty($input['email'])) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        if (empty($input['password'])) {
            $errors[] = 'Password is required';
        } elseif (strlen($input['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }

        if (empty($input['password_confirm']) || $input['password'] !== $input['password_confirm']) {
            $errors[] = 'Password confirmation does not match';
        }

        if (!empty($errors)) {
            $this->error('Validation failed', 422, $errors);
        }

        // Check if username already exists
        if ($this->userModel->getByUsername($input['username'])) {
            $this->error('Username already exists', 422, ['username' => 'Username already exists']);
        }

        // Check if email already exists
        if ($this->userModel->getByEmail($input['email'])) {
            $this->error('Email already exists', 422, ['email' => 'Email already exists']);
        }

        // Create user
        $result = $this->userModel->create([
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => $input['password'],
            'fullname' => $input['fullname'] ?? $input['username']
        ]);

        if ($result) {
            $this->success(null, 'Registration successful', 201);
        } else {
            $this->error('Registration failed', 500);
        }
    }

    /**
     * Login user
     */
    public function login() {
        $input = $this->getInput();

        if (empty($input['username']) || empty($input['password'])) {
            $this->error('Username and password are required', 422);
        }

        $user = $this->userModel->getByUsername($input['username']);

        if (!$user || !password_verify($input['password'], $user['password'])) {
            $this->error('Invalid username or password', 401);
        }

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Return user data (without password)
        unset($user['password']);
        $this->success(['user' => $user], 'Login successful');
    }

    /**
     * Logout user
     */
    public function logout() {
        // Clear session
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        session_destroy();

        $this->success(null, 'Logout successful');
    }
}
?>