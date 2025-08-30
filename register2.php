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

    <style>
        body {
            font-weight: bold;
        }

        a,
        p,
        label,
        h6 {
            font-weight: bold;
        }
    </style>
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

                <form class="p-2" action="" method="POST" enctype="multipart/form-data">
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
                        <label for="father_name">نام پدر</label>
                        <input type="text" class="form-control" name="father_name" id="father_name" required>
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label for="birth_date">تاریخ تولد دقیق (YYYY/MM/DD)</label>
                        <input type="text" class="form-control" name="birth_date" id="birth_date" placeholder="مثال: ۱۳۷۰/۰۱/۰۱" required>
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label for="issue_location">صادره از</label>
                        <input type="text" class="form-control" name="issue_location" id="issue_location" required>
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
                        <label for="address">آدرس</label>
                        <input type="text" class="form-control" name="address" id="address" required>
                    </div>

                    <h6 style="text-align: right;">اطلاعات ثبت نامی :</h6>
                    <div class="form-group" style="text-align: right;">
                        <label for="course">دوره </label>
                        <select class="form-control" name="name_course" id="name_course" required>
                            <option value="">دوره مورد نظر خودرا انتخاب کنید:</option>
                            <?php
                            $sql1 = "SELECT * FROM courses WHERE category = 'course' ORDER BY id DESC ";

                            $result1 = $conn->query($sql1);
                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {

                            ?>
                                    <option value="<?= $row1['course'] ?>">
                                        دوره <?= $row1['course'] . " به قیمت : " . number_format($row1['amount'] + 15000000) . " ریال (اقساطی)" ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>

                        </select>

                    </div>

                    <br>

                    <div class="form-group" style="text-align: right;">
                        <label for="amount">مبلغ قابل پرداخت (توجه: حداقل باید 5 میلیون پرداخت کنید تا ثبت نام شما انجام شود)</label>
                        <input type="number" class="form-control" name="amount" id="amount" required min="50000000" placeholder="به ریال وارد کنید">
                    </div>

                    <div class="form-group" style="text-align: right;">
                        <label for="discount_code">کد تخفیف : (در صورت وجود )</label>
                        <input type="text" class="form-control" name="discount_code" id="discount_code" style="width: 100px;">
                    </div>


                    <div class="form-group" style="text-align: right;">
                        <label for="explain">توضیحات</label>
                        <textarea class="form-control" name="explain" id="explain"></textarea>
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

                    <p class="mt-4" style="text-align: center; color: red;">
                        توجه: لطفاً فرم ثبت نام را با دقت پر کنید، اطلاعات این فرم در گواهینامه پایان دوره ثبت خواهد شد.
                    </p>

                    <input type="submit" value="انتقال به درگاه آپ" name="submit_register" class="btn mb-2 mb-md-0 btn-outline-info btn-block">
                </form>

            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>

    <script>
        document.querySelectorAll('#meli_code, #mobile').forEach(input => {
            input.addEventListener('input', function() {
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
        document.querySelectorAll('input[required]').forEach(input => {
            input.addEventListener('invalid', function(event) {
                if (this.validity.valueMissing) {
                    this.setCustomValidity('لطفا این فیلد را پر کنید');
                } else {
                    this.setCustomValidity('');
                }
            });
            input.addEventListener('input', function() {
                this.setCustomValidity('');
            });
        });
    </script>

    <script>
        document.getElementById('name_course').addEventListener('invalid', function(event) {
            if (this.validity.valueMissing) {
                this.setCustomValidity('لطفا یک دوره را انتخاب کنید');
            } else {
                this.setCustomValidity('');
            }
        });
        document.getElementById('name_course').addEventListener('change', function() {
            this.setCustomValidity('');
        });
    </script>


</body>

</html>


<?php

if (isset($_POST['submit_register'])) {
    $CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $CurUrl = substr($CurUrl, 0, strrpos($CurUrl, '/') + 1);


    $invoiceId = time();

    // مبلغ مستقیما از فرم دریافت می‌شود
    $amount = $_POST['amount'];

    // شرط حداقل مبلغ 5 میلیون تومان
    if ($amount < 50000000) {
        echo "<h4>مبلغ وارد شده کمتر از 5 میلیون تومان است لطفا دقت کنید!! </h4>";
        die();
    }


    $mobile = $_POST['mobile'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $meli_code = $_POST['meli_code'];
    $address = $_POST['address'];

    $father_name = $_POST['father_name'];
    $birth_date = $_POST['birth_date'];
    $issue_location = $_POST['issue_location'];


    $description = isset($_POST['explain']) ? $_POST['explain'] : NULL;

    // کدهای آپلود فایل‌ها حذف شدند

    $takhfifs = "SELECT * FROM codes";
    $result_takhfif = $conn->query($takhfifs);
    if ($result_takhfif->num_rows > 0) {
        $takhfif = $result_takhfif->fetch_assoc();
        $code = $takhfif['code'];
        $takhfif_amount = $takhfif['takhfif_amount'];
        if (isset($_POST['discount_code']) && $_POST['discount_code'] == "$code") {
            // در این کد تخفیف محاسبه نمی‌شود
            $discount = TRUE;
        } else {
            $discount = NULL;
        }
    } else {
        $discount = NULL;
    }


    if (empty($_POST['name_course'])) {
        die("لطفاً یک دوره را انتخاب کنید.");
    }
    $name_course = $_POST['name_course'];


    $amounts_query = "SELECT * FROM courses WHERE category= 'course' AND (course LIKE '%$name_course%' OR title LIKE '%$name_course%')";
    $result_courses = $conn->query($amounts_query);

    if ($result_courses->num_rows > 0) {
        $row2 = $result_courses->fetch_assoc();
        $course = $row2['course'];
        $introduce = $row2['introduce'];
    }


    if ($amount <= 0) {
        die('مبلغ وارد شده معتبر نیست.');
    }

    if (isset($_POST['reference'])) {
        $reference = $_POST['reference'];
    } else {
        $reference = NULL;
    }


    $sql = "INSERT INTO contacts (user_id, name, lastname, meli_code, father_name, birth_date, 
    issue_location, course, introduce, amount, mobile, address, know, description, created_at, username, password)
                     VALUES ('$invoiceId', '$name', '$lastname', '$meli_code', '$father_name', 
                     '$birth_date', '$issue_location', '$course', '$introduce', '$amount', '$mobile', '$address', 
                     '$reference', '$description', NOW(), '$mobile', '$mobile')";


    $result = $conn->query($sql);

    if ($result) {
        $new_id = $conn->insert_id;
    } else {
        echo 'خطا در ذخیره اطلاعات تراکنش در پایگاه داده.';
        die();
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