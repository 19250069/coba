<?php
// Simulate a web request by including the file
ob_start();
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET = [];
$_POST = [];
$_SESSION = [];
require __DIR__ . '/auth/login.php';
$content = ob_get_clean();
echo "Content length: " . strlen($content) . "\n";
echo substr($content, 0, 500);
