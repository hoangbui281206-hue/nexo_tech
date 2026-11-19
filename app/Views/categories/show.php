
<?php
$e = fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');

$queryParams = [
    'keyword' => $filters['keyword'],
    'minPrice' => $filters['minPrice'] ?: '',
    'maxPrice' => $filters['maxPrice'] ?: '',
    'stock' => $filters['stock'],
    'sort' => $filters['sort']
];

function categoryPageUrl($page, $queryParams, $slug)
{
    $queryParams['page'] = $page;

    return '/categories/' . rawurlencode($slug)
        . '?' . http_build_query($queryParams);
}
?>

<div class="container py-4">

    <!-- Tiêu đề -->
    <div class="mb-4">
        <h2 class="fw-bold">
            <?= $e($category['name']) ?>
        </h2>

        <p class="text-muted">
            <?= $e($category['description'] ?? '') ?>
        </p>
    </div>

    <div class="row g-4">

        <!-- SIDEBAR LỌC -->
        <div class="col-lg-3">

            <div class="filter-box">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-funnel"></i>
                    Bộ lọc sản phẩm
                </h5>

                <form method="GET"
                      action="/categories/<?= rawurlencode($category['slug']) ?>">

                    <!-- Tìm kiếm -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Tìm kiếm
                        </label>

                        <input
                            type="text"
                            name="keyword"
                            class="form-control"
                            placeholder="Tên điện thoại..."
                            value="<?= $e($filters['keyword']) ?>"
                        >

                    </div>

                    <!-- Giá -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Khoảng giá (VNĐ)
                        </label>

                        <input
                            type="number"
                            name="minPrice"
                            class="form-control mb-2"
                            placeholder="Giá thấp nhất"
                            min="0"
                            value="<?= $e($filters['minPrice'] ?: '') ?>"
                        >

                        <input
                            type="number"
                            name="maxPrice"
                            class="form-control"
                            placeholder="Giá cao nhất"
                            min="0"
                            value="<?= $e($filters['maxPrice'] ?: '') ?>"
                        >

                    </div>

                    <!-- Tình trạng -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Tình trạng
                        </label>

                        <select name="stock" class="form-select">

                            <option value="">
                                Tất cả sản phẩm
                            </option>

                            <option value="in_stock"
                                <?= $filters['stock'] === 'in_stock' ? 'selected' : '' ?>>
                                Còn hàng
                            </option>

                            <option value="out_of_stock"
                                <?= $filters['stock'] === 'out_of_stock' ? 'selected' : '' ?>>
                                Hết hàng
                            </option>

                        </select>

                    </div>

                    <!-- Sắp xếp -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Sắp xếp
                        </label>

                        <select name="sort" class="form-select">

                            <option value="newest"
                                <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>
                                Mới nhất
                            </option>

                            <option value="oldest"
                                <?= $filters['sort'] === 'oldest' ? 'selected' : '' ?>>
                                Cũ nhất
                            </option>

                            <option value="price_asc"
                                <?= $filters['sort'] === 'price_asc' ? 'selected' : '' ?>>
                                Giá tăng dần
                            </option>

                            <option value="price_desc"
                                <?= $filters['sort'] === 'price_desc' ? 'selected' : '' ?>>
                                Giá giảm dần
                            </option>

                            <option value="name_asc"
                                <?= $filters['sort'] === 'name_asc' ? 'selected' : '' ?>>
                                Tên A - Z
                            </option>

                        </select>

                    </div>

                    <button type="submit"
                            class="btn btn-dark w-100 mb-2">
                        Áp dụng bộ lọc
                    </button>

                    <a href="/categories/<?= rawurlencode($category['slug']) ?>"
                       class="btn btn-outline-secondary w-100">
                        Xóa bộ lọc
                    </a>

                </form>

                <hr>

                <!-- Danh mục khác -->
                <h6 class="fw-bold mb-3">
                    Danh mục khác
                </h6>

                <?php foreach ($categories as $item): ?>

                    <a
                        href="/categories/<?= $e($item['slug']) ?>"
                        class="category-link <?= $item['id'] == $category['id'] ? 'active' : '' ?>"
                    >
                        <?= $e($item['name']) ?>
                    </a>

                <?php endforeach; ?>

            </div>

        </div>

        <!-- DANH SÁCH SẢN PHẨM -->
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <p class="mb-0 text-muted">
                    Tìm thấy
                    <strong><?= number_format($productsCount) ?></strong>
                    sản phẩm
                </p>

                <span class="text-muted small">
                    Trang <?= $page ?> / <?= $totalPages ?>
                </span>

            </div>

            <div class="row g-4">

                <?php if (!empty($products)): ?>

                    <?php foreach ($products as $product): ?>

                        <?php
                        $image = !empty($product['image'])
                            ? $product['image']
                            : '/assets/images/products/default-phone.png';

                        $price = !empty($product['sale_price'])
                            ? (float) $product['sale_price']
                            : (float) $product['price'];
                        ?>

                        <div class="col-6 col-md-4">

                            <div class="card product-card h-100">

                                <a href="/products/<?= (int) $product['id'] ?>">
                                    <img
                                        src="<?= $e($image) ?>"
                                        class="card-img-top product-image"
                                        alt="<?= $e($product['name']) ?>"
                                        onerror="this.src='/assets/images/products/default-phone.png'"
                                    >
                                </a>

                                <div class="card-body d-flex flex-column">

                                    <h6 class="fw-bold product-name">
                                        <?= $e($product['name']) ?>
                                    </h6>

                                    <p class="text-danger fw-bold mb-2">
                                        <?= number_format($price, 0, ',', '.') ?> đ
                                    </p>

                                    <?php if ((int) $product['stock'] > 0): ?>

                                        <span class="text-success small mb-3">
                                            <i class="bi bi-check-circle"></i>
                                            Còn hàng
                                        </span>

                                    <?php else: ?>

                                        <span class="text-danger small mb-3">
                                            Hết hàng
                                        </span>

                                    <?php endif; ?>

                                    <a
                                        href="/products/<?= (int) $product['id'] ?>"
                                        class="btn btn-outline-dark mt-auto w-100"
                                    >
                                        Xem chi tiết
                                    </a>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="col-12">

                        <div class="alert alert-light border text-center py-5">

                            <i class="bi bi-search fs-1 text-muted"></i>

                            <h5 class="mt-3">
                                Không tìm thấy sản phẩm
                            </h5>

                            <p class="text-muted">
                                Hãy thử thay đổi điều kiện lọc.
                            </p>

                            <a href="/categories/<?= $e($category['slug']) ?>"
                               class="btn btn-dark">
                                Xóa bộ lọc
                            </a>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

            <!-- PHÂN TRANG -->
            <?php if ($totalPages > 1): ?>

                <nav class="mt-5">

                    <ul class="pagination justify-content-center">

                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">

                            <a class="page-link"
                               href="<?= $page > 1 ? categoryPageUrl($page - 1, $queryParams, $category['slug']) : '#' ?>">
                                Trước
                            </a>

                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">

                                <a class="page-link"
                                   href="<?= categoryPageUrl($i, $queryParams, $category['slug']) ?>">
                                    <?= $i ?>
                                </a>

                            </li>

                        <?php endfor; ?>

                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">

                            <a class="page-link"
                               href="<?= $page < $totalPages ? categoryPageUrl($page + 1, $queryParams, $category['slug']) : '#' ?>">
                                Tiếp
                            </a>

                        </li>

                    </ul>

                </nav>

            <?php endif; ?>

        </div>

    </div>

</div>

<style>
.filter-box {
    padding: 22px;
    background: #fff;
    border: 1px solid #e9e9e9;
    border-radius: 12px;
    position: sticky;
    top: 20px;
}

.filter-box .form-control,
.filter-box .form-select {
    border-radius: 8px;
    padding: 10px 12px;
}

.category-link {
    display: block;
    padding: 10px 12px;
    color: #555;
    text-decoration: none;
    border-radius: 7px;
    margin-bottom: 5px;
}

.category-link:hover,
.category-link.active {
    background: #f1f4f9;
    color: #0d6efd;
    font-weight: 600;
}

.product-card {
    border: 1px solid #eee;
    border-radius: 12px;
    overflow: hidden;
    transition: .25s;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 7px 22px rgba(0,0,0,.08);
}

.product-image {
    width: 100%;
    height: 220px;
    object-fit: contain;
    padding: 15px;
}

.product-name {
    min-height: 42px;
}

@media(max-width: 767px) {
    .product-image {
        height: 150px;
    }

    .filter-box {
        position: static;
    }
}
</style>
