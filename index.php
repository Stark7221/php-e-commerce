<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'app/config/database.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Controller ve method belirleme
if(empty($url[0])) {
    // Eğer URL boşsa ve kullanıcı giriş yapmışsa ana sayfaya, yapmamışsa home'a yönlendir
    if(isset($_SESSION['user_id'])) {
        $controller = 'home';
        $method = 'index';
    } else {
        header("Location: home");
        exit;
    }
} else {
    $controller = $url[0];
    $method = isset($url[1]) ? $url[1] : 'index';
}

// Controller dosyasını yükle
$controller_name = ucfirst($controller) . 'Controller';
$controller_file = 'app/controllers/' . $controller_name . '.php';

// Model dosyalarını yükle
require_once 'app/models/User.php';
require_once 'app/models/Product.php';
// AdminController'ı yükle
require_once 'app/controllers/AdminController.php';

// Admin routes
if (strpos($url[0], 'admin') === 0) {
    if ($url[0] === 'admin' && isset($url[1])) {
        $controller = new AdminController();
        
        switch($url[1]) {
            case 'products':
                if (isset($url[2])) {
                    switch($url[2]) {
                        case 'add':
                            $controller->addProduct();
                            break;
                        case 'edit':
                            if (isset($url[3])) {
                                $controller->editProduct($url[3]);
                            }
                            break;
                        case 'delete':
                            if (isset($url[3])) {
                                $controller->deleteProduct($url[3]);
                            }
                            break;
                    }
                } else {
                    $controller->products();
                }
                break;
            case 'orders':
                if (isset($url[2])) {
                    switch($url[2]) {
                        case 'update-status':
                            $controller->updateOrderStatus();
                            break;
                        case 'details':
                            if (isset($url[3])) {
                                $controller->getOrderDetails($url[3]);
                            }
                            break;
                    }
                } else {
                    $controller->orders();
                }
                break;
            default:
                $controller->index();
                break;
        }
        exit;
    }
}

if(file_exists($controller_file)) {
    require_once $controller_file;
    $controller = new $controller_name();
    
    if(method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], array_slice($url, 2));
    } else {
        echo "Method bulunamadı: " . $method;
    }
} else {
    echo "Controller bulunamadı: " . $controller_file;
} 