<?php
session_start();
require_once 'dbConfig.php';

if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}

$filmID = isset($_GET['film_id']) ? $_GET['film_id'] : null;
if (empty($filmID)) {
    header('Location: soundtrack.php');
    exit();
}

function getSoundtrackByFilmID($filmID)
{
    global $conn;
    $stmt = $conn->prepare("SELECT Baslik, Soundtrack FROM Filmler WHERE FilmID = ?");
    $stmt->bind_param("i", $filmID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$soundtrack = getSoundtrackByFilmID($filmID);

function getEmbedUrl($url) {
    $parsedUrl = parse_url($url);
    if (strpos($parsedUrl['host'], 'youtube.com') !== false) {
        parse_str($parsedUrl['query'], $queryParams);
        return 'https://www.youtube.com/embed/' . $queryParams['v'];
    } elseif (strpos($parsedUrl['host'], 'youtu.be') !== false) {
        return 'https://www.youtube.com/embed' . $parsedUrl['path'];
    }
    // Diğer video platformları için benzer kurallar eklenebilir
    return $url;
}

$embedUrl = getEmbedUrl($soundtrack['Soundtrack']);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Soundtrack</title>
    <link rel="stylesheet" href="../css/soundtrackdetail.css">
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
            <h1>Film Soundtrack</h1>
        </header>
        <div class="categories">
            <?php if ($soundtrack): ?>
                <div class='category'>
                    <h2><?= htmlspecialchars($soundtrack['Baslik']) ?></h2>
                    <iframe width="560" height="315" src="<?= htmlspecialchars($embedUrl) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            <?php else: ?>
                <p>Bu film için bir soundtrack bulunamadı.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- CONTENT END -->

</body>
</html>
