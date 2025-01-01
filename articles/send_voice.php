<?php
session_start();
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ارسال صدای خودتان</title>

   
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    

</head>
<body>

    <?php


    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();



    if(!extension_loaded('curl')){
        echo '<div class="error">
                برای استفاده از درگاه آپ نیازمند ماژول <b>CURL</b> هستید.
                <br>لطفا ابتدا <b>CURL</b> را روی هاست یا سرور خود نصب کنید.
            </div>
            ';
        die();
    }




    ?>
       <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <!-- <img class="mx-auto d-block img-fluid" src="../images/audio.jpg" alt="ثبت گویندگی" style="width: 100%; height: auto;"> -->
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            <div class="row mb-5">
                                <div class="col-md-6 border">
                                    <h4 class="">به جمع گویندگان سیمرغ خوش آمدید.</h4><p>اینجا مکان کسب درآمد شماست.</p><p>دستمزد هر پروژه بصورت درصدی به شما پرداخت خواهد شد.</p><p><span style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;; background-color: rgb(231, 156, 156);">هزینه عضویت یکساله در سایت 500/000 هزارتومان</span><br></p><p>پس از پرداخت هزینه و عضویت در سایت صفحه بارگذاری و آپلود صدا باز خواهد شد.</p><p><br></p><h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);"><br></h4><p><br style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"></p><div><span style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;; background-color: rgb(231, 156, 156);"><br></span></div><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"></p>

                                    <br>
                                </div>
                                <div class="col-md-6">
                                    <form method="post" action="" class="form-group border p-1">
                                        <h4>فرم ثبت نام</h4>
                                        <label> <span style="font-size:10pt; color:#666">مبلغ 5/000/000 ریال</span></label>
                                        <input type="text" class="form-control" name="amount" value="5000000" readonly/> 
                                        <br>
                                        <label>شماره موبایل : <span style="font-size:10pt; color:#666"></span></label>
                                        <input type="text" class="form-control" name="mobile" required/>
                                        <br>
                                        <label>نام : <span style="font-size:10pt; color:#666"></span></label>
                                        <input type="text" class="form-control" name="name" required/>
                                        <br>
                                        <label>نام خانوادگی : <span style="font-size:10pt; color:#666"></span></label>
                                        <input type="text" class="form-control" name="lastname" required/>
                                        <br>
                                        <label>سن <span style="font-size:10pt; color:#666"></span></label>
                                        <input type="text" class="form-control" name="age" required/>
                                        <br>
                                        <input type="submit" value="انتقال به درگاه آپ">
                                    </form>
                                </div>
                            </div>

                    
                            
                        </div>

                     
                       

                   

                    </div>

                </div>
            </div>
        </div>



    <?php include 'footer.php'; ?>

  


</body>
</html>





<?php

require 'API/Gateway.php';
require 'ipgcfg.php';


if(!empty($_POST)){
	$CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$CurUrl = substr($CurUrl,0, strrpos($CurUrl, '/')+1);

    $invoiceId = time(); // Generate an invoice ID based on current time


  
    $mobile = $_POST['mobile'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $amount = $_POST['amount'];
 

    $sql = "INSERT INTO contacts (user_id, name, lastname, age, course, introduce, amount, mobile, created_at) 
        VALUES ('$invoiceId', '$name', '$lastname', '$age', 'voice','500 toman', 500000, '$mobile', NOW())";

    

        $result = $conn->query($sql);

        if ($result) {
     
            $new_id = $conn->insert_id;
        } else {
            echo 'خطا در ذخیره اطلاعات تراکنش در پایگاه داده.';
        }

    
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


?>

