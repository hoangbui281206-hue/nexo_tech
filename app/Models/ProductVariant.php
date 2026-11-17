<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\BaseModel;

class ProductVariant extends BaseModel
{
    /**
     * Lấy các biến thể đang hoạt động của sản phẩm
     */
    public function allByProduct(int $productId): array
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM product_variants
             WHERE product_id = :product_id
             AND status = 1
             ORDER BY id DESC"
        );

        $stmt->execute([
            'product_id' => $productId
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Lấy tất cả biến thể của sản phẩm dành cho Admin
     * Bao gồm cả biến thể đang bán và ngừng bán
     */
    public function allAdminByProduct(int $productId): array
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM product_variants
             WHERE product_id = :product_id
             ORDER BY id DESC"
        );

        $stmt->execute([
            'product_id' => $productId
        ]);

        return $stmt->fetchAll();
    }

    /**
     * Lấy toàn bộ biến thể dành cho Admin
     */
    public function allAdmin(): array
    {
        $stmt = $this->db->prepare(
            "SELECT
                pv.*,
                p.name AS product_name
             FROM product_variants pv
             LEFT JOIN products p
                ON pv.product_id = p.id
             ORDER BY pv.id DESC"
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Tìm biến thể theo ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM product_variants
             WHERE id = :id
             LIMIT 1"
        );

        $stmt->execute([
            'id' => $id
        ]);

        $variant = $stmt->fetch();

        return $variant ?: null;
    }

    /**
     * Thêm biến thể mới
     */
    public function create(array $data): bool
    {
        $sql = "
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
                image,
                status
            )
            VALUES
            (
                :product_id,
                :sku,
                :color,
                :ram,
                :storage,
                :price,
                :sale_price,
                :stock,
                :image,
                :status
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'product_id' => (int) $data['product_id'],
            'sku' => trim($data['sku']),
            'color' => trim($data['color']),
            'ram' => trim($data['ram']),
            'storage' => trim($data['storage']),
            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,
            'stock' => (int) ($data['stock'] ?? 0),
            'image' => $data['image'] ?? null,
            'status' => (int) ($data['status'] ?? 1)
        ]);
    }

    /**
     * Cập nhật biến thể
     */
    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE product_variants
            SET
                sku = :sku,
                color = :color,
                ram = :ram,
                storage = :storage,
                price = :price,
                sale_price = :sale_price,
                stock = :stock,
                image = :image,
                status = :status
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'sku' => trim($data['sku']),
            'color' => trim($data['color']),
            'ram' => trim($data['ram']),
            'storage' => trim($data['storage']),
            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,
            'stock' => (int) ($data['stock'] ?? 0),
            'image' => $data['image'] ?? null,
            'status' => (int) ($data['status'] ?? 1)
        ]);
    }

    /**
     * Xóa biến thể
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM product_variants
             WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
