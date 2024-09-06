<?php
session_start();


require 'API/Gateway.php';
require 'ipgcfg.php';
include "config.php"; 
include "includes.php";

?>


<div class="spinner-border text-warning" role="status">
  <span class="sr-only">Loading...</span>
</div>

<?php

$invoiceID = $_REQUEST['invoice']; // Get the invoice ID from the request
$gateway = Gateway::make()->config($Username, $Password, $merchantConfigID)->invoiceId($invoiceID);
$result = $gateway->TranResult();




if ($result['code'] != 200) {
    echo 'مشکل در TranResult تراکنش';
    echo '<br>';
    echo 'Http Code: ' . $result['code'];
    echo '<br>';
    echo 'Response: ' . $result['content'];
    exit();
}

// echo 'اطلاعات تراکنش : ';
// echo '<br>';
foreach ($result['content'] as $field => $res) {
    // echo $field . ' : ' . $res;
    // echo '<br>';
}

// Verify the transaction
$verify = $gateway->verify($result['content']['payGateTranID']);
if ($verify['code'] == 200) {
    // echo 'تراکنش verify شد.';
    // echo '<br>';

    // Settlement
    $settlement = $gateway->settlement($result['content']['payGateTranID']);
    if ($settlement['code'] == 200) {


        $sql = "UPDATE contacts SET pardakht = 1 WHERE user_id = '$invoiceID'";
        $conn->query($sql);
        
      
        $_SESSION['invoice'] = $invoiceID;
        echo "<script>location.href='payment_receipt';</script>";
       
    } else {
        // echo 'مشکل در settlement تراکنش';
        // echo '<br>';
        // echo 'Http Code: ' . $settlement['code'];
        // echo '<br>';
        // echo 'Response: ' . $settlement['content'];
    }
} else {
    echo 'مشکل در verify تراکنش';
    echo '<br>';
    echo 'Http Code: ' . $verify['code'];
    echo '<br>';
    echo 'Response: ' . $verify['content'];
}



?>
