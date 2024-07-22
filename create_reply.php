<?php
session_start();
date_default_timezone_set('Europe/Istanbul'); // Türkiye saat dilimi

if (!isset($_POST['topic_id']) || !isset($_POST['author']) || !isset($_POST['body'])) {
    die("Eksik veri.");
}

// Veritabanı bağlantısı
$host = 'localhost';
$dbname = 'yorukdatabase';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Yanıt oluşturma fonksiyonu
function createReply($topic_id, $author, $body) {
    global $conn;
    $current_timestamp = date('Y-m-d H:i:s');

    $sql = "INSERT INTO `replies` (`topic_id`, `author`, `body`, `date`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
    }
    $stmt->bind_param('ssss', $topic_id, $author, $body, $current_timestamp);
    $stmt->execute();
    $stmt->close();
}

// POST isteğini işle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic_id = $_POST['topic_id'];
    $author = $_POST['author'];
    $body = $_POST['body'];

    createReply($topic_id, $author, $body);

    echo "Yanıt başarıyla eklendi.";
} else {
    echo "Geçersiz istek.";
}

$conn->close();
?>
