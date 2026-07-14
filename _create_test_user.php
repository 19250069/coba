<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pdo = new PDO("mysql:host=localhost;dbname=db_apotek;charset=utf8mb4", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create a test customer
$email = 'test@apotek.com';
$pass = password_hash('test123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT IGNORE INTO users (nama, email, password, no_hp, alamat, role, created_at) VALUES (?, ?, ?, ?, ?, 'customer', NOW())");
$stmt->execute(['Test User', $email, $pass, '081234000099', 'Jl. Test No. 1, Jakarta']);
echo "Customer created/verified: $email / test123\n";
