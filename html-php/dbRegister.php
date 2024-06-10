<?php
$DB_HOST_NAME = "localhost";
$DB_USER_NAME = "root";
$DB_PASSWORD = "12345678";
$DB_NAME = "ardaberk";
$conn = new mysqli($DB_HOST_NAME, $DB_USER_NAME, $DB_PASSWORD, $DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userName = $_POST['username'];
$userPassword = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];
$userEmail = $_POST['email'];
$phoneNumber = $_POST['phone'];

// Kullanıcının şifreleri uyuşuyor mu diye kontrol et
if ($userPassword != $confirmPassword) {
    header('Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/register.php?temp=1');
    exit;
}

// Email ve telefon numarasının zaten kullanılıp kullanılmadığını kontrol et
$checkQuery = $conn->prepare("SELECT * FROM kullanicilar WHERE Email = ? OR TelefonNo = ?");
$checkQuery->bind_param("ss", $userEmail, $phoneNumber);
$checkQuery->execute();
$result = $checkQuery->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['Email'] == $userEmail) {
            header('Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/register.php?temp=2');
            exit;
        }
        if ($row['TelefonNo'] == $phoneNumber) {
            header('Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/register.php?temp=3');
            exit;
        }
    }
}
$checkQuery->close();

// Parolayı hash'le ve kullanıcıyı veritabanına ekle
$hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO kullanicilar (KullaniciAdi, Sifre, Email, TelefonNo) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $userName, $hashedPassword, $userEmail, $phoneNumber);

if ($stmt->execute()) {
    header('Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/login.php');
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
