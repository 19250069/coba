<?php
$f = file_get_contents(__DIR__ . '/_login2.html');
echo "Length: " . strlen($f) . "\n";
echo substr($f, 0, 2000);
echo "\n--- CSRF? ---\n";
if (strpos($f, 'csrf') !== false) {
    echo "FOUND: csrf\n";
} else {
    echo "NOT FOUND: csrf\n";
}
if (preg_match('/name="csrf_token" value="([^"]+)"/', $f, $m)) {
    echo "CSRF token: " . $m[1] . "\n";
} else {
    echo "CSRF token: NOT FOUND\n";
}
