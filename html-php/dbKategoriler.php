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

// Kategoriler tablosundan kategorileri sorgula
$sql = "SELECT KategoriID, KategoriAdi FROM Kategoriler";
$result = $conn->query($sql);

$kategoriler = array();


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $kategoriler[] = $row;
    }
}

// Veritabanı bağlantısını kapat
$conn->close();
?>
