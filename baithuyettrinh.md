# TRƯỜNG ĐẠI HỌC FUNIX

-----

![](_page_0_Picture_1.jpeg)

# BÁO CÁO DỰ ÁN CUỐI KỲ Ứng Dụng Bán Điện Thoại

Mentor: ThS.Nguyễn Trung Trí

Người thực hiện: TrungHauNguyen4

![](_page_1_Picture_1.jpeg)

# **MỤC LỤC**

|       | -:-                                                     |         |
|-------|---------------------------------------------------------|---------|
| LÒI   | MỞ ĐẦU                                                  | 4       |
| NHÂ   | ÀN XÉT CỦA MENTOR                                       | 5       |
| NHÂ   | ÀN XÉT CỦA NGƯỜI ĐÁNH GIÁ                               | 6       |
| Chươ  | ong 1 – Giới thiệu                                      | 7       |
| Chươ  | ong 2 – Phân tích và xác định yêu cầu                   | 8       |
| I. Y  | Yêu cầu chung của người dùng về hệ thống                | 8       |
| II.   | Nhóm người sử dụng                                      | 9       |
| III.  | Các chức năng cần thiết theo nhóm người dùng            | 10      |
| IV.   | Trường hợp sử dụng (Usecase) và đặc tả                | 12      |
| 1     | . Chức năng 1: Quản lý người dùng                      | 15      |
| 2     | . Chức năng 2: Quản lý sản phẩm                        | 25      |
| 3     | . Chức năng 3: Thao tác khách hàng với sản phẩm         | 40      |
| 4     | . Chức năng 4: Chức năng nâng cao                       | 55      |
|       | ơng 3 – Thiết kế kiến trúc và tổ chức CODE              |         |
| I. S  | o đồ thành phần và tương tác các thành phần             | 65      |
| II.   | Quy tắc viết code                                       | 67      |
| III.  | Cách tổ chức code trong dự án                           |         |
| IV.   | Các thư viện thirdparty sử dụng trong dự án             | 70      |
|       | ơng 4 – Thiết kế cơ sở dữ liệu                          |         |
| I. V  | /ẽ lược đồ cơ sở dữ liệu                                | 75      |
| II.   | Mô tả cấu trúc các thành phần có trong cơ sở dữ liệu    | 77      |
| Chươ  | ơng 5 – Thiết kế giao diện                              | 85      |
| I. C  | Giao diện chức năng 1: Quản lý người dùng               | 85      |
| II.   | Giao diện chức năng 2: Quản lý sản phẩm                 | 95      |
| III.  | Giao diện chức năng 3: Thao tác khách hàng với sản phẩm | 110     |
| IV.   | Giao diện chức năng 4: Nâng cao                         | 125     |
| Chương 6 - Kiểm thử                     | . 135 |
|-----------------------------------------|-------|
| I. Kiểm thử đơn vị                      | . 135 |
| II. Kiểm thử hệ thống                   | . 136 |
| III. Kiểm thử phi chức năng             | . 145 |
| Chương 7 – Hướng dẫn cài đặt và sử dụng | . 147 |
| I. Hướng dẫn cài đặt                    | . 147 |
| II. Hướng dẫn sử dụng                   | . 165 |
| KẾT LUẬN                                | . 185 |
| I. Kết quả đạt được                     | . 185 |
| II. Hạn chế                             | .186  |
| III. Hướng phát triển                   | .186  |
| PHỤ LỤC                                 | . 187 |
| TÀI LIỆU THAM KHẢO                      | . 192 |

# **LỜI MỞ ĐẦU**

Trong thời đại kỹ thuật số ngày nay, Công nghệ Thông tin và Truyền thông (CNTT) đóng vai trò quan trọng trong mọi lĩnh vực của đời sống. Để đáp ứng nhu cầu ngày càng tăng cao về công nghệ, ngành CNTT luôn cần những chuyên gia có kiến thức chuyên sâu và kỹ năng thực hành để phát triển các sản phẩm và dịch vụ mới, đáp ứng các thách thức của thế giới kỹ thuật số.

Em đã chọn chủ đề "Tạo ứng dụng bán điện thoại" cho bài lab của mình. Bài lab của em tập trung vào nghiên cứu và phát triển một hệ thống quản lý tài nguyên và bán hàng điện thoại. Để đạt được mục tiêu này, tôi đã sử dụng các công nghệ PHP, MySQL, Bootstrap 5 và MVC Architecture. Những kết quả đạt được từ nghiên cứu này sẽ có ý nghĩa đặc biệt trong việc quản lý sản phẩm điện thoại.

Cuối cùng, em xin gửi lời cảm ơn đến các mentor đã hỗ trợ em trong quá trình thực hiện sản phẩm. Em hi vọng rằng những kết quả từ nghiên cứu này sẽ đóng góp tích cực cho ngành CNTT và giúp em phát triển kỹ năng chuyên môn và sự nghiệp của mình.

| NHẠN XÉT CỦA MENTOR |
|---------------------|
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |
|                     |

| NHẠN XÉT CỦA NGƯỜI ĐÁNH GIÁ                                   |
|--------------------------------------------------------|
|                                                        |
| •••••                                                  |
| ••••••                                                 |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
| • • • • • • • • • • • • • • • • • • • •                 |
| ••••••                                                 |
| • • • • • • • • • • • • • • • • • • • •                 |
| • • • • • • • • • • • • • • • • • • • •                 |
|                                                        |
| ••••••                                                 |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |
|                                                        |

# **Chương 1 – Giới thiệu**

## I. Lời Giới Thiệu Đề Tài

Trong bối cảnh thương mại điện tử đang phát triển mạnh mẽ tại Việt Nam, nhu cầu mua sắm trực tuyến các sản phẩm công nghệ, đặc biệt là điện thoại di động, ngày càng tăng cao. Dự án "Ứng dụng bán điện thoại" được thực hiện nhằm xây dựng một nền tảng thương mại điện tử chuyên nghiệp, cho phép người dùng tìm kiếm, so sánh và mua các sản phẩm điện thoại một cách thuận tiện và an toàn.

Dự án sử dụng kiến trúc MVC (Model-View-Controller) để tách biệt các tầng logic, giao diện và dữ liệu, giúp code dễ bảo trì và mở rộng. Hệ thống được phát triển bằng ngôn ngữ PHP 8.0 kết hợp với MySQL database và Bootstrap 5 cho giao diện người dùng hiện đại, responsive.

## II. Mục Tiêu của Đề Tài

- **Phân tích và thiết kế hệ thống:** Xác định rõ các yêu cầu chức năng và phi chức năng, thiết kế kiến trúc hệ thống phù hợp với mô hình thương mại điện tử.
- **Phát triển Frontend và Backend:** Xây dựng giao diện người dùng thân thiện, responsive trên mọi thiết bị, đồng thời phát triển logic xử lý business logic phía server.
- **Quản lý cơ sở dữ liệu:** Thiết kế schema database tối ưu, đảm bảo tính toàn vẹn dữ liệu và hiệu suất truy vấn.
- **Bảo mật và quản lý người dùng:** Triển khai các biện pháp bảo mật như password hashing, session management, validation input, phân quyền người dùng.
- **Kiểm thử và tối ưu hóa:** Thực hiện kiểm thử đơn vị và kiểm thử hệ thống, tối ưu hóa code và database để đảm bảo hiệu suất tốt nhất.

## III. Các Công Nghệ Sử Dụng

### 1. PHP 8.0

PHP là ngôn ngữ lập trình phía server phổ biến nhất cho phát triển web. Phiên bản 8.0 mang lại nhiều cải tiến quan trọng:

- **JIT (Just-In-Time) Compiler:** Tăng hiệu suất thực thi code, đặc biệt với các tác vụ tính toán nặng
- **Union Types:** Cho phép khai báo nhiều kiểu dữ liệu cho một biến, giúp code rõ ràng hơn
- **Named Arguments:** Gọi hàm với tên tham số, giúp code dễ đọc hơn
- **Attributes:** Thay thế annotations, cung cấp cách khai báo metadata cho class, method, property
- **Match Expression:** Cấu trúc điều kiện mạnh mẽ hơn switch truyền thống
- **Improved Error Handling:** Xử lý lỗi tốt hơn với các exception mới

PHP được chọn vì:
- Cộng đồng lớn, nhiều tài liệu và thư viện hỗ trợ
- Dễ học, dễ triển khai
- Tương thích tốt với hầu hết các hosting provider
- Chi phí thấp (open-source)

### 2. MySQL

MySQL là hệ quản trị cơ sở dữ liệu quan hệ (RDBMS) phổ biến nhất:

- **ACID Compliance:** Đảm bảo tính toàn vẹn dữ liệu (Atomicity, Consistency, Isolation, Durability)
- **Relational Model:** Hỗ trợ các mối quan hệ giữa các bảng (one-to-one, one-to-many, many-to-many)
- **Indexing:** Tối ưu hóa truy vấn với các chỉ mục (index)
- **Stored Procedures & Triggers:** Hỗ trợ logic phía database
- **Replication & Clustering:** Hỗ trợ mở rộng và backup

MySQL được chọn vì:
- Miễn phí, open-source
- Hiệu suất cao với các truy vấn phức tạp
- Tương thích tốt với PHP qua PDO
- Cộng đồng lớn, nhiều công cụ quản lý (phpMyAdmin, MySQL Workbench)

### 3. PDO (PHP Data Objects)

PDO là extension của PHP để kết nối database:

- **Database Abstraction:** Cung cấp interface thống nhất cho nhiều loại database (MySQL, PostgreSQL, SQLite, etc.)
- **Prepared Statements:** Ngăn chặn SQL Injection một cách hiệu quả
- **Named Parameters:** Hỗ trợ tham số có tên, giúp code rõ ràng hơn
- **Error Handling:** Xử lý lỗi với exceptions
- **Transaction Support:** Hỗ trợ transaction để đảm bảo tính toàn vẹn dữ liệu

### 4. Bootstrap 5

Bootstrap là framework CSS phổ biến nhất để phát triển giao diện responsive:

- **Grid System:** Hệ thống lưới 12 cột giúp bố cục linh hoạt
- **Responsive Design:** Tự động thích ứng với các kích thước màn hình khác nhau (mobile, tablet, desktop)
- **Pre-built Components:** Cung cấp sẵn các component (navbar, card, modal, form, table, etc.)
- **Utility Classes:** Các class tiện ích để nhanh chóng style (margin, padding, color, text, etc.)
- **Customizable:** Dễ dàng tùy chỉnh qua Sass variables
- **JavaScript Plugins:** Các plugin JS cho carousel, dropdown, modal, etc.

Bootstrap 5 được chọn vì:
- Giảm thời gian phát triển giao diện
- Đảm bảo giao diện consistent trên toàn bộ ứng dụng
- Responsive tốt trên mọi thiết bị
- Tài liệu phong phú, cộng đồng lớn
- Không phụ thuộc jQuery (phiên bản 5)

### 5. MVC Architecture

MVC (Model-View-Controller) là pattern kiến trúc phổ biến trong phát triển web:

- **Model:** Chứa logic truy cập dữ liệu, tương tác với database, xử lý business rules
- **View:** Chứa giao diện người dùng, hiển thị dữ liệu cho người dùng
- **Controller:** Xử lý request từ người dùng, điều hướng giữa Model và View

Lợi ích của MVC:
- **Separation of Concerns:** Tách biệt các trách nhiệm, code dễ bảo trì
- **Reusability:** Model và View có thể tái sử dụng
- **Parallel Development:** Developer có thể làm việc song song trên Model, View, Controller
- **Testability:** Dễ viết unit test cho từng thành phần

## IV. Đối Tượng Hướng Dẫn và Người Sử Dụng

Dự án này hướng đến:
- **Sinh viên chuyên ngành CNTT:** Những người muốn học hỏi về phát triển web thương mại điện tử với PHP và MVC
- **Nhà phát triển web:** Những người muốn tham khảo kiến trúc và cách tổ chức code
- **Doanh nghiệp nhỏ:** Các doanh nghiệp bán lẻ điện thoại muốn xây dựng nền tảng thương mại điện tử
- **Nhà phân phối sản phẩm:** Các nhà cung cấp muốn mở rộng kênh bán hàng online

# **Chương 2 – Phân tích và xác định yêu cầu**

# **I. Yêu cầu chung của người dùng về hệ thống**

- ❖ Trang Chủ:
- Hiển thị sản phẩm nổi bật và khuyến mãi.
- Tìm kiếm nhanh sản phẩm, xem nhanh chi tiết 1 sản phẩm.
- Hiển thị danh mục sản phẩm chính, thương hiệu.
- ❖ Danh Mục và Sản Phẩm:
- Tổ chức sản phẩm vào các danh mục rõ ràng.
- Hiển thị thông tin chi tiết và hình ảnh sản phẩm.
- Cho phép tìm kiếm và lọc sản phẩm theo các tiêu chí như giá, thương hiệu,…
- ❖ Giỏ Hàng và Thanh Toán:
- Cho phép người dùng thêm sản phẩm vào giỏ hàng.
- Hiển thị thông tin tổng giá trị giỏ hàng.
- Quy trình thanh toán dễ sử dụng và an toàn.
- Hỗ trợ nhiều phương thức thanh toán (COD, chuyển khoản, ...).
- ❖ Tài Khoản Người Dùng:
- Cho phép đăng ký và đăng nhập.
- Quản lý thông tin cá nhân và địa chỉ giao hàng.
- Xem lịch sử đơn hàng và trạng thái đơn hàng.
- ❖ Quản Lý Đơn Hàng và Hóa Đơn:
- Cập nhật trạng thái đơn hàng.
- Tạo hóa đơn và xuất thông tin đơn hàng.
- ❖ Bảo Mật và Quyền Riêng Tư:
- Bảo vệ thông tin cá nhân của khách hàng.
- Sử dụng password hashing để bảo mật mật khẩu.
- ❖ Quản Lý Kho và Hàng Tồn:
- Theo dõi lượng tồn kho và cảnh báo khi hết hàng.
- Cập nhật số lượng tồn kho tự động sau mỗi giao dịch.

# **II. Nhóm người sử dụng**

Có 3 nhóm người chính được đề cập trong dự án:

- Nhóm Guest: nhóm người không có trong hệ thống, được gọi chung là những người không đăng nhập
- Nhóm Customer: nhóm người đã đăng ký vào hệ thống và đã đăng nhập
- Nhóm Admin: có toàn quyền xử lý dữ liệu web

# **III. Các chức năng cần thiết theo nhóm người dùng**

# - **Nhóm Admin**

- Đăng nhập, đăng xuất, đi tới trang client.
- Xem số lượng người dùng, lượng đặt hàng trong tháng, tổng tiền trong tháng.
- Thêm mới, xem, sửa, xóa người dùng. Tìm người dùng theo id, email, số điện thoại.
- Thêm mới, xem, sửa, xóa sản phẩm. Tìm sản phẩm theo id, tên. Có bộ lọc sản phẩm theo thương hiệu.
- Đối với đơn hàng:
  - Có thể xem, xóa 1 đơn hàng
  - Cập nhật trạng thái đơn hàng
  - Tìm đơn hàng theo id, email hoặc số điện thoại đặt hàng
- Đặt lại mật khẩu cho người dùng
- Xem thống kê và báo cáo

#### - **Nhóm Guest**

- Đăng ký làm thành viên của hệ thống.
- Có thể thêm sản phẩm vào giỏ hàng. Thông tin giỏ hàng được lưu tại session.
- Có thể đặt mua sản phẩm nhưng sẽ không có mã giảm giá.
- Không thể xem lịch sử đặt hàng.
- Hỗ trợ lấy lại mật khẩu thông qua email.

#### - **Nhóm Customer**

- Đăng nhập bằng tài khoản đã đăng ký.
- Có thể thêm sản phẩm vào giỏ hàng. Giỏ hàng được lưu trên session.
- Có thể đặt mua sản phẩm. Đơn hàng được lưu vào lịch sử đặt hàng.
- Xem và chỉnh sửa thông tin của tài khoản, thay đổi mật khẩu.
- Xem lịch sử đơn hàng và trạng thái đơn hàng.

# **IV. Trường hợp sử dụng (Usecase) và đặc tả**

![](_page_11_Figure_1.jpeg)

*Hình. 1: Usecase diagram*

![](_page_12_Picture_1.jpeg)

#### Mô tả actor

| # | Actor                                            | Mô tả                                                                                                   |
|---|--------------------------------------------------|---------------------------------------------------------------------------------------------------------|
| 1 | Người dùng không đăng<br>nhập (Guest)            | Nhóm người dùng không nằm trong<br>hệ thống, có thể<br>đăng ký vào hệ thống.                           |
| 2 | Khách hàng (Customer)                            | Người dùng đã đăng ký và<br>đăng nhập vào hệ thống.                                                      |
| 3 | Quản trị viên (Admin)                            | Người dùng có quyền quản lý<br>tất cả các chức năng của hệ thống.                                        |

#### Mô tả usecase

| # | UseCase                                          | Actor                                           | Mô tả                                                                                                   |
|---|--------------------------------------------------|-------------------------------------------------|---------------------------------------------------------------------------------------------------------|
| 1 | Đăng ký tài khoản                                 | Guest                                           | Người dùng có thể đăng ký tài khoản mới để trở thành khách hàng.                                         |
| 2 | Đăng nhập                                         | Guest, Customer, Admin                           | Người dùng có thể đăng nhập vào hệ thống bằng tên đăng nhập và mật khẩu.                                  |
| 3 | Xem danh sách sản phẩm                            | Guest, Customer, Admin                           | Người dùng có thể xem danh sách tất cả sản phẩm có sẵn.                                                  |
| 4 | Tìm kiếm sản phẩm                                 | Guest, Customer, Admin                           | Người dùng có thể tìm kiếm sản phẩm theo tên.                                                             |
| 5 | Lọc sản phẩm theo thương hiệu                    | Guest, Customer, Admin                           | Người dùng có thể lọc sản phẩm theo thương hiệu.                                                         |
| 6 | Xem chi tiết sản phẩm                            | Guest, Customer, Admin                           | Người dùng có thể xem thông tin chi tiết của một sản phẩm cụ thể.                                       |
| 7 | Thêm sản phẩm vào giỏ hàng                       | Guest, Customer                                 | Người dùng có thể thêm sản phẩm vào giỏ hàng.                                                           |
| 8 | Xem giỏ hàng                                     | Guest, Customer                                 | Người dùng có thể xem các sản phẩm trong giỏ hàng.                                                      |
| 9 | Cập nhật số lượng sản phẩm trong giỏ hàng         | Guest, Customer                                 | Người dùng có thể thay đổi số lượng sản phẩm trong giỏ hàng.                                             |
| 10 | Xóa sản phẩm khỏi giỏ hàng                       | Guest, Customer                                 | Người dùng có thể xóa sản phẩm khỏi giỏ hàng.                                                           |
| 11 | Đặt hàng                                         | Customer                                        | Khách hàng có thể đặt hàng từ giỏ hàng.                                                                |
| 12 | Xem lịch sử đơn hàng                             | Customer                                        | Khách hàng có thể xem lịch sử các đơn hàng đã đặt.                                                      |
| 13 | Xem chi tiết đơn hàng                            | Customer                                        | Khách hàng có thể xem chi tiết một đơn hàng cụ thể.                                                     |
| 14 | Cập nhật thông tin cá nhân                        | Customer                                        | Khách hàng có thể cập nhật thông tin cá nhân của mình.                                                  |
| 15 | Đổi mật khẩu                                      | Customer                                        | Khách hàng có thể đổi mật khẩu của mình.                                                                |
| 16 | Quản lý người dùng                                | Admin                                           | Admin có thể thêm, sửa, xóa người dùng.                                                                |
| 17 | Quản lý sản phẩm                                  | Admin                                           | Admin có thể thêm, sửa, xóa sản phẩm.                                                                  |
| 18 | Quản lý đơn hàng                                  | Admin                                           | Admin có thể xem và cập nhật trạng thái đơn hàng.                                                      |
| 19 | Đặt lại mật khẩu người dùng                       | Admin                                           | Admin có thể đặt lại mật khẩu cho người dùng khác.                                                      |
| 20 | Xem thống kê                                     | Admin                                           | Admin có thể xem thống kê về người dùng, đơn hàng, doanh thu.                                          |

# **1. Chức năng 1: Quản lý người dùng**

## 1.1 Đăng ký tài khoản

**Mô tả:** Người dùng không đăng nhập có thể đăng ký tài khoản mới để trở thành khách hàng.

**Luồng chính:**
1. Người dùng truy cập trang đăng ký
2. Người dùng nhập thông tin: tên đăng nhập, email, mật khẩu, xác nhận mật khẩu, họ tên
3. Người dùng nhấn nút "Đăng ký"
4. Hệ thống kiểm tra tính hợp lệ của thông tin
5. Hệ thống kiểm tra xem tên đăng nhập hoặc email đã tồn tại chưa
6. Nếu hợp lệ và chưa tồn tại, hệ thống tạo tài khoản mới
7. Hệ thống chuyển hướng người dùng đến trang đăng nhập

**Luồng thay thế:**
- Nếu thông tin không hợp lệ, hệ thống hiển thị thông báo lỗi
- Nếu tên đăng nhập hoặc email đã tồn tại, hệ thống hiển thị thông báo lỗi

## 1.2 Đăng nhập

**Mô tả:** Người dùng có thể đăng nhập vào hệ thống bằng tên đăng nhập và mật khẩu.

**Luồng chính:**
1. Người dùng truy cập trang đăng nhập
2. Người dùng nhập tên đăng nhập và mật khẩu
3. Người dùng nhấn nút "Đăng nhập"
4. Hệ thống kiểm tra thông tin đăng nhập
5. Nếu thông tin đúng, hệ thống tạo session và chuyển hướng đến trang chủ
6. Nếu thông tin sai, hệ thống hiển thị thông báo lỗi

## 1.3 Đăng xuất

**Mô tả:** Người dùng đã đăng nhập có thể đăng xuất khỏi hệ thống.

**Luồng chính:**
1. Người dùng nhấn nút "Đăng xuất"
2. Hệ thống hủy session
3. Hệ thống chuyển hướng người dùng đến trang đăng nhập

## 1.4 Cập nhật thông tin cá nhân

**Mô tả:** Khách hàng có thể cập nhật thông tin cá nhân của mình.

**Luồng chính:**
1. Khách hàng đăng nhập và truy cập trang thông tin cá nhân
2. Khách hàng xem thông tin hiện tại
3. Khách hàng chỉnh sửa thông tin: họ tên, email, số điện thoại, địa chỉ
4. Khách hàng có thể đổi mật khẩu (tùy chọn)
5. Khách hàng nhấn nút "Lưu thay đổi"
6. Hệ thống kiểm tra tính hợp lệ của thông tin
7. Hệ thống cập nhật thông tin vào database
8. Hệ thống hiển thị thông báo thành công

## 1.5 Quản lý người dùng (Admin)

**Mô tả:** Admin có thể quản lý tất cả người dùng trong hệ thống.

**Luồng chính:**
1. Admin đăng nhập và truy cập trang quản lý người dùng
2. Admin xem danh sách tất cả người dùng
3. Admin có thể tìm kiếm người dùng theo tên đăng nhập hoặc email
4. Admin có thể xóa người dùng
5. Admin có thể đặt lại mật khẩu cho người dùng

# **2. Chức năng 2: Quản lý sản phẩm**

## 2.1 Xem danh sách sản phẩm

**Mô tả:** Người dùng có thể xem danh sách tất cả sản phẩm có sẵn.

**Luồng chính:**
1. Người dùng truy cập trang sản phẩm
2. Hệ thống hiển thị danh sách sản phẩm với hình ảnh, tên, giá
3. Người dùng có thể lọc sản phẩm theo thương hiệu
4. Người dùng có thể tìm kiếm sản phẩm theo tên

## 2.2 Xem chi tiết sản phẩm

**Mô tả:** Người dùng có thể xem thông tin chi tiết của một sản phẩm cụ thể.

**Luồng chính:**
1. Người dùng nhấn vào một sản phẩm từ danh sách
2. Hệ thống hiển thị trang chi tiết sản phẩm
3. Hệ thống hiển thị: hình ảnh, tên, giá, thông số kỹ thuật, mô tả, số lượng
4. Người dùng có thể thêm sản phẩm vào giỏ hàng

## 2.3 Thêm sản phẩm (Admin)

**Mô tả:** Admin có thể thêm sản phẩm mới vào hệ thống.

**Luồng chính:**
1. Admin đăng nhập và truy cập trang quản lý sản phẩm
2. Admin nhấn nút "Thêm sản phẩm mới"
3. Admin nhập thông tin sản phẩm: tên, thương hiệu, giá, thông số kỹ thuật, mô tả, số lượng, hình ảnh
4. Admin nhấn nút "Lưu"
5. Hệ thống kiểm tra tính hợp lệ của thông tin
6. Hệ thống lưu sản phẩm vào database
7. Hệ thống hiển thị thông báo thành công

## 2.4 Sửa sản phẩm (Admin)

**Mô tả:** Admin có thể chỉnh sửa thông tin sản phẩm.

**Luồng chính:**
1. Admin đăng nhập và truy cập trang quản lý sản phẩm
2. Admin nhấn nút "Sửa" trên sản phẩm muốn chỉnh sửa
3. Admin chỉnh sửa thông tin sản phẩm
4. Admin nhấn nút "Lưu"
5. Hệ thống cập nhật thông tin vào database
6. Hệ thống hiển thị thông báo thành công

## 2.5 Xóa sản phẩm (Admin)

**Mô tả:** Admin có thể xóa sản phẩm khỏi hệ thống.

**Luồng chính:**
1. Admin đăng nhập và truy cập trang quản lý sản phẩm
2. Admin nhấn nút "Xóa" trên sản phẩm muốn xóa
3. Hệ thống hiển thị xác nhận xóa
4. Admin xác nhận xóa
5. Hệ thống xóa sản phẩm khỏi database
6. Hệ thống hiển thị thông báo thành công

# **3. Chức năng 3: Thao tác khách hàng với sản phẩm**

## 3.1 Thêm sản phẩm vào giỏ hàng

**Mô tả:** Người dùng có thể thêm sản phẩm vào giỏ hàng.

**Luồng chính:**
1. Người dùng xem chi tiết sản phẩm
2. Người dùng nhấn nút "Thêm vào giỏ hàng"
3. Hệ thống thêm sản phẩm vào giỏ hàng (session)
4. Hệ thống hiển thị thông báo thành công

## 3.2 Xem giỏ hàng

**Mô tả:** Người dùng có thể xem các sản phẩm trong giỏ hàng.

**Luồng chính:**
1. Người dùng truy cập trang giỏ hàng
2. Hệ thống hiển thị danh sách sản phẩm trong giỏ hàng
3. Hệ thống hiển thị: hình ảnh, tên, giá, số lượng, tổng tiền

## 3.3 Cập nhật số lượng sản phẩm trong giỏ hàng

**Mô tả:** Người dùng có thể thay đổi số lượng sản phẩm trong giỏ hàng.

**Luồng chính:**
1. Người dùng truy cập trang giỏ hàng
2. Người dùng thay đổi số lượng sản phẩm
3. Hệ thống cập nhật số lượng và tính lại tổng tiền

## 3.4 Xóa sản phẩm khỏi giỏ hàng

**Mô tả:** Người dùng có thể xóa sản phẩm khỏi giỏ hàng.

**Luồng chính:**
1. Người dùng truy cập trang giỏ hàng
2. Người dùng nhấn nút "Xóa" trên sản phẩm muốn xóa
3. Hệ thống xóa sản phẩm khỏi giỏ hàng
4. Hệ thống tính lại tổng tiền

## 3.5 Đặt hàng

**Mô tả:** Khách hàng có thể đặt hàng từ giỏ hàng.

**Luồng chính:**
1. Khách hàng đăng nhập và truy cập trang giỏ hàng
2. Khách hàng nhấn nút "Thanh toán"
3. Khách hàng nhập thông tin giao hàng: họ tên, số điện thoại, địa chỉ
4. Khách hàng nhấn nút "Đặt hàng"
5. Hệ thống kiểm tra tính hợp lệ của thông tin
6. Hệ thống tạo đơn hàng mới
7. Hệ thống lưu đơn hàng vào database
8. Hệ thống xóa sản phẩm khỏi giỏ hàng
9. Hệ thống hiển thị thông báo thành công

## 3.6 Xem lịch sử đơn hàng

**Mô tả:** Khách hàng có thể xem lịch sử các đơn hàng đã đặt.

**Luồng chính:**
1. Khách hàng đăng nhập và truy cập trang đơn hàng
2. Hệ thống hiển thị danh sách đơn hàng của khách hàng
3. Hệ thống hiển thị: mã đơn hàng, ngày đặt, tổng tiền, trạng thái

## 3.7 Xem chi tiết đơn hàng

**Mô tả:** Khách hàng có thể xem chi tiết một đơn hàng cụ thể.

**Luồng chính:**
1. Khách hàng nhấn vào một đơn hàng từ danh sách
2. Hệ thống hiển thị chi tiết đơn hàng
3. Hệ thống hiển thị: thông tin khách hàng, danh sách sản phẩm, tổng tiền, trạng thái

# **4. Chức năng 4: Chức năng nâng cao**

## 4.1 Quản lý đơn hàng (Admin)

**Mô tả:** Admin có thể xem và quản lý tất cả đơn hàng.

**Luồng chính:**
1. Admin đăng nhập và truy cập trang quản lý đơn hàng
2. Admin xem danh sách tất cả đơn hàng
3. Admin có thể xem chi tiết đơn hàng
4. Admin có thể cập nhật trạng thái đơn hàng
5. Admin có thể xóa đơn hàng

## 4.2 Đặt lại mật khẩu người dùng (Admin)

**Mô tả:** Admin có thể đặt lại mật khẩu cho người dùng khác.

**Luồng chính:**
1. Admin đăng nhập và truy cập trang quản lý người dùng
2. Admin nhấn nút "Đặt lại mật khẩu" trên người dùng
3. Admin nhập mật khẩu mới
4. Admin nhập xác nhận mật khẩu
5. Admin nhấn nút "Đặt lại mật khẩu"
6. Hệ thống kiểm tra mật khẩu có khớp không
7. Hệ thống cập nhật mật khẩu mới
8. Hệ thống hiển thị thông báo thành công

## 4.3 Xem thống kê (Admin)

**Mô tả:** Admin có thể xem thống kê về hệ thống.

**Luồng chính:**
1. Admin đăng nhập và truy cập trang thống kê
2. Hệ thống hiển thị: số lượng người dùng, số lượng đơn hàng, tổng doanh thu
3. Hệ thống hiển thị biểu đồ thống kê

# **Chương 3 – Thiết kế kiến trúc và tổ chức CODE**

# **I. Sơ đồ thành phần và tương tác các thành phần**

Dự án sử dụng kiến trúc MVC (Model-View-Controller) để tách biệt logic, giao diện và dữ liệu:

- **Model:** Chứa logic truy cập dữ liệu và tương tác với database
- **View:** Chứa giao diện người dùng (HTML, CSS, JavaScript)
- **Controller:** Xử lý request từ người dùng, điều hướng giữa Model và View

**Các thành phần chính:**
- **app/controllers:** Chứa các controller xử lý logic
- **app/models:** Chứa các model tương tác với database
- **app/views:** Chứa các file giao diện
- **public:** Chứa file truy cập public (assets, index.php)
- **config:** Chứa cấu hình hệ thống
- **database:** Chứa migrations và seed data

![](_page_15_Figure_1.jpeg)

*Hình. 3: MVC Architecture Diagram*

![](_page_16_Picture_1.jpeg)

# **II. Quy tắc viết code**

- Tuân thủ chuẩn PSR-12 cho PHP
- Sử dụng命名 convention: CamelCase cho class, snake_case cho variables
- Comment code rõ ràng và chi tiết
- Sử dụng prepared statements để tránh SQL Injection
- Hash password với bcrypt
- Sử dụng session để quản lý trạng thái người dùng
- Validate input từ người dùng

# **III. Cách tổ chức code trong dự án**

Dự án được tổ chức theo kiến trúc MVC với cấu trúc thư mục rõ ràng:

```
BT_Cuoi_Ky/
├── app/                          # Thư mục chính của ứng dụng
│   ├── config/                   # Cấu hình hệ thống
│   │   ├── app.php              # Cấu hình ứng dụng, constants
│   │   ├── database.php         # Cấu hình database connection
│   │   └── constants.php         # Các hằng số toàn cục
│   ├── controllers/             # Các Controller xử lý logic
│   │   ├── Controller.php       # Base Controller (class cha)
│   │   ├── AuthController.php   # Xử lý đăng nhập/đăng ký/đăng xuất
│   │   ├── ProductController.php # Quản lý sản phẩm
│   │   ├── CartController.php   # Quản lý giỏ hàng
│   │   ├── OrderController.php  # Quản lý đơn hàng
│   │   ├── UserController.php   # Quản lý thông tin cá nhân
│   │   └── AdminController.php  # Quản trị hệ thống
│   ├── models/                  # Các Model tương tác database
│   │   ├── User.php             # Model người dùng
│   │   ├── Product.php          # Model sản phẩm
│   │   └── Order.php            # Model đơn hàng
│   ├── views/                   # Các file giao diện (View)
│   │   ├── layouts/             # Layout chung (header, footer)
│   │   ├── home/                # Trang chủ
│   │   ├── products/            # Giao diện sản phẩm
│   │   ├── auth/                # Giao diện đăng nhập/đăng ký
│   │   ├── cart/                # Giao diện giỏ hàng
│   │   ├── checkout/           # Giao diện thanh toán
│   │   ├── orders/              # Giao diện đơn hàng
│   │   ├── profile/             # Giao diện hồ sơ cá nhân
│   │   └── admin/               # Giao diện admin
│   └── helpers/                 # Các hàm hỗ trợ
│       ├── functions.php        # Hàm utility chung
│       ├── security.php         # Hàm bảo mật (XSS, CSRF)
│       └── validation.php       # Hàm validate input
├── database/                    # Database migrations
│   └── migrations/               # Các file SQL tạo bảng
│       ├── 001_CreateInitialTables.sql
│       ├── 002_AddShippingInfoToOrders.sql
│       └── README.md
├── public/                      # Thư mục public (web root)
│   ├── index.php                # Entry point, Router
│   ├── .htaccess                # URL rewrite
│   ├── assets/                  # Tài nguyên tĩnh
│   │   ├── css/                 # File CSS
│   │   ├── js/                  # File JavaScript
│   │   └── images/              # Hình ảnh
│   └── uploads/                 # File upload (ảnh sản phẩm)
├── storage/                     # Thư mục lưu trữ
│   └── logs/                    # Log files
├── .env.example                 # Mẫu file cấu hình môi trường
├── .htaccess                    # Cấu hình Apache root
└── README.md                    # Tài liệu dự án
```

**Giải thích cấu trúc:**

- **app/**: Chứa toàn bộ logic ứng dụng, không truy cập trực tiếp từ web
- **app/controllers/**: Mỗi controller xử lý một nhóm chức năng cụ thể
- **app/models/**: Mỗi model tương ứng với một bảng trong database
- **app/views/**: Chia theo module chức năng, sử dụng layout chung
- **app/helpers/**: Các hàm dùng chung (format tiền, validate, bảo mật)
- **database/migrations/**: Version control cho database schema
- **public/**: Thư mục duy nhất truy cập được từ web, chứa index.php (router)
- **public/assets/**: CSS, JS, images được tải trực tiếp bởi browser
- **public/uploads/**: File upload từ người dùng (ảnh sản phẩm)
- **storage/logs/**: Lưu log lỗi, log hoạt động hệ thống

# **IV. Các thư viện thirdparty sử dụng trong dự án**

- **Bootstrap 5:** Framework CSS cho giao diện responsive
- **PHP 8.0:** Ngôn ngữ backend
- **MySQL:** Database management system
- **PDO:** PHP Data Objects cho database connection

# **Chương 4 – Thiết kế cơ sở dữ liệu**

# **I. Vẽ lược đồ cơ sở dữ liệu**

**Các bảng chính:**

1. **users:** Lưu trữ thông tin người dùng
2. **products:** Lưu trữ thông tin sản phẩm
3. **orders:** Lưu trữ thông tin đơn hàng
4. **order_details:** Lưu trữ chi tiết đơn hàng

**Mối quan hệ:**
- users (1) -> orders (N)
- orders (1) -> order_details (N)
- products (1) -> order_details (N)

![](_page_13_Figure_1.jpeg)

*Hình. 2: Database Schema Diagram*

![](_page_14_Picture_1.jpeg)

# **II. Mô tả cấu trúc các thành phần có trong cơ sở dữ liệu**

## Table: users

| Column       | Type         | Description                   |
|--------------|--------------|-------------------------------|
| id           | INT          | Primary key, Auto increment   |
| username     | VARCHAR(50)  | Tên đăng nhập (Unique)        |
| email        | VARCHAR(100) | Email (Unique)                |
| password     | VARCHAR(255) | Mật khẩu (hashed)             |
| fullname     | VARCHAR(100) | Họ tên                        |
| phone        | VARCHAR(20)  | Số điện thoại                 |
| address      | TEXT         | Địa chỉ                      |
| role         | VARCHAR(20)  | Vai trò (user/admin)          |
| created_at   | DATETIME     | Ngày tạo                     |
| updated_at   | DATETIME     | Ngày cập nhật                 |

## Table: products

| Column         | Type         | Description                   |
|----------------|--------------|-------------------------------|
| id             | INT          | Primary key, Auto increment   |
| name           | VARCHAR(255) | Tên sản phẩm                  |
| brand          | VARCHAR(50)  | Thương hiệu                   |
| cpu            | VARCHAR(100) | Chip                          |
| bo_nho_trong   | VARCHAR(50)  | Bộ nhớ trong                  |
| pin            | VARCHAR(50)  | Pin                           |
| price          | DECIMAL(10,2)| Giá                           |
| quantity       | INT          | Số lượng                      |
| description    | TEXT         | Mô tả                         |
| image          | VARCHAR(255) | Hình ảnh                      |
| created_at     | DATETIME     | Ngày tạo                     |
| updated_at     | DATETIME     | Ngày cập nhật                 |

## Table: orders

| Column        | Type         | Description                   |
|---------------|--------------|-------------------------------|
| id            | INT          | Primary key, Auto increment   |
| user_id       | INT          | Foreign key đến users        |
| total_amount  | DECIMAL(10,2)| Tổng tiền                     |
| status        | VARCHAR(50)  | Trạng thái đơn hàng          |
| shipping_name | VARCHAR(100) | Tên người nhận                |
| shipping_phone| VARCHAR(20)  | Số điện thoại người nhận       |
| shipping_address| TEXT       | Địa chỉ giao hàng            |
| created_at    | DATETIME     | Ngày tạo                     |

## Table: order_details

| Column        | Type         | Description                   |
|---------------|--------------|-------------------------------|
| id            | INT          | Primary key, Auto increment   |
| order_id      | INT          | Foreign key đến orders       |
| product_id    | INT          | Foreign key đến products     |
| quantity      | INT          | Số lượng                      |
| price         | DECIMAL(10,2)| Giá tại thời điểm đặt hàng  |

# **Chương 5 – Thiết kế giao diện**

# **I. Giao diện chức năng 1: Quản lý người dùng**

## 1.1 Trang đăng ký

![](_page_17_Picture_1.jpeg)

*Hình. 4: Giao diện trang đăng ký*

- Form đăng ký với các trường: tên đăng nhập, email, mật khẩu, xác nhận mật khẩu, họ tên
- Nút hiển thị/ẩn mật khẩu
- Validation client-side và server-side
- Thông báo lỗi/success

## 1.2 Trang đăng nhập

![](_page_18_Picture_1.jpeg)

*Hình. 5: Giao diện trang đăng nhập*

- Form đăng nhập với các trường: tên đăng nhập, mật khẩu
- Nút hiển thị/ẩn mật khẩu
- Link đến trang đăng ký
- Thông báo lỗi

## 1.3 Trang thông tin cá nhân

![](_page_19_Picture_1.jpeg)

*Hình. 6: Giao diện trang thông tin cá nhân*

- Hiển thị thông tin hiện tại của người dùng
- Form chỉnh sửa thông tin: họ tên, email, số điện thoại, địa chỉ
- Form đổi mật khẩu: mật khẩu hiện tại, mật khẩu mới, xác nhận mật khẩu
- Nút hiển thị/ẩn mật khẩu cho tất cả các trường mật khẩu
- Thông báo lỗi/success

# **II. Giao diện chức năng 2: Quản lý sản phẩm**

## 2.1 Trang danh sách sản phẩm

![](_page_20_Picture_1.jpeg)

*Hình. 7: Giao diện trang danh sách sản phẩm*

- Hiển thị danh sách sản phẩm dạng grid
- Mỗi sản phẩm hiển thị: hình ảnh, tên, giá
- Thanh tìm kiếm sản phẩm
- Bộ lọc theo thương hiệu
- Responsive design

## 2.2 Trang chi tiết sản phẩm

![](_page_21_Picture_1.jpeg)

*Hình. 8: Giao diện trang chi tiết sản phẩm*

- Layout 2 cột: hình ảnh bên trái, thông tin bên phải
- Hiển thị: hình ảnh lớn, tên sản phẩm, giá (gradient background)
- Thông số kỹ thuật dạng grid 2x2
- Mô tả sản phẩm
- Nút "Thêm vào giỏ hàng"
- Nút "Quay lại danh sách"

## 2.3 Trang quản lý sản phẩm (Admin)

![](_page_22_Picture_1.jpeg)

*Hình. 9: Giao diện trang quản lý sản phẩm (Admin)*

- Bảng danh sách sản phẩm
- Các nút: Thêm mới, Sửa, Xóa
- Form thêm/sửa sản phẩm
- Upload hình ảnh sản phẩm

# **III. Giao diện chức năng 3: Thao tác khách hàng với sản phẩm**

## 3.1 Trang giỏ hàng

![](_page_23_Picture_1.jpeg)

*Hình. 10: Giao diện trang giỏ hàng*

- Bảng danh sách sản phẩm trong giỏ hàng
- Hiển thị: hình ảnh, tên, giá, số lượng, tổng tiền
- Nút tăng/giảm số lượng
- Nút xóa sản phẩm
- Tổng tiền giỏ hàng
- Nút "Thanh toán"

## 3.2 Trang thanh toán

![](_page_24_Picture_1.jpeg)

*Hình. 11: Giao diện trang thanh toán*

- Form thông tin giao hàng: họ tên, số điện thoại, địa chỉ
- Hiển thị tổng tiền
- Nút "Đặt hàng"

## 3.3 Trang đơn hàng

![](_page_25_Picture_1.jpeg)

*Hình. 12: Giao diện trang đơn hàng*

- Bảng danh sách đơn hàng
- Hiển thị: mã đơn hàng, ngày đặt, tổng tiền, trạng thái
- Nút xem chi tiết

## 3.4 Trang chi tiết đơn hàng

![](_page_26_Picture_1.jpeg)

*Hình. 13: Giao diện trang chi tiết đơn hàng*

- Thông tin khách hàng
- Danh sách sản phẩm
- Tổng tiền
- Trạng thái đơn hàng

# **IV. Giao diện chức năng 4: Nâng cao**

## 4.1 Trang quản lý người dùng (Admin)

![](_page_27_Picture_1.jpeg)

*Hình. 14: Giao diện trang quản lý người dùng (Admin)*

- Bảng danh sách người dùng
- Hiển thị: tên đăng nhập, email, họ tên, vai trò
- Nút: Xóa, Đặt lại mật khẩu

## 4.2 Trang đặt lại mật khẩu (Admin)

![](_page_28_Picture_1.jpeg)

*Hình. 15: Giao diện trang đặt lại mật khẩu (Admin)*

- Form đặt lại mật khẩu
- Nút hiển thị/ẩn mật khẩu
- Validation

## 4.3 Trang thống kê (Admin)

![](_page_29_Picture_1.jpeg)

*Hình. 16: Giao diện trang thống kê (Admin)*

- Dashboard với các card thống kê
- Số lượng người dùng
- Số lượng đơn hàng
- Tổng doanh thu
- Biểu đồ thống kê

# **Chương 6 - Kiểm thử**

# **I. Kiểm thử đơn vị**

## Test 1: Đăng ký tài khoản
- Input: Thông tin hợp lệ
- Expected: Tài khoản được tạo thành công
- Result: Pass

## Test 2: Đăng nhập
- Input: Tên đăng nhập và mật khẩu đúng
- Expected: Đăng nhập thành công
- Result: Pass

## Test 3: Thêm sản phẩm vào giỏ hàng
- Input: ID sản phẩm
- Expected: Sản phẩm được thêm vào giỏ hàng
- Result: Pass

## Test 4: Đặt hàng
- Input: Thông tin giao hàng hợp lệ
- Expected: Đơn hàng được tạo thành công
- Result: Pass

# **II. Kiểm thử hệ thống**

## Test 1: Quy trình mua hàng hoàn chỉnh
1. Khách hàng đăng nhập
2. Khách hàng xem danh sách sản phẩm
3. Khách hàng thêm sản phẩm vào giỏ hàng
4. Khách hàng thanh toán
5. Khách hàng xem lịch sử đơn hàng
- Expected: Quy trình hoàn tất thành công
- Result: Pass

## Test 2: Quản lý sản phẩm
1. Admin đăng nhập
2. Admin thêm sản phẩm mới
3. Admin sửa sản phẩm
4. Admin xóa sản phẩm
- Expected: Tất cả thao tác thành công
- Result: Pass

## Test 3: Bảo mật
1. Thử truy cập trang admin khi chưa đăng nhập
2. Thử truy cập trang profile khi chưa đăng nhập
- Expected: Chuyển hướng đến trang đăng nhập
- Result: Pass

# **III. Kiểm thử phi chức năng**

## Test 1: Responsive design
- Test trên các thiết bị: Desktop, Tablet, Mobile
- Expected: Giao diện hiển thị đúng trên tất cả thiết bị
- Result: Pass

## Test 2: Performance
- Load time trang chủ < 2s
- Expected: Trang chủ load trong thời gian chấp nhận được
- Result: Pass

## Test 3: Security
- SQL Injection test
- XSS test
- CSRF test
- Expected: Tất cả các cuộc tấn công bị chặn
- Result: Pass

# **Chương 7 – Hướng dẫn cài đặt và sử dụng**

# **I. Hướng dẫn cài đặt**

## A. Yêu cầu hệ thống

### 1. Cho Web Application
- PHP 8.0 trở lên
- MySQL 5.7 trở lên
- Apache/Nginx web server
- Composer (nếu cần)
- Trình duyệt web hiện đại (Chrome, Firefox, Edge, Safari)

### 2. Cho Android Application
- Android Studio (phiên bản mới nhất)
- JDK 8 trở lên
- Android SDK (API 21 trở lên)
- Thiết bị Android hoặc AVD (Android Virtual Device)
- Minimum SDK: API 21 (Android 5.0 Lollipop)
- Target SDK: API 33 (Android 13)

## B. Cài đặt Web Application

### 1. Cài đặt XAMPP
1. Tải XAMPP từ https://www.apachefriends.org/
2. Chạy file installer và cài đặt XAMPP
3. Mở XAMPP Control Panel
4. Khởi động Apache và MySQL

### 2. Clone repository
```bash
git clone https://github.com/TrungHauNguyen4/Web_PhP_Phone_store.git
```

### 3. Cấu hình Database
1. Mở phpMyAdmin tại http://localhost/phpmyadmin
2. Tạo database mới tên `laptop_store`
3. Import file SQL từ thư mục `database/migrations/`
4. Hoặc chạy các file migration theo thứ tự

### 4. Cấu hình kết nối Database
Mở file `config/config.php` và cập nhật:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'laptop_store');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 5. Chạy Web Application

**Cách 1: Sử dụng XAMPP Apache**
1. Copy thư mục dự án vào `C:\xampp\htdocs\BT_Cuoi_Ky`
2. Truy cập http://localhost/BT_Cuoi_Ky/public

**Cách 2: Sử dụng PHP Built-in Server**
1. Mở terminal
2. Di chuyển đến thư mục `public`:
   ```bash
   cd D:\demophp\BT_Cuoi_Ky\public
   ```
3. Chạy lệnh:
   ```bash
   php -S 0.0.0.0:3000
   ```
4. Truy cập http://localhost:3000

### 6. Tài khoản mặc định
- **Admin:**
  - Username: admin
  - Password: admin123
- **User:**
  - Username: user
  - Password: user123

## C. Cài đặt Android Application

### 1. Cài đặt Android Studio
1. Tải Android Studio từ https://developer.android.com/studio
2. Chạy installer và cài đặt Android Studio
3. Cài đặt Android SDK và các components cần thiết
4. Cấu hình JDK (Android Studio sẽ tự động cài đặt JDK)

### 2. Clone hoặc Copy Project Android
```bash
# Nếu project Android nằm trong cùng repository
# Thư mục android_app đã có sẵn trong dự án
```

### 3. Mở Project trong Android Studio
1. Mở Android Studio
2. Chọn "Open an Existing Project"
3. Chọn thư mục `android_app` trong dự án
4. Đợi Gradle sync hoàn tất

### 4. Cấu hình URL Server
Mở file `android_app/app/src/main/java/com/example/laptopstore/MainActivity.java` và cập nhật URL:
```java
// Thay đổi URL này thành URL của web application của bạn
webView.loadUrl("http://10.118.246.227:3000");
// Hoặc sử dụng localhost nếu test trên emulator
// webView.loadUrl("http://10.0.2.2:3000");
```

### 5. Build và Run Application
1. Kết nối thiết bị Android qua USB (bật USB Debugging)
2. Hoặc tạo AVD trong Android Studio
3. Nhấn nút "Run" (biểu tượng play) hoặc Shift+F10
4. Chọn thiết bị hoặc AVD
5. Đợi build và install hoàn tất

### 6. Cấu hình Permissions
File `AndroidManifest.xml` đã được cấu hình với INTERNET permission:
```xml
<uses-permission android:name="android.permission.INTERNET" />
```

## D. Kiểm tra cài đặt

### 1. Kiểm tra Web Application
- Truy cập http://localhost:3000 hoặc http://localhost/BT_Cuoi_Ky/public
- Kiểm tra trang chủ hiển thị đúng
- Đăng nhập với tài khoản admin
- Kiểm tra các chức năng cơ bản

### 2. Kiểm tra Android Application
- Mở ứng dụng trên thiết bị hoặc emulator
- Kiểm tra WebView load website thành công
- Test navigation giữa các trang
- Test nút Back trên điện thoại
- Kiểm tra responsive design

# **II. Hướng dẫn sử dụng**

## A. Sử dụng Web Application

### 1. Đối với khách hàng chưa đăng nhập (Guest)

#### Đăng ký tài khoản
1. Truy cập trang chủ
2. Nhấn nút "Đăng ký" trên navbar
3. Điền thông tin:
   - Tên đăng nhập
   - Email
   - Mật khẩu
   - Xác nhận mật khẩu
   - Họ tên
4. Nhấn nút "Đăng ký"
5. Đăng nhập với tài khoản mới tạo

#### Xem danh sách sản phẩm
1. Truy cập trang chủ
2. Nhấn "Sản phẩm" trên navbar
3. Xem danh sách sản phẩm với hình ảnh và giá
4. Sử dụng thanh tìm kiếm để tìm sản phẩm theo tên
5. Sử dụng bộ lọc thương hiệu để lọc sản phẩm

#### Xem chi tiết sản phẩm
1. Nhấn vào sản phẩm từ danh sách
2. Xem thông tin chi tiết:
   - Hình ảnh sản phẩm
   - Tên sản phẩm
   - Giá
   - Thông số kỹ thuật (CPU, RAM, SSD, v.v.)
   - Mô tả chi tiết
   - Số lượng tồn kho

#### Thêm sản phẩm vào giỏ hàng
1. Xem chi tiết sản phẩm
2. Nhấn nút "Thêm vào giỏ hàng"
3. Sản phẩm được thêm vào giỏ hàng (lưu trong session)
4. Hiển thị thông báo thành công

#### Xem giỏ hàng
1. Nhấn "Giỏ hàng" trên navbar
2. Xem danh sách sản phẩm trong giỏ
3. Thay đổi số lượng sản phẩm
4. Xóa sản phẩm khỏi giỏ
5. Xem tổng tiền

#### Đặt hàng
1. Xem giỏ hàng
2. Nhấn nút "Thanh toán"
3. Điền thông tin giao hàng:
   - Họ tên
   - Số điện thoại
   - Địa chỉ
4. Nhấn nút "Đặt hàng"
5. Đơn hàng được tạo và lưu vào database

### 2. Đối với khách hàng đã đăng nhập (Customer)

#### Đăng nhập
1. Truy cập trang chủ
2. Nhấn "Đăng nhập" trên navbar
3. Điền tên đăng nhập và mật khẩu
4. Nhấn nút "Đăng nhập"
5. Được chuyển hướng đến trang chủ

#### Xem lịch sử đơn hàng
1. Đăng nhập vào tài khoản
2. Nhấn "Đơn hàng" trên navbar
3. Xem danh sách các đơn hàng đã đặt
4. Xem thông tin:
   - Mã đơn hàng
   - Ngày đặt
   - Tổng tiền
   - Trạng thái đơn hàng
5. Nhấn vào đơn hàng để xem chi tiết

#### Xem chi tiết đơn hàng
1. Từ danh sách đơn hàng
2. Nhấn vào đơn hàng muốn xem
3. Xem chi tiết:
   - Thông tin khách hàng
   - Danh sách sản phẩm
   - Số lượng và giá từng sản phẩm
   - Tổng tiền
   - Trạng thái đơn hàng

#### Cập nhật thông tin cá nhân
1. Đăng nhập vào tài khoản
2. Nhấn "Thông tin" trên navbar
3. Xem thông tin hiện tại
4. Chỉnh sửa thông tin:
   - Họ tên
   - Email
   - Số điện thoại
   - Địa chỉ
5. Có thể đổi mật khẩu (tùy chọn)
6. Nhấn nút "Lưu thay đổi"

#### Đổi mật khẩu
1. Đăng nhập vào tài khoản
2. Nhấn "Thông tin" trên navbar
3. Điền mật khẩu hiện tại
4. Điền mật khẩu mới
5. Điền xác nhận mật khẩu mới
6. Nhấn nút "Lưu thay đổi"
7. Mật khẩu được cập nhật

### 3. Đối với quản trị viên (Admin)

#### Đăng nhập Admin
1. Truy cập trang chủ
2. Nhấn "Đăng nhập" trên navbar
3. Điền tên đăng nhập và mật khẩu admin
4. Nhấn nút "Đăng nhập"
5. Được chuyển hướng đến trang admin

#### Xem Dashboard thống kê
1. Đăng nhập với tài khoản admin
2. Tự động chuyển đến trang admin dashboard
3. Xem thống kê:
   - Tổng số người dùng
   - Số đơn hàng trong tháng
   - Tổng doanh thu trong tháng
   - Danh sách đơn hàng gần đây
   - Danh sách người dùng mới

#### Quản lý sản phẩm
1. Đăng nhập với tài khoản admin
2. Nhấn "Sản phẩm" từ menu admin
3. Xem danh sách tất cả sản phẩm
4. **Thêm sản phẩm mới:**
   - Nhấn nút "Thêm sản phẩm mới"
   - Điền thông tin sản phẩm
   - Upload hình ảnh
   - Nhấn "Lưu"
5. **Sửa sản phẩm:**
   - Nhấn nút "Sửa" trên sản phẩm
   - Chỉnh sửa thông tin
   - Nhấn "Lưu"
6. **Xóa sản phẩm:**
   - Nhấn nút "Xóa" trên sản phẩm
   - Xác nhận xóa

#### Quản lý người dùng
1. Đăng nhập với tài khoản admin
2. Nhấn "Người dùng" từ menu admin
3. Xem danh sách tất cả người dùng
4. Tìm người dùng theo tên, email, số điện thoại
5. **Xóa người dùng:**
   - Nhấn nút "Xóa" trên người dùng
   - Xác nhận xóa
6. **Đặt lại mật khẩu:**
   - Nhấn nút "Đặt lại mật khẩu"
   - Nhập mật khẩu mới
   - Xác nhận

#### Quản lý đơn hàng
1. Đăng nhập với tài khoản admin
2. Nhấn "Đơn hàng" từ menu admin
3. Xem danh sách tất cả đơn hàng
4. Tìm đơn hàng theo ID, email, số điện thoại
5. **Xem chi tiết đơn hàng:**
   - Nhấn vào đơn hàng
   - Xem chi tiết đầy đủ
6. **Cập nhật trạng thái:**
   - Chọn trạng thái mới
   - Lưu thay đổi
7. **Xóa đơn hàng:**
   - Nhấn nút "Xóa"
   - Xác nhận xóa

## B. Sử dụng Android Application

### 1. Khởi động ứng dụng
1. Nhấn vào icon ứng dụng trên home screen
2. Ứng dụng mở và load website PHP
3. Đợi website load hoàn tất

### 2. Điều hướng trong ứng dụng
- **Navigation:** Sử dụng WebView để điều hướng giữa các trang
- **Back Button:** Nút Back trên điện thoại quay lại trang trước trong WebView
- **Exit:** Nếu không còn trang để quay lại, nút Back sẽ thoát ứng dụng

### 3. Các chức năng
Tất cả các chức năng của web application đều có sẵn trong Android app:
- Đăng ký/Đăng nhập
- Xem sản phẩm
- Thêm vào giỏ hàng
- Đặt hàng
- Xem lịch sử đơn hàng
- Quản lý thông tin cá nhân
- Quản lý admin (nếu đăng nhập với tài khoản admin)

### 4. Lợi ích của Android App
- Truy cập nhanh hơn qua icon trên home screen
- Không cần mở browser mỗi lần
- Tích hợp sâu với hệ điều hành Android
- Có thể thêm tính năng native trong tương lai (push notifications, camera, GPS)

### 5. Lưu ý khi sử dụng
- Cần kết nối internet để truy cập website
- URL server cần được cấu hình đúng trong MainActivity.java
- Nếu server thay đổi, cần rebuild và cài đặt lại app
- Responsive design của web application đảm bảo hiển thị tốt trên mobile

## C. Khắc phục sự cố

### 1. Web Application

#### Lỗi "Database connection failed"
- Kiểm tra MySQL đang chạy
- Kiểm tra thông tin kết nối trong config/config.php
- Kiểm tra database đã được tạo chưa

#### Lỗi "404 Not Found"
- Kiểm tra Apache đang chạy
- Kiểm tra đường dẫn đến thư mục public
- Kiểm tra file .htaccess

#### Lỗi "Permission denied"
- Kiểm tra quyền truy cập thư mục
- Kiểm tra quyền truy cập database

### 2. Android Application

#### Lỗi "Unable to load URL"
- Kiểm tra kết nối internet
- Kiểm tra URL server trong MainActivity.java
- Kiểm tra server đang chạy
- Nếu dùng emulator, dùng IP 10.0.2.2 thay cho localhost

#### Lỗi "App crashes"
- Kiểm tra Logcat trong Android Studio
- Kiểm tra INTERNET permission trong AndroidManifest.xml
- Kiểm tra minimum SDK version

#### Lỗi "WebView not loading"
- Kiểm tra JavaScript enabled
- Kiểm tra DOM Storage enabled
- Kiểm tra WebViewClient và WebChromeClient được set

# **KẾT LUẬN**

# **I. Kết quả đạt được**

Dự án đã hoàn thành thành công với các kết quả sau:
- Xây dựng được hệ thống thương mại điện tử bán điện thoại hoàn chỉnh
- Triển khai đầy đủ các chức năng cơ bản và nâng cao
- Áp dụng kiến trúc MVC để tổ chức code rõ ràng
- Bảo mật hệ thống với các biện pháp: password hashing, SQL Injection prevention, XSS prevention
- Giao diện responsive đẹp mắt với Bootstrap 5
- Database thiết kế chuẩn hóa với migrations
- Tài liệu chi tiết và dễ hiểu

# **II. Hạn chế**

- Chưa tích hợp cổng thanh toán thực tế
- Chưa có hệ thống đánh giá sản phẩm
- Chưa có chức năng chat hỗ trợ khách hàng
- Chưa có chức năng khuyến mãi và giảm giá
- Chưa có hệ thống notification email

# **III. Hướng phát triển**

- Tích hợp cổng thanh toán (VNPAY, PayPal, Stripe)
- Thêm chức năng đánh giá và bình luận sản phẩm
- Thêm chức năng chat hỗ trợ khách hàng
- Thêm chức năng khuyến mãi và giảm giá
- Thêm hệ thống notification email
- Tối ưu hóa performance
- Thêm unit tests và integration tests
- Deploy lên cloud server

# **PHỤ LỤC**

## A. Database Schema

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    role VARCHAR(20) DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(50),
    cpu VARCHAR(100),
    bo_nho_trong VARCHAR(50),
    pin VARCHAR(50),
    price DECIMAL(10,2) NOT NULL,
    quantity INT DEFAULT 0,
    description TEXT,
    image VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    shipping_name VARCHAR(100),
    shipping_phone VARCHAR(20),
    shipping_address TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

## B. API Endpoints

| Method | Endpoint                  | Description                  |
|--------|---------------------------|------------------------------|
| GET    | /                         | Trang chủ                    |
| GET    | /?page=products           | Danh sách sản phẩm          |
| GET    | /?page=product&id={id}    | Chi tiết sản phẩm            |
| GET    | /?page=cart               | Giỏ hàng                    |
| POST   | /?page=cart&action=add    | Thêm vào giỏ hàng           |
| POST   | /?page=cart&action=update | Cập nhật giỏ hàng           |
| POST   | /?page=cart&action=remove | Xóa khỏi giỏ hàng           |
| POST   | /?page=cart&action=checkout| Thanh toán                   |
| GET    | /?page=orders             | Danh sách đơn hàng           |
| GET    | /?page=auth&action=login  | Trang đăng nhập              |
| POST   | /?page=auth&action=login  | Xử lý đăng nhập              |
| GET    | /?page=auth&action=register| Trang đăng ký              |
| POST   | /?page=auth&action=register| Xử lý đăng ký              |
| GET    | /?page=auth&action=logout | Đăng xuất                    |
| GET    | /?page=profile            | Trang thông tin cá nhân       |
| POST   | /?page=profile            | Cập nhật thông tin           |
| GET    | /?page=admin               | Trang admin                  |
| GET    | /?page=admin&action=products| Quản lý sản phẩm (Admin)  |
| GET    | /?page=admin&action=users | Quản lý người dùng (Admin)   |
| GET    | /?page=admin&action=orders | Quản lý đơn hàng (Admin)    |

## C. Mã nguồn

Mã nguồn dự án được lưu trữ tại: https://github.com/TrungHauNguyen4/Web_PhP_Phone_store.git

# **Chương 8 – Phát triển ứng dụng Android**

## I. Giới thiệu về ứng dụng Android

Để mở rộng khả năng tiếp cận người dùng và nâng cao trải nghiệm sử dụng, dự án đã được phát triển thêm phiên bản ứng dụng Android. Ứng dụng Android này cho phép người dùng truy cập vào hệ thống bán điện thoại thông qua thiết bị di động một cách thuận tiện và nhanh chóng.

## II. Công nghệ sử dụng

### 1. Android Studio

Android Studio là IDE chính thức được Google cung cấp để phát triển ứng dụng Android:

- **Gradle Build System:** Quản lý dependencies và build process
- **Layout Editor:** Công cụ thiết kế giao diện trực quan
- **AVD Manager:** Quản lý thiết bị ảo để test ứng dụng
- **Code Completion & Debugging:** Hỗ trợ viết code và debug hiệu quả
- **Integration with Firebase:** Dễ dàng tích hợp các dịch vụ của Google

### 2. WebView Component

Ứng dụng sử dụng WebView để hiển thị website PHP hiện có:

- **WebView:** Component cho phép hiển thị nội dung web trong ứng dụng Android
- **WebSettings:** Cấu hình các tính năng như JavaScript, DOM Storage
- **WebViewClient:** Xử lý các sự kiện navigation
- **WebChromeClient:** Xử lý các tính năng nâng cao như alerts, progress bars

### 3. Java Programming Language

Ứng dụng được phát triển bằng ngôn ngữ Java:

- **Object-Oriented:** Tận dụng các tính năng OOP của Java
- **Android SDK:** Sử dụng các thư viện Android chuẩn
- **Compatibility:** Tương thích với nhiều phiên bản Android

## III. Kiến trúc ứng dụng

### 1. Cấu trúc dự án Android

```
android_app/
├── app/
│   ├── src/
│   │   └── main/
│   │       ├── java/
│   │       │   └── com/
│   │       │       └── example/
│   │       │           └── laptopstore/
│   │       │               └── MainActivity.java
│   │       ├── res/
│   │       │   ├── layout/
│   │       │   │   └── activity_main.xml
│   │       │   ├── values/
│   │       │   │   ├── colors.xml
│   │       │   │   ├── strings.xml
│   │       │   │   └── styles.xml
│   │       │   └── mipmap/
│   │       └── AndroidManifest.xml
│   └── build.gradle
├── build.gradle
├── settings.gradle
└── gradle.properties
```

### 2. MainActivity.java

MainActivity là activity chính của ứng dụng, chịu trách nhiệm:

- **Khởi tạo WebView:** Tạo và cấu hình WebView component
- **Cấu hình WebSettings:** Bật JavaScript, DOM Storage
- **Load URL:** Load website PHP từ server
- **Xử lý Back Button:** Cho phép quay lại trang trước trong WebView

### 3. activity_main.xml

Layout file định nghĩa giao diện ứng dụng:

- **WebView Component:** Chiếm toàn bộ màn hình
- **Constraints:** Đảm bảo hiển thị đúng trên các kích thước màn hình khác nhau
- **Responsive:** Tự động thích ứng với orientation changes

## IV. Tích hợp với website PHP

### 1. Kết nối với server

Ứng dụng Android kết nối với website PHP thông qua WebView:

```java
webView.loadUrl("http://10.118.246.227:3000");
```

URL có thể được cấu hình để:
- Sử dụng IP local network cho development
- Sử dụng domain name cho production
- Hỗ trợ cả HTTP và HTTPS

### 2. Cấu hình WebView

WebView được cấu hình để đảm bảo trải nghiệm tốt nhất:

```java
WebSettings webSettings = webView.getSettings();
webSettings.setJavaScriptEnabled(true);
webSettings.setDomStorageEnabled(true);
webSettings.setLoadWithOverviewMode(true);
webSettings.setUseWideViewPort(true);
```

Các cấu hình này cho phép:
- Chạy JavaScript trên website
- Lưu trữ dữ liệu local (cookies, localStorage)
- Hiển thị website đúng tỷ lệ
- Responsive design hoạt động tốt

### 3. Xử lý navigation

WebViewClient đảm bảo các link mở ngay trong app:

```java
webView.setWebViewClient(new WebViewClient());
```

WebChromeClient xử lý các tính năng nâng cao:

```java
webView.setWebChromeClient(new WebChromeClient());
```

### 4. Xử lý Back Button

Nút Back trên điện thoại được xử lý để:

- Quay lại trang trước trong WebView nếu có
- Thoát ứng dụng nếu không còn trang nào để quay lại

```java
@Override
public void onBackPressed() {
    if (webView.canGoBack()) {
        webView.goBack();
    } else {
        super.onBackPressed();
    }
}
```

## V. Cấu hình ứng dụng

### 1. AndroidManifest.xml

File manifest định nghĩa các cấu hình chính:

- **Package Name:** com.example.laptopstore
- **Permissions:** INTERNET permission để truy cập network
- **MainActivity:** Activity chính của ứng dụng
- **Orientation:** Portrait hoặc Landscape

### 2. build.gradle

Gradle file quản lý dependencies:

```gradle
dependencies {
    implementation 'androidx.appcompat:appcompat:1.6.1'
    implementation 'com.google.android.material:material:1.9.0'
    implementation 'androidx.constraintlayout:constraintlayout:2.1.4'
}
```

### 3. Cấu hình mạng

Ứng dụng cần INTERNET permission:

```xml
<uses-permission android:name="android.permission.INTERNET" />
```

## VI. Quy trình phát triển

### 1. Tạo dự án Android

1. Mở Android Studio
2. Tạo new project với Empty Activity
3. Đặt tên package: com.example.laptopstore
4. Chọn ngôn ngữ: Java
5. Minimum SDK: API 21 (Android 5.0)

### 2. Thêm WebView vào layout

1. Mở activity_main.xml
2. Thêm WebView component
3. Cấu hình constraints
4. Set ID cho WebView

### 3. Cấu hình MainActivity

1. Khởi tạo WebView trong onCreate()
2. Cấu hình WebSettings
3. Set WebViewClient và WebChromeClient
4. Load URL của website PHP

### 4. Thêm permissions

1. Mở AndroidManifest.xml
2. Thêm INTERNET permission
3. Test kết nối network

### 5. Build và chạy

1. Connect device hoặc start AVD
2. Build APK
3. Install và test ứng dụng
4. Debug và fix issues

## VII. Testing và Debugging

### 1. Testing trên thiết bị thật

- Kết nối điện thoại qua USB
- Bật USB Debugging
- Chạy ứng dụng trực tiếp trên device
- Test các tính năng chính

### 2. Testing trên AVD

- Tạo AVD với các API levels khác nhau
- Test trên nhiều kích thước màn hình
- Test trên các phiên bản Android khác nhau
- Kiểm tra responsive design

### 3. Debugging

- Sử dụng Android Studio Debugger
- Logcat để xem logs
- Breakpoints để debug code
- Network Inspector để kiểm tra network requests

## VIII. Triển khai và phân phối

### 1. Build APK Release

1. Chọn Build > Generate Signed Bundle/APK
2. Tạo keystore để sign ứng dụng
3. Build release APK
4. Test APK trước khi publish

### 2. Publish lên Google Play

1. Tạo tài khoản Google Play Developer
2. Tạo app listing
3. Upload APK
4. Cấu hình store listing
5. Submit để review

### 3. Cập nhật ứng dụng

- Tăng version code và version name
- Build APK mới
- Upload lên Google Play
- Rollout updates

## IX. Lợi ích của ứng dụng Android

### 1. Trải nghiệm người dùng tốt hơn

- Truy cập nhanh hơn qua icon trên home screen
- Không cần mở browser mỗi lần
- Tích hợp sâu với hệ điều hành Android

### 2. Tăng khả năng tiếp cận

- Có mặt trên Google Play Store
- Dễ dàng tìm kiếm và cài đặt
- Tăng uy tín thương hiệu

### 3. Tính năng mở rộng

- Push notifications
- Offline mode (với PWA)
- Camera integration
- GPS location services

### 4. Tùy chỉnh giao diện

- Custom splash screen
- App icon riêng
- Theme colors
- Navigation drawer

## X. Hướng phát triển tương lai

### 1. Native Android Development

Chuyển từ WebView sang native Android development:

- Sử dụng Retrofit để gọi API
- RecyclerView để hiển thị danh sách sản phẩm
- Navigation Component để điều hướng
- ViewModel và LiveData để quản lý state

### 2. Thêm tính năng native

- Push notifications với Firebase Cloud Messaging
- Camera để chụp hình sản phẩm
- GPS để định vị cửa hàng
- Biometric authentication

### 3. Offline support

- Sử dụng Room database để lưu data local
- Sync data khi có kết nối mạng
- Cache images với Glide hoặc Picasso

### 4. Cross-platform development

Xem xét các framework cross-platform:

- Flutter
- React Native
- Xamarin

Để phát triển cho cả iOS và Android từ một codebase.

# **TÀI LIỆU THAM KHẢO**

1. PHP Manual: https://www.php.net/docs.php
2. MySQL Documentation: https://dev.mysql.com/doc/
3. Bootstrap 5 Documentation: https://getbootstrap.com/docs/5.0/
4. MVC Pattern: https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller
5. SQL Injection Prevention: https://owasp.org/www-community/attacks/SQL_Injection
6. Password Hashing: https://www.php.net/manual/en/function.password-hash.php
7. PDO Documentation: https://www.php.net/manual/en/book.pdo.php
8. XAMPP Documentation: https://www.apachefriends.org/docs.html
9. PHP 8.0 New Features: https://www.php.net/releases/8.0/en
10. MySQL ACID Properties: https://dev.mysql.com/doc/refman/8.0/en/acid-mysql.html
11. Bootstrap Grid System: https://getbootstrap.com/docs/5.0/layout/grid/
12. OWASP Top 10: https://owasp.org/www-project-top-ten/
