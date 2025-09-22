<?php
session_start();
// برای نمایش خطاها در محیط توسعه
error_reporting(E_ALL);
ini_set('display_errors', 1);

// بررسی وجود شناسه آیتم در URL
if (!isset($_GET['cart_id']) || !isset($_GET['user_id'])) {
    header("Location: user_cart.php?message=خطا در پردازش پرداخت&type=danger");
    exit();
}

include '../config.php';

$user_id = intval($_GET['user_id']);
$cart_id = intval($_GET['cart_id']);

require 'API/Gateway.php';
require 'ipgcfg.php';

$invoiceID = $_REQUEST['invoice'];

$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID)
    ->invoiceId($invoiceID);
$result = $gateway->TranResult();

if ($result['code'] != 200) {
    // پرداخت ناموفق بود.
    header("Location: user_cart.php?message=پرداخت با خطا مواجه شد. لطفاً دوباره تلاش کنید.&type=danger");
    exit();
}

// اطلاعات تراکنش
$transaction_data = $result['content'];

// Verify تراکنش
$verify = $gateway->verify($transaction_data['payGateTranID']);
if ($verify['code'] == 200) {
    // پرداخت با موفقیت تأیید شد.
    // آیتم را از سبد خرید حذف می‌کنیم
    $stmt_del = $conn->prepare("DELETE FROM user_cart WHERE id = ? AND user_id = ?");
    $stmt_del->bind_param("ii", $cart_id, $user_id);
    $stmt_del->execute();
    $stmt_del->close();
    
    // Settlement تراکنش
    $settlement = $gateway->settlement($transaction_data['payGateTranID']);
    if ($settlement['code'] == 200) {
        $message = "پرداخت شما با موفقیت انجام شد و آیتم از سبد خرید حذف گردید.";
        $message_type = "success";
    } else {
        $message = "پرداخت موفق بود، اما Settlement ناموفق بود. لطفاً با پشتیبانی تماس بگیرید.";
        $message_type = "warning";
    }

    // هدایت به صفحه سبد خرید با پیام مناسب
    header("Location: user_cart.php?message=" . urlencode($message) . "&type=" . $message_type);
    exit();

} else {
    // مشکل در تأیید تراکنش
    header("Location: user_cart.php?message=پرداخت ناموفق بود. لطفاً دوباره تلاش کنید.&type=danger");
    exit();
}
?>