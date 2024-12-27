<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Ürün Düzenle</h5>
    </div>
    <div class="card-body">
        <form action="/admin/products/edit/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Ürün Adı</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Açıklama</label>
                <textarea class="form-control" name="description" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Fiyat (TL)</label>
                <input type="number" class="form-control" name="price" step="0.01" value="<?= $product['price'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mevcut Resim</label>
                <?php if($product['image']): ?>
                    <div class="mb-2">
                        <img src="/public/images/products/<?= $product['image'] ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             style="max-width: 200px; border-radius: 5px;">
                    </div>
                <?php endif; ?>
                <label class="form-label">Yeni Resim (Opsiyonel)</label>
                <input type="file" class="form-control" name="image" accept="image/*">
                <small class="text-muted">Desteklenen formatlar: JPG, JPEG, PNG, GIF</small>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/products" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary">Değişiklikleri Kaydet</button>
            </div>
        </form>
    </div>
</div> 