<?php
class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Debug için
            var_dump($email, $password);
            
            if ($user = $this->user->login($email, $password)) {
                // Debug için
                var_dump($user);
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['isAdmin'] = $user['isAdmin'];
                $_SESSION['message'] = "Başarıyla giriş yaptınız!";
                $_SESSION['message_type'] = "success";
                
                if($user['isAdmin']) {
                    header("Location: /admin");
                } else {
                    header("Location: /product");
                }
                exit;
            } else {
                $_SESSION['message'] = "Geçersiz e-posta veya şifre!";
                $_SESSION['message_type'] = "danger";
            }
        }
        $content = 'app/views/auth/login.php';
        require_once 'app/views/layouts/main.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->name = $_POST['name'] ?? '';
            $this->user->email = $_POST['email'] ?? '';
            $this->user->password = $_POST['password'] ?? '';

            if ($this->user->create()) {
                $_SESSION['message'] = "Kayıt başarıyla oluşturuldu. Giriş yapabilirsiniz.";
                $_SESSION['message_type'] = "success";
                header("Location: login");
                exit;
            } else {
                $_SESSION['message'] = "Kayıt oluşturulurken bir hata oluştu!";
                $_SESSION['message_type'] = "danger";
            }
        }
        $content = 'app/views/auth/register.php';
        require_once 'app/views/layouts/main.php';
    }

    public function logout() {
        session_destroy();
        header("Location: login");
        exit;
    }
} 