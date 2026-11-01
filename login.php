<?php
if (session_status() === PHP_SESSION_NONE) {
    $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    if (!$isSecure && isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        $isSecure = true;
    }
    session_set_cookie_params([
        'lifetime' => 0, 'path' => '/', 'domain' => '', 'secure' => $isSecure, 'httponly' => true, 'samesite' => 'Lax',
    ]);
    session_start();
}

// ذخیره آدرس برگشت
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $_SESSION['redirect_after_login'] = $_GET['redirect'];
}

// ============================================
// ✅ اگر کاربر از قبل لاگین کرده
// ============================================
if (isset($_SESSION['user_id'])) {

    // ✅ چک ادمین بودن
    include 'config.php';
    $check_admin = $conn->prepare("SELECT admin FROM users WHERE id = ? LIMIT 1");
    $check_admin->bind_param("i", $_SESSION['user_id']);
    $check_admin->execute();
    $admin_result = $check_admin->get_result();
    $is_admin = false;
    if ($admin_result->num_rows > 0) {
        $admin_row = $admin_result->fetch_assoc();
        $is_admin = ((int)$admin_row['admin'] === 1);
    }
    $check_admin->close();
    $conn->close();

    // ✅ ادمین → مستقیم بره /admin
    if ($is_admin) {
        unset($_SESSION['redirect_after_login']);
        header("Location: /admin");
        exit();
    }

    // ✅ غیر ادمین → به صفحه‌ای که بوده برگرده
    if (isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])) {
        $redirect = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']);
        header("Location: " . $redirect);
        exit();
    }

    // پیش‌فرض → پروفایل
    header("Location: /user/profile");
    exit();
}

// آماده‌سازی متغیر ریدایرکت برای ارسال به جاوااسکریپت
$current_redirect = '';
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    $current_redirect = $_GET['redirect'];
} elseif (isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])) {
    $current_redirect = $_SESSION['redirect_after_login'];
}
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ورود / ثبت نام | هفت هنر سیمرغ</title>
    
    <?php include 'includes.php'; ?>
    
    <style>
    body {
        font-weight: bold !important;
        background: linear-gradient(135deg, #f4f6f9 0%, #e9ecef 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .login-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        margin-top: 20px;
    }
    .login-box {
        background: white;
        border-radius: 30px;
        padding: 40px 30px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 420px;
        border: 1px solid #eaeaea;
    }
    .form-control {
        border-radius: 12px;
        padding: 12px 15px;
        border: 2px solid #e8e8e8;
        text-align: center;
        font-size: 1.2rem;
        letter-spacing: 2px;
        background-color: #fcfcfc;
    }
    .form-control:focus {
        border-color: #764ba2;
        box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.15);
        background-color: #fff;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        padding: 12px;
        font-weight: bold;
        font-size: 1.1rem;
        width: 100%;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(118, 75, 162, 0.3);
    }
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        border: none;
        border-radius: 15px;
        padding: 12px;
        font-weight: bold;
        font-size: 1.1rem;
        width: 100%;
        color: white;
        transition: all 0.3s;
    }
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    .hidden { display: none !important; }
    #error-msg, #error-msg-code { color: #dc3545; font-size: 0.9rem; text-align: center; margin-top: 10px; }
    </style>
</head>
<body>

    <!-- هدر سایت (منو) -->
    <?php include 'header.php'; ?>

    <div class="login-wrapper">
        <div class="login-box text-center">
            
            <div class="mb-4">
                <img src="images/40.jpg" alt="سیمرغ" style="width: 70px; height: 70px; border-radius: 15px; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <h4 class="fw-bold text-dark">ورود / ثبت نام</h4>
                <p class="text-muted small">فقط با شماره موبایل خود وارد شوید</p>
            </div>

            <!-- مرحله اول: وارد کردن موبایل -->
            <div id="step-mobile">
                <div class="mb-3">
                    <input type="tel" id="mobile" class="form-control" placeholder="۰۹۱۲۳۴۵۶۷۸۹" maxlength="11">
                </div>
                <button onclick="sendCode()" id="btn-send" class="btn btn-primary">دریافت کد تایید</button>
                <div id="error-msg"></div>
            </div>

            <!-- مرحله دوم: وارد کردن کد تایید -->
            <div id="step-code" class="hidden">
                <p class="text-success mb-3 small" id="msg-success"></p>
                <div class="mb-3">
                    <input type="number" id="code" class="form-control" placeholder="- - - - - -" maxlength="6" style="letter-spacing: 10px;">
                </div>
                <button onclick="verifyCode()" id="btn-verify" class="btn btn-success">ورود به حساب</button>
                <div id="error-msg-code"></div>
                <a href="#" onclick="backToMobile(event)" class="d-block mt-3 text-decoration-none small text-muted">تغییر شماره موبایل</a>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function toEnglishDigits(str) {
        return str.replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
    }

    // دریافت آدرس برگشت از PHP
    const redirectUrl = "<?php echo urlencode($current_redirect); ?>";

    function sendCode() {
        let mobile = toEnglishDigits($('#mobile').val().trim());
        if (!/^09[0-9]{9}$/.test(mobile)) {
            $('#error-msg').text('شماره موبایل باید با ۰۹ شروع شده و ۱۱ رقم باشد.');
            return;
        }
        
        $('#btn-send').text('در حال ارسال...').prop('disabled', true);
        $('#error-msg').text('');

        $.post('ajax_auth.php', { 
            action: 'send_code', 
            mobile: mobile,
            redirect: redirectUrl
        }, function(res) {
            if (res.status === 'success') {
                $('#step-mobile').addClass('hidden');
                $('#step-code').removeClass('hidden');
                $('#msg-success').text('کد تایید به شماره ' + mobile + ' ارسال شد.');
            } else {
                $('#error-msg').text(res.message);
            }
            $('#btn-send').text('دریافت کد تایید').prop('disabled', false);
        }, 'json').fail(function() {
            $('#error-msg').text('خطا در ارتباط با سرور.');
            $('#btn-send').text('دریافت کد تایید').prop('disabled', false);
        });
    }

    function verifyCode() {
        let code = toEnglishDigits($('#code').val().trim());
        if (code.length !== 6) {
            $('#error-msg-code').text('لطفا کد ۶ رقمی را وارد کنید.');
            return;
        }

        $('#btn-verify').text('در حال بررسی...').prop('disabled', true);
        $('#error-msg-code').text('');

        $.post('ajax_auth.php', { 
            action: 'verify_code', 
            code: code,
            redirect: redirectUrl
        }, function(res) {
            if (res.status === 'success') {
                window.location.href = res.redirect;
            } else {
                $('#error-msg-code').text(res.message);
                $('#btn-verify').text('ورود به حساب').prop('disabled', false);
            }
        }, 'json').fail(function() {
            $('#error-msg-code').text('خطا در ارتباط با سرور.');
            $('#btn-verify').text('ورود به حساب').prop('disabled', false);
        });
    }

    function backToMobile(e) {
        e.preventDefault();
        $('#step-code').addClass('hidden');
        $('#step-mobile').removeClass('hidden');
        $('#code').val('');
        $('#error-msg-code').text('');
    }
    </script>
    
    <?php include 'footer.php'; ?>
</body>
</html>