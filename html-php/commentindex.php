<?php
session_start();
require_once 'dbConfig.php';

if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Kategorileri</title>
    <link rel="stylesheet" href="../css/commentindex.css">
    <link href='https://unpkg.com/boxicons/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                    <li class="menu-list-item active"><a href="index.php">Ana Sayfa</a></li>
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

    <!-- CONTENT START -->
    <div class="container">
        <header>
            <h1>Film Kategorileri</h1>
        </header>
        <div class="categories">
            <?php
            $kategori_sorgu = "SELECT KategoriID, KategoriAdi FROM kategoriler ORDER BY KategoriAdi";
            $kategori_sonuc = $conn->query($kategori_sorgu);

            if ($kategori_sonuc->num_rows > 0) {
                while ($kategori = $kategori_sonuc->fetch_assoc()) {
                    echo "<div class='category'>";
                    echo "<h2>" . $kategori['KategoriAdi'] . "</h2>";

                    $film_sorgu = "SELECT FilmID, Baslik, ImgPath FROM filmler WHERE KategoriID = " . $kategori['KategoriID'];
                    $film_sonuc = $conn->query($film_sorgu);

                    if ($film_sonuc->num_rows > 0) {
                        while ($film = $film_sonuc->fetch_assoc()) {
                            echo "<div class='film'>";
                            echo "<a href='comment.php?film_id=" . $film['FilmID'] . "'>";
                            echo "<i class='bx bx-chat'></i> ";
                            echo "<p>" . htmlspecialchars($film['Baslik']) . "</p>";
                            echo "</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Bu kategoride film bulunamadı.</p>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p>Kategori bulunamadı.</p>";
            }
            ?>
        </div>
    </div>
    <!-- CONTENT END -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('.star-icon').click(function() {
                var filmID = $(this).data('film-id');
                var icon = $(this);

                $.ajax({
                    url: 'toggleFavorite.php',
                    type: 'POST',
                    data: { filmID: filmID },
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
