<?php
function fetch($url, $post = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return ['response' => $response, 'status' => $info['http_code'], 'url' => $info['url']];
}

// Login
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);
curl_close($ch);

if (preg_match('/name="csrf_token" value="([^"]+)"/', $response, $matches)) {
    $csrf = $matches[1];
    $r = fetch('http://localhost/Apotek/auth/login.php', "email=admin@apotek.com&password=admin123&csrf_token=$csrf");
    echo "Login HTTP: " . $r['status'] . " -> " . $r['url'] . "\n";
    
    $r = fetch('http://localhost/Apotek/user/checkout/');
    echo "Checkout HTTP: " . $r['status'] . "\n";
    if (strpos($r['response'], 'id_metode') !== false) {
        echo "CHECKOUT: PASS - id_metode found\n";
    } else {
        echo "CHECKOUT: FAIL - showing: " . substr(strip_tags($r['response']), 0, 200) . "\n";
    }
    
    $r = fetch('http://localhost/Apotek/admin/metode_pembayaran/');
    echo "Admin Metode HTTP: " . $r['status'] . "\n";
    if (strpos($r['response'], 'Transfer Bank BCA') !== false) {
        echo "ADMIN METODE: PASS\n";
    } else {
        echo "ADMIN METODE: FAIL\n";
    }
    
    $r = fetch('http://localhost/Apotek/api/notifikasi.php?act=count');
    echo "Notif API HTTP: " . $r['status'] . "\n";
    echo "Notif API body: " . substr($r['response'], 0, 200) . "\n";
    
    $r = fetch('http://localhost/Apotek/admin/pembayaran/');
    echo "Admin Pembayaran HTTP: " . $r['status'] . "\n";
    if (strpos($r['response'], 'Tujuan') !== false) {
        echo "ADMIN PEMBAYARAN: PASS\n";
    } else {
        echo "ADMIN PEMBAYARAN: FAIL\n";
    }
    
    $r = fetch('http://localhost/Apotek/user/booking/buat.php');
    echo "Booking Form HTTP: " . $r['status'] . "\n";
    if (strpos($r['response'], 'selectJadwal') !== false) {
        echo "BOOKING FORM: PASS\n";
    } else {
        echo "BOOKING FORM: FAIL\n";
    }
    
    $r = fetch('http://localhost/Apotek/user/pesanan/');
    echo "Pesanan HTTP: " . $r['status'] . "\n";
    if (strpos($r['response'], 'Belum ada pesanan') !== false || strpos($r['response'], 'PSN-') !== false) {
        echo "PESANAN: PASS\n";
    } else {
        echo "PESANAN: FAIL - " . substr(strip_tags($r['response']), 0, 200) . "\n";
    }
    
    $r = fetch('http://localhost/Apotek/admin/pesanan/');
    echo "Admin Pesanan HTTP: " . $r['status'] . "\n";
    if (strpos($r['response'], 'PSN-') !== false || strpos($r['response'], 'Menunggu Pembayaran') !== false) {
        echo "ADMIN PESANAN: PASS\n";
    } else {
        echo "ADMIN PESANAN: FAIL\n";
    }
}