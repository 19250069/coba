<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);
curl_close($ch);

if (preg_match('/name="csrf_token" value="([^"]+)"/', $response, $matches)) {
    $csrf = $matches[1];
    echo "CSRF: $csrf\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "email=admin@apotek.com&password=admin123&csrf_token=$csrf");
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    echo "Login response length: " . strlen($response) . "\n";
    if (strpos($response, 'Dashboard') !== false || strpos($response, 'admin/') !== false) {
        echo "LOGIN: SUCCESS\n";
    } else {
        echo "LOGIN: FAILED\n";
    }
    
    // Test checkout page
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/user/checkout/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (strpos($response, 'id_metode') !== false && strpos($response, 'Transfer Bank BCA') !== false) {
        echo "CHECKOUT: PASS - payment destinations found\n";
    } else {
        echo "CHECKOUT: FAIL - payment destinations missing\n";
    }
    
    // Test admin metode_pembayaran
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/admin/metode_pembayaran/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (strpos($response, 'Transfer Bank BCA') !== false && strpos($response, 'DANA') !== false) {
        echo "ADMIN METODE PEMBAYARAN: PASS\n";
    } else {
        echo "ADMIN METODE PEMBAYARAN: FAIL\n";
    }
    
    // Test booking form has jadwal selector
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/user/booking/buat.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (strpos($response, 'selectJadwal') !== false && strpos($response, 'Jadwal Praktik') !== false) {
        echo "BOOKING FORM: PASS - jadwal selector found\n";
    } else {
        echo "BOOKING FORM: FAIL - jadwal selector missing\n";
    }
    
    // Test admin pembayaran has target/destination column
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/admin/pembayaran/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (strpos($response, 'Tujuan') !== false || strpos($response, 'a.n.') !== false) {
        echo "ADMIN PEMBAYARAN: PASS - destination info found\n";
    } else {
        echo "ADMIN PEMBAYARAN: FAIL - destination info missing\n";
    }
    
    // Test notification API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/api/notifikasi.php?act=count');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (strpos($response, '"count"') !== false) {
        echo "NOTIFICATION API: PASS\n";
    } else {
        echo "NOTIFICATION API: FAIL\n";
    }
    
} else {
    echo "Could not extract CSRF token\n";
}