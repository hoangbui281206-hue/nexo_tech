
<div class="container mt-4 mb-5">

    <h2 class="mb-4">🎨 Thêm biến thể điện thoại</h2>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-warning">
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <form
                method="POST"
                action="/admin/variants/create"
                enctype="multipart/form-data"
            >

                <!-- SẢN PHẨM -->
                <div class="mb-3">
                    <label class="form-label">Sản phẩm</label>

                    <select
                        name="product_id"
                        class="form-select"
                        required
                    >
                        <option value="">-- Chọn điện thoại --</option>

                        <?php foreach ($products as $product): ?>
                            <option value="<?= (int) $product['id'] ?>">
                                <?= htmlspecialchars($product['name']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <!-- SKU -->
                <div class="mb-3">
                    <label class="form-label">Mã SKU</label>

                    <input
                        type="text"
                        name="sku"
                        class="form-control"
                        placeholder="Ví dụ: IP17-256-BLK"
                        maxlength="100"
                        required
                    >
                </div>

                <!-- MÀU SẮC -->
                <div class="mb-3">
                    <label class="form-label">Màu sắc</label>

                    <input
                        type="text"
                        name="color"
                        class="form-control"
                        placeholder="Ví dụ: Đen, Trắng, Xanh"
                        maxlength="100"
                        required
                    >
                </div>

                <!-- RAM -->
                <div class="mb-3">
                    <label class="form-label">RAM</label>

                    <select
                        name="ram"
                        class="form-select"
                        required
                    >
                        <option value="">-- Chọn RAM --</option>
                        <option value="4GB">4GB</option>
                        <option value="6GB">6GB</option>
                        <option value="8GB">8GB</option>
                        <option value="12GB">12GB</option>
                        <option value="16GB">16GB</option>
                    </select>
                </div>

                <!-- DUNG LƯỢNG -->
                <div class="mb-3">
                    <label class="form-label">Dung lượng</label>

                    <select
                        name="storage"
                        class="form-select"
                        required
                    >
                        <option value="">-- Chọn dung lượng --</option>
                        <option value="64GB">64GB</option>
                        <option value="128GB">128GB</option>
                        <option value="256GB">256GB</option>
                        <option value="512GB">512GB</option>
                        <option value="1TB">1TB</option>
                    </select>
                </div>

                <!-- GIÁ BÁN -->
                <div class="mb-3">
                    <label class="form-label">Giá bán (VNĐ)</label>

                    <input
                        type="number"
                        name="price"
                        class="form-control"
                        min="1"
                        step="1"
                        placeholder="Ví dụ: 25000000"
                        required
                    >
                </div>

                <!-- GIÁ KHUYẾN MÃI -->
                <div class="mb-3">
                    <label class="form-label">Giá khuyến mãi (VNĐ)</label>

                    <input
                        type="number"
                        name="sale_price"
                        class="form-control"
                        min="0"
                        step="1"
                        placeholder="Để trống nếu không giảm giá"
                    >
                </div>

                <!-- TỒN KHO -->
                <div class="mb-3">
                    <label class="form-label">Số lượng tồn kho</label>

                    <input
                        type="number"
                        name="stock"
                        class="form-control"
                        min="0"
                        step="1"
                        value="0"
                        required
                    >
                </div>

                <!-- ẢNH -->
                <div class="mb-3">
                    <label class="form-label">Ảnh biến thể</label>

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small class="text-muted">
                        Chỉ nhận JPG, PNG, WEBP. Dung lượng tối đa 3MB.
                    </small>
                </div>

                <!-- TRẠNG THÁI -->
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>

                    <select name="status" class="form-select">
                        <option value="1">Đang bán</option>
                        <option value="0">Ngừng bán</option>
                    </select>
                </div>

                <!-- NÚT -->
                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        💾 Lưu biến thể
                    </button>

                    <a
                        href="/admin/variants"
                        class="btn btn-secondary"
                    >
                        Quay lại
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>
