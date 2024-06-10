<?php
session_start();
require_once 'dbConfig.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt ol</title>
    <link rel="stylesheet" href="../css/register.css">
</head>

<body>
    <a href="index.php">
        <h1 class="logo-a">Movie2You</h1>
    </a>
    <div class="register-container">
        <form class="register-form" action="dbRegister.php" method="POST">
            <h2>Hesap Oluştur</h2>
            <?php
            if (isset($_GET['temp'])) {
                if ($_GET['temp'] == "1") {
                    echo "
                        <div class='alert alert-danger'>
                        <strong>Hata!</strong> Şifreler Uyuşmuyor!.
                      </div>
                        ";
                } elseif ($_GET['temp'] == "2") {
                    echo "
                        <div class='alert alert-danger'>
                        <strong>Hata!</strong> Email Zaten Kayıtlı!.
                      </div>
                        ";
                } elseif ($_GET['temp'] == "3") {
                    echo "
                            <div class='alert alert-danger'>
                            <strong>Hata!</strong> Telefon Numarası Zaten Kayıtlı!.
                          </div>
                            ";
                }
            }
            ?>

            <div class="form-group">
                <label for="username">Adı Soyadı:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Şifreyi Onayla:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefon Numarası:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="5xxxxxxxxx" required>
            </div>
            <button type="submit">Kayıt ol</button>
            <div class="signup">
                <span>Hesabınız var mı?</span>
                <a href="login.php">Şimdi Giriş Yapın.</a>
            </div>
        </form>
    </div>
</body>

</html>