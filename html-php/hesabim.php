<?php
session_start();
require_once 'dbConfig.php';

if (!isset($_SESSION['user_logged_in']) || !isset($_SESSION['user_id'])) {
    header('Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Kullanıcı bilgilerini al
$sql = "SELECT KullaniciAdi, Email, TelefonNo FROM kullanicilar WHERE KullaniciID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo 'Kullanıcı bilgileri alınamadı.';
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesabım</title>
    <link rel="stylesheet" href="../css/hesabim.css">
</head>
<body>
    <div class="container">
        <h1>Hesabım</h1>
        <div class="profile-info">
            <label>Adı Soyadı:</label>
            <p><?php echo htmlspecialchars($user['KullaniciAdi']); ?></p>
        </div>
        <div class="profile-info">
            <label>E-posta:</label>
            <p><?php echo htmlspecialchars($user['Email']); ?></p>
        </div>
        <div class="profile-info">
            <label>Telefon Numarası:</label>
            <p><?php echo htmlspecialchars($user['TelefonNo']); ?></p>
        </div>
        <a href="sifreGuncelle.php">Şifre Güncelle</a>
        <a href="index.php">Ana Sayfa'ya Dön</a>
        
    </div>
</body>
</html>
