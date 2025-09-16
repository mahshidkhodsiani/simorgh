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
        // **اینجا دیگه ریدایرکت نمی‌کنیم.**
    } else {
        $_SESSION['toast'] = ['type' => 'danger', 'message' => '❌ خطا در ثبت کاربر!'];
        // **اینجا هم ریدایرکت نمی‌کنیم.**
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
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-4">
        <div class="form-container border p-4 rounded shadow-sm">
            <h5 class="text-center mb-4">ایجاد حساب کاربری</h5>
            <form action="" method="post">
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
                    <input type="text" class="form-control" id="meli_code" name="meli_code" required>
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">شماره موبایل</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">یوزرنیم</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">پسورد</label>
                    <input type="password" class="form-control" id="password" name="password" required>
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
    </script>
</body>

</html>