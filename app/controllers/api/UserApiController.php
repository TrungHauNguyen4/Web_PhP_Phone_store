<?php
/**
 * User API Controller
 *
 * Handles user profile endpoints:
 * - GET /api/users/profile - Get current user profile
 * - PUT /api/users/profile - Update current user profile
 * - PUT /api/users/password - Change password
 */

require_once APP_PATH . '/controllers/api/ApiController.php';
require_once APP_PATH . '/models/User.php';

class UserApiController extends ApiController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Get current user profile
     */
    public function profile() {
        $this->requireAuth();
        $userId = $this->getCurrentUserId();
        $user = $this->userModel->getById($userId);
        $this->success(['user' => $user]);
    }

    /**
     * Update current user profile
     */
    public function updateProfile() {
        $this->requireAuth();
        $input = $this->getInput();
        $userId = $this->getCurrentUserId();
        $currentUser = $this->userModel->getById($userId);
        $errors = [];

        // Validate input
        if (empty($input['fullname'])) {
            $errors[] = 'Full name is required';
        }

        if (empty($input['email'])) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format';
        }

        // Check if email is already taken by another user
        if ($input['email'] !== $currentUser['email']) {
            $existingUser = $this->userModel->getByEmail($input['email']);
            if ($existingUser) {
                $errors[] = 'Email already exists';
            }
        }

        if (!empty($errors)) {
            $this->error('Validation failed', 422, $errors);
        }

        // Prepare update data
        $updateData = [
            'fullname' => $input['fullname'],
            'email' => $input['email'],
            'phone' => $input['phone'] ?? '',
            'address' => $input['address'] ?? ''
        ];

        $result = $this->userModel->update($userId, $updateData);

        if ($result) {
            $updatedUser = $this->userModel->getById($userId);
            $this->success(['user' => $updatedUser], 'Profile updated successfully');
        } else {
            $this->error('Profile update failed', 500);
        }
    }

    /**
     * Change password
     */
    public function changePassword() {
        $this->requireAuth();
        $input = $this->getInput();
        $userId = $this->getCurrentUserId();
        $user = $this->userModel->getByUsername($_SESSION['username']);
        $errors = [];

        // Validate input
        if (empty($input['current_password'])) {
            $errors[] = 'Current password is required';
        } elseif (!password_verify($input['current_password'], $user['password'])) {
            $errors[] = 'Current password is incorrect';
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

        // Update password
        $result = $this->userModel->update($userId, [
            'password' => $input['new_password']
        ]);

        if ($result) {
            $this->success(null, 'Password changed successfully');
        } else {
            $this->error('Password change failed', 500);
        }
    }
}
?>