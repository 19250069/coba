<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function fetch($url, $post = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
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

// Step 1: Get login page
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
curl_setopt($ch, CURLOPT_ENCODING, '');
$response = curl_exec($ch);
curl_close($ch);

if (preg_match('/name="csrf_token" value="([^"]+)"/', $response, $matches)) {
    $csrf = $matches[1];
    echo "CSRF: $csrf\n";
    
    // Step 2: Login
    $r = fetch('http://localhost/Apotek/auth/login.php', "email=admin@apotek.com&password=admin123&csrf_token=$csrf");
    echo "Login: HTTP {$r['status']} -> {$r['url']}\n";
    
    // Step 3: Checkout
    $r = fetch('http://localhost/Apotek/user/checkout/');
    echo "Checkout: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'id_metode') !== false) {
        echo "CHECKOUT: PASS\n";
    } else {
        echo "CHECKOUT: FAIL\n";
    }
    
    // Step 4: Admin metode_pembayaran
    $r = fetch('http://localhost/Apotek/admin/metode_pembayaran/');
    echo "Admin Metode: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'Transfer Bank BCA') !== false) {
        echo "ADMIN METODE: PASS\n";
    } else {
        echo "ADMIN METODE: FAIL\n";
    }
    
    // Step 5: Notification API
    $r = fetch('http://localhost/Apotek/api/notifikasi.php?act=count');
    echo "Notif API: HTTP {$r['status']}\n";
    echo "Notif body: " . substr($r['response'], 0, 100) . "\n";
    
    // Step 6: Admin pembayaran
    $r = fetch('http://localhost/Apotek/admin/pembayaran/');
    echo "Admin Pembayaran: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'Tujuan') !== false) {
        echo "ADMIN PEMBAYARAN: PASS\n";
    } else {
        echo "ADMIN PEMBAYARAN: FAIL\n";
    }
    
    // Step 7: Booking form
    $r = fetch('http://localhost/Apotek/user/booking/buat.php');
    echo "Booking: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'selectJadwal') !== false) {
        echo "BOOKING: PASS\n";
    } else {
        echo "BOOKING: FAIL\n";
    }
    
    // Step 8: Admin pesanan
    $r = fetch('http://localhost/Apotek/admin/pesanan/');
    echo "Admin Pesanan: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'PSN-') !== false) {
        echo "ADMIN PESANAN: PASS\n";
    } else {
        echo "ADMIN PESANAN: FAIL\n";
    }
    
    // Step 9: Customer pesanan
    $r = fetch('http://localhost/Apotek/user/pesanan/');
    echo "Customer Pesanan: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'PSN-') !== false || strpos($r['response'], 'Belum ada pesanan') !== false) {
        echo "CUSTOMER PESANAN: PASS\n";
    } else {
        echo "CUSTOMER PESANAN: FAIL\n";
    }
    
    // Step 10: Test API booking exists
    $r = fetch('http://localhost/Apotek/api/jadwal_by_dokter_klinik.php?id_dokter=1&id_klinik=1');
    echo "Jadwal API: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'Senin') !== false || strpos($r['response'], 'Selasa') !== false || strpos($r['response'], '[]') !== false) {
        echo "JADWAL API: PASS\n";
    } else {
        echo "JADWAL API: FAIL - " . substr($r['response'], 0, 200) . "\n";
    }
    
} else {
    echo "CSRF not found\n";
}
