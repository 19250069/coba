<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies5.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies5.txt');
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
curl_close($ch);

preg_match('/name="csrf_token" value="([^"]+)"/', $response, $matches);
$csrf = $matches[1] ?? '';
echo "CSRF: $csrf\n";

// Login
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "email=test@apotek.com&password=test123&csrf_token=$csrf");
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies5.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies5.txt');
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
curl_close($ch);

echo "Login body length: " . strlen($response) . "\n";
if (strpos($response, 'Dashboard') !== false) {
    echo "LOGIN: SUCCESS\n";
} else if (strpos($response, 'Email atau password salah') !== false) {
    echo "LOGIN: WRONG CREDENTIALS\n";
} else {
    echo "LOGIN: UNKNOWN\n";
}

// Checkout
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/user/checkout/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies5.txt');
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
curl_close($ch);

echo "Checkout body length: " . strlen($response) . "\n";
if (strpos($response, 'id_metode') !== false && strpos($response, 'Transfer Bank BCA') !== false) {
    echo "CHECKOUT: PASS\n";
} else {
    echo "CHECKOUT: FAIL - body: " . substr(strip_tags($response), 0, 300) . "\n";
}
