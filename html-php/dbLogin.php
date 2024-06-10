<?php
session_start(); // Oturumu başlat
$DB_HOST_NAME = "localhost";
$DB_USER_NAME = "root";
$DB_PASSWORD = "12345678";
$DB_NAME = "ardaberk";
$conn = new mysqli($DB_HOST_NAME, $DB_USER_NAME, $DB_PASSWORD, $DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Post verileri alınıyor ve SQL Injection önlemi için temizleniyor
$userEmail = $conn->real_escape_string($_POST['email']);
$userPassword = $conn->real_escape_string($_POST['password']);

$sql = "SELECT KullaniciID, Email, TelefonNo, Sifre FROM kullanicilar WHERE Email = '$userEmail' OR TelefonNo = '$userEmail'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (password_verify($userPassword, $row["Sifre"])) {
            $_SESSION['user_logged_in'] = true; // Kullanıcı giriş yaptı
            $_SESSION['user_id'] = $row["KullaniciID"]; // Kullanıcı ID'sini session'a kaydet
            echo '<script type="text/javascript"> window.location.href = "http://localhost/Muhendislik-Projesi-3-Proje/html-php/index.php" </script>';
            return;
        }
    }
    // Eğer şifre doğrulanamazsa
    echo '<script type="text/javascript"> window.location.href = "http://localhost/Muhendislik-Projesi-3-Proje/html-php/login.php?error=1" </script>';
} else {
    // Eğer kullanıcı bulunamazsa
    echo '<script type="text/javascript"> window.location.href = "http://localhost/Muhendislik-Projesi-3-Proje/html-php/login.php?error=1" </script>';
}

$conn->close();
?>
