<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function fetch($url, $post = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies4.txt');
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

// Get login page
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies4.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies4.txt');
curl_setopt($ch, CURLOPT_ENCODING, '');
$response = curl_exec($ch);
curl_close($ch);

if (preg_match('/name="csrf_token" value="([^"]+)"/', $response, $matches)) {
    $csrf = $matches[1];
    echo "CSRF: $csrf\n";
    
    // Login as customer
    $r = fetch('http://localhost/Apotek/auth/login.php', "email=test@apotek.com&password=test123&csrf_token=$csrf");
    echo "Login: HTTP {$r['status']} -> {$r['url']}\n";
    
    // Checkout
    $r = fetch('http://localhost/Apotek/user/checkout/');
    echo "Checkout: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'id_metode') !== false && strpos($r['response'], 'Transfer Bank BCA') !== false) {
        echo "CHECKOUT: PASS\n";
    } else {
        echo "CHECKOUT: FAIL - body: " . substr(strip_tags($r['response']), 0, 300) . "\n";
    }
    
    // Dashboard
    $r = fetch('http://localhost/Apotek/user/');
    echo "Dashboard: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'Dashboard') !== false) {
        echo "DASHBOARD: PASS\n";
    } else {
        echo "DASHBOARD: FAIL\n";
    }
    
    // Medicine catalog
    $r = fetch('http://localhost/Apotek/user/obat/');
    echo "Obat: HTTP {$r['status']}\n";
    if (strpos($r['response'], 'Paracetamol') !== false) {
        echo "OBAT: PASS\n";
    } else {
        echo "OBAT: FAIL\n";
    }
    
    // Notification API
    $r = fetch('http://localhost/Apotek/api/notifikasi.php?act=count');
    echo "Notif API GET count: HTTP {$r['status']}\n";
    echo "Notif body: " . substr($r['response'], 0, 100) . "\n";
    
    // Test POST notification action
    $post_data = json_encode(['act' => 'read_all', 'csrf_token' => $csrf]);
    $r = fetch('http://localhost/Apotek/api/notifikasi.php', $post_data);
    echo "Notif POST: HTTP {$r['status']}\n";
    echo "Notif POST body: " . substr($r['response'], 0, 100) . "\n";
    
    // Logout
    $r = fetch('http://localhost/Apotek/auth/logout.php');
    echo "Logout: HTTP {$r['status']}\n";
} else {
    echo "CSRF not found\n";
}
