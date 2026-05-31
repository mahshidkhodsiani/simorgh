<?php
// فعال‌سازی گزارش خطا برای دیباگ (در حالت اصلی روی 0 بگذارید)
ini_set('display_errors', 0);
error_reporting(E_ALL);

session_start();

// فراخوانی فایل‌های پیکربندی
include '../config.php'; 
require 'API/Gateway.php'; 
require 'ipgcfg.php';

// =========================================================================
// ثابت‌ها و توابع کاربردی
// =========================================================================

define('SPOTPLAYER_API_KEY', 'aNOAHmD7i6t49l9O4YjS6wypggM=');
define('SPOTPLAYER_API_URL', 'https://panel.spotplayer.ir/license/edit/');

function filter_json_data($data) { 
    return array_filter($data, function ($v) { return !is_null($v); }); 
}

/**
 * تابع ساخت لایسنس در اسپات پلیر
 */
function create_spotplayer_license($user_id, $courses, $watermark_text, $invoiceID) {
    $payload = [
        'test'      => false,
        'name'      => "User-" . $user_id . "-" . time(),
        'course'    => $courses,
        'watermark' => ['texts' => [['text' => $watermark_text]]],
        'payload'   => $invoiceID, 
        'device'    => ['p0' => 3, 'p1' => 1] // محدودیت دستگاه (مثلاً ۳ ویندوز، ۱ اندروید)
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => SPOTPLAYER_API_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_SSL_VERIFYPEER => false, 
        CURLOPT_HTTPHEADER     => [
            '$API: ' . SPOTPLAYER_API_KEY,
            '$LEVEL: -1',
            'content-type: application/json'
        ],
        CURLOPT_POSTFIELDS      => json_encode(filter_json_data($payload))
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

/**
 * تابع ارسال پیامک لایسنس
 */
function send_license_sms($mobile, $license_key) {
    $username = "09124366786";
    $password = "96139290@sN";
    $from = "300016343000";
    $sms_message = "خرید شما موفق بود.\nلایسنس شما:\n" . $license_key . "\nسیمرغ";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://niksms.com/fa/publicapi/groupsms");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "username" => $username, "password" => $password,
        "numbers" => $mobile, "sendernumber" => $from, "message" => $sms_message
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

/**
 * نمایش صفحه موفقیت
 */
function show_success_page($license_key, $package_name) {
    ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>پرداخت موفق</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <?php include "includes.php" ?>
    <style>
    body {
        background: #f4f7f6;
        font-family: Tahoma, sans-serif;
        text-align: center;
        padding-top: 50px;
    }

    .card {
        max-width: 500px;
        margin: auto;
        padding: 20px;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .license {
        background: #eee;
        padding: 10px;
        border: 1px dashed #333;
        word-break: break-all;
        margin: 15px 0;
        font-family: monospace;
    }
    </style>
</head>

<body>
    <div class="card">
        <h2 style="color: green;">✓ پرداخت با موفقیت انجام شد</h2>
        <p>پکیج: <strong><?php echo htmlspecialchars($package_name); ?></strong></p>
        <div class="license" id="lkey"><?php echo htmlspecialchars($license_key); ?></div>
        <button onclick="navigator.clipboard.writeText(document.getElementById('lkey').innerText); alert('کپی شد!')"
            class="btn btn-sm btn-outline-primary">کپی لایسنس</button>
        <hr>
        <a href="index.php" class="btn btn-success w-100">بازگشت به پنل کاربری</a>
    </div>
</body>

</html>
<?php
    exit();
}

/**
 * نمایش صفحه خطا
 */
function show_error_page($message) {
    ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>خطا در پرداخت</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>

<body style="background: #fff5f5; text-align: center; padding-top: 50px;">
    <div class="container">
        <h2 style="color: red;">خطا در پردازش پرداخت</h2>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
        <a href="user_cart.php" class="btn btn-primary">بازگشت به سبد خرید</a>
    </div>
</body>

</html>
<?php
    exit();
}

// =========================================================================
// شروع پردازش اصلی
// =========================================================================

// ۱. دریافت اطلاعات از درگاه (آسان پرداخت معمولاً POST می‌کند)
$invoiceID = $_REQUEST['invoice'] ?? null;
$payGateTranID = $_REQUEST['PayGateTranID'] ?? $_REQUEST['payGateTranID'] ?? null;

if (!$invoiceID) {
    show_error_page("شناسه فاکتور دریافت نشد.");
}

// ۲. بررسی وجود تراکنش در دیتابیس
$stmt = $conn->prepare("SELECT * FROM pending_transactions WHERE invoice_id=? AND status=0 LIMIT 1");
$stmt->bind_param("s", $invoiceID);
$stmt->execute();
$txn = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$txn) {
    show_error_page("این تراکنش قبلاً پردازش شده یا معتبر نیست.");
}

try {
    // ۳. عملیات Verify و Settlement در درگاه بانکی
    $gateway = Gateway::make()->config($Username, $Password, $merchantConfigID)->invoiceId($invoiceID);
    
    // اگر توکن تراکنش مستقیم نیامده، استعلام می‌کنیم
    if (!$payGateTranID) {
        $check = $gateway->TranResult();
        $payGateTranID = $check['content']['payGateTranID'] ?? null;
    }

    if (!$payGateTranID) {
        throw new Exception("بانک تراکنش را تایید نکرد.");
    }

    // تایید (Verify)
    $v_res = $gateway->verify($payGateTranID);
    if ($v_res['code'] != 200) throw new Exception("خطا در مرحله Verify بانک.");

    // تسویه (Settlement) - برای آسان‌پرداخت الزامی است
    $s_res = $gateway->settlement($payGateTranID);
    if ($s_res['code'] != 200) throw new Exception("خطا در مرحله Settlement بانک.");

    // ۴. دریافت اطلاعات تکمیلی برای اسپات پلیر
    $stmt = $conn->prepare("SELECT p.name, p.spotplayer, u.mobile FROM packages p JOIN users u ON u.id = ? WHERE p.id = ?");
    $stmt->bind_param("ii", $txn['user_id'], $txn['package_id']);
    $stmt->execute();
    $info = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$info) throw new Exception("اطلاعات پکیج در سیستم یافت نشد.");

    // ۵. صدور لایسنس اسپات پلیر
    $watermark = $txn['user_id'] . "-" . $info['mobile'];
    $spot_res = create_spotplayer_license($txn['user_id'], [$info['spotplayer']], $watermark, $invoiceID);

    if (!isset($spot_res['key'])) {
        throw new Exception("خطا در صدور لایسنس از سمت اسپات‌پلیر.");
    }
    $license_key = $spot_res['key'];

    // ۶. ثبت نهایی در دیتابیس (Transaction Safe)
    $conn->begin_transaction();

    // ثبت در پکیج‌های کاربر
    $stmt = $conn->prepare("INSERT INTO user_package (package_id, user_id, paid, license_key, created_at) VALUES (?, ?, 1, ?, NOW())");
    $stmt->bind_param("iis", $txn['package_id'], $txn['user_id'], $license_key);
    $stmt->execute();

    // ثبت در لیست کانتکت‌ها/فروش
    $stmt = $conn->prepare("INSERT INTO contacts (user_id, course, amount, mobile, pardakht, created_at) VALUES (?, ?, ?, ?, 1, NOW())");
    $stmt->bind_param("isis", $txn['user_id'], $info['name'], $txn['amount'], $info['mobile']);
    $stmt->execute();

    // حذف از سبد خرید
    $stmt = $conn->prepare("DELETE FROM user_cart WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $txn['cart_id'], $txn['user_id']);
    $stmt->execute();

    // بروزرسانی وضعیت تراکنش معلق
    $stmt = $conn->prepare("UPDATE pending_transactions SET status=1 WHERE invoice_id=?");
    $stmt->bind_param("s", $invoiceID);
    $stmt->execute();

    $conn->commit();

    // ۷. ارسال پیامک و نمایش نتیجه
    send_license_sms($info['mobile'], $license_key);
    show_success_page($license_key, $info['name']);

} catch (Exception $e) {
    if (isset($conn)) $conn->rollback();
    
    // ثبت خطا در دیتابیس برای پیگیری‌های بعدی
    $stmt = $conn->prepare("UPDATE pending_transactions SET status=2 WHERE invoice_id=?");
    $stmt->bind_param("s", $invoiceID);
    $stmt->execute();

    show_error_page($e->getMessage());
}