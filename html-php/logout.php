<?php
session_start();
session_destroy();
require_once 'dbConfig.php';

echo '<div class="loading-text">Çıkış yapılıyor, lütfen bekleyiniz...</div>';
header("Refresh: 2; url=http://localhost/Muhendislik-Projesi-3-Proje/html-php/index.php");
exit();
?>
