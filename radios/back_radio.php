<?php
session_start();
include '../config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$invoice_id = isset($_REQUEST['invoice']) ? $_REQUEST['invoice'] : '';

if(empty($invoice_id)) {
    die("شماره فاکتور یافت نشد");
}

// ========== درست کردن مسیرها ==========
require_once __DIR__ . '/API/Gateway.php';   // مسیر درست Gateway
require_once __DIR__ . '/ipgcfg.php';        // مسیر درست ipgcfg
// ======================================

$gateway = Gateway::make();
$gateway->config($Username, $Password, $merchantConfigID);
$gateway->invoiceId($invoice_id);
$result = $gateway->TranResult();

if($result['code'] != 200) {
    header("Location: tehran.php?payment=failed");
    exit();
}

$tranData = $result['content'];
$status = isset($tranData['status']) ? $tranData['status'] : 0;
$payGateTranID = isset($tranData['payGateTranID']) ? $tranData['payGateTranID'] : '';

if($status != 1) {
    header("Location: tehran.php?payment=failed");
    exit();
}

$verify = $gateway->verify($payGateTranID);
if($verify['code'] != 200) {
    header("Location: tehran.php?payment=failed");
    exit();
}

$settlement = $gateway->settlement($payGateTranID);
if($settlement['code'] != 200) {
    header("Location: tehran.php?payment=failed");
    exit();
}

$conn->query("UPDATE user_radio_subscription 
              SET paid = 1, 
                  paygate_tran_id = '$payGateTranID', 
                  payment_date = NOW(),
                  expire_date = DATE_ADD(NOW(), INTERVAL 1 YEAR)
              WHERE invoice_id = '$invoice_id'");

$get_info = $conn->query("SELECT user_id, radio_slug FROM user_radio_subscription WHERE invoice_id = '$invoice_id'");
if($get_info && $get_info->num_rows > 0) {
    $info = $get_info->fetch_assoc();
    $_SESSION['user_id'] = $info['user_id'];
}

header("Location: tehran.php?payment=success");
exit();
?>