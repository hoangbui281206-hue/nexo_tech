-- Thêm 3 danh mục mới: vivo, realme, HONOR
-- Thêm 30 sản phẩm mới cho các thương hiệu: Apple, Samsung, Xiaomi, OPPO, vivo, realme, HONOR
-- Cập nhật category_id cho các sản phẩm mới dựa trên tên sản phẩm và slug danh mục

INSERT INTO categories (name, slug, description, status) VALUES
('vivo', 'vivo', 'Điện thoại thương hiệu vivo', 1),
('realme', 'realme', 'Điện thoại thương hiệu realme', 1),
('HONOR', 'honor', 'Điện thoại thương hiệu HONOR', 1);

INSERT INTO products(name, price, sale_price, image, description, stock) VALUES
-- APPLE
('iPhone 16 128GB', 22990000, 20990000, 'https://placehold.co/600x450?text=iPhone+16', 'Điện thoại Apple iPhone 16, bộ nhớ 128GB.', 15),
('iPhone 16 Plus 128GB', 25990000, 23990000, 'https://placehold.co/600x450?text=iPhone+16+Plus', 'Điện thoại Apple iPhone 16 Plus, bộ nhớ 128GB.', 10),
('iPhone 16 Pro 256GB', 28990000, 26990000, 'https://placehold.co/600x450?text=iPhone+16+Pro', 'Điện thoại Apple iPhone 16 Pro, bộ nhớ 256GB.', 8),
('iPhone 16 Pro Max 256GB', 34990000, 32990000, 'https://placehold.co/600x450?text=iPhone+16+Pro+Max', 'Điện thoại Apple iPhone 16 Pro Max, bộ nhớ 256GB.', 7),
('iPhone 15 Plus 128GB', 22990000, 20990000, 'https://placehold.co/600x450?text=iPhone+15+Plus', 'Điện thoại Apple iPhone 15 Plus, bộ nhớ 128GB.', 12),
('iPhone 15 Pro Max 256GB', 30990000, 28990000, 'https://placehold.co/600x450?text=iPhone+15+Pro+Max', 'Điện thoại Apple iPhone 15 Pro Max, bộ nhớ 256GB.', 6),

-- SAMSUNG
('Samsung Galaxy S25 256GB', 22990000, 20990000, 'https://placehold.co/600x450?text=Galaxy+S25', 'Điện thoại Samsung Galaxy S25, bộ nhớ 256GB.', 12),
('Samsung Galaxy S25 Plus 256GB', 26990000, 24990000, 'https://placehold.co/600x450?text=Galaxy+S25+Plus', 'Điện thoại Samsung Galaxy S25 Plus, bộ nhớ 256GB.', 8),
('Samsung Galaxy S25 Ultra 256GB', 33990000, 31990000, 'https://placehold.co/600x450?text=Galaxy+S25+Ultra', 'Điện thoại Samsung Galaxy S25 Ultra, bộ nhớ 256GB.', 5),
('Samsung Galaxy A56 5G 256GB', 11990000, 10990000, 'https://placehold.co/600x450?text=Galaxy+A56', 'Điện thoại Samsung Galaxy A56 5G, bộ nhớ 256GB.', 20),
('Samsung Galaxy A36 5G 128GB', 8990000, 7990000, 'https://placehold.co/600x450?text=Galaxy+A36', 'Điện thoại Samsung Galaxy A36 5G, bộ nhớ 128GB.', 18),
('Samsung Galaxy Z Flip6 256GB', 28990000, 26990000, 'https://placehold.co/600x450?text=Galaxy+Z+Flip6', 'Điện thoại gập Samsung Galaxy Z Flip6, bộ nhớ 256GB.', 6),

-- XIAOMI
('Xiaomi 15 256GB', 22990000, 20990000, 'https://placehold.co/600x450?text=Xiaomi+15', 'Điện thoại Xiaomi 15, bộ nhớ 256GB.', 10),
('Xiaomi 14T Pro 512GB', 16990000, 14990000, 'https://placehold.co/600x450?text=Xiaomi+14T+Pro', 'Điện thoại Xiaomi 14T Pro, bộ nhớ 512GB.', 9),
('Redmi Note 14 Pro 5G 256GB', 8990000, 7990000, 'https://placehold.co/600x450?text=Redmi+Note+14+Pro', 'Điện thoại Redmi Note 14 Pro 5G, bộ nhớ 256GB.', 20),
('Redmi Note 14 128GB', 5990000, 5490000, 'https://placehold.co/600x450?text=Redmi+Note+14', 'Điện thoại Redmi Note 14, bộ nhớ 128GB.', 25),
('POCO X7 Pro 256GB', 8990000, 8290000, 'https://placehold.co/600x450?text=POCO+X7+Pro', 'Điện thoại POCO X7 Pro, bộ nhớ 256GB.', 15),

-- OPPO
('OPPO Reno13 5G 256GB', 15990000, 13990000, 'https://placehold.co/600x450?text=OPPO+Reno13', 'Điện thoại OPPO Reno13 5G, bộ nhớ 256GB.', 10),
('OPPO Reno13 F 5G 256GB', 9990000, 8990000, 'https://placehold.co/600x450?text=OPPO+Reno13+F', 'Điện thoại OPPO Reno13 F 5G, bộ nhớ 256GB.', 15),
('OPPO A5 Pro 5G 256GB', 8990000, 7990000, 'https://placehold.co/600x450?text=OPPO+A5+Pro', 'Điện thoại OPPO A5 Pro 5G, bộ nhớ 256GB.', 18),
('OPPO Find X8 512GB', 22990000, 20990000, 'https://placehold.co/600x450?text=OPPO+Find+X8', 'Điện thoại OPPO Find X8, bộ nhớ 512GB.', 7),

-- VIVO
('vivo V50 5G 256GB', 12990000, 11990000, 'https://placehold.co/600x450?text=vivo+V50', 'Điện thoại vivo V50 5G, bộ nhớ 256GB.', 12),
('vivo V40 5G 256GB', 11990000, 9990000, 'https://placehold.co/600x450?text=vivo+V40', 'Điện thoại vivo V40 5G, bộ nhớ 256GB.', 10),
('vivo Y29 5G 128GB', 6990000, 6490000, 'https://placehold.co/600x450?text=vivo+Y29', 'Điện thoại vivo Y29 5G, bộ nhớ 128GB.', 20),

-- REALME
('realme 14 Pro 5G 256GB', 10990000, 9990000, 'https://placehold.co/600x450?text=realme+14+Pro', 'Điện thoại realme 14 Pro 5G, bộ nhớ 256GB.', 12),
('realme 13 Plus 5G 256GB', 8990000, 7990000, 'https://placehold.co/600x450?text=realme+13+Plus', 'Điện thoại realme 13 Plus 5G, bộ nhớ 256GB.', 15),
('realme C75 256GB', 6990000, 6290000, 'https://placehold.co/600x450?text=realme+C75', 'Điện thoại realme C75, bộ nhớ 256GB.', 20),

-- HONOR
('HONOR Magic7 Pro 512GB', 27990000, 25990000, 'https://placehold.co/600x450?text=HONOR+Magic7+Pro', 'Điện thoại HONOR Magic7 Pro, bộ nhớ 512GB.', 5),
('HONOR 200 5G 256GB', 12990000, 11990000, 'https://placehold.co/600x450?text=HONOR+200', 'Điện thoại HONOR 200 5G, bộ nhớ 256GB.', 10),
('HONOR X9c 5G 256GB', 8990000, 8290000, 'https://placehold.co/600x450?text=HONOR+X9c', 'Điện thoại HONOR X9c 5G, bộ nhớ 256GB.', 18);

UPDATE products
SET category_id = CASE
    WHEN name LIKE 'iPhone%' THEN (
        SELECT id FROM categories WHERE slug = 'apple'
    )

    WHEN name LIKE 'Samsung%' THEN (
        SELECT id FROM categories WHERE slug = 'samsung'
    )

    WHEN name LIKE 'Xiaomi%'
      OR name LIKE 'Redmi%'
      OR name LIKE 'POCO%' THEN (
        SELECT id FROM categories WHERE slug = 'xiaomi'
    )

    WHEN name LIKE 'OPPO%' THEN (
        SELECT id FROM categories WHERE slug = 'oppo'
    )

    WHEN name LIKE 'vivo%' THEN (
        SELECT id FROM categories WHERE slug = 'vivo'
    )

    WHEN name LIKE 'realme%' THEN (
        SELECT id FROM categories WHERE slug = 'realme'
    )

    WHEN name LIKE 'HONOR%' THEN (
        SELECT id FROM categories WHERE slug = 'honor'
    )

    ELSE category_id
END
WHERE category_id IS NULL;