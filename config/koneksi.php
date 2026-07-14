<?php
/* ============================================================
   config/koneksi.php
   Koneksi database (PDO) + konfigurasi dasar aplikasi
   ============================================================ */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_apotek');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

/* Base URL aplikasi (ubah sesuai letak folder di server) */
define('BASE_URL', 'http://localhost/Apotek/');

/* Path absolut */
define('APP_ROOT', dirname(__DIR__));

/* Folder upload */
define('UPLOAD_OBAT', APP_ROOT . '/uploads/obat/');
define('UPLOAD_BUKTI', APP_ROOT . '/uploads/bukti/');
define('URL_OBAT', BASE_URL . 'uploads/obat/');
define('URL_BUKTI', BASE_URL . 'uploads/bukti/');

/* Mulai session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Muat helper */
require_once APP_ROOT . '/functions/functions.php';
