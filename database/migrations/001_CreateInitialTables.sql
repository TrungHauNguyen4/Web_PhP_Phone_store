-- ===================================================
-- Migration: 001_CreateInitialTables
-- Created: 2024-01-01
-- Description: Create initial database schema for Laptop Store
-- Database: laptop_store (MySQL)
-- ===================================================

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS phone_store;
USE phone_store;

-- ===================================================
-- Table: users
-- Stores user account information including authentication and profile data
-- ===================================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL COMMENT 'Tên đăng nhập',
    email VARCHAR(100) COMMENT 'Email người dùng',
    password VARCHAR(255) NOT NULL COMMENT 'Mật khẩu đã hash (bcrypt)',
    fullname VARCHAR(100) COMMENT 'Họ tên đầy đủ',
    phone VARCHAR(20) COMMENT 'Số điện thoại',
    address VARCHAR(255) COMMENT 'Địa chỉ',
    role VARCHAR(20) DEFAULT 'user' COMMENT 'Vai trò: user hoặc admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo tài khoản',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật gần nhất',

    INDEX idx_users_username (username),
    INDEX idx_users_email (email),
    INDEX idx_users_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng người dùng';

-- ===================================================
-- Table: products
-- Stores phone product information
-- ===================================================
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL COMMENT 'Tên sản phẩm',
    brand VARCHAR(100) COMMENT 'Hãng sản xuất',
    cpu VARCHAR(100) COMMENT 'Chip xử lý',
    bo_nho_trong VARCHAR(50) COMMENT 'Bộ nhớ trong',
    pin VARCHAR(50) COMMENT 'Dung lượng pin',
    price DECIMAL(10, 2) NOT NULL COMMENT 'Giá sản phẩm (VNĐ)',
    image VARCHAR(255) COMMENT 'Tên file ảnh sản phẩm',
    description LONGTEXT COMMENT 'Mô tả chi tiết sản phẩm',
    quantity INT DEFAULT 0 COMMENT 'Số lượng trong kho',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian tạo sản phẩm',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật gần nhất',

    INDEX idx_products_name (name),
    INDEX idx_products_brand (brand),
    INDEX idx_products_price (price),
    INDEX idx_products_quantity (quantity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng sản phẩm';

-- ===================================================
-- Table: orders
-- Stores order information
-- ===================================================
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL COMMENT 'ID người dùng đặt hàng',
    total_amount DECIMAL(10, 2) COMMENT 'Tổng tiền đơn hàng',
    payment_method VARCHAR(50) COMMENT 'Phương thức thanh toán (transfer, cod)',
    status VARCHAR(20) DEFAULT 'pending' COMMENT 'Trạng thái: pending, confirmed, shipped, completed, cancelled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian đặt hàng',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Thời gian cập nhật gần nhất',

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_orders_user_id (user_id),
    INDEX idx_orders_status (status),
    INDEX idx_orders_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng đơn hàng';

-- ===================================================
-- Table: order_details
-- Stores individual items in each order
-- ===================================================
CREATE TABLE IF NOT EXISTS order_details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL COMMENT 'ID đơn hàng',
    product_id INT NOT NULL COMMENT 'ID sản phẩm',
    quantity INT COMMENT 'Số lượng sản phẩm',
    price DECIMAL(10, 2) COMMENT 'Giá tại thời điểm đặt hàng',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Thời gian thêm vào đơn hàng',

    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id),
    INDEX idx_order_details_order_id (order_id),
    INDEX idx_order_details_product_id (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Chi tiết đơn hàng';

-- ===================================================
-- Insert Sample Data - Users
-- Default accounts for testing
-- Password: admin123 (hashed with bcrypt)
-- ===================================================
INSERT IGNORE INTO users (username, email, password, fullname, phone, address, role)
VALUES (
    'admin',
    'admin@laptopstore.com',
    '$2y$12$R9h/cIPz0gi.URNN0kh2OPST9/PgBkqquzi.Ss7KIUgO2t0jWMUga',
    'Administrator',
    '0123456789',
    'Hanoi, Vietnam',
    'admin'
);

INSERT IGNORE INTO users (username, email, password, fullname, phone, address, role)
VALUES (
    'user',
    'user@laptopstore.com',
    '$2y$12$pXE7J9k6wYjJu7c9LxWLU.kWLnAk9e8bN6U5Y2K4F3QZ0W7R8P0qm',
    'Test User',
    '0987654321',
    'Ho Chi Minh City, Vietnam',
    'user'
);

-- ===================================================
-- Insert Sample Data - Products
-- Sample phone products for demonstration
-- ===================================================
INSERT IGNORE INTO products (name, brand, cpu, bo_nho_trong, pin, price, quantity, description)
VALUES
(
    'iPhone 15 Pro Max',
    'Apple',
    'A17 Pro',
    '256GB',
    '4422 mAh',
    34990000,
    15,
    'iPhone 15 Pro Max với chip A17 Pro, màn hình 6.7 inch Super Retina XDR, camera 48MP, hỗ trợ 5G.'
),
(
    'iPhone 15',
    'Apple',
    'A16 Bionic',
    '128GB',
    '3349 mAh',
    24990000,
    20,
    'iPhone 15 với chip A16 Bionic, màn hình 6.1 inch Super Retina XDR, camera 48MP, thiết kế mới.'
),
(
    'Samsung Galaxy S24 Ultra',
    'Samsung',
    'Snapdragon 8 Gen 3',
    '256GB',
    '5000 mAh',
    32990000,
    12,
    'Samsung Galaxy S24 Ultra với chip Snapdragon 8 Gen 3, màn hình 6.8 inch Dynamic AMOLED 2X, camera 200MP.'
),
(
    'Samsung Galaxy S24',
    'Samsung',
    'Exynos 2400',
    '128GB',
    '4000 mAh',
    21990000,
    18,
    'Samsung Galaxy S24 với chip Exynos 2400, màn hình 6.2 inch Dynamic AMOLED 2X, camera 50MP.'
),
(
    'Xiaomi 14 Ultra',
    'Xiaomi',
    'Snapdragon 8 Gen 3',
    '256GB',
    '5300 mAh',
    28990000,
    10,
    'Xiaomi 14 Ultra với chip Snapdragon 8 Gen 3, màn hình 6.73 inch AMOLED LTPO, camera Leica 50MP.'
),
(
    'Xiaomi Redmi Note 13 Pro',
    'Xiaomi',
    'Snapdragon 7s Gen 2',
    '128GB',
    '5100 mAh',
    8990000,
    25,
    'Xiaomi Redmi Note 13 Pro với chip Snapdragon 7s Gen 2, màn hình 6.67 inch AMOLED, camera 200MP.'
),
(
    'OPPO Find X7 Ultra',
    'OPPO',
    'Snapdragon 8 Gen 3',
    '256GB',
    '5400 mAh',
    29990000,
    8,
    'OPPO Find X7 Ultra với chip Snapdragon 8 Gen 3, màn hình 6.82 inch AMOLED, camera Hasselblad.'
),
(
    'Vivo X100 Pro',
    'Vivo',
    'Dimensity 9300',
    '256GB',
    '5400 mAh',
    27990000,
    12,
    'Vivo X100 Pro với chip Dimensity 9300, màn hình 6.78 inch AMOLED, camera Zeiss 50MP.'
),
(
    'Google Pixel 8 Pro',
    'Google',
    'Tensor G3',
    '128GB',
    '5050 mAh',
    26990000,
    10,
    'Google Pixel 8 Pro với chip Tensor G3, màn hình 6.7 inch LTPO OLED, camera 50MP, AI camera.'
),
(
    'OnePlus 12',
    'OnePlus',
    'Snapdragon 8 Gen 3',
    '256GB',
    '5400 mAh',
    24990000,
    15,
    'OnePlus 12 với chip Snapdragon 8 Gen 3, màn hình 6.82 inch AMOLED LTPO, camera Hasselblad 50MP.'
);

-- ===================================================
-- Migration Complete
-- ===================================================
SELECT 'Migration 001_CreateInitialTables completed successfully!' AS Status;
