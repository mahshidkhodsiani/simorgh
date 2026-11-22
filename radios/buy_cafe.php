<?php
session_start();
include '../config.php';
require_once 'API/Gateway.php';
require_once 'ipgcfg.php';

// ========== بررسی لاگین ==========
if (!isset($_SESSION['user_id'])) {
    $redirect = 'buy_cafe.php';
    if (isset($_GET['coupon'])) {
        $redirect .= '?coupon=' . urlencode($_GET['coupon']);
    }
    header("Location: ../login.php?redirect=" . urlencode($redirect));
    exit();
}

$user_id = (int)$_SESSION['user_id'];

// ========== بررسی خرید قبلی ==========
$check_sql = "SELECT id FROM user_radio 
              WHERE user_id = ? AND radio_type = 'cafe' 
              AND paid = 1 AND program_id IS NULL LIMIT 1";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $user_id);
$check_stmt->execute();
if ($check_stmt->get_result()->num_rows > 0) {
    $check_stmt->close();
    header("Location: cafe_meh.php?payment=already");
    exit();
}
$check_stmt->close();

// ========== دریافت قیمت کافه ==========
$cafe_id = 2;
$radio_query = "SELECT price, name FROM radios WHERE id = $cafe_id";
$radio_result = $conn->query($radio_query);
if (!$radio_result || $radio_result->num_rows === 0) {
    die("خطا: اطلاعات کافه یافت نشد");
}
$radio_info = $radio_result->fetch_assoc();
$price_in_toman_base = (int)($radio_info['price'] ?? 35000);
$radio_name = $radio_info['name'] ?? 'کافه مه آلود';

// ========== چک کد تخفیف ==========
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
$price_in_rial  = $price_in_toman * 10;

// ========== اگر تخفیف >= قیمت → مستقیم بدون درگاه ==========
if ($price_in_rial <= 0) {
    $ins = $conn->prepare("INSERT INTO user_radio 
        (user_id, radio_type, program_id, paid, price, created_at)
        VALUES (?, 'cafe', NULL, 1, ?, NOW())");
    $ins->bind_param("ii", $user_id, $price_in_toman_base);
    $ins->execute();
    $ins->close();

    if ($valid_coupon !== '') {
        $upd = $conn->prepare("UPDATE codes SET used_count = used_count + 1 WHERE code = ?");
        $upd->bind_param("s", $valid_coupon);
        $upd->execute();
        $upd->close();
    }
    $conn->close();
    header("Location: cafe_meh.php?payment=success");
    exit();
}

// ========== invoice_id و callback ==========
$invoice_id = time() . rand(100, 999);
$callbackUrl = "https://simorghtv.com/radios/API/callback_cafe.php";

// ========== درخواست token ==========
$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID, $callbackUrl)
    ->invoiceId($invoice_id)
    ->amount($price_in_rial);

$result = $gateway->token();

if ($result['code'] == 200) {
    // ثبت pending با قیمت نهایی
    $sql = "INSERT INTO user_radio 
            (user_id, radio_type, program_id, paid, price, invoice_id, created_at) 
            VALUES (?, 'cafe', NULL, 0, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $price_in_toman, $invoice_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    Gateway::redirect($result['content'], '');
    exit();
} else {
    echo "خطا در اتصال به درگاه: " . $result['content'];
}
?>