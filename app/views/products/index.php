<div class="products-header mb-5">
    <div class="text-center position-relative py-5">
        <div class="products-header-bg"></div>
        <h2 class="display-4 fw-bold text-white mb-3 position-relative">Taze Ürünler</h2>
        <p class="lead text-white-50 position-relative">En kaliteli tarım ürünleri sizin için özenle seçildi</p>
    </div>
</div>

<div class="container">
    <div class="row g-4">
        <?php while($product = $products->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="col-md-6 col-lg-4">
                <div class="product-card">
                    <div class="product-image">
                        <img src="/public/images/products/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                        <div class="product-overlay">
                            <div class="product-badges">
                                <span class="badge bg-success">Taze</span>
                                <span class="badge bg-primary">Organik</span>
                            </div>
                        </div>
                    </div>
                    <div class="product-content">
                        <h3 class="product-title"><?= $product['name'] ?></h3>
                        <div class="product-description"><?= $product['description'] ?></div>
                        <div class="product-price">
                            <span class="price"><?= number_format($product['price'], 2) ?> TL</span>
                            <span class="unit">/ kg</span>
                        </div>
                        <div class="product-actions">
                            <div class="quantity-control">
                                <button class="btn-quantity decrease-qty" type="button" data-product-id="<?= $product['id'] ?>">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" class="quantity-input product-qty" value="1" min="1" max="99" data-product-id="<?= $product['id'] ?>">
                                <button class="btn-quantity increase-qty" type="button" data-product-id="<?= $product['id'] ?>">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <button class="btn-add-cart add-to-cart" data-product-id="<?= $product['id'] ?>">
                                <i class="bi bi-cart-plus"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<style>
.products-header {
    position: relative;
    overflow: hidden;
    margin-top: -1.5rem;
}

.products-header-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, #4CAF50, #2196F3);
    transform: skewY(-3deg);
    transform-origin: top left;
}

.product-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.product-image {
    position: relative;
    padding-top: 75%;
    overflow: hidden;
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-badges {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.product-badges .badge {
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
    border-radius: 50px;
    backdrop-filter: blur(5px);
}

.product-content {
    padding: 1.5rem;
}

.product-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.product-description {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.product-price {
    display: flex;
    align-items: baseline;
    margin-bottom: 1.5rem;
}

.product-price .price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4CAF50;
}

.product-price .unit {
    margin-left: 0.5rem;
    color: #666;
    font-size: 0.9rem;
}

.product-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.quantity-control {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border-radius: 50px;
    padding: 0.25rem;
}

.btn-quantity {
    width: 32px;
    height: 32px;
    border: none;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4CAF50;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-quantity:hover {
    background: #4CAF50;
    color: white;
}

.quantity-input {
    width: 40px;
    border: none;
    background: transparent;
    text-align: center;
    font-weight: 600;
    color: #2c3e50;
}

.btn-add-cart {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: linear-gradient(45deg, #4CAF50, #2196F3);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-add-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

/* Animasyonlar */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-card {
    animation: fadeInUp 0.6s ease backwards;
}

.product-card:nth-child(2) {
    animation-delay: 0.2s;
}

.product-card:nth-child(3) {
    animation-delay: 0.4s;
}

/* Responsive */
@media (max-width: 768px) {
    .product-actions {
        flex-direction: column;
    }
    
    .quantity-control {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Artırma butonu
    document.querySelectorAll('.increase-qty').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const input = document.querySelector(`.product-qty[data-product-id="${productId}"]`);
            const currentValue = parseInt(input.value);
            if (currentValue < 99) {
                input.value = currentValue + 1;
            }
        });
    });

    // Azaltma butonu
    document.querySelectorAll('.decrease-qty').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const input = document.querySelector(`.product-qty[data-product-id="${productId}"]`);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });

    // Input değeri manuel değiştiğinde kontrol
    document.querySelectorAll('.product-qty').forEach(input => {
        input.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > 99) {
                this.value = 99;
            }
        });
    });
});

// Sepete Ekle butonu işlevselliği
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.productId;
        const card = this.closest('.product-card');
        const name = card.querySelector('.product-title').textContent;
        const price = parseFloat(card.querySelector('.price').textContent.replace(' TL', ''));
        const quantity = parseInt(card.querySelector('.product-qty').value);
        const image = card.querySelector('.product-image img').getAttribute('src').split('/').pop();

        addToCart(productId, name, price, quantity, image);
        showMiniCart();
    });
});
</script> 