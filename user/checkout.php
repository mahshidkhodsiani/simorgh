<?php
session_start();
// برای نمایش خطاها در محیط توسعه
error_reporting(E_ALL);
ini_set('display_errors', 1);

// بررسی وجود کاربر و اطلاعات مورد نیاز در URL
if (!isset($_SESSION['all_data']) || !isset($_GET['cart_id']) || !isset($_GET['amount'])) {
    // در صورت ناقص بودن اطلاعات، کاربر به صفحه سبد خرید هدایت می‌شود.
    header("Location: user_cart.php?message=" . urlencode("اطلاعات پرداخت ناقص است.") . "&type=danger");
    exit;
}

include '../config.php';

$user_id = $_SESSION['all_data']['id'];
$cart_id = intval($_GET['cart_id']);
$amount = intval($_GET['amount']);

// یک شناسه فاکتور منحصر به فرد برای پیگیری تراکنش ایجاد می‌کنیم.
$invoiceID = "INV-" . $user_id . "-" . time() . "-" . $cart_id;

// فرض می‌کنیم فایل Gateway.php در پوشه API قرار دارد
require 'API/Gateway.php';
// فرض می‌کنیم فایل ipgcfg.php در همین پوشه قرار دارد
require 'ipgcfg.php';

// آدرس بازگشت پس از پرداخت را به صورت پویا می‌سازیم
$CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$CallBackUrl = dirname($CurUrl) . '/back.php?cart_id=' . $cart_id . '&user_id=' . $user_id;

try {
    $tokenResult = Gateway::make()
        ->config($Username, $Password, $merchantConfigID)
        ->amount($amount)
        ->callbackUrl($CallBackUrl) 
        ->description('پرداخت آیتم با شناسه ' . $cart_id)
        ->invoiceId($invoiceID)
        ->token();
    
    if ($tokenResult['code'] == 200) {
        // هدایت کاربر به صفحه پرداخت با توکن دریافتی
        Gateway::redirect($tokenResult['content']);
        exit();
    } else {
        // مدیریت خطا در صورت ناموفق بودن دریافت توکن
        $message = 'خطا در ایجاد تراکنش: ' . $tokenResult['content'];
        $message_type = "danger";
        header("Location: user_cart.php?message=" . urlencode($message) . "&type=" . $message_type);
        exit();
    }
} catch (Exception $e) {
    // نمایش خطاهای غیرمنتظره
    $message = "یک خطای غیرمنتظره رخ داد: " . $e->getMessage();
    $message_type = "danger";
    header("Location: user_cart.php?message=" . urlencode($message) . "&type=" . $message_type);
    exit();
}
?>