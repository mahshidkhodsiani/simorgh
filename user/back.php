<?php
// فعال کردن گزارش خطا
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include '../config.php'; 

// =========================================================================
//                  ثابت‌ها و توابع ارتباط با API و SMS
// =========================================================================

// !!! این کلید را حتماً با کلید API واقعی خود جایگزین کنید !!!
define('SPOTPLAYER_API_KEY', 'aNOAHmD7i6t49l9O4YjS6wypggM=');
define('SPOTPLAYER_API_URL', 'https://panel.spotplayer.ir/license/edit/');

function filter_json_data($data): array {
	return array_filter($data, function ($v) { return !is_null($v); });
}

/**
 * ایجاد یا ویرایش لایسنس اسپات پلیر و مدیریت خطای اتصال.
 * @throws Exception پرتاب خطا در صورت شکست در اتصال یا دریافت پاسخ خطادار از API
 */
function create_spotplayer_license(string $name, array $courses, string $watermark_text, bool $test = false, string $invoiceID = null): ?array {

    // اضافه کردن زمان و یک شناسه یونیک به واترمارک برای یونیک بودن ۱۰۰٪ 
    // این کار خطای "واترمارک تکراری" را کاملاً از بین می‌برد.
    $unique_watermark = $watermark_text . "-" . time() . "-" . uniqid(); 

    $watermark_payload = [
        'texts' => [
            ['text' => $unique_watermark] 
        ]
    ];

    $payload = [
        'test'      => $test,
        'name'      => $name . "-" . time(), // نام لایسنس را هم یونیک می‌کنیم
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

/**
 * ارسال پیامک حاوی کلید لایسنس.
 */
function send_license_sms(string $mobile, string $license_key): bool {
    // ... (کد تابع SMS)
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

// =========================================================================
//                  منطق پردازش تراکنش
// =========================================================================

// 1. آخرین تراکنش pending با status=0 را پیدا می‌کنیم.
$stmt = $conn->prepare("SELECT * FROM pending_transactions WHERE status=0 ORDER BY id DESC LIMIT 1");
$stmt->execute();
$txn = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$txn) {
    header("Location: my_packages.php?error=no_pending_transaction");
    exit();
}

// مقادیر تراکنش
$invoiceID  = $txn['invoice_id'];
$user_id    = $txn['user_id'];
$package_id = $txn['package_id'];
$cart_id    = $txn['cart_id'];
$amount     = $txn['amount'];

// 2. گرفتن اطلاعات پکیج و موبایل کاربر
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
    error_log("CRITICAL: Package info or user mobile missing for user_id: " . $user_id . " and package_id: " . $package_id);
    die("خطا: اطلاعات پکیج، شناسه اسپات پلیر یا موبایل کاربر ناقص است.");
}

$course_name = $data['title'];
$spotplayer_course_id = $data['spotplayer'];
$user_mobile = $data['mobile'];

$license_key = null;

// ================= شروع تراکنش DB برای اطمینان از Rollback =================
// این خط تضمین می‌کند که اگر یک مرحله شکست خورد، بقیه مراحل ذخیره نشوند.
$conn->begin_transaction(); 

try {
    $spotplayer_courses = [$spotplayer_course_id];
    $custom_watermark = strval($user_id) . "-" . $user_mobile;
    
    // 1. صدور لایسنس (با واترمارک منحصر به فرد)
    $license_result = create_spotplayer_license(strval($user_id), $spotplayer_courses, $custom_watermark, false, $invoiceID);

    if (!isset($license_result['key'])) {
        throw new Exception("پاسخ API موفقیت‌آمیز بود، اما کلید لایسنس یافت نشد.");
    }
    
    $license_key = $license_result['key'];
    
    // 2. ثبت لایسنس در جدول user_package
    // حالا که ستون created_at به user_package اضافه شده، این خط باید بدون خطا اجرا شود.
    $stmt = $conn->prepare("INSERT INTO user_package (package_id, user_id, paid, license_key, created_at) VALUES (?, ?, 1, ?, NOW())");
    if (!$stmt) throw new Exception("DB Prepare failed (user_package insert): " . $conn->error);
    $stmt->bind_param("iis", $package_id, $user_id, $license_key);
    $stmt->execute();
    $stmt->close();

    // 3. ثبت در جدول contacts
    // این ستون created_at قبلاً وجود داشته و خطایی ندارد.
    $stmt = $conn->prepare("INSERT INTO contacts (user_id, course, amount, mobile, pardakht, created_at)
                            VALUES (?, ?, ?, ?, 1, NOW())");
    if (!$stmt) throw new Exception("DB Prepare failed (contacts insert): " . $conn->error);
    $stmt->bind_param("isis", $user_id, $course_name, $amount, $user_mobile);
    $stmt->execute();
    $stmt->close();

    // 4. حذف آیتم از user_cart 
    $stmt = $conn->prepare("DELETE FROM user_cart WHERE id=? AND user_id=?");
    if (!$stmt) throw new Exception("DB Prepare failed (user_cart delete): " . $conn->error);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $stmt->close();

    // 5. بروزرسانی وضعیت pending_transactions به 1 (انجام‌شده)
    $stmt = $conn->prepare("UPDATE pending_transactions SET status=1 WHERE invoice_id=?");
    if (!$stmt) throw new Exception("DB Prepare failed (pending update): " . $conn->error);
    $stmt->bind_param("s", $invoiceID);
    $stmt->execute();
    $stmt->close();

    // COMMIT نهایی
    // در صورت رسیدن به این مرحله، تمام تغییرات دیتابیس با موفقیت ثبت می‌شوند.
    $conn->commit();

    // 6. ارسال پیامک (بعد از commit)
    send_license_sms($user_mobile, $license_key);

    // 7. ریدایرکت نهایی
    header("Location: my_packages.php?success=1");
    exit();

} catch (Exception $e) {
    // خطا در صدور لایسنس -> Rollback تراکنش
    // تمام تغییراتی که در بلاک try رخ داده بودند، لغو می‌شوند.
    $conn->rollback();
    error_log("Exception during license creation for Invoice ID {$invoiceID}: " . $e->getMessage());
    
    // بروزرسانی وضعیت pending_transactions به 2 (خطا)
    $stmt2 = $conn->prepare("UPDATE pending_transactions SET status=2 WHERE invoice_id=?");
    if ($stmt2) {
        $stmt2->bind_param("i", $invoiceID); 
        $stmt2->execute();
        $stmt2->close();
    }
    
    // نمایش پیغام خطا به کاربر
    die("خطای بحرانی در صدور لایسنس. لطفاً با پشتیبانی تماس بگیرید. جزئیات: " . htmlspecialchars($e->getMessage()));
}