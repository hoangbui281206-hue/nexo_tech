
<?php
$isEdit = !empty($category);
?>

<div class="admin-page">
    <div class="admin-sidebar">
        <h2>⚙️ ADMIN</h2>

        <a href="/admin">📊 Tổng quan</a>
        <a href="/admin/products">📱 Quản lý sản phẩm</a>
        <a href="/admin/categories" class="active">📂 Quản lý danh mục</a>
        <a href="/admin/orders">📦 Quản lý đơn hàng</a>
        <a href="/admin/users">👥 Quản lý người dùng</a>

        <hr>

        <a href="/">🏠 Về trang chủ</a>
    </div>

    <div class="admin-content">
        <h1><?= $isEdit ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới' ?></h1>

        <p class="page-description">
            <?= $isEdit
                ? 'Cập nhật thông tin danh mục sản phẩm.'
                : 'Nhập thông tin để tạo danh mục sản phẩm mới.' ?>
        </p>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert">
                <?= htmlspecialchars($_SESSION['flash']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="admin-card">
            <form
                action="<?= $isEdit ? '/admin/categories/update' : '/admin/categories/create' ?>"
                method="POST"
            >

                <?php if ($isEdit): ?>
                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $category['id'] ?>"
                    >
                <?php endif; ?>

                <div class="form-group">
                    <label for="name">Tên danh mục *</label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Ví dụ: Điện thoại iPhone"
                        value="<?= htmlspecialchars($category['name'] ?? '') ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="slug">Slug *</label>

                    <input
                        type="text"
                        id="slug"
                        name="slug"
                        placeholder="Ví dụ: dien-thoai-iphone"
                        value="<?= htmlspecialchars($category['slug'] ?? '') ?>"
                        required
                    >

                    <small>
                        Slug được sử dụng để tạo đường dẫn danh mục.
                    </small>
                </div>

                <div class="form-group">
                    <label for="description">Mô tả</label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Nhập mô tả danh mục..."
                    ><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="status-label">
                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            <?= !isset($category) || (int) $category['status'] === 1
                                ? 'checked'
                                : '' ?>
                        >
                        Kích hoạt danh mục
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <?= $isEdit ? 'Cập nhật danh mục' : 'Tạo danh mục' ?>
                    </button>

                    <a href="/admin/categories" class="btn-cancel">
                        Hủy
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
.admin-page {
    display: flex;
    min-height: 650px;
    margin: 20px 0;
    gap: 25px;
}

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
}

.admin-sidebar a:hover,
.admin-sidebar a.active {
    background: #ffc107;
    color: #212529;
}

.admin-sidebar hr {
    border: none;
    border-top: 1px solid #555;
    margin: 20px 0;
}

.admin-content {
    flex: 1;
    min-width: 0;
}

.admin-content h1 {
    margin-top: 0;
}

.page-description {
    color: #777;
    margin-bottom: 20px;
}

.admin-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 25px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
}

.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
    font-size: 14px;
    font-family: inherit;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #ffc107;
    box-shadow: 0 0 0 3px rgba(255,193,7,.15);
}

.form-group small {
    display: block;
    color: #777;
    margin-top: 6px;
}

.status-label {
    display: flex !important;
    align-items: center;
    gap: 9px;
    cursor: pointer;
}

.status-label input {
    width: 17px;
    height: 17px;
    accent-color: #ffc107;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

.btn-save,
.btn-cancel {
    padding: 11px 18px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
}

.btn-save {
    background: #ffc107;
    color: #212529;
}

.btn-save:hover {
    background: #e0a800;
}

.btn-cancel {
    background: #6c757d;
    color: white;
}

.alert {
    padding: 12px;
    margin-bottom: 20px;
    background: #d1e7dd;
    color: #0f5132;
    border-radius: 6px;
}

@media (max-width: 800px) {
    .admin-page {
        flex-direction: column;
    }

    .admin-sidebar {
        width: 100%;
    }
}
</style>
