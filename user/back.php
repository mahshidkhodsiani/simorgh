<?php
session_start();
include '../config.php';
require 'API/Gateway.php';
require 'ipgcfg.php';

// بررسی اینکه تراکنش در SESSION وجود دارد
if (!isset($_SESSION['invoice'])) {
    die("تراکنش یافت نشد.");
}

$invoice = $_SESSION['invoice'];
$invoiceID = $invoice['id'];
$amount = $invoice['amount'];
$user_id = $invoice['user_id'];
$package_name = $invoice['package_name'];

// دریافت اطلاعات برگشتی از Gateway
$refID = $_GET['refId'] ?? null; // بسته به Gateway
$status = $_GET['status'] ?? null;

// تایید تراکنش با Gateway (در صورت نیاز)
try {
    $verify = Gateway::make()
        ->config($Username, $Password, $merchantConfigID)
        ->amount($amount)
        ->invoiceId($invoiceID)
        ->verify($refID);

    if ($verify['code'] == 200) {
        // تراکنش موفق
        echo "تراکنش با موفقیت انجام شد. شماره فاکتور: $invoiceID";
        // اینجا می‌توان دیتابیس را بروزرسانی کرد
        // مثلا ثبت اینکه این کاربر پکیج را خریداری کرده
    } else {
        echo "تراکنش ناموفق بود: " . $verify['content'];
    }
} catch (Exception $e) {
    echo "خطای غیرمنتظره: " . $e->getMessage();
}

// پاک کردن SESSION تراکنش بعد از بررسی
unset($_SESSION['invoice']);
