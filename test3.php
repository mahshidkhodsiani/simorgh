<?php
require 'API/Gateway.php';
require 'ipgcfg.php';

include "../config.php";

session_start();

$invoiceID = $_REQUEST['invoice'];

$gateway =Gateway::make()->config($Username,$Password,$merchantConfigID)->invoiceId($invoiceID);
$result = $gateway->TranResult();


$invoiceID = $_SESSION['invoiceId']; // Retrieve the invoice ID from the session
$mobile = $_SESSION['mobile']; // Retrieve the mobile number from the session
$amount = $_SESSION['amount']; // Retrieve the amount from the session





	if($result['code'] != 200){
		echo 'مشکل در TranResult تراکنش';
		echo '<br>';
		echo 'Http Code: '.$result['code'];
		echo '<br>';
		echo 'Response: '.$result['content'];
		exit();
	}
    
	echo 'اطلاعات تراکنش : ';
    echo '<br>';
    foreach ($result['content'] as $field=>$res){
        echo $field.' : '.$res;
        echo '<br>';
    }
	
	//Verify 
    $verify = $gateway->verify($result['content']['payGateTranID']);
    if($verify['code'] == 200){
        echo 'تراکنش verify شد.';
        echo '<br>';
		//Settlement
        $settlement = $gateway->settlement($result['content']['payGateTranID']);
        if($settlement['code'] == 200){

            $stmt = $conn->prepare("INSERT INTO contacts (user_id, introduce, mobile) VALUES (?, ?, ?)");
            $stmt->bind_param("sssssis", $name, $family, $number);

            echo 'تراکنش settlement شد.';
            echo "<script>location.href='about.php';</script>";
            echo '<br>';
        }
		else{
            echo 'مشکل در settlement تراکنش';
            echo '<br>';
            echo 'Http Code: '.$settlement['code'];
            echo '<br>';
            echo 'Response: '.$settlement['content'];
        }
    }
	else{
        echo 'مشکل در verify تراکنش';
        echo '<br>';
        echo 'Http Code: '.$verify['code'];
        echo '<br>';
        echo 'Response: '.$verify['content'];
    }
