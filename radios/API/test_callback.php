<?php
// تست کامل callback_radio_cafe.php بدون هیچگونه هدر
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Testing callback_radio_cafe.php</h1>";

// 1. شامل کردن فایل‌ها
echo "Step 1: Including config.php... ";
if (file_exists('../../config.php')) {
    include '../../config.php';
    echo "✅ OK<br>";
} else {
    die("❌ config.php not found");
}

echo "Step 2: Including ipgcfg.php... ";
if (file_exists('../ipgcfg.php')) {
    include '../ipgcfg.php';
    echo "✅ OK<br>";
} else {
    die("❌ ipgcfg.php not found");
}

echo "Step 3: Including Gateway.php... ";
if (file_exists('Gateway.php')) {
    require_once 'Gateway.php';
    echo "✅ OK<br>";
} else {
    die("❌ Gateway.php not found");
}

// 2. اتصال به دیتابیس
echo "Step 4: Connecting to database... ";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}
echo "✅ OK<br>";

// 3. تست با یک شماره فاکتور فرضی
$test_invoice = 123456789;
echo "Step 5: Creating gateway object with invoice $test_invoice... ";
$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID)
    ->invoiceId($test_invoice);
echo "✅ OK<br>";

echo "Step 6: Calling TranResult()... ";
$result = $gateway->TranResult();
echo "✅ Code: " . $result['code'] . "<br>";
echo "Content: <pre>" . print_r($result['content'], true) . "</pre>";

echo "<br><strong>Test completed without crash!</strong>";
?>