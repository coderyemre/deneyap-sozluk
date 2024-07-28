<?php
session_start();

include "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if ($check === false) {
        echo "Dosya bir resim değil.";
        $uploadOk = 0;
    }
    if ($_FILES["profile_pic"]["size"] > 5000000) {
        echo "Dosya çok büyük.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sadece JPG, JPEG, PNG ve GIF dosyalarına izin verilmektedir.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Dosya yüklenmedi.";
    } else {
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
            $username = $_SESSION['username']; // Kullanıcı adını alın
            $sql = "UPDATE users SET profile_pic = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', basename($_FILES["profile_pic"]["name"]), $username);
            if ($stmt->execute()) {
                echo "Dosya başarıyla yüklendi.";
            } else {
                echo "Veritabanına kaydedilirken bir hata oluştu.";
            }
            $stmt->close();
        } else {
            echo "Dosya yüklenirken bir hata oluştu.";
        }
    }
}

$conn->close();
?>
