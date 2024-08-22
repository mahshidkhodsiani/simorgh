<?php
require 'API/Gateway.php';
require 'ipgcfg.php';

$invoiceID = $_REQUEST['invoice'];

$gateway =Gateway::make()
    ->config($Username,$Password,$merchantConfigID)
    ->invoiceId($invoiceID);
$result = $gateway->TranResult();

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
            echo 'تراکنش settlement شد.';
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
