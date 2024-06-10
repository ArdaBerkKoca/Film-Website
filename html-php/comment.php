<?php
session_start();
require_once 'dbConfig.php';

$film_id = intval($_GET['film_id']);

if (!$film_id) {
    header('Location: commentindex.php');
    exit();
}

// Film bilgilerini çek
$film_sorgu = "SELECT * FROM filmler WHERE FilmID = ?";
$stmt = $conn->prepare($film_sorgu);
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("i", $film_id);
$stmt->execute();
$film_sonuc = $stmt->get_result();
$film = $film_sonuc->fetch_assoc();
$stmt->close();

// Yorum ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['comment_text'])) {
        $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

        if (empty($user_id) || empty($film_id) || empty($comment_text)) {
            die("Hata: Kullanıcı ID, film ID veya yorum metni boş olamaz.");
        }

        $sql = "INSERT INTO comments (film_id, user_id, comment_text) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("iis", $film_id, $user_id, $comment_text);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $message = "Yorum başarıyla eklendi.";
                header("Location: comment.php?film_id=$film_id");
                exit();
            } else {
                $error = "Yorum eklenirken bir hata oluştu: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Veritabanı sorgu hatası: " . $conn->error;
        }
    } elseif (isset($_POST['reply_text'])) {
        $comment_id = intval($_POST['comment_id']);
        $reply_text = mysqli_real_escape_string($conn, $_POST['reply_text']);

        if (empty($user_id) || empty($comment_id) || empty($reply_text)) {
            die("Hata: Kullanıcı ID, yorum ID veya yanıt metni boş olamaz.");
        }

        $sql = "INSERT INTO replies (comment_id, user_id, reply_text) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("iis", $comment_id, $user_id, $reply_text);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $message = "Yanıt başarıyla eklendi.";
                header("Location: comment.php?film_id=$film_id");
                exit();
            } else {
                $error = "Yanıt eklenirken bir hata oluştu: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Veritabanı sorgu hatası: " . $conn->error;
        }
    } elseif (isset($_POST['like'])) {
        $comment_id = intval($_POST['comment_id']);

        // Kullanıcı daha önce beğenmiş mi kontrol et
        $check_like_sql = "SELECT * FROM likes WHERE comment_id = ? AND user_id = ?";
        $stmt = $conn->prepare($check_like_sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ii", $comment_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $already_liked = $result->num_rows > 0;
        $stmt->close();

        // Kullanıcı daha önce beğenmeme yapmış mı kontrol et
        $check_dislike_sql = "SELECT * FROM dislikes WHERE comment_id = ? AND user_id = ?";
        $stmt = $conn->prepare($check_dislike_sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ii", $comment_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $already_disliked = $result->num_rows > 0;
        $stmt->close();

        if ($already_liked) {
            // Kullanıcı zaten beğendiyse beğeniyi kaldır
            $sql = "DELETE FROM likes WHERE comment_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE comments SET likes = likes - 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $stmt->close();
        } elseif ($already_disliked) {
            // Kullanıcı beğenmemişse beğenmeyi beğen yap
            $sql = "DELETE FROM dislikes WHERE comment_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE comments SET dislikes = dislikes - 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $stmt->close();

            $sql = "INSERT INTO likes (comment_id, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE comments SET likes = likes + 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $stmt->close();
        } else {
            // Kullanıcı beğenmemiş ve beğenmemişse beğen
            $sql = "INSERT INTO likes (comment_id, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE comments SET likes = likes + 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: comment.php?film_id=$film_id");
        exit();
    } elseif (isset($_POST['dislike'])) {
        $comment_id = intval($_POST['comment_id']);

        // Kullanıcı daha önce beğenmiş mi kontrol et
        $check_like_sql = "SELECT * FROM likes WHERE comment_id = ? AND user_id = ?";
        $stmt = $conn->prepare($check_like_sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ii", $comment_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $already_liked = $result->num_rows > 0;
        $stmt->close();

        // Kullanıcı daha önce beğenmeme yapmış mı kontrol et
        $check_dislike_sql = "SELECT * FROM dislikes WHERE comment_id = ? AND user_id = ?";
        $stmt = $conn->prepare($check_dislike_sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ii", $comment_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $already_disliked = $result->num_rows > 0;
        $stmt->close();

        if ($already_disliked) {
            // Kullanıcı zaten beğenmemişse beğenmeyi kaldır
            $sql = "DELETE FROM dislikes WHERE comment_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE comments SET dislikes = dislikes - 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $stmt->close();
        } elseif ($already_liked) {
            // Kullanıcı beğenmişse beğenmeyi beğenmeme yap
            $sql = "DELETE FROM likes WHERE comment_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE comments SET likes = likes - 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $stmt->close();

            $sql = "INSERT INTO dislikes (comment_id, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE comments SET dislikes = dislikes + 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $stmt->close();
        } else {
            // Kullanıcı beğenmemiş ve beğenmemişse beğenmeme yap
            $sql = "INSERT INTO dislikes (comment_id, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("ii", $comment_id, $user_id);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE comments SET dislikes = dislikes + 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $stmt->close();
        }

        header("Location: comment.php?film_id=$film_id");
        exit();
    } elseif (isset($_POST['delete_comment'])) {
        $comment_id = intval($_POST['comment_id']);

        // Beğenme ve beğenmeme kayıtlarını sil
        $sql = "DELETE FROM likes WHERE comment_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $stmt->close();

        $sql = "DELETE FROM dislikes WHERE comment_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        $stmt->close();

        // Yorumu sil
        $sql = "DELETE FROM comments WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ii", $comment_id, $user_id);
        $stmt->execute();
        $stmt->close();

        header("Location: comment.php?film_id=$film_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Yorum - <?= htmlspecialchars($film['Baslik']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/comment.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .comment-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .comment-form {
            display: none;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .comment-form textarea {
            width: 80%;
            height: 100px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .comment-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #5cb85c;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .comment-form button:hover {
            background-color: #4cae4c;
        }
        
        /* Navbar, Sidebar ve Dark Mode CSS */
        .navbar {
            background-color: #1F1F1F;
            height: 60px;
            color: #FFFFFF;
            position: sticky;
            top: 0;
            z-index: 1;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .navbar-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            padding: 0 50px;
        }

        a {
            text-decoration: none;
            color: #FFFFFF;
            transition: color 0.3s;
        }

        .navbar-link {
            margin-right: 15px;
            transition: color 0.3s, text-decoration 0.3s;
        }

        .navbar-link:hover {
            color: #E50914;
            text-decoration: underline;
        }

        .logo {
            font-size: 30px;
            color: #E50914;
        }

        .menu-list {
            display: flex;
            list-style: none;
            column-gap: 30px;
            padding: 0;
        }

        .menu-list-item {
            cursor: pointer;
            transition: font-weight 0.3s;
        }

        .menu-list-item:hover, .menu-list-item.active {
            font-weight: bold;
        }

        .profile-container {
            display: flex;
            align-items: center;
            column-gap: 20px;
        }

        .profile-text-container {
            display: flex;
            align-items: center;
            column-gap: 5px;
            line-height: 1;
        }

        .toggle {
            width: 40px;
            background-color: #FFFFFF;
            position: relative;
            height: 20px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            cursor: pointer;
        }

        .toggle-icon {
            color: #FFD700;
        }

        .toggle-ball {
            width: 18px;
            height: 18px;
            background-color: #000000;
            border-radius: 50px;
            position: absolute;
            right: 1px;
            transition: transform 0.3s;
        }

        body.active .toggle-ball {
            transform: translateX(-20px);
            background-color: #FFFFFF;
        }

        .sidebar {
            background-color: #1F1F1F;
            color: #FFFFFF;
            height: 100%;
            width: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
            row-gap: 40px;
            position: fixed;
            top: 0;
            z-index: 1000;
            box-shadow: 4px 0 8px rgba(0, 0, 0, 0.3);
        }

        .sidebar i {
            color: #FFFFFF;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .sidebar i:hover {
            color: #E50914;
        }

        .like-button, .dislike-button, .delete-button {
            border: none;
            background: none;
            cursor: pointer;
            color: white;
            margin-right: 10px;
            font-size: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .like-button:hover, .dislike-button:hover, .delete-button:hover {
            color: #E50914;
        }

        .like-button:focus, .dislike-button:focus, .delete-button:focus {
            outline: none;
        }

        .reply-button {
            border: none;
            background: none;
            cursor: pointer;
            color: white;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .reply-button:hover {
            color: #E50914;
        }

        .reply-form {
            display: none;
            flex-direction: column;
            margin-top: 10px;
        }

        .reply-form textarea {
            width: 90%;
            height: 60px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .reply-form button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #5cb85c;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        .reply-form button:hover {
            background-color: #4cae4c;
        }

        .replies {
            margin-left: 30px;
            margin-top: 10px;
        }

        .replies .reply {
            background-color: #555;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 8px;
        }

        .replies .reply p {
            margin: 0;
        }

        .replies .reply p strong {
            color: #ff0000;
        }

        .replies .reply p small {
            color: #bbb;
            font-size: 12px;
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

    <div class="film-detail">
        <h1><?= htmlspecialchars($film['Baslik']) ?></h1>
        <img src="../<?= htmlspecialchars($film['ImgPath']) ?>" alt="<?= htmlspecialchars($film['Baslik']) ?>">
        <p><?= htmlspecialchars($film['Aciklama']) ?></p>
        
        <h2>Yorumlar</h2>
        <?php if (isset($message)) : ?>
            <p style="color: green;"><?= $message ?></p>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <div class="comments">
            <?php
            $comment_sorgu = "SELECT c.id, c.comment_text, c.created_at, c.likes, c.dislikes, u.KullaniciAdi, c.user_id FROM comments c JOIN kullanicilar u ON c.user_id = u.KullaniciID WHERE c.film_id = ? ORDER BY c.likes DESC";
            $stmt = $conn->prepare($comment_sorgu);
            if (!$stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            $stmt->bind_param("i", $film_id);
            $stmt->execute();
            $comment_sonuc = $stmt->get_result();

            while ($comment = $comment_sonuc->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "<p><strong>{$comment['KullaniciAdi']}</strong>: {$comment['comment_text']}</p>";
                echo "<p><small>{$comment['created_at']}</small></p>";
                echo "<form method='POST' action='comment.php?film_id=$film_id'>";
                echo "<input type='hidden' name='comment_id' value='{$comment['id']}'>";
                echo "<button type='submit' name='like' class='like-button'><i class='bi bi-hand-thumbs-up'></i> {$comment['likes']}</button>";
                echo "<button type='submit' name='dislike' class='dislike-button'><i class='bi bi-hand-thumbs-down'></i> {$comment['dislikes']}</button>";
                if ($comment['user_id'] == $_SESSION['user_id']) {
                    echo "<button type='submit' name='delete_comment' class='delete-button'><i class='bi bi-trash'></i> Sil</button>";
                }
                echo "<button type='button' class='reply-button' onclick='toggleReplyForm({$comment['id']})'>Yanıtla</button>";
                echo "</form>";

                // Display replies
                $reply_sorgu = "SELECT r.reply_text, r.created_at, u.KullaniciAdi FROM replies r JOIN kullanicilar u ON r.user_id = u.KullaniciID WHERE r.comment_id = ? ORDER BY r.created_at ASC";
                $stmt_reply = $conn->prepare($reply_sorgu);
                if (!$stmt_reply) {
                    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                }
                $stmt_reply->bind_param("i", $comment['id']);
                $stmt_reply->execute();
                $reply_sonuc = $stmt_reply->get_result();
                
                echo "<div class='replies'>";
                while ($reply = $reply_sonuc->fetch_assoc()) {
                    echo "<div class='reply'>";
                    echo "<p><strong>{$reply['KullaniciAdi']}</strong>: {$reply['reply_text']}</p>";
                    echo "<p><small>{$reply['created_at']}</small></p>";
                    echo "</div>";
                }
                echo "</div>";

                // Reply form
                echo "<div class='reply-form' id='reply-form-{$comment['id']}'>";
                echo "<form method='POST' action='comment.php?film_id=$film_id'>";
                echo "<input type='hidden' name='comment_id' value='{$comment['id']}'>";
                echo "<textarea name='reply_text' required></textarea>";
                echo "<button type='submit'>Yanıtla</button>";
                echo "</form>";
                echo "</div>";

                echo "</div>";
            }
            $stmt->close();
            ?>
        </div>

        <button class="comment-button" onclick="showCommentForm()">+</button>

        <div class="comment-form" id="comment-form">
            <form action="comment.php?film_id=<?= $film_id ?>" method="POST">
                <textarea name="comment_text" required></textarea>
                <button type="submit">Yorum Yap</button>
            </form>
        </div>
    </div>

    <script>
        function showCommentForm() {
            document.getElementById('comment-form').style.display = 'flex';
            document.querySelector('.comment-button').style.display = 'none';
        }

        function toggleReplyForm(commentId) {
            var form = document.getElementById('reply-form-' + commentId);
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'flex';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</body>
</html>
