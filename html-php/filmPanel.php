<?php
require_once 'dbConfig.php'; // Veritabanı bağlantı dosyasını dahil edin
session_start();

// Kullanıcı giriş yapmamışsa login sayfasına yönlendir
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Tüm kategorileri çek
$sqlKategori = "SELECT KategoriID, KategoriAdi FROM Kategoriler ORDER BY KategoriAdi";
$resultKategori = $conn->query($sqlKategori);

// Kategoriler ve filmleri listele
$allMovies = '';
if ($resultKategori->num_rows > 0) {
    while ($kategori = $resultKategori->fetch_assoc()) {
        $kategoriID = $kategori['KategoriID'];
        $kategoriAdi = htmlspecialchars($kategori['KategoriAdi']);

        // Kategori başlığı ve film listesini ayrı div'ler ile grupla
        $movieItems = "<div class='category-section'>";
        $movieItems .= "<h2 class='category-title'>$kategoriAdi</h2>";
        $movieItems .= "<div class='movie-list-wrapper'>";
        $movieItems .= "<ul class='movie-list'>";

        $sql = "SELECT FilmID, Baslik, ImgPath, Aciklama, YayinTarihi, Sure, DilID, YönetmenID, OyuncuIDs, Soundtrack, IMDBPuani FROM Filmler WHERE KategoriID = ? ORDER BY YayinTarihi DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $kategoriID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $filmID = $row['FilmID'];
                $isFavorited = isFavorited($filmID, $userId);
                $starColor = $isFavorited ? 'yellow' : 'white';

                // Beğen ve Beğenmeme durumlarını kontrol et
                $likeStatus = checkLikeStatus($filmID, $userId);
                $likeColor = $likeStatus === 'liked' ? 'blue' : 'white';
                $dislikeColor = $likeStatus === 'disliked' ? 'red' : 'white';

                $movieItems .= '<li class="movie-item">
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
            $movieItems .= '<li class="db-movie-details">Bu kategoride film bulunamadı.</li>';
        }
        $movieItems .= "</ul>";
        $movieItems .= "<i class='bi bi-chevron-left arrow arrow-left'></i>";
        $movieItems .= "<i class='bi bi-chevron-right arrow arrow-right'></i>";
        $movieItems .= "</div></div>";
        $allMovies .= $movieItems;
    }
} else {
    $allMovies = "<p>Kategori bulunamadı.</p>";
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
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Film Sitesi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/filmPanel.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .star-icon {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- NAVBAR START -->
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
    <!-- NAVBAR END -->

    <!-- SIDEBAR START -->
    <div class="sidebar">
        <a href="index.php"><i class="bi bi-house-door-fill"></i></a>
        <a href="commentindex.php"><i class="bi bi-people-fill"></i></a>
        <a href="Listem.php"><i class="bi bi-bookmarks-fill"></i></a>
        <a href="soundtrack.php"><i class="bi bi-music-note-list"></i></a>
    </div>
    <!-- SIDEBAR END -->

    <!-- CONTENT -->
    <div class="container">
        <div class="movie-list-container">
            <?= $allMovies ?>
        </div>
    </div>
    <!-- CONTENT END -->

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

            $('.arrow-right').click(function() {
                const movieList = $(this).siblings('.movie-list');
                const movieWidth = movieList.find('.movie-item').outerWidth(true);
                movieList.animate({ scrollLeft: '+=' + movieWidth }, 'smooth');
            });

            $('.arrow-left').click(function() {
                const movieList = $(this).siblings('.movie-list');
                const movieWidth = movieList.find('.movie-item').outerWidth(true);
                movieList.animate({ scrollLeft: '-=' + movieWidth }, 'smooth');
            });
        });
    </script>

</body>

</html>
