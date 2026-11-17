
<div class="container mt-4 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">✏️ Sửa biến thể điện thoại</h2>

        <a href="/admin/variants" class="btn btn-outline-secondary">
            ← Quay lại
        </a>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-warning">
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (!empty($variant)): ?>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form
                    method="POST"
                    action="/admin/variants/update"
                    enctype="multipart/form-data"
                >

                    <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $variant['id'] ?>"
                    >

                    <!-- SẢN PHẨM -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Sản phẩm
                        </label>

                        <select
                            name="product_id"
                            class="form-select"
                            required
                        >
                            <option value="">-- Chọn điện thoại --</option>

                            <?php foreach ($products as $product): ?>
                                <option
                                    value="<?= (int) $product['id'] ?>"
                                    <?= (int) $product['id'] === (int) $variant['product_id'] ? 'selected' : '' ?>
                                >
                                    <?= htmlspecialchars($product['name']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- SKU -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Mã SKU
                        </label>

                        <input
                            type="text"
                            name="sku"
                            class="form-control"
                            value="<?= htmlspecialchars($variant['sku'] ?? '') ?>"
                            required
                        >
                    </div>

                    <!-- MÀU SẮC -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Màu sắc
                        </label>

                        <input
                            type="text"
                            name="color"
                            class="form-control"
                            value="<?= htmlspecialchars($variant['color'] ?? '') ?>"
                            placeholder="Ví dụ: Đen, Trắng, Xanh"
                            required
                        >
                    </div>

                    <!-- RAM -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            RAM
                        </label>

                        <select name="ram" class="form-select" required>
                            <?php
                            $ramOptions = ['4GB', '6GB', '8GB', '12GB', '16GB'];
                            ?>

                            <?php foreach ($ramOptions as $ram): ?>
                                <option
                                    value="<?= $ram ?>"
                                    <?= ($variant['ram'] ?? '') === $ram ? 'selected' : '' ?>
                                >
                                    <?= $ram ?>
                                </option>
                            <?php endforeach; ?>

                            <?php if (!in_array($variant['ram'] ?? '', $ramOptions, true)): ?>
                                <option value="<?= htmlspecialchars($variant['ram'] ?? '') ?>" selected>
                                    <?= htmlspecialchars($variant['ram'] ?? '') ?>
                                </option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- DUNG LƯỢNG -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Dung lượng
                        </label>

                        <select name="storage" class="form-select" required>
                            <?php
                            $storageOptions = [
                                '64GB',
                                '128GB',
                                '256GB',
                                '512GB',
                                '1TB'
                            ];
                            ?>

                            <?php foreach ($storageOptions as $storage): ?>
                                <option
                                    value="<?= $storage ?>"
                                    <?= ($variant['storage'] ?? '') === $storage ? 'selected' : '' ?>
                                >
                                    <?= $storage ?>
                                </option>
                            <?php endforeach; ?>

                            <?php if (!in_array($variant['storage'] ?? '', $storageOptions, true)): ?>
                                <option value="<?= htmlspecialchars($variant['storage'] ?? '') ?>" selected>
                                    <?= htmlspecialchars($variant['storage'] ?? '') ?>
                                </option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- GIÁ BÁN -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Giá bán (VNĐ)
                        </label>

                        <input
                            type="number"
                            name="price"
                            class="form-control"
                            min="1"
                            step="1"
                            value="<?= htmlspecialchars((string) ($variant['price'] ?? '')) ?>"
                            required
                        >
                    </div>

                    <!-- GIÁ KHUYẾN MÃI -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Giá khuyến mãi (VNĐ)
                        </label>

                        <input
                            type="number"
                            name="sale_price"
                            class="form-control"
                            min="0"
                            step="1"
                            value="<?= htmlspecialchars((string) ($variant['sale_price'] ?? '')) ?>"
                            placeholder="Để trống nếu không giảm giá"
                        >
                    </div>

                    <!-- TỒN KHO -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Số lượng tồn kho
                        </label>

                        <input
                            type="number"
                            name="stock"
                            class="form-control"
                            min="0"
                            step="1"
                            value="<?= (int) ($variant['stock'] ?? 0) ?>"
                            required
                        >
                    </div>

                    <!-- ẢNH HIỆN TẠI -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Ảnh hiện tại
                        </label>

                        <div>
                            <?php if (!empty($variant['image'])): ?>
                                <img
                                    src="/<?= htmlspecialchars(ltrim($variant['image'], '/')) ?>"
                                    alt="Ảnh biến thể hiện tại"
                                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;"
                                >
                            <?php else: ?>
                                <p class="text-muted">Chưa có ảnh.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- CHỌN ẢNH MỚI -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Chọn ảnh mới
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small class="text-muted">
                            Để trống nếu muốn giữ ảnh hiện tại. Tối đa 3MB.
                        </small>
                    </div>

                    <!-- TRẠNG THÁI -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Trạng thái
                        </label>

                        <select name="status" class="form-select">
                            <option
                                value="1"
                                <?= (int) ($variant['status'] ?? 1) === 1 ? 'selected' : '' ?>
                            >
                                Đang bán
                            </option>

                            <option
                                value="0"
                                <?= (int) ($variant['status'] ?? 1) === 0 ? 'selected' : '' ?>
                            >
                                Ngừng bán
                            </option>
                        </select>
                    </div>

                    <!-- NÚT -->
                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            💾 Cập nhật biến thể
                        </button>

                        <a
                            href="/admin/variants"
                            class="btn btn-secondary"
                        >
                            Hủy
                        </a>

                    </div>

                </form>

            </div>
        </div>

    <?php else: ?>

        <div class="alert alert-danger">
            Không tìm thấy dữ liệu biến thể.
        </div>

    <?php endif; ?>

</div>
