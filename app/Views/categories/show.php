<!-- app/Views/categories/show.php -->
<h1><?= htmlspecialchars($category['name']) ?></h1>
<p><?= htmlspecialchars($category['description'] ?? '') ?></p>
<p>Số sản phẩm: <?= $productsCount ?></p>

<div class="row">
    <?php foreach ($products as $product): ?>
        <?php
        $stock = (int)($product['stock'] ?? 0);
        $isSale = !empty($product['sale_price']);
        $displayPrice = $isSale ? (float)($product['sale_price'] ?? $product['price']) : (float)($product['price'] ?? 0);
        ?>
        <div class="col-md-4 mb-3">
            <div class="card border-0 <?php echo $stock > 0 ? '' : 'border-secondary'; ?>">
                <div class="position-relative overflow-hidden">
                    <img src="/assets/images/products/<?= $product['image'] ?? 'images.jpeg' ?>" 
                         class="card-img-top" 
                         alt="<?= htmlspecialchars($product['name']) ?>" 
                         style="height: 200px; object-fit: cover;">
                    
                    <!-- Sale Badge -->
                    <?php if ($isSale): ?>
                    <span class="badge bg-danger position-absolute top-2 end-2 m-2">Giảm giá</span>
                    <?php endif; ?>
                    
                    <!-- Stock Badge -->
                    <div class="position-absolute bottom-0 start-0 m-2">
                        <?php if ($stock > 0): ?>
                        <span class="badge bg-success">✓ Còn <?= $stock ?></span>
                        <?php else: ?>
                        <span class="badge bg-secondary">Hết hàng</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card-body p-3">
                    <h5 class="card-title fw-bold small" style="min-height: 48px;">
                        <?= htmlspecialchars($product['name']) ?>
                    </h5>
                    
                    <div class="mb-2">
                        <?php if ($isSale): ?>
                        <div class="text-muted text-decoration-line-through small">
                            <?= number_format((float)$product['price'], 0, ',', '.') ?> ₫
                        </div>
                        <?php endif; ?>
                        <div class="price fw-bold text-danger fs-6">
                            <?= number_format($displayPrice, 0, ',', '.') ?> ₫
                        </div>
                    </div>
                    
                    <a href="/products/<?= (int)$product['id'] ?>" 
                       class="btn btn-dark w-100 small mt-auto">
                        <?= $stock > 0 ? 'Xem chi tiết' : 'Xem sản phẩm' ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
