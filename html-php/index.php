<?php
require_once 'dbConfig.php'; // Veritabanı bağlantı dosyasını dahil edin

session_start();

// Popüler Filmleri çeken sorgu (Beğenisi en yüksek 15 film)
$sqlPopular = "
    SELECT f.FilmID, f.Baslik, f.ImgPath, f.Aciklama, f.KategoriID, f.YayinTarihi, f.Sure, f.DilID, f.YönetmenID, f.OyuncuIDs, f.Soundtrack, f.IMDBPuani,
           (SELECT COUNT(*) FROM filmlikes WHERE film_id = f.FilmID) AS like_count
    FROM Filmler f
    ORDER BY like_count DESC
    LIMIT 15";
$resultPopular = $conn->query($sqlPopular);

// Popüler Filmleri listele
$popularItems = '';
if ($resultPopular->num_rows > 0) {
    while ($row = $resultPopular->fetch_assoc()) {
        $filmID = $row['FilmID'];
        $isFavorited = isFavorited($filmID, $_SESSION['user_id']);
        $starColor = $isFavorited ? 'yellow' : 'white';

        // Beğen ve Beğenmeme durumlarını kontrol et
        $likeStatus = checkLikeStatus($filmID, $_SESSION['user_id']);
        $likeColor = $likeStatus === 'liked' ? 'blue' : 'white';
        $dislikeColor = $likeStatus === 'disliked' ? 'red' : 'white';

        $popularItems .= '<li class="movie-item">
                <img class="movie-item-img" src="../' . htmlspecialchars($row['ImgPath']) . '" alt="' . htmlspecialchars($row['Baslik']) . '" style="width: 200px; height: 300px;" />
                <div class="movie-info">
                    <span class="movie-item-title">' . htmlspecialchars($row['Baslik']) . '</span>
                    <div class="movie-item-buttons">
                        <a href="http://localhost/Muhendislik-Projesi-3-Proje/html-php/filmler.php?film=' . urlencode($row['Baslik']) . '"><i class="bi bi-play-circle-fill"></i></a>
                        <a href="#" class="like-icon" data-film-id="' . $filmID . '" data-action="like"><i class="bi bi-hand-thumbs-up-fill" style="color: ' . $likeColor . '"></i></a>
                        <a href="#" class="dislike-icon" data-film-id="' . $filmID . '" data-action="dislike"><i class="bi bi-hand-thumbs-down-fill" style="color: ' . $dislikeColor . '"></i></a>
                        <i class="bx bx-star star-icon" data-film-id="' . $filmID . '" style="color: ' . $starColor . '"></i>
                    </div>
                </div>
            </li>';
    }
} else {
    $popularItems = "Film bulunamadı.";
}

// Yeni Çıkan Filmleri çeken sorgu (Yayın tarihine göre en yeni 15 film)
$sqlNewReleases = "
    SELECT FilmID, Baslik, ImgPath, Aciklama, KategoriID, YayinTarihi, Sure, DilID, YönetmenID, OyuncuIDs, Soundtrack, IMDBPuani
    FROM Filmler
    ORDER BY YayinTarihi DESC
    LIMIT 15";
$resultNewReleases = $conn->query($sqlNewReleases);

// Yeni Çıkan Filmleri listele
$newReleaseItems = '';
if ($resultNewReleases->num_rows > 0) {
    while ($row = $resultNewReleases->fetch_assoc()) {
        $filmID = $row['FilmID'];
        $isFavorited = isFavorited($filmID, $_SESSION['user_id']);
        $starColor = $isFavorited ? 'yellow' : 'white';

        // Beğen ve Beğenmeme durumlarını kontrol et
        $likeStatus = checkLikeStatus($filmID, $_SESSION['user_id']);
        $likeColor = $likeStatus === 'liked' ? 'blue' : 'white';
        $dislikeColor = $likeStatus === 'disliked' ? 'red' : 'white';

        $newReleaseItems .= '<li class="movie-item">
                <img class="movie-item-img" src="../' . htmlspecialchars($row['ImgPath']) . '" alt="' . htmlspecialchars($row['Baslik']) . '" style="width: 200px; height: 300px;" />
                <div class="movie-info">
                    <span class="movie-item-title">' . htmlspecialchars($row['Baslik']) . '</span>
                    <div class="movie-item-buttons">
                        <a href="http://localhost/Muhendislik-Projesi-3-Proje/html-php/filmler.php?film=' . urlencode($row['Baslik']) . '"><i class="bi bi-play-circle-fill"></i></a>
                        <a href="#" class="like-icon" data-film-id="' . $filmID . '" data-action="like"><i class="bi bi-hand-thumbs-up-fill" style="color: ' . $likeColor . '"></i></a>
                        <a href="#" class="dislike-icon" data-film-id="' . $filmID . '" data-action="dislike"><i class="bi bi-hand-thumbs-down-fill" style="color: ' . $dislikeColor . '"></i></a>
                        <i class="bx bx-star star-icon" data-film-id="' . $filmID . '" style="color: ' . $starColor . '"></i>
                    </div>
                </div>
            </li>';
    }
} else {
    $newReleaseItems = "Film bulunamadı.";
}

// Beğendiğim Filmleri çeken sorgu
$favoritesItems = '';
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
    $sqlFavorites = "
        SELECT f.FilmID, f.Baslik, f.ImgPath, f.Aciklama, f.KategoriID, f.YayinTarihi, f.Sure, f.DilID, f.YönetmenID, f.OyuncuIDs, f.Soundtrack, f.IMDBPuani
        FROM Filmler f
        JOIN filmlikes fl ON f.FilmID = fl.film_id
        WHERE fl.user_id = ?
        ORDER BY fl.id DESC";
    $stmtFavorites = $conn->prepare($sqlFavorites);

    if (!$stmtFavorites) {
        die("Prepare failed: " . $conn->error);
    }

    $stmtFavorites->bind_param("i", $_SESSION['user_id']);
    $stmtFavorites->execute();
    $resultFavorites = $stmtFavorites->get_result();

    if ($resultFavorites->num_rows > 0) {
        while ($row = $resultFavorites->fetch_assoc()) {
            $filmID = $row['FilmID'];
            $isFavorited = isFavorited($filmID, $_SESSION['user_id']);
            $starColor = $isFavorited ? 'yellow' : 'white';

            $likeStatus = checkLikeStatus($filmID, $_SESSION['user_id']);
            $likeColor = $likeStatus === 'liked' ? 'blue' : 'white';
            $dislikeColor = $likeStatus === 'disliked' ? 'red' : 'white';

            $favoritesItems .= '<li class="movie-item">
                    <img class="movie-item-img" src="../' . htmlspecialchars($row['ImgPath']) . '" alt="' . htmlspecialchars($row['Baslik']) . '" style="width: 200px; height: 300px;" />
                    <div class="movie-info">
                        <span class="movie-item-title">' . htmlspecialchars($row['Baslik']) . '</span>
                        <div class="movie-item-buttons">
                            <a href="http://localhost/Muhendislik-Projesi-3-Proje/html-php/filmler.php?film=' . urlencode($row['Baslik']) . '"><i class="bi bi-play-circle-fill"></i></a>
                            <a href="#" class="like-icon" data-film-id="' . $filmID . '" data-action="like"><i class="bi bi-hand-thumbs-up-fill" style="color: ' . $likeColor . '"></i></a>
                            <a href="#" class="dislike-icon" data-film-id="' . $filmID . '" data-action="dislike"><i class="bi bi-hand-thumbs-down-fill" style="color: ' . $dislikeColor . '"></i></a>
                            <i class="bx bx-star star-icon" data-film-id="' . $filmID . '" style="color: ' . $starColor . '"></i>
                        </div>
                    </div>
                </li>';
        }
    } else {
        $favoritesItems = "Beğendiğiniz film bulunamadı.";
    }
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

function checkLikeStatus($filmID, $userID)
{
    global $conn;
    $stmt = $conn->prepare("SELECT 'liked' AS status FROM filmlikes WHERE film_id = ? AND user_id = ? UNION SELECT 'disliked' AS status FROM filmdislikes WHERE film_id = ? AND user_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("iiii", $filmID, $userID, $filmID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['status'];
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width , initial-scale=1.0" />
    <title>Film Sitesi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .star-icon {
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
                    <li class="menu-list-item "><a href="filmPanel.php">Filmler</a></li>
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

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="index.php"><i class="bi bi-house-door-fill"></i></a>
        <a href="commentindex.php"><i class="bi bi-people-fill"></i></a>
        <a href="Listem.php"><i class="bi bi-bookmarks-fill"></i></a>
        <a href="soundtrack.php"><i class="bi bi-music-note-list"></i></a>
    </div>

    <!-- CONTENT -->
    <div class="container">
        <div class="content-wrapper">
            <div class="featured-content">
                <img class="featured-title" src="../img/f2.png" alt="" />
                <p class="featured-desc">
                    Mühendislik Projesi 3 - Selçuk Kıran <br>
                    Film Web Sitesi Yapımı <br>
                    Arda Berk Koca - Berk Halit Erdem
                </p>
                <div class="featured-buttons">
                </div>
            </div>
        </div>

        <div class="movie-list-container">
            <h1 class="movie-list-title">Popüler</h1>
            <br>
            <div class="movie-list-wrapper">
                <ul class="movie-list">
                    <?= $popularItems ?>
                </ul>
                <i class="bi bi-chevron-right arrow"></i>
            </div>
        </div>
        <br><br>
        <div class="movie-list-container">
            <h1 class="movie-list-title">Yeni Çıkanlar</h1>
            <br>
            <div class="movie-list-wrapper">
                <ul class="movie-list">
                    <?= $newReleaseItems ?>
                </ul>
                <i class="bi bi-chevron-right arrow"></i>
            </div>
        </div>
        <br><br>
        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) : ?>
            <div class="movie-list-container">
                <h1 class="movie-list-title">Beğendiklerim</h1>
                <br>
                <div class="movie-list-wrapper">
                    <ul class="movie-list">
                        <?= $favoritesItems ?>
                    </ul>
                    <i class="bi bi-chevron-right arrow"></i>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('.like-icon, .dislike-icon').click(function(event) {
                event.preventDefault();
                var filmID = $(this).data('film-id');
                var action = $(this).data('action');
                var icon = $(this);

                $.ajax({
                    url: 'toggleLikeDislike.php',
                    type: 'POST',
                    data: {
                        filmID: filmID,
                        action: action
                    },
                    success: function(response) {
                        if (response == 'liked') {
                            icon.css('color', 'blue');
                            icon.siblings('.dislike-icon').css('color', 'white');
                        } else if (response == 'disliked') {
                            icon.css('color', 'red');
                            icon.siblings('.like-icon').css('color', 'white');
                        } else if (response == 'removed_like') {
                            icon.css('color', 'white');
                        } else if (response == 'removed_dislike') {
                            icon.css('color', 'white');
                        }
                        location.reload(); // Sayfayı yenile
                    }
                });
            });

            $('.star-icon').click(function() {
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
                        location.reload(); // Sayfayı yenile
                    }
                });
            });
        });
    </script>

</body>

</html>