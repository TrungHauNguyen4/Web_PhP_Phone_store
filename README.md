# 🛍️ Laptop Store - E-commerce Website

Một website thương mại điện tử bán laptop được xây dựng bằng **PHP MVC** với cơ sở dữ liệu **MySQL**.

## 📋 Thông tin dự án

- **Tên**: Laptop Store
- **Phiên bản**: 1.0.0
- **Công nghệ**: PHP 8.0+, HTML5, CSS3, JavaScript, MySQL
- **Cơ sở dữ liệu**: MySQL (XAMPP)
- **Kiến trúc**: MVC (Model-View-Controller)

## ✨ Chức năng

### Chức năng cơ bản
- ✅ Danh sách laptop với tìm kiếm & lọc theo giá
- ✅ Chi tiết sản phẩm
- ✅ Giỏ hàng (session-based)
- ✅ Tính tổng tiền
- ✅ Responsive design

### Chức năng nâng cao
- ✅ Đăng nhập / Đăng ký
- ✅ Phân quyền Admin/User
- ✅ Quản lý sản phẩm (CRUD)
- ✅ Upload hình ảnh sản phẩm
- ✅ Thanh toán & tạo đơn hàng
- ✅ Xem danh sách đơn hàng
- ✅ Chỉnh sửa thông tin cá nhân
- ✅ Đổi mật khẩu
- ✅ Admin reset mật khẩu user
- ✅ Quản lý đơn hàng (xem chi tiết, cập nhật trạng thái, xóa)
- ✅ Quản lý người dùng (chỉnh sửa thông tin, reset mật khẩu)
- ✅ Dashboard thống kê (sản phẩm, user, đơn hàng, doanh thu)
- ✅ Thống kê chi tiết
- ✅ Bảo mật SQL Injection (Prepared Statements)
- ✅ Bảo mật XSS (Output escaping)
- ✅ Bảo mật Password (Bcrypt hashing)

## 🏗️ Cấu trúc dự án

```
BT_Cuoi_Ky/
├── app/                          # Thư mục ứng dụng chính (MVC)
│   ├── config/                   # Cấu hình
│   │   ├── app.php              # Cấu hình ứng dụng (constants, helpers)
│   │   └── database.php         # Kết nối CSDL MySQL (PDO)
│   ├── controllers/              # Controllers (Xử lý logic)
│   │   ├── Controller.php       # BaseController (lớp cha)
│   │   ├── AuthController.php   # Đăng nhập, đăng ký, đăng xuất
│   │   ├── ProductController.php # Sản phẩm (trang chủ, danh sách, chi tiết)
│   │   ├── CartController.php    # Giỏ hàng (thêm, xóa, cập nhật)
│   │   ├── OrderController.php   # Đơn hàng (thanh toán, danh sách)
│   │   ├── UserController.php    # Thông tin cá nhân, đổi mật khẩu
│   │   └── AdminController.php   # Admin panel (quản lý sản phẩm, đơn hàng, user)
│   ├── models/                   # Models (Xử lý CSDL)
│   │   ├── User.php              # Model người dùng
│   │   ├── Product.php           # Model sản phẩm
│   │   └── Order.php             # Model đơn hàng
│   └── views/                    # Views (Giao diện người dùng)
│       ├── layouts/              # Layouts chung
│       ├── home/                 # Trang chủ
│       ├── products/             # Sản phẩm
│       ├── auth/                 # Xác thực
│       ├── cart/                 # Giỏ hàng
│       ├── checkout/             # Thanh toán
│       ├── orders/               # Đơn hàng
│       ├── profile/              # Thông tin cá nhân
│       └── admin/                # Admin Panel
├── public/                       # Folder công khai (web root)
│   ├── index.php                # Entry point (Router)
│   ├── .htaccess                # Rewrite rules Apache
│   └── assets/                  # Tài nguyên tĩnh
│       ├── css/                 # CSS files
│       ├── js/                  # JavaScript files
│       └── images/              # Hình ảnh sản phẩm
├── database/                     # Database files
│   ├── schema.sql               # Database schema MySQL
│   ├── schema_mysql.sql         # Schema MySQL (backup)
│   ├── seed_data.sql            # Dữ liệu mẫu
│   └── migrations/              # Migration files
├── .gitignore                    # Git ignore file
├── .htaccess                     # Apache rewrite rules
├── README.md                     # Tài liệu dự án
└── STRUCTURE.md                  # Cấu trúc dự án
```

## 🚀 Cài đặt và chạy

### Yêu cầu
- PHP 8.0+
- MySQL (XAMPP)
- Apache hoặc PHP Built-in Server
- PDO Driver cho MySQL

### Bước 1: Clone dự án
```bash
git clone <repository-url>
cd BT_Cuoi_Ky
```

### Bước 2: Cấu hình cơ sở dữ liệu
```bash
# Sử dụng phpMyAdmin hoặc MySQL command line
mysql -u root -p < database/schema.sql
```

Hoặc import qua phpMyAdmin:
1. Mở phpMyAdmin (http://localhost/phpmyadmin)
2. Tạo database mới tên `laptop_store`
3. Import file `database/schema.sql`

### Bước 3: Cấu hình ứng dụng
Cấu hình database trong file `app/config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'laptop_store');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
```

### Bước 4: Chạy ứng dụng
```bash
# Sử dụng PHP Built-in Server
php -S localhost:3000 -t public

# Hoặc sử dụng Apache với XAMPP
# Đảm bảo mod_rewrite được bật
```

Truy cập: `http://localhost:3000`

## 👤 Tài khoản test

```
Admin:
- Username: admin
- Password: admin123

User:
- Username: user
- Password: user123
```

## 🔒 Bảo mật

- ✅ **SQL Injection Protection**: Sử dụng Prepared Statements (PDO)
- ✅ **XSS Protection**: Escape output với `escape()`
- ✅ **Password Hashing**: Bcrypt (password_hash)
- ✅ **Input Validation**: Server-side validation
- ✅ **Session Management**: Secure session handling
- ✅ **Authentication Check**: isLoggedIn(), isAdmin()
- ✅ **PRG Pattern**: Post/Redirect/Get cho checkout

## 📊 Cơ sở dữ liệu

### Bảng chính
- **users**: Người dùng hệ thống (id, username, email, password, fullname, phone, address, role)
- **products**: Sản phẩm laptop (id, name, cpu, ram, ssd, price, image, description, quantity)
- **orders**: Đơn hàng (id, user_id, total_amount, payment_method, status)
- **order_details**: Chi tiết đơn hàng (id, order_id, product_id, quantity, price)

### Connection String MySQL
```
mysql:host=localhost;port=3306;dbname=laptop_store;charset=utf8mb4
```

## 🏗️ Kiến trúc MVC

### Model
- Xử lý logic database
- Các class: User, Product, Order
- Sử dụng PDO Prepared Statements

### View
- Hiển thị giao diện
- PHP templates với layouts
- Bootstrap 5 cho styling

### Controller
- Xử lý logic business
- Điều hướng request
- Các class: BaseController, AuthController, ProductController, CartController, OrderController, UserController, AdminController

### Router
- File: `public/index.php`
- Phân phối request đến controller dựa trên tham số `page` và `action`

## 📊 Routing

```
/?page=home → ProductController::home()
/?page=products → ProductController::index()
/?page=product&id=X → ProductController::detail()
/?page=auth&action=login → AuthController::login()
/?page=auth&action=register → AuthController::register()
/?page=auth&action=logout → AuthController::logout()
/?page=cart → CartController::index()
/?page=cart&action=add → CartController::add()
/?page=cart&action=remove → CartController::remove()
/?page=cart&action=update → CartController::update()
/?page=checkout → OrderController::checkout()
/?page=orders → OrderController::index()
/?page=profile → UserController::edit()
/?page=admin → AdminController::index()
/?page=admin&action=products → AdminController::products()
/?page=admin&action=orders → AdminController::orders()
/?page=admin&action=users → AdminController::users()
/?page=admin&action=statistics → AdminController::statistics()
```

## 📚 Tài liệu

- [Cấu trúc dự án](STRUCTURE.md)
- [Chi tiết cơ sở dữ liệu](database/schema.sql)
- [Yêu cầu dự án](checktiendo.md)

## 🤝 Đóng góp

Pull requests được chào đón!

## 📄 Giấy phép

MIT License

---

**Phát triển bởi**: Your Name  
**Cập nhật lần cuối**: Tháng 6, 2026
