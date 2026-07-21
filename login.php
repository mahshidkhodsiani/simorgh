<?php
session_start();

// اگر کاربر از PWA آمده، این پارامتر رو ست کن
if (isset($_GET['mode']) && $_GET['mode'] === 'pwa') {
    $_SESSION['is_pwa'] = true;
}

// اگر کاربر لاگین کرده
if (isset($_SESSION['user_id'])) {
    // اگر از PWA (وب اپ) آمده بود -> به رادیو برود
    if (isset($_SESSION['is_pwa']) && $_SESSION['is_pwa'] === true) {
        // پاک کردن وضعیت PWA (اختیاری - اگر میخواید每次都 لاگین بخواد، این خط رو حذف کنید)
        // unset($_SESSION['is_pwa']);
        header("Location: /radios/index.php");
        exit();
    }
    
    // اگر آدرس برگشت ذخیره شده بود (از رادیو اومده)
    if (isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])) {
        $redirect = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']);
        header("Location: " . $redirect);
        exit();
    }
    
    // هدایت پیش‌فرض برای کاربر عادی
    header("Location: /user/profile");
    exit();
}

// نمایش خطاهای لاگین
$error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

// بررسی آیا از رادیو آمده (برای نمایش پیام)
$from_radio = false;
if (isset($_SESSION['redirect_after_login']) && strpos($_SESSION['redirect_after_login'], 'radios') !== false) {
    $from_radio = true;
}
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ورود به رادیو سیمرغ</title>

    <?php
    include 'includes.php';
    require 'API/Gateway.php';
    require 'ipgcfg.php';
    ?>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/radios/manifest.json">
    <meta name="theme-color" content="#764ba2">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="رادیو سیمرغ">
    <link rel="apple-touch-icon" href="images/36.png">

    <link rel="icon" href="images/logo1.ico" type="image/x-icon">

    <style>
    body {
        font-weight: bold !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        margin: 0;
        padding: 0;
    }

    .login-container {
        margin-top: 80px;
        margin-bottom: 80px;
        padding: 0 15px;
    }

    .login-box {
        background: white;
        border-radius: 30px;
        padding: 40px 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .login-box h5 {
        color: #333;
        font-weight: bold;
    }

    .login-box .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        padding: 12px;
        font-weight: bold;
        transition: all 0.3s;
    }

    .login-box .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(118, 75, 162, 0.3);
    }

    .login-box .btn-success {
        border-radius: 15px;
        padding: 12px;
        font-weight: bold;
        transition: all 0.3s;
    }

    .login-box .btn-success:hover {
        transform: translateY(-2px);
    }

    .radio-logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .radio-logo img {
        width: 80px;
        height: 80px;
        border-radius: 20px;
    }

    .error-message {
        color: #dc3545;
        text-align: center;
        margin-bottom: 15px;
        font-size: 0.9rem;
        background: #f8d7da;
        padding: 10px;
        border-radius: 10px;
    }

    .success-message {
        color: #155724;
        text-align: center;
        margin-bottom: 15px;
        font-size: 0.9rem;
        background: #d4edda;
        padding: 10px;
        border-radius: 10px;
    }

    .forgot-link {
        color: #764ba2;
        text-decoration: none;
        font-weight: bold;
    }

    .forgot-link:hover {
        text-decoration: underline;
    }

    .login-subtitle {
        text-align: center;
        color: #888;
        font-size: 0.9rem;
        margin-top: -10px;
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 2px solid #e8e8e8;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #764ba2;
        box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.25);
    }

    @media (max-width: 576px) {
        .login-container {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .login-box {
            padding: 25px 20px;
        }

        .login-box h5 {
            font-size: 1.1rem;
        }

        .radio-logo img {
            width: 60px;
            height: 60px;
        }
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


    <div class="container login-container">

        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-12">
                <div class="login-box">

                    <div class="radio-logo">
                        <img src="images/40.jpg" alt="رادیو سیمرغ">
                    </div>

                    <h5 class="text-center mt-3 mb-2">🎙️ ورود به رادیو سیمرغ</h5>

                    <?php if ($from_radio || isset($_SESSION['is_pwa'])): ?>
                    <p class="login-subtitle">برای دسترسی به پخش آنلاین، لطفاً وارد شوید</p>
                    <?php endif; ?>

                    <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="login_proccess.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">نام کاربری</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="نام کاربری خود را وارد کنید" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">رمز عبور</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="رمز عبور خود را وارد کنید" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button name="enter" class="btn btn-primary">ورود به رادیو</button>
                            <a href="create_account.php" class="btn btn-success">ثبت نام</a>
                        </div>
                        <div class="mb-3 mt-3 text-center">
                            <h5 class="bold">
                                <a href="forgot_password" class="forgot-link">فراموشی رمز عبور؟</a>
                            </h5>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


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

    <?php include 'footer.php'; ?>


</body>

</html>