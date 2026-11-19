-- Mở database hpc_phone và dán đoạn code sau vào SQL để tạo bảng product_variants và thêm dữ liệu mẫu

USE hpc_phone;

-- 1. Tao bang bien the san pham
CREATE TABLE IF NOT EXISTS product_variants (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Ma san pham cha
    product_id INT NOT NULL,

    -- Ma SKU rieng cua bien the
    sku VARCHAR(100) NOT NULL UNIQUE,

    -- Thuoc tinh dien thoai
    color VARCHAR(100) NOT NULL,
    ram VARCHAR(50) NOT NULL,
    storage VARCHAR(50) NOT NULL,

    -- Gia ban
    price DECIMAL(15,2) NOT NULL,
    sale_price DECIMAL(15,2) DEFAULT NULL,

    -- So luong ton kho cua tung bien the
    stock INT NOT NULL DEFAULT 0,

    -- Anh rieng cua bien the
    image VARCHAR(255) DEFAULT NULL,

    -- Trang thai
    status TINYINT NOT NULL DEFAULT 1,

    -- Ngay tao
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Moi to hop chi duoc xuat hien mot lan
    UNIQUE KEY unique_variant (
        product_id,
        color,
        ram,
        storage
    ),

    -- Khoa ngoai lien ket voi products
    CONSTRAINT fk_variant_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;


-- ==========================================
-- 2. THEM DU LIEU BIEN THE MAU
-- ==========================================

INSERT INTO product_variants
(
    product_id,
    sku,
    color,
    ram,
    storage,
    price,
    sale_price,
    stock,
    status
)
VALUES

-- iPhone 15
(1, 'IP15-BLK-6-128', 'Den', '6GB', '128GB',
 18990000, 16990000, 5, 1),

(1, 'IP15-BLU-6-128', 'Xanh', '6GB', '128GB',
 18990000, 16990000, 10, 1),

(1, 'IP15-PNK-6-128', 'Hong', '6GB', '128GB',
 18990000, 16990000, 7, 1),

-- Samsung Galaxy S24
(2, 'SS24-BLK-8-256', 'Den', '8GB', '256GB',
 21990000, 19490000, 8, 1),

(2, 'SS24-GRY-8-256', 'Xam', '8GB', '256GB',
 21990000, 19490000, 6, 1),

-- Xiaomi 14T
(3, 'XM14-BLK-12-256', 'Den', '12GB', '256GB',
 12990000, 10990000, 15, 1),

(3, 'XM14-BLU-12-256', 'Xanh', '12GB', '256GB',
 12990000, 10990000, 5, 1),

-- OPPO Reno12
(4, 'OP12-BLK-8-256', 'Den', '8GB', '256GB',
 11990000, 9990000, 10, 1),

(4, 'OP12-PNK-8-256', 'Hong', '8GB', '256GB',
 11990000, 9990000, 8, 1);


-- ==========================================
-- 3. KIEM TRA DU LIEU BIEN THE
-- ==========================================

SELECT
    pv.id,
    p.name AS product_name,
    pv.sku,
    pv.color,
    pv.ram,
    pv.storage,
    pv.price,
    pv.sale_price,
    pv.stock,
    pv.status
FROM product_variants pv
INNER JOIN products p
    ON pv.product_id = p.id
ORDER BY p.id, pv.id;
