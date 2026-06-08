<?php
/**
 * View Products List - Danh sách sản phẩm
 *
 * File này hiển thị danh sách sản phẩm với:
 * - Tìm kiếm sản phẩm theo từ khóa
 * - Lọc theo hãng
 * - Sắp xếp theo giá và tên
 * - Hiển thị sản phẩm dạng grid
 *
 * Dữ liệu được truyền từ ProductController:
 * - $products: Mảng các sản phẩm đã được lọc và sắp xếp
 * - $search: Từ khóa tìm kiếm
 * - $brand: Hãng đã chọn
 * - $brands: Danh sách tất cả các hãng
 */

include APP_PATH . '/views/layouts/header.php';
?>

<div class="container">
    <h1 class="mb-4">Danh sách sản phẩm</h1>

    <!-- Search and Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo getBaseUrl(); ?>/">
                <input type="hidden" name="page" value="products">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">🔍 Tìm kiếm</label>
                        <input type="text" id="search" name="search" value="<?php echo escape($search); ?>"
                               class="form-control" placeholder="Tên sản phẩm, hãng...">
                    </div>
                    <div class="col-md-3">
                        <label for="brand" class="form-label">🏢 Hãng</label>
                        <select id="brand" name="brand" class="form-select">
                            <option value="">Tất cả hãng</option>
                            <?php foreach ($brands as $b): ?>
                                <option value="<?php echo escape($b); ?>" <?php echo $brand === $b ? 'selected' : ''; ?>>
                                    <?php echo escape($b); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            🔎 Tìm kiếm
                        </button>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-secondary w-100">
                            ↺ Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <?php
                        $image = $product['image'] ?? '';
                        $hasImage = !empty($image);
                        $imageUrl = $hasImage ? (getBaseUrl() . '/assets/images/' . $image) : '';
                        ?>
                        <?php if ($hasImage): ?>
                            <img src="<?php echo $imageUrl; ?>" class="card-img-top" alt="<?php echo escape($product['name']); ?>" style="height: 200px; object-fit: contain; background-color: #f8f9fa;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span style="font-size: 3rem;">�</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo escape($product['name']); ?></h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    Hãng: <?php echo escape($product['brand'] ?? 'N/A'); ?><br>
                                    Chip: <?php echo escape($product['cpu'] ?? 'N/A'); ?><br>
                                    Bộ nhớ: <?php echo escape($product['bo_nho_trong'] ?? 'N/A'); ?>
                                </small>
                            </p>
                            <h5 class="card-text text-primary"><?php echo formatPrice($product['price']); ?> VNĐ</h5>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-grid gap-2">
                                <a href="<?php echo getBaseUrl(); ?>/?page=product&id=<?php echo $product['id']; ?>" class="btn btn-outline-primary">Chi tiết</a>
                                <form method="POST" action="<?php echo getBaseUrl(); ?>/?page=cart&action=add">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary">Thêm giỏ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">Không có sản phẩm nào</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include APP_PATH . '/views/layouts/footer.php';
?>
