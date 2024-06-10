<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'dbConfig.php';

if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}

$filmTitle = isset($_GET['film']) ? $_GET['film'] : null;
if (empty($filmTitle)) {
    header('Location: index.php');
    exit();
}

function getFilmByTitle($title)
{
    global $conn;
    $stmt = $conn->prepare(
        "SELECT f.*, d.DilAdi, y.YönetmenAdi FROM Filmler f 
         JOIN Diller d ON f.DilID = d.DilID 
         JOIN Yönetmenler y ON f.YönetmenID = y.YönetmenID 
         WHERE f.Baslik = ?"
    );

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $title);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getOyuncularByFilmID($filmID)
{
    global $conn;
    $stmt = $conn->prepare(
        "SELECT o.AdSoyad FROM FilmOyuncular fo
         JOIN Oyuncular o ON fo.OyuncuID = o.OyuncuID 
         WHERE fo.FilmID = ?"
    );

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $filmID);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function isFavorited($filmID, $userID)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Favoriler WHERE FilmID = ? AND KullaniciID = ?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ii", $filmID, $userID);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

$filmData = getFilmByTitle($filmTitle);
if ($filmData) {
    $oyuncular = getOyuncularByFilmID($filmData['FilmID']);
    $oyuncuAdlari = implode(', ', array_column($oyuncular, 'AdSoyad'));
    $youtubeLink = $filmData['YoutubeLink'];
    $embedLink = str_replace("watch?v=", "embed/", $youtubeLink);
    $isFavorited = isFavorited($filmData['FilmID'], $_SESSION['user_id']);
} else {
    echo 'Film bulunamadı.';
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Film Sitesi - <?= htmlspecialchars($filmTitle) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/filmler.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .star-icon {
            color: <?= $isFavorited ? 'yellow' : 'white' ?>;
            font-size: 32px;
            padding-left: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <div class="navbar">
        <div class="navbar-wrapper">
            <div class="logo-wrapper">
                <a href="index.php">
                    <h1 class="logo">Movie2You</h1>
                </a>
            </div>
            <div class="menu-container">
                <ul class="menu-list">
                    <li class="menu-list-item"><a href="index.php">Ana Sayfa</a></li>
                    <li class="menu-list-item"><a href="filmPanel.php">Filmler</a></li>
                    <li class="menu-list-item"><a href="Listem.php">Listem</a></li>
                </ul>
            </div>
            <div class="profile-container">
                <div class="profile-text-container">
                    <?php if (!isset($_SESSION['user_logged_in'])) : ?>
                        <a href="login.php" class="navbar-link" id="loginLink">Giriş Yap</a>
                        <a href="register.php" class="navbar-link" id="registerLink">Kayıt ol</a>
                    <?php else : ?>
                        <a href="hesabim.php" class="navbar-link">Hesabım</a>
                        <a href="logout.php" class="navbar-link">Çıkış Yap</a>
                    <?php endif; ?>
                </div>
                <div class="toggle">
                    <i class="bi bi-moon-fill toggle-icon"></i>
                    <i class="bi bi-brightness-high-fill toggle-icon"></i>
                    <div class="toggle-ball"></div>
                </div>
            </div>
        </div>
    </div>

    <!--! SİDEBAR START -->
    <div class="sidebar">
        <a href="index.php"><i class="bi bi-house-door-fill"></i></a>
        <a href="commentindex.php"><i class="bi bi-people-fill"></i></a>
        <a href="Listem.php"><i class="bi bi-bookmarks-fill"></i></a>
        <a href="soundtrack.php"><i class="bi bi-music-note-list"></i></a>
    </div>
    <!--! SİDEBAR END -->

    <!-- CONTENT -->
    <div class="container-movie">
        <div class="movie-header">
            <h1><?= htmlspecialchars($filmTitle) ?><i class='bx bx-star star-icon' id="favorite-icon" data-film-id="<?= $filmData['FilmID'] ?>"></i></h1>
            <img src="../<?= htmlspecialchars($filmData['ImgPath']) ?>" alt="<?= htmlspecialchars($filmTitle) ?>" class="movie-image">
        </div>
        <div class="movie-details">
            <div class="db-movie-info"><strong>Yönetmen:</strong> <a><?= htmlspecialchars($filmData['YönetmenAdi']) ?></a></div>
            <div class="db-movie-info"><strong>Oyuncular:</strong> <a> <?= htmlspecialchars($oyuncuAdlari) ?></a></div>
            <div class="db-movie-info"><strong>Açıklama:</strong> <a> <?= htmlspecialchars($filmData['Aciklama']) ?></a></div>
            <div class="db-movie-info"><strong>Yayın Tarihi:</strong> <a> <?= htmlspecialchars($filmData['YayinTarihi']) ?></a></div>
            <div class="db-movie-info"><strong>Süre:</strong> <a> <?= htmlspecialchars($filmData['Sure']) ?> dakika</a></div>
            <div class="db-movie-info"><strong>Dil:</strong> <a> <?= htmlspecialchars($filmData['DilAdi']) ?></a></div>
            <div class="db-movie-info"><strong>IMDB Puanı:</strong> <a> <?= htmlspecialchars($filmData['IMDBPuani']) ?></a></div>
            <div class="db-movie-info-sd">
                <strong><a href="soundtrackDetail.php?film_id=<?= $filmData['FilmID'] ?>">Soundtrack</a></strong>
            </div>
        </div>
        <iframe src="<?= htmlspecialchars($embedLink) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#favorite-icon').click(function() {
                var filmID = $(this).data('film-id');
                var icon = $(this);

                $.ajax({
                    url: 'toggleFavorite.php',
                    type: 'POST',
                    data: {
                        filmID: filmID
                    },
                    success: function(response) {
                        if (response == 'favorited') {
                            icon.css('color', 'yellow');
                        } else if (response == 'unfavorited') {
                            icon.css('color', 'white');
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>