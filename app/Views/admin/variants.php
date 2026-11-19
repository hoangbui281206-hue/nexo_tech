
<div class="admin-page">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <h2>⚙️ ADMIN</h2>

        <a href="/admin">📊 Tổng quan</a>
        <a href="/admin/products">📱 Quản lý sản phẩm</a>
        <a href="/admin/variants" class="active">🎨 Quản lý biến thể</a>
        <a href="/admin/categories">📂 Quản lý danh mục</a>
        <a href="/admin/orders">📦 Quản lý đơn hàng</a>
        <a href="/admin/revenue">💰 Quản lý doanh thu</a>
        <a href="/admin/users">👥 Quản lý người dùng</a>

        <hr>
        <a href="/">🏠 Về trang chủ</a>
    </aside>

    <!-- NỘI DUNG CHÍNH -->
    <main class="admin-content">

        <div class="container-fluid py-2">

            <!-- TIÊU ĐỀ -->
            <div class="mb-4">
                <h1 class="fw-bold mb-1">Quản lý biến thể điện thoại</h1>
                <p class="text-muted mb-0">
                    Quản lý màu sắc, RAM, dung lượng và tồn kho điện thoại.
                </p>
            </div>

            <!-- THÔNG BÁO -->
            <?php if (!empty($_SESSION['flash'])): ?>
                <div class="alert alert-info alert-dismissible fade show">
                    <?= htmlspecialchars($_SESSION['flash'], ENT_QUOTES, 'UTF-8') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>


            <!-- FORM THÊM BIẾN THỂ -->
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">Thêm biến thể mới</h5>

                    <form method="POST"
                          action="/admin/variants/create"
                          enctype="multipart/form-data">

                        <div class="row g-3">

                            <!-- SẢN PHẨM -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Sản phẩm</label>

                                <select name="product_id" class="form-select" required>
                                    <option value="">-- Chọn điện thoại --</option>

                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= (int) $product['id'] ?>">
                                            <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <!-- SKU -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Mã SKU</label>

                                <input type="text"
                                       name="sku"
                                       class="form-control"
                                       placeholder="Ví dụ: IP17-256-BLK"
                                       maxlength="100"
                                       required>
                            </div>

                            <!-- MÀU SẮC -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Màu sắc</label>

                                <input type="text"
                                       name="color"
                                       class="form-control"
                                       placeholder="Ví dụ: Đen, Trắng, Xanh"
                                       maxlength="100"
                                       required>
                            </div>

                            <!-- RAM -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">RAM</label>

                                <select name="ram" class="form-select" required>
                                    <option value="">-- Chọn RAM --</option>
                                    <option value="4GB">4GB</option>
                                    <option value="6GB">6GB</option>
                                    <option value="8GB">8GB</option>
                                    <option value="12GB">12GB</option>
                                    <option value="16GB">16GB</option>
                                </select>
                            </div>

                            <!-- DUNG LƯỢNG -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Dung lượng</label>

                                <select name="storage" class="form-select" required>
                                    <option value="">-- Chọn dung lượng --</option>
                                    <option value="64GB">64GB</option>
                                    <option value="128GB">128GB</option>
                                    <option value="256GB">256GB</option>
                                    <option value="512GB">512GB</option>
                                    <option value="1TB">1TB</option>
                                </select>
                            </div>

                            <!-- GIÁ BÁN -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Giá bán (VNĐ)</label>

                                <input type="number"
                                       name="price"
                                       class="form-control"
                                       min="1"
                                       step="1"
                                       placeholder="Ví dụ: 25000000"
                                       required>
                            </div>

                            <!-- GIÁ KHUYẾN MÃI -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Giá khuyến mãi (VNĐ)</label>

                                <input type="number"
                                       name="sale_price"
                                       class="form-control"
                                       min="0"
                                       step="1"
                                       placeholder="Để trống nếu không giảm giá">
                            </div>

                            <!-- TỒN KHO -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số lượng tồn kho</label>

                                <input type="number"
                                       name="stock"
                                       class="form-control"
                                       min="0"
                                       step="1"
                                       value="0"
                                       required>
                            </div>

                            <!-- ẢNH -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Ảnh biến thể</label>

                                <input type="file"
                                       name="image"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.webp">

                                <small class="text-muted">
                                    Chỉ nhận JPG, PNG, WEBP. Dung lượng tối đa 3MB.
                                </small>
                            </div>

                            <!-- TRẠNG THÁI -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Trạng thái</label>

                                <select name="status" class="form-select">
                                    <option value="1">Đang bán</option>
                                    <option value="0">Ngừng bán</option>
                                </select>
                            </div>

                            <!-- NÚT -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-warning px-4">
                                    + Thêm biến thể
                                </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>


            <!-- DANH SÁCH BIẾN THỂ -->
            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="fw-bold mb-0">
                            Danh sách biến thể
                        </h5>

                        <span class="text-muted">
                            <?= count($variants) ?> biến thể
                        </span>

                    </div>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th>Ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th>SKU</th>
                                    <th>Màu sắc</th>
                                    <th>RAM</th>
                                    <th>Dung lượng</th>
                                    <th>Giá bán</th>
                                    <th>Giá khuyến mãi</th>
                                    <th>Tồn kho</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php if (!empty($variants)): ?>

                                    <?php foreach ($variants as $index => $variant): ?>

                                        <tr>

                                            <td class="text-center">
                                                <?= $index + 1 ?>
                                            </td>

                                            <td>
                                                <?php if (!empty($variant['image'])): ?>
                                                    <img
                                                        src="/<?= htmlspecialchars(ltrim($variant['image'], '/'), ENT_QUOTES, 'UTF-8') ?>"
                                                        alt="Ảnh biến thể"
                                                        width="65"
                                                        height="65"
                                                        style="object-fit: cover; border-radius: 8px;"
                                                    >
                                                <?php else: ?>
                                                    <span class="text-muted small">Chưa có ảnh</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($variant['product_name'] ?? 'Không xác định', ENT_QUOTES, 'UTF-8') ?>
                                            </td>

                                            <td>
                                                <span class="text-muted small">
                                                    <?= htmlspecialchars($variant['sku'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                </span>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($variant['color'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($variant['ram'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($variant['storage'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                            </td>

                                            <td>
                                                <?= number_format((float) ($variant['price'] ?? 0), 0, ',', '.') ?> đ
                                            </td>

                                            <td>
                                                <?php if (!empty($variant['sale_price'])): ?>
                                                    <span class="text-danger fw-bold">
                                                        <?= number_format((float) $variant['sale_price'], 0, ',', '.') ?> đ
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">Không có</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    <?= (int) ($variant['stock'] ?? 0) ?>
                                                </span>
                                            </td>

                                            <td>
                                                <?php if ((int) ($variant['status'] ?? 0) === 1): ?>
                                                    <span class="badge bg-success">Đang bán</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Ngừng bán</span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">

                                                <div class="d-flex justify-content-center gap-2">

                                                    <a href="/admin/variants/edit/<?= (int) $variant['id'] ?>"
                                                       class="btn btn-primary btn-sm">
                                                        Sửa
                                                    </a>

                                                    <form method="POST"
                                                          action="/admin/variants/delete"
                                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này không?');">

                                                        <input type="hidden"
                                                               name="id"
                                                               value="<?= (int) $variant['id'] ?>">

                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            Xóa
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>
                                        <td colspan="12"
                                            class="text-center text-muted py-4">
                                            Chưa có biến thể điện thoại nào.
                                        </td>
                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

        </div>

    </main>

</div>


<style>

/* LAYOUT ADMIN */
.admin-page {
    display: flex;
    min-height: 650px;
    margin: 20px 0;
    gap: 25px;
}

/* SIDEBAR */
.admin-sidebar {
    width: 230px;
    flex-shrink: 0;
    background: #212529;
    border-radius: 10px;
    padding: 20px 15px;
    box-sizing: border-box;
}

.admin-sidebar h2 {
    color: white;
    margin: 0 0 25px;
    text-align: center;
}

.admin-sidebar a {
    display: block;
    color: #ddd;
    text-decoration: none;
    padding: 13px 15px;
    margin-bottom: 7px;
    border-radius: 6px;
    transition: 0.2s;
}

.admin-sidebar a:hover,
.admin-sidebar a.active {
    background: #ffc107;
    color: #212529;
    font-weight: 600;
}

.admin-sidebar hr {
    border: none;
    border-top: 1px solid #555;
    margin: 20px 0;
}

/* NỘI DUNG */
.admin-content {
    flex: 1;
    min-width: 0;
    padding: 0;
}

.admin-content h1 {
    margin-top: 0;
    font-size: 28px;
    font-weight: 700;
    color: #212529;
}

.admin-content h5 {
    color: #212529;
}

.admin-content .text-muted {
    color: #6c757d !important;
}

/* CARD */
.admin-content .card {
    background: #fff;
    border: 1px solid #e5e5e5 !important;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04) !important;
    overflow: hidden;
}

.admin-content .card-body {
    padding: 24px;
}

/* FORM */
.admin-content .form-label {
    color: #212529;
    font-size: 14px;
    margin-bottom: 7px;
}

.admin-content .form-control,
.admin-content .form-select {
    border: 1px solid #ced4da;
    border-radius: 7px;
    padding: 10px 12px;
    font-size: 14px;
}

.admin-content .form-control:focus,
.admin-content .form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255,193,7,0.2);
}

/* BUTTON */
.admin-content .btn-warning {
    background: #ffc107;
    border-color: #ffc107;
    color: #212529;
    font-weight: 600;
}

.admin-content .btn-warning:hover {
    background: #e0a800;
    border-color: #e0a800;
}

.admin-content .btn {
    border-radius: 7px;
}

/* ALERT */
.admin-content .alert {
    border-radius: 8px;
    padding: 13px 16px;
}

/* TABLE */
.admin-content .table {
    width: 100%;
    margin-bottom: 0;
    vertical-align: middle;
}

.admin-content .table th {
    background: #f8f9fa;
    color: #555;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    padding: 14px 12px;
}

.admin-content .table td {
    font-size: 14px;
    padding: 14px 12px;
    white-space: nowrap;
}

.admin-content .table tbody tr:hover {
    background: #fafafa;
}

.admin-content .badge {
    padding: 7px 10px;
    border-radius: 20px;
    font-size: 12px;
}

/* RESPONSIVE */
@media (max-width: 1100px) {
    .admin-content .card-body {
        padding: 18px;
    }
}

@media (max-width: 800px) {
    .admin-page {
        flex-direction: column;
        margin: 10px 0;
    }

    .admin-sidebar {
        width: 100%;
    }

    .admin-content {
        width: 100%;
    }
}

@media (max-width: 600px) {
    .admin-content h1 {
        font-size: 23px;
    }

    .admin-content .card-body {
        padding: 15px;
    }
}

</style>
