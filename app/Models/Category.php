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
    
    /**
 * Lấy danh mục đang hoạt động theo slug
 */
public function findActiveBySlug(string $slug): ?array
{
    $stmt = $this->db->prepare("
        SELECT *
        FROM categories
        WHERE slug = :slug AND status = 1
        LIMIT 1
    ");

    $stmt->execute(['slug' => $slug]);

    return $stmt->fetch() ?: null;
}

/**
 * Tạo điều kiện lọc sản phẩm
 */
private function filterConditions(int $categoryId, array $filters): array
{
    $sql = "
        WHERE category_id = :category_id
        AND status = 1
    ";

    $params = [
        'category_id' => $categoryId
    ];

    if ($filters['keyword'] !== '') {
        $sql .= " AND name LIKE :keyword";
        $params['keyword'] = '%' . $filters['keyword'] . '%';
    }

    $effectivePrice = "COALESCE(NULLIF(sale_price, 0), price)";

    if ($filters['minPrice'] > 0) {
        $sql .= " AND $effectivePrice >= :min_price";
        $params['min_price'] = $filters['minPrice'];
    }

    if ($filters['maxPrice'] > 0) {
        $sql .= " AND $effectivePrice <= :max_price";
        $params['max_price'] = $filters['maxPrice'];
    }

    if ($filters['stock'] === 'in_stock') {
        $sql .= " AND stock > 0";
    } elseif ($filters['stock'] === 'out_of_stock') {
        $sql .= " AND stock <= 0";
    }

    return [$sql, $params];
}

/**
 * Lọc sản phẩm theo danh mục
 */
public function filterProducts(
    int $categoryId,
    array $filters,
    int $limit = 12,
    int $offset = 0
): array {
    [$where, $params] = $this->filterConditions(
        $categoryId,
        $filters
    );

    $sortOptions = [
        'newest' => 'id DESC',
        'oldest' => 'id ASC',
        'price_asc' => 'COALESCE(NULLIF(sale_price, 0), price) ASC',
        'price_desc' => 'COALESCE(NULLIF(sale_price, 0), price) DESC',
        'name_asc' => 'name ASC'
    ];

    $sort = $sortOptions[$filters['sort']] ?? 'id DESC';

    $sql = "
        SELECT *
        FROM products
        $where
        ORDER BY $sort
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->db->prepare($sql);

    foreach ($params as $key => $value) {
        $type = is_int($value)
            ? \PDO::PARAM_INT
            : \PDO::PARAM_STR;

        $stmt->bindValue(':' . $key, $value, $type);
    }

    $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll();
}

/**
 * Đếm sản phẩm sau khi lọc
 */
public function countFilteredProducts(
    int $categoryId,
    array $filters
): int {
    [$where, $params] = $this->filterConditions(
        $categoryId,
        $filters
    );

    $stmt = $this->db->prepare("
        SELECT COUNT(*)
        FROM products
        $where
    ");

    $stmt->execute($params);

    return (int) $stmt->fetchColumn();
}
}

