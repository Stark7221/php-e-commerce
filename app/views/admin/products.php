<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Ürün Listesi</h5>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-lg"></i> Yeni Ürün Ekle
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Resim</th>
                        <th>Ürün Adı</th>
                        <th>Açıklama</th>
                        <th>Fiyat</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($product = $products->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td>
                                <img src="/public/images/products/<?= $product['image'] ?>" 
                                     alt="<?= $product['name'] ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars(substr($product['description'], 0, 50)) ?>...</td>
                            <td><?= number_format($product['price'], 2) ?> TL</td>
                            <td><?= date('d.m.Y H:i', strtotime($product['created_at'])) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="/admin/products/edit/<?= $product['id'] ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="deleteProduct(<?= $product['id'] ?>, '<?= htmlspecialchars($product['name']) ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Ürün Ekleme Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Ürün Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" action="/admin/products/add" method="POST" enctype="multipart/form-data">
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
                        <small class="text-muted">Desteklenen formatlar: JPG, JPEG, PNG, GIF</small>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary">Ürün Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteProduct(id, name) {
    if(confirm(`"${name}" adlı ürünü silmek istediğinizden emin misiniz?`)) {
        try {
            window.location.href = `/admin/products/delete/${id}`;
        } catch (error) {
            alert('Silme işlemi sırasında bir hata oluştu!');
        }
    }
}

// Form submit edildiğinde loading göster
document.getElementById('addProductForm').addEventListener('submit', function() {
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Ekleniyor...';
});

// Modal kapandığında formu sıfırla
const addProductModal = document.getElementById('addProductModal');
addProductModal.addEventListener('hidden.bs.modal', function () {
    document.getElementById('addProductForm').reset();
    const submitButton = document.querySelector('#addProductForm button[type="submit"]');
    submitButton.disabled = false;
    submitButton.innerHTML = 'Ürün Ekle';
});
</script>

<style>
.table img {
    transition: transform 0.2s;
}
.table img:hover {
    transform: scale(3);
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
}
.btn-group {
    gap: 0.25rem;
}
</style> 