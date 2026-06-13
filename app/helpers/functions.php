<?php
/**
 * Các hàm helper chung
 * 
 * File này chứa các hàm tiện ích được sử dụng trong toàn bộ ứng dụng:
 * - Redirect và URL handling
 * - Xử lý session và authentication
 * - Format dữ liệu (giá, ngày tháng, text)
 * - Xử lý file
 * - Pagination
 * - Debugging và logging
 */

/**
 * Redirect đến URL chỉ định
 * 
 * @param string $url URL để redirect
 * @return void
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Lấy thông tin user hiện tại từ session
 * 
 * @return array|null Thông tin user hoặc null nếu chưa đăng nhập
 */
function getCurrentUser() {
    if (!isLoggedIn()) return null;
    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role' => $_SESSION['role']
    ];
}

/**
 * Kiểm tra xem user đã đăng nhập chưa
 * 
 * @return bool True nếu đã đăng nhập, false nếu chưa
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Kiểm tra xem user có phải là admin không
 * 
 * @return bool True nếu là admin, false nếu không
 */
function isAdmin() {
    return isLoggedIn() && ($_SESSION['role'] ?? '') === 'admin';
}

/**
 * Lưu thông báo vào session
 * 
 * @param string $message Nội dung thông báo
 * @param string $type Loại thông báo (info, success, error, warning)
 * @return void
 */
function setMessage($message, $type = 'info') {
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Lấy và xóa thông báo từ session
 * 
 * @return array|null Mảng chứa message và type nếu có, null nếu không
 */
function getMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

/**
 * Format giá tiền theo định dạng Việt Nam
 * 
 * @param float $price Giá cần format
 * @return string Giá đã format (ví dụ: 1.000.000)
 */
function formatPrice($price) {
    return number_format($price, 0, ',', '.');
}

/**
 * Lấy phần mở rộng của file
 * 
 * @param string $filename Tên file
 * @return string Phần mở rộng (viết thường)
 */
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

/**
 * Tạo tên file duy nhất
 * 
 * @param string $originalName Tên file gốc
 * @return string Tên file duy nhất (ví dụ: image_1234567890_1234.jpg)
 */
function generateUniqueFilename($originalName) {
    $ext = getFileExtension($originalName);
    $name = pathinfo($originalName, PATHINFO_FILENAME);
    return $name . '_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
}

/**
 * Cắt ngắn văn bản
 * 
 * @param string $text Văn bản cần cắt
 * @param int $length Độ dài tối đa
 * @param string $suffix Hậu缀 khi cắt
 * @return string Văn bản đã cắt
 */
function truncateText($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $suffix;
}

/**
 * Lấy giá trị từ mảng một cách an toàn
 * 
 * @param array $array Mảng cần lấy giá trị
 * @param string $key Key cần lấy
 * @param mixed $default Giá trị mặc định nếu key không tồn tại
 * @return mixed Giá trị hoặc giá trị mặc định
 */
function getArrayValue($array, $key, $default = null) {
    return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Chuyển underscore thành space và viết hoa chữ cái đầu
 * 
 * @param string $text Văn bản cần chuyển đổi
 * @return string Văn bản đã chuyển đổi (ví dụ: "hello_world" -> "Hello world")
 */
function humanize($text) {
    return ucfirst(str_replace('_', ' ', $text));
}

/**
 * Lấy số trang hiện tại
 * 
 * @return int Số trang hiện tại (tối thiểu là 1)
 */
function getCurrentPage() {
    $page = $_GET['page'] ?? 1;
    return max(1, intval($page));
}

/**
 * Tính toán offset cho pagination
 * 
 * @param int $page Số trang hiện tại
 * @param int $itemsPerPage Số item mỗi trang
 * @return int Offset cho SQL LIMIT
 */
function getPaginationOffset($page, $itemsPerPage = ITEMS_PER_PAGE) {
    return ($page - 1) * $itemsPerPage;
}

/**
 * Xây dựng query string từ mảng
 * 
 * @param array $params Mảng tham số
 * @return string Query string
 */
function buildQueryString($params) {
    return http_build_query($params);
}

/**
 * Format ngày tháng
 * 
 * @param string $date Ngày cần format
 * @param string $format Định dạng mong muốn
 * @return string Ngày đã format
 */
function formatDate($date, $format = 'd/m/Y H:i') {
    return date($format, strtotime($date));
}

/**
 * Kiểm tra key trong mảng có tồn tại và không rỗng
 * 
 * @param array $array Mảng cần kiểm tra
 * @param string $key Key cần kiểm tra
 * @return bool True nếu tồn tại và không rỗng
 */
function checkArrayKey($array, $key) {
    return isset($array[$key]) && !empty($array[$key]);
}

/**
 * Lấy base URL của ứng dụng
 * 
 * @return string Base URL
 */
function getBaseUrl() {
    return APP_URL;
}

/**
 * Lấy URL của asset
 * 
 * @param string $path Đường dẫn tương đối đến asset
 * @return string URL đầy đủ của asset
 */
function getAssetUrl($path) {
    return getBaseUrl() . '/assets/' . $path;
}

/**
 * Var dump và die (dùng để debug)
 * 
 * @param mixed $data Dữ liệu cần debug
 * @return void
 */
function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die;
}

/**
 * Ghi log message vào file
 * 
 * @param string $message Nội dung log
 * @param string $level Mức độ log (info, warning, error)
 * @return void
 */
function log_message($message, $level = 'info') {
    $log_file = ROOT_PATH . '/storage/logs/' . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $message" . PHP_EOL;
    
    error_log($log_entry, 3, $log_file);
}
?>
