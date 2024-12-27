<?php
require_once 'app/config/database.php';
require_once 'app/models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$user->name = "Admin";
$user->email = "admin@admin.com";
$user->password = "admin123";
$user->isAdmin = 1;

if($user->create()) {
    echo "Admin kullanıcısı başarıyla oluşturuldu!";
} else {
    echo "Bir hata oluştu!";
} 