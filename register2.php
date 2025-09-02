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
    if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger text-center">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }

    ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-sm-12 border">

                <form class="p-2" action="" method="POST" enctype="multipart/form-data">
                    <h2 style="text-align: center;">فرم ثبت نام</h2>
                    <h6 style="text-align: right;">اطلاعات شما :</h6>
                    <div class="form-group" style="text-align: right;">
                        <label for="name">نام</label>
                        <input type="text" class="form-control" name="name" id="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label for="lastname">نام خانوادگی</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" required value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>">
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
                            required
                            value="<?php echo isset($_POST['meli_code']) ? htmlspecialchars($_POST['meli_code']) : ''; ?>">
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label for="father_name">نام پدر</label>
                        <input type="text" class="form-control" name="father_name" id="father_name" required value="<?php echo isset($_POST['father_name']) ? htmlspecialchars($_POST['father_name']) : ''; ?>">
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label for="birth_date">تاریخ تولد دقیق (YYYY/MM/DD)</label>
                        <input type="text" class="form-control" name="birth_date" id="birth_date" placeholder="مثال: ۱۳۷۰/۰۱/۰۱" required value="<?php echo isset($_POST['birth_date']) ? htmlspecialchars($_POST['birth_date']) : ''; ?>">
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label for="issue_location">صادره از</label>
                        <input type="text" class="form-control" name="issue_location" id="issue_location" required value="<?php echo isset($_POST['issue_location']) ? htmlspecialchars($_POST['issue_location']) : ''; ?>">
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
                            required
                            value="<?php echo isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : ''; ?>">
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <label for="address">آدرس</label>
                        <input type="text" class="form-control" name="address" id="address" required value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
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
                                    $selected = '';
                                    if (isset($_POST['name_course']) && $_POST['name_course'] == $row1['course']) {
                                        $selected = 'selected';
                                    }
                            ?>
                                    <option value="<?= $row1['course'] ?>" <?= $selected ?>>
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
                        <input type="number" class="form-control" name="amount" id="amount" required min="50000000" placeholder="به ریال وارد کنید" value="<?php echo isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : ''; ?>">
                    </div>

                    <div class="form-group" style="text-align: right;">
                        <label for="discount_code">کد تخفیف : (در صورت وجود )</label>
                        <input type="text" class="form-control" name="discount_code" id="discount_code" style="width: 100px;" value="<?php echo isset($_POST['discount_code']) ? htmlspecialchars($_POST['discount_code']) : ''; ?>">
                    </div>


                    <div class="form-group" style="text-align: right;">
                        <label for="explain">توضیحات</label>
                        <textarea class="form-control" name="explain" id="explain"><?php echo isset($_POST['explain']) ? htmlspecialchars($_POST['explain']) : ''; ?></textarea>
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <p>نحوه آشنایی با موسسه :</p>
                        <?php
                        $reference_options = ['internet', 'relation', 'others'];
                        foreach ($reference_options as $option) {
                            $checked = '';
                            if (isset($_POST['reference']) && $_POST['reference'] == $option) {
                                $checked = 'checked';
                            }
                            echo '<label for="' . $option . '">' . ($option == 'internet' ? 'اینترنت' : ($option == 'relation' ? 'آشنایان' : 'غیره')) . '</label>
                                  <input class="form-check-input" type="radio" name="reference" value="' . $option . '" id="' . $option . '" ' . $checked . '>
                                  <br>';
                        }
                        ?>
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
        $_SESSION['error_message'] = 'مبلغ وارد شده کمتر از 5 میلیون تومان است لطفا دقت کنید!!';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
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
    $discount = false;
    $takhfif_amount = 0;
    if ($result_takhfif->num_rows > 0) {
        $takhfif = $result_takhfif->fetch_assoc();
        $code = $takhfif['code'];
        $takhfif_amount = $takhfif['takhfif_amount'];
        if (isset($_POST['discount_code']) && $_POST['discount_code'] == "$code") {
            $discount = TRUE;
        } else {
            $discount = FALSE;
        }
    } else {
        $discount = FALSE;
    }


    if (empty($_POST['name_course'])) {
        $_SESSION['error_message'] = 'لطفاً یک دوره را انتخاب کنید.';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
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
        $_SESSION['error_message'] = 'مبلغ وارد شده معتبر نیست.';
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['reference'])) {
        $reference = $_POST['reference'];
    } else {
        $reference = NULL;
    }

    // منطق بررسی و ایجاد کاربر جدید (همانند register.php)
    $user_id_from_db = NULL;
    $sql_check_user = "SELECT id FROM users WHERE username = '$mobile'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows > 0) {
        $row_user = $result_check_user->fetch_assoc();
        $user_id_from_db = $row_user['id'];
    } else {
        $password = password_hash($mobile, PASSWORD_DEFAULT);
        $sql_insert_user = "INSERT INTO users (username, password) VALUES ('$mobile', '$password')";

        if ($conn->query($sql_insert_user)) {
            $user_id_from_db = $conn->insert_id;
        } else {
            $_SESSION['error_message'] = "خطا در ایجاد کاربر جدید: " . $conn->error;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }


    // ذخیره اطلاعات در session برای استفاده در back.php
    $_SESSION['register_data'] = [
        'user_id' => $user_id_from_db,
        'name' => $name,
        'lastname' => $lastname,
        'meli_code' => $meli_code,
        'father_name' => $father_name,
        'birth_date' => $birth_date,
        'issue_location' => $issue_location,
        'course' => $course,
        'introduce' => $introduce,
        'amount' => $amount,
        'mobile' => $mobile,
        'address' => $address,
        'reference' => $reference,
        'description' => $description
    ];


    $CallBackUrl = $CurUrl . 'back.php';

    $result = Gateway::make()
        ->config($Username, $Password, $merchantConfigID, $CallBackUrl)
        ->amount($amount)
        ->invoiceId(time())
        ->token();

    if ($result['code'] == 200) {
        $_SESSION['payment_token'] = $result['content'];
        $_SESSION['payment_amount'] = $amount;
        $_SESSION['payment_invoice_id'] = time();

        Gateway::redirect($result['content'], $_POST['mobile']);
        exit();
    } else {
        if ($result['errortype']) {
            $_SESSION['error_message'] = "خطای ماژول CURL. کدخطا: " . $result['code'] . " - " . $result['content'];
        } else {
            $_SESSION['error_message'] = "خطا هنگام ایجاد تراکنش. کدخطا: " . $result['code'] . " - " . $result['content'];
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>