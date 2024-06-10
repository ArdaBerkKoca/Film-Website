<?php
// dbFilmler.php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "12345678";
$DB_NAME = "film_database";

// Veritabanı bağlantısını yap
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Film bilgilerini getirme fonksiyonu
function getFilmByTitle($title) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Filmler WHERE Baslik = ?");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;  // Film bulunamadı
    }
}

// Veritabanı bağlantısını kapat
function closeDbConnection() {
    global $conn;
    $conn->close();
}
?>
