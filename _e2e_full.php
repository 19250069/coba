<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function curl_fetch($url, $post = null, $cookies = 'cookies6.txt') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/' . $cookies);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return ['response' => $response, 'status' => $info['http_code'], 'url' => $info['url']];
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies6.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies6.txt');
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
curl_close($ch);

preg_match('/name="csrf_token" value="([^"]+)"/', $response, $matches);
$csrf = $matches[1] ?? '';
echo "CSRF: $csrf\n";

// Login
$r = curl_fetch('http://localhost/Apotek/auth/login.php', "email=test@apotek.com&password=test123&csrf_token=$csrf");
echo "Login: HTTP {$r['status']} -> " . substr($r['url'], -30) . "\n";

if (strpos($r['response'], 'Dashboard') !== false) {
    echo "LOGIN: SUCCESS\n";
    
    // Add to cart
    $cart_data = json_encode(['act' => 'add', 'id_obat' => 1, 'csrf_token' => $csrf]);
    $r = curl_fetch('http://localhost/Apotek/api/keranjang.php', $cart_data);
    echo "Add to cart: {$r['response']}\n";
    
    // Checkout
    $r = curl_fetch('http://localhost/Apotek/user/checkout/');
    echo "Checkout: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'id_metode') !== false && strpos($r['response'], 'Transfer Bank BCA') !== false) {
        echo "CHECKOUT: PASS\n";
    } else {
        echo "CHECKOUT: FAIL - body: " . substr(strip_tags($r['response']), 0, 300) . "\n";
    }
    
    // Dashboard
    $r = curl_fetch('http://localhost/Apotek/user/');
    echo "Dashboard: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'Dashboard') !== false && strpos($r['response'], 'Total Pesanan') !== false) {
        echo "DASHBOARD: PASS\n";
    } else {
        echo "DASHBOARD: FAIL\n";
    }
    
    // Medicine
    $r = curl_fetch('http://localhost/Apotek/user/obat/');
    echo "Obat: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'Paracetamol') !== false) {
        echo "OBAT: PASS\n";
    } else {
        echo "OBAT: FAIL\n";
    }
    
    // Booking form
    $r = curl_fetch('http://localhost/Apotek/user/booking/buat.php');
    echo "Booking: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'selectJadwal') !== false) {
        echo "BOOKING: PASS\n";
    } else {
        echo "BOOKING: FAIL\n";
    }
    
    // Admin pages (using admin login)
} else {
    echo "Customer login failed\n";
}

// Now test admin
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies_admin.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies_admin.txt');
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$response = curl_exec($ch);
curl_close($ch);

preg_match('/name="csrf_token" value="([^"]+)"/', $response, $matches);
$csrf = $matches[1] ?? '';

$r = curl_fetch('http://localhost/Apotek/auth/login.php', "email=admin@apotek.com&password=admin123&csrf_token=$csrf", 'cookies_admin.txt');
echo "\nAdmin Login: HTTP {$r['status']} -> " . substr($r['url'], -30) . "\n";

if (strpos($r['response'], 'Dashboard') !== false) {
    echo "ADMIN LOGIN: SUCCESS\n";
    
    $pages = [
        'admin/metode_pembayaran/' => 'Transfer Bank BCA',
        'admin/pembayaran/' => 'Tujuan',
        'admin/pesanan/' => 'PSN-',
        'admin/booking/' => 'BKG-',
        'admin/obat/' => 'Paracetamol',
        'admin/dokter/' => 'dr.',
        'admin/klinik/' => 'Klinik',
        'admin/jadwal/' => 'Senin',
        'admin/kota/' => 'Jakarta',
        'admin/spesialis/' => 'Penyakit',
        'admin/supplier/' => 'Kimia',
        'admin/kategori/' => 'Analgesik',
        'admin/user/' => 'Budi',
        'admin/review/' => 'review',
        'admin/pengiriman/' => 'JNE',
        'admin/laporan/' => 'Laporan',
        'admin/pengaturan/' => 'Pengaturan',
    ];
    
    foreach ($pages as $page => $needle) {
        $r = curl_fetch("http://localhost/Apotek/$page", null, 'cookies_admin.txt');
        $found = strpos($r['response'], $needle) !== false;
        echo strtoupper(str_replace('/', '_', $page)) . ": " . ($found ? 'PASS' : 'FAIL') . "\n";
    }
}
