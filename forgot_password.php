<?php
session_start();

include "config.php";
include 'includes.php';

$user_exist = FALSE; // مقدار اولیه
$mobile_verified = FALSE; // وضعیت تایید شماره تلفن

if (isset($_POST['submit_mobile'])) {
    $mobile = $_POST['mobile'];
    $select_mobile = "SELECT * FROM users WHERE mobile = '$mobile'";

    $result_user = $conn->query($select_mobile);
    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $user_exist = TRUE;
        $_SESSION['user_mobile'] = $mobile; // ذخیره شماره تلفن در session
        $_SESSION['user_username'] = $row_user['username']; // این خط رو اضافه کنید

        // تولید کد 4 رقمی تصادفی
        $verification_code = rand(1000, 9999);
        $_SESSION['verification_code'] = $verification_code; // ذخیره کد در session

        // ارسال پیامک
        $username = "09124366786";
        $password = "91300517Na";
        $from = "300016343000";
        $to = $mobile;
        $message = "کد تایید شما برای تغییر رمز عبور: " . $verification_code;

        $url = "https://niksms.com/fa/publicapi/groupsms";

        $data = [
            "username" => $username,
            "password" => $password,
            "numbers" => $to,
            "sendernumber" => $from,
            "message" => $message,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    } else {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' 
        style='position: fixed; top: 50px; right:30px; width: 300px; z-index: 1055;'>
        <div class='toast-header bg-danger text-white'>
            <strong class='mr-auto'>Error</strong>
        </div>
        <div class='toast-body font-weight-bold'>
            کاربری با این شماره تلفن وجود ندارد لطفا دوباره تلاش کنید !
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

if (isset($_POST['submit_verification'])) {
    $entered_code = $_POST['verification_code'];
    if ($entered_code == $_SESSION['verification_code']) {
        $mobile_verified = TRUE;
    } else {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' 
        style='position: fixed; top: 50px; right:30px; width: 300px; z-index: 1055;'>
        <div class='toast-header bg-danger text-white'>
            <strong class='mr-auto'>Error</strong>
        </div>
        <div class='toast-body font-weight-bold'>
            کد وارد شده صحیح نیست.
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


if (isset($_POST['submit_new_password'])) {
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];
    $mobile = $_SESSION['user_mobile'];

    if ($password === $password_repeat) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = '$hashed_password' WHERE mobile = '$mobile'";

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

                <form id="mobileForm" action="" method="POST" <?php echo ($user_exist) ? 'class="hidden-form"' : ''; ?>>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">شماره تلفن خود را وارد کنید</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="شماره تلفن"
                            required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-info" name="submit_mobile">ثبت درخواست</button>
                    </div>
                </form>

                <form id="verificationForm" action="" method="POST"
                    <?php echo (!$user_exist || $mobile_verified) ? 'class="hidden-form"' : ''; ?>>
                    <div class="mb-3">
                        <label for="verification_code" class="form-label">کد 4 رقمی ارسال شده به شماره تلفن خود را وارد
                            کنید</label>
                        <input type="text" class="form-control" id="verification_code" name="verification_code"
                            placeholder="کد تایید" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-warning" name="submit_verification">تایید کد</button>
                    </div>
                </form>

                <form id="passwordForm" action="" method="POST"
                    <?php echo !$mobile_verified ? 'class="hidden-form"' : ''; ?>>
                    <div class="mb-3">
                        <label for="username" class="form-label">نام کاربری شما</label>
                        <input type="text" class="form-control" value="<?= $_SESSION['user_username'] ?? '' ?>"
                            name="username" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">رمز عبور جدید</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_repeat" class="form-label">تکرار رمز عبور</label>
                        <input type="password" class="form-control" id="password_repeat" name="password_repeat"
                            required>
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
    document.addEventListener('DOMContentLoaded', function() {
        var mobileForm = document.getElementById('mobileForm');
        var verificationForm = document.getElementById('verificationForm');
        var passwordForm = document.getElementById('passwordForm');

        <?php if ($user_exist && !$mobile_verified): ?>
        mobileForm.style.display = 'none';
        verificationForm.style.display = 'block';
        passwordForm.style.display = 'none';
        <?php elseif ($mobile_verified): ?>
        mobileForm.style.display = 'none';
        verificationForm.style.display = 'none';
        passwordForm.style.display = 'block';
        <?php else: ?>
        mobileForm.style.display = 'block';
        verificationForm.style.display = 'none';
        passwordForm.style.display = 'none';
        <?php endif; ?>
    });
    </script>


    <script type="text/javascript">
    ! function() {
        var i = "4Ey6dG",
            a = window,
            d = document;

        function g() {
            var g = d.createElement("script"),
                s = "https://www.goftino.com/widget/" + i,
                l = localStorage.getItem("goftino_" + i);
            g.async = !0, g.src = l ? s + "?o=" + l : s;
            d.getElementsByTagName("head")[0].appendChild(g);
        }
        "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !
            1);
    }();
    </script>

</body>

</html>