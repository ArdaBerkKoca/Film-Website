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
        $yonetmenAdi = mysqli_real_escape_string($conn, $_POST['yonetmenAdi']);
        $sql = "INSERT INTO Yönetmenler (YönetmenAdi) VALUES ('$yonetmenAdi')";
        if ($conn->query($sql) === TRUE) {
            $success = "Yönetmen başarıyla eklendi!";
        } else {
            $error = "Bir hata oluştu: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $yonetmenID = intval($_POST['yonetmenID']);
        $sql = "DELETE FROM Yönetmenler WHERE YönetmenID = $yonetmenID";
        if ($conn->query($sql) === TRUE) {
            $success = "Yönetmen başarıyla silindi!";
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
    <title>Yönetmen Ekle/Sil</title>
    <link rel="stylesheet" href="../css/adminAdd.css">
</head>
<body>
    <div class="admin-container">
        <h1>Yönetmen Ekle/Sil</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="yonetmenAdi">Yönetmen Adı:</label>
                <input type="text" id="yonetmenAdi" name="yonetmenAdi" required>
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
                <label for="yonetmenID">Yönetmen Seçin:</label>
                <select id="yonetmenID" name="yonetmenID" required>
                    <option value="">Yönetmen Seçin</option>
                    <?php
                    $query = "SELECT YönetmenID, YönetmenAdi FROM Yönetmenler ORDER BY YönetmenAdi";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['YönetmenID'] . '">' . $row['YönetmenAdi'] . '</option>';
                        }
                    } else {
                        echo '<option value="">Yönetmen bulunamadı</option>';
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
