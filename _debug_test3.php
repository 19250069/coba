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
curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
$response = curl_exec($ch);
curl_close($ch);

echo "Login page length: " . strlen($response) . "\n";

if (preg_match('/name="csrf_token" value="([^"]+)"/', $response, $matches)) {
    $csrf = $matches[1];
    echo "CSRF found: $csrf\n";
    
    $r = fetch('http://localhost/Apotek/auth/login.php', "email=admin@apotek.com&password=admin123&csrf_token=$csrf");
    echo "Login HTTP: " . $r['status'] . " -> " . $r['url'] . "\n";
    
    if ($r['status'] == 200 || $r['status'] == 302) {
        $r = fetch('http://localhost/Apotek/user/checkout/');
        echo "Checkout HTTP: " . $r['status'] . " URL: " . $r['url'] . "\n";
        if (strpos($r['response'], 'id_metode') !== false) {
            echo "CHECKOUT: PASS\n";
        } else {
            echo "CHECKOUT body: " . substr(strip_tags($r['response']), 0, 300) . "\n";
        }
        
        $r = fetch('http://localhost/Apotek/admin/metode_pembayaran/');
        echo "Admin Metode HTTP: " . $r['status'] . "\n";
        if (strpos($r['response'], 'Transfer Bank BCA') !== false) {
            echo "ADMIN METODE: PASS\n";
        } else {
            echo "ADMIN METODE body: " . substr(strip_tags($r['response']), 0, 300) . "\n";
        }
    }
} else {
    echo "CSRF token not found in login page\n";
    echo "Response: " . substr($response, 0, 500) . "\n";
}