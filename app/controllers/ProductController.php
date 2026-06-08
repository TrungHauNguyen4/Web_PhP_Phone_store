<?php
/**
 * ProductController - Controller xử lý sản phẩm
 *
 * Controller này chịu trách nhiệm xử lý tất cả các chức năng liên quan đến
 * sản phẩm trong hệ thống, bao gồm:
 * - Trang chủ: Hiển thị carousel và sản phẩm nổi bật
 * - Danh sách sản phẩm: Hiển thị danh sách với tìm kiếm và lọc theo hãng
 * - Chi tiết sản phẩm: Hiển thị thông tin chi tiết của một sản phẩm
 *
 * Các phương thức chính:
 * - home(): Hiển thị trang chủ với carousel và sản phẩm nổi bật
 * - index(): Hiển thị danh sách sản phẩm với tìm kiếm và lọc
 * - detail(): Hiển thị chi tiết một sản phẩm cụ thể
 *
 * @package App\Controllers
 */

require_once APP_PATH . '/controllers/Controller.php';
require_once APP_PATH . '/models/Product.php';

class ProductController extends Controller {
    
    /**
     * Hiển thị trang danh sách sản phẩm với tìm kiếm và lọc
     *
     * Phương thức này thực hiện các chức năng:
     * 1. Lấy tham số tìm kiếm và lọc từ request (search, brand)
     * 2. Nếu có từ khóa tìm kiếm: Tìm sản phẩm theo từ khóa
     * 3. Nếu không có từ khóa: Lọc sản phẩm theo hãng
     * 4. Lấy danh sách tất cả các hãng để hiển thị dropdown
     * 5. Sắp xếp sản phẩm theo giá thấp đến cao, sau đó theo tên
     * 6. Truyền dữ liệu cho view để hiển thị
     *
     * @return void
     */
    public function index() {
        // Tạo instance của Product model để truy vấn database
        $productModel = new Product();

        // Lấy tham số tìm kiếm và lọc từ request
        $search = $this->input('search', '');          // Từ khóa tìm kiếm
        $brand = $this->input('brand', '');            // Hãng sản xuất

        // Lấy danh sách tất cả các hãng
        $brands = $productModel->getAllBrands();

        // Xử lý tìm kiếm hoặc lọc
        if (!empty($search)) {
            // Có từ khóa tìm kiếm - Tìm sản phẩm theo từ khóa
            $products = $productModel->search($search);
        } elseif (!empty($brand)) {
            // Không có từ khóa nhưng có hãng - Lọc theo hãng
            $products = $productModel->getByBrand($brand);
        } else {
            // Không có lọc - Lấy tất cả sản phẩm
            $products = $productModel->getAll();
        }

        // Sắp xếp sản phẩm: giá thấp trước, sau đó theo tên
        // Điều này giúp người dùng dễ dàng tìm sản phẩm phù hợp
        if (!empty($products)) {
            usort($products, function($a, $b) {
                // So sánh giá trước
                if ($a['price'] != $b['price']) {
                    return $a['price'] - $b['price'];
                }
                // Nếu giá bằng nhau, so sánh tên
                return strcmp($a['name'], $b['name']);
            });
        }

        // Truyền dữ liệu cho view để hiển thị
        $this->view('products/list.php', [
            'products' => $products,      // Danh sách sản phẩm đã lọc và sắp xếp
            'search' => $search,          // Từ khóa tìm kiếm (để điền lại vào form)
            'brand' => $brand,            // Hãng đã chọn (để điền lại vào form)
            'brands' => $brands           // Danh sách tất cả các hãng
        ]);
    }
    
    /**
     * Hiển thị trang chủ với carousel và sản phẩm nổi bật
     * 
     * Phương thức này thực hiện các chức năng:
     * 1. Lấy tất cả sản phẩm từ database
     * 2. Chọn 6 sản phẩm đầu tiên làm sản phẩm nổi bật
     * 3. Chọn 3 sản phẩm đầu tiên có ảnh cho carousel
     * 4. Nếu không đủ 3 sản phẩm có ảnh, thêm placeholder
     * 5. Truyền dữ liệu cho view để hiển thị
     * 
     * @return void
     */
    public function home() {
        // Tạo instance của Product model
        $productModel = new Product();
        
        // Lấy tất cả sản phẩm từ database
        $allProducts = $productModel->getAll();
        
        // Lấy 6 sản phẩm đầu tiên làm sản phẩm nổi bật
        // array_slice cắt mảng từ vị trí 0, lấy 6 phần tử
        $featuredProducts = array_slice($allProducts, 0, 6);
        
        // Lấy sản phẩm cho carousel (3 sản phẩm đầu tiên có ảnh)
        $carouselProducts = [];
        foreach ($allProducts as $product) {
            // Chỉ lấy sản phẩm có ảnh
            if (!empty($product['image'])) {
                $carouselProducts[] = $product;
                // Dừng khi đã đủ 3 sản phẩm
                if (count($carouselProducts) >= 3) {
                    break;
                }
            }
        }
        
        // Nếu không đủ 3 sản phẩm có ảnh, thêm placeholder
        // Điều này đảm bảo carousel luôn có 3 slide
        if (count($carouselProducts) < 3) {
            for ($i = count($carouselProducts); $i < 3; $i++) {
                $carouselProducts[] = [
                    'id' => 0,
                    'name' => 'Phone Store',
                    'image' => '',
                    'price' => 0,
                    'brand' => ''
                ];
            }
        }
        
        // Truyền dữ liệu cho view
        $this->view('home/index.php', [
            'carouselProducts' => $carouselProducts,    // 3 sản phẩm cho carousel
            'featuredProducts' => $featuredProducts     // 6 sản phẩm nổi bật
        ]);
    }
    
    /**
     * Hiển thị trang chi tiết sản phẩm
     * 
     * Phương thức này thực hiện các chức năng:
     * 1. Lấy ID sản phẩm từ tham số request
     * 2. Validate ID sản phẩm (phải > 0)
     * 3. Tìm sản phẩm trong database theo ID
     * 4. Nếu không tìm thấy, hiển thị thông báo lỗi
     * 5. Nếu tìm thấy, truyền dữ liệu cho view để hiển thị
     * 
     * @return void
     */
    public function detail() {
        // Lấy ID sản phẩm từ tham số request và ép kiểu sang int
        $product_id = (int)$this->input('id', 0);
        
        // Validate product ID - phải lớn hơn 0
        if ($product_id <= 0) {
            // ID không hợp lệ - Hiển thị thông báo lỗi
            echo '<div class="container"><div class="alert alert-danger">
                <h3>Sản phẩm không tồn tại</h3>
                <a href="' . APP_URL . '/?page=products" class="btn btn-primary">Quay lại danh sách</a>
            </div></div>';
            return;
        }
        
        // Tạo instance của Product model
        $productModel = new Product();
        
        // Tìm sản phẩm trong database theo ID
        $product = $productModel->getById($product_id);
        
        // Kiểm tra xem sản phẩm có tồn tại không
        if (!$product) {
            // Không tìm thấy sản phẩm - Hiển thị thông báo lỗi
            echo '<div class="container"><div class="alert alert-danger">
                <h3>Sản phẩm không tồn tại</h3>
                <a href="' . APP_URL . '/?page=products" class="btn btn-primary">Quay lại danh sách</a>
            </div></div>';
            return;
        }
        
        // Tìm thấy sản phẩm - Truyền dữ liệu cho view để hiển thị
        $this->view('products/detail.php', ['product' => $product]);
    }
}
