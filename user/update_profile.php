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

    $name = $_POST['name'];
    $family = $_POST['family'];
    $mobile = $_POST['mobile']; // ✅ دریافت فیلد جدید mobile
    $username = $_POST['username'];
    $meli_code = $_POST['meli_code']; 
    $password = $_POST['password'];

    // آماده‌سازی query برای به‌روزرسانی
    if (!empty($password)) {
        // اگر رمز عبور وارد شده بود، آن را هش کنید
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // ✅ اصلاح: اضافه شدن mobile به کوئری
        $sql = "UPDATE users SET name = ?, family = ?, mobile = ?, username = ?, meli_code = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        // ✅ اصلاح: اضافه شدن 's' برای نوع mobile و متغیر $mobile
        $stmt->bind_param("ssssssi", $name, $family, $mobile, $username, $meli_code, $hashed_password, $user_id);
    } else {
        // اگر رمز عبور خالی بود، آن را به‌روزرسانی نکنید
        
        // ✅ اصلاح: اضافه شدن mobile به کوئری
        $sql = "UPDATE users SET name = ?, family = ?, mobile = ?, username = ?, meli_code = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        // ✅ اصلاح: اضافه شدن 's' برای نوع mobile و متغیر $mobile
        $stmt->bind_param("sssssi", $name, $family, $mobile, $username, $meli_code, $user_id);
    }

    if ($stmt->execute()) {
        // اگر به‌روزرسانی موفقیت‌آمیز بود، پیام موفقیت را در سشن ذخیره کرده و به صفحه پروفایل برگردید
        $_SESSION['success_message'] = "اطلاعات پروفایل شما با موفقیت به‌روزرسانی شد.";
        
        // مهم: به‌روزرسانی mobile در سشن
        $_SESSION['all_data']['mobile'] = $mobile;
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