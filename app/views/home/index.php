<!-- Hero Section -->
<div class="hero-section text-center py-5 mb-5 bg-light rounded shadow-sm position-relative overflow-hidden">
    <!-- Animasyonlu Arka Plan -->
    <div class="sliding-background">
        <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1610348725531-843dff563e2c?q=80')"></div>
        <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1573246123716-6b1782bfc499?q=80')"></div>
        <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1610832958506-aa56368176cf?q=80')"></div>
        <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1597362925123-77861d3fbac7?q=80')"></div>
    </div>

    <!-- İçerik -->
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-4 fw-bold mb-4" style="color: #fff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Taze ve Doğal Ürünler</h1>
        <p class="lead mb-4" style="color: #fff; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">En taze tarım ürünleri, en uygun fiyatlarla kapınıza kadar geliyor!</p>
        <?php if(!isset($_SESSION['user_id'])): ?>
            <div class="mb-4">
                <a class="btn btn-lg px-4 me-2" style="background: var(--gradient-primary); color: white;" href="auth/login">Giriş Yap</a>
                <a class="btn btn-lg px-4" style="background: var(--gradient-secondary); color: white;" href="auth/register">Kayıt Ol</a>
            </div>
        <?php else: ?>
            <div class="mb-4">
                <p class="h5 mb-3" style="color: #fff; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Hoş geldiniz, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>
                <a class="btn btn-lg px-4" style="background: var(--gradient-secondary); color: white;" href="product">Ürünleri Keşfet</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Features Section -->
<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon bg-success bg-gradient text-white mb-3 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-truck fs-4"></i>
                    </div>
                    <h3 class="h5 mb-3">Hızlı Teslimat</h3>
                    <p class="text-muted mb-0">Siparişleriniz aynı gün içinde hazırlanıp en kısa sürede kapınıza teslim edilir.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon bg-success bg-gradient text-white mb-3 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <h3 class="h5 mb-3">Kalite Garantisi</h3>
                    <p class="text-muted mb-0">Tüm ürünlerimiz özenle seçilir ve kalite kontrolünden geçirilir.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon bg-success bg-gradient text-white mb-3 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-heart fs-4"></i>
                    </div>
                    <h3 class="h5 mb-3">Müşteri Memnuniyeti</h3>
                    <p class="text-muted mb-0">Mutlu müşteriler için her zaman en iyi hizmeti sunmaya çalışıyoruz.</p>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- CSS ekleyin -->
<style>
.hero-section {
    min-height: 500px;
    background: rgba(0,0,0,0.3);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sliding-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.slide-item {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    animation: slideAnimation 20s infinite;
    opacity: 0;
    transform: scale(1.1);
}

.slide-item:nth-child(1) {
    animation-delay: 0s;
}

.slide-item:nth-child(2) {
    animation-delay: 5s;
}

.slide-item:nth-child(3) {
    animation-delay: 10s;
}

.slide-item:nth-child(4) {
    animation-delay: 15s;
}

@keyframes slideAnimation {
    0% {
        opacity: 0;
        transform: scale(1.1) rotate(-5deg);
    }
    5% {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }
    20% {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }
    25% {
        opacity: 0;
        transform: scale(1.1) rotate(5deg);
    }
    100% {
        opacity: 0;
        transform: scale(1.1) rotate(5deg);
    }
}

.category-card {
    transition: transform 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-5px);
}

.category-overlay {
    transition: background-color 0.3s ease;
}

.category-card:hover .category-overlay {
    background-color: rgba(0,0,0,0.3) !important;
}

.feature-icon {
    transition: transform 0.3s ease;
}

.card:hover .feature-icon {
    transform: scale(1.1);
}
</style> 