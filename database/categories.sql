--Mở database hpc_phone và dán đoạn code sau vào SQL để tạo bảng categories và thêm dữ liệu mẫu

USE hpc_phone;

-- 1. Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(190) NOT NULL,
    slug VARCHAR(190) NOT NULL UNIQUE,
    description TEXT NULL,
    image VARCHAR(500) NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_categories_status (status)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- 2. Insert default categories
INSERT INTO categories (name, slug, description, image, status)
VALUES
(
    'Apple',
    'apple',
    'Các sản phẩm điện thoại Apple như iPhone.',
    'https://cdn.simpleicons.org/apple/000000',
    1
),
(
    'Samsung',
    'samsung',
    'Các sản phẩm điện thoại Samsung Galaxy.',
    'https://cdn.simpleicons.org/samsung/1428A0',
    1
),
(
    'Xiaomi',
    'xiaomi',
    'Các sản phẩm điện thoại Xiaomi.',
    'https://cdn.simpleicons.org/xiaomi/FF6900',
    1
),
(
    'OPPO',
    'oppo',
    'Các sản phẩm điện thoại OPPO.',
    'https://cdn.simpleicons.org/oppo/00A862',
    1
)
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    description = VALUES(description),
    image = VALUES(image),
    status = VALUES(status);


-- 3. Add category_id to products
ALTER TABLE products
ADD COLUMN category_id INT NULL AFTER description;


-- 4. Add foreign key
ALTER TABLE products
ADD CONSTRAINT fk_products_category
FOREIGN KEY (category_id)
REFERENCES categories(id);


-- 5. Assign categories to existing products

UPDATE products p
JOIN categories c ON c.slug = 'apple'
SET p.category_id = c.id
WHERE p.name LIKE '%iPhone%';

UPDATE products p
JOIN categories c ON c.slug = 'samsung'
SET p.category_id = c.id
WHERE p.name LIKE '%Samsung%';

UPDATE products p
JOIN categories c ON c.slug = 'xiaomi'
SET p.category_id = c.id
WHERE p.name LIKE '%Xiaomi%';

UPDATE products p
JOIN categories c ON c.slug = 'oppo'
SET p.category_id = c.id
WHERE p.name LIKE '%OPPO%';


-- 6. Verify migration results
SELECT
    p.id,
    p.name AS product_name,
    c.name AS category_name
FROM products p
LEFT JOIN categories c
    ON p.category_id = c.id;

