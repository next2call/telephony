<?php
$serverIP = $_SERVER['SERVER_ADDR'];
require_once '../conf/url_page.php';

if ($serverIP === $Public_ip) {
    echo "✅ Server IP is correct: " . $serverIP;
} else {
    echo "❌ Warning! Server IP mismatch.<br>";
    echo "🔹 Expected: <b>$expectedIP</b><br>";
    echo "🔹 Found: <b>$serverIP</b><br>";
    echo "👉 Please update your IP path (/Telephony/confe/defineyour_ip.php";
}
?>
