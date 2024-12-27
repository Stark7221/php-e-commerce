<?php
class Database {
    private $host = "localhost";
    private $db_name = "tarim_eticaret";
    private $username = "root";
    private $password = "Serhat7221.";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "Bağlantı hatası: " . $e->getMessage();
        }
        return $this->conn;
    }
} 