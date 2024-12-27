<?php
class AdminController {
    private $db;
    private $product;

    public function __construct() {
        // Admin kontrolü
        if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
            $_SESSION['message'] = "Bu sayfaya erişim yetkiniz yok!";
            $_SESSION['message_type'] = "danger";
            header("Location: /");
            exit;
        }
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    public function index() {
        $content = 'app/views/admin/dashboard.php';
        require_once 'app/views/admin/layouts/main.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $query = "SELECT * FROM admins WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($admin = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['name'];
                    header("Location: /admin");
                    exit;
                }
            }
            
            $_SESSION['message'] = "Geçersiz e-posta veya şifre!";
            $_SESSION['message_type'] = "danger";
        }
        require_once 'app/views/admin/login.php';
    }

    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        header("Location: /admin/login");
        exit;
    }

    public function products() {
        $products = $this->product->getAll();
        $content = 'app/views/admin/products.php';
        require_once 'app/views/admin/layouts/main.php';
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Form verilerini kontrol edilyor
                if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price'])) {
                    throw new Exception("Lütfen tüm alanları doldurun.");
                }

                // Resim kontrolü
                if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception("Lütfen bir resim seçin.");
                }

                // Ürünü oluşturma
                if ($this->product->create($_POST)) {
                    $_SESSION['message'] = "Ürün başarıyla eklendi.";
                    $_SESSION['message_type'] = "success";
                }
            } catch (Exception $e) {
                $_SESSION['message'] = $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }

            header("Location: /admin/products");
            exit;
        }
    }

    public function editProduct($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Form verilerini kontrol et
                if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price'])) {
                    throw new Exception("Lütfen tüm alanları doldurun.");
                }

                if ($this->product->update($id, $_POST)) {
                    $_SESSION['message'] = "Ürün başarıyla güncellendi.";
                    $_SESSION['message_type'] = "success";
                } else {
                    throw new Exception("Ürün güncellenirken bir hata oluştu.");
                }
            } catch (Exception $e) {
                $_SESSION['message'] = $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
            header("Location: /admin/products");
            exit;
        }

        // Ürün bilgilerini getirme
        $product = $this->product->getById($id);
        if (!$product) {
            $_SESSION['message'] = "Ürün bulunamadı.";
            $_SESSION['message_type'] = "danger";
            header("Location: /admin/products");
            exit;
        }

        $content = 'app/views/admin/edit-product.php';
        require_once 'app/views/admin/layouts/main.php';
    }

    public function deleteProduct($id) {
        try {
            if (!$id) {
                throw new Exception("Geçersiz ürün ID'si");
            }

            if ($this->product->delete($id)) {
                $_SESSION['message'] = "Ürün başarıyla silindi.";
                $_SESSION['message_type'] = "success";
            } else {
                throw new Exception("Ürün silinirken bir hata oluştu.");
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_type'] = "danger";
        }

        header("Location: /admin/products");
        exit;
    }

    public function orders() {
        // Siparişleri listeleme
        $query = "SELECT o.*, u.name as user_name FROM orders o 
                 JOIN users u ON o.user_id = u.id 
                 ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $content = 'app/views/admin/orders.php';
        require_once 'app/views/admin/layouts/main.php';
    }

    public function updateOrderStatus() {
        try {
            // Debug için
            error_log('updateOrderStatus çağrıldı');
            error_log('POST data: ' . file_get_contents('php://input'));

            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['orderId']) || !isset($data['status'])) {
                throw new Exception('Geçersiz veri: orderId veya status eksik');
            }

            // SQL sorgusunu debug et
            $query = "UPDATE orders SET status = :status WHERE id = :id";
            error_log('SQL Query: ' . $query);
            error_log('orderId: ' . $data['orderId']);
            error_log('status: ' . $data['status']);

            $stmt = $this->db->prepare($query);
            $params = [
                ':status' => $data['status'],
                ':id' => $data['orderId']
            ];

            $result = $stmt->execute($params);

            if ($result) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Durum güncellendi'
                ]);
            } else {
                error_log('SQL Error: ' . print_r($stmt->errorInfo(), true));
                throw new Exception('Güncelleme başarısız: ' . implode(', ', $stmt->errorInfo()));
            }
        } catch (Exception $e) {
            error_log('Error in updateOrderStatus: ' . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function getOrderDetails($id) {
        try {
            // Sipariş detaylarını alma
            $query = "SELECT oi.*, p.name, p.description, p.price 
                     FROM order_items oi 
                     JOIN products p ON oi.product_id = p.id 
                     WHERE oi.order_id = :id";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Sipariş bilgilerini alma
            $query = "SELECT o.*, u.name as user_name 
                     FROM orders o 
                     JOIN users u ON o.user_id = u.id 
                     WHERE o.id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            
            header('Content-Type: application/json');
            echo json_encode([
                'items' => $items,
                'order' => $order,
                'note' => $order['note'] ?? null
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
} 