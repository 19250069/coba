<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/user/checkout/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);
curl_close($ch);
echo "CHECKOUT RESPONSE:\n";
echo substr($response, 0, 1000);
echo "\n---\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/admin/metode_pembayaran/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);
curl_close($ch);
echo "ADMIN METODE PEMBAYARAN RESPONSE:\n";
echo substr($response, 0, 1000);
echo "\n---\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/api/notifikasi.php?act=count');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);
curl_close($ch);
echo "NOTIFICATION API RESPONSE:\n";
echo $response;
echo "\n---\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/admin/pembayaran/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);
curl_close($ch);
echo "ADMIN PEMBAYARAN HAS TUJUAN: " . (strpos($response, 'Tujuan') !== false ? 'YES' : 'NO') . "\n";
