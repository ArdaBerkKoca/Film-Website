<?php
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yonetmenAdi = $_POST['yonetmenAdi'];

    $stmt = $conn->prepare("INSERT INTO yonetmenler (YonetmenAdi) VALUES (?)");
    $stmt->bind_param("s", $yonetmenAdi);

    if ($stmt->execute()) {
        echo "Yönetmen başarıyla eklendi.";
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
    <title>Yönetmen Ekle</title>
    <link rel="stylesheet" href="../css/adminPanel.css">
</head>
<body>
    <div class="admin-container">
        <h1>Yönetmen Ekle</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="yonetmenAdi">Yönetmen Adı:</label>
                <input type="text" id="yonetmenAdi" name="yonetmenAdi" required>
            </div>
            <button type="submit">Ekle</button>
        </form>
    </div>
</body>
</html>
