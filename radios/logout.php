<?php
session_start();

// پاک کردن تمام سشن ها
$_SESSION = array();

// اگر کوکی سشن وجود دارد، آن را نیز حذف کنید
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// نابودی سشن
session_destroy();

// دریافت آدرس صفحه قبلی (referer)
$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// هدایت به صفحه قبلی
header("Location: " . $redirect);
exit;
?>