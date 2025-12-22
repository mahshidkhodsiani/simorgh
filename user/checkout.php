<?php
session_start();
include '../config.php';
require 'API/Gateway.php'; 
require 'ipgcfg.php'; 

function send_verification_sms(string $mobile, string $code) {
    $username = "09124366786";
    $password = "96139290@sN";
    $from = "300016343000";
    $to = $mobile;
    $sms_message = "کد تایید پرداخت شما: " . $code . "\nسیمرغ";
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://niksms.com/fa/publicapi/groupsms",
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query(["username" => $username, "password" => $password, "numbers" => $to, "sendernumber" => $from, "message" => $sms_message]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30 
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return ($response !== false) ? true : "خطا در ارسال پیامک";
}

if (!isset($_SESSION['all_data'])) { header("Location: login.php"); exit(); }

$user_id = $_SESSION['all_data']['id'];
$mobile = $_SESSION['all_data']['mobile'] ?? '0'; 
$message = '';
$message_type = '';

$cart_id = intval($_GET['cart_id'] ?? 0);
$final_amount = intval($_GET['amount'] ?? 0); // مبلغی که از سبد خرید نهایی شده

if (!$cart_id || !$final_amount) { header("Location: user_cart.php"); exit(); }

// پیدا کردن پکیج
$stmt = $conn->prepare("SELECT package_id FROM user_cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$package_id = $stmt->get_result()->fetch_assoc()['package_id'];
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    if (isset($_SESSION['sms_code']) && $_POST['verify_code'] === $_SESSION['sms_code']) {
        unset($_SESSION['sms_code']);
        $invoiceID = time(); 

        // ثبت تراکنش با مبلغ نهایی دریافتی
        $stmt = $conn->prepare("INSERT INTO pending_transactions (invoice_id, user_id, package_id, cart_id, amount, status) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("iiiii", $invoiceID, $user_id, $package_id, $cart_id, $final_amount);
        $stmt->execute();
        $stmt->close();
        
        $CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['REQUEST_URI']) . '/back.php';

        try {
            $result = Gateway::make()
                ->config($Username, $Password, $merchantConfigID, $CurUrl)
                ->amount($final_amount) 
                ->invoiceId($invoiceID)
                ->token(); 

            if ($result['code'] == 200) {
                Gateway::redirect($result['content'], $mobile);
                exit();
            }
        } catch (Exception $e) { die("Error: " . $e->getMessage()); }
    } else {
        $message = "کد تایید اشتباه است."; $message_type = "danger";
    }
} 

if (!isset($_SESSION['sms_code']) || $message_type == 'danger') {
    $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    if (send_verification_sms($mobile, $code) === true) { $_SESSION['sms_code'] = $code; $message = "کد ارسال شد."; $message_type = "success"; }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تایید پرداخت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5" style="max-width: 450px;">
        <div class="card shadow-sm p-4">
            <h5 class="text-center mb-4">تایید کد امنیتی</h5>
            <div class="alert alert-warning text-center small">مبلغ: <?php echo number_format($final_amount); ?> ریال
            </div>
            <?php if ($message): ?> <div class="alert alert-<?php echo $message_type; ?> text-center">
                <?php echo $message; ?></div> <?php endif; ?>
            <form method="POST">
                <input type="text" name="verify_code" class="form-control text-center mb-3" placeholder="کد ۴ رقمی"
                    required>
                <button type="submit" class="btn btn-primary w-100">پرداخت آنلاین</button>
            </form>
        </div>
    </div>
</body>

</html>