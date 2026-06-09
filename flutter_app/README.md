# Phone Store - Flutter Mobile App

A Flutter mobile application for the Phone Store e-commerce platform, built with the PHP REST API backend.

## Features

- User Authentication (Login/Register)
- Product Catalog with Search and Filter
- Shopping Cart
- Checkout and Order Management
- User Profile Management

## Getting Started

### Prerequisites

- Flutter SDK (3.0.0+)
- Dart SDK
- Android Studio / VS Code
- A device or emulator

### Setup

1. Make sure the PHP backend is running on `http://localhost:3000`

2. Navigate to the project directory:
   ```bash
   cd flutter_app
   ```

3. Install dependencies:
   ```bash
   flutter pub get
   ```

4. Run the app:
   ```bash
   flutter run
   ```

## Configuration

The API base URL is set in `lib/constants/app_constants.dart`. If you're running the backend on a different address, update this file.

For Android emulators, `10.0.2.2` is used to access the host machine's `localhost`.

## Test Accounts

### Admin
- Username: `admin`
- Password: `admin123`

### User
- Username: `user`
- Password: `user123`

## Project Structure

```
lib/
├── constants/          # App constants
├── models/             # Data models
├── providers/          # State management (Provider)
├── screens/            # UI screens
├── services/           # API services
└── main.dart           # App entry point
```
