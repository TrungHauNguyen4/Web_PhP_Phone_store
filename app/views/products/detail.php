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

<div class="container my-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height: 500px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                    <?php if ($product['image']): ?>
                        <img src="<?php echo getBaseUrl(); ?>/assets/images/<?php echo escape($product['image']); ?>"
                             alt="<?php echo escape($product['name']); ?>"
                             class="img-fluid"
                             style="max-height: 450px; object-fit: contain;">
                    <?php else: ?>
                        <div class="text-center">
                            <span style="font-size: 8rem;">📱</span>
                            <p class="text-muted mt-3">Không có hình ảnh</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h1 class="display-5 fw-bold mb-3"><?php echo escape($product['name']); ?></h1>

                    <!-- Price -->
                    <div class="alert alert-primary mb-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); border: none;">
                        <p class="h2 mb-0 text-white fw-bold">
                            <?php echo formatPrice($product['price']); ?> VNĐ
                        </p>
                    </div>

                    <!-- Specifications Grid -->
                    <div class="mb-4">
                        <h4 class="mb-3 fw-bold">Thông số kỹ thuật</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <small class="text-muted d-block mb-1">Hãng</small>
                                    <strong><?php echo escape($product['brand'] ?? 'N/A'); ?></strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <small class="text-muted d-block mb-1">Chip</small>
                                    <strong><?php echo escape($product['cpu'] ?? 'N/A'); ?></strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <small class="text-muted d-block mb-1">Bộ nhớ trong</small>
                                    <strong><?php echo escape($product['bo_nho_trong'] ?? 'N/A'); ?></strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <small class="text-muted d-block mb-1">Pin</small>
                                    <strong><?php echo escape($product['pin'] ?? 'N/A'); ?></strong>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 bg-light rounded">
                                    <small class="text-muted d-block mb-1">Số lượng</small>
                                    <?php if ($product['quantity'] > 0): ?>
                                        <span class="badge bg-success fs-6">Còn hàng (<?php echo $product['quantity']; ?>)</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger fs-6">Hết hàng</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h4 class="mb-3 fw-bold">Mô tả</h4>
                        <p class="text-secondary" style="line-height: 1.8;"><?php echo escape($product['description']); ?></p>
                    </div>

                    <!-- Add to Cart Button -->
                    <?php if ($product['quantity'] > 0): ?>
                        <form method="POST" action="<?php echo getBaseUrl(); ?>/?page=cart&action=add">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                                🛒 Thêm vào giỏ hàng
                            </button>
                        </form>
                    <?php else: ?>
                        <button disabled class="btn btn-secondary btn-lg w-100 fw-bold" style="cursor: not-allowed; opacity: 0.6;">
                            Hết hàng
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-outline-secondary">
            ← Quay lại danh sách sản phẩm
        </a>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
