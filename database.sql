CREATE DATABASE IF NOT EXISTS diwakarsewa;
USE diwakarsewa;

-- USERS TABLE
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(100),
email VARCHAR(100) UNIQUE,
phone VARCHAR(15),
password VARCHAR(255),
role ENUM('user', 'admin') DEFAULT 'user',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ADDRESSES TABLE (Separate from users)
CREATE TABLE addresses (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
street VARCHAR(150),
city VARCHAR(50),
province VARCHAR(50),
address_type ENUM('billing', 'shipping') DEFAULT 'shipping',
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- PRODUCTS TABLE (Smartphones)
CREATE TABLE products (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100),
brand VARCHAR(50),
price DECIMAL(10,2),
ram VARCHAR(50),
storage VARCHAR(50),
camera VARCHAR(100),
stock INT DEFAULT 0,
image VARCHAR(255),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CARTS TABLE (1 cart per user)
CREATE TABLE carts (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- CART ITEMS TABLE (1 cart has many items)
CREATE TABLE cart_items (
id INT AUTO_INCREMENT PRIMARY KEY,
cart_id INT,
product_id INT,
quantity INT DEFAULT 1,
FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ORDERS TABLE
CREATE TABLE orders (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT,
address_id INT, -- Links to addresses table
total_amount DECIMAL(10,2),
phone VARCHAR(15),
payment_method VARCHAR(50),
status ENUM('pending', 'delivered', 'cancelled') DEFAULT 'pending',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
FOREIGN KEY (address_id) REFERENCES addresses(id) ON DELETE SET NULL
);

-- ORDER ITEMS TABLE
CREATE TABLE order_items (
id INT AUTO_INCREMENT PRIMARY KEY,
order_id INT,
product_id INT,
quantity INT,
price DECIMAL(10,2),
FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- INSERT DEFAULT ADMIN USER
INSERT INTO users (full_name, email, phone, password, role)
VALUES ('Admin User', 'admin@example.com', '9999999999', MD5('admin123'), 'admin');
