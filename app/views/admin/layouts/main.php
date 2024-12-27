<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background: #343a40;
            width: 240px;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 1rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,.1);
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,.2);
        }
        .main-content {
            margin-left: 240px;
            padding: 2rem;
        }
        .admin-header {
            background: white;
            padding: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            border-radius: 0.5rem;
        }
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-sticky">
            <div class="text-center text-white mb-4 p-3">
                <i class="bi bi-person-circle display-6"></i>
                <div class="mt-2 fw-bold"><?= htmlspecialchars($_SESSION['user_name']) ?></div>
                <div class="small text-white-50">Admin Panel</div>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $content == 'app/views/admin/dashboard.php' ? 'active' : '' ?>" href="/admin">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $content == 'app/views/admin/products.php' ? 'active' : '' ?>" href="/admin/products">
                        <i class="bi bi-grid"></i>
                        Ürünler
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $content == 'app/views/admin/orders.php' ? 'active' : '' ?>" href="/admin/orders">
                        <i class="bi bi-cart"></i>
                        Siparişler
                    </a>
                </li>
                <li class="nav-item mt-auto">
                    <a class="nav-link text-danger" href="/auth/logout">
                        <i class="bi bi-box-arrow-right"></i>
                        Çıkış Yap
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Ana içerik -->
    <main class="main-content">
        <div class="admin-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <?php
                if($content == 'app/views/admin/dashboard.php') echo 'Dashboard';
                elseif($content == 'app/views/admin/products.php') echo 'Ürünler';
                elseif($content == 'app/views/admin/orders.php') echo 'Siparişler';
                ?>
            </h4>
            <div>
                <?php if($content == 'app/views/admin/products.php'): ?>
                    <a href="/admin/products/add" class="btn btn-success">
                        <i class="bi bi-plus-lg"></i> Yeni Ürün Ekle
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php 
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
        
        <?php include $content; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Alert mesajlarını otomatik kapatma
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });
    </script>
</body>
</html> 