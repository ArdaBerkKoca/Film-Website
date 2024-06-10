<?php
// Veritabanı bağlantı bilgileri
$DB_HOST_NAME = "localhost";  // Veritabanı sunucusunun adresi
$DB_USER_NAME = "root";       // Veritabanı kullanıcı adı
$DB_PASSWORD = "12345678";    // Veritabanı şifresi
$DB_NAME = "ardaberk";        // Veritabanı ismi

// Veritabanı bağlantısını oluştur
$conn = new mysqli($DB_HOST_NAME, $DB_USER_NAME, $DB_PASSWORD, $DB_NAME);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
