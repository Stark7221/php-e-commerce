<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Yeni Ürün Ekle</h5>
    </div>
    <div class="card-body">
        <form action="/admin/products/add" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Ürün Adı</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Açıklama</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Fiyat (TL)</label>
                <input type="number" class="form-control" name="price" step="0.01" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ürün Resmi</label>
                <input type="file" class="form-control" name="image" accept="image/*" required>
                <small class="text-muted">Önerilen boyut: 800x600 piksel</small>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/products" class="btn btn-secondary">İptal</a>
                <button type="submit" class="btn btn-primary">Ürün Ekle</button>
            </div>
        </form>
    </div>
</div>

<style>
.card {
    max-width: 800px;
    margin: 0 auto;
}
</style> 