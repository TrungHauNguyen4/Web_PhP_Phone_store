<?php
/**
 * Helper Validation - Xác thực dữ liệu đầu vào
 * 
 * File này cung cấp class Validator và các hàm helper để xác thực dữ liệu:
 * - Xác thực các trường bắt buộc
 * - Xác thực email, số điện thoại, URL
 * - Xác thực mật khẩu
 * - Xác thực độ dài chuỗi
 * - Xác thực số
 */

/**
 * Class Validator - Xác thực dữ liệu
 * 
 * Cung cấp các phương thức để xác thực các loại dữ liệu khác nhau
 * và thu thập các lỗi validation.
 */
class Validator {
    
    private $errors = []; // Mảng chứa các lỗi validation
    
    /**
     * Xác thực trường bắt buộc
     * 
     * @param mixed $value Giá trị cần kiểm tra
     * @param string $fieldName Tên trường
     * @return bool True nếu hợp lệ, false nếu không
     */
    public function required($value, $fieldName) {
        if (empty(trim($value))) {
            $this->addError($fieldName, "$fieldName là trường bắt buộc");
            return false;
        }
        return true;
    }
    
    /**
     * Xác thực email
     * 
     * @param string $value Email cần kiểm tra
     * @param string $fieldName Tên trường
     * @return bool True nếu hợp lệ, false nếu không
     */
    public function email($value, $fieldName) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($fieldName, "$fieldName không phải là email hợp lệ");
            return false;
        }
        return true;
    }
    
    /**
     * Xác thực độ dài mật khẩu
     * 
     * @param string $value Mật khẩu cần kiểm tra
     * @param string $fieldName Tên trường
     * @param int $minLength Độ dài tối thiểu
     * @return bool True nếu hợp lệ, false nếu không
     */
    public function password($value, $fieldName, $minLength = 6) {
        if (strlen($value) < $minLength) {
            $this->addError($fieldName, "$fieldName phải có ít nhất $minLength ký tự");
            return false;
        }
        return true;
    }
    
    /**
     * Xác thực mật khẩu khớp
     * 
     * @param string $password Mật khẩu
     * @param string $confirmPassword Mật khẩu xác nhận
     * @param string $fieldName Tên trường
     * @return bool True nếu khớp, false nếu không
     */
    public function passwordMatch($password, $confirmPassword, $fieldName) {
        if ($password !== $confirmPassword) {
            $this->addError($fieldName, "Mật khẩu không khớp");
            return false;
        }
        return true;
    }
    
    /**
     * Xác thực số điện thoại Việt Nam
     * 
     * @param string $value Số điện thoại cần kiểm tra
     * @param string $fieldName Tên trường
     * @return bool True nếu hợp lệ, false nếu không
     */
    public function phone($value, $fieldName) {
        if (!preg_match('/^(\+84|0)[0-9]{9,10}$/', str_replace(' ', '', $value))) {
            $this->addError($fieldName, "$fieldName không phải là số điện thoại hợp lệ");
            return false;
        }
        return true;
    }
    
    /**
     * Xác thực số
     * 
     * @param mixed $value Giá trị cần kiểm tra
     * @param string $fieldName Tên trường
     * @return bool True là số, false nếu không
     */
    public function number($value, $fieldName) {
        if (!is_numeric($value)) {
            $this->addError($fieldName, "$fieldName phải là số");
            return false;
        }
        return true;
    }
    
    /**
     * Xác thực độ dài tối thiểu
     * 
     * @param string $value Chuỗi cần kiểm tra
     * @param string $fieldName Tên trường
     * @param int $minLength Độ dài tối thiểu
     * @return bool True nếu hợp lệ, false nếu không
     */
    public function minLength($value, $fieldName, $minLength) {
        if (strlen($value) < $minLength) {
            $this->addError($fieldName, "$fieldName phải có ít nhất $minLength ký tự");
            return false;
        }
        return true;
    }
    
    /**
     * Xác thực độ dài tối đa
     * 
     * @param string $value Chuỗi cần kiểm tra
     * @param string $fieldName Tên trường
     * @param int $maxLength Độ dài tối đa
     * @return bool True nếu hợp lệ, false nếu không
     */
    public function maxLength($value, $fieldName, $maxLength) {
        if (strlen($value) > $maxLength) {
            $this->addError($fieldName, "$fieldName không được vượt quá $maxLength ký tự");
            return false;
        }
        return true;
    }
    
    /**
     * Xác thực URL
     * 
     * @param string $value URL cần kiểm tra
     * @param string $fieldName Tên trường
     * @return bool True nếu hợp lệ, false nếu không
     */
    public function url($value, $fieldName) {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($fieldName, "$fieldName không phải là URL hợp lệ");
            return false;
        }
        return true;
    }
    
    /**
     * Thêm lỗi vào danh sách lỗi
     * 
     * @param string $field Tên trường
     * @param string $message Thông báo lỗi
     * @return void
     */
    private function addError($field, $message) {
        $this->errors[$field][] = $message;
    }
    
    /**
     * Lấy tất cả lỗi
     * 
     * @return array Mảng chứa tất cả lỗi
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Kiểm tra có lỗi không
     * 
     * @return bool True nếu có lỗi, false nếu không
     */
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    /**
     * Lấy lỗi của một trường cụ thể
     * 
     * @param string $field Tên trường
     * @return string|null Thông báo lỗi hoặc null
     */
    public function getError($field) {
        return $this->errors[$field][0] ?? null;
    }
}

/**
 * Hàm validate dữ liệu
 * 
 * @param string $field Tên trường
 * @param mixed $value Giá trị cần kiểm tra
 * @param array $rules Mảng các quy tắc validation
 * @return Validator Instance Validator với các lỗi (nếu có)
 */
function validate($field, $value, $rules) {
    $validator = new Validator();
    
    foreach ($rules as $rule => $param) {
        if ($rule === 'required') {
            $validator->required($value, $field);
        } elseif ($rule === 'email') {
            $validator->email($value, $field);
        } elseif ($rule === 'password') {
            $validator->password($value, $field, $param ?? 6);
        } elseif ($rule === 'phone') {
            $validator->phone($value, $field);
        }
    }
    
    return $validator;
}
?>
