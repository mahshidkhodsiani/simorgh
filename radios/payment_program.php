<?php
session_start();
include '../config.php';
require_once 'API/Gateway.php';
require_once 'ipgcfg.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$program_id = (int)$_GET['program_id'];
if ($program_id == 0) die("برنامه یافت نشد");

$prog = $conn->query("SELECT * FROM radio_tehran WHERE id = $program_id")->fetch_assoc();
if (!$prog) die("برنامه یافت نشد");

$price = (int)$prog['price'];
if ($price < 10000) die("قیمت کمتر از حداقل درگاه است");

$user_id = $_SESSION['user_id'];
$invoice_id = time() . rand(100, 999);

// بررسی خرید قبلی
$check = $conn->prepare("SELECT id FROM user_radio WHERE user_id = ? AND radio_type = 'tehran' AND program_id = ? AND paid = 1");
$check->bind_param("ii", $user_id, $program_id);
$check->execute();
if ($check->get_result()->num_rows > 0) {
    header("Location: tehran.php?payment=already");
    exit();
}

$callback = "https://simorghtv.com/radios/API/callback_program.php";

$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID, $callback)
    ->invoiceId($invoice_id)
    ->amount($price);

$token = $gateway->token();

if ($token['code'] == 200) {
    $insert = $conn->prepare("INSERT INTO user_radio (user_id, radio_type, program_id, paid, price, invoice_id, created_at) VALUES (?, 'tehran', ?, 0, ?, ?, NOW())");
    $insert->bind_param("iiii", $user_id, $program_id, $price, $invoice_id);
    $insert->execute();
    $conn->close();
    Gateway::redirect($token['content'], '');
    exit();
} else {
    echo "خطا: " . $token['content'];
}
?>