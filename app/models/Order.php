<?php
/**
 * Model Order - Quản lý dữ liệu đơn hàng
 * 
 * File này chứa class Order để xử lý các thao tác database liên quan đến đơn hàng:
 * - Tạo đơn hàng mới
 * - Thêm chi tiết sản phẩm vào đơn hàng
 * - Lấy thông tin đơn hàng theo ID, user ID
 * - Cập nhật trạng thái đơn hàng
 * - Xóa đơn hàng (và chi tiết)
 * - Lấy chi tiết đơn hàng
 */
class Order {
    private $db; // Kết nối database
    
    /**
     * Constructor - Khởi tạo kết nối database
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Tạo đơn hàng mới
     * 
     * @param array $data Dữ liệu đơn hàng (user_id, total_price, payment_method)
     * @return int|false ID của đơn hàng mới hoặc false nếu thất bại
     */
    public function create($data) {
        $sql = "INSERT INTO orders (user_id, total_amount, status, payment_method)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $data['user_id'],
            $data['total_amount'],
            'pending', // Trạng thái mặc định là chờ xử lý
            $data['payment_method'] ?? 'transfer' // Mặc định là chuyển khoản
        ]);
        
        if ($result) {
            return $this->db->lastInsertId(); // Trả về ID của đơn hàng vừa tạo
        }
        return false;
    }

    /**
     * Tạo đơn hàng với transaction và kiểm tra tồn kho
     *
     * @param array $orderData Dữ liệu đơn hàng (user_id, total_amount, payment_method, shipping_fullname, shipping_phone, shipping_email, shipping_address)
     * @param array $cartItems Mảng các sản phẩm trong giỏ (product_id, quantity, price)
     * @return int|false ID của đơn hàng mới hoặc false nếu thất bại
     */
    public function createWithTransaction($orderData, $cartItems) {
        try {
            $this->db->beginTransaction();

            // Tạo đơn hàng với thông tin giao hàng
            $sql = "INSERT INTO orders (user_id, total_amount, status, payment_method, shipping_fullname, shipping_phone, shipping_email, shipping_address)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $orderData['user_id'],
                $orderData['total_amount'],
                'pending',
                $orderData['payment_method'] ?? 'transfer',
                $orderData['shipping_fullname'] ?? '',
                $orderData['shipping_phone'] ?? '',
                $orderData['shipping_email'] ?? '',
                $orderData['shipping_address'] ?? ''
            ]);

            if (!$result) {
                throw new Exception('Failed to create order');
            }

            $order_id = $this->db->lastInsertId();

            // Thêm chi tiết đơn hàng và trừ tồn kho
            foreach ($cartItems as $item) {
                // Kiểm tra tồn kho
                $checkSql = "SELECT quantity FROM products WHERE id = ? FOR UPDATE";
                $checkStmt = $this->db->prepare($checkSql);
                $checkStmt->execute([$item['product_id']]);
                $product = $checkStmt->fetch();

                if (!$product || $product['quantity'] < $item['quantity']) {
                    throw new Exception('Insufficient stock for product ID: ' . $item['product_id']);
                }

                // Thêm chi tiết đơn hàng (lưu đơn giá, không phải subtotal)
                $detailSql = "INSERT INTO order_details (order_id, product_id, quantity, price)
                              VALUES (?, ?, ?, ?)";
                $detailStmt = $this->db->prepare($detailSql);
                $detailResult = $detailStmt->execute([
                    $order_id,
                    $item['product_id'],
                    $item['quantity'],
                    $item['price'] // Lưu đơn giá
                ]);

                if (!$detailResult) {
                    throw new Exception('Failed to add order detail');
                }

                // Trừ tồn kho
                $updateStockSql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
                $updateStockStmt = $this->db->prepare($updateStockSql);
                $updateStockResult = $updateStockStmt->execute([
                    $item['quantity'],
                    $item['product_id']
                ]);

                if (!$updateStockResult) {
                    throw new Exception('Failed to update stock');
                }
            }

            $this->db->commit();
            return $order_id;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Order creation failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Thêm sản phẩm vào chi tiết đơn hàng
     * 
     * @param int $order_id ID của đơn hàng
     * @param int $product_id ID của sản phẩm
     * @param int $quantity Số lượng
     * @param float $subtotal Thành tiền
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function addItem($order_id, $product_id, $quantity, $subtotal) {
        $sql = "INSERT INTO order_details (order_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$order_id, $product_id, $quantity, $subtotal]);
    }
    
    /**
     * Lấy thông tin đơn hàng theo ID
     * 
     * @param int $id ID của đơn hàng
     * @return array|null Thông tin đơn hàng hoặc null nếu không tìm thấy
     */
    public function getById($id) {
        $sql = "SELECT * FROM orders WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Lấy danh sách đơn hàng của một user
     * 
     * @param int $user_id ID của user
     * @return array Mảng chứa các đơn hàng của user
     */
    public function getByUserId($user_id) {
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
    
    /**
     * Lấy tất cả đơn hàng (cho admin)
     * 
     * @return array Mảng chứa tất cả đơn hàng
     */
    public function getAll() {
        $sql = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Cập nhật trạng thái đơn hàng
     *
     * @param int $order_id ID của đơn hàng
     * @param string $status Trạng thái mới (pending, confirmed, shipped, completed, cancelled)
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function updateStatus($order_id, $status) {
        $sql = "UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $order_id]);
    }

    /**
     * Cập nhật trạng thái đơn hàng và hoàn trả kho nếu bị hủy
     *
     * @param int $order_id ID của đơn hàng
     * @param string $status Trạng thái mới (pending, confirmed, shipped, completed, cancelled)
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function updateStatusWithStockReturn($order_id, $status) {
        try {
            $this->db->beginTransaction();

            // Lấy trạng thái hiện tại của đơn hàng
            $currentStatusSql = "SELECT status FROM orders WHERE id = ?";
            $stmt = $this->db->prepare($currentStatusSql);
            $stmt->execute([$order_id]);
            $currentOrder = $stmt->fetch();

            if (!$currentOrder) {
                throw new Exception('Order not found');
            }

            $currentStatus = $currentOrder['status'];

            // Nếu đang chuyển sang cancelled và trạng thái hiện tại không phải cancelled
            // thì hoàn trả kho
            if ($status === 'cancelled' && $currentStatus !== 'cancelled') {
                // Lấy chi tiết đơn hàng
                $detailsSql = "SELECT product_id, quantity FROM order_details WHERE order_id = ?";
                $detailsStmt = $this->db->prepare($detailsSql);
                $detailsStmt->execute([$order_id]);
                $orderDetails = $detailsStmt->fetchAll();

                // Hoàn trả kho cho từng sản phẩm
                foreach ($orderDetails as $detail) {
                    $restoreSql = "UPDATE products SET quantity = quantity + ? WHERE id = ?";
                    $restoreStmt = $this->db->prepare($restoreSql);
                    $restoreResult = $restoreStmt->execute([
                        $detail['quantity'],
                        $detail['product_id']
                    ]);

                    if (!$restoreResult) {
                        throw new Exception('Failed to restore stock for product ID: ' . $detail['product_id']);
                    }
                }
            }

            // Cập nhật trạng thái đơn hàng
            $updateSql = "UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?";
            $updateStmt = $this->db->prepare($updateSql);
            $updateResult = $updateStmt->execute([$status, $order_id]);

            if (!$updateResult) {
                throw new Exception('Failed to update order status');
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Order status update failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Xóa đơn hàng (và chi tiết đơn hàng)
     * 
     * Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
     * 
     * @param int $order_id ID của đơn hàng cần xóa
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function delete($order_id) {
        try {
            $this->db->beginTransaction();
            
            // Xóa chi tiết đơn hàng trước (do foreign key constraint)
            $sql = "DELETE FROM order_details WHERE order_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$order_id]);
            
            // Xóa đơn hàng
            $sql = "DELETE FROM orders WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$order_id]);
            
            $this->db->commit(); // Commit transaction nếu thành công
            return $result;
        } catch (Exception $e) {
            $this->db->rollBack(); // Rollback nếu có lỗi
            return false;
        }
    }
    
    /**
     * Lấy chi tiết đơn hàng (bao gồm thông tin sản phẩm)
     *
     * @param int $order_id ID của đơn hàng
     * @return array Mảng chứa chi tiết đơn hàng với thông tin sản phẩm
     */
    public function getOrderDetails($order_id) {
        $sql = "SELECT od.*, p.name, p.brand, p.cpu, p.bo_nho_trong, p.pin, p.image
                FROM order_details od
                JOIN products p ON od.product_id = p.id
                WHERE od.order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetchAll();
    }

    /**
     * Tính toán lại tổng tiền đơn hàng dựa trên chi tiết đơn hàng
     *
     * @param int $order_id ID của đơn hàng
     * @return float Tổng tiền thực tế
     */
    public function recalculateOrderTotal($order_id) {
        $sql = "SELECT SUM(price * quantity) as total FROM order_details WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$order_id]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Cập nhật tổng tiền đơn hàng
     *
     * @param int $order_id ID của đơn hàng
     * @param float $total_amount Tổng tiền mới
     * @return bool True nếu thành công, false nếu thất bại
     */
    public function updateOrderTotal($order_id, $total_amount) {
        $sql = "UPDATE orders SET total_amount = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$total_amount, $order_id]);
    }
}
?>
