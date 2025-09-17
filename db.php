<?php
$host = 'localhost';
$dbname = 'dbq7zj3u6hjgpc';
$username = 'uzrprp3rmtdfr';
$password = '#[qI(M3@k1bz';
 
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
