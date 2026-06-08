```
📁 BT_Cuoi_Ky/  (Laptop Store - Website bán laptop PHP MVC)
│
├── 📁 app/                               # Thư mục chính của ứng dụng (MVC)
│   ├── 📁 config/                        # Cấu hình ứng dụng
│   │   ├── app.php                       # Cấu hình chính (constants, helpers)
│   │   └── database.php                  # Kết nối CSDL MySQL (PDO)
│   │
│   ├── 📁 controllers/                   # Controllers (Xử lý logic)
│   │   ├── Controller.php                # BaseController (lớp cha)
│   │   ├── AuthController.php            # Đăng nhập, đăng ký, đăng xuất
│   │   ├── ProductController.php         # Sản phẩm (trang chủ, danh sách, chi tiết)
│   │   ├── CartController.php            # Giỏ hàng (thêm, xóa, cập nhật)
│   │   ├── OrderController.php           # Đơn hàng (thanh toán, danh sách)
│   │   ├── UserController.php            # Thông tin cá nhân, đổi mật khẩu
│   │   └── AdminController.php           # Admin panel (quản lý sản phẩm, đơn hàng, user)
│   │
│   ├── 📁 models/                        # Models (Xử lý CSDL)
│   │   ├── User.php                      # Model người dùng
│   │   ├── Product.php                   # Model sản phẩm
│   │   └── Order.php                     # Model đơn hàng
│   │
│   └── 📁 views/                         # Views (Giao diện người dùng)
│       ├── 📁 layouts/                   # Layouts chung
│       │   ├── header.php                # Header (navbar, menu)
│       │   └── footer.php                # Footer
│       │
│       ├── 📁 home/                      # Trang chủ
│       │   └── index.php                 # Trang chủ với carousel
│       │
│       ├── 📁 products/                  # Sản phẩm
│       │   ├── list.php                  # Danh sách sản phẩm (tìm kiếm, lọc)
│       │   └── detail.php                # Chi tiết sản phẩm
│       │
│       ├── 📁 auth/                      # Xác thực
│       │   ├── login.php                 # Form đăng nhập
│       │   └── register.php              # Form đăng ký
│       │
│       ├── 📁 cart/                      # Giỏ hàng
│       │   └── index.php                 # Trang giỏ hàng
│       │
│       ├── 📁 checkout/                  # Thanh toán
│       │   └── index.php                 # Form thanh toán
│       │
│       ├── 📁 orders/                    # Đơn hàng
│       │   └── index.php                 # Danh sách đơn hàng user
│       │
│       ├── 📁 profile/                   # Thông tin cá nhân
│       │   └── edit.php                  # Chỉnh sửa thông tin, đổi mật khẩu
│       │
│       └── 📁 admin/                     # Admin Panel
│           ├── dashboard.php             # Dashboard thống kê
│           ├── products.php              # Danh sách sản phẩm
│           ├── product-form.php          # Form thêm/sửa sản phẩm
│           ├── orders.php                # Danh sách đơn hàng
│           ├── order-view.php            # Chi tiết đơn hàng
│           ├── users.php                 # Danh sách người dùng
│           ├── user-edit.php             # Chỉnh sửa thông tin user
│           ├── user-reset-password.php   # Reset mật khẩu user
│           └── statistics.php            # Thống kê chi tiết
│
├── 📁 public/                            # Thư mục công khai (web root)
│   ├── index.php                         # Entry point chính (Router)
│   ├── .htaccess                         # Rewrite rules Apache
│   └── 📁 assets/                        # Tài nguyên tĩnh
│       ├── 📁 css/
│       │   ├── style.css                 # CSS chính
│       │   └── responsive.css            # CSS responsive
│       ├── 📁 js/
│       │   ├── main.js                   # JavaScript chính
│       │   └── validation.js             # Validation script
│       └── 📁 images/                    # Hình ảnh sản phẩm
│
├── 📁 database/                          # Cơ sở dữ liệu
│   ├── schema.sql                        # Schema MySQL đầy đủ
│   ├── schema_mysql.sql                  # Schema MySQL (backup)
│   ├── seed_data.sql                     # Dữ liệu mẫu
│   └── 📁 migrations/                    # Migration files
│       └── 001_CreateInitialTables.sql   # Migration 1
│
├── 🔧 File cấu hình
│   ├── .gitignore                        # Git ignore file
│   ├── .htaccess                         # Rewrite rules
│   ├── README.md                         # Tài liệu dự án
│   └── STRUCTURE.md                      # Cấu trúc dự án
│
└── 📄 checktiendo.md                     # Yêu cầu dự án


═════════════════════════════════════════════════════════════════════

🔌 KẾT NỐI CSDL:
  Server: localhost (XAMPP MySQL)
  Database: laptop_store
  Tables: users, products, orders, order_details
  Charset: utf8mb4 (hỗ trợ tiếng Việt)

📋 TÍNH NĂNG CƠ BẢN:
  ✅ Danh sách laptop với tìm kiếm & lọc theo giá
  ✅ Chi tiết sản phẩm
  ✅ Giỏ hàng (session-based)
  ✅ Tính tổng tiền
  ✅ Responsive design

🚀 TÍNH NĂNG NÂNG CAO:
  ✅ Đăng nhập / Đăng ký
  ✅ Phân quyền (admin/user)
  ✅ Quản lý sản phẩm (CRUD)
  ✅ Upload hình ảnh sản phẩm
  ✅ Thanh toán & tạo đơn hàng
  ✅ Xem danh sách đơn hàng
  ✅ Chỉnh sửa thông tin cá nhân
  ✅ Đổi mật khẩu
  ✅ Admin reset mật khẩu user
  ✅ Quản lý đơn hàng (xem chi tiết, cập nhật trạng thái, xóa)
  ✅ Quản lý người dùng (chỉnh sửa thông tin, reset mật khẩu)
  ✅ Dashboard thống kê (sản phẩm, user, đơn hàng, doanh thu)
  ✅ Thống kê chi tiết
  ✅ Bảo mật SQL Injection (Prepared Statements)
  ✅ Bảo mật XSS (Output escaping)
  ✅ Bảo mật Password (Bcrypt hashing)

🛡️ BẢO MẬT:
  ✅ SQL Injection: Prepared Statements (PDO)
  ✅ XSS: Output escaping với escape()
  ✅ Password: Bcrypt hashing (password_hash)
  ✅ Input validation: Server-side validation
  ✅ Session management: Secure session handling
  ✅ Authentication check: isLoggedIn(), isAdmin()
  ✅ PRG Pattern: Post/Redirect/Get cho checkout

📱 RESPONSIVE:
  ✅ Desktop (1200px+)
  ✅ Tablet (768px - 1199px)
  ✅ Mobile (480px - 767px)

🚀 CHẠY ỨNG DỤNG:
  php -S localhost:3000 -t public
  
  Truy cập: http://localhost:3000
  Admin: admin / admin123
  User: user / user123

🏗️ KIẾN TRÚC MVC:
  - Model: Xử lý logic database (User, Product, Order)
  - View: Hiển thị giao diện (PHP templates)
  - Controller: Xử lý logic business, điều hướng request
  - Router: public/index.php phân phối request đến controller

📊 ROUTING:
  - /?page=home → ProductController::home()
  - /?page=products → ProductController::index()
  - /?page=product&id=X → ProductController::detail()
  - /?page=auth&action=login → AuthController::login()
  - /?page=auth&action=register → AuthController::register()
  - /?page=auth&action=logout → AuthController::logout()
  - /?page=cart → CartController::index()
  - /?page=cart&action=add → CartController::add()
  - /?page=cart&action=remove → CartController::remove()
  - /?page=cart&action=update → CartController::update()
  - /?page=checkout → OrderController::checkout()
  - /?page=orders → OrderController::index()
  - /?page=profile → UserController::edit()
  - /?page=admin → AdminController::index()
  - /?page=admin&action=products → AdminController::products()
  - /?page=admin&action=orders → AdminController::orders()
  - /?page=admin&action=users → AdminController::users()
  - /?page=admin&action=statistics → AdminController::statistics()

═════════════════════════════════════════════════════════════════════
```
