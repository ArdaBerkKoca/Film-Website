<?php
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kategoriAdi = $_POST['kategoriAdi'];

    $stmt = $conn->prepare("INSERT INTO kategoriler (KategoriAdi) VALUES (?)");
    $stmt->bind_param("s", $kategoriAdi);

    if ($stmt->execute()) {
        echo "Kategori başarıyla eklendi.";
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
    <title>Kategori Ekle</title>
    <link rel="stylesheet" href="../css/adminPanel.css">
</head>
<body>
    <div class="admin-container">
        <h1>Kategori Ekle</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="kategoriAdi">Kategori Adı:</label>
                <input type="text" id="kategoriAdi" name="kategoriAdi" required>
            </div>
            <button type="submit">Ekle</button>
        </form>
    </div>
</body>
</html>
