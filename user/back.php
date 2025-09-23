<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config.php';

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
$amount     = $txn['amount']; // فرض میکنم توی pending_transactions داری

// 2. گرفتن اسم پکیج از جدول package
$stmt = $conn->prepare("SELECT title FROM package WHERE id=?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();
$pkg = $result->fetch_assoc();
$stmt->close();

$course_name = $pkg ? $pkg['title'] : null;

// 3. ثبت در جدول user_package
$stmt = $conn->prepare("INSERT INTO user_package (package_id, user_id, paid) VALUES (?, ?, 1)");
$stmt->bind_param("ii", $package_id, $user_id);
$stmt->execute();
$stmt->close();

// 4. ثبت در جدول contacts
$stmt = $conn->prepare("INSERT INTO contacts (user_id, course, amount, pardakht, created_at) 
                        VALUES (?, ?, ?, 1, NOW())");
$stmt->bind_param("ssi", $user_id, $course_name, $amount);
$stmt->execute();
$stmt->close();

// 5. حذف آیتم از user_cart
$stmt = $conn->prepare("DELETE FROM user_cart WHERE id=?");
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$stmt->close();

// 6. بروزرسانی وضعیت pending_transactions
$stmt = $conn->prepare("UPDATE pending_transactions SET status=1 WHERE invoice_id=?");
$stmt->bind_param("i", $invoiceID);
$stmt->execute();
$stmt->close();

// 7. ریدایرکت به my_packages
header("Location: my_packages.php?success=1");
exit();
