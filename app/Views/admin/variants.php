
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold mb-1">Quản lý biến thể điện thoại</h2>
            <p class="text-muted mb-0">
                Quản lý màu sắc, RAM, dung lượng và tồn kho điện thoại.
            </p>
        </div>

        <a href="/admin/variants/create" class="btn btn-primary">
            + Thêm biến thể
        </a>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-info alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['flash']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
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
                                                src="/<?= htmlspecialchars(ltrim($variant['image'], '/')) ?>"
                                                alt="Ảnh biến thể"
                                                width="65"
                                                height="65"
                                                style="object-fit: cover; border-radius: 8px;"
                                            >
                                        <?php else: ?>
                                            <span class="text-muted">Chưa có ảnh</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($variant['product_name'] ?? 'Không xác định') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($variant['sku'] ?? '') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($variant['color'] ?? '') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($variant['ram'] ?? '') ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($variant['storage'] ?? '') ?>
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

                                            <a
                                                href="/admin/variants/edit/<?= (int) $variant['id'] ?>"
                                                class="btn btn-warning btn-sm"
                                            >
                                                Sửa
                                            </a>

                                            <form
                                                method="POST"
                                                action="/admin/variants/delete"
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa biến thể này không?');"
                                            >
                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int) $variant['id'] ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    Xóa
                                                </button>
                                            </form>

                                        </div>

                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="12" class="text-center py-4">
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
