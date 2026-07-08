<?php
// شروع نشست
session_start();

// فراخوانی فایل اتصال به پایگاه داده
include '../config.php';

// بررسی اینکه آیا package_id یا radio_tehran_id ارسال شده است
if (isset($_POST['package_id'])) {
    $package_id = intval($_POST['package_id']);
    $radio_tehran_id = null;
    $item_type = 'package';
} elseif (isset($_POST['radio_tehran_id'])) {
    $radio_tehran_id = intval($_POST['radio_tehran_id']);
    $package_id = null;
    $item_type = 'radio';
} else {
    // هیچکدام ارسال نشده
    header("Location: ../index.php");
    exit();
}

// اگر سبد خرید در نشست وجود نداشت، آن را به عنوان یک آرایه خالی ایجاد کن
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ذخیره در سشن
$cart_item = [
    'type' => $item_type,
    'package_id' => $package_id,
    'radio_tehran_id' => $radio_tehran_id
];

// بررسی تکراری نبودن
$is_duplicate = false;
foreach ($_SESSION['cart'] as $item) {
    if ($item['type'] == $item_type) {
        if ($item_type == 'package' && $item['package_id'] == $package_id) {
            $is_duplicate = true;
            break;
        } elseif ($item_type == 'radio' && $item['radio_tehran_id'] == $radio_tehran_id) {
            $is_duplicate = true;
            break;
        }
    }
}

if (!$is_duplicate) {
    $_SESSION['cart'][] = $cart_item;
}

// بررسی وضعیت ورود کاربر
if (isset($_SESSION['user_id'])) {
    // اگر کاربر وارد شده، اطلاعات را به پایگاه داده منتقل کن
    $user_id = intval($_SESSION['user_id']);

    // جلوگیری از افزودن تکراری در پایگاه داده
    $insert_sql = "INSERT IGNORE INTO `user_cart` (`user_id`, `package_id`, `radio_tehran_id`) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iii", $user_id, $package_id, $radio_tehran_id);
    $insert_stmt->execute();
    $insert_stmt->close();

    // هدایت به صفحه سبد خرید
    header("Location: ../user/user_cart.php");
} else {
    // اگر کاربر وارد نشده، آدرس فعلی رو برای برگشت ذخیره کن
    $_SESSION['redirect_after_login'] = $_SERVER['HTTP_REFERER'] ?? '../radios/tehran.php';
    // به صفحه ورود هدایت کن
    header("Location: ../login.php");
}

exit();
?>