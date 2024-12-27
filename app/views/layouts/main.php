<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarım E-Ticaret</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    /* Ana renkler */
    :root {
        --primary-color: #FF6B6B;
        --secondary-color: #4ECDC4;
        --accent-color: #45B7D1;
        --gradient-primary: linear-gradient(45deg, #FF6B6B, #FF8E53);
        --gradient-secondary: linear-gradient(45deg, #4ECDC4, #45B7D1);
    }

    /* Navbar */
    .navbar {
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    /* Butonlar */
    .btn-primary {
        background: var(--gradient-primary);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #FF8E53, #FF6B6B);
    }

    .btn-success {
        background: var(--gradient-secondary);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(45deg, #45B7D1, #4ECDC4);
    }

    /* Kartlar */
    .card {
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Badge */
    .badge.bg-danger {
        background: var(--primary-color) !important;
    }

    /* İkonlar */
    .text-success {
        color: var(--secondary-color) !important;
    }

    /* Linkler */
    a.text-success {
        color: var(--accent-color) !important;
    }

    a.text-success:hover {
        color: var(--secondary-color) !important;
    }

    /* Hero section */
    .hero-section {
        background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), 
                    url('public/images/hero-bg.jpg') center/cover no-repeat;
    }

    /* Feature ikonları */
    .feature-icon {
        background: var(--gradient-secondary) !important;
    }

    /* Input grupları */
    .input-group-text {
        border-color: #dee2e6;
    }

    .form-control:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 0.25rem rgba(78, 205, 196, 0.25);
    }

    /* Sepet badge animasyonu */
    .cart-count {
        transition: all 0.3s ease;
    }

    .cart-count.has-items {
        background: linear-gradient(45deg, #4ECDC4, #45B7D1) !important;
        transform: scale(1.2);
    }

    .mini-cart {
        position: fixed;
        right: -400px;
        bottom: 30px;
        width: 350px;
        max-height: 80vh;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 1050;
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .mini-cart.show {
        right: 30px;
    }

    .mini-cart-header {
        padding: 1rem;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .mini-cart-body {
        flex: 1;
        max-height: calc(80vh - 140px);
        overflow-y: auto;
        padding: 1rem;
    }

    .mini-cart-footer {
        padding: 1rem;
        border-top: 1px solid #eee;
    }

    .mini-cart-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .mini-cart-item:last-child {
        border-bottom: none;
    }

    .mini-cart-item-img {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
    }

    .mini-cart-item-details {
        flex: 1;
    }

    .mini-cart-item-title {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .mini-cart-item-price {
        color: #666;
        font-size: 0.9rem;
    }

    .checkout-btn {
        background: linear-gradient(45deg, #4CAF50, #2196F3);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
    }

    /* Animasyon için */
    @keyframes slideInCart {
        from { transform: translateX(100px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .mini-cart-item {
        animation: slideInCart 0.3s ease;
    }

    /* Scroll bar stilini özelleştirme */
    .mini-cart-body::-webkit-scrollbar {
        width: 6px;
    }

    .mini-cart-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .mini-cart-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .mini-cart-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Mini sepet içindeki miktar kontrolleri için stiller */
    .mini-cart-item .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0.5rem 0;
    }

    .mini-cart-item .btn-quantity {
        width: 24px;
        height: 24px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: #f8f9fa;
        border-radius: 50%;
        color: #4CAF50;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .mini-cart-item .btn-quantity:hover {
        background: #4CAF50;
        color: white;
    }

    .mini-cart-item .quantity-value {
        font-weight: 600;
        min-width: 20px;
        text-align: center;
    }

    .mini-cart-item .price-info {
        font-size: 0.85rem;
        color: #666;
    }

    .mini-cart-item-price {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .total-price {
        font-weight: 600;
        color: #4CAF50;
        margin-top: 0.25rem;
    }

    .mini-cart-header .btn-outline-danger {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .mini-cart-header .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        transform: translateY(-1px);
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(45deg, #FF6B6B, #FF8E53);">
        <div class="container">
            <a class="navbar-brand" href="<?= isset($_SESSION['user_id']) ? '/' : '/home' ?>">
                <i class="bi bi-flower1 me-2"></i>NİĞDE ÖMER HALİSDEMİR E-TİCARET
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/product">
                                <i class="bi bi-grid me-1"></i>Ürünler
                            </a>
                        </li>
                        <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin">
                                    <i class="bi bi-gear me-1"></i>Admin Panel
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['user_name']) ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/auth/logout">
                                <i class="bi bi-box-arrow-right me-1"></i>Çıkış Yap
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/auth/login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Giriş Yap
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/auth/register">
                                <i class="bi bi-person-plus me-1"></i>Kayıt Ol
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sepet Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alışveriş Sepeti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="cartItems">
                        <!-- Sepet öğeleri buraya gelecek -->
                    </div>
                    <div class="text-end mt-3">
                        <h5>Toplam: <span id="cartTotal">0.00</span> TL</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-success" id="completeOrder">Siparişi Tamamla</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sipariş Tamamlama Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Teslimat Bilgileri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm">
                        <div class="mb-3">
                            <label class="form-label">Telefon Numarası</label>
                            <input type="tel" class="form-control" name="phone" placeholder="05XX XXX XX XX" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teslimat Adresi</label>
                            <textarea class="form-control" name="address" rows="3" placeholder="Mahalle, Sokak, Bina No, Daire No, İle/İl" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sipariş Notu (İsteğe bağlı)</label>
                            <textarea class="form-control" name="note" rows="2" placeholder="Varsa özel notunuzu yazabilirsiniz"></textarea>
                        </div>
                        <div class="border rounded p-3 mb-3">
                            <h6>Sipariş Özeti</h6>
                            <div id="orderSummary"></div>
                            <hr>
                            <div class="text-end">
                                <h5>Toplam: <span id="orderTotal">0.00</span> TL</h5>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="button" class="btn btn-success" id="submitOrder">Siparişi Onayla</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mini Sepet -->
    <div class="mini-cart">
        <div class="mini-cart-header">
            <h5 class="mb-0">Sepetiniz</h5>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCart()">
                    <i class="bi bi-trash"></i> Sepeti Temizle
                </button>
                <button type="button" class="btn-close" onclick="hideMiniCart()"></button>
            </div>
        </div>
        <div class="mini-cart-body">
            <div id="miniCartItems">
                <!-- Ürünler buraya gelecek -->
            </div>
        </div>
        <div class="mini-cart-footer">
            <div class="d-flex justify-content-between mb-3">
                <strong>Toplam:</strong>
                <strong class="text-success"><span id="miniCartTotal">0.00</span> TL</strong>
            </div>
            <button class="btn w-100 checkout-btn" onclick="showCheckoutModal()">
                Siparişi Tamamla
            </button>
        </div>
    </div>

    <div class="container mt-4">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?>">
                <?= $_SESSION['message'] ?>
            </div>
            <?php 
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
        
        <?php include $content; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Sepet işlemleri için JavaScript
    let cart = [];
    
    function updateCart() {
        const miniCartItems = document.getElementById('miniCartItems');
        const cartItems = document.getElementById('cartItems');
        const miniCartTotal = document.getElementById('miniCartTotal');
        const cartTotal = document.getElementById('cartTotal');
        
        let total = 0;

        // Mini sepet içeriğini güncelle
        const cartHTML = cart.map((item, index) => {
            total += item.price * item.quantity;
            return `
                <div class="mini-cart-item">
                    <img src="/public/images/products/${item.image}" class="mini-cart-item-img" alt="${item.name}">
                    <div class="mini-cart-item-details">
                        <div class="mini-cart-item-title">${item.name}</div>
                        <div class="mini-cart-item-price">
                            <div class="quantity-control">
                                <button class="btn-quantity" onclick="decreaseCartItem(${index})">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="quantity-value">${item.quantity}</span>
                                <button class="btn-quantity" onclick="increaseCartItem(${index})">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <div class="price-info">
                                <div>${item.price.toFixed(2)} TL/adet</div>
                                <div class="total-price">Toplam: ${(item.price * item.quantity).toFixed(2)} TL</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-sm text-danger" onclick="removeFromCart(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
        }).join('');

        miniCartItems.innerHTML = cartHTML || '<div class="text-center text-muted py-3">Sepetiniz boş</div>';
        if (cartItems) {
            cartItems.innerHTML = cartHTML || '<div class="text-center text-muted">Sepetiniz boş</div>';
        }

        miniCartTotal.textContent = total.toFixed(2);
        if (cartTotal) cartTotal.textContent = total.toFixed(2);
        
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function addToCart(productId, name, price, quantity, image) {
        const existingItem = cart.find(item => item.productId === productId);
        
        if (existingItem) {
            existingItem.quantity += quantity;
        } else {
            cart.push({ productId, name, price, quantity, image });
        }
        
        updateCart();
        showMiniCart();
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCart();
    }

    function increaseCartItem(index) {
        if (cart[index].quantity < 99) {
            cart[index].quantity++;
            updateCart();
        }
    }

    function decreaseCartItem(index) {
        if (cart[index].quantity > 1) {
            cart[index].quantity--;
            updateCart();
        } else {
            removeFromCart(index);
        }
    }

    // Sayfa yüklendiğinde sepeti localStorage'dan al
    document.addEventListener('DOMContentLoaded', function() {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
            updateCart();
        }
    });

    // Siparişi tamamla butonuna tıklandığında
    document.getElementById('completeOrder').addEventListener('click', function() {
        if (cart.length === 0) {
            alert('Sepetiniz boş!');
            return;
        }

        // Sipariş özetini hazırla
        const orderSummary = document.getElementById('orderSummary');
        const orderTotal = document.getElementById('orderTotal');
        let total = 0;

        orderSummary.innerHTML = cart.map(item => {
            total += item.price * item.quantity;
            return `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="mb-0">${item.name}</h6>
                        <small class="text-muted">${item.quantity} adet x ${item.price.toFixed(2)} TL</small>
                    </div>
                    <div>${(item.price * item.quantity).toFixed(2)} TL</div>
                </div>
            `;
        }).join('');

        orderTotal.textContent = total.toFixed(2);

        // Sepet modalını kapat, sipariş modalını aç
        const cartModal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
        cartModal.hide();
        const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
        orderModal.show();
    });

    // Siparişi onayla butonuna tıklandığında
    document.getElementById('submitOrder').addEventListener('click', async function() {
        const phone = document.querySelector('input[name="phone"]').value;
        const address = document.querySelector('textarea[name="address"]').value;
        const note = document.querySelector('textarea[name="note"]').value;
        
        if (!phone || !address) {
            alert('Lütfen telefon ve adres bilgilerini doldurun.');
            return;
        }
        
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        const orderData = {
            items: cart,
            phone: phone,
            address: address,
            note: note,
            total_amount: total
        };

        try {
            const response = await fetch('/order/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderData)
            });

            const result = await response.json();

            if (result.success) {
                alert('Siparişiniz başarıyla alındı! Sipariş numaranız: ' + result.orderId);
                cart = [];
                updateCart();
                const orderModal = bootstrap.Modal.getInstance(document.getElementById('orderModal'));
                orderModal.hide();
            } else {
                alert(result.error || 'Bir hata oluştu');
            }
        } catch (error) {
            alert('Sipariş işlemi sırasında bir hata oluştu');
        }
    });

    function showMiniCart() {
        const miniCart = document.querySelector('.mini-cart');
        miniCart.classList.add('show');
    }

    function hideMiniCart() {
        document.querySelector('.mini-cart').classList.remove('show');
    }

    function showCheckoutModal() {
        hideMiniCart();
        const orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
        
        // Sipariş özetini güncelle
        const orderSummary = document.getElementById('orderSummary');
        const orderTotal = document.getElementById('orderTotal');
        let total = 0;
        
        let summaryHTML = '<div class="list-group mb-3">';
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            summaryHTML += `
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">${item.name}</h6>
                        <small class="text-muted">${item.quantity} adet x ${item.price.toFixed(2)} TL</small>
                    </div>
                    <strong>${itemTotal.toFixed(2)} TL</strong>
                </div>
            `;
        });
        summaryHTML += '</div>';
        
        orderSummary.innerHTML = summaryHTML;
        orderTotal.textContent = total.toFixed(2);
        
        orderModal.show();
    }

    function clearCart() {
        if(confirm('Sepetinizdeki tüm ürünler silinecek. Emin misiniz?')) {
            cart = [];
            updateCart();
            // Opsiyonel: Başarılı mesajı göster
            alert('Sepetiniz temizlendi!');
        }
    }
    </script>
    <script src="js/main.js"></script>
</body>
</html> 