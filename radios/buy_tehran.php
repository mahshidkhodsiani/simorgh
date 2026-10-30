<?php
session_start();
include '../config.php';
require_once 'API/Gateway.php';
require_once 'ipgcfg.php';

// ========== بررسی لاگین ==========
if (!isset($_SESSION['user_id'])) {
    $redirect = 'buy_tehran.php?season=' . (isset($_GET['season']) ? (int)$_GET['season'] : 1);
    header("Location: ../login.php?redirect=" . urlencode($redirect));
    exit();
}

$user_id = $_SESSION['user_id'];
$season  = isset($_GET['season']) ? (int)$_GET['season'] : 1;

// اعتبارسنجی فصل
if (!in_array($season, [1, 2], true)) {
    header("Location: tehran1.php");
    exit();
}

// ========== انتخاب radio_type بر اساس فصل ==========
$radio_type = ($season === 2) ? 'tehran2' : 'tehran';
$radio_id   = ($season === 2) ? 4 : 1;  // 1=فصل اول، 4=فصل دوم

// ========== بررسی خرید قبلی (اشتراک کامل) ==========
$check_sql = "SELECT id FROM user_radio 
              WHERE user_id = ? 
              AND radio_type = ? 
              AND paid = 1 
              AND program_id IS NULL 
              LIMIT 1";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("is", $user_id, $radio_type);
$check_stmt->execute();
if ($check_stmt->get_result()->num_rows > 0) {
    $check_stmt->close();
    header("Location: tehran{$season}.php?payment=already");
    exit();
}
$check_stmt->close();

// ========== دریافت قیمت از radios ==========
$radio_query = "SELECT price, name FROM radios WHERE id = $radio_id LIMIT 1";
$radio_result = $conn->query($radio_query);
if (!$radio_result || $radio_result->num_rows === 0) {
    die("خطا: اطلاعات فصل یافت نشد");
}
$radio_info = $radio_result->fetch_assoc();
$price_in_toman = (int)$radio_info['price'];
$price_in_rial  = $price_in_toman * 10;  // تبدیل به ریال برای درگاه
$radio_name     = $radio_info['name'];

// ========== ساخت invoice_id ==========
$invoice_id = time() . rand(100, 999);

// ========== callback ==========
$callbackUrl = "https://simorghtv.com/radios/API/callback_tehran.php";

// ========== درخواست token ==========
$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID, $callbackUrl)
    ->invoiceId($invoice_id)
    ->amount($price_in_rial);

$result = $gateway->token();

if ($result['code'] == 200) {
    // ========== ثبت درخواست خرید (pending) ==========
    $sql = "INSERT INTO user_radio 
            (user_id, radio_type, program_id, paid, price, invoice_id, created_at) 
            VALUES (?, ?, NULL, 0, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isii", $user_id, $radio_type, $price_in_toman, $invoice_id);
    $stmt->execute();
    $conn->close();
    
    // ========== هدایت به درگاه ==========
    Gateway::redirect($result['content'], '');
    exit();
} else {
    echo "خطا در اتصال به درگاه: " . $result['content'];
}
?>