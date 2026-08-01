<?php
session_start();
include '../config.php';
require_once 'API/Gateway.php';
require_once 'ipgcfg.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// بررسی اینکه کاربر قبلاً اشتراک کامل کافه را خریداری کرده یا نه
$user_id = $_SESSION['user_id'];
$check_sql = "SELECT * FROM user_radio WHERE user_id = ? AND radio_type = 'cafe' AND paid = 1 AND program_id IS NULL LIMIT 1";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $user_id);
$check_stmt->execute();
if ($check_stmt->get_result()->num_rows > 0) {
    header("Location: cafe_meh.php?payment=already");
    exit();
}
$check_stmt->close();

// دریافت قیمت کافه از دیتابیس
$cafe_id = 2;
$radio_query = "SELECT price FROM radios WHERE id = $cafe_id";
$radio_result = $conn->query($radio_query);
$radio_info = $radio_result->fetch_assoc();
$price_in_toman = $radio_info['price'] ?? 35000; // قیمت به تومان
$price_in_rial = $price_in_toman * 10; // تبدیل به ریال

$invoice_id = time() . rand(100, 999);
$callbackUrl = "https://simorghtv.com/radios/API/callback_cafe.php";

$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID, $callbackUrl)
    ->invoiceId($invoice_id)
    ->amount($price_in_rial);

$result = $gateway->token();

if ($result['code'] == 200) {
    // ثبت درخواست خرید در دیتابیس
    $sql = "INSERT INTO user_radio (user_id, radio_type, program_id, paid, price, invoice_id, created_at) 
            VALUES (?, 'cafe', NULL, 0, ?, ?, NOW())";
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