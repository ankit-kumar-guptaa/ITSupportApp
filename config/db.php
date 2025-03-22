<?php
$host = 'localhost';
$dbname = 'itsupport_db';
$username = 'root';
$password = '';

// For online server

// $host = 'localhost';
// $dbname = 'u634223065_itsupport_db';
// $username = 'u634223065_itsupport_db';
// $password = 'Ankit@1925@';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET time_zone = '+05:30'"); // Set to IST (India Standard Time)
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}