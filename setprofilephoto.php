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
<meta charset="UTF-8">
<title>Profil Fotoğrafı Yükle</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Profil Fotoğrafı Yükle</h2>
    <form action="upload_profile_pic_process.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="profile_pic" class="form-label">Profil Fotoğrafı Seçin:</label>
            <input type="file" class="form-control" id="profile_pic" name="profile_pic" required>
        </div>
        <button type="submit" class="btn btn-primary">Yükle</button>
    </form>
</div>
</body>
</html>
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
<meta charset="UTF-8">
<title>Profil Fotoğrafı Yükle</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Profil Fotoğrafı Yükle</h2>
    <form action="upload_profile_pic_process.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="profile_pic" class="form-label">Profil Fotoğrafı Seçin:</label>
            <input type="file" class="form-control" id="profile_pic" name="profile_pic" required>
        </div>
        <button type="submit" class="btn btn-primary">Yükle</button>
    </form>
</div>
</body>
</html>
