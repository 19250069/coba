<?php
$html = file_get_contents(__DIR__ . '/_login2.html');
preg_match('/name="csrf_token" value="([^"]+)"/', $html, $m);
echo "CSRF: " . ($m[1] ?? "NOT FOUND") . "\n";
$csrf = $m[1] ?? '';

if ($csrf) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/auth/login.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "email=admin@apotek.com&password=admin123&csrf_token=$csrf");
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    echo "Login status: {$info['http_code']} -> {$info['url']}\n";
    
    if ($info['http_code'] == 200 || $info['http_code'] == 302) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/user/checkout/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $response = curl_exec($ch);
        curl_close($ch);
        
        if (strpos($response, 'id_metode') !== false) {
            echo "CHECKOUT: PASS\n";
        } else {
            echo "CHECKOUT: FAIL - body: " . substr(strip_tags($response), 0, 200) . "\n";
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/admin/metode_pembayaran/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $response = curl_exec($ch);
        curl_close($ch);
        
        if (strpos($response, 'Transfer Bank BCA') !== false) {
            echo "ADMIN METODE: PASS\n";
        } else {
            echo "ADMIN METODE: FAIL\n";
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/api/notifikasi.php?act=count');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $response = curl_exec($ch);
        curl_close($ch);
        echo "Notif API: " . substr($response, 0, 100) . "\n";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/admin/pembayaran/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $response = curl_exec($ch);
        curl_close($ch);
        echo "Admin Pembayaran: " . (strpos($response, 'Tujuan') !== false ? 'PASS' : 'FAIL') . "\n";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/user/booking/buat.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $response = curl_exec($ch);
        curl_close($ch);
        echo "Booking Form: " . (strpos($response, 'selectJadwal') !== false ? 'PASS' : 'FAIL') . "\n";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/admin/pesanan/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $response = curl_exec($ch);
        curl_close($ch);
        echo "Admin Pesanan: " . (strpos($response, 'PSN-') !== false ? 'PASS' : 'FAIL') . "\n";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/Apotek/api/jadwal_by_dokter_klinik.php?id_dokter=1&id_klinik=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        $response = curl_exec($ch);
        curl_close($ch);
        echo "Jadwal API: " . (strpos($response, 'Senin') !== false || strpos($response, 'Selasa') !== false || strpos($response, '[]') !== false ? 'PASS' : 'FAIL') . "\n";
    }
}
