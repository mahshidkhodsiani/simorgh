<?php

session_start();

require 'API/Gateway.php';
require 'ipgcfg.php';
include "config.php"; // Include your database connection file

$invoiceID = $_REQUEST['invoice']; // Get the invoice ID from the request
$gateway = Gateway::make()->config($Username, $Password, $merchantConfigID)->invoiceId($invoiceID);
$result = $gateway->TranResult();

// Retrieve the transaction data from the session
$invoiceID = $_SESSION['invoiceId'];
$mobile = $_SESSION['mobile'];
$name = $_SESSION['name'];
$lastname = $_SESSION['lastname'];
$age = $_SESSION['age'];
$amount = $_SESSION['amount'];
$email = $_SESSION['email'];
$address = $_SESSION['address'];
$course = $_SESSION['course'];
$introduce = $_SESSION['introduce'];
$reference = $_SESSION['reference'];

if ($result['code'] != 200) {
    echo 'مشکل در TranResult تراکنش';
    echo '<br>';
    echo 'Http Code: ' . $result['code'];
    echo '<br>';
    echo 'Response: ' . $result['content'];
    exit();
}

echo 'اطلاعات تراکنش : ';
echo '<br>';
foreach ($result['content'] as $field => $res) {
    echo $field . ' : ' . $res;
    echo '<br>';
}

// Verify the transaction
$verify = $gateway->verify($result['content']['payGateTranID']);
if ($verify['code'] == 200) {
    echo 'تراکنش verify شد.';
    echo '<br>';

    // Settlement
    $settlement = $gateway->settlement($result['content']['payGateTranID']);
    if ($settlement['code'] == 200) {
        // Prepare the SQL query with course and reference details
        $sql = "INSERT INTO contacts (user_id, name, lastname, age, course, email, introduce, mobile, know, address, created_at) 
                VALUES ('$invoiceID', '$name', '$lastname', '$age', '$course', '$email', '$introduce', '$mobile', '$reference', '$address', NOW())";

        echo $sql;

        $result = $conn->query($sql);

        if ($result) {
            $new_id = $conn->insert_id;
            $_SESSION['new_id'] = $new_id;
            echo "<script>alert('اطلاعات شما به درستی ذخیره شد و شما ثبت نام شدید. از فیش واریزی اسکرین شات بگیرید')</script>";
            echo "<script>location.href='index';</script>";
        } else {
            echo 'خطا در ذخیره اطلاعات تراکنش در پایگاه داده.';
        }
    } else {
        echo 'مشکل در settlement تراکنش';
        echo '<br>';
        echo 'Http Code: ' . $settlement['code'];
        echo '<br>';
        echo 'Response: ' . $settlement['content'];
    }
} else {
    echo 'مشکل در verify تراکنش';
    echo '<br>';
    echo 'Http Code: ' . $verify['code'];
    echo '<br>';
    echo 'Response: ' . $verify['content'];
}

?>
