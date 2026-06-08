<?php
/**
 * Helper Security - Các hàm bảo mật
 * 
 * File này cung cấp class Security và các hàm helper để bảo mật ứng dụng:
 * - Escape HTML để ngăn chặn XSS
 * - Sanitize dữ liệu đầu vào
 * - Hash và verify mật khẩu
 * - CSRF token protection
 * - Validate file upload
 * - Rate limiting
 */

/**
 * Class Security - Các hàm bảo mật
 * 
 * Cung cấp các phương thức tĩnh để xử lý các vấn đề bảo mật phổ biến
 * như XSS, password hashing, CSRF protection, v.v.
 */
class Security {
    
    /**
     * Escape HTML output để ngăn chặn XSS (Cross-Site Scripting)
     * 
     * @param mixed $data Dữ liệu cần escape (string hoặc array)
     * @return mixed Dữ liệu đã được escape
     */
    public static function escape($data) {
        if (is_array($data)) {
            return array_map([self::class, 'escape'], $data);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Sanitize string input để loại bỏ các ký tự nguy hiểm
     * 
     * @param mixed $data Dữ liệu cần sanitize (string hoặc array)
     * @return mixed Dữ liệu đã được sanitize
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return filter_var(trim($data), FILTER_SANITIZE_STRING);
    }
    
    /**
     * Hash mật khẩu sử dụng bcrypt
     * 
     * @param string $password Mật khẩu cần hash
     * @return string Mật khẩu đã được hash
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    /**
     * Verify mật khẩu với hash
     * 
     * @param string $password Mật khẩu cần kiểm tra
     * @param string $hash Hash mật khẩu
     * @return bool True nếu khớp, false nếu không
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Tạo CSRF token để bảo vệ form
     * 
     * @return string CSRF token
     */
    public static function generateToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Verify CSRF token
     * 
     * @param string $token Token cần verify
     * @return bool True nếu hợp lệ, false nếu không
     */
    public static function verifyToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Tạo chuỗi ngẫu nhiên
     * 
     * @param int $length Độ dài chuỗi (số byte)
     * @return string Chuỗi ngẫu nhiên (hex)
     */
    public static function generateRandomString($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Validate file upload
     * 
     * @param array $file File từ $_FILES
     * @param int $maxSize Kích thước tối đa (bytes)
     * @param array $allowedTypes Các định dạng được phép
     * @return array Mảng kết quả với key 'error' và 'message'
     */
    public static function validateFileUpload($file, $maxSize, $allowedTypes) {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['error' => true, 'message' => 'File upload không hợp lệ'];
        }
        
        if ($file['size'] > $maxSize) {
            return ['error' => true, 'message' => 'Kích thước file vượt quá giới hạn'];
        }
        
        $ext = getFileExtension($file['name']);
        if (!in_array($ext, $allowedTypes)) {
            return ['error' => true, 'message' => 'Định dạng file không được phép'];
        }
        
        return ['error' => false];
    }
    
    /**
     * Rate limiting - Giới hạn số lần request (implement đơn giản)
     * 
     * @param string $key Khóa để định danh user/action
     * @param int $maxAttempts Số lần thử tối đa
     * @param int $window Thời gian cửa sổ (giây)
     * @return bool True nếu cho phép, false nếu vượt quá giới hạn
     */
    public static function rateLimit($key, $maxAttempts = 5, $window = 300) {
        $cache_key = "rate_limit_$key";
        $attempts = $_SESSION[$cache_key] ?? 0;
        $timestamp = $_SESSION["{$cache_key}_time"] ?? time();
        
        if (time() - $timestamp > $window) {
            $_SESSION[$cache_key] = 1;
            $_SESSION["{$cache_key}_time"] = time();
            return true;
        }
        
        if ($attempts >= $maxAttempts) {
            return false;
        }
        
        $_SESSION[$cache_key] = $attempts + 1;
        return true;
    }
}

// Các hàm shorthand (viết tắt) cho dễ sử dụng
/**
 * Escape HTML (shorthand)
 */
function escape($data) {
    return Security::escape($data);
}

/**
 * Sanitize input (shorthand)
 */
function sanitize($data) {
    return Security::sanitize($data);
}

/**
 * Hash password (shorthand)
 */
function hashPassword($password) {
    return Security::hashPassword($password);
}

/**
 * Verify password (shorthand)
 */
function verifyPassword($password, $hash) {
    return Security::verifyPassword($password, $hash);
}

/**
 * Generate CSRF token (shorthand)
 */
function generateToken() {
    return Security::generateToken();
}

/**
 * Verify CSRF token (shorthand)
 */
function verifyToken($token) {
    return Security::verifyToken($token);
}

/**
 * Validate file upload (shorthand)
 */
function validateFileUpload($file, $maxSize = MAX_PRODUCT_UPLOAD_SIZE, $allowedTypes = ALLOWED_IMAGE_TYPES) {
    return Security::validateFileUpload($file, $maxSize, $allowedTypes);
}
?>
