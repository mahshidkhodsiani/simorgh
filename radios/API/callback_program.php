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

// ==========================================
// مثل back.php - گرفتن نتیجه
// ==========================================
$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID)
    ->invoiceId($invoiceID);

$result = $gateway->TranResult();

if ($result['code'] != 200) {
    file_put_contents(__DIR__ . '/tran_error.txt', 
        date('Y-m-d H:i:s') . " - TranResult Failed: " . print_r($result, true) . PHP_EOL,
        FILE_APPEND
    );
    header("Location: https://simorghtv.com/radios/tehran.php?payment=failed");
    exit;
}

$payGateTranID = $result['content']['payGateTranID'] ?? null;

if (empty($payGateTranID)) {
    header("Location: https://simorghtv.com/radios/tehran.php?payment=failed");
    exit;
}

// ==========================================
// مثل back.php - Verify و Settlement پشت سر هم
// ==========================================
$verify = $gateway->verify($payGateTranID);

if ($verify['code'] != 200) {
    file_put_contents(__DIR__ . '/verify_error.txt',
        date('Y-m-d H:i:s') . " - Verify Failed: " . print_r($verify, true) . PHP_EOL,
        FILE_APPEND
    );
    header("Location: https://simorghtv.com/radios/tehran.php?payment=failed");
    exit;
}

// مثل back.php - تسویه (Settlement)
$settlement = $gateway->settlement($payGateTranID);

if ($settlement['code'] != 200) {
    file_put_contents(__DIR__ . '/settlement_error.txt',
        date('Y-m-d H:i:s') . " - Settlement Failed: " . print_r($settlement, true) . PHP_EOL,
        FILE_APPEND
    );
    // حتی اگر Settlement خطا داد، باز هم پرداخت موفق است
}

// ==========================================
// آپدیت دیتابیس - مثل back.php
// ==========================================
$rrn = $result['content']['rrn'] ?? null;
$refID = $result['content']['refID'] ?? null;

$stmt = $conn->prepare("
    UPDATE user_radio 
    SET paid = 1, 
        payment_date = NOW(), 
        paygate_tran_id = ?, 
        ref_id = ?, 
        rrn = ? 
    WHERE invoice_id = ?
");

$stmt->bind_param("ssss", $payGateTranID, $refID, $rrn, $invoiceID);
$stmt->execute();
$stmt->close();
$conn->close();

// لاگ موفقیت
file_put_contents(__DIR__ . '/payment_success.txt',
    date('Y-m-d H:i:s') . " - SUCCESS - Invoice: $invoiceID - TransId: $payGateTranID" . PHP_EOL,
    FILE_APPEND
);

// مثل back.php - هدایت به صفحه موفقیت
header("Location: https://simorghtv.com/radios/tehran.php?payment=success");
exit;