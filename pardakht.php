<?php
session_start();
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>

    <?php 
    include 'includes.php'; 
    require 'API/Gateway.php';
    require 'ipgcfg.php';
    ?>

    <link rel="icon" href="images/logo1.ico" type="image/x-icon">

</head>
<body>

    <?php
    include 'header.php';
    include 'config.php';
    include 'PersianCalendar.php';
    include 'jalaliDate.php';
    $sdate = new SDate();
    
   ?>

        
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-7 col-sm-12 border">
                 

                

                        <form class="p-2" action="" method="POST">
                            <h2 style="text-align: center;">فرم پرداخت به موسسه</h2>
                            <h6 style="text-align: right;">اطلاعات شما :</h6>
                            <div class="form-group" style="text-align: right;">
                                <label for="name">نام</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="lastname">نام خانوادگی</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" required>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="meli_code">کد ملی</label>
                                <input type="text" class="form-control" name="meli_code" id="meli_code" required>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="mobile">شماره همراه</label>
                                <input type="text" class="form-control" name="mobile" id="mobile" required>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="email">ایمیل</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="age">سن</label>
                                <input type="number" class="form-control" name="age" id="age" required>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="age">مبلغ:(به ریال)</label>
                                <input type="number" class="form-control" name="amount" id="amount" required>
                            </div>
                          
                            <div class="form-group" style="text-align: right;">
                                <label for="address">آدرس</label>
                                <input type="text" class="form-control" name="address" id="address" required>
                            </div>
                            <h6 style="text-align: right;">اطلاعات ثبت نامی :</h6>
                          
                            <div class="form-group" style="text-align: right;">
                                <label for="explain">پرداخت جهت :</label>
                                <textarea class="form-control" name="explain" id="explain" required></textarea>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="discount_code">کد تخفیف : (در صورت وجود )</label>
                                <input type="text" class="form-control" name="discount_code" id="discount_code" style="width: 100px;">
                            </div>
                    
            
                            <input type="submit" value="انتقال به درگاه آپ" class="btn mb-2 mb-md-0 btn-outline-info btn-block">
                        </form>

                
                    
                   

                </div>
            </div>
        </div>
 

    <?php include 'footer.php'; ?>

</body>
</html>



<?php


// var_dump(empty($_POST));
if (isset($_POST)) {
    $CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $CurUrl = substr($CurUrl, 0, strrpos($CurUrl, '/') + 1);


    $invoiceId = time(); 


    $mobile = $_POST['mobile'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $meli_code = $_POST['meli_code'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $amount = $_POST['amount'];
    // if(isset($_POST['discount_code']) && $_POST['discount_code']== 'sim-t-49237'){
    //     $discount = TRUE ;
    // }
    $discount = NULL ;
   
    $introduce = isset($_POST['explain']) ? $_POST['explain'] : NULL;
 







    if ($amount <= 0) {
        // Handle error
        die('Invalid amount.');
    }




    $sql = "INSERT INTO contacts (user_id, name, lastname, age, course,  email, introduce, meli_code, amount, mobile, know, address, created_at) 
                VALUES ('$invoiceId', '$name', '$lastname', '$age', NULL, '$email', '$introduce', '$meli_code', '$amount', '$mobile', NULL, '$address', NOW())";

    // echo $sql;

    $result = $conn->query($sql);

    if ($result) {
        $new_id = $conn->insert_id;
        
        // echo "<script>location.href='payment_receipt';</script>";
    } else {
        echo 'خطا در ذخیره اطلاعات تراکنش در پایگاه داده.';
    }
    

    $CallBackUrl = $CurUrl . 'back.php';	

    $result = Gateway::make()
        ->config($Username, $Password, $merchantConfigID, $CallBackUrl)
        ->amount($amount)
        ->invoiceId(time())
        ->token();



    if ($result['code'] == 200) {	
        Gateway::redirect($result['content'], $_POST['mobile']);
        exit();
    } else {
        if ($result['errortype']) {
            echo 
            '<div class="error">
                <span style="color: #d00">خطای ماژول CURL.<br>
                کدخطا: <b>' . $result['code'] . '</b></span>
                <p align="right">شرح خطا:</p>
                <div style="text-align: left; direction: ltr;">
                    <span style="font:bold 11pt verdana ">' . $result['content'] . '</span>
                </div>		
            </div>';		
            exit();
        }
        echo 
        '<div class="error">
            <span style="color: #d00">خطا هنگام ایجاد تراکنش.<br>
            کدخطا: <b>' . $result['code'] . '</b></span>
            <div style="text-align:right;">
                شرح خطا:<br><span style="direction:ltr; font:bold 11pt verdana ">' . $result['content'] . '</span></div>
                <div style="text-align:justify; direction:rtl; line-height:1.4;  margin-top:30px">برای دریافت شرح کاملتر خطا با مراجعه به نشانی 
                <a href="https://rest.asanpardakht.net" target="_blank">https://rest.asanpardakht.net</a> ، شرح خطای <b>' . $result['code'] . '</b> 
                را در متد <b>Token</b> مشاهده کنید.
            </div>		
        </div>';
    }


}



?>
