<?php
session_start();

// اگر کاربر وارد نشده است، به صفحه لاگین هدایت شود
if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION['all_data']['id'];

// بررسی اینکه آیا اطلاعات به صورت POST ارسال شده است
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../config.php';

    // دریافت اطلاعات ارسالی از فرم و sanitize کردن
    $name = $_POST['name'];
    $family = $_POST['family'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // آماده‌سازی query برای به‌روزرسانی
    if (!empty($password)) {
        // اگر رمز عبور وارد شده بود، آن را هش کنید
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET name = ?, family = ?, username = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $family, $username, $hashed_password, $user_id);
    } else {
        // اگر رمز عبور خالی بود، آن را به‌روزرسانی نکنید
        $sql = "UPDATE users SET name = ?, family = ?, username = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $family, $username, $user_id);
    }

    if ($stmt->execute()) {
        // اگر به‌روزرسانی موفقیت‌آمیز بود، پیام موفقیت را در سشن ذخیره کرده و به صفحه پروفایل برگردید
        $_SESSION['success_message'] = "اطلاعات پروفایل شما با موفقیت به‌روزرسانی شد.";
    } else {
        // در صورت خطا
        $_SESSION['success_message'] = "خطا در به‌روزرسانی اطلاعات: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

// هدایت کاربر به صفحه اصلی ویرایش پروفایل
header("location: profile.php");
exit;
