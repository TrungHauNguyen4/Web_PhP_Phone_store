-- ===================================================
-- Migration: 002_AddShippingInfoToOrders
-- Created: 2024-06-08
-- Description: Add shipping information fields to orders table
-- Database: laptop_store (MySQL)
-- ===================================================
-- This migration adds columns to store shipping information separately from user profile
-- This fixes the issue where admin orders show admin's info instead of actual shipping info
-- ===================================================

USE laptop_store;

ALTER TABLE orders
ADD COLUMN shipping_fullname VARCHAR(100) COMMENT 'Họ tên người nhận' AFTER payment_method,
ADD COLUMN shipping_phone VARCHAR(20) COMMENT 'Số điện thoại người nhận' AFTER shipping_fullname,
ADD COLUMN shipping_email VARCHAR(100) COMMENT 'Email người nhận' AFTER shipping_phone,
ADD COLUMN shipping_address VARCHAR(255) COMMENT 'Địa chỉ giao hàng' AFTER shipping_email;

-- ===================================================
-- Migration Complete
-- ===================================================
SELECT 'Migration 002_AddShippingInfoToOrders completed successfully!' AS Status;
