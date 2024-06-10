<?php
session_start();
require_once 'dbConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    if (isset($_POST['add'])) {
        $kategori = intval($_POST['kategori']);
        $filmAdi = strtolower(mysqli_real_escape_string($conn, $_POST['filmAdi']));
        $filmAciklamasi = mysqli_real_escape_string($conn, $_POST['filmAciklamasi']);
        $yonetmenID = intval($_POST['yonetmen']);
        $oyuncuIDs = explode(',', $_POST['oyuncular']); 
        $soundtrack = mysqli_real_escape_string($conn, $_POST['soundtrack']);
        $youtubeLink = mysqli_real_escape_string($conn, $_POST['youtubeLink']);
        $yayinTarihi = mysqli_real_escape_string($conn, $_POST['yayinTarihi']);
        $sure = mysqli_real_escape_string($conn, $_POST['sure']);
        $dilID = intval($_POST['dil']);
        $imdbPuani = mysqli_real_escape_string($conn, $_POST['imdbPuani']);
        $imgPath = '';

        if (isset($_FILES['filmResim']) && $_FILES['filmResim']['error'] == 0) {
            $allowed = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];
            $filename = $_FILES['filmResim']['name'];
            $filesize = $_FILES['filmResim']['size'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $maxsize = 5 * 1024 * 1024; // 5MB
            if ($filesize > $maxsize) {
                die("Hata: Dosya boyutu izin verilen sınırları aşıyor.");
            }
            $newfilename = md5(time() . $filename) . ".$ext";
            
            // Resmi yeniden boyutlandırma işlemi
            $sourcePath = $_FILES['filmResim']['tmp_name'];
            $targetPath = "../img/" . $newfilename;
            $width = 200;
            $height = 300;

            if ($ext == 'jpg' || $ext == 'jpeg') {
                $sourceImage = imagecreatefromjpeg($sourcePath);
            } elseif ($ext == 'png') {
                $sourceImage = imagecreatefrompng($sourcePath);
            } elseif ($ext == 'gif') {
                $sourceImage = imagecreatefromgif($sourcePath);
            }

            list($sourceWidth, $sourceHeight) = getimagesize($sourcePath);
            $targetImage = imagecreatetruecolor($width, $height);

            imagecopyresampled($targetImage, $sourceImage, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);

            if ($ext == 'jpg' || $ext == 'jpeg') {
                imagejpeg($targetImage, $targetPath);
            } elseif ($ext == 'png') {
                imagepng($targetImage, $targetPath);
            } elseif ($ext == 'gif') {
                imagegif($targetImage, $targetPath);
            }

            imagedestroy($sourceImage);
            imagedestroy($targetImage);
            
            $imgPath = "img/" . $newfilename;
        }

        $sql = "INSERT INTO Filmler (KategoriID, Baslik, YönetmenID, Aciklama, Soundtrack, YoutubeLink, YayinTarihi, Sure, DilID, IMDBPuani, ImgPath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("issssssssis", $kategori, $filmAdi, $yonetmenID, $filmAciklamasi, $soundtrack, $youtubeLink, $yayinTarihi, $sure, $dilID, $imdbPuani, $imgPath);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $filmID = $stmt->insert_id;
                $stmt->close();
                
                foreach ($oyuncuIDs as $oyuncuID) {
                    $sql = "INSERT INTO FilmOyuncular (FilmID, OyuncuID) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $filmID, $oyuncuID);
                    $stmt->execute();
                    $stmt->close();
                }

                $message = "Film başarıyla eklendi.";
            } else {
                $error = "Film eklenirken bir hata oluştu: " . $stmt->error;
            }
        } else {
            $error = "Veritabanı sorgu hatası: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $filmID = intval($_POST['filmID']);
        $sql = "DELETE FROM Filmler WHERE FilmID = $filmID";
        if ($conn->query($sql) === TRUE) {
            $success = "Film başarıyla silindi!";
        } else {
            $error = "Bir hata oluştu: " . $conn->error;
        }
    }
}

if (isset($error)) {
    echo $error;
}

if (isset($message)) {
    echo $message;
    header("refresh:3;url=http://localhost/Muhendislik-Projesi-3-Proje/html-php/adminPanel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Film Ekle/Sil</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .selected-actors {
            margin-top: 10px;
        }

        .selected-actor {
            margin-bottom: 5px;
        }
        .carp-icon {
            color: red;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <div class="admin-panel">
        <h1>Film Ekle/Sil Panel</h1>
        <?php if (isset($message)) : ?>
            <p style="color: green;"><?= $message ?></p>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form action="adminFilm.php" method="POST" enctype="multipart/form-data">
            <label for="filmAdi">Film Adı</label>
            <input type="text" id="filmAdi" name="filmAdi" required>

            <label for="filmAciklamasi">Film Açıklaması</label>
            <textarea id="filmAciklamasi" name="filmAciklamasi" required></textarea>

            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
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

            <label for="yayinTarihi">Yayın Tarihi</label>
            <input type="date" id="yayinTarihi" name="yayinTarihi" required>

            <label for="sure">Süre (Dakika)</label>
            <input type="number" id="sure" name="sure" required>

            <label for="dil">Dil</label>
            <select id="dil" name="dil" required>
                <option value="">Dil Seçin</option>
                <?php
                $query = "SELECT DilID, DilAdi FROM Diller ORDER BY DilAdi";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['DilID'] . '">' . $row['DilAdi'] . '</option>';
                    }
                } else {
                    echo '<option value="">Dil bulunamadı</option>';
                }
                ?>
            </select>

            <label for="yonetmen">Yönetmen</label>
            <select id="yonetmen" name="yonetmen" required>
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

            <label for="oyuncular">Oyuncular</label>
            <select id="oyuncular" name="oyuncular_select">
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

            <div class="selected-actors" id="selected-actors"></div>

            <input type="hidden" id="oyuncular-hidden" name="oyuncular" value="">

            <label for="soundtrack">Soundtrack</label>
            <input type="url" id="soundtrack" name="soundtrack" required>

            <label for="youtubeLink">YouTube Link</label>
            <input type="url" id="youtubeLink" name="youtubeLink" required>

            <label for="imdbPuani">IMDB Puanı</label>
            <input type="number" step="0.1" id="imdbPuani" name="imdbPuani" required>

            <label for="filmResim">Film Resmi</label>
            <input type="file" id="filmResim" name="filmResim" required accept=".jpeg, .jpg, .png, .gif">

            <button class="filmbutton" type="submit" name="add">Film Ekle</button>
        </form>

        
        <form action="adminFilm.php" method="POST">
            <div class="form-group">
                <label for="filmID">Film Seçin:</label>
                <select id="filmID" name="filmID" required>
                    <option value="">Film Seçin</option>
                    <?php
                    $query = "SELECT FilmID, Baslik FROM Filmler ORDER BY Baslik";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['FilmID'] . '">' . $row['Baslik'] . '</option>';
                        }
                    } else {
                        echo '<option value="">Film bulunamadı</option>';
                    }
                    ?>
                </select>
            </div>
            <button class="filmbutton" type="submit" name="delete">Sil</button>
        </form>
        <a href="adminPanel.php">Admin Paneline Dön</a>
    </div>

    <script>
        const oyuncularSelect = document.getElementById('oyuncular');
        const selectedActorsDiv = document.getElementById('selected-actors');
        const oyuncularHiddenInput = document.getElementById('oyuncular-hidden');
        let selectedActors = [];

        oyuncularSelect.addEventListener('change', function() {
            const selectedOption = oyuncularSelect.options[oyuncularSelect.selectedIndex];
            const actorId = selectedOption.value;
            const actorName = selectedOption.text;

            if (actorId && !selectedActors.includes(actorId)) {
                selectedActors.push(actorId);
                updateSelectedActorsDiv(actorId, actorName);
                updateHiddenInput();
                selectedOption.remove();
            }
        });

        function updateSelectedActorsDiv(actorId, actorName) {
            const actorDiv = document.createElement('div');
            actorDiv.className = 'selected-actor';
            actorDiv.innerHTML = `${actorName} <span class="button1" onclick="removeActor('${actorId}', '${actorName}')"><i class='bx bx-x carp-icon'></i></span>`;
            selectedActorsDiv.appendChild(actorDiv);
        }

        function updateHiddenInput() {
            oyuncularHiddenInput.value = selectedActors.join(',');
        }

        function removeActor(actorId, actorName) {
            selectedActors = selectedActors.filter(id => id !== actorId);
            updateHiddenInput();
            addActorOption(actorId, actorName);
            const actorDivs = selectedActorsDiv.getElementsByClassName('selected-actor');
            for (let actorDiv of actorDivs) {
                if (actorDiv.innerText.includes(actorName)) {
                    actorDiv.remove();
                }
            }
        }

        function addActorOption(actorId, actorName) {
            const option = document.createElement('option');
            option.value = actorId;
            option.text = actorName;
            oyuncularSelect.add(option);
        }
    </script>
</body>

</html>
