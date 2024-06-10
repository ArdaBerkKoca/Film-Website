<?php
session_start();
require_once 'dbConfig.php';

if (!isset($_SESSION['user_logged_in']) || !isset($_SESSION['user_id'])) {
    header('Location: http://localhost/Muhendislik-Projesi-3-Proje/html-php/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $error = "Yeni şifreler eşleşmiyor.";
    } else {
        $sql = "SELECT Sifre FROM kullanicilar WHERE KullaniciID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (password_verify($currentPassword, $user['Sifre'])) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE kullanicilar SET Sifre = ? WHERE KullaniciID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $newPasswordHash, $userId);
            $updateStmt->execute();

            $success = "Şifreniz başarıyla güncellendi.";
        } else {
            $error = "Mevcut şifre yanlış.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Güncelle</title>
    <link rel="stylesheet" href="../css/hesabim.css">
</head>
<body>
    <div class="container">
        <h1>Şifre Güncelle</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="POST" action="sifreGuncelle.php">
            <div class="profile-info">
                <label>Mevcut Şifre:</label>
                <input type="password" name="current_password" required>
            </div>
            <div class="profile-info">
                <label>Yeni Şifre:</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="profile-info">
                <label>Yeni Şifre (Tekrar):</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit">Güncelle</button>
        </form>
        <a href="hesabim.php">Hesabıma Dön</a>
    </div>
</body>
</html>
