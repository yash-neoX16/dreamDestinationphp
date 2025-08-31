<?php
$host = "localhost:3307"; 
$user = "root";   // default XAMPP username
$pass = "";       // default XAMPP password is empty
$db   = "dreamdestination"; // your database name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
