<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: giris.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title>Forum Topic - Forum</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    body {
        margin-top: 20px;
        background: #eee;
        color: #708090;
    }
    .icon-1x {
        font-size: 24px !important;
    }
    a {
        text-decoration: none;
    }
    .text-primary, a.text-primary:focus, a.text-primary:hover {
        color: #00ADBB!important;
    }
    .text-black, .text-hover-black:hover {
        color: #000 !important;
    }
    .font-weight-bold {
        font-weight: 700 !important;
    }
    .card-custom {
        border-left: 8px solid #00ADBB; /* Sol kenarlık rengi */
        border-top: none;
        border-right: none;
        border-bottom: none;
        margin-bottom: 1rem;
        padding: 1.25rem;
        background-color: #fff;
        width: calc(100% - 20px); /* Tam genişlik - boşluk */
        box-sizing: border-box; /* Kenar boşlukları dahil genişlik */
        margin-top: 20px; /* Yukarıdan boşluk */
        margin-right: auto; /* Sağdan boşluk bırak */
        margin-left: 20px; /* Soldan boşluk */
        /* Gölgeyi kaldırdık */
    }
    .card-custom .card-body {
        padding: 0; /* İçerik padding */
    }
    .card-custom .card-title {
        margin-bottom: 0.5rem;
    }
    .card-custom .card-text {
        margin-bottom: 0.5rem;
    }
    .profile-pic {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #ddd;
        display: inline-block;
        vertical-align: middle;
    }
</style>
</head>
<body>
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

<!-- Üst Menü Başlangıcı -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
  <a class="navbar-brand" href="main.php">Forum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="main.php">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Çıkış yap</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Üst Menü Sonu -->

<?php 
        if (isset($_GET['topic_id'])) {
            $topic_id = intval($_GET['topic_id']);
        } else {
            die("topic id yok");
        }
        include "utility.php";
        InitTopic($topic_id);
        SimulateReplys($topic_id);
      ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</body>

</html>
<!-- Yanıt ekleme metin kutusu -->

<div class="container mt-4" style="padding-left: 0; padding-right: 0;">
  <div class="row" style="margin-left: 0; margin-right: 0;">
    <div class="col-lg-12" style="padding-left: 20; padding-right: 0;">
      <form id="replyForm" style="display: flex; flex-direction: column; width: 100%;">
        <textarea id="replyText" class="form-control mb-2" rows="3" placeholder="create reply" required style="width: 100%;"></textarea>
        <input type="hidden" id="topicId" value="<?php echo htmlspecialchars($topic_id); ?>">
        <button type="submit" class="btn btn-primary" style="width: 100%;">Gönder</button>
      </form>
    </div>
  </div>
</div>
<script>
document.getElementById('replyForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Formun varsayılan davranışını engelle

    var replyText = document.getElementById('replyText').value;
    var topicId = document.getElementById('topicId').value;

    // Ajax ile POST isteği gönder
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'create_reply.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('replyText').value = ''; // Metin kutusunu temizle
            location.reload(); // Sayfayı yenile
        } else {
            alert('Bir hata oluştu: ' + xhr.status);
        }
    };

    xhr.send('topic_id=' + encodeURIComponent(topicId) + '&author=' + encodeURIComponent('<?php echo htmlspecialchars($_SESSION["username"]); ?>') + '&body=' + encodeURIComponent(replyText));
});
</script>


