<?php
require_once 'dbConfig.php'; // Veritabanı bağlantı dosyasını dahil edin
session_start();

// Kullanıcı giriş yapmamışsa işlem yapma
if (!isset($_SESSION['user_logged_in'])) {
    echo 'not_logged_in';
    exit();
}

$userId = $_SESSION['user_id'];
$filmID = $_POST['filmID'];
$action = $_POST['action'];

// Önce mevcut beğeni ve beğenmeme durumlarını kontrol et
$sqlCheckLike = "SELECT * FROM filmlikes WHERE film_id = ? AND user_id = ?";
$sqlCheckDislike = "SELECT * FROM filmdislikes WHERE film_id = ? AND user_id = ?";
$stmtLike = $conn->prepare($sqlCheckLike);
$stmtLike->bind_param("ii", $filmID, $userId);
$stmtLike->execute();
$resultLike = $stmtLike->get_result();

$stmtDislike = $conn->prepare($sqlCheckDislike);
$stmtDislike->bind_param("ii", $filmID, $userId);
$stmtDislike->execute();
$resultDislike = $stmtDislike->get_result();

// İşlem türüne göre beğeni veya beğenmeme ekle veya kaldır
if ($action == 'like') {
    if ($resultLike->num_rows > 0) {
        // Zaten beğenmiş, beğenmeyi kaldır
        $sqlRemoveLike = "DELETE FROM filmlikes WHERE film_id = ? AND user_id = ?";
        $stmtRemoveLike = $conn->prepare($sqlRemoveLike);
        $stmtRemoveLike->bind_param("ii", $filmID, $userId);
        $stmtRemoveLike->execute();
        echo 'removed_like';
    } else {
        // Beğenmeyi ekle, varsa beğenmeyi kaldır
        $sqlAddLike = "INSERT INTO filmlikes (film_id, user_id) VALUES (?, ?)";
        $stmtAddLike = $conn->prepare($sqlAddLike);
        $stmtAddLike->bind_param("ii", $filmID, $userId);
        $stmtAddLike->execute();
        $sqlRemoveDislike = "DELETE FROM filmdislikes WHERE film_id = ? AND user_id = ?";
        $stmtRemoveDislike = $conn->prepare($sqlRemoveDislike);
        $stmtRemoveDislike->bind_param("ii", $filmID, $userId);
        $stmtRemoveDislike->execute();
        echo 'liked';
    }
} elseif ($action == 'dislike') {
    if ($resultDislike->num_rows > 0) {
        // Zaten beğenmemiş, beğenmeyi kaldır
        $sqlRemoveDislike = "DELETE FROM filmdislikes WHERE film_id = ? AND user_id = ?";
        $stmtRemoveDislike = $conn->prepare($sqlRemoveDislike);
        $stmtRemoveDislike->bind_param("ii", $filmID, $userId);
        $stmtRemoveDislike->execute();
        echo 'removed_dislike';
    } else {
        // Beğenmeme ekle, varsa beğenmeyi kaldır
        $sqlAddDislike = "INSERT INTO filmdislikes (film_id, user_id) VALUES (?, ?)";
        $stmtAddDislike = $conn->prepare($sqlAddDislike);
        $stmtAddDislike->bind_param("ii", $filmID, $userId);
        $stmtAddDislike->execute();
        $sqlRemoveLike = "DELETE FROM filmlikes WHERE film_id = ? AND user_id = ?";
        $stmtRemoveLike = $conn->prepare($sqlRemoveLike);
        $stmtRemoveLike->bind_param("ii", $filmID, $userId);
        $stmtRemoveLike->execute();
        echo 'disliked';
    }
}
?>
