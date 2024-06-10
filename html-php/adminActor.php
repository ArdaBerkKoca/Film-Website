<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../html-php/dbConfig.php'); // doğru yolu belirtelim

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adSoyad = $_POST['adSoyad'];

    $stmt = $conn->prepare("INSERT INTO oyuncular (AdSoyad) VALUES (?)");
    $stmt->bind_param("s", $adSoyad);

    if ($stmt->execute()) {
        echo "Oyuncu başarıyla eklendi.";
    } else {
        echo "Hata: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oyuncu Ekle</title>
    <link rel="stylesheet" href="../css/adminPanel.css">
</head>
<body>
    <div class="admin-container">
        <h1>Oyuncu Ekle</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="adSoyad">Ad Soyad:</label>
                <input type="text" id="adSoyad" name="adSoyad" required>
            </div>
            <button type="submit">Ekle</button>
        </form>
    </div>
</body>
</html>
