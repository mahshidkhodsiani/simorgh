<?php
// شروع نشست
session_start();

// فراخوانی فایل‌های مورد نیاز (مانند فایل اتصال به پایگاه داده)
include '../config.php';

// بررسی اینکه آیا یک package_id از طریق فرم POST ارسال شده است
if (isset($_POST['package_id'])) {
    $package_id = intval($_POST['package_id']); // اطمینان از اینکه مقدار عددی است

    // اگر سبد خرید در نشست وجود نداشت، آن را به عنوان یک آرایه خالی ایجاد کن
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // اگر پکیج از قبل در سبد خرید نیست، آن را به آرایه اضافه کن
    if (!in_array($package_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $package_id;
    }

    // بررسی وضعیت ورود کاربر
    if (isset($_SESSION['user_id'])) {
        // اگر کاربر وارد شده، اطلاعات را به پایگاه داده منتقل کن
        $user_id = intval($_SESSION['user_id']);

        // جلوگیری از افزودن تکراری در پایگاه داده با استفاده از INSERT IGNORE
        $insert_sql = "INSERT IGNORE INTO `user_cart` (`user_id`, `package_id`) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $user_id, $package_id);
        $insert_stmt->execute();

        // هدایت به پنل کاربری
        header("Location: ../user/profile.php");
    } else {
        // اگر کاربر وارد نشده، به صفحه ورود هدایت کن
        header("Location: ../login.php");
    }

    exit();
}
