<?php 
echo "MERHABA"

?>
<?php 
$allow_register = true;
$host = 'localhost'; 
$dbname = 'yorukdatabase';
$user = 'root'; 
$pass = ''; 


$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

// form veri cek
$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
$level = 0; // default user = 0 admin = 1 banned = -1

// check username and pass
if ($username == "" || $password == "") {
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Hata</title>';
    echo '<style>';
    echo 'body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background: #f4f4f4; }';
    echo '.message-box { padding: 20px; border-radius: 5px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; width: 300px; text-align: center; }';
    echo '.redirect-link { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="message-box">';
    echo '<h2>kutucukları doldur </h2>';
    echo '<a class="redirect-link" href="kaydol.php">Tekrar Deneyin</a>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit();
}

//güvenlik için kullanıcı varmı diye kontrol et 
$check_sql = "SELECT COUNT(*) FROM users WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param('s', $username);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    // zeki pici uyar // kullanıcı adı varsa gönder
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Hata</title>';
    echo '<style>';
    echo 'body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background: #f4f4f4; }';
    echo '.message-box { padding: 20px; border-radius: 5px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; width: 300px; text-align: center; }';
    echo '.redirect-link { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="message-box">';
    echo '<h2>Bi zeki sensin zaten amk!Username was taken</h2>';
    echo '<a class="redirect-link" href="kaydol.php">Tekrar Deneyin</a>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit();
}

// kaydet
$sql = "INSERT INTO users (username, password, level) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Sorgu hazırlanırken bir hata oluştu: " . $conn->error);
}

$stmt->bind_param('ssi', $username, $password, $level);
$stmt->execute();

if ($stmt->affected_rows > 0 && $allow_register) {
    //kaydolma scripti
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Kayıt Başarılı</title>';
    echo '<style>';
    echo 'body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background: #f4f4f4; }';
    echo '.message-box { padding: 20px; border-radius: 5px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; width: 300px; text-align: center; }';
    echo '.redirect-link { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="message-box">';
    echo '<h2>aramıza hoşgeldin deneyaplı</h2>';
    echo '<a class="redirect-link" href="main.html">Ana Sayfaya Dön</a>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
} else {
    // baiarısız kayıt 
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Hata</title>';
    echo '<style>';
    echo 'body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background: #f4f4f4; }';
    echo '.message-box { padding: 20px; border-radius: 5px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; width: 300px; text-align: center; }';
    echo '.redirect-link { display: block; margin-top: 20px; text-decoration: none; color: #007bff; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="message-box">';
    echo '<h2>kaydolamadın nigga galiba kayıtlar kapandı </h2>';
    echo '<a class="redirect-link" href="kaydol.php">Tekrar Deneyin</a>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
}
$stmt->close();
$conn->close();
?>
