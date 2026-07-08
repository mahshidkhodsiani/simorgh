<?php
session_start();
include '../../config.php';
include '../ipgcfg.php';

$invoiceID = isset($_GET['invoice']) ? (int)$_GET['invoice'] : 0;

if ($invoiceID == 0) {
    echo "شماره فاکتور نامعتبر";
    exit;
}

// اتصال به دیتابیس
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

// آپدیت مستقیم بدون verify و settlement (فعلاً برای تست)
$sql = "UPDATE user_radio SET paid = 1, payment_date = NOW() WHERE invoice_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $invoiceID);
$stmt->execute();

$conn->close();

// ریدایرکت با جاوااسکریپت
echo '<script>window.location.href = "../tehran.php?payment=success";</script>';
exit();
?>