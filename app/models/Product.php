<?php
class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($data) {
        try {
            $image = '';
            // Resim yükleme işlemi
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/images/products/';
                
                // Dizin yoksa oluştur
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Resim türü kontrolü
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                
                if (!in_array($imageFileType, $allowedTypes)) {
                    throw new Exception("Sadece JPG, JPEG, PNG & GIF dosyaları yüklenebilir.");
                }

                // Benzersiz dosya adı oluştur
                $image = uniqid() . '.' . $imageFileType;
                $uploadFile = $uploadDir . $image;

                // Resmi yükle
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    throw new Exception("Resim yüklenirken bir hata oluştu.");
                }
            }

            // Veritabanına kaydet
            $query = "INSERT INTO products (name, description, price, image) VALUES (:name, :description, :price, :image)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":price", $data['price']);
            $stmt->bindParam(":image", $image);

            if (!$stmt->execute()) {
                // Resim yüklendiyse ve veritabanı kaydı başarısız olduysa resmi sil
                if ($image && file_exists($uploadDir . $image)) {
                    unlink($uploadDir . $image);
                }
                throw new Exception("Ürün kaydedilirken bir hata oluştu.");
            }

            return true;

        } catch(Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function delete($id) {
        try {
            // Önce ürünün bilgilerini al (resim adını almak için)
            $query = "SELECT image FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // Ürünü veritabanından sil
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);

            if($stmt->execute()) {
                // Ürün başarıyla silindiyse ve resim varsa, resmi de sil
                if($product && $product['image']) {
                    $imagePath = 'public/images/products/' . $product['image'];
                    if(file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                return true;
            }
            return false;

        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        try {
            $image = '';
            $currentProduct = $this->getById($id);
            
            // Resim yükleme işlemi
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/images/products/';
                
                // Dizin kontrolü
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Resim türü kontrolü
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                
                if (!in_array($imageFileType, $allowedTypes)) {
                    throw new Exception("Sadece JPG, JPEG, PNG & GIF dosyaları yüklenebilir.");
                }

                // Benzersiz dosya adı oluştur
                $image = uniqid() . '.' . $imageFileType;
                $uploadFile = $uploadDir . $image;

                // Resmi yükle
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Eski resmi sil
                    if($currentProduct['image'] && file_exists($uploadDir . $currentProduct['image'])) {
                        unlink($uploadDir . $currentProduct['image']);
                    }
                } else {
                    throw new Exception("Resim yüklenirken bir hata oluştu.");
                }
            }

            // Veritabanını güncelle
            $query = "UPDATE " . $this->table_name . " SET 
                    name = :name, 
                    description = :description, 
                    price = :price" . 
                    ($image ? ", image = :image" : "") . 
                    " WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":description", $data['description']);
            $stmt->bindParam(":price", $data['price']);
            $stmt->bindParam(":id", $id);
            
            if($image) {
                $stmt->bindParam(":image", $image);
            }

            return $stmt->execute();

        } catch(Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
} 