# Database Migrations

This folder contains SQL migration files for the Laptop Store project database.

## How to Run Migrations

### Option 1: Run via PHP Script
```bash
php run_migration.php
```

### Option 2: Run via MySQL Command Line
```bash
mysql -u root laptop_store < database/migrations/001_CreateInitialTables.sql
mysql -u root laptop_store < database/migrations/002_AddShippingInfoToOrders.sql
```

### Option 3: Import via phpMyAdmin
1. Open phpMyAdmin
2. Select the `laptop_store` database
3. Click "Import" tab
4. Upload migration files in numerical order

## Migration Files

### 001_CreateInitialTables.sql
- **Created:** 2024-01-01
- **Description:** Creates the initial database schema including:
  - `users` table - User accounts and authentication
  - `products` table - Phone product information
  - `orders` table - Order information
  - `order_details` table - Individual items in orders
- **Sample Data:** Includes 2 test users (admin/admin123, user/user123) and 10 sample products

### 002_AddShippingInfoToOrders.sql
- **Created:** 2024-06-08
- **Description:** Adds shipping information fields to the `orders` table:
  - `shipping_fullname` - Recipient's full name
  - `shipping_phone` - Recipient's phone number
  - `shipping_email` - Recipient's email
  - `shipping_address` - Delivery address
- **Purpose:** Fixes issue where admin orders showed admin's profile info instead of actual shipping details

## Database Schema

The current database structure consists of:

- **users:** id, username, email, password, fullname, phone, address, role, created_at, updated_at
- **products:** id, name, brand, cpu, bo_nho_trong, pin, price, image, description, quantity, created_at, updated_at
- **orders:** id, user_id, total_amount, payment_method, status, shipping_fullname, shipping_phone, shipping_email, shipping_address, created_at, updated_at
- **order_details:** id, order_id, product_id, quantity, price, created_at

## Important Notes

- Migrations must be run in numerical order (001, 002, etc.)
- The database name is `laptop_store`
- Default MySQL connection: localhost (XAMPP)
- All tables use InnoDB engine with UTF-8MB4 character set
- Foreign key constraints are enabled with CASCADE delete for related data

## Rollback

To rollback a migration, you would need to manually reverse the SQL statements. Currently, there is no automated rollback mechanism.
