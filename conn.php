<?php
$dbservername = "sql209.infinityfree.com"; 
$dbusername = "if0_36940961"; 
$dbpassword = "2SZZdnNbwUEGw"; 
$dbdatabase = "if0_36940961_forum";

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbdatabase);

if ($conn->connect_error) {
    die("MySQL bağlantısı başarısız: " . $conn->connect_error);
}
?>