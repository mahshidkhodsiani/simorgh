<?php
// فعال کردن گزارش خطا
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include '../config.php'; 
require 'API/Gateway.php'; 
require 'ipgcfg.php';

// =========================================================================
//                  ثابت‌ها و توابع ارتباط با API و SMS
// =========================================================================

define('SPOTPLAYER_API_KEY', 'aNOAHmD7i6t49l9O4YjS6wypggM=');
define('SPOTPLAYER_API_URL', 'https://panel.spotplayer.ir/license/edit/');

function filter_json_data($data): array {
	return array_filter($data, function ($v) { return !is_null($v); });
}

function create_spotplayer_license(string $name, array $courses, string $watermark_text, bool $test = false, string $invoiceID = null): ?array {
    $unique_watermark = $watermark_text . "-" . time() . "-" . uniqid(); 

    $watermark_payload = [
        'texts' => [
            ['text' => $unique_watermark] 
        ]
    ];

    $payload = [
        'test'      => $test,
        'name'      => $name . "-" . time(),
        'course'    => $courses,
        'watermark' => $watermark_payload,
        'payload' => ($invoiceID ?? 'N/A') . '_' . $name . '_' . time(), 
        'device' => ['p0' => 3, 'p1' => 1]
    ];

	$ch = curl_init();
	curl_setopt_array($ch, [
		CURLOPT_URL            => SPOTPLAYER_API_URL,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CUSTOMREQUEST  => 'POST',
		CURLOPT_SSL_VERIFYHOST => false, 
		CURLOPT_SSL_VERIFYPEER => false, 
		CURLOPT_FOLLOWLOCATION => false,
		CURLOPT_TIMEOUT        => 30, 
		CURLOPT_HTTPHEADER     => [
            '$API: ' . SPOTPLAYER_API_KEY,
            '$LEVEL: -1',
            'content-type: application/json'
        ],
        CURLOPT_POSTFIELDS     => json_encode(filter_json_data($payload))
	]);

	$response_json = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    $curl_errno = curl_errno($ch);
	curl_close($ch);

    if ($curl_errno) {
        error_log("SpotPlayer API CRITICAL CURL Error [Code: " . $curl_errno . "]: " . $curl_error);
        throw new Exception("خطای اتصال CURL: " . $curl_error);
    }

	$result = json_decode($response_json, true);
    $ex = null;

    if ($http_code !== 200 || (is_array($result) && isset($result['ex']))) {
        if (is_array($result) && isset($result['ex'])) {
            $ex = $result['ex'];
        } else {
            $ex = ['msg' => 'HTTP Error (Not 200)', 'http_code' => $http_code, 'response' => $response_json];
        }
        $error_message = ($ex['msg'] ?? "HTTP Code: " . $http_code . " | Response: " . json_encode($ex));
        error_log("SpotPlayer API Error: " . $error_message);
        throw new Exception("SpotPlayer API Error: " . $error_message);
    }

	return $result;
}

function send_license_sms(string $mobile, string $license_key): bool {
    $username = "09124366786";
    $password = "96139290@sN";
    $from = "300016343000";
    $to = $mobile;
    $sms_message = "خرید شما با موفقیت انجام شد.\nکلید لایسنس اسپات پلیر شما:\n" . $license_key . "\nلطفا آن را در پلیر وارد کنید.";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://niksms.com/fa/publicapi/groupsms",
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            "username" => $username,
            "password" => $password,
            "numbers" => $to,
            "sendernumber" => $from,
            "message" => $sms_message
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30 
    ]);

    $response = curl_exec($ch);
    $curl_error = curl_error($ch);
    $success = ($response !== false);
    curl_close($ch);

    if (!$success) {
        error_log("SMS Send Error: " . $curl_error);
    }
    return $success;
}

function show_success_page($license_key, $package_name) {
    ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پرداخت موفق</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    .success-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .checkmark {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #4bb71b;
        stroke-miterlimit: 10;
        box-shadow: inset 0 0 0 #4bb71b;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }

    .checkmark-circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #4bb71b;
        fill: #fff;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark-check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }

    @keyframes scale {

        0%,
        100% {
            transform: none;
        }

        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }

    @keyframes fill {
        100% {
            box-shadow: inset 0 0 0 30px #4bb71b;
        }
    }

    .license-box {
        background: #f8f9fa;
        border: 2px dashed #667eea;
        border-radius: 10px;
        padding: 15px;
        font-family: 'Courier New', monospace;
        font-size: 16px;
        color: #333;
        word-break: break-all;
    }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="success-card p-5 text-center" style="max-width: 600px; width: 100%;">
            <svg class="checkmark mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
            </svg>

            <h2 class="text-success mb-3"><i class="bi bi-check-circle-fill"></i> پرداخت موفق!</h2>
            <p class="text-muted mb-4">خرید شما با موفقیت انجام شد و پکیج به حساب شما اضافه گردید.</p>

            <div class="alert alert-info">
                <i class="bi bi-box-seam"></i> <strong>پکیج:</strong> <?php echo htmlspecialchars($package_name); ?>
            </div>

            <h5 class="mt-4 mb-3"><i class="bi bi-key-fill text-warning"></i> کلید لایسنس شما:</h5>
            <div class="license-box mb-3" id="licenseKey">
                <?php echo htmlspecialchars($license_key); ?>
            </div>

            <button class="btn btn-outline-primary mb-4" onclick="copyLicense()">
                <i class="bi bi-clipboard"></i> کپی کلید لایسنس
            </button>

            <div class="alert alert-warning small">
                <i class="bi bi-info-circle"></i> کلید لایسنس به شماره موبایل شما نیز پیامک شده است.
            </div>

            <hr class="my-4">

            <a href="my_packages.php" class="btn btn-success btn-lg">
                <i class="bi bi-box-arrow-in-left"></i> مشاهده پکیج‌های من
            </a>
            <a href="index.php" class="btn btn-outline-secondary btn-lg ms-2">
                <i class="bi bi-house-door"></i> بازگشت به داشبورد
            </a>
        </div>
    </div>

    <script>
    function copyLicense() {
        const licenseText = document.getElementById('licenseKey').innerText;
        navigator.clipboard.writeText(licenseText).then(() => {
            alert('✅ کلید لایسنس کپی شد!');
        });
    }
    </script>
</body>

</html>
<?php
    exit();
}

function show_error_page($message, $show_support = true) {
    ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطا در پرداخت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
    body {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        min-height: 100vh;
    }

    .error-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="error-card p-5 text-center" style="max-width: 600px; width: 100%;">
            <i class="bi bi-x-circle-fill text-danger" style="font-size: 80px;"></i>
            <h2 class="text-danger mt-3 mb-3">خطا در پردازش پرداخت</h2>
            <p class="text-muted mb-4"><?php echo htmlspecialchars($message); ?></p>

            <?php if ($show_support): ?>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>توجه:</strong> در صورت کسر مبلغ از حساب شما، پول ظرف 72 ساعت بازگردانده می‌شود.
            </div>
            <div class="alert alert-info">
                <i class="bi bi-headset"></i> برای پیگیری با پشتیبانی تماس بگیرید: <strong>09124366786</strong>
            </div>
            <?php endif; ?>

            <hr class="my-4">

            <a href="user_cart.php" class="btn btn-primary btn-lg">
                <i class="bi bi-cart"></i> بازگشت به سبد خرید
            </a>
            <a href="index.php" class="btn btn-outline-secondary btn-lg ms-2">
                <i class="bi bi-house-door"></i> بازگشت به داشبورد
            </a>
        </div>
    </div>
</body>

</html>
<?php
    exit();
}

// =========================================================================
//                  🔥 مرحله 1: دریافت invoice از درگاه AsanPardakht
// =========================================================================

error_log("=== BACK.PHP STARTED (AsanPardakht) ===");
error_log("GET params: " . json_encode($_GET));
error_log("POST params: " . json_encode($_POST));

$invoiceID = $_REQUEST['invoice'] ?? null;

if (!$invoiceID) {
    error_log("ERROR: No invoice ID received");
    show_error_page("شناسه تراکنش یافت نشد.", true);
}

error_log("Processing Invoice: {$invoiceID}");

// =========================================================================
//                  مرحله 2: بررسی تراکنش در دیتابیس
// =========================================================================

$stmt = $conn->prepare("SELECT * FROM pending_transactions WHERE invoice_id=? AND status=0 LIMIT 1");
$stmt->bind_param("s", $invoiceID);
$stmt->execute();
$txn = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$txn) {
    error_log("ERROR: Transaction not found or already processed for Invoice: {$invoiceID}");
    show_error_page("تراکنش یافت نشد یا قبلاً پردازش شده است.", false);
}

error_log("Transaction found: user_id={$txn['user_id']}, package_id={$txn['package_id']}, amount={$txn['amount']}");

// =========================================================================
//                  🔥 مرحله 3: Verify با AsanPardakht (3 مرحله)
// =========================================================================

try {
    error_log("Step 1: Calling TranResult()...");
    
    // مرحله 1: TranResult
    $gateway = Gateway::make()->config($Username, $Password, $merchantConfigID)->invoiceId($invoiceID);
    $result = $gateway->TranResult();
    
    error_log("TranResult Response: " . json_encode($result));
    
    if ($result['code'] != 200) {
        throw new Exception("TranResult failed - Code: {$result['code']}, Response: " . json_encode($result['content']));
    }
    
    $payGateTranID = $result['content']['payGateTranID'] ?? null;
    if (!$payGateTranID) {
        throw new Exception("payGateTranID not found in TranResult response");
    }
    
    error_log("Step 2: Calling verify() with payGateTranID: {$payGateTranID}");
    
    // مرحله 2: Verify
    $verify = $gateway->verify($payGateTranID);
    
    error_log("Verify Response: " . json_encode($verify));
    
    if ($verify['code'] != 200) {
        throw new Exception("Verify failed - Code: {$verify['code']}, Response: " . json_encode($verify['content']));
    }
    
    error_log("Step 3: Calling settlement()...");
    
    // مرحله 3: Settlement
    $settlement = $gateway->settlement($payGateTranID);
    
    error_log("Settlement Response: " . json_encode($settlement));
    
    if ($settlement['code'] != 200) {
        throw new Exception("Settlement failed - Code: {$settlement['code']}, Response: " . json_encode($settlement['content']));
    }
    
    error_log("✅ Payment VERIFIED and SETTLED successfully!");
    
} catch (Exception $e) {
    error_log("❌ Payment verification/settlement FAILED: " . $e->getMessage());
    
    // بروزرسانی وضعیت به 2 (خطا)
    $stmt = $conn->prepare("UPDATE pending_transactions SET status=2 WHERE invoice_id=?");
    if ($stmt) {
        $stmt->bind_param("s", $invoiceID);
        $stmt->execute();
        $stmt->close();
    }
    
    show_error_page("خطا در تایید پرداخت: " . $e->getMessage(), true);
}

// =========================================================================
//                  مرحله 4: صدور لایسنس و ثبت اطلاعات
// =========================================================================

$user_id    = $txn['user_id'];
$package_id = $txn['package_id'];
$cart_id    = $txn['cart_id'];
$amount     = $txn['amount'];

$stmt = $conn->prepare("
    SELECT p.name AS title, p.spotplayer, u.mobile
    FROM packages p
    JOIN users u ON u.id = ?
    WHERE p.id = ?
");
$stmt->bind_param("ii", $user_id, $package_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data || empty($data['spotplayer']) || empty($data['mobile'])) {
    error_log("CRITICAL: Package info missing for user_id: {$user_id}, package_id: {$package_id}");
    show_error_page("اطلاعات پکیج یا کاربر ناقص است.", true);
}

$course_name = $data['title'];
$spotplayer_course_id = $data['spotplayer'];
$user_mobile = $data['mobile'];

error_log("Package info: name={$course_name}, spotplayer_id={$spotplayer_course_id}");

$license_key = null;

$conn->begin_transaction(); 

try {
    error_log("Creating SpotPlayer license...");
    
    $spotplayer_courses = [$spotplayer_course_id];
    $custom_watermark = strval($user_id) . "-" . $user_mobile;
    
    $license_result = create_spotplayer_license(strval($user_id), $spotplayer_courses, $custom_watermark, false, $invoiceID);

    if (!isset($license_result['key'])) {
        throw new Exception("کلید لایسنس از API دریافت نشد.");
    }
    
    $license_key = $license_result['key'];
    error_log("✅ License created: {$license_key}");
    
    $stmt = $conn->prepare("INSERT INTO user_package (package_id, user_id, paid, license_key, created_at) VALUES (?, ?, 1, ?, NOW())");
    if (!$stmt) throw new Exception("خطا در ذخیره لایسنس: " . $conn->error);
    $stmt->bind_param("iis", $package_id, $user_id, $license_key);
    $stmt->execute();
    $stmt->close();
    error_log("✅ License saved to user_package");

    $stmt = $conn->prepare("INSERT INTO contacts (user_id, course, amount, mobile, pardakht, created_at) VALUES (?, ?, ?, ?, 1, NOW())");
    if (!$stmt) throw new Exception("خطا در ثبت تماس: " . $conn->error);
    $stmt->bind_param("isis", $user_id, $course_name, $amount, $user_mobile);
    $stmt->execute();
    $stmt->close();
    error_log("✅ Contact record created");

    $stmt = $conn->prepare("DELETE FROM user_cart WHERE id=? AND user_id=?");
    if (!$stmt) throw new Exception("خطا در حذف سبد: " . $conn->error);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $stmt->close();
    error_log("✅ Cart item deleted");

    $stmt = $conn->prepare("UPDATE pending_transactions SET status=1 WHERE invoice_id=?");
    if (!$stmt) throw new Exception("خطا در بروزرسانی تراکنش: " . $conn->error);
    $stmt->bind_param("s", $invoiceID);
    $stmt->execute();
    $stmt->close();
    error_log("✅ Transaction status updated to 1");

    $conn->commit();
    error_log("✅ Database transaction COMMITTED");

    send_license_sms($user_mobile, $license_key);

    error_log("=== TRANSACTION COMPLETED SUCCESSFULLY ===");
    show_success_page($license_key, $course_name);

} catch (Exception $e) {
    $conn->rollback();
    error_log("❌ CRITICAL ERROR: " . $e->getMessage());
    
    $stmt2 = $conn->prepare("UPDATE pending_transactions SET status=2 WHERE invoice_id=?");
    if ($stmt2) {
        $stmt2->bind_param("s", $invoiceID);
        $stmt2->execute();
        $stmt2->close();
    }
    
    show_error_page("خطا در صدور لایسنس: " . $e->getMessage(), true);
}