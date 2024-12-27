<div class="auth-container">
    <div class="auth-card-wrapper">
        <div class="auth-card">
            <div class="auth-card-inner">
                <!-- Sol taraf - Görsel kısım -->
                <div class="auth-image">
                    <div class="overlay"></div>
                    <div class="auth-image-content">
                        <h2>Hoş Geldiniz</h2>
                        <p>Tarım ürünlerinin en taze hali kapınızda</p>
                    </div>
                </div>
                
                <!-- Sağ taraf - Form kısmı -->
                <div class="auth-form">
                    <div class="brand-logo">
                        <i class="bi bi-flower1"></i>
                    </div>
                    <h3>Giriş Yap</h3>
                    <p class="text-muted mb-4">Hesabınıza erişin</p>
                    
                    <form method="POST" action="login">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                            <label for="email">E-posta Adresiniz</label>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Şifre" required>
                            <label for="password">Şifreniz</label>
                        </div>
                        
                        <button type="submit" class="btn w-100 auth-submit">
                            Giriş Yap
                        </button>
                    </form>
                    
                    <p class="mt-4 text-center">
                        Hesabınız yok mu? 
                        <a href="register" class="text-decoration-none">Kayıt Ol</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-container {
    min-height: calc(100vh - 76px);
    background: #f8f9fa;
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-card-wrapper {
    width: 100%;
    max-width: 900px;
}

.auth-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 0 50px rgba(0,0,0,0.1);
}

.auth-card-inner {
    display: flex;
    min-height: 550px;
}

.auth-image {
    flex: 1;
    background: url('https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?q=80') center/cover;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    color: white;
    text-align: center;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(76, 175, 80, 0.9), rgba(33, 150, 243, 0.9));
}

.auth-image-content {
    position: relative;
    z-index: 1;
}

.auth-image-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 300;
}

.auth-form {
    flex: 1;
    padding: 3rem;
    display: flex;
    flex-direction: column;
}

.brand-logo {
    width: 60px;
    height: 60px;
    background: linear-gradient(45deg, #4CAF50, #2196F3);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    margin-bottom: 2rem;
}

.auth-form h3 {
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-floating > .form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    height: calc(3.5rem + 2px);
    padding: 1rem 0.75rem;
}

.form-floating > .form-control:focus {
    border-color: #4CAF50;
    box-shadow: none;
}

.form-floating > label {
    padding: 1rem 0.75rem;
}

.auth-submit {
    background: linear-gradient(45deg, #4CAF50, #2196F3);
    border: none;
    color: white;
    padding: 0.8rem;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 500;
    margin-top: 1rem;
    transition: all 0.3s ease;
}

.auth-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

.auth-form a {
    color: #4CAF50;
    font-weight: 500;
}

@media (max-width: 768px) {
    .auth-card-inner {
        flex-direction: column;
    }
    
    .auth-image {
        min-height: 200px;
    }
    
    .auth-form {
        padding: 2rem;
    }
}
</style> 