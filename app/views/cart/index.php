<?php
/**
 * View Cart - Giỏ hàng
 * 
 * File này hiển thị giỏ hàng với:
 * - Danh sách sản phẩm trong giỏ
 * - Cập nhật số lượng sản phẩm
 * - Xóa sản phẩm khỏi giỏ
 * - Tính tổng tiền
 * - Link đến trang thanh toán
 * 
 * Dữ liệu được truyền từ CartController:
 * - $cartItems: Mảng các sản phẩm trong giỏ
 * - $total: Tổng tiền
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
    <h1 class="mb-4">🛒 Giỏ hàng</h1>

    <?php if (empty($cartItems)): ?>
        <div class="card text-center">
            <div class="card-body py-5">
                <p class="mb-4">Giỏ hàng của bạn đang trống</p>
                <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-primary btn-lg">→ Tiếp tục mua sắm</a>
            </div>
        </div>
    <?php else: ?>
        <form id="cartForm" method="POST" action="<?php echo getBaseUrl(); ?>/?page=cart&action=update">
            <input type="hidden" name="redirect_to_checkout" id="redirect_to_checkout" value="0">
            <div class="table-responsive mb-4">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center" style="width: 150px;">Giá</th>
                            <th class="text-center" style="width: 150px;">Số lượng</th>
                            <th class="text-center" style="width: 150px;">Tổng cộng</th>
                            <th class="text-center" style="width: 100px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <strong><?php echo escape($item['product']['name']); ?></strong><br>
                                    <small class="text-muted">
                                        Chip: <?php echo escape($item['product']['cpu'] ?? 'N/A'); ?><br>
                                        Bộ nhớ: <?php echo escape($item['product']['bo_nho_trong'] ?? 'N/A'); ?> | Pin: <?php echo escape($item['product']['pin'] ?? 'N/A'); ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <?php echo formatPrice($item['product']['price']); ?> VNĐ
                                </td>
                                <td class="text-center">
                                    <input type="number" name="quantity[<?php echo $item['product']['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['product']['quantity'] > 0 ? $item['product']['quantity'] : 999; ?>" class="form-control form-control-sm" style="width: 80px; margin: 0 auto;" onchange="updateSubtotal(this, <?php echo $item['product']['price']; ?>)">
                                </td>
                                <td class="text-center fw-bold">
                                    <?php echo formatPrice($item['subtotal']); ?> VNĐ
                                </td>
                                <td class="text-center">
                                    <a href="<?php echo getBaseUrl(); ?>/?page=cart&action=remove&id=<?php echo $item['product']['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">🗑️ Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex gap-2 mb-4">
                <button type="submit" class="btn btn-primary">Cập nhật giỏ hàng</button>
                <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-secondary">Tiếp tục mua sắm</a>
            </div>
        </form>

        <!-- Order Summary -->
        <div class="card" style="max-width: 400px; margin-left: auto;">
            <div class="card-body">
                <h5 class="card-title mb-3">📋 Tóm tắt đơn hàng</h5>
                <table class="table table-borderless mb-3">
                    <tr>
                        <td>Tổng sản phẩm:</td>
                        <td class="text-end fw-bold"><?php echo array_sum(array_column($cartItems, 'quantity')); ?> sản phẩm</td>
                    </tr>
                    <tr>
                        <td>Tổng tiền:</td>
                        <td class="text-end fw-bold text-primary fs-5"><?php echo formatPrice($total); ?> VNĐ</td>
                    </tr>
                </table>

                <?php if (isLoggedIn()): ?>
                    <button type="button" onclick="submitToCheckout()" class="btn btn-success w-100 btn-lg">💳 Thanh toán ngay</button>
                <?php else: ?>
                    <div class="alert alert-warning mb-0 text-center">
                        <p class="mb-0">Vui lòng <a href="<?php echo getBaseUrl(); ?>/?page=auth&action=login" class="alert-link fw-bold">đăng nhập</a> để thanh toán</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function updateSubtotal(input, price) {
    const quantity = parseInt(input.value);
    const row = input.closest('tr');
    const subtotalCell = row.querySelector('td:nth-child(4)');
    const subtotal = price * quantity;
    subtotalCell.textContent = formatPrice(subtotal) + ' VNĐ';

    // Update total
    updateTotal();
}

function updateTotal() {
    let total = 0;
    const quantityInputs = document.querySelectorAll('input[name^="quantity"]');
    quantityInputs.forEach(input => {
        const row = input.closest('tr');
        const priceCell = row.querySelector('td:nth-child(2)');
        const priceText = priceCell.textContent.replace(/[^0-9]/g, '');
        const price = parseInt(priceText);
        const quantity = parseInt(input.value);
        total += price * quantity;
    });

    const totalElement = document.querySelector('.text-primary.fs-5');
    if (totalElement) {
        totalElement.textContent = formatPrice(total) + ' VNĐ';
    }
}

function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function submitToCheckout() {
    document.getElementById('redirect_to_checkout').value = '1';
    document.getElementById('cartForm').submit();
}
</script>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
