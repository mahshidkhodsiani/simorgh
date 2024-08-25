<?php
require 'API/Gateway.php';
require 'ipgcfg.php';



?>
    <style>
        body {font-family: Tahoma, Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

        input[type=text], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
			text-align:center;
            resize: vertical;
			font:bold 14pt Tahoma;
			
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
			font:bold 14pt Tahoma;

        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
            max-width: 500px;
            direction: rtl;
			margin:50px auto;
        }
		
		.error {
			direction:rtl;
			line-height:2;
			text-align:center;
			max-width:500px;
			padding:20px; 
			margin:30px auto; 
			background:#ffe6e6;
			border:2px dashed #d00;
		}
    </style>
<?php
if(!extension_loaded('curl')){
    echo '<div class="error">
			برای استفاده از درگاه آپ نیازمند ماژول <b>CURL</b> هستید.
			<br>لطفا ابتدا <b>CURL</b> را روی هاست یا سرور خود نصب کنید.
		</div>
		';
    die();
}
?>	
<div class="container">
    <form method="post" action="index.php">
        <label>مبلغ : <span style="font-size:10pt; color:#666">(حداقل 12000 ریال)</label>
        <input type="text" name="amount" value="12000" />
        <br>
        <label>شماره موبایل : <span style="font-size:10pt; color:#666">(اختیاری)</label></label>
        <input type="text" name="mobile" />
        <br>
        <input type="submit" value="انتقال به درگاه آپ">
    </form>
</div>
<?php
if(!empty($_POST)){
	$CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$CurUrl = substr($CurUrl,0, strrpos($CurUrl, '/')+1);
	$CallBackUrl = $CurUrl.'back.php';	

    $result = Gateway::make()
        ->config($Username,$Password,$merchantConfigID,$CallBackUrl)
        ->amount($_POST['amount'])
        ->invoiceId(time())
        ->token();

    if($result['code'] == 200){	
        Gateway::redirect($result['content'],$_POST['mobile']);
    }
	else{
		if ($result['errortype']){
			echo 
			'<div class="error">
				<span style="color: #d00">خطای ماژول CURL.<br>
				کدخطا: <b>'.$result['code'].'</b></span>
				<p align="right">شرح خطا:</p>
				<div style="text-align: left; direction: ltr;">
					<span style="font:bold 11pt verdana ">'.$result['content'].'</span>
				</div>		
			</div>';		
			exit();
		}
        echo 
		'<div class="error">
			<span style="color: #d00">خطا هنگام ایجاد تراکنش.<br>
			کدخطا: <b>'.$result['code'].'</b></span>
			<div style="text-align:right;">
				شرح خطا:<br><span style="direction:ltr; font:bold 11pt verdana ">'.$result['content'].'</span></div>
				<div style="text-align:justify; direction:rtl; line-height:1.4;  margin-top:30px">برای دریافت شرح کاملتر خطا با مراجعه به نشانی 
				<a href="https://rest.asanpardakht.net" target="_blank">https://rest.asanpardakht.net</a> ، شرح خطای <b>'.$result['code'].'</b> 
				را در متد <b>Token</b> مشاهده کنید.
			</div>		
		</div>';
    }
}

if ($Username == 'Your Username' || 
	$Password == 'Your Password' || 
	$merchantConfigID == 'Your merchantConfigID')
	// echo '<div align="center">
			// <img src="HELP.jpg" />
		  // </div>
			// ';
?>
