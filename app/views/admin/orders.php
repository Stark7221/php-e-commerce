<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sipariş ID</th>
                        <th>Müşteri</th>
                        <th>Telefon</th>
                        <th>Adres</th>
                        <th>Toplam Tutar</th>
                        <th>Durum</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($order['user_name']) ?></td>
                            <td><?= htmlspecialchars($order['phone']) ?></td>
                            <td>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-secondary" 
                                        onclick="showAddress('<?= htmlspecialchars($order['address']) ?>')">
                                    <i class="bi bi-geo-alt me-1"></i>Adresi Göster
                                </button>
                            </td>
                            <td><?= number_format($order['total_amount'], 2) ?> TL</td>
                            <td>
                                <select class="form-select form-select-sm status-select" 
                                        data-order-id="<?= $order['id'] ?>"
                                        style="width: 150px;">
                                    <option value="Beklemede" <?= $order['status'] == 'Beklemede' ? 'selected' : '' ?>>Beklemede</option>
                                    <option value="Onaylandı" <?= $order['status'] == 'Onaylandı' ? 'selected' : '' ?>>Onaylandı</option>
                                    <option value="Hazırlanıyor" <?= $order['status'] == 'Hazırlanıyor' ? 'selected' : '' ?>>Hazırlanıyor</option>
                                    <option value="Yolda" <?= $order['status'] == 'Yolda' ? 'selected' : '' ?>>Yolda</option>
                                    <option value="Tamamlandı" <?= $order['status'] == 'Tamamlandı' ? 'selected' : '' ?>>Tamamlandı</option>
                                    <option value="İptal" <?= $order['status'] == 'İptal' ? 'selected' : '' ?>>İptal</option>
                                </select>
                            </td>
                            <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                            <td>
                                <button type="button" 
                                        class="btn btn-sm btn-info"
                                        onclick="showOrderDetails(<?= $order['id'] ?>)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Sipariş Detay Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sipariş Detayı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="orderDetailContent"></div>
            </div>
        </div>
    </div>
</div>

<!-- Adres Modal -->
<div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teslimat Adresi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="addressText" style="white-space: pre-wrap;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<script>
// Tooltip'leri aktifleştir
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

// Sipariş durumu değiştiğinde
document.querySelectorAll('.status-select').forEach(select => {
    select.setAttribute('data-original-status', select.value);
    
    select.addEventListener('change', async function() {
        if (!confirm('Sipariş durumunu güncellemek istediğinize emin misiniz?')) {
            this.value = this.getAttribute('data-original-status');
            return;
        }

        const orderId = this.dataset.orderId;
        const status = this.value;
        const originalStatus = this.getAttribute('data-original-status');
        
        try {
            const response = await fetch('/admin/orders/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ orderId, status })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            console.log('Sunucu yanıtı:', result);
            
            if(result.success) {
                alert('Sipariş durumu başarıyla güncellendi!');
                this.setAttribute('data-original-status', status);
                
                const row = this.closest('tr');
                row.className = '';
                if(status === 'Tamamlandı') {
                    row.classList.add('table-success');
                } else if(status === 'İptal') {
                    row.classList.add('table-danger');
                } else if(status === 'Yolda') {
                    row.classList.add('table-info');
                }
            } else {
                throw new Error(result.error || 'Güncelleme başarısız');
            }
        } catch (error) {
            console.error('Hata:', error);
            this.value = originalStatus;
            alert('Durum güncellenirken bir hata oluştu: ' + error.message);
        }
    });
});

// Sipariş detaylarını göster
async function showOrderDetails(orderId) {
    try {
        const response = await fetch(`/admin/orders/details/${orderId}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        
        if (result.error) {
            throw new Error(result.error);
        }

        let html = `
            <div class="mb-3">
                <h6 class="border-bottom pb-2">Sipariş Bilgileri</h6>
                <p><strong>Müşteri:</strong> ${result.order.user_name}</p>
                <p><strong>Durum:</strong> ${result.order.status}</p>
                <p><strong>Tarih:</strong> ${new Date(result.order.created_at).toLocaleString('tr-TR')}</p>
            </div>
            <div class="mb-3">
                <h6 class="border-bottom pb-2">Ürünler</h6>
                <div class="list-group">
        `;
        
        result.items.forEach(item => {
            html += `
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">${item.name}</h6>
                            <small class="text-muted">${item.quantity} adet x ${parseFloat(item.price).toFixed(2)} TL</small>
                        </div>
                        <strong>${(item.quantity * item.price).toFixed(2)} TL</strong>
                    </div>
                </div>
            `;
        });
        
        html += `</div></div>`;

        if (result.note) {
            html += `
                <div class="mb-3">
                    <h6 class="border-bottom pb-2">Sipariş Notu</h6>
                    <div class="alert alert-info">
                        ${result.note}
                    </div>
                </div>
            `;
        }

        const total = result.items.reduce((sum, item) => sum + (item.quantity * item.price), 0);
        html += `
            <div class="border-top pt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Toplam:</h5>
                    <h5 class="text-success mb-0">${total.toFixed(2)} TL</h5>
                </div>
            </div>
        `;

        document.getElementById('orderDetailContent').innerHTML = html;
        
        const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
        modal.show();
        
    } catch (error) {
        console.error('Hata:', error);
        alert('Sipariş detayları alınırken bir hata oluştu: ' + error.message);
    }
}

// Adres gösterme fonksiyonu
function showAddress(address) {
    document.getElementById('addressText').textContent = address;
    const addressModal = new bootstrap.Modal(document.getElementById('addressModal'));
    addressModal.show();
}
</script>

<style>
.status-select {
    min-width: 140px;
}

.table-success {
    background-color: rgba(25, 135, 84, 0.1) !important;
}

.table-danger {
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.table-info {
    background-color: rgba(13, 202, 240, 0.1) !important;
}

.list-group-item {
    transition: all 0.2s;
}

.list-group-item:hover {
    background-color: rgba(0,0,0,0.02);
}

/* Adres butonu stilleri */
.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
}

#addressText {
    font-size: 1rem;
    line-height: 1.5;
    color: #333;
}
</style> 