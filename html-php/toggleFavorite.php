<?php
session_start();
require_once 'dbConfig.php';

if (!isset($_SESSION['user_logged_in'])) {
    echo 'not_logged_in';
    exit();
}

$filmID = $_POST['filmID'];
$userID = $_SESSION['user_id'];

// Favorilerde olup olmadığını kontrol et
$stmt = $conn->prepare("SELECT * FROM Favoriler WHERE FilmID = ? AND KullaniciID = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ii", $filmID, $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Favorilerden çıkar
    $stmt = $conn->prepare("DELETE FROM Favoriler WHERE FilmID = ? AND KullaniciID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $filmID, $userID);
    $stmt->execute();
    echo 'unfavorited';
} else {
    // Favorilere ekle
    $stmt = $conn->prepare("INSERT INTO Favoriler (FilmID, KullaniciID) VALUES (?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $filmID, $userID);
    $stmt->execute();
    echo 'favorited';
}
?>
