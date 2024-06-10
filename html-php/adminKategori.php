<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin.php");
    exit;
}

require_once 'dbConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $kategoriAdi = mysqli_real_escape_string($conn, $_POST['kategoriAdi']);
        $sql = "INSERT INTO Kategoriler (KategoriAdi) VALUES ('$kategoriAdi')";
        if ($conn->query($sql) === TRUE) {
            $success = "Kategori başarıyla eklendi!";
        } else {
            $error = "Bir hata oluştu: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $kategoriID = intval($_POST['kategoriID']);
        $sql = "DELETE FROM Kategoriler WHERE KategoriID = $kategoriID";
        if ($conn->query($sql) === TRUE) {
            $success = "Kategori başarıyla silindi!";
        } else {
            $error = "Bir hata oluştu: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Ekle/Sil</title>
    <link rel="stylesheet" href="../css/adminAdd.css">
</head>
<body>
    <div class="admin-container">
        <h1>Kategori Ekle/Sil</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="kategoriAdi">Kategori Adı:</label>
                <input type="text" id="kategoriAdi" name="kategoriAdi" required>
            </div>
            <?php if (isset($success)): ?>
                <p style="color: green;"><?= $success ?></p>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>
            <button type="submit" name="add">Ekle</button>
        </form>
        <br> <br>
        <form action="" method="post">
            <div class="form-group">
                <label for="kategoriID">Kategori Seçin:</label>
                <select id="kategoriID" name="kategoriID" required>
                    <option value="">Kategori Seçin</option>
                    <?php
                    $query = "SELECT KategoriID, KategoriAdi FROM Kategoriler ORDER BY KategoriAdi";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['KategoriID'] . '">' . $row['KategoriAdi'] . '</option>';
                        }
                    } else {
                        echo '<option value="">Kategori bulunamadı</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="delete">Sil</button>
        </form>
        <a href="adminPanel.php">Admin Paneline Dön</a>
    </div>
</body>
</html>
