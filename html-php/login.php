<?php
session_start();
require_once 'dbConfig.php';
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kullanıcı Giriş</title>
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <a href="index.php">
    <h1 class="logo-a">Movie2You</h1>
  </a>
  <div class="login-container">
    <div class="login-header">
      <h2>Oturum Aç</h2>
    </div>
    <?php
    if (isset($_GET['error'])) {
      echo "<div class='alert alert-danger'>
              <strong>Hata!</strong> Email, Telefon ya da Şifre Hatalı!.
             </div>";
    }
    ?>
    <br>
    <form action="dbLogin.php" method="POST">
      <div class="form-group">
        <label for="email">E-posta veya telefon numarası</label>
        <input type="text" id="email" name="email" required placeholder="E-posta veya telefon numarası girin">
      </div>
      <div class="form-group">
        <label for="password">Parola</label>
        <input type="password" id="password" name="password" required placeholder="Parola girin" minlength="3" maxlength="60">
      </div>
      <button type="submit" class="login-btn">Giriş Yap</button>
    </form>
    <div class="signup">
      <span>Hesabınız yok mu?</span>
      <a href="register.php">Şimdi kaydolun.</a>
    </div>
  </div>

</body>

</html>