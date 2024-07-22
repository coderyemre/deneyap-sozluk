<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $host = 'localhost';
  $dbname = 'yorukdatabase';
  $user = 'root';
  $pass = '';
  $conn = new mysqli($host, $user, $pass, $dbname);

  if ($conn->connect_error) {
      die("Bağlantı hatası: " . $conn->connect_error);
  }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcıyı veritabanında kontrol et
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        header('Location: main.php'); // Ana sayfaya yönlendir
        exit();
    } else {
        $error_message = "Username or password incorrect.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Giriş Yap - Forum</title>
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
          <a class="nav-link" aria-current="page" href="main.php">Ana Sayfa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="giris.php">Giriş</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kaydol.html">Kaydol</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Üst Menü Sonu -->

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card mt-5">
        <div class="card-body">
          <h3 class="card-title text-center">Login</h3>
          <?php if (isset($error_message)) { ?>
          <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
          </div>
          <?php } ?>
          <form method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<h3 class="card-title text-center">bu siteye girmen için hesaba ihtiyacın var</h3>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
