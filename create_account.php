<?php
session_start();
include 'config.php'; // اتصال به دیتابیس

// پردازش فرم ثبت نام
if (isset($_POST['submit_create'])) {
    $name = $_POST['name'];
    $family = $_POST['family'];
    $meli_code = $_POST['meli_code'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $username = $_POST['username'];

    // --- اعتبارسنجی سمت سرور (Server-Side Validation) ---
    // تبدیل اعداد فارسی به انگلیسی در PHP قبل از بررسی
    $persian_digits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $meli_code = str_replace($persian_digits, $english_digits, $meli_code);
    $mobile = str_replace($persian_digits, $english_digits, $mobile);

    // بررسی اینکه کد ملی فقط شامل ۱۰ رقم انگلیسی باشد.
    if (!preg_match('/^[0-9]{10}$/', $meli_code)) {
        $_SESSION['toast'] = ['type' => 'danger', 'message' => '❌ کد ملی باید ۱۰ رقم و فقط شامل اعداد انگلیسی باشد.'];
        header("Location: create_account.php");
        exit();
    }

    // بررسی اینکه شماره موبایل فقط شامل اعداد انگلیسی باشد.
    if (!preg_match('/^[0-9]+$/', $mobile)) {
        $_SESSION['toast'] = ['type' => 'danger', 'message' => '❌ شماره موبایل باید فقط شامل اعداد انگلیسی باشد.'];
        header("Location: create_account.php");
        exit();
    }

    // بررسی اینکه یوزرنیم فقط شامل حروف و اعداد انگلیسی باشد.
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $_SESSION['toast'] = ['type' => 'danger', 'message' => '❌ یوزرنیم باید فقط شامل حروف و اعداد انگلیسی باشد.'];
        header("Location: create_account.php");
        exit();
    }
    // --- پایان اعتبارسنجی سمت سرور ---

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // بررسی وجود کاربر
    $checkUserSql = "SELECT * FROM users WHERE meli_code = ? OR username = ?";
    $stmt = $conn->prepare($checkUserSql);
    $stmt->bind_param("ss", $meli_code, $username);
    $stmt->execute();
    $checkUserResult = $stmt->get_result();

    if ($checkUserResult->num_rows > 0) {
        $_SESSION['toast'] = ['type' => 'warning', 'message' => '⚠️ کاربری با این کد ملی یا یوزرنیم قبلا ثبت شده است.'];
        header("Location: create_account.php");
        exit();
    }

    // درج کاربر جدید
    $insert_user = "INSERT INTO users (name, family, username, password, meli_code, mobile, level, admin, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, 'user', 0, NOW())";
    $stmt = $conn->prepare($insert_user);
    $stmt->bind_param("ssssss", $name, $family, $username, $hashedPassword, $meli_code, $mobile);

    if ($stmt->execute()) {
        $_SESSION['toast'] = ['type' => 'success', 'message' => '✅ ثبت نام با موفقیت انجام شد.'];
    } else {
        $_SESSION['toast'] = ['type' => 'danger', 'message' => '❌ خطا در ثبت کاربر!'];
    }
    $stmt->close();
}

$conn->close();
?>

<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ - ثبت نام</title>
    <?php include 'includes.php'; ?>
    <link rel="icon" href="images/logo1.ico" type="image/x-icon">
    <style>
        body {
            font-weight: bold !important;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-4">
        <div class="form-container border p-4 rounded shadow-sm">
            <h5 class="text-center mb-4">ایجاد حساب کاربری</h5>
            <form action="" method="post" id="registrationForm">
                <div class="mb-3">
                    <label for="name" class="form-label">نام</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="family" class="form-label">نام خانوادگی</label>
                    <input type="text" class="form-control" id="family" name="family" required>
                </div>
                <div class="mb-3">
                    <label for="meli_code" class="form-label">کد ملی</label>
                    <input type="text" class="form-control" id="meli_code" name="meli_code" required oninput="checkNumbers(this)">
                    <div id="meli_code_error" class="text-danger mt-1 d-none">لطفاً کد ملی را به **اعداد انگلیسی** وارد کنید.</div>
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">شماره موبایل</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" required oninput="checkNumbers(this)">
                    <div id="mobile_error" class="text-danger mt-1 d-none">لطفاً شماره موبایل را به **اعداد انگلیسی** وارد کنید.</div>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">یوزرنیم</label>
                    <input type="text" class="form-control" id="username" name="username" required oninput="checkEnglish(this)">
                    <div id="username_error" class="text-danger mt-1 d-none">لطفاً یوزرنیم را به **انگلیسی** وارد کنید.</div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">پسورد</label>
                    <input type="password" class="form-control" id="password" name="password" required oninput="checkEnglish(this)">
                    <div id="password_error" class="text-danger mt-1 d-none">لطفاً پسورد را به **انگلیسی** وارد کنید.</div>
                </div>
                <button name="submit_create" class="btn btn-primary w-100">ثبت نام</button>
                <br>
                <br>
                <a href="login.php" class="btn btn-outline-primary w-100">ورود به حساب کاربری</a>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
        <?php if (isset($_SESSION['toast'])): ?>
            <div class="toast text-bg-<?= $_SESSION['toast']['type'] ?> border-0 shadow-lg"
                role="alert" aria-live="assertive" aria-atomic="true"
                style="min-width: 320px; font-size: 1.1rem; padding: 1rem;">
                <div class="d-flex">
                    <div class="toast-body fw-bold">
                        <?= $_SESSION['toast']['message'] ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <?php
            $is_success = ($_SESSION['toast']['type'] == 'success');
            unset($_SESSION['toast']);
            ?>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toastEl = document.querySelector('.toast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                toast.show();

                // ریدایرکت با تاخیر 3 ثانیه‌ای فقط در صورت موفقیت
                <?php if (isset($is_success) && $is_success): ?>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 3000); // 3000 میلی‌ثانیه = 3 ثانیه
                <?php endif; ?>
            }
        });

        // تابعی برای تبدیل اعداد فارسی به انگلیسی
        function toEnglishDigits(str) {
            var persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            var englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            for (var i = 0; i < 10; i++) {
                str = str.replace(new RegExp(persianNumbers[i], 'g'), englishNumbers[i]);
            }
            return str;
        }

        // بررسی اعداد انگلیسی
        function checkNumbers(inputElement) {
            var inputValue = inputElement.value;
            var errorElement = document.getElementById(inputElement.id + '_error');
            var isPersian = /[۰-۹]/.test(inputValue);

            // تبدیل اعداد فارسی به انگلیسی
            inputElement.value = toEnglishDigits(inputValue);

            if (isPersian) {
                errorElement.classList.remove('d-none');
                inputElement.classList.add('is-invalid');
            } else {
                errorElement.classList.add('d-none');
                inputElement.classList.remove('is-invalid');
            }
        }

        // بررسی حروف انگلیسی
        function checkEnglish(inputElement) {
            var inputValue = inputElement.value;
            var errorElement = document.getElementById(inputElement.id + '_error');
            var isPersian = /[آ-ی]/.test(inputValue);

            if (isPersian) {
                errorElement.classList.remove('d-none');
                inputElement.classList.add('is-invalid');
            } else {
                errorElement.classList.add('d-none');
                inputElement.classList.remove('is-invalid');
            }
        }

        // بررسی کل فرم قبل از ارسال
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            var hasError = false;
            var numberInputs = ['meli_code', 'mobile'];
            var englishInputs = ['username', 'password'];

            numberInputs.forEach(function(id) {
                var inputElement = document.getElementById(id);
                var errorElement = document.getElementById(id + '_error');
                var inputValue = inputElement.value;
                var isPersian = /[۰-۹آ-ی]/.test(inputValue);

                if (isPersian) {
                    errorElement.classList.remove('d-none');
                    inputElement.classList.add('is-invalid');
                    hasError = true;
                }
            });

            englishInputs.forEach(function(id) {
                var inputElement = document.getElementById(id);
                var errorElement = document.getElementById(id + '_error');
                var inputValue = inputElement.value;
                var isPersian = /[۰-۹آ-ی]/.test(inputValue);

                if (isPersian) {
                    errorElement.classList.remove('d-none');
                    inputElement.classList.add('is-invalid');
                    hasError = true;
                }
            });

            if (hasError) {
                event.preventDefault(); // جلوگیری از ارسال فرم
            }
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
            "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !1);
        }();
    </script>
</body>

</html>