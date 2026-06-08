<?php
/**
 * View Product Detail - Chi tiết sản phẩm
 *
 * File này hiển thị chi tiết sản phẩm với:
 * - Hình ảnh sản phẩm
 * - Thông số kỹ thuật (Hãng)
 * - Giá và số lượng
 * - Mô tả sản phẩm
 * - Form thêm vào giỏ hàng
 *
 * Dữ liệu được truyền từ ProductController:
 * - $product: Thông tin chi tiết sản phẩm
 */

include APP_PATH . '/views/layouts/header.php';
?>

<div class="container">
    <div class="card mb-4">
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start;">
                <!-- Product Image -->
                <div style="background: var(--gray-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; min-height: 400px; overflow: hidden;">
                    <?php if ($product['image']): ?>
                        <img src="<?php echo getBaseUrl(); ?>/assets/images/<?php echo escape($product['image']); ?>"
                             alt="<?php echo escape($product['name']); ?>"
                             style="max-width: 100%; max-height: 400px; object-fit: contain;">
                    <?php else: ?>
                        <span style="font-size: 5rem;">📱</span>
                    <?php endif; ?>
                </div>

                <!-- Product Info -->
                <div>
                    <h1 class="mb-3"><?php echo escape($product['name']); ?></h1>

                    <div style="background: var(--gray-50); padding: 1.5rem; border-radius: var(--radius-lg); margin-bottom: 2rem; border: 1px solid var(--border-color);">
                        <p style="font-size: 2.5rem; color: var(--primary-color); font-weight: 800; margin: 0;">
                            <?php echo formatPrice($product['price']); ?> VNĐ
                        </p>
                    </div>

                    <div class="mb-4">
                        <h3 class="mb-3">Thông số kỹ thuật</h3>
                        <table class="table-container" style="box-shadow: none; border: 1px solid var(--border-color);">
                            <tbody>
                                <tr>
                                    <td style="font-weight: 600; width: 150px;">Hãng:</td>
                                    <td><?php echo escape($product['brand'] ?? 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Chip:</td>
                                    <td><?php echo escape($product['cpu'] ?? 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Bộ nhớ trong:</td>
                                    <td><?php echo escape($product['bo_nho_trong'] ?? 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Pin:</td>
                                    <td><?php echo escape($product['pin'] ?? 'N/A'); ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600;">Số lượng:</td>
                                    <td>
                                        <?php if ($product['quantity'] > 0): ?>
                                            <span class="alert alert-success" style="display: inline-block; padding: 0.25rem 0.75rem; margin: 0;">
                                                Còn hàng (<?php echo $product['quantity']; ?>)
                                            </span>
                                        <?php else: ?>
                                            <span class="alert alert-danger" style="display: inline-block; padding: 0.25rem 0.75rem; margin: 0;">
                                                Hết hàng
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-4">
                        <h3 class="mb-3">Mô tả</h3>
                        <p style="line-height: 1.8; color: var(--text-light);"><?php echo escape($product['description']); ?></p>
                    </div>

                    <?php if ($product['quantity'] > 0): ?>
                        <form id="addToCartForm" method="POST" action="<?php echo getBaseUrl(); ?>/?page=cart&action=add" class="d-flex gap-2 no-validate">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                🛒 Thêm vào giỏ hàng
                            </button>
                        </form>
                    <?php else: ?>
                        <button disabled class="btn btn-secondary btn-lg w-100" style="cursor: not-allowed; opacity: 0.6;">
                            Hết hàng
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-secondary">
                    ← Quay lại danh sách sản phẩm
                </a>
            </div>
        </div>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
