<div class="admin-page">

    <!-- SIDEBAR -->
<aside class="admin-sidebar">

    <h2>⚙️ ADMIN</h2>
    <a href="/admin">📊 Tổng quan</a>
    <a href="/admin/products" class="active">📱 Quản lý sản phẩm</a>
    <a href="/admin/variants">🎨 Quản lý biến thể</a>
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

    <!-- Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="fw-bold mb-1">
                Quản lý sản phẩm
            </h1>

            <p class="text-muted mb-0">
                Thêm, sửa và quản lý điện thoại trên NEXO TECH
            </p>
        </div>

    </div>


    <!-- THÔNG BÁO -->
    <?php if (!empty($_SESSION['flash'])): ?>

        <div class="alert alert-info alert-dismissible fade show">

            <?= htmlspecialchars($_SESSION['flash']) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

        <?php unset($_SESSION['flash']); ?>

    <?php endif; ?>


    <!-- ==========================================
         FORM THÊM SẢN PHẨM
    ========================================== -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body p-4">

            <h5 class="fw-bold mb-3">
                Thêm sản phẩm mới
            </h5>

            <form
                method="post"
                action="/admin/products/create"
                class="row g-3"
            >

                <!-- Tên sản phẩm -->
                <div class="col-md-6">

                    <label class="form-label fw-bold">
                        Tên điện thoại
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        placeholder="Ví dụ: iPhone 16 Pro Max"
                        required
                    >

                </div>


                <!-- Giá -->
                <div class="col-md-3">

                    <label class="form-label fw-bold">
                        Giá gốc
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="price"
                        placeholder="Ví dụ: 18990000"
                        inputmode="numeric"
                        required
                    >

                </div>


                <!-- Giá khuyến mãi -->
                <div class="col-md-3">

                    <label class="form-label fw-bold">
                        Giá khuyến mãi
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="sale_price"
                        placeholder="Không bắt buộc"
                        inputmode="numeric"
                    >

                </div>


                <!-- Tồn kho -->
                <div class="col-md-3">

                    <label class="form-label fw-bold">
                        Tồn kho
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        name="stock"
                        min="0"
                        placeholder="Ví dụ: 10"
                        required
                    >

                </div>


                <!-- Trạng thái -->
                <div class="col-md-3">

                    <label class="form-label fw-bold">
                        Trạng thái
                    </label>

                    <select
                        class="form-select"
                        name="status"
                    >
                        <option value="1">
                            Đang bán
                        </option>

                        <option value="0">
                            Tạm ẩn
                        </option>
                    </select>

                </div>


                <!-- Đường dẫn ảnh -->
                <div class="col-md-6">

                    <label class="form-label fw-bold">
                        Đường dẫn ảnh
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="image"
                        placeholder="/assets/images/products/images.jpeg"
                    >

                    <small class="text-muted">
                        Ví dụ: /assets/images/products/images.jpeg
                    </small>

                </div>


                <!-- Mô tả -->
                <div class="col-12">

                    <label class="form-label fw-bold">
                        Mô tả sản phẩm
                    </label>

                    <textarea
                        class="form-control"
                        name="description"
                        rows="4"
                        placeholder="Nhập thông tin chi tiết về điện thoại..."
                    ></textarea>

                </div>


                <!-- Nút thêm -->
                <div class="col-12">

                    <button
                        type="submit"
                        class="btn btn-warning px-4"
                    >
                        + Thêm sản phẩm
                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- ==========================================
         TÌM KIẾM
    ========================================== -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form
                method="get"
                action="/admin/products"
                class="row g-2"
            >

                <div class="col-md-10">

                    <input
                        type="text"
                        class="form-control"
                        name="keyword"
                        value="<?= htmlspecialchars($keyword ?? '') ?>"
                        placeholder="Tìm kiếm theo tên điện thoại..."
                    >

                </div>

                <div class="col-md-2 d-grid">

                    <button
                        type="submit"
                        class="btn btn-dark"
                    >
                        Tìm kiếm
                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- ==========================================
         DANH SÁCH SẢN PHẨM
    ========================================== -->

    <div class="card shadow-sm border-0">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between mb-3">

                <h5 class="fw-bold mb-0">
                    Danh sách sản phẩm
                </h5>

                <span class="text-muted">
                    <?= count($products) ?> sản phẩm
                </span>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th class="text-center">
                                Thao tác
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (empty($products)): ?>

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-4"
                                >
                                    Chưa có sản phẩm nào.
                                </td>

                            </tr>

                        <?php else: ?>

                            <?php foreach ($products as $p): ?>

                                <tr>

                                    <!-- ID -->
                                    <td>
                                        <?= (int) $p['id'] ?>
                                    </td>


                                    <!-- Ảnh -->
                                    <td>

                                        <?php if (!empty($p['image'])): ?>

                                            <img
                                                src="<?= htmlspecialchars($p['image']) ?>"
                                                alt="<?= htmlspecialchars($p['name']) ?>"
                                                style="
                                                    width: 70px;
                                                    height: 70px;
                                                    object-fit: contain;
                                                    background: #f8f9fa;
                                                    border-radius: 8px;
                                                    padding: 5px;
                                                "
                                            >

                                        <?php else: ?>

                                            <span class="text-muted small">
                                                Chưa có ảnh
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- Tên -->
                                    <td>

                                        <strong>
                                            <?= htmlspecialchars($p['name']) ?>
                                        </strong>

                                        <?php if (!empty($p['description'])): ?>

                                            <div
                                                class="text-muted small mt-1"
                                                style="
                                                    max-width: 250px;
                                                    white-space: nowrap;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;
                                                "
                                            >
                                                <?= htmlspecialchars($p['description']) ?>
                                            </div>

                                        <?php endif; ?>

                                    </td>


                                    <!-- Giá -->
                                    <td>

                                        <?php if (
                                            !empty($p['sale_price']) &&
                                            (float) $p['sale_price'] > 0
                                        ): ?>

                                            <div
                                                class="text-muted small text-decoration-line-through"
                                            >
                                                <?= number_format(
                                                    (float) $p['price'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?> đ
                                            </div>

                                            <strong class="text-danger">

                                                <?= number_format(
                                                    (float) $p['sale_price'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?> đ

                                            </strong>

                                        <?php else: ?>

                                            <strong>

                                                <?= number_format(
                                                    (float) $p['price'],
                                                    0,
                                                    ',',
                                                    '.'
                                                ) ?> đ

                                            </strong>

                                        <?php endif; ?>

                                    </td>


                                    <!-- Tồn kho -->
                                    <td>
                                        <?= (int) $p['stock'] ?>
                                    </td>


                                    <!-- Trạng thái -->
                                    <td>

                                        <?php if ((int) $p['status'] === 1): ?>

                                            <span class="badge bg-success">
                                                Đang bán
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-secondary">
                                                Tạm ẩn
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- Thao tác -->
                                    <td class="text-center">

                                        <!-- Nút sửa -->
                                        <a
                                            href="/admin/products/edit?id=<?= (int) $p['id'] ?>"
                                            class="btn btn-primary btn-sm mb-1"
                                        >
                                            Sửa
                                        </a>


                                        <!-- Nút xóa -->
                                        <form
                                            method="post"
                                            action="/admin/products/delete"
                                            class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn sản phẩm này không?');"
                                        >

                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= (int) $p['id'] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm mb-1"
                                            >
                                                Xóa
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

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
/* ==========================================
   LAYOUT ADMIN - ĐỒNG BỘ DASHBOARD
========================================== */

.admin-page {
    display: flex;
    min-height: 650px;
    margin: 20px 0;
    gap: 25px;
}

/* ==========================================
   SIDEBAR
========================================== */

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

/* ==========================================
   NỘI DUNG CHÍNH
========================================== */

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

/* ==========================================
   TIÊU ĐỀ VÀ MÔ TẢ
========================================== */

.admin-content .text-muted {
    color: #6c757d !important;
}

/* ==========================================
   CARD
========================================== */

.admin-content .card {
    background: #fff;
    border: 1px solid #e5e5e5 !important;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    overflow: hidden;
}

.admin-content .card-body {
    padding: 24px;
}

/* ==========================================
   FORM NHẬP LIỆU
========================================== */

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
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.2);
}

/* ==========================================
   BUTTON
========================================== */

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

.admin-content .btn-dark {
    background: #212529;
    border-color: #212529;
}

.admin-content .btn {
    border-radius: 7px;
}

/* ==========================================
   THÔNG BÁO
========================================== */

.admin-content .alert {
    border-radius: 8px;
    padding: 13px 16px;
}

/* ==========================================
   BẢNG SẢN PHẨM
========================================== */

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
}

.admin-content .table tbody tr:hover {
    background: #fafafa;
}

.admin-content .badge {
    padding: 7px 10px;
    border-radius: 20px;
    font-size: 12px;
}

/* ==========================================
   RESPONSIVE
========================================== */

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

