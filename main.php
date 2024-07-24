<?php
session_start();
include "conn.php";


if (!isset($_SESSION['username'])) {
    header('Location: giris.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>En Kral Forum</title>
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
</style>
</head>
<body>
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

<!-- Üst Menü Başlangıcı -->
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
          <a class="nav-link" href="setprofilephoto.php">Profil Fotoğrafı Ayarla</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<!-- Üst Menü Sonu -->

<div class="container">
  <div class="row">
    <!-- Sol Kısım -->
    <div class="col-lg-9 mb-3">
      <div class="row text-left mb-5">
        <div class="col-lg-6 mb-3 mb-sm-0">
          <div class="dropdown bootstrap-select form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50" style="width: 100%;">
            <select class="form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50" data-toggle="select" tabindex="-98">
              <option> Kategoriler </option>
              <option> Öğren </option>
              <option> Paylaş </option>
              <option> İnşa Et </option>
              <option> İfşa </option>
            </select>
          </div>
        </div>
        <div class="col-lg-6 text-lg-right">
          <div class="dropdown bootstrap-select form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50" style="width: 100%;">
            <select class="form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50" data-toggle="select" tabindex="-98">
              <option> Filtrele </option>
              <option> Oy </option>
              <option> Yorum Sayısı </option>
              <option> Görüntüleme </option>
            </select>
          </div>
        </div>
      </div>
        
      <?php 
        include "utility.php";
      PrepareTopicsForFirstLogin($conn);
      $stats = getStats($conn);
      ?>

      <!-- Diğer Kartlar Burada Devam Edecek -->
    </div>

    <!-- Sağ Kısım -->
    <div class="col-lg-3 mb-4 mb-lg-0 px-lg-0 mt-lg-0">
      <div data-children=".item" class="pl-lg-4">
        <div class="item">
          <div class="card mb-2">
            <div class="card-body">
              <h5 class="card-title">Hakkımızda</h5>
              <p class="card-text">Deneyap Forum'a hoş geldiniz! Burası teknoloji meraklılarının buluşma noktası. Kod, robot, elektronik ne varsa konuştuğumuz, projelerimizi paylaştığımız bir yer. Misyonumuz mu? Eğlenmek ve öğrenmek!
              
              Kolpa Alarmı</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card mb-2">
            <div class="card-body">
              <h5 class="card-title">Öne Çıkanlar</h5>
              <div class="card-text">
                <a href="topic.php?topic_id=13" class="d-block mb-2">Beytullah İfşa</a>
                <a href="#" class="d-block mb-2">Ferhat Gövercin Aslında Kim?</a>
                <a href="#" class="d-block mb-2">Yörük Bot Dünyayı Ele Geçirecek mi?</a>
                <a href="#" class="d-block">Ap Rammus OP mi?</a>
              </div>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card mb-2">
            <div class="card-body">
              <h5 class="card-title">İstatistikler</h5>
              <p class="card-text"><b>Toplam Üye:</b> <?php echo number_format($stats['total_members']); ?></p>
              <p class="card-text"><b>Konular:</b> <?php echo number_format($stats['total_posts']); ?></p>
              <p class="card-text"><b>Yorumlar:</b> <?php echo number_format($stats['total_comments']); ?></p>
            </div>
          </div>
          <div class="card mb-2">
    <div class="card-body">
      <h5 class="card-title">Create Post</h5>
      <a href="create_post.php" class="btn btn-primary w-100">Yeni Gönderi Oluştur</a>
    </div>
  </div>
</div>
        </div>
      </div>
    </div>
    <div class="item">
 
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
