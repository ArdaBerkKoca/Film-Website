<?php
session_start();
require_once 'dbConfig.php';

if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

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

$sql = "SELECT f.FilmID, f.Baslik, f.ImgPath FROM Favoriler fav
        JOIN Filmler f ON fav.FilmID = f.FilmID
        WHERE fav.KullaniciID = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$favoriFilmler = [];
while ($row = $result->fetch_assoc()) {
    $favoriFilmler[] = $row;
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Film Sitesi - Listem</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/listem.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .star-icon {
            cursor: pointer;
        }

        .star-icon.favorited {
            color: yellow;
        }

        .star-icon.not-favorited {
            color: white;
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
    <div class="container-movie">
        <h1>Favori Filmlerim</h1>
        <div class="movie-list">
            <?php if (count($favoriFilmler) > 0) : ?>
                <?php foreach ($favoriFilmler as $film) : ?>
                    <?php
                    $filmID = $film['FilmID'];
                    $isFavorited = isFavorited($filmID, $userId);
                    $starClass = $isFavorited ? 'favorited' : 'not-favorited';
                    ?>
                    <div class="movie-item">
                        <img class="movie-item-img" src="../<?= htmlspecialchars($film['ImgPath']) ?>" alt="<?= htmlspecialchars($film['Baslik']) ?>" />
                        <div class="movie-info">
                            <span class="movie-item-title"><?= htmlspecialchars($film['Baslik']) ?></span>
                            <div class="movie-item-buttons">
                                <a href="filmler.php?film=<?= urlencode($film['Baslik']) ?>"><i class="bi bi-play-circle-fill"></i></a>
                                <a href="index.php"><i class="bi bi-hand-thumbs-up-fill"></i></a>
                                <a href="index.php"><i class="bi bi-hand-thumbs-down-fill"></i></a>
                                <i class="bx bx-star star-icon <?= $starClass ?>" data-film-id="<?= $filmID ?>"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Henüz favori film eklemediniz.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- CONTENT END -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
                    const ball = document.querySelector(".toggle-ball");
                    const items = document.querySelectorAll(
                        ".container, .navbar, .bi, .sidebar, .sidebar i, .toggle, .toggle-ball, .movie-list-filter select, .movie-list-title, #loginLink, #registerLink, .profile-text-container a, body, .category-title, .db-movie-details, .menu-list-item, .container-movie"
                    );

                    function toggleDarkMode() {
                        items.forEach((item) => {
                            item.classList.toggle("active");
                        });
                        const isDarkMode = ball.classList.contains("active");
                        localStorage.setItem("darkMode", isDarkMode ? "enabled" : "disabled");
                    }

                    ball.addEventListener("click", () => {
                        ball.classList.toggle("active");
                        toggleDarkMode();
                    });

                    if (localStorage.getItem("darkMode") === "enabled") {
                        ball.classList.add("active");
                        toggleDarkMode();
                    }

                    if (window.history.replaceState) {
                        window.history.replaceState(null, null, window.location.href);
                    }

                    $(document).ready(function() {
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
                                        icon.removeClass('not-favorited').addClass('favorited');
                                    } else if (response == 'unfavorited') {
                                        icon.removeClass('favorited').addClass('not-favorited');
                                    }
                                }
                            });
                        });
                    });
        });
    </script>
</body>

</html>