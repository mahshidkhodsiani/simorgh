<?php
session_start();
include '../config.php';
require_once 'API/Gateway.php';
require_once 'ipgcfg.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$price_in_toman = 50000; // قیمت اشتراک کامل به تومان
$price_in_rial = $price_in_toman * 10; // تبدیل به ریال

$invoice_id = time() . rand(100, 999);

$callbackUrl = "https://simorghtv.com/radios/API/callback_radio.php";

$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID, $callbackUrl)
    ->invoiceId($invoice_id)
    ->amount($price_in_rial); // ✅ ریال به درگاه می‌رود

$result = $gateway->token();

if ($result['code'] == 200) {
    $sql = "INSERT INTO user_radio (user_id, radio_type, program_id, paid, price, invoice_id, created_at) 
            VALUES (?, 'tehran', NULL, 0, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $price_in_toman, $invoice_id);
    $stmt->execute();
    $conn->close();
    
    Gateway::redirect($result['content'], '');
    exit();
} else {
    echo "خطا: " . $result['content'];
}
?>