<?php

$db_host = 'localhost';
$db_name = 'swiftq_db';
$db_user = 'root';
$db_pass = '';

$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!$pdo) {
    die("connection failed: " . mysqli_connect_error());
}
?>