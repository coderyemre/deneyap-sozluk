<?php
session_start();
date_default_timezone_set('Europe/Istanbul');

if (!isset($_SESSION['username'])) {
    die("Yetkisiz erişim.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo $_POST['author'];
    echo "<br>";
    echo $_POST['body'];
    echo "<br>";
    echo $_POST['topic_id'];
    echo "<br>";
    //echo $_POST[3];
    if (!isset($_POST['topic_id']) || !isset($_POST['author']) || !isset($_POST['body'])) {
        die("Eksik veri.");
    }

    include "conn.php";
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    function createReply($topic_id, $author, $body) {
        global $conn;

        $current_timestamp = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `replies` (`topic_id`, `author`, `body`, `date`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
        }
        $stmt->bind_param('ssss', $topic_id, $author, $body, $current_timestamp);
        if ($stmt->execute() === false) {
            die("Hata: " . $stmt->error);
        } else {
            // Bildirim oluşturulacak
            
            createNotification($topic_id, $author);
            echo "Yanıt başarıyla eklendi.";
        }
    }

    function createNotification($topic_id, $author_username) {
        global $conn;

        // Kullanıcının ID'sini almak
        $sql = "SELECT `id` FROM `users` WHERE `username` = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
        }
        $stmt->bind_param('s', $author_username);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        if (!$userData) {
            die("Kullanıcı bulunamadı.");
        }
        $author_id = $userData['id'];

        // Konu sahibini almak
        $sql = "SELECT `post_author` FROM `topics` WHERE `topic_id` = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
        }
        $stmt->bind_param('i', $topic_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $topicData = $result->fetch_assoc();
        if (!$topicData) {
            die("Konu bulunamadı.");
        }
        $topic_owner_username = $topicData['post_author'];

        // Konu sahibinin ID'sini almak
        $sql = "SELECT `id` FROM `users` WHERE `username` = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
        }
        $stmt->bind_param('s', $topic_owner_username);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        if (!$userData) {
            die("Konu sahibinin ID'si bulunamadı.");
        }
        $topic_owner_id = $userData['id'];
        $link = "topic.php?topic_id=" . $topic_id;
        if ($topic_owner_id != $author_id) { 
            $content = $author_username . " kullanıcısı yanıtladı.";
            $link = "topic.php?topic_id=" . $topic_id;
            $sql = "INSERT INTO `notifications`(`user_id`, `maker_id`, `type`, `content`, `link`, `created_at`, `read_at`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
            }
            $created_at = date('Y-m-d H:i:s');
            $read_at = null;
            $type=2;
            $stmt->bind_param('iiissss', $topic_owner_id, $author_id, $type, $content, $link, $created_at, $read_at);
            if ($stmt->execute() === false) {
                die("Bildirim eklenirken bir hata oluştu: " . $stmt->error);
            }
        }
    header("Location: $link");
    $conn->close();
    }

    $topic_id = $_POST['topic_id'];
    $author = $_POST['author'];
    $body = $_POST['body'];
    createReply($topic_id, $author, $body);
    
    
} else {
    echo "Geçersiz istek.";
}
?>
