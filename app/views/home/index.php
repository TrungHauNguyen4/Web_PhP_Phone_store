<?php
/**
 * View Home - Trang chủ
 * 
 * File này hiển thị trang chủ với:
 * - Carousel hiển thị sản phẩm nổi bật
 * - Danh sách sản phẩm nổi bật (6 sản phẩm)
 * - Các tính năng của cửa hàng
 * - CTA (Call to Action) để đăng ký
 * 
 * Dữ liệu được truyền từ ProductController:
 * - $carouselProducts: Mảng sản phẩm cho carousel (3 sản phẩm)
 * - $featuredProducts: Mảng sản phẩm nổi bật (6 sản phẩm)
 */

// Include header chung
include APP_PATH . '/views/layouts/header.php';
?>

<!-- Bootstrap Carousel with Product Images -->
<div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-indicators">
        <?php for ($i = 0; $i < 3; $i++): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $i; ?>" 
                    class="<?php echo $i === 0 ? 'active' : ''; ?>" 
                    aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>" 
                    aria-label="Slide <?php echo $i + 1; ?>"></button>
        <?php endfor; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($carouselProducts as $index => $product): ?>
            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?php echo getBaseUrl(); ?>/assets/images/<?php echo escape($product['image']); ?>"
                         class="d-block w-100"
                         alt="<?php echo escape($product['name']); ?>"
                         style="height: 400px; object-fit: contain; background-color: #f8f9fa;">
                <?php else: ?>
                    <div class="d-block w-100 bg-primary text-white text-center d-flex align-items-center justify-content-center"
                         style="height: 400px;">
                        <div>
                            <h1 class="display-4 fw-bold">Phone Store</h1>
                            <p class="lead">Khám phá bộ sưu tập điện thoại chất lượng cao</p>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="carousel-caption">
                    <?php if ($product['id'] > 0): ?>
                        <h1 class="display-4 fw-bold"><?php echo escape($product['name']); ?></h1>
                        <p class="lead">
                            Hãng: <?php echo escape($product['brand'] ?? 'N/A'); ?>
                        </p>
                        <p class="lead text-warning fs-3"><?php echo formatPrice($product['price']); ?> VNĐ</p>
                        <a href="<?php echo getBaseUrl(); ?>/?page=product&id=<?php echo $product['id']; ?>" class="btn btn-light btn-lg mt-3">Xem chi tiết</a>
                    <?php else: ?>
                        <h1 class="display-4 fw-bold">Phone Store</h1>
                        <p class="lead">Khám phá bộ sưu tập điện thoại chất lượng cao với giá cực tốt</p>
                        <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-light btn-lg mt-3">Khám phá ngay →</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Featured Products -->
<section class="mb-5">
    <div class="container">
        <h2 class="mb-4 text-center">Sản phẩm nổi bật</h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (!empty($featuredProducts)): ?>
                <?php foreach ($featuredProducts as $product): ?>
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
                    <p class="text-center">Chưa có sản phẩm nào</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-outline-primary btn-lg">Xem tất cả sản phẩm</a>
        </div>
    </div>
</section>

<!-- Features -->
<section class="mb-5 bg-light py-5">
    <div class="container">
        <h2 class="mb-4 text-center">Tại sao chọn chúng tôi?</h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">💎</div>
                        <h5 class="card-title">Chất lượng đảm bảo</h5>
                        <p class="card-text">Tất cả sản phẩm đều được kiểm tra chất lượng kỹ lưỡng trước khi giao đến khách hàng.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🚀</div>
                        <h5 class="card-title">Giao hàng nhanh</h5>
                        <p class="card-text">Giao hàng miễn phí trong 24h cho đơn hàng từ 10 triệu đồng.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
                        <h5 class="card-title">Bảo hành uy tín</h5>
                        <p class="card-text">Bảo hành 12-24 tháng chính hãng, hỗ trợ kỹ thuật trọn đời.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">💬</div>
                        <h5 class="card-title">Hỗ trợ 24/7</h5>
                        <p class="card-text">Đội ngũ hỗ trợ chuyên nghiệp luôn sẵn sàng giải đáp mọi thắc mắc.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="mb-5">
    <div class="bg-primary text-white text-center py-5">
        <div class="container">
            <h2 class="display-5 fw-bold">Sẵn sàng nâng cấp trải nghiệm?</h2>
            <p class="lead mb-4">Đăng ký ngay để nhận ưu đãi đặc biệt và thông tin về sản phẩm mới nhất.</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="<?php echo getBaseUrl(); ?>/?page=auth&action=register" class="btn btn-light btn-lg">Đăng ký ngay</a>
                <a href="<?php echo getBaseUrl(); ?>/?page=products" class="btn btn-outline-light btn-lg">Xem sản phẩm</a>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include APP_PATH . '/views/layouts/footer.php';
?>
