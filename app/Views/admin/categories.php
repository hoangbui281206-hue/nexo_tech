
<div class="admin-page">
    <div class="admin-sidebar">
        <h2>⚙️ ADMIN</h2>

        <a href="/admin">📊 Tổng quan</a>
        <a href="/admin/products">📱 Quản lý sản phẩm</a>
        <a href="/admin/categories" class="active">📂 Quản lý danh mục</a>
        <a href="/admin/orders">📦 Quản lý đơn hàng</a>
        <a href="/admin/revenue">💰 Quản lý doanh thu</a>
        <a href="/admin/users">👥 Quản lý người dùng</a>
        <hr>
        <a href="/">🏠 Về trang chủ</a>
    </div>

    <div class="admin-content">
        <h1>Quản lý danh mục</h1>
        <p class="page-description">
            Quản lý các danh mục sản phẩm trong cửa hàng NEXO TECH.
        </p>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert">
                <?= htmlspecialchars($_SESSION['flash']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="admin-card">

            <div class="card-header">
                <div>
                    <h2>Danh sách danh mục</h2>
                    <span>
                        Tổng: <?= count($categories) ?> danh mục
                    </span>
                </div>

                <a href="/admin/categories/create" class="btn-add">
                    + Thêm danh mục
                </a>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($categories)): ?>
                            <tr>
                                <td colspan="6" class="empty">
                                    Chưa có danh mục nào.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td>
                                        #<?= (int) $category['id'] ?>
                                    </td>

                                    <td class="category-name">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </td>

                                    <td>
                                        <span class="slug">
                                            <?= htmlspecialchars($category['slug']) ?>
                                        </span>
                                    </td>

                                    <td class="description">
                                        <?= htmlspecialchars(
                                            $category['description'] ?? 'Chưa có mô tả'
                                        ) ?>
                                    </td>

                                    <td>
                                        <?php if ((int) $category['status'] === 1): ?>
                                            <span class="badge active">
                                                Đang hoạt động
                                            </span>
                                        <?php else: ?>
                                            <span class="badge inactive">
                                                Ngừng hoạt động
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="action-buttons">

                                            <a
                                                href="/admin/categories/edit/<?= (int) $category['id'] ?>"
                                                class="btn-edit"
                                            >
                                                Sửa
                                            </a>

                                            <form
                                                action="/admin/categories/delete"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?')"
                                            >
                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int) $category['id'] ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn-delete"
                                                >
                                                    Xóa
                                                </button>
                                            </form>

                                        </div>
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
    padding: 20px;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.card-header h2 {
    margin: 0 0 5px;
}

.card-header span {
    color: #666;
    font-size: 14px;
}

.btn-add {
    display: inline-block;
    background: #ffc107;
    color: #212529;
    text-decoration: none;
    padding: 10px 16px;
    border-radius: 6px;
    font-weight: bold;
    white-space: nowrap;
}

.btn-add:hover {
    background: #e0a800;
    color: #212529;
}

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

th, td {
    padding: 13px 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

th {
    background: #f5f5f5;
    white-space: nowrap;
}

.category-name {
    font-weight: bold;
}

.slug {
    color: #555;
    background: #f1f1f1;
    padding: 5px 8px;
    border-radius: 5px;
    font-size: 13px;
}

.description {
    max-width: 200px;
    color: #666;
}

.badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    white-space: nowrap;
}

.badge.active {
    background: #d1e7dd;
    color: #0f5132;
}

.badge.inactive {
    background: #f8d7da;
    color: #842029;
}

.action-buttons {
    display: flex;
    gap: 7px;
}

.btn-edit,
.btn-delete {
    display: inline-block;
    padding: 7px 11px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
}

.btn-edit {
    background: #ffc107;
    color: #212529;
}

.btn-delete {
    background: #dc3545;
    color: white;
}

.btn-edit:hover {
    background: #e0a800;
}

.btn-delete:hover {
    background: #bb2d3b;
}

.empty {
    text-align: center;
    color: #777;
    padding: 30px;
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

    .card-header {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>
