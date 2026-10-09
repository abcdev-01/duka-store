-- =====================================================
-- Duka-Store — Database Schema
-- =====================================================

DROP DATABASE IF EXISTS duka_store;

CREATE DATABASE duka_store DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE duka_store;

-- -----------------------------------------------------
-- admin
-- -----------------------------------------------------
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- -----------------------------------------------------
-- customers
-- -----------------------------------------------------
CREATE TABLE customers (
    customer_code VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- -----------------------------------------------------
-- products
-- price and size are comma-separated lists, matched by index.
-- Example: price = '20000,30000', size = 'm,l'
-- -----------------------------------------------------
CREATE TABLE products (
    product_code VARCHAR(20) PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price VARCHAR(255) NOT NULL,
    size VARCHAR(255) NOT NULL,
    weight INT NOT NULL,
    description TEXT,
    image VARCHAR(255)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- -----------------------------------------------------
-- cart
-- -----------------------------------------------------
CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_code VARCHAR(10) NOT NULL,
    product_code VARCHAR(20) NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    qty INT NOT NULL,
    price INT NOT NULL,
    weight INT NOT NULL,
    size VARCHAR(20) NOT NULL,
    INDEX idx_customer (customer_code),
    INDEX idx_product (product_code)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- -----------------------------------------------------
-- orders
-- One row per order (order_id is unique).
-- -----------------------------------------------------
CREATE TABLE orders (
    order_id VARCHAR(30) PRIMARY KEY,
    customer_code VARCHAR(10) NOT NULL,
    date DATETIME NOT NULL,
    total INT NOT NULL,
    weight INT NOT NULL,
    courier VARCHAR(20) NOT NULL,
    service VARCHAR(30) NOT NULL,
    shipping_cost INT NOT NULL,
    etd VARCHAR(10) NOT NULL,
    address TEXT NOT NULL,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'New Order',
    accepted TINYINT(1) NOT NULL DEFAULT 0,
    rejected TINYINT(1) NOT NULL DEFAULT 0,
    payment_proof VARCHAR(255) DEFAULT NULL,
    payment_date DATETIME DEFAULT NULL,
    payment_amount INT DEFAULT 0,
    payment_bank VARCHAR(50) DEFAULT NULL,
    payment_account_name VARCHAR(100) DEFAULT NULL,
    INDEX idx_customer (customer_code),
    INDEX idx_date (date)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- -----------------------------------------------------
-- order_details
-- One row per product inside an order.
-- -----------------------------------------------------
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(30) NOT NULL,
    product_code VARCHAR(20) NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    qty INT NOT NULL,
    price INT NOT NULL,
    size VARCHAR(20) NOT NULL,
    INDEX idx_order (order_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- -----------------------------------------------------
-- inventory (raw materials)
-- -----------------------------------------------------
CREATE TABLE inventory (
    material_code VARCHAR(100) PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    qty VARCHAR(200) NOT NULL,
    unit VARCHAR(200) NOT NULL,
    price INT NOT NULL,
    date DATE NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- -----------------------------------------------------
-- product_bom (bill of materials)
-- -----------------------------------------------------
CREATE TABLE product_bom (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bom_code VARCHAR(100) NOT NULL,
    material_code VARCHAR(100) NOT NULL,
    product_code VARCHAR(100) NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    requirement VARCHAR(200) NOT NULL,
    INDEX idx_product (product_code)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- -----------------------------------------------------
-- payments (separate payment log, optional)
-- -----------------------------------------------------
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(30) NOT NULL,
    bank VARCHAR(50) NOT NULL,
    account_name VARCHAR(100) NOT NULL,
    amount INT NOT NULL,
    proof VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    INDEX idx_order (order_id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;