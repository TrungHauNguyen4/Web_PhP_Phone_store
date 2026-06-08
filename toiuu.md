# toiuu.md - Đánh giá logic & độ ổn định chức năng hiện tại

## Tổng quan
Dự án là web PHP theo kiến trúc MVC, có route `public/index.php`, các controller cho Home/Products/Auth/Cart/Checkout/Orders/Profile/Admin, và model xử lý truy vấn MySQL (PDO prepared statements).

Qua rà soát mã nguồn các phần controller + model cốt lõi đã đọc được:
- Luồng cơ bản hoạt động đúng theo mô tả MVC.
- Có một số lỗi logic/không nhất quán có thể gây lỗi chạy hoặc hành vi sai trong các tình huống thực tế.

## Kết luận nhanh
**Chưa thể khẳng định “đúng & hoạt động ổn định 100%”** vì tồn tại ít nhất:
1) Lỗi tương thích session message (helper vs Controller) – thông báo có thể không hiện đúng.
2) Lẫn lộn/không nhất quán “cart” phía client vs phía server.
3) Lỗi tính năng checkout: tạo biến debug + xác định submit dựa theo `submit_order` (phụ thuộc view) có thể làm checkout không chạy đúng nếu name/field không khớp.
4) Một lỗi nghiêm trọng về sanitize/escape: `validation`/`security` có, nhưng việc escape trong router dùng `escape()` từ helper - cần chắc chắn helper được load đúng (trong `public/index.php` có require `app/helpers/functions.php` nên OK), tuy nhiên các view cần dùng đúng `escape()`/`htmlspecialchars`.

## Phân tích theo module

### 0) Xác minh luồng đặt hàng thực tế (từ chọn số lượng → giỏ → thanh toán → tạo đơn → hiển thị kết quả)

#### 0.1 Chọn số lượng để đặt
- Ở danh sách sản phẩm (`app/views/products/list.php`), người dùng có form:
  - `method=POST`, `action=/?page=cart&action=add`
  - field: `product_id`, `quantity`.
- Ở trang chi tiết sản phẩm (`app/views/products/detail.php`), form:
  - `method=POST`, `action=/?page=cart&action=add`
  - field: `product_id`, `quantity`.

➡️ Như vậy luồng “chọn số lượng” đang đi **thẳng vào CartController (server-side session cart)**, **khớp** với `CartController->add()`.

#### 0.2 Tính tiền phải trả theo số lượng đã chọn (Giỏ hàng)
- Giỏ hàng (`app/views/cart/index.php`) hiển thị:
  - mỗi item: `subtotal` từ server: `$item['subtotal']`.
  - tổng tiền: `$total` từ server.
- Có JavaScript “updateSubtotal/updateTotal” để cập nhật UI khi đổi số lượng.
  - Tuy nhiên: `updateTotal()` đang cố tìm text giá qua `td:nth-child(2)` và parse số từ chuỗi.
  - Sau khi submit form cập nhật giỏ (`/?page=cart&action=update`), server sẽ **tính lại** subtotal & total dựa trên session.

➡️ Kết luận: **số tiền hiển thị ở Checkout là số tiền server tính**, không phụ thuộc JS (miễn là người dùng bấm “Cập nhật giỏ hàng” trước khi thanh toán, hoặc nếu không bấm thì có thể hiển thị lệch tạm thời giữa UI và server). 

#### 0.3 Thanh toán (Checkout)
- Checkout (`app/views/checkout/index.php`):
  - hiển thị bảng item, mỗi dòng dùng `$item['subtotal']`.
  - hiển thị “Tổng cộng” dùng `$total`.
  - form submit:
    - `method=POST`, `action=/?page=checkout`
    - nút submit: `name="submit_order" value="1"`.

Trong controller (`app/controllers/OrderController.php`):
- `checkout()` xử lý POST chỉ khi:
  - `$isPost && $hasSubmitOrder` (tức có `submit_order`)
- Controller lấy thông tin form và validate:
  - fullname: không rỗng
  - phone: regex số 9-11
  - email: FILTER_VALIDATE_EMAIL
  - address: không rỗng
- Nếu validate OK:
  - `Order->create()` tạo record `orders` với:
    - `user_id`, `total_amount = $total` (tổng tiền từ session cart)
    - `status = pending`
    - `payment_method = payment_method` (default transfer)
  - foreach cartItems: `Order->addItem(order_id, product_id, quantity, subtotal)`
  - `unset($_SESSION['cart'])`
  - set message + redirect về `/?page=orders`.

➡️ Kết luận: phần “tạo đơn hàng và tính tổng tiền theo subtotal” về mặt công thức đang **khớp**.

#### 0.4 Hiển thị đơn hàng sau khi đặt
- Trang Orders (`app/views/orders/index.php`) hiển thị:
  - `total_amount` của order
  - chi tiết đơn dùng `$orderModel->getOrderDetails($order['id'])`.
- Model `getOrderDetails()` join `order_details` với `products` và lấy `od.quantity`, `od.price`.
- Trong view, thành tiền từng item hiển thị: `price * quantity` và tổng dùng `order['total_amount']`.

➡️ Kết luận: hiển thị tổng/chi tiết đang **đúng về công thức** nếu dữ liệu trong DB được ghi đúng.

### 0.5 Luồng đặt hàng: tạo đơn, cập nhật DB, hiển thị trạng thái (đúng/sai)
- Checkout (POST `/?page=checkout`) tạo đơn theo các bước:
  1) Validate form (fullname/phone/email/address) trong `OrderController::checkout()`.
  2) Tạo `orders` qua `Order->create()` với `total_amount = $total` và `status = pending`.
  3) Với từng item trong cart (từ session): insert vào `order_details` qua `Order->addItem()`.
  4) `unset($_SESSION['cart'])`.
  5) Redirect về `/?page=orders`.

=> Như vậy **tiền hiển thị trên trang “Đơn hàng của tôi”** là:
- Đơn hàng: hiển thị `orders.total_amount`.
- Chi tiết: `order_details.price * quantity`.

#### 0.5.1 Các lỗi/thiếu sót làm kết quả hiển thị “không đúng thực tế”
1) **Không kiểm tra/giảm tồn kho => người dùng có thể đặt số lượng vượt DB**
- `Cart` cho phép nhập quantity với `max="<?php echo $item['product']['quantity'] ?>"` (UI), nhưng server **không kiểm tra lại**.
- `OrderController` cũng không trừ `products.quantity`.
- Hệ quả: DB vẫn tạo đơn thành công và hiển thị tổng tiền đúng theo session cart, nhưng thực tế cửa hàng “hết hàng” vẫn không được phản ánh.

2) **Không dùng transaction cho bước tạo order + insert order_details**
- `Order->delete()` có transaction, nhưng `checkout()` thì không.
- Nếu `Order->addItem()` thất bại ở giữa danh sách:
  - DB có thể có `orders` tạo thành công nhưng `order_details` bị thiếu.
  - Trang “Đơn hàng của tôi” sẽ show:
    - `total_amount` (từ `orders`) vẫn bằng tổng $total ban đầu
    - nhưng “Chi tiết sản phẩm” có thể ít dòng hơn (vì order_details thiếu)
  - Đây đúng kiểu “tổng tiền hiển thị không khớp chi tiết thực tế”.

3) **Không có luồng “hủy đơn” cho user từ trang của user**
- Trong code đã đọc, các thao tác hủy/xóa đơn nằm ở AdminController.
- Nếu yêu cầu bài có “hủy đơn” cho user, chức năng này hiện tại **chưa thấy** trong luồng đặt hàng.

4) **Flash message có thể không hiện đúng (tác động cảm nhận ‘đã/không đặt thành công’)**
- `Controller` dùng `$_SESSION['flash_message']` nhưng view hiển thị message lại gọi `getMessage()` trong `helpers/functions.php` (dùng `$_SESSION['message']`).
- Kết quả: dù checkout redirect thành công, người dùng có thể không thấy thông báo tương ứng, tưởng rằng thao tác không diễn ra.

#### 0.5.2 Mức độ liên quan đến yêu cầu bạn nêu (từ chọn số lượng → thanh toán → hiển thị)
- Tiền hiển thị trên Checkout và Orders hiện tại **được tính từ session cart** và ghi vào DB theo logic hiện có.
- Nhưng “tính đúng thực tế” bị phá vỡ bởi:
  - thiếu kiểm tra tồn kho
  - thiếu transaction cho insert details
  - flash message không nhất quán (gây hiểu nhầm)



---

### 1) Router (`public/index.php`)
**Điểm tốt**
- Có sanitize `page` và `action` để hạn chế path traversal.
- Dùng try/catch và trả 500 có escape message.

**Điểm cần chú ý**
- Router chỉ lọc ký tự trong page/action, nhưng không kiểm tra whitelist route hợp lệ (vẫn safe ở mức path traversal; nhưng vẫn có thể gọi method không mong muốn nếu controller có method trùng tên).

### 2) Base Controller (`app/controllers/Controller.php`)
**Điểm tốt**
- `view()` ném exception khi view không tồn tại.
- `redirect()` gọi `exit`.
- Có helper flash message trong session: `flash_message` với `message/type`.

**Vấn đề nghiêm trọng tiềm ẩn**
- Trong `app/helpers/functions.php` lại tồn tại `setMessage()/getMessage()` khác: dùng `$_SESSION['message']` và `message_type`.
- Nếu view dùng helper `getMessage()` (hàm global) mà controller lại set `flash_message` (phương thức trong Controller), thông báo sẽ **không hiển thị**.

=> Đây là **bất nhất giữa 2 hệ thống flash message**.

### 3) Product (`app/controllers/ProductController.php`, `app/models/Product.php`)
**Logic đúng**
- `index()` hỗ trợ search theo `search` và lọc theo `brand`.
- `home()` lấy featured 6 sản phẩm đầu, carousel chọn 3 sản phẩm đầu có ảnh.
- Model dùng PDO prepared statements.
- `getAllBrands()` dùng DISTINCT.

**Rủi ro**
- `usort` sắp xếp lại bằng PHP trên kết quả fetchAll (ổn, nhưng không tối ưu lớn dữ liệu).
- Nếu trong DB có `price` là chuỗi, phép trừ trong usort có thể có implicit cast (thường vẫn OK trong PHP nhưng không “chắc tuyệt đối”).

### 4) Cart (`app/controllers/CartController.php`)
**Logic đúng (server-side)**
- Cart lưu session `$_SESSION['cart'][product_id] = quantity`.
- `add()` và `update()` chặn theo POST.

**Vấn đề lớn: JS cart localStorage**
- `public/assets/js/main.js` đang implement giỏ hàng bằng `localStorage` (hàm `addToCart/removeFromCart/getCart`).
- Trong khi server lại dùng session.

=> Nếu UI đang gọi JS `addToCart()` thì giỏ hàng **không đồng bộ với server**, dẫn tới:
- thêm vào localStorage nhưng server-side cart không có sản phẩm
- checkout/giỏ hàng server hiển thị trống hoặc sai.

=> Đây là **lỗi kiến trúc/đồng bộ dữ liệu** có thể làm chức năng giỏ hàng hoạt động không ổn định tùy cách tích hợp button.

### 5) Checkout / Orders (`app/controllers/OrderController.php`, `app/models/Order.php`)
**Luồng đúng**
- Chỉ cho phép đã đăng nhập.
- Nếu giỏ trống: thông báo và link mua.
- Khi POST và có `submit_order`: tạo order + addItem + xóa cart.
- Dùng transaction được dùng trong `Order->delete()`.

**Vấn đề tiềm ẩn**
- checkout phụ thuộc trường/form của view: `submit_order`.
  - Nếu view không dùng đúng `name="submit_order"` thì checkout sẽ không tạo đơn.
- Không thấy kiểm tra số lượng tồn kho trừ đi.
  - Model không update `products.quantity` khi đặt hàng.
  - Có thể chấp nhận theo đề bài, nhưng nếu muốn ổn định “nghiệp vụ”, cần kiểm tra/giảm stock.

### 6) Auth (`app/controllers/AuthController.php`, `app/models/User.php`)
**Logic đúng**
- Login: `password_verify`.
- Register: validate cơ bản, hash bcrypt bằng model.
- Logout hủy session và cache headers.

**Rủi ro**
- Register “setMessage lỗi validate” đang nối `implode('<br>', $errors)` vào flash message.
  - Nếu view hiển thị message không escape HTML phù hợp, có thể render không mong muốn (nhưng dữ liệu lỗi là từ server nội bộ, rủi ro thấp).

### 7) Admin (`app/controllers/AdminController.php`)
**Điểm tốt**
- Có `checkAdmin()`.
- Products CRUD có upload ảnh.
- Orders: cập nhật status, xóa order.

**Vấn đề**
- `AdminController->orders()` phần `task=view`: lấy `$order` và sau đó dùng `$userModel->getById($order['user_id']);` nhưng nếu `$order` null thì sẽ notice.
- upload ảnh: tạo `$uploadDir = APP_PATH . '/../public/assets/images/'`.
  - Khả năng chạy từ nơi khác sẽ ảnh hưởng path, nhưng theo cấu trúc MVC hiện tại thì có vẻ đúng.

## Vấn đề đồng bộ/nhất quán có thể làm hệ thống “không ổn định”
1) **Flash message inconsistent**
- `Controller.php` set `$_SESSION['flash_message']`.
- `helpers/functions.php` set `$_SESSION['message']`.
- Không rõ view dùng helper hay dùng phương thức controller.

2) **Cart inconsistent (JS localStorage vs PHP session)**
- `main.js` đang dùng localStorage.
- `CartController`/checkout dùng session.

3) **Checkout POST depende view field**
- checkout chỉ xử lý nếu `input('submit_order')` tồn tại.

## Danh sách đánh giá độ đúng & ổn định
- **Products (search/filter/detail/home):** Độ đúng: **cao**, rủi ro chủ yếu ở cast price và sắp xếp.
- **Auth:** Độ đúng: **cao**.
- **Cart/Checkout:** Độ đúng: **trung bình-thấp** vì xung đột JS localStorage vs server session.
- **Admin:** Độ đúng: **trung bình** (có thể chạy, nhưng có vài trường hợp null dẫn đến notice).

## Kiến nghị để “đạt ổn định tuyệt đối” (không thực hiện sửa trong yêu cầu này)
- Chuẩn hóa flash message: chỉ dùng một cơ chế `setMessage/getMessage` (hoặc phương thức trong Controller, hoặc helper global) và đảm bảo view sử dụng đúng.
- Chuẩn hóa giỏ hàng: bỏ localStorage hoặc đảm bảo JS gọi API server hoặc submit form đúng vào `CartController`.
- Kiểm tra view checkout đảm bảo nút submit có `name="submit_order"`.
- Khi đặt hàng: cân nhắc trừ tồn kho và validate số lượng.

---
*Lưu ý:* Kết quả này dựa trên rà soát các file đã đọc được ở controller/model (chưa đọc hết toàn bộ views, đặc biệt các view form checkout/cart/admin). Nếu view có đúng field name và cách hiển thị message/flash nhất quán, một số vấn đề ở trên có thể không xảy ra.

