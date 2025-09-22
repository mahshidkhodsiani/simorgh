<?php
session_start();
include '../config.php';
require 'API/Gateway.php';
require 'ipgcfg.php';


if (!isset($_SESSION['invoice'])) {
    // اگر اطلاعات تراکنش در session وجود ندارد، به صفحه my_packages.php هدایت کن
    header("Location: my_packages.php");
    exit();
}

$invoice = $_SESSION['invoice'];
$invoiceID = $invoice['id'];
$amount = $invoice['amount'];
$user_id = $invoice['user_id'];
$package_id = $invoice['package_id'];
$cart_id = $invoice['cart_id'];

// دریافت اطلاعات برگشتی از Gateway
$refID = $_GET['refId'] ?? null;
$status = $_GET['status'] ?? null;

// تایید تراکنش با Gateway (در صورت نیاز)
try {
    $verify = Gateway::make()
        ->config($Username, $Password, $merchantConfigID)
        ->amount($amount)
        ->invoiceId($invoiceID)
        ->verify($refID);

    if ($verify['code'] == 200) {
        // تراکنش موفق → ذخیره در جدول user_package
        $stmt = $conn->prepare("INSERT INTO user_package (package_id, user_id, paid) VALUES (?, ?, 1)");
        $stmt->bind_param("ii", $package_id, $user_id);
        $stmt->execute();
        $stmt->close();

        // حذف آیتم از سبد خرید
        $stmt = $conn->prepare("DELETE FROM user_cart WHERE id = ?");
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $stmt->close();

        // پاک کردن SESSION تراکنش
        unset($_SESSION['invoice']);

        // ریدایرکت به صفحه my_packages
        header("Location: my_packages.php?success=1");
        exit();
    } else {
        echo "تراکنش ناموفق بود: " . $verify['content'];
    }
} catch (Exception $e) {
    echo "خطای غیرمنتظره: " . $e->getMessage();
}
