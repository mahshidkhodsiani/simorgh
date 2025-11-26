<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

function create_spotplayer_license(string $name, array $courses, string $watermark_text, bool $test = false): ?array {
    
    // ساختار کامل‌تر واترماک بر اساس مستندات (فقط متن ساده کافیست)
    $watermark_payload = [
        'texts' => [
            ['text' => $watermark_text] // شماره موبایل کاربر یا ID او
        ]
    ];
    
    $payload = [
        'test'      => $test,
        'name'      => $name, // نام کاربر یا شناسه او
        'course'    => $courses, // آرایه‌ای از شناسه دوره‌ها
        'watermark' => $watermark_payload,
        'payload' => $name . '_' . time(), // برای ردیابی در پنل اسپات پلیر (اختیاری)
        'device' => [
            'p0' => 3, // 3 دستگاه در مجموع (قابل تغییر است)
            'p1' => 1, // 1 دستگاه ویندوز (قابل تغییر است)
        ]
    ];

	$ch = curl_init();
	curl_setopt_array($ch, [
		CURLOPT_URL            => SPOTPLAYER_API_URL,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CUSTOMREQUEST  => 'POST',
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_FOLLOWLOCATION => false,
		CURLOPT_HTTPHEADER     => [
            // هدرهای ضروری بر اساس مستندات
            '$API: ' . SPOTPLAYER_API_KEY, 
            '$LEVEL: -1', 
            'content-type: application/json' 
        ],
        CURLOPT_POSTFIELDS     => json_encode(filter_json_data($payload))
	]);
    
	$response_json = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
    
	$result = json_decode($response_json, true);
    
	if ($http_code !== 200 || (is_array($result) && ($ex = @$result['ex']))) {
        // ثبت دقیق‌تر خطا
        error_log("SpotPlayer API Error: " . ($ex['msg'] ?? "HTTP Code: " . $http_code . " | Response: " . $response_json));
		return null;
	}
    
	return $result;
}

function send_license_sms(string $mobile, string $license_key): bool {
    // کد پیامک شما صحیح است.
    $username = "09124366786";
    $password = "96139290@sN";
    $from = "300016343000";
    $to = $mobile;
    // متن پیامک شامل کلید لایسنس
    $sms_message = "خرید شما با موفقیت انجام شد.\nکلید لایسنس اسپات پلیر شما:\n" . $license_key . "\nلطفا آن را در پلیر وارد کنید.";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://niksms.com/fa/publicapi/groupsms");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "username" => $username,
        "password" => $password,
        "numbers" => $to,
        "sendernumber" => $from,
        "message" => $sms_message
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $success = ($response !== false);
    curl_close($ch);
    
    if (!$success) {
        error_log("SMS Send Error: " . curl_error($ch));
    }
    return $success;
}

// =========================================================================
//                  منطق پردازش تراکنش موفق
// =========================================================================

// 1. آخرین تراکنش pending
$stmt = $conn->prepare("SELECT * FROM pending_transactions WHERE status=0 ORDER BY id DESC LIMIT 1");
$stmt->execute();
$txn = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$txn) {
    die("هیچ تراکنش pending برای پردازش وجود ندارد.");
}

// مقادیر تراکنش
$invoiceID  = $txn['invoice_id'];
$user_id    = $txn['user_id'];
$package_id = $txn['package_id'];
$cart_id    = $txn['cart_id'];
$amount     = $txn['amount'];

// 2. گرفتن اطلاعات پکیج (title, spotplayer) و موبایل کاربر (mobile)
// نام جدول: packages (جمع) - این کوئری صحیح است و خطای گزارش شده را رفع می‌کند
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
    die("خطا: اطلاعات پکیج، شناسه اسپات پلیر یا موبایل کاربر ناقص است.");
}

$course_name = $data['title'];
$spotplayer_course_id = $data['spotplayer']; 
$user_mobile = $data['mobile'];

$license_key = null;

// =========================================================================
//                  فراخوانی API اسپات پلیر و صدور لایسنس
// =========================================================================

try {
    // شناسه دوره باید آرایه باشد
    $spotplayer_courses = [$spotplayer_course_id]; 
    
    // استفاده از user_mobile برای واترماک (همانطور که در مستندات آمده)
    // استفاده از strval($user_id) به عنوان name
    $license_result = create_spotplayer_license(strval($user_id), $spotplayer_courses, $user_mobile, false); 

    if ($license_result && isset($license_result['key'])) {
        $license_key = $license_result['key'];
        
        // 3. ثبت در جدول user_package و ذخیره کلید لایسنس
        $stmt = $conn->prepare("INSERT INTO user_package (package_id, user_id, paid, license_key) VALUES (?, ?, 1, ?)");
        $stmt->bind_param("iis", $package_id, $user_id, $license_key);
        $stmt->execute();
        $stmt->close();
        
        // 4. ارسال پیامک حاوی کلید لایسنس
        send_license_sms($user_mobile, $license_key); // این پیامک کلید لایسنس را برای کاربر ارسال می‌کند.
        
    } else {
        error_log("CRITICAL: SpotPlayer License creation failed for invoice ID: " . $invoiceID);
        // اگر ساخت لایسنس شکست خورد، نباید تراکنش نهایی شود.
        die("خطای بحرانی در صدور لایسنس. لطفاً با پشتیبانی تماس بگیرید."); 
    }
    
} catch (Exception $e) {
    error_log("Exception during license creation: " . $e->getMessage());
    die("خطای غیرمنتظره در ارتباط با SpotPlayer.");
}


// =========================================================================
//                  نهایی‌سازی تراکنش در دیتابیس (فقط در صورت موفقیت لایسنس)
// =========================================================================

// 5. ثبت در جدول contacts
$stmt = $conn->prepare("INSERT INTO contacts (user_id, course, amount, pardakht, created_at) 
                        VALUES (?, ?, ?, 1, NOW())");
$stmt->bind_param("isi", $user_id, $course_name, $amount); 
$stmt->execute();
$stmt->close();

// 6. حذف آیتم از user_cart
$stmt = $conn->prepare("DELETE FROM user_cart WHERE id=?");
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$stmt->close();

// 7. بروزرسانی وضعیت pending_transactions
$stmt = $conn->prepare("UPDATE pending_transactions SET status=1 WHERE invoice_id=?");
$stmt->bind_param("i", $invoiceID);
$stmt->execute();
$stmt->close();

// 8. ریدایرکت به my_packages
header("Location: my_packages.php?success=1");
exit();
?>