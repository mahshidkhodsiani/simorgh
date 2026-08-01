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

// دریافت قیمت کافه از دیتابیس
$cafe_id = 2;
$query = "SELECT price FROM radios WHERE id = $cafe_id";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$price_in_toman = $row['price']; 
$price_in_rial = $price_in_toman * 10; 

$invoice_id = time() . rand(100, 999);
$callbackUrl = "https://simorghtv.com/radios/API/callback_radio_cafe.php";

// ★★★ این خط درست ارسال فاکتور به درگاه است ★★★
$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID, $callbackUrl)
    ->invoiceId($invoice_id)
    ->amount($price_in_rial);

$result = $gateway->token();

if ($result['code'] == 200) {
    // ذخیره درخواست در دیتابیس
    $sql = "INSERT INTO user_radio (user_id, radio_type, program_id, paid, price, invoice_id, created_at) 
            VALUES (?, 'cafe', NULL, 0, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $price_in_toman, $invoice_id);
    $stmt->execute();
    $conn->close();
    
    // ★★★ هدایت به درگاه با Authority تولید شده ★★★
    Gateway::redirect($result['content'], '');
    exit();
} else {
    echo "خطا در اتصال به درگاه: " . $result['content'];
}
?>