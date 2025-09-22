<?php

require './Gateway.php';

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);

$invoiceID = $_GET['invoice'];

$gateway =Gateway::make()
    ->config('tstfr1625910','S4xz24',35588)
    ->invoiceId($invoiceID);

$result = $gateway->TranResult();
echo '<pre>';
print_r($result);
$gateway->reverse($result['content']['payGateTranID']);