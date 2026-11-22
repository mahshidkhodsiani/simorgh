<?php
session_start();
include '../config.php';
require_once 'API/Gateway.php';
require_once 'ipgcfg.php';

// ========== بررسی لاگین ==========
if (!isset($_SESSION['user_id'])) {
    $redirect = 'buy_tehran.php?season=' . (isset($_GET['season']) ? (int)$_GET['season'] : 1);
    header("Location: ../login.php?redirect=" . urlencode($redirect));
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$season  = isset($_GET['season']) ? (int)$_GET['season'] : 1;

// اعتبارسنجی فصل
if (!in_array($season, [1, 2], true)) {
    header("Location: tehran1.php");
    exit();
}

// ========== انتخاب radio_type بر اساس فصل ==========
$radio_type = ($season === 2) ? 'tehran2' : 'tehran';
$radio_id   = ($season === 2) ? 4 : 1;  // 1=فصل اول، 4=فصل دوم

// ========== بررسی خرید قبلی (اشتراک کامل) ==========
$check_sql = "SELECT id FROM user_radio 
              WHERE user_id = ? 
              AND radio_type = ? 
              AND paid = 1 
              AND program_id IS NULL 
              LIMIT 1";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("is", $user_id, $radio_type);
$check_stmt->execute();
if ($check_stmt->get_result()->num_rows > 0) {
    $check_stmt->close();
    header("Location: tehran{$season}.php?payment=already");
    exit();
}
$check_stmt->close();

// ========== دریافت قیمت از radios ==========
$radio_query = "SELECT price, name FROM radios WHERE id = $radio_id LIMIT 1";
$radio_result = $conn->query($radio_query);
if (!$radio_result || $radio_result->num_rows === 0) {
    die("خطا: اطلاعات فصل یافت نشد");
}
$radio_info = $radio_result->fetch_assoc();
$price_in_toman_base = (int)$radio_info['price'];
$radio_name = $radio_info['name'];

// ========== چک کد تخفیف (اگر از tehran1.php اومده) ==========
$coupon_code    = trim($_GET['coupon'] ?? '');
$discount_toman = 0;
$valid_coupon   = '';

if ($coupon_code !== '') {
    $cstmt = $conn->prepare("SELECT code, applies_to, takhfif_amount, is_active 
                             FROM codes WHERE code = ? LIMIT 1");
    $cstmt->bind_param("s", $coupon_code);
    $cstmt->execute();
    $cres = $cstmt->get_result();
    if ($cres->num_rows === 1) {
        $c = $cres->fetch_assoc();
        if ((int)$c['is_active'] === 1
            && in_array($c['applies_to'], ['radio', 'all'], true)
            && (int)$c['takhfif_amount'] > 0) {
            $discount_toman = (int)$c['takhfif_amount'];
            $valid_coupon = $c['code'];
        }
    }
    $cstmt->close();
}

// ========== محاسبه قیمت نهایی ==========
$price_in_toman = max(0, $price_in_toman_base - $discount_toman);
$price_in_rial  = $price_in_toman * 10;  // تبدیل به ریال برای درگاه

// ========== اگر تخفیف >= قیمت → مستقیم بدون درگاه ثبت کن ==========
if ($price_in_rial <= 0) {
    $ins = $conn->prepare("INSERT INTO user_radio 
        (user_id, radio_type, program_id, paid, price, created_at)
        VALUES (?, ?, NULL, 1, ?, NOW())");
    $ins->bind_param("isi", $user_id, $radio_type, $price_in_toman_base);
    $ins->execute();
    $ins->close();

    // افزایش used_count کد تخفیف
    if ($valid_coupon !== '') {
        $upd = $conn->prepare("UPDATE codes SET used_count = used_count + 1 WHERE code = ?");
        $upd->bind_param("s", $valid_coupon);
        $upd->execute();
        $upd->close();
    }
    $conn->close();
    header("Location: tehran{$season}.php?payment=success");
    exit();
}

// ========== ساخت invoice_id ==========
$invoice_id = time() . rand(100, 999);

// ========== callback ==========
$callbackUrl = "https://simorghtv.com/radios/API/callback_tehran.php";

// ========== درخواست token ==========
$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID, $callbackUrl)
    ->invoiceId($invoice_id)
    ->amount($price_in_rial);

$result = $gateway->token();

if ($result['code'] == 200) {
    // ========== ثبت درخواست خرید (pending) ==========
    $sql = "INSERT INTO user_radio 
            (user_id, radio_type, program_id, paid, price, invoice_id, created_at) 
            VALUES (?, ?, NULL, 0, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isii", $user_id, $radio_type, $price_in_toman, $invoice_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // ========== هدایت به درگاه ==========
    Gateway::redirect($result['content'], '');
    exit();
} else {
    echo "خطا در اتصال به درگاه: " . $result['content'];
}
?>