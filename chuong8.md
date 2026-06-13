# **Chương 8 – Phát triển ứng dụng Android**

## I. Giới thiệu về ứng dụng Android

Để mở rộng khả năng tiếp cận người dùng và nâng cao trải nghiệm sử dụng, dự án đã được phát triển thêm phiên bản ứng dụng Android. Ứng dụng Android này cho phép người dùng truy cập vào hệ thống bán điện thoại thông qua thiết bị di động một cách thuận tiện và nhanh chóng.

## II. Công nghệ sử dụng

### 1. Android Studio

Android Studio là IDE chính thức được Google cung cấp để phát triển ứng dụng Android:

- **Gradle Build System:** Quản lý dependencies và build process
- **Layout Editor:** Công cụ thiết kế giao diện trực quan
- **AVD Manager:** Quản lý thiết bị ảo để test ứng dụng
- **Code Completion & Debugging:** Hỗ trợ viết code và debug hiệu quả
- **Integration with Firebase:** Dễ dàng tích hợp các dịch vụ của Google

### 2. WebView Component

Ứng dụng sử dụng WebView để hiển thị website PHP hiện có:

- **WebView:** Component cho phép hiển thị nội dung web trong ứng dụng Android
- **WebSettings:** Cấu hình các tính năng như JavaScript, DOM Storage
- **WebViewClient:** Xử lý các sự kiện navigation
- **WebChromeClient:** Xử lý các tính năng nâng cao như alerts, progress bars

### 3. Java Programming Language

Ứng dụng được phát triển bằng ngôn ngữ Java:

- **Object-Oriented:** Tận dụng các tính năng OOP của Java
- **Android SDK:** Sử dụng các thư viện Android chuẩn
- **Compatibility:** Tương thích với nhiều phiên bản Android

## III. Kiến trúc ứng dụng

### 1. Cấu trúc dự án Android

```
android_app/
├── app/
│   ├── src/
│   │   └── main/
│   │       ├── java/
│   │       │   └── com/
│   │       │       └── example/
│   │       │           └── laptopstore/
│   │       │               └── MainActivity.java
│   │       ├── res/
│   │       │   ├── layout/
│   │       │   │   └── activity_main.xml
│   │       │   ├── values/
│   │       │   │   ├── colors.xml
│   │       │   │   ├── strings.xml
│   │       │   │   └── styles.xml
│   │       │   └── mipmap/
│   │       └── AndroidManifest.xml
│   └── build.gradle
├── build.gradle
├── settings.gradle
└── gradle.properties
```

### 2. MainActivity.java

MainActivity là activity chính của ứng dụng, chịu trách nhiệm:

- **Khởi tạo WebView:** Tạo và cấu hình WebView component
- **Cấu hình WebSettings:** Bật JavaScript, DOM Storage
- **Load URL:** Load website PHP từ server
- **Xử lý Back Button:** Cho phép quay lại trang trước trong WebView

### 3. activity_main.xml

Layout file định nghĩa giao diện ứng dụng:

- **WebView Component:** Chiếm toàn bộ màn hình
- **Constraints:** Đảm bảo hiển thị đúng trên các kích thước màn hình khác nhau
- **Responsive:** Tự động thích ứng với orientation changes

## IV. Tích hợp với website PHP

### 1. Kết nối với server

Ứng dụng Android kết nối với website PHP thông qua WebView:

```java
webView.loadUrl("http://10.118.246.227:3000");
```

URL có thể được cấu hình để:
- Sử dụng IP local network cho development
- Sử dụng domain name cho production
- Hỗ trợ cả HTTP và HTTPS

### 2. Cấu hình WebView

WebView được cấu hình để đảm bảo trải nghiệm tốt nhất:

```java
WebSettings webSettings = webView.getSettings();
webSettings.setJavaScriptEnabled(true);
webSettings.setDomStorageEnabled(true);
webSettings.setLoadWithOverviewMode(true);
webSettings.setUseWideViewPort(true);
```

Các cấu hình này cho phép:
- Chạy JavaScript trên website
- Lưu trữ dữ liệu local (cookies, localStorage)
- Hiển thị website đúng tỷ lệ
- Responsive design hoạt động tốt

### 3. Xử lý navigation

WebViewClient đảm bảo các link mở ngay trong app:

```java
webView.setWebViewClient(new WebViewClient());
```

WebChromeClient xử lý các tính năng nâng cao:

```java
webView.setWebChromeClient(new WebChromeClient());
```

### 4. Xử lý Back Button

Nút Back trên điện thoại được xử lý để:

- Quay lại trang trước trong WebView nếu có
- Thoát ứng dụng nếu không còn trang nào để quay lại

```java
@Override
public void onBackPressed() {
    if (webView.canGoBack()) {
        webView.goBack();
    } else {
        super.onBackPressed();
    }
}
```

## V. Cấu hình ứng dụng

### 1. AndroidManifest.xml

File manifest định nghĩa các cấu hình chính:

- **Package Name:** com.example.laptopstore
- **Permissions:** INTERNET permission để truy cập network
- **MainActivity:** Activity chính của ứng dụng
- **Orientation:** Portrait hoặc Landscape

### 2. build.gradle

Gradle file quản lý dependencies:

```gradle
dependencies {
    implementation 'androidx.appcompat:appcompat:1.6.1'
    implementation 'com.google.android.material:material:1.9.0'
    implementation 'androidx.constraintlayout:constraintlayout:2.1.4'
}
```

### 3. Cấu hình mạng

Ứng dụng cần INTERNET permission:

```xml
<uses-permission android:name="android.permission.INTERNET" />
```

## VI. Quy trình phát triển

### 1. Tạo dự án Android

1. Mở Android Studio
2. Tạo new project với Empty Activity
3. Đặt tên package: com.example.laptopstore
4. Chọn ngôn ngữ: Java
5. Minimum SDK: API 21 (Android 5.0)

### 2. Thêm WebView vào layout

1. Mở activity_main.xml
2. Thêm WebView component
3. Cấu hình constraints
4. Set ID cho WebView

### 3. Cấu hình MainActivity

1. Khởi tạo WebView trong onCreate()
2. Cấu hình WebSettings
3. Set WebViewClient và WebChromeClient
4. Load URL của website PHP

### 4. Thêm permissions

1. Mở AndroidManifest.xml
2. Thêm INTERNET permission
3. Test kết nối network

### 5. Build và chạy

1. Connect device hoặc start AVD
2. Build APK
3. Install và test ứng dụng
4. Debug và fix issues

## VII. Testing và Debugging

### 1. Testing trên thiết bị thật

- Kết nối điện thoại qua USB
- Bật USB Debugging
- Chạy ứng dụng trực tiếp trên device
- Test các tính năng chính

### 2. Testing trên AVD

- Tạo AVD với các API levels khác nhau
- Test trên nhiều kích thước màn hình
- Test trên các phiên bản Android khác nhau
- Kiểm tra responsive design

### 3. Debugging

- Sử dụng Android Studio Debugger
- Logcat để xem logs
- Breakpoints để debug code
- Network Inspector để kiểm tra network requests

## VIII. Triển khai và phân phối

### 1. Build APK Release

1. Chọn Build > Generate Signed Bundle/APK
2. Tạo keystore để sign ứng dụng
3. Build release APK
4. Test APK trước khi publish

### 2. Publish lên Google Play

1. Tạo tài khoản Google Play Developer
2. Tạo app listing
3. Upload APK
4. Cấu hình store listing
5. Submit để review

### 3. Cập nhật ứng dụng

- Tăng version code và version name
- Build APK mới
- Upload lên Google Play
- Rollout updates

## IX. Lợi ích của ứng dụng Android

### 1. Trải nghiệm người dùng tốt hơn

- Truy cập nhanh hơn qua icon trên home screen
- Không cần mở browser mỗi lần
- Tích hợp sâu với hệ điều hành Android

### 2. Tăng khả năng tiếp cận

- Có mặt trên Google Play Store
- Dễ dàng tìm kiếm và cài đặt
- Tăng uy tín thương hiệu

### 3. Tính năng mở rộng

- Push notifications
- Offline mode (với PWA)
- Camera integration
- GPS location services

### 4. Tùy chỉnh giao diện

- Custom splash screen
- App icon riêng
- Theme colors
- Navigation drawer

## X. Hướng phát triển tương lai

### 1. Native Android Development

Chuyển từ WebView sang native Android development:

- Sử dụng Retrofit để gọi API
- RecyclerView để hiển thị danh sách sản phẩm
- Navigation Component để điều hướng
- ViewModel và LiveData để quản lý state

### 2. Thêm tính năng native

- Push notifications với Firebase Cloud Messaging
- Camera để chụp hình sản phẩm
- GPS để định vị cửa hàng
- Biometric authentication

### 3. Offline support

- Sử dụng Room database để lưu data local
- Sync data khi có kết nối mạng
- Cache images với Glide hoặc Picasso

### 4. Cross-platform development

Xem xét các framework cross-platform:

- Flutter
- React Native
- Xamarin

Để phát triển cho cả iOS và Android từ một codebase.