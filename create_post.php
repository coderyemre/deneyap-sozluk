<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: giris.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Başlık ve içeriği al
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['username']; // Oturumdan kullanıcı adını al

    // Yeni konuyu veritabanına ekleme
    $sql = "INSERT INTO topics (post_title, post_content, post_author, post_date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
    }
    $stmt->bind_param('sss', $title, $content, $author);
    $stmt->execute();
    $topic_id = $stmt->insert_id; // Yeni oluşturulan konunun ID'sini al
    $stmt->close();
    $conn->close();

    // Yeni konu sayfasına yönlendir
    header("Location: topic.php?topic_id=" . $topic_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Create Post - Forum</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    body {
        margin-top: 20px;
        background: #eee;
        color: #708090;
    }
</style>
</head>
<body>
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Forum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Çıkış yap</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="setprofilephoto.php">SetProfilePhoto</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h2>Yeni Gönderi Oluştur</h2>
  <form method="post" action="create_post.php">
    <div class="mb-3">
      <label for="title" class="form-label">Başlık</label>
      <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
      <label for="content" class="form-label">İçerik</label>
      <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Gönder</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
