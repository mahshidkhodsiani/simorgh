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
                            <h2 style="text-align: center;">فرم ثبت نام</h2>
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
                                <label for="address">آدرس</label>
                                <input type="text" class="form-control" name="address" id="address" required>
                            </div>
                            <h6 style="text-align: right;">اطلاعات ثبت نامی :</h6>
                            <div class="form-group" style="text-align: right;">
                                <label for="course">دوره </label>
                                <select class="form-control" name="course" id="course" required>
                                    <option>دوره مورد نظر را انتخاب کنید</option>
                                    <option value="course1">'گویندگی پیشرفته رادیو "15 جلسه سه ساعته" - قیمت: 12/000/000 تومان '</option>
                                    <option value="course2">'فن بیان کودکان "10 جلسه دو ساعته" - قیمت : 5/900/000 تومان'</option>
                                    <option value="course3">'فن بیان و گویندگی "10 جلسه دو ساعته" - قیمت : 6/500/000 تومان'</option>
                                    <option value="course4">'نمایش رادیویی "8 جلسه دو ساعته" - قیمت : 5/500/000 تومان'</option>
                                    <option value="course5">'بازیگری بزرگسال "16 جلسه دو ساعته" - قیمت : 8/800/000 تومان'</option>
                                    <option value="course6">'بازیگری مخصوص کودکان "12 جلسه سه ساعته" - قیمت : 6/500/000 تومان'</option>
                                    <option value="course7">'موشن گرافیک "16 جلسه دو ساعته" - قیمت : 9/500/000 تومان'</option>
                                    <option value="course8">'دوره دوبله "10 جلسه سه ساعته" - قیمت : 7/500/000 تومان'</option>
                                    <option value="course9">'انیمیشن سازی "12 جلسه سه ساعته" - قیمت : 7/900/000 تومان'</option>
                                    <option value="course10">'گریم سینمایی (مقدماتی) "10 جلسه سه ساعته" - قیمت : 6/500/000 تومان'</option>
                                    <option value="course11">'گریم سینمایی (پیشرفته) "10 جلسه سه ساعته" - قیمت : 8/000/000 تومان'</option>
                                    <option value="course12">'کارگردانی و فیلمسازی "12 جلسه سه ساعته" - قیمت : 11/000/000 تومان'</option>
                                    <option value="course13">'ورکشاپ گویندگی - قیمت : 500/000 تومان'</option>
                                    <option value="course14">'تدوین و ادیت فیلم "10 جلسه دو ساعته" - قیمت : 6/500/000 تومان'</option>

                                </select>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="explain">توضیحات</label>
                                <textarea class="form-control" name="explain" id="explain"></textarea>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="discount_code">کد تخفیف : (در صورت وجود )</label>
                                <input type="text" class="form-control" name="discount_code" id="discount_code" style="width: 100px;">
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <p>نحوه آشنایی با موسسه :</p>
                                <label for="internet">اینترنت</label>
                                <input class="form-check-input" type="radio" name="reference" value="internet" id="internet">
                                <br>
                                <label for="relation">آشنایان</label>
                                <input class="form-check-input" type="radio" name="reference" value="relation" id="relation">
                                <br>
                                <label for="others">غیره</label>
                                <input class="form-check-input" type="radio" name="reference" value="others" id="others">
                            </div>

                            
                            <input type="submit" value="انتقال به درگاه آپ"
                            name="submit_register" class="btn mb-2 mb-md-0 btn-outline-info btn-block">
                        </form>

                
                    
                   

                </div>
            </div>
        </div>
 

    <?php include 'footer.php'; ?>

</body>
</html>



<?php


// var_dump(empty($_POST));
if (isset($_POST['submit_register'])) {
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
    // if(isset($_POST['discount_code']) && $_POST['discount_code']== 'sim-t-49237'){
    //     $discount = TRUE ;
    // }
    $discount = NULL ;
   
    $description = isset($_POST['explain']) ? $_POST['explain'] : NULL;
 


    switch ($_POST['course']) {
        case 'course1':
            $course = "گویندگی تخصصی رادیو";
            $introduce = "قیمت: دو قسط 6 میلیونی";
            $amount = $discount ? 110000000 : 120000000;
            break;
    
        case 'course2':
            $course = "فن بیان کودکان";
            $introduce = "قیمت: 5/900/000 تومان";
            $amount = $discount ? 49000000 : 59000000;
            break;
    
        case 'course3':
            $course = "فن بیان و گویندگی";
            $introduce = "قیمت: 6/500/000 تومان";
            $amount = $discount ? 55000000 : 65000000;
            break;
    
        case 'course4':
            $course = "نمایش رادیویی";
            $introduce = "قیمت: 5/500/000 تومان";
            $amount = $discount ? 45000000 : 55000000;
            break;
    
        case 'course5':
            $course = "بازیگری بزرگسال";
            $introduce = "قیمت: 8/800/000 تومان";
            $amount = $discount ? 78000000 : 88000000;
            break;
    
        case 'course6':
            $course = "بازیگری مخصوص کودکان";
            $introduce = "قیمت: 7/500/000 تومان";
            $amount = $discount ? 55000000 : 65000000;
            break;
    
        case 'course7':
            $course = "موشن گرافیک";
            $introduce = "قیمت: 9/500/000 تومان";
            $amount = $discount ? 85000000 : 95000000;
            break;
    
        case 'course8':
            $course = "آموزش و جذب دوبلر";
            $introduce = "قیمت: 7/500/000 تومان";
            $amount = $discount ? 65000000 : 75000000;
            break;
    
        case 'course9':
            $course = "انیمیشن سازی";
            $introduce = "قیمت: 7/900/000 تومان";
            $amount = $discount ? 69000000 : 79000000;
            break;
    
        case 'course10':
            $course = "گریم سینمایی (مقدماتی)";
            $introduce = "قیمت: 6/500/000 تومان";
            $amount = $discount ? 55000000 : 65000000;
            break;
    
        case 'course11':
            $course = "گریم سینمایی (پیشرفته)";
            $introduce = "قیمت: 8/000/000 تومان";
            $amount = $discount ? 70000000 : 80000000;
            break;
    
        case 'course12':
            $course = "کارگردانی و فیلمسازی";
            $introduce = "قیمت: 11/000/000 تومان";
            $amount = $discount ? 100000000 : 110000000;
            break;
    
        case 'course13':
            $course = "ورکشاپ گویندگی رادیو";
            $introduce = "قیمت: 500/000 تومان";
            $amount =  5000000;
            break;
    
        case 'course14':
            $course = "تدوین و ادیت فیلم";
            $introduce = "قیمت: 6/500/000 تومان";
            $amount = $discount ? 55000000 : 65000000;
            break;
    }




    if ($amount <= 0) {
        // Handle error
        die('Invalid amount.');
    }

    // Handle reference selection
    if (isset($_POST['reference'])) {
        $reference = $_POST['reference'];
    } else {
        $reference = NULL;
    }


    $sql = "INSERT INTO contacts (user_id, name, lastname, age, course,  email, introduce, meli_code, amount, mobile, know, address, created_at) 
                VALUES ('$invoiceId', '$name', '$lastname', '$age', '$course', '$email', '$introduce', '$meli_code', '$amount', '$mobile', '$reference', '$address', NOW())";

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
