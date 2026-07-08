<?php
session_start();
include '../config.php';
require_once 'API/Gateway.php';
require_once 'ipgcfg.php';

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$invoiceID = isset($_REQUEST['invoice']) ? (int)$_REQUEST['invoice'] : 0;

if ($invoiceID == 0) {
    die("شماره فاکتور نامعتبر است");
}

$gateway = Gateway::make()
    ->config($Username, $Password, $merchantConfigID)
    ->invoiceId($invoiceID);

$result = $gateway->TranResult();

if ($result['code'] != 200) {
    die('مشکل در دریافت اطلاعات تراکنش: ' . $result['content']);
}

$tranData = $result['content'];
$payGateTranID = $tranData['payGateTranID'];
$status = $tranData['status'] ?? '';

if ($status == 1) {
    $verify = $gateway->verify($payGateTranID);
    
    if ($verify['code'] == 200) {
        $settlement = $gateway->settlement($payGateTranID);
        
        if ($settlement['code'] == 200) {
            $update_sql = "UPDATE user_radio 
                          SET paid = 1, 
                              paygate_tran_id = ?, 
                              payment_date = NOW()
                          WHERE invoice_id = ? AND paid = 0";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $payGateTranID, $invoiceID);
            
            if ($update_stmt->execute()) {
                $conn->close();
                header("Location: tehran.php?payment=success");
                exit();
            } else {
                $conn->close();
                echo "خطا در ثبت اطلاعات در دیتابیس";
            }
        } else {
            $conn->close();
            echo 'مشکل در settlement تراکنش';
        }
    } else {
        $conn->close();
        echo 'مشکل در verify تراکنش';
    }
} else {
    $conn->close();
    header("Location: tehran.php?payment=failed");
    exit();
}
?>