<?php
if(!extension_loaded('curl')){
    echo "لطفا CURL روی هاست یا سرور نصب کنید.".PHP_EOL;
    die();
}
require './Gateway.php';
$token = Gateway::make()
    ->config('tstfr1625910','S4xz24',35588,'https://up.sedehi.ir/settlement.php')
    ->amount(15000)
    ->invoiceId(time())
    ->token();

if($token['code'] == 200){
    Gateway::redirect($token['content'],'09128462973');
}else{
    echo '<br>';
    echo 'Http Code: '.$token['code'];
    echo '<br>';
    echo 'Response: '.$token['content'];
}
