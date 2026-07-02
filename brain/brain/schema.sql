CREATE DATABASE ouvvee_toys;
USE ouvvee_toys;

CREATE TABLE users (
    id_user BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('buyer', 'admin') NOT NULL DEFAULT 'buyer',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE addresses (
    id_address BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_user BIGINT NOT NULL,
    recipient_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    detail_address TEXT NOT NULL,
    postal_code VARCHAR(10),
    is_default BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE categories (
    id_category BIGINT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE products (
    id_product BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_category BIGINT NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    stock INT NOT NULL DEFAULT 0,
    recommended_age VARCHAR(50),
    safety_note TEXT,
    size VARCHAR(50),
    weight_gram INT NOT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    FOREIGN KEY (id_category) REFERENCES categories(id_category) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE product_images (
    id_image BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_product BIGINT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    alt_text VARCHAR(150),
    is_primary BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_product) REFERENCES products(id_product) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE carts (
    id_cart BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_user BIGINT NOT NULL,
    status ENUM('active', 'checked_out') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE cart_items (
    id_cart_item BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_cart BIGINT NOT NULL,
    id_product BIGINT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (id_cart) REFERENCES carts(id_cart) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_product) REFERENCES products(id_product) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE payment_methods (
    id_payment_method BIGINT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE shipping_methods (
    id_shipping_method BIGINT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

CREATE TABLE shipping_rates (
    id_shipping_rate BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_shipping_method BIGINT NOT NULL,
    min_weight_gram INT NOT NULL,
    max_weight_gram INT NOT NULL,
    base_cost DECIMAL(12,2) NOT NULL,
    cost_per_kg DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_shipping_method) REFERENCES shipping_methods(id_shipping_method) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE orders (
    id_order BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_user BIGINT NOT NULL,
    id_address BIGINT NOT NULL,
    order_code VARCHAR(50) NOT NULL UNIQUE,
    order_date DATETIME NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    shipping_cost DECIMAL(12,2) NOT NULL,
    total_price DECIMAL(12,2) NOT NULL,
    order_status ENUM('waiting_payment', 'paid', 'processing', 'shipped', 'completed', 'cancelled') NOT NULL DEFAULT 'waiting_payment',
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_address) REFERENCES addresses(id_address) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE order_items (
    id_order_item BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_order BIGINT NOT NULL,
    id_product BIGINT NOT NULL,
    quantity INT NOT NULL,
    price_each DECIMAL(12,2) NOT NULL,
    total_price DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (id_order) REFERENCES orders(id_order) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_product) REFERENCES products(id_product) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE payments (
    id_payment BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_order BIGINT NOT NULL UNIQUE,
    id_payment_method BIGINT NOT NULL,
    payment_status ENUM('unpaid', 'paid', 'failed') NOT NULL DEFAULT 'unpaid',
    paid_at DATETIME NULL,
    FOREIGN KEY (id_order) REFERENCES orders(id_order) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_payment_method) REFERENCES payment_methods(id_payment_method) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE shipments (
    id_shipment BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_order BIGINT NOT NULL UNIQUE,
    id_shipping_method BIGINT NOT NULL,
    shipping_cost DECIMAL(12,2) NOT NULL,
    tracking_number VARCHAR(100),
    shipment_status ENUM('not_shipped', 'on_delivery', 'delivered') NOT NULL DEFAULT 'not_shipped',
    FOREIGN KEY (id_order) REFERENCES orders(id_order) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_shipping_method) REFERENCES shipping_methods(id_shipping_method) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE reviews (
    id_review BIGINT AUTO_INCREMENT PRIMARY KEY,
    id_user BIGINT NOT NULL,
    id_product BIGINT NOT NULL,
    id_order BIGINT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_product) REFERENCES products(id_product) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_order) REFERENCES orders(id_order) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE wishlists (
    id_user BIGINT NOT NULL,
    id_product BIGINT NOT NULL,
    created_at TIMESTAMP NULL,
    PRIMARY KEY (id_user, id_product),
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_product) REFERENCES products(id_product) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO payment_methods (method_name, description) VALUES
('Transfer Bank', 'Pembayaran simulasi melalui transfer bank'),
('Kartu Kredit', 'Pembayaran simulasi menggunakan kartu kredit'),
('COD', 'Pembayaran di tempat');

INSERT INTO shipping_methods (method_name, description) VALUES
('JNE', 'Pengiriman menggunakan JNE'),
('GOJEK', 'Pengiriman menggunakan GOJEK');

INSERT INTO shipping_rates (id_shipping_method, min_weight_gram, max_weight_gram, base_cost, cost_per_kg) VALUES
(1, 0, 1000, 10000, 5000),
(1, 1001, 3000, 15000, 7000),
(2, 0, 1000, 12000, 6000),
(2, 1001, 3000, 18000, 8000);
