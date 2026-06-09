# Hướng dẫn cài đặt và chạy dự án Phone Store

Dự án này bao gồm:
1. **Backend**: PHP MVC + MySQL
2. **Frontend Web**: PHP Views + Bootstrap 5
3. **Frontend Mobile**: Flutter App

---

## 📋 Yêu cầu hệ thống

### Backend
- PHP 8.0 trở lên
- MySQL 8.0 trở lên (hoặc XAMPP/WAMP)
- Web Server (Apache/Nginx hoặc dùng PHP Built-in Server)

### Flutter Mobile
- Flutter SDK 3.0 trở lên
- Android Studio (để cài Android SDK)
- Điện thoại Android (hoặc Emulator)
- Git

---

## 🚀 Cài đặt Backend

### 1. Clone dự án
```bash
git clone https://github.com/TrungHauNguyen4/mobile_phone_store.git
cd mobile_phone_store
```

### 2. Cấu hình database
1. Tạo database mới trong MySQL (ví dụ: `laptop_store`)
2. Sao chép file `.env.example` thành `.env` và cập nhật thông tin kết nối:
   ```
   DB_HOST=localhost
   DB_PORT=3306
   DB_NAME=laptop_store
   DB_USER=root
   DB_PASSWORD=
   ```
3. Import file migration từ `database/migrations/001_CreateInitialTables.sql` và `002_AddShippingInfoToOrders.sql`

### 3. Chạy backend
```bash
cd public
php -S localhost:3000
```
Hoặc dùng XAMPP:
- Di chuyển dự án vào thư mục `htdocs`
- Khởi động Apache và MySQL trong XAMPP
- Truy cập: `http://localhost/phone_store/public`

---

## 📱 Cài đặt và chạy Flutter Mobile App

### 1. Cài Flutter SDK
1. Tải Flutter SDK: https://docs.flutter.dev/get-started/install/windows/mobile
2. Giải nén vào thư mục (ví dụ: `D:\flutter`)
3. Thêm `D:\flutter\bin` vào PATH hệ thống

### 2. Cài Android Studio và Android SDK
1. Tải Android Studio: https://developer.android.com/studio
2. Cài đặt Android Studio (chọn Standard)
3. Mở Android Studio → More Actions → SDK Manager
4. Cài đặt:
   - Android SDK Platform (Android 13.0 trở lên)
   - Android SDK Build-Tools
   - Android SDK Platform-Tools
5. Chấp nhận bản quyền Android:
   ```bash
   flutter doctor --android-licenses
   ```
   (Gõ `y` và Enter cho tất cả các câu hỏi)

### 3. Cấu hình Flutter App
1. Mở file `flutter_app/lib/constants/app_constants.dart`
2. Thay `baseUrl` bằng địa chỉ IP máy của bạn (nếu chạy trên điện thoại thật):
   ```dart
   static const String baseUrl = 'http://192.168.x.x:3000/api';
   ```
   (Nếu dùng emulator Android, dùng `http://10.0.2.2:3000/api`)

### 4. Chạy Flutter App
1. Kết nối điện thoại (bật Gỡ lỗi USB) hoặc mở emulator
2. Kiểm tra thiết bị:
   ```bash
   cd flutter_app
   flutter devices
   ```
3. Cài dependencies và chạy:
   ```bash
   flutter pub get
   flutter run
   ```

---

## 🔑 Tài khoản dùng thử

- **Admin**: `admin` / `admin123`
- **User**: `user` / `user123`

---

## 📚 Tài liệu API

Xem chi tiết tại: [API.md](API.md)

---

## 💡 Lưu ý quan trọng

1. **Chạy backend trước khi chạy Flutter app**
2. **Điện thoại và máy tính phải cùng mạng** (nếu dùng điện thoại thật)
3. Nếu dùng emulator Android, thay IP thành `10.0.2.2`
4. Đảm bảo backend chạy trên `0.0.0.0:3000` (không phải `localhost:3000`) để các thiết bị khác truy cập được

---

## 🛠️ Khắc phục sự cố

### Lỗi "Unable to locate Android SDK"
- Cài đặt Android Studio và Android SDK theo các bước trên
- Chạy `flutter config --android-sdk <đường dẫn SDK>`

### Lỗi "No supported devices connected"
- Kiểm tra điện thoại đã bật Gỡ lỗi USB
- Kiểm tra dây cáp USB (không phải chỉ dùng cho sạc)
- Chạy `flutter devices` để kiểm tra

### App Flutter không kết nối được backend
- Kiểm tra IP máy tính trong `app_constants.dart`
- Đảm bảo backend chạy trên `0.0.0.0:3000`
- Kiểm tra tường lửa máy tính cho phép kết nối cổng 3000
