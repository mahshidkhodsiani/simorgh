<?php
/**
 * صفحه هدایت مستقیم به درگاه پرداخت (حذف تاییدیه پیامکی)
 */

session_start();
include '../config.php';
require 'API/Gateway.php'; 
require 'ipgcfg.php'; 

// ۱. بررسی دسترسی کاربر (آیا لاگین است؟)
if (!isset($_SESSION['all_data'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['all_data']['id'];
$mobile = $_SESSION['all_data']['mobile'] ?? '0'; 

// ۲. دریافت اطلاعات از URL (شناسه سبد خرید و مبلغ)
$cart_id = intval($_GET['cart_id'] ?? 0);
$final_amount = intval($_GET['amount'] ?? 0);

// اگر اطلاعات ناقص بود، بازگشت به سبد خرید
if (!$cart_id || !$final_amount) {
    header("Location: user_cart.php");
    exit();
}

// ۳. پیدا کردن پکیج مربوطه از دیتابیس
$stmt = $conn->prepare("SELECT package_id FROM user_cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$db_result = $stmt->get_result()->fetch_assoc();
$package_id = $db_result['package_id'] ?? 0;
$stmt->close();

if (!$package_id) {
    die("خطا: پکیج مورد نظر یافت نشد.");
}

// ۴. ایجاد شناسه فاکتور (استفاده از Time برای یونیک بودن موقت)
$invoiceID = time(); 

// ۵. ثبت تراکنش در جدول تراکنش‌های معلق (Pending)
$stmt = $conn->prepare("INSERT INTO pending_transactions (invoice_id, user_id, package_id, cart_id, amount, status) VALUES (?, ?, ?, ?, ?, 0)");
$stmt->bind_param("iiiii", $invoiceID, $user_id, $package_id, $cart_id, $final_amount);
$stmt->execute();
$stmt->close();

// ۶. ساخت آدرس بازگشت (Callback)
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
$CurUrl = $protocol . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['REQUEST_URI']) . '/back.php';

// ۷. تلاش برای اتصال به درگاه و هدایت مستقیم
try {
    // مقداردهی کلاس درگاه با متغیرهای فایل ipgcfg.php
    $result = Gateway::make()
        ->config($Username, $Password, $merchantConfigID, $CurUrl)
        ->amount($final_amount) 
        ->invoiceId($invoiceID)
        ->token(); 

    if (isset($result['code']) && $result['code'] == 200) {
        // حذف هرگونه کد پیامک قدیمی از سشن برای جلوگیری از تداخل
        unset($_SESSION['sms_code']);
        
        // انتقال آنی به صفحه بانک
        Gateway::redirect($result['content'], $mobile);
        exit();
    } else {
        // نمایش خطا در صورت عدم دریافت توکن از بانک
        $error_msg = $result['message'] ?? 'خطای نامشخص در ارتباط با بانک';
        die("متأسفانه اتصال به درگاه برقرار نشد. علت: " . $error_msg);
    }
} catch (Exception $e) { 
    die("خطای سیستم: " . $e->getMessage()); 
}
?>