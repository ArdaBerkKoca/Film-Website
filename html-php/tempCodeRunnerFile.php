<?php
function isFavorited($filmID, $userID) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Favoriler WHERE FilmID = ? AND KullaniciID = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ii", $filmID, $userID);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}