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
        $adSoyad = mysqli_real_escape_string($conn, $_POST['adSoyad']);
        $sql = "INSERT INTO Oyuncular (AdSoyad) VALUES ('$adSoyad')";
        if ($conn->query($sql) === TRUE) {
            $success = "Oyuncu başarıyla eklendi!";
        } else {
            $error = "Bir hata oluştu: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $oyuncuID = intval($_POST['oyuncuID']);
        $sql = "DELETE FROM Oyuncular WHERE OyuncuID = $oyuncuID";
        if ($conn->query($sql) === TRUE) {
            $success = "Oyuncu başarıyla silindi!";
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
    <title>Oyuncu Ekle/Sil</title>
    <link rel="stylesheet" href="../css/adminAdd.css">
</head>
<body>
    <div class="admin-container">
        <h1>Oyuncu Ekle/Sil</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="adSoyad">Ad Soyad:</label>
                <input type="text" id="adSoyad" name="adSoyad" required>
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
                <label for="oyuncuID">Oyuncu Seçin:</label>
                <select id="oyuncuID" name="oyuncuID" required>
                    <option value="">Oyuncu Seçin</option>
                    <?php
                    $query = "SELECT OyuncuID, AdSoyad FROM Oyuncular ORDER BY AdSoyad";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['OyuncuID'] . '">' . $row['AdSoyad'] . '</option>';
                        }
                    } else {
                        echo '<option value="">Oyuncu bulunamadı</option>';
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
