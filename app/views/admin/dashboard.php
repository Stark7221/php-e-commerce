<div class="row g-4">
    <!-- İstatistik Kartları -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-muted">Toplam Ürün</h6>
                        <h2 class="card-title mb-0">
                            <?php
                            $stmt = $this->db->query("SELECT COUNT(*) as total FROM products");
                            echo $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                            ?>
                        </h2>
                    </div>
                    <div class="fs-1 text-success">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-muted">Toplam Sipariş</h6>
                        <h2 class="card-title mb-0">
                            <?php
                            $stmt = $this->db->query("SELECT COUNT(*) as total FROM orders");
                            echo $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                            ?>
                        </h2>
                    </div>
                    <div class="fs-1 text-primary">
                        <i class="bi bi-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 text-muted">Toplam Kullanıcı</h6>
                        <h2 class="card-title mb-0">
                            <?php
                            $stmt = $this->db->query("SELECT COUNT(*) as total FROM users");
                            echo $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                            ?>
                        </h2>
                    </div>
                    <div class="fs-1 text-info">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Son Siparişler -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Son Siparişler</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sipariş ID</th>
                                <th>Müşteri</th>
                                <th>Tutar</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $this->db->query("SELECT o.*, u.name as user_name 
                                                     FROM orders o 
                                                     JOIN users u ON o.user_id = u.id 
                                                     ORDER BY o.created_at DESC LIMIT 5");
                            while ($order = $stmt->fetch(PDO::FETCH_ASSOC)):
                            ?>
                            <tr>
                                <td>#<?= $order['id'] ?></td>
                                <td><?= htmlspecialchars($order['user_name']) ?></td>
                                <td><?= number_format($order['total_amount'], 2) ?> TL</td>
                                <td>
                                    <span class="badge bg-<?= $order['status'] == 'Beklemede' ? 'warning' : 
                                                          ($order['status'] == 'Tamamlandı' ? 'success' : 'info') ?>">
                                        <?= $order['status'] ?>
                                    </span>
                                </td>
                                <td><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> 