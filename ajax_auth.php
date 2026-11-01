<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

// ==========================================
// مرحله ۱: ارسال کد تایید (چه برای لاگین چه ثبت نام)
// ==========================================
if ($action === 'send_code') {
    $mobile = trim($_POST['mobile'] ?? '');

    // تبدیل اعداد فارسی به انگلیسی
    $persian_digits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $mobile = str_replace($persian_digits, $english_digits, $mobile);

    if (!preg_match('/^09[0-9]{9}$/', $mobile)) {
        echo json_encode(['status' => 'error', 'message' => 'شماره موبایل نامعتبر است. (مثال: 09123456789)']);
        exit;
    }

    // بررسی اینکه آیا کاربر وجود دارد یا باید ثبت نام شود
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE mobile = ? LIMIT 1");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // ثبت نام خودکار با اطلاعات تصادفی (چون فقط با موبایل کار می‌کنیم)
        $random_username = 'user_' . rand(100000, 999999);
        $random_password = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);
        $name = 'کاربر جدید';
        
        $insert_stmt = $conn->prepare("INSERT INTO users (name, username, password, mobile, level, admin, created_at) VALUES (?, ?, ?, ?, 'user', 0, NOW())");
        $insert_stmt->bind_param("ssss", $name, $random_username, $random_password, $mobile);
        
        if (!$insert_stmt->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'خطا در ایجاد حساب کاربری!']);
            exit;
        }
        $user_id = $insert_stmt->insert_id;
        $insert_stmt->close();
    } else {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    }
    $stmt->close();

    // تولید کد ۶ رقمی
    $code = rand(100000, 999999);
    $_SESSION['auth_code'] = $code;
    $_SESSION['auth_mobile'] = $mobile;
    $_SESSION['auth_user_id'] = $user_id;
    $_SESSION['auth_time'] = time();

    // ارسال پیامک با تنظیمات فایل فراموشی رمز
    $sms_username = "09124366786";
    $sms_password = "96139290@sN";
    $from = "300016343000";
    $message = "کد تایید ورود شما به هفت هنر سیمرغ: " . $code;
    $url = "https://niksms.com/fa/publicapi/groupsms";

    $data = [
        "username" => $sms_username,
        "password" => $sms_password,
        "numbers" => $mobile,
        "sendernumber" => $from,
        "message" => $message,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    echo json_encode(['status' => 'success', 'message' => 'کد تایید ارسال شد.']);
    exit;
}

// ==========================================
// مرحله ۲: بررسی کد و لاگین
// ==========================================
if ($action === 'verify_code') {
    $code = trim($_POST['code'] ?? '');

    if (!isset($_SESSION['auth_code']) || !isset($_SESSION['auth_user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'درخواست نامعتبر است. لطفا دوباره تلاش کنید.']);
        exit;
    }

    // بررسی انقضای کد (۲ دقیقه)
    if (time() - $_SESSION['auth_time'] > 120) {
        unset($_SESSION['auth_code'], $_SESSION['auth_mobile'], $_SESSION['auth_user_id'], $_SESSION['auth_time']);
        echo json_encode(['status' => 'error', 'message' => 'زمان کد به پایان رسیده است. دوباره تلاش کنید.']);
        exit;
    }

    if ($code == $_SESSION['auth_code']) {
        // لاگین موفق
        $user_id = $_SESSION['auth_user_id'];
        
        // دریافت اطلاعات کامل کاربر برای سشن
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['all_data'] = $user;

        // پاک کردن سشن‌های موقت
        unset($_SESSION['auth_code'], $_SESSION['auth_mobile'], $_SESSION['auth_user_id'], $_SESSION['auth_time']);

        // هدایت بر اساس نقش
        if ($user['admin'] == 1) {
            unset($_SESSION['redirect_after_login']);
            echo json_encode(['status' => 'success', 'redirect' => '/admin/index']);
        } elseif (isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            echo json_encode(['status' => 'success', 'redirect' => $redirect]);
        } elseif (isset($_SESSION['is_pwa']) && $_SESSION['is_pwa'] === true) {
            echo json_encode(['status' => 'success', 'redirect' => '/radios/index.php']);
        } else {
            echo json_encode(['status' => 'success', 'redirect' => '/user/profile']);
        }
        exit;

    } else {
        echo json_encode(['status' => 'error', 'message' => 'کد وارد شده صحیح نیست.']);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'درخواست نامعتبر']);
?>