
<div class="container py-5">

    <div class="mb-4">
        <h2 class="fw-bold">Danh mục sản phẩm</h2>
        <p class="text-muted">
            Khám phá các dòng điện thoại tại NEXO TECH
        </p>
    </div>

    <div class="row g-4">

        <?php foreach ($categories as $category): ?>

            <div class="col-6 col-md-4 col-lg-3">

                <a
                    href="/categories/<?= htmlspecialchars($category['slug']) ?>"
                    class="category-item text-decoration-none"
                >

                    <div class="card h-100 shadow-sm category-card">

                        <div class="card-body text-center py-4">

                            <div class="category-icon mb-3">
                                <i class="bi bi-phone"></i>
                            </div>

                            <h5 class="fw-bold text-dark mb-2">
                                <?= htmlspecialchars($category['name']) ?>
                            </h5>

                            <p class="text-muted small mb-0">
                                <?= htmlspecialchars(
                                    $category['description'] ?? ''
                                ) ?>
                            </p>

                            <span class="btn btn-outline-dark btn-sm mt-3">
                                Xem sản phẩm →
                            </span>

                        </div>

                    </div>

                </a>

            </div>

        <?php endforeach; ?>

        <?php if (empty($categories)): ?>

            <div class="col-12">
                <div class="alert alert-info text-center">
                    Hiện chưa có danh mục sản phẩm.
                </div>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
.category-card {
    border: 1px solid #eee;
    border-radius: 14px;
    transition: .25s;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,.09) !important;
}

.category-icon {
    font-size: 42px;
    color: #0d6efd;
}
</style>
