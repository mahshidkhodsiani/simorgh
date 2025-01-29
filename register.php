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
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="meli_code" 
                                    id="meli_code" 
                                    pattern="\d{10}" 
                                    title="کد ملی باید 10 رقم باشد" 
                                    required>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="mobile">شماره همراه</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="mobile" 
                                    id="mobile" 
                                    pattern="\d{11}" 
                                    title="شماره همراه باید 11 رقم باشد" 
                                    required>
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
                                <select class="form-control" name="name_course" id="name_course" required>
                                    <?php
                                    $sql1="SELECT * FROM courses WHERE category = 'course'";
                                    
                                    $result1 = $conn->query($sql1);
                                    if($result1->num_rows>0){
                                        while($row1 = $result1->fetch_assoc()){
                                        ?>
                                        <option value="<?=$row1['course']?>"><?=$row1['course'] ." به قیمت : ".$row1['amount']?></option>
                                        <?php
                                        }
                                    }
                                    ?>



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

    <script>
        document.querySelectorAll('#meli_code, #mobile').forEach(input => {
            input.addEventListener('input', function () {
                if (this.id === 'meli_code' && !/^\d{10}$/.test(this.value)) {
                    this.setCustomValidity('کد ملی باید 10 رقم باشد');
                } else if (this.id === 'mobile' && !/^\d{11}$/.test(this.value)) {
                    this.setCustomValidity('شماره همراه باید 11 رقم باشد');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    </script>
    <script>
        // Add a custom required message for all inputs
        document.querySelectorAll('input[required]').forEach(input => {
            input.addEventListener('invalid', function (event) {
                if (this.validity.valueMissing) {
                    // Show the custom Persian message for required fields
                    this.setCustomValidity('لطفا این فیلد را پر کنید');
                } else {
                    this.setCustomValidity(''); // Clear message for other cases
                }
            });

            // Clear the message when input is valid
            input.addEventListener('input', function () {
                this.setCustomValidity('');
            });
        });
    </script>

    <script>
        // Custom required message for the select element
        document.getElementById('course').addEventListener('invalid', function (event) {
            if (this.validity.valueMissing) {
                this.setCustomValidity('لطفا یک دوره را انتخاب کنید');
            } else {
                this.setCustomValidity(''); // Clear the message for other cases
            }
        });

        // Clear the message when the user makes a valid selection
        document.getElementById('course').addEventListener('change', function () {
            this.setCustomValidity('');
        });
    </script>


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

 
   
    $description = isset($_POST['explain']) ? $_POST['explain'] : NULL;
 

    $takhfifs = "SELECT * FROM codes";
    $result_takhfif = $conn->query($takhfifs);
    if($result_takhfif->num_rows >0){
        $takhfif = $result_takhfif->fetch_assoc();
        $code = $takhfif['code'];
        if(isset($_POST['discount_code']) && $_POST['discount_code']== "$code"){
            $discount = TRUE ;
        }else{
            $discount = NULL ;
        }
    }else{
        $discount = NULL ;
    }



    $name_course = $_POST['name_course'];

    $amounts = "SELECT * FROM courses WHERE category= 'course' AND (course LIKE '%$name_course%' OR title LIKE '%$name_course%')";
    $result_courses = $conn->query($amounts);
    
    // ذخیره داده‌های دوره‌ها در آرایه
    $courses = [];
    if ($result_courses->num_rows > 0) {
        while ($row2 = $result_courses->fetch_assoc()) {
         
            $course= $row2['course'];
            $amount= isset($discount) && $discount ? $row2['amount'] - 10000000 : $row2['amount'];
            $introduce = $row2['introduce'];
        }
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
