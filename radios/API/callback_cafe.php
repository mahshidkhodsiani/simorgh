<?php
session_start();

ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

if (file_exists(__DIR__ . '/../../config.php')) {
    include __DIR__ . '/../../config.php';
} elseif (file_exists(__DIR__ . '/../config.php')) {
    include __DIR__ . '/../config.php';
} else {
    die("config.php پیدا نشد");
}

require_once 'Gateway.php';
require_once '../ipgcfg.php';

$invoiceID = isset($_GET['invoice']) ? trim($_GET['invoice']) : '';

if (empty($invoiceID)) {
    die("شماره فاکتور نامعتبر");
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("خطا در اتصال دیتابیس");
}
$conn->set_charset("utf8mb4");

// دریافت نتیجه از درگاه
$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID)
    ->invoiceId($invoiceID);

$result = $gateway->TranResult();

if ($result['code'] != 200) {
    file_put_contents(__DIR__ . '/tran_error_cafe.txt', 
        date('Y-m-d H:i:s') . " - TranResult Failed: " . print_r($result, true) . PHP_EOL,
        FILE_APPEND
    );
    header("Location: https://simorghtv.com/radios/cafe_meh.php?payment=failed");
    exit;
}

$payGateTranID = $result['content']['payGateTranID'] ?? null;

if (empty($payGateTranID)) {
    header("Location: https://simorghtv.com/radios/cafe_meh.php?payment=failed");
    exit;
}

// Verify تراکنش
$verify = $gateway->verify($payGateTranID);

if ($verify['code'] != 200) {
    file_put_contents(__DIR__ . '/verify_error_cafe.txt',
        date('Y-m-d H:i:s') . " - Verify Failed: " . print_r($verify, true) . PHP_EOL,
        FILE_APPEND
    );
    header("Location: https://simorghtv.com/radios/cafe_meh.php?payment=failed");
    exit;
}

// تسویه (Settlement)
$settlement = $gateway->settlement($payGateTranID);

if ($settlement['code'] != 200) {
    file_put_contents(__DIR__ . '/settlement_error_cafe.txt',
        date('Y-m-d H:i:s') . " - Settlement Failed: " . print_r($settlement, true) . PHP_EOL,
        FILE_APPEND
    );
}

// آپدیت دیتابیس
$rrn = $result['content']['rrn'] ?? null;
$refID = $result['content']['refID'] ?? null;

$stmt = $conn->prepare("
    UPDATE user_radio 
    SET paid = 1, 
        payment_date = NOW(), 
        paygate_tran_id = ?, 
        ref_id = ?, 
        rrn = ? 
    WHERE invoice_id = ? AND radio_type = 'cafe'
");

$stmt->bind_param("ssss", $payGateTranID, $refID, $rrn, $invoiceID);
$stmt->execute();
$stmt->close();

// بازیابی user_id و تنظیم مجدد سشن
$get_user = $conn->prepare("SELECT user_id FROM user_radio WHERE invoice_id = ? AND radio_type = 'cafe'");
$get_user->bind_param("s", $invoiceID);
$get_user->execute();
$user_result = $get_user->get_result();

if ($user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
    $user_id = $user_data['user_id'];
    
    // تنظیم مجدد سشن
    $_SESSION['user_id'] = $user_id;
    
    // بازیابی اطلاعات کامل کاربر از جدول users
    $user_sql = "SELECT * FROM users WHERE id = ?";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_info = $user_stmt->get_result()->fetch_assoc();
    
    if ($user_info) {
        $_SESSION['username'] = $user_info['username'];
        $_SESSION['email'] = $user_info['email'];
        $_SESSION['first_name'] = $user_info['first_name'];
        $_SESSION['last_name'] = $user_info['last_name'];
        $_SESSION['phone'] = $user_info['phone'] ?? '';
        $_SESSION['speaker'] = $user_info['speaker'] ?? 0;
    }
    $user_stmt->close();
}
$get_user->close();

$conn->close();

// لاگ موفقیت
file_put_contents(__DIR__ . '/payment_success_cafe.txt',
    date('Y-m-d H:i:s') . " - SUCCESS - Invoice: $invoiceID - TransId: $payGateTranID - UserID: " . ($_SESSION['user_id'] ?? 'unknown') . PHP_EOL,
    FILE_APPEND
);

// هدایت به صفحه موفقیت
header("Location: https://simorghtv.com/radios/cafe_meh.php?payment=success");
exit;
?>