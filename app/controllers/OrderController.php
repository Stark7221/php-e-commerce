<?php
class OrderController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Lütfen giriş yapın']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        try {
            $this->db->beginTransaction();

            // Ana sipariş kaydı
            $query = "INSERT INTO orders (user_id, phone, address, note, total_amount) 
                     VALUES (:user_id, :phone, :address, :note, :total_amount)";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':phone' => $data['phone'],
                ':address' => $data['address'],
                ':note' => $data['note'] ?? '',
                ':total_amount' => $data['total_amount']
            ]);

            $orderId = $this->db->lastInsertId();

            // Sipariş detaylarını kaydet
            $query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                     VALUES (:order_id, :product_id, :quantity, :price)";
            
            $stmt = $this->db->prepare($query);

            foreach ($data['items'] as $item) {
                $stmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['productId'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price']
                ]);
            }

            $this->db->commit();
            echo json_encode(['success' => true, 'orderId' => $orderId]);

        } catch (Exception $e) {
            $this->db->rollBack();
            http_response_code(500);
            echo json_encode(['error' => 'Sipariş kaydedilirken bir hata oluştu']);
        }
    }
} 