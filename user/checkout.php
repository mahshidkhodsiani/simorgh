<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include '../config.php';
require 'API/Gateway.php';
require 'ipgcfg.php';

// بررسی ورود کاربر
if (!isset($_SESSION['all_data'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['all_data']['id'];
$mobile = $_SESSION['all_data']['mobile'];
$message = '';
$message_type = '';

// بررسی وجود cart_id در URL
if (!isset($_GET['cart_id'])) {
    die("آیتم سبد خرید مشخص نشده است.");
}
$cart_id = intval($_GET['cart_id']);

// گرفتن اطلاعات آیتم و package_id از دیتابیس
$sql = "SELECT p.price, p.id AS package_id 
        FROM user_cart uc 
        JOIN packages p ON uc.package_id = p.id 
        WHERE uc.id = ? AND uc.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $amount = (int)$row['price'];
    $package_id = $row['package_id'];
} else {
    die("آیتم سبد خرید یافت نشد یا دسترسی ندارید.");
}
$stmt->close();

// مرحله اول: پردازش فرم تأیید کد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    if (isset($_SESSION['sms_code']) && $_POST['verify_code'] === $_SESSION['sms_code']) {
        $_SESSION['is_verified'] = true;
    } else {
        $message = "کد وارد شده اشتباه است. لطفاً دوباره تلاش کنید.";
        $message_type = "danger";
    }
}

// مرحله دوم: اگر کد تأیید شده باشد، به مرحله پرداخت بروید
if (isset($_SESSION['is_verified']) && $_SESSION['is_verified'] === true) {
    $invoiceID = time();
    $CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['REQUEST_URI']) . '/back.php';

    $_SESSION['invoice'] = [
        'id' => $invoiceID,
        'amount' => $amount,
        'user_id' => $user_id,
        'package_id' => $package_id,
        'cart_id' => $cart_id
    ];
    
    // unset($_SESSION['is_verified']);

    if (isset($_SESSION['is_verified'])) {
        unset($_SESSION['is_verified']);
    }

    try {
        $result = Gateway::make()
            ->config($Username, $Password, $merchantConfigID, $CurUrl)
            ->amount($amount)
            ->invoiceId($invoiceID)
            ->token();

        if ($result['code'] == 200) {
            Gateway::redirect($result['content'], $mobile);
            exit();
        } else {
            echo '<div style="color:red">خطا هنگام ایجاد تراکنش:<br>';
            echo 'کد خطا: ' . $result['code'] . '<br>';
            echo 'شرح خطا: ' . $result['content'] . '</div>';
            exit();
        }
    } catch (Exception $e) {
        die("خطای غیرمنتظره: " . $e->getMessage());
    }
} else {
    // اگر کاربر هنوز تأیید نشده است، فرم را نمایش دهید و پیامک ارسال کنید
    $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    $_SESSION['sms_code'] = $code;

    $username = "09124366786";
    $password = "96139290@sN";
    $from = "300016343000";
    $to = $mobile;
    $sms_message = "کد تایید پرداخت شما: " . $code . "\nلطفا این کد را در صفحه پرداخت وارد نمایید.";

    $url = "https://niksms.com/fa/publicapi/groupsms";
    $data = [
        "username" => $username,
        "password" => $password,
        "numbers" => $to,
        "sendernumber" => $from,
        "message" => $sms_message,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
?>
    <!DOCTYPE html>
    <html lang="fa" dir="rtl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>تایید پرداخت</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .container {
                max-width: 500px;
                margin-top: 50px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="card p-4 shadow">
                <h5 class="card-title text-center">تایید کد پرداخت</h5>
                <p class="text-center text-muted">یک کد ۴ رقمی به شماره موبایل شما ارسال شد. لطفاً آن را وارد کنید.</p>
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?> text-center" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
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
