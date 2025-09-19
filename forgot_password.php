<?php
session_start();

include "config.php";
include 'includes.php';

$user_exist = FALSE; // مقدار اولیه

if (isset($_POST['submit_meliCode'])) {
    $meli_code = $_POST['meli_code'];
    $select_meli = "SELECT * FROM users WHERE meli_code = '$meli_code'";

    $result_user = $conn->query($select_meli);
    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $user_exist = TRUE;
        $_SESSION['user_meli_code'] = $meli_code; // ذخیره کد ملی در session
    } else {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' 
        style='position: fixed; top: 50px; right:30px; width: 300px; z-index: 1055;'>
        <div class='toast-header bg-danger text-white'>
            <strong class='mr-auto'>Error</strong>
        </div>
        <div class='toast-body font-weight-bold'>
            کاربری با این کد ملی وجود ندارد لطفا دوباره تلاش کنید !
        </div>
        </div>
        <script>
            $(document).ready(function(){
                $('#errorToast').toast({
                    autohide: true,
                    delay: 4000
                }).toast('show');
                setTimeout(function(){
                    window.location.href = 'forgot_password';
                }, 4000);
            });
        </script>";
    }
}



// بعد از بخش پردازش فرم اول، این کد را اضافه کنید
if (isset($_POST['submit_new_password'])) {
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    $meli_code = $_SESSION['user_meli_code'];

    if ($password === $password_repeat) {
        // هش کردن رمز عبور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // به روزرسانی رمز عبور در دیتابیس
        $update_sql = "UPDATE users SET password = '$hashed_password' WHERE meli_code = '$meli_code'";

        if ($conn->query($update_sql)) {
            echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' 
            style='position: fixed; top: 50px; right:30px; width: 300px; z-index: 1055;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>Success</strong>
            </div>
            <div class='toast-body font-weight-bold'>
            رمز عبور شما با موفقیت تغییر کرد
            </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#successToast').toast({
                        autohide: true,
                        delay: 4000
                    }).toast('show');
                    setTimeout(function(){
                        window.location.href = 'login.php';
                    }, 4000);
                });
            </script>";
        } else {
            echo "خطا در به روزرسانی رمز عبور: " . $conn->error;
        }
    } else {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' 
        style='position: fixed; top: 50px; right:30px; width: 300px; z-index: 1055;'>
        <div class='toast-header bg-danger text-white'>
            <strong class='mr-auto'>Error</strong>
        </div>
        <div class='toast-body font-weight-bold'>
            رمزهای عبور وارد شده مطابقت ندارند.
        </div>
        </div>
        <script>
            $(document).ready(function(){
                $('#errorToast').toast({
                    autohide: true,
                    delay: 4000
                }).toast('show');
            });
        </script>";
    }
}

?>

<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>

    <?php
    require 'API/Gateway.php';
    require 'ipgcfg.php';
    ?>

    <link rel="icon" href="images/logo1.ico" type="image/x-icon">

    <style>
        body {
            font-weight: bold !important;
        }

        .hidden-form {
            display: none;
        }
    </style>
</head>

<body>

    <?php
    include 'header.php';

    include 'PersianCalendar.php';
    include 'jalaliDate.php';
    $sdate = new SDate();
    ?>

    <div class="container mt-4 mb-4">
        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-12 border">
                <h4 class="text-center mt-3 mb-3 font-weight-bold">فرم فراموشی رمز</h4>

                <!-- فرم اول (ورود کد ملی) -->
                <form id="meliForm" action="" method="POST" <?php echo $user_exist ? 'class="hidden-form"' : ''; ?>>
                    <div class="mb-3">
                        <label for="meli_code" class="form-label">کد ملی خودرا وارد کنید</label>
                        <input type="text" class="form-control" id="meli_code" name="meli_code" placeholder="کد ملی" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-info" name="submit_meliCode">ثبت درخواست</button>
                    </div>
                </form>

                <!-- فرم دوم (تعیین رمز عبور جدید) -->
                <form id="passwordForm" action="" method="POST" <?php echo !$user_exist ? 'class="hidden-form"' : ''; ?>>

                    <div class="mb-3">
                        <label for="username" class="form-label">نام کاربری شما</label>
                        <input type="text" class="form-control" value="<?= $row_user['username'] ?>" name="username" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور جدید</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_repeat" class="form-label">تکرار رمز عبور</label>
                        <input type="password" class="form-control" id="password_repeat" name="password_repeat" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-success" name="submit_new_password">تغییر رمز عبور</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>
    <br>
    <?php include 'footer.php'; ?>

    <script>
        // برای اطمینان از تغییر display در سمت کلاینت
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($user_exist): ?>
                document.getElementById('meliForm').style.display = 'none';
                document.getElementById('passwordForm').style.display = 'block';
            <?php else: ?>
                document.getElementById('meliForm').style.display = 'block';
                document.getElementById('passwordForm').style.display = 'none';
            <?php endif; ?>
        });
    </script>

</body>

</html>