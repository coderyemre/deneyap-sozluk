<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
error_reporting(E_ALL);
$dbservername = "sql209.infinityfree.com"; 
$dbusername = "if0_36940961"; 
$dbpassword = "2SZZdnNbwUEGw"; 
$dbdatabase = "if0_36940961_forum";

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbdatabase);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("MySQL bağlantısı başarısız: " . $conn->connect_error);
}
?>