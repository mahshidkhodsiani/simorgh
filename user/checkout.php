<?php
// فعال کردن گزارش خطا (فقط برای توسعه‌دهنده)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// =========================================================================
//                  فایل‌های حیاتی و توابع
// =========================================================================

include '../config.php';
require 'API/Gateway.php'; 
require 'ipgcfg.php'; // شامل $Username, $Password, $merchantConfigID

// توابع SMS 
function send_verification_sms(string $mobile, string $code) {
    $username = "09124366786";
    $password = "96139290@sN";
    $from = "300016343000";
    $to = $mobile;
    $sms_message = "کد تایید پرداخت شما: " . $code . "\nلطفا این کد را در صفحه پرداخت وارد نمایید.";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => "https://niksms.com/fa/publicapi/groupsms",
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query([
            "username"     => $username,
            "password"     => $password,
            "numbers"      => $to,
            "sendernumber" => $from,
            "message"      => $sms_message
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30 
    ]);

    $response = curl_exec($ch);
    $curl_error = curl_error($ch);
    $success = ($response !== false);
    curl_close($ch);

    if (!$success) {
        error_log("SMS Send Error: " . $curl_error);
        return "خطا در ارسال پیامک: " . $curl_error;
    }
    return true; 
}


// =========================================================================
//                  شروع منطق اصلی
// =========================================================================

// 1. بررسی ورود کاربر
if (!isset($_SESSION['all_data']) || empty($_SESSION['all_data']['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['all_data']['id'];
$mobile = $_SESSION['all_data']['mobile'] ?? '0'; 
$message = '';
$message_type = '';

// 2. گرفتن cart_id و اعتبارسنجی
$cart_id = intval($_GET['cart_id'] ?? 0);
if (!$cart_id) {
    header("Location: user_cart.php?error=cart_id_missing");
    exit();
}

// 3. گرفتن اطلاعات آیتم و package_id از دیتابیس
$stmt = $conn->prepare("SELECT p.price, p.id AS package_id
        FROM user_cart uc
        JOIN packages p ON uc.package_id = p.id
        WHERE uc.id = ? AND uc.user_id = ?");
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$row) {
    die("خطا: آیتم سبد خرید یافت نشد یا دسترسی ندارید.");
}
$amount = (int)$row['price'];
$package_id = $row['package_id'];

// =========================================================================
//                  منطق تایید SMS و شروع پرداخت (POST)
// =========================================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    
    $is_code_verified = (isset($_SESSION['sms_code']) && $_POST['verify_code'] === $_SESSION['sms_code'] && (time() - $_SESSION['sms_send_time'] < 300));
                        
    if ($is_code_verified) { 
        
        // --- کد تأیید شد: بلافاصله پرداخت را شروع می‌کنیم ---
        
        if (!isset($Username) || !isset($Password) || !isset($merchantConfigID)) {
            die("<h2 style='color:red'>FATAL CONFIG ERROR!</h2><p>یکی از متغیرهای پیکربندی درگاه (Username, Password, merchantConfigID) در فایل <code>ipgcfg.php</code> وجود ندارد.</p>");
        }

        // پاک کردن سشن‌های موقت
        unset($_SESSION['sms_code']);
        unset($_SESSION['sms_send_time']);
        
        $invoiceID = time(); 

        // 1. ذخیره تراکنش در pending_transactions با وضعیت 0 (Pending)
        $stmt = $conn->prepare("INSERT INTO pending_transactions (invoice_id, user_id, package_id, cart_id, amount, status) VALUES (?, ?, ?, ?, ?, 0)");
        
        if (!$stmt) {
            die("FATAL DB ERROR: Prepare statement failed. Error: " . $conn->error);
        }
        
        $stmt->bind_param("iiiii", $invoiceID, $user_id, $package_id, $cart_id, $amount);
        $stmt->execute();
        
        if ($stmt->error) {
            die("FATAL DB ERROR: Execute failed. Error: " . $stmt->error);
        }
        
        $stmt->close();
        
        $CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['REQUEST_URI']) . '/back.php';

        try {
            $result = Gateway::make()
                ->config($Username, $Password, $merchantConfigID, $CurUrl)
                ->amount($amount)
                ->invoiceId($invoiceID)
                ->token(); 

            if ($result['code'] == 200) {
                // ریدایرکت نهایی به درگاه
                Gateway::redirect($result['content'], $mobile);
                exit();
            } else {
                // در صورت خطا در API درگاه
                $conn->prepare("DELETE FROM pending_transactions WHERE invoice_id = ?")->bind_param("i", $invoiceID)->execute();
                
                die('<div style="color:red">خطا هنگام ایجاد تراکنش:<br>' .
                    'کد خطا: ' . htmlspecialchars($result['code']) . '<br>' .
                    'شرح خطا: ' . htmlspecialchars($result['content']) . '</div>');
            }
        } catch (Exception $e) {
            $conn->prepare("DELETE FROM pending_transactions WHERE invoice_id = ?")->bind_param("i", $invoiceID)->execute();
            die("خطای غیرمنتظره در اتصال به درگاه: " . htmlspecialchars($e->getMessage()));
        }
        
    } else {
        $message = "کد وارد شده اشتباه یا منقضی شده است. لطفاً دوباره تلاش کنید.";
        $message_type = "danger";
    }
} 

// =========================================================================
//                  ارسال SMS و نمایش فرم تایید (GET یا POST ناموفق)
// =========================================================================

{
    $code_validity_time = 300; 
    
    // اگر کد سشن وجود ندارد یا منقضی شده، یا خطا در POST داشتیم، مجدد ارسال کن
    if (!isset($_SESSION['sms_code']) || (time() - $_SESSION['sms_send_time'] > $code_validity_time) || $message_type == 'danger') { 
        $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        $sms_status = send_verification_sms($mobile, $code);

        if ($sms_status === true) {
            $_SESSION['sms_code'] = $code;
            $_SESSION['sms_send_time'] = time();
            
            if (empty($message) || $message_type != 'danger') { 
                $message = "کد تایید با موفقیت به شماره $mobile ارسال شد.";
                $message_type = "success";
            }
        } else {
            $message = $sms_status; 
            $message_type = "danger";
        }
    }

    // نمایش فرم تایید کد
    ?>
    <!DOCTYPE html>
    <html lang="fa" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تایید پرداخت</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .container { max-width: 500px; margin-top: 50px; }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="card p-4 shadow">
            <h5 class="card-title text-center">تایید کد پرداخت</h5>
            <p class="text-center text-muted">یک کد ۴ رقمی به شماره موبایل شما **<?php echo htmlspecialchars($mobile); ?>** ارسال شد. لطفاً آن را وارد کنید.</p>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="checkout.php?cart_id=<?php echo $cart_id; ?>">
                <div class="mb-3">
                    <label for="verify_code" class="form-label">کد تایید:</label>
                    <input type="text" class="form-control" id="verify_code" name="verify_code" required maxlength="4" pattern="\d{4}">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">تایید و ادامه</button>
                </div>
            </form>
        </div>
    </div>
    </body>
    </html>
    <?php
}