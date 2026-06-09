<?php
/**
 * Cấu hình kết nối Database - MySQL
 * 
 * File này thiết lập kết nối đến database MySQL sử dụng PDO:
 * - Kết nối đến localhost (XAMPP MySQL)
 * - Sử dụng PDO prepared statements để bảo mật
 * - Áp dụng Singleton pattern để đảm bảo chỉ có một kết nối duy nhất
 */

// ============== CẤU HÌNH CŨ (COMMENT LẠI) ==============
// define('DB_DRIVER', 'mysql');
// define('DB_HOST', 'old-host.com');
// define('DB_PORT', '3306');
// define('DB_NAME', 'old_database');
// define('DB_USER', 'old_user');
// define('DB_PASSWORD', 'old_password');
// define('DB_CHARSET', 'utf8mb4');
// define('DB_DSN', 'mysql:host=old-host.com;port=3306;dbname=old_database;charset=utf8mb4');
// =====================================================

// ============== CẤU HÌNH HIỆN TẠI (XAMPP) ==============
define('DB_DRIVER', 'mysql'); // Loại database driver
define('DB_HOST', 'localhost'); // Địa chỉ host database
define('DB_PORT', '3306'); // Port kết nối database
define('DB_NAME', 'laptop_store'); // Tên database
define('DB_USER', 'root'); // Tên người dùng database
define('DB_PASSWORD', ''); // Mật khẩu database (trống cho XAMPP mặc định)
define('DB_CHARSET', 'utf8mb4'); // Bộ ký tự (hỗ trợ tiếng Việt và emoji)
// Chuỗi DSN (Data Source Name) cho PDO MySQL
define('DB_DSN', 'mysql:host=localhost;port=3306;dbname=laptop_store;charset=utf8mb4');
// =====================================================

/**
 * Class Database - Quản lý kết nối database
 * 
 * Sử dụng Singleton pattern để đảm bảo chỉ có một instance của kết nối database
 * trong toàn bộ ứng dụng, giúp tiết kiệm tài nguyên và tránh lỗi kết nối.
 */
class Database {
    private $connection; // Đối tượng PDO connection
    private static $instance; // Instance duy nhất của class (Singleton)
    
    /**
     * Constructor - Khởi tạo kết nối database
     * 
     * Private để ngăn việc tạo instance trực tiếp từ bên ngoài
     * Sử dụng PDO với các cấu hình bảo mật:
     * - ERRMODE_EXCEPTION: Ném exception khi có lỗi
     * - FETCH_ASSOC: Trả về kết quả dưới dạng associative array
     */
    private function __construct() {
        try {
            $this->connection = new PDO(
                DB_DSN,
                DB_USER,
                DB_PASSWORD,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Bật chế độ báo lỗi bằng exception
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mặc định trả về associative array
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci" // Thiết lập charset cho kết nối
                )
            );
        } catch (PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }
    }
    
    /**
     * Singleton pattern - Lấy instance duy nhất của Database
     * 
     * @return Database Instance duy nhất của class Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Lấy đối tượng PDO connection
     * 
     * @return PDO Đối tượng kết nối database
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Chuẩn bị câu lệnh SQL
     * 
     * @param string $sql Câu lệnh SQL cần chuẩn bị
     * @return PDOStatement Statement đã được chuẩn bị
     */
    public function query($sql) {
        return $this->connection->prepare($sql);
    }
    
    /**
     * Thực thi câu lệnh SQL và trả về tất cả kết quả
     * 
     * @param string $sql Câu lệnh SQL
     * @param array $params Tham số cho prepared statement
     * @return array Mảng chứa tất cả kết quả
     */
    public function fetchAll($sql, $params = array()) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Thực thi câu lệnh SQL và trả về kết quả đầu tiên
     * 
     * @param string $sql Câu lệnh SQL
     * @param array $params Tham số cho prepared statement
     * @return mixed Kết quả đầu tiên hoặc false nếu không có
     */
    public function fetch($sql, $params = array()) {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
    
    /**
     * Thực thi câu lệnh INSERT, UPDATE, DELETE
     * 
     * @param string $sql Câu lệnh SQL
     * @param array $params Tham số cho prepared statement
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function execute($sql, $params = array()) {
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Lấy ID của bản ghi vừa được INSERT
     * 
     * @return string ID của bản ghi vừa được thêm
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
    
    /**
     * Bắt đầu transaction
     * 
     * @return bool True nếu thành công
     */
    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    /**
     * Commit transaction
     * 
     * @return bool True nếu thành công
     */
    public function commit() {
        return $this->connection->commit();
    }
    
    /**
     * Rollback transaction
     * 
     * @return bool True nếu thành công
     */
    public function rollback() {
        return $this->connection->rollback();
    }
}
?>
