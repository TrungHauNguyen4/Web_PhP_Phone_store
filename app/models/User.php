<?php
/**
 * Model User - Quản lý dữ liệu người dùng
 * 
 * File này chứa class User để xử lý các thao tác database liên quan đến người dùng:
 * - Lấy thông tin user theo ID, username, email
 * - Tạo user mới (đăng ký)
 * - Cập nhật thông tin user
 * - Lấy danh sách tất cả user (cho admin)
 */
class User {
    private $db; // Kết nối database
    
    /**
     * Constructor - Khởi tạo kết nối database
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Lấy thông tin user theo ID
     * 
     * @param int $id ID của user
     * @return array|null Thông tin user hoặc null nếu không tìm thấy
     */
    public function getById($id) {
        $sql = "SELECT id, username, email, fullname, phone, address, role FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Lấy thông tin user theo username
     * 
     * @param string $username Tên đăng nhập
     * @return array|null Thông tin user (bao gồm password) hoặc null
     */
    public function getByUsername($username) {
        $sql = "SELECT id, username, email, password, fullname, phone, address, role FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
    
    /**
     * Lấy thông tin user theo email
     * 
     * @param string $email Email của user
     * @return array|null Thông tin user (bao gồm password) hoặc null
     */
    public function getByEmail($email) {
        $sql = "SELECT id, username, email, password FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    /**
     * Tạo user mới (đăng ký)
     * 
     * @param array $data Dữ liệu user (username, email, password, fullname)
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function create($data) {
        $sql = "INSERT INTO users (username, email, password, fullname, role)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_BCRYPT), // Hash mật khẩu với bcrypt
            $data['fullname'] ?? '',
            'user' // Mặc định role là user thường
        ]);
    }
    
    /**
     * Cập nhật thông tin user
     * 
     * @param int $id ID của user cần cập nhật
     * @param array $data Dữ liệu cần cập nhật (fullname, phone, address, email, password)
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function update($id, $data) {
        // Xây dựng câu SQL động dựa trên dữ liệu cần cập nhật
        $fields = [];
        $values = [];
        
        if (isset($data['fullname'])) {
            $fields[] = "fullname = ?";
            $values[] = $data['fullname'];
        }
        
        if (isset($data['phone'])) {
            $fields[] = "phone = ?";
            $values[] = $data['phone'];
        }
        
        if (isset($data['address'])) {
            $fields[] = "address = ?";
            $values[] = $data['address'];
        }
        
        if (isset($data['email'])) {
            $fields[] = "email = ?";
            $values[] = $data['email'];
        }
        
        // Nếu có password, hash nó trước khi lưu
        if (isset($data['password'])) {
            $fields[] = "password = ?";
            $values[] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        
        // Thêm updated_at
        $fields[] = "updated_at = NOW()";
        
        // Thêm ID vào cuối mảng values
        $values[] = $id;
        
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
    
    /**
     * Lấy danh sách tất cả user (chỉ cho admin)
     *
     * @return array Mảng chứa tất cả user
     */
    public function getAll() {
        $sql = "SELECT id, username, email, fullname, role, created_at FROM users ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Xóa user
     *
     * @param int $id ID của user cần xóa
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
