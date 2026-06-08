<?php
/**
 * View Checkout - Trang thanh toán
 * 
 * File này hiển thị trang thanh toán với:
 * - Danh sách sản phẩm trong giỏ hàng
 * - Form nhập thông tin người mua
 * - Chọn phương thức thanh toán
 * 
 * Dữ liệu được truyền từ OrderController:
 * - $cartItems: Mảng các sản phẩm trong giỏ
 * - $total: Tổng tiền
 * - $user: Thông tin user hiện tại
 * - $submitted: Biến flag nếu form đã được submit
 * - $errors: Mảng lỗi validate (nếu có)
 */

// Kiểm tra tính hợp lệ của session trước khi include header
if (isLoggedIn()) {
    // Regenerate session ID để ngăn chặn session fixation
    if (!isset($_SESSION['regenerated'])) {
        session_regenerate_id(true);
        $_SESSION['regenerated'] = true;
    }
}

include APP_PATH . '/views/layouts/header.php';
?>

<div class="container">
    <h1 class="mb-4">💳 Thanh toán đơn hàng</h1>

    <div class="row">
        <!-- Thông tin sản phẩm -->
        <div class="col-lg-6 mb-4">
            <h3 class="mb-3">📦 Thông tin sản phẩm</h3>
            <div class="table-responsive mb-4">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center" style="width: 80px;">SL</th>
                            <th class="text-end" style="width: 120px;">Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <strong><?php echo escape($item['product']['name']); ?></strong>
                                </td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-end fw-bold">
                                    <?php echo formatPrice($item['subtotal']); ?> VNĐ
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <div class="card-body text-end">
                    <p class="text-muted mb-2">Tổng cộng:</p>
                    <p class="mb-0 fs-3 text-primary fw-bold">
                        <?php echo formatPrice($total); ?> VNĐ
                    </p>
                </div>
            </div>
        </div>

        <!-- Form thông tin người mua -->
        <div class="col-lg-6">
            <h3 class="mb-3">👤 Thông tin người mua</h3>

            <?php if ($submitted && !empty($errors)): ?>
                <div class="alert alert-danger mb-4">
                    <strong>Lỗi:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo escape($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($submitted && empty($errors)): ?>
                <div class="alert alert-info mb-4">
                    <strong>Debug:</strong> Form đã được submit nhưng không có lỗi validate. Kiểm tra console để xem lỗi.
                </div>
            <?php endif; ?>

            <form id="checkoutForm" method="POST" action="<?php echo getBaseUrl(); ?>/?page=checkout" class="no-validate">
                <div class="mb-3">
                    <label for="fullname" class="form-label">👤 Họ tên *</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" required
                        value="<?php echo escape($_POST['fullname'] ?? ($user['fullname'] ?? '')); ?>">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">📱 Số điện thoại *</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required placeholder="09xxxxxxxxx"
                        pattern="[0-9]{9,11}" title="Số điện thoại phải từ 9-11 chữ số"
                        value="<?php echo escape($_POST['phone'] ?? ($user['phone'] ?? '')); ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">📧 Email *</label>
                    <input type="email" id="email" name="email" class="form-control" required
                        value="<?php echo escape($_POST['email'] ?? ($user['email'] ?? '')); ?>">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">📍 Địa chỉ giao hàng *</label>
                    <textarea id="address" name="address" class="form-control" required rows="3"><?php echo escape($_POST['address'] ?? ($user['address'] ?? '')); ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="payment_method" class="form-label">💳 Phương thức thanh toán *</label>
                    <select id="payment_method" name="payment_method" class="form-select" required>
                        <option value="transfer">Chuyển khoản ngân hàng</option>
                        <option value="cod">Thanh toán khi nhận hàng</option>
                        <option value="wallet">Ví điện tử</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="submit_order" value="1" class="btn btn-success btn-lg">
                        ✅ Đặt hàng
                    </button>
                    <a href="<?php echo getBaseUrl(); ?>/?page=cart" class="btn btn-secondary btn-lg">
                        ← Quay lại giỏ hàng
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
