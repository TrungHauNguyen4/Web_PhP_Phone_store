# Đề tài 1 — Website bán điện thoại

## Mô tả
Xây dựng website bán điện thoại bằng PHP và MySQL.

## Chức năng cơ bản

### ✅ Trang chủ hiển thị danh sách điện thoại
- Hiển thị carousel sản phẩm nổi bật
- Hiển thị danh sách sản phẩm nổi bật (6 sản phẩm)
- Giao diện đẹp mắt với Bootstrap

### ✅ Trang chi tiết sản phẩm
- Hiển thị thông tin chi tiết sản phẩm
- Nút thêm vào giỏ hàng
- Hiển thị hình ảnh sản phẩm

### ✅ Thêm vào giỏ hàng
- Thêm sản phẩm vào giỏ hàng từ trang danh sách và chi tiết
- Sử dụng session để lưu giỏ hàng

### ✅ Xem giỏ hàng
- Hiển thị danh sách sản phẩm trong giỏ
- Cập nhật số lượng sản phẩm
- Xóa sản phẩm khỏi giỏ
- Tính tổng tiền

### ✅ Tính tổng tiền
- Tính tổng tiền trong giỏ hàng
- Hiển thị tổng tiền ở trang checkout
- Format giá tiền VNĐ

### ✅ Thông tin sản phẩm
- Tên điện thoại (name)
- Hãng sản xuất (brand)
- Chip xử lý (cpu)
- Bộ nhớ trong (bo_nho_trong)
- Dung lượng pin (pin)
- Giá bán (price)
- Hình ảnh (image)
- Mô tả (description)
- Số lượng trong kho (quantity)

## Yêu cầu nâng cao

### ✅ Tìm kiếm sản phẩm
- Tìm kiếm theo tên, mô tả, hãng, chip
- Sử dụng prepared statements để bảo mật

### ✅ Lọc theo hãng
- Lọc sản phẩm theo hãng sản xuất
- Dropdown chọn hãng

### ✅ Cập nhật số lượng trong giỏ hàng
- Cập nhật số lượng sản phẩm trong giỏ
- Tự động tính lại tổng tiền

### ✅ Xóa sản phẩm khỏi giỏ hàng
- Xóa sản phẩm khỏi giỏ hàng
- Cập nhật tổng tiền

### ✅ Thiết kế responsive bằng Bootstrap
- Giao diện responsive với Bootstrap 5
- Mobile-first design
- Tương thích với mọi thiết bị

## Chức năng bổ sung (Nâng cao hơn yêu cầu)

### ✅ Đăng nhập / Đăng ký
- Xác thực người dùng
- Hash mật khẩu với bcrypt
- Session management

### ✅ Quản lý đơn hàng
- Tạo đơn hàng
- Xem lịch sử đơn hàng
- Xem chi tiết đơn hàng
- Cập nhật trạng thái đơn hàng (Admin)

### ✅ Quản lý sản phẩm (Admin)
- Thêm sản phẩm mới
- Sửa thông tin sản phẩm
- Xóa sản phẩm
- Upload hình ảnh

### ✅ Quản lý người dùng (Admin)
- Xem danh sách người dùng
- Sửa thông tin người dùng
- Reset mật khẩu
- Xóa người dùng

### ✅ Dashboard Admin
- Thống kê tổng quan
- Biểu đồ doanh thu
- Quản lý đơn hàng, sản phẩm, người dùng

### ✅ Thanh toán giả lập
- Form thông tin giao hàng
- Chọn phương thức thanh toán
- Tạo đơn hàng với transaction

### ✅ Bảo mật nâng cao
- SQL Injection protection (prepared statements)
- XSS protection (htmlspecialchars escape)
- CSRF protection (token generation)
- Password hashing (bcrypt)

## CSDL gợi ý

### Bảng products
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- name (VARCHAR)
- brand (VARCHAR)
- cpu (VARCHAR)
- bo_nho_trong (VARCHAR)
- pin (VARCHAR)
- price (DECIMAL)
- image (VARCHAR)
- description (LONGTEXT)
- quantity (INT)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### Bảng users
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- username (VARCHAR, UNIQUE)
- email (VARCHAR)
- password (VARCHAR)
- fullname (VARCHAR)
- phone (VARCHAR)
- address (VARCHAR)
- role (VARCHAR)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### Bảng orders
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- user_id (INT, FOREIGN KEY)
- total_amount (DECIMAL)
- payment_method (VARCHAR)
- status (VARCHAR)
- shipping_fullname (VARCHAR)
- shipping_phone (VARCHAR)
- shipping_email (VARCHAR)
- shipping_address (VARCHAR)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

### Bảng order_details
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- order_id (INT, FOREIGN KEY)
- product_id (INT, FOREIGN KEY)
- quantity (INT)
- price (DECIMAL)
- created_at (TIMESTAMP)

## Công nghệ bắt buộc

- ✅ PHP (PHP 8.0.30)
- ✅ MySQL
- ✅ HTML/CSS
- ✅ Session
- ✅ Bootstrap (khuyến khích) - Bootstrap 5

## Công nghệ bổ sung

- ✅ JavaScript thuần
- ✅ MVC Architecture
- ✅ PDO (PHP Data Objects)
- ✅ Prepared Statements
- ✅ Git Version Control

## Trạng thái dự án

**Đã hoàn thành:** 100%

Tất cả các chức năng cơ bản và nâng cao đã được implement thành công. Dự án đã sẵn sàng để sử dụng.

## Repository GitHub

https://github.com/TrungHauNguyen4/Web_PhP_Phone_store.git 