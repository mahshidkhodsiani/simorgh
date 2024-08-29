<?php

require './Gateway.php';

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);


$invoiceID = $_GET['invoice'];

$gateway = Gateway::make()
    ->config('tstfr1625910','S4xz24',35588)
    ->invoiceId($invoiceID);

$result = $gateway->TranResult();

print_r($result);
echo '<br>';
echo 'ok';