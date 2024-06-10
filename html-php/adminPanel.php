<?php
session_start(); // Oturumu başlat

// Çıkış işlemi
if (isset($_GET['logout'])) {
    session_destroy(); 
    unset($_SESSION['loggedin']); 
    header("Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/admin.php"); 
    exit;
}

// Giriş kontrolü
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $displayLogin = 'none';
    $displayAdmin = 'block';
} else {
    $displayLogin = 'block';
    $displayAdmin = 'none';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === '123') {
        $_SESSION['loggedin'] = true; 
        header("Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/adminPanel.php"); 
        exit;
    } else {
        $error = "Geçersiz kullanıcı adı veya şifre"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/adminPanel.css">
</head>
<body>
    <div class="admin-container" id="adminContainer" style="display: <?= $displayAdmin ?>;">
        <h1>Admin Panel</h1>
        <div class="admin-Ekle">
            <ul>
                <li class="add-film"><a href="adminFilm.php">Film Ekle</a></li>
                <li class="add-film"><a href="adminOyuncu.php">Oyuncu Ekle</a></li>
                <li class="add-film"><a href="adminYonetmen.php">Yönetmen Ekle</a></li>
                <li class="add-film"><a href="adminKategori.php">Kategori Ekle</a></li>
                <li class="add-film"><a href="admin.php?logout=true">Çıkış Yap</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
