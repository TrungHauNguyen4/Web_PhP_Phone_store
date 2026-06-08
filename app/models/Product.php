<?php
/**
 * Model Product - Quản lý dữ liệu sản phẩm
 *
 * File này chứa class Product để xử lý các thao tác database liên quan đến sản phẩm:
 * - Lấy danh sách sản phẩm (có hàng, hết hàng)
 * - Lấy thông tin sản phẩm theo ID
 * - Tạo, cập nhật, xóa sản phẩm
 * - Tìm kiếm sản phẩm theo từ khóa
 * - Lọc sản phẩm theo hãng
 */
class Product {
    private $db; // Kết nối database
    
    /**
     * Constructor - Khởi tạo kết nối database
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Lấy tất cả sản phẩm còn hàng
     * 
     * @return array Mảng chứa tất cả sản phẩm còn hàng
     */
    public function getAll() {
        $sql = "SELECT * FROM products WHERE quantity > 0 ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Lấy thông tin sản phẩm theo ID
     * 
     * @param int $id ID của sản phẩm
     * @return array|null Thông tin sản phẩm hoặc null nếu không tìm thấy
     */
    public function getById($id) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Tạo sản phẩm mới
     *
     * @param array $data Dữ liệu sản phẩm (name, brand, cpu, bo_nho_trong, pin, price, image, description, quantity)
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function create($data) {
        $sql = "INSERT INTO products (name, brand, cpu, bo_nho_trong, pin, price, image, description, quantity)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['brand'] ?? null,
            $data['cpu'] ?? null,
            $data['bo_nho_trong'] ?? null,
            $data['pin'] ?? null,
            $data['price'],
            $data['image'] ?? null,
            $data['description'] ?? null,
            $data['quantity'] ?? 0
        ]);
    }
    
    /**
     * Lấy tất cả sản phẩm (bao gồm cả hết hàng)
     * 
     * @return array Mảng chứa tất cả sản phẩm
     */
    public function getAllIncludingSoldOut() {
        $sql = "SELECT * FROM products ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Cập nhật thông tin sản phẩm
     *
     * @param int $id ID của sản phẩm cần cập nhật
     * @param array $data Dữ liệu cần cập nhật (name, brand, cpu, bo_nho_trong, pin, price, image, description, quantity)
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function update($id, $data) {
        $sql = "UPDATE products SET name = ?, brand = ?, cpu = ?, bo_nho_trong = ?, pin = ?, price = ?,
                image = ?, description = ?, quantity = ?, updated_at = NOW()
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['brand'] ?? null,
            $data['cpu'] ?? null,
            $data['bo_nho_trong'] ?? null,
            $data['pin'] ?? null,
            $data['price'],
            $data['image'] ?? null,
            $data['description'] ?? null,
            $data['quantity'] ?? 0,
            $id
        ]);
    }
    
    /**
     * Xóa sản phẩm
     * 
     * @param int $id ID của sản phẩm cần xóa
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function delete($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    /**
     * Tìm kiếm sản phẩm theo từ khóa
     *
     * Tìm kiếm trong các trường: name, description, brand, price
     *
     * @param string $keyword Từ khóa tìm kiếm
     * @return array Mảng chứa các sản phẩm khớp với từ khóa
     */
    public function search($keyword) {
        $rawKeyword = trim((string)$keyword);

        // Nếu từ khóa rỗng -> trả về tất cả
        if ($rawKeyword === '') {
            return $this->getAll();
        }

        // Sử dụng LIKE cho các trường text + price (tìm kiếm xấp xỉ/chứa)
        $like = '%' . $rawKeyword . '%';

        $sql = "SELECT * FROM products
                WHERE name LIKE ?
                   OR description LIKE ?
                   OR brand LIKE ?
                   OR price LIKE ?
                ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $like, // name
            $like, // description
            $like, // brand
            $like  // price (tìm kiếm xấp xỉ/chứa)
        ]);

        return $stmt->fetchAll();
    }
    
    /**
     * Lọc sản phẩm theo hãng
     *
     * @param string $brand Tên hãng
     * @return array Mảng chứa các sản phẩm của hãng
     */
    public function getByBrand($brand) {
        $sql = "SELECT * FROM products WHERE brand = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$brand]);
        return $stmt->fetchAll();
    }

    /**
     * Lấy danh sách tất cả các hãng có sản phẩm
     *
     * @return array Mảng chứa tên các hãng
     */
    public function getAllBrands() {
        $sql = "SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL ORDER BY brand ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $brands ?: [];
    }
}
?>
