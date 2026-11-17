<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\BaseModel;

class Category extends BaseModel
{
    /** Lấy tất cả danh mục đang hoạt động */
    public function allActive(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC"
        );

        return $stmt->fetchAll();
    }

    /** Lấy danh mục theo slug */
    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM categories WHERE slug = :slug LIMIT 1"
        );
        $stmt->execute([':slug' => $slug]);

        return $stmt->fetch() ?: null;
    }

    /** Đếm số lượng danh mục */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM categories");
        return (int) $stmt->fetchColumn();
    }

    /** Lấy sản phẩm theo danh mục */
    public function getProducts(int $categoryId, int $limit = 0, int $offset = 0): array
    {
        $sql = "SELECT * FROM products WHERE category_id = :category_id AND status = 1 ORDER BY id DESC";
        $params = [':category_id' => $categoryId];

        if ($limit > 0) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = $limit;
            $params[':offset'] = $offset;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /** Đếm sản phẩm trong danh mục */
    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM products WHERE category_id = :category_id AND status = 1"
        );
        $stmt->execute([':category_id' => $categoryId]);

        return (int) $stmt->fetchColumn();
    }
}