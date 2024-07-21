<?php
function createTopic($author, $title, $content) {
    $host = 'localhost';
    $dbname = 'yorukdatabase';
    $user = 'root';
    $pass = '';
    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // Veritabanına eklemek için SQL sorgusu
    $sql = "INSERT INTO topics (post_author, post_title, post_content, post_date) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
    }

    $date = date('Y-m-d'); // Geçerli tarihi al
    $stmt->bind_param('ssss', $author, $title, $content, $date);
    $stmt->close();
    $conn->close();
}

function PrepareTopicsForFirstLogin() {
    $host = 'localhost';
    $dbname = 'yorukdatabase';
    $user = 'root';
    $pass = '';
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql = "SELECT post_author, post_title, post_content, post_date FROM topics ORDER BY topic_id DESC LIMIT 5";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
    }

    $stmt->execute();
    $stmt->bind_result($post_author, $post_title, $post_content, $post_date);

    while ($stmt->fetch()) {
        echo '<div class="card row-hover pos-relative py-3 px-3 mb-3 border-primary border-top-0 border-right-0 border-bottom-0 rounded-0">';
        echo '<div class="row align-items-center">';
        echo '<div class="col-md-8 mb-3 mb-sm-0">';
        echo '<h5>';
        echo '<a href="#" class="text-primary">' . htmlspecialchars($post_title) . '</a>';
        echo '</h5>';
        echo '<p class="text-sm"><span class="op-6">Posted by </span><a class="text-black" href="#">' . htmlspecialchars($post_author) . '</a><span class="op-6"> at </span><a class="text-black" href="#">' . htmlspecialchars($post_date) . '</a></p>';
        echo '<div class="text-sm op-5"><a class="text-black mr-2" href="#">' . htmlspecialchars($post_content) . '</a></div>';
        echo '</div>';
        echo '<div class="col-md-4 op-7">';
        echo '<div class="row text-center op-7">';
        echo'<div class="col px-1"> <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">256 Votes</span> </div>';
echo'<div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">251 Replys</span> </div>';
echo'<div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">223 Views</span> </div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    $stmt->close();
    $conn->close();
}
function InitTopic($topic_id) {
    $host = 'localhost';
    $dbname = 'yorukdatabase';
    $user = 'root';
    $pass = '';
    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql = "SELECT post_author, post_title, post_content, post_date FROM topics WHERE topic_id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('i', $topic_id);
    $stmt->execute();
    $stmt->bind_result($post_author, $post_title, $post_content, $post_date);
    if ($stmt->fetch()) {
        echo '<div class="card row-hover pos-relative py-3 px-3 mb-3 border-primary border-top-0 border-right-0 border-bottom-0 rounded-0">';
        echo '<div class="row align-items-center">';
        echo '<div class="col-md-8 mb-3 mb-sm-0">';
        echo '<h5>';
        echo '<a href="#" class="text-primary">' . htmlspecialchars($post_title) . '</a>';
        echo '</h5>';
        echo '<div class="text-sm op-5"> <a class="text-black mr-2" href="#">' . htmlspecialchars($post_content) . '</a></div>';
        echo '<p class="text-sm"><span class="op-6">Posted</span> <span class="op-6">by</span> <a class="text-black" href="#">' . htmlspecialchars($post_author) . '</a></p>';
        echo '<span class="op-6">' . htmlspecialchars($post_date) . '</span>';
        echo '</div>';
        echo '<div class="col-md-4 op-7">';
        echo '<div class="row text-center op-7">';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo " veri çekilmedi  : topic id = " . htmlspecialchars($topic_id);
    }

    $stmt->close();
    $conn->close();
}
?>