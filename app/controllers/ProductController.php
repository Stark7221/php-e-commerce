<?php
class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    public function index() {
        if(!isset($_SESSION['user_id'])) {
            $_SESSION['message'] = "Ürünleri görüntülemek için giriş yapmalısınız.";
            $_SESSION['message_type'] = "warning";
            header("Location: auth/login");
            exit;
        }

        $products = $this->product->getAll();
        $content = 'app/views/products/index.php';
        require_once 'app/views/layouts/main.php';
    }
} 