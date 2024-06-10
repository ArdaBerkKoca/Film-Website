<?php
session_start();
require_once 'dbConfig.php';

// Kullanıcının giriş yapıp yapmadığını kontrol et
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/login.php'); // Giriş yapılmamışsa login sayfasına yönlendir
    exit();
}

$userId = $_SESSION['user_id']; // Oturumda saklanan kullanıcı ID'si

// Kullanıcı bilgilerini al
$sql = "SELECT KullaniciAdi, Email FROM kullanicilar WHERE KullaniciID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // Kullanıcı bilgisi alınamazsa hata mesajı
    echo 'Kullanıcı bilgileri alınamadı.';
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width= , initial-scale=1.0" />
    <title>Film Sitesi</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="../css/filmler.css" />
  </head>
  <body>
    <!--! NAVBAR START -->
    <div class="navbar">
      <div class="navbar-wrapper">
        <div class="logo-wrapper">
        <a href="index.php"><h1 class="logo">Movie2You</h1></a> 
        </div>
        <div class="menu-container">
          <ul class="menu-list">
            <li class="menu-list-item active"><a href="index.php">Ana Sayfa</a></li>
            <li class="menu-list-item"><a href="filmler.php">Filmler</a></li>
            <li class="menu-list-item"><a href="Listem.php">Listem</a></li>
          </ul>
        </div>
        <div class="profile-container">
          <div class="profile-text-container">
          <a href="hesabim.php">Hesabım</a>
          </div>
          <a href="logout.php">Çıkış Yap</a>
          <div class="toggle">
            <i class="bi bi-moon-fill toggle-icon"></i>
            <i class="bi bi-brightness-high-fill toggle-icon"></i>
            <div class="toggle-ball"></div>
          </div>
        </div>
      </div>
    </div>
    <!--! NAVBAR END -->

    <!--! SİDEBAR START -->
    <div class="sidebar">
      <a href="index.php"><i class="bi bi-house-door-fill"></i></a>
      <a href="commentindex.php"><i class="bi bi-people-fill"></i></a>
      <a href="Listem.php"><i class="bi bi-bookmarks-fill"></i></a>
    </div>
    <!--! SİDEBAR END -->