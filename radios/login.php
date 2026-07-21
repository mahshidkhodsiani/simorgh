<?php
session_start();

// اگر کاربر لاگین کرده، به صفحه اصلی برود
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// پردازش فرم لاگین
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // اتصال به دیتابیس
    include '../config.php';
    
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        // فرض می‌کنیم جدول users دارید
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                
                // اگر آدرس برگشت وجود داشت، به آنجا برو
                $redirect = $_SESSION['redirect_after_login'] ?? 'index.php';
                unset($_SESSION['redirect_after_login']);
                header("Location: " . $redirect);
                exit();
            } else {
                $error = 'رمز عبور اشتباه است';
            }
        } else {
            $error = 'نام کاربری یا ایمیل یافت نشد';
        }
        $stmt->close();
    } else {
        $error = 'لطفاً تمام فیلدها را پر کنید';
    }
}
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ورود به رادیو سیمرغ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Vazir', sans-serif;
    }

    .login-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .login-title {
        text-align: center;
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
    }

    .login-title span {
        color: #764ba2;
    }

    .form-control {
        border-radius: 15px;
        padding: 12px 20px;
        border: 2px solid #e8e8e8;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #764ba2;
        box-shadow: 0 0 0 0.2rem rgba(118, 75, 162, 0.25);
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        padding: 12px;
        font-weight: bold;
        font-size: 1.1rem;
        width: 100%;
        color: white;
        transition: all 0.3s;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(118, 75, 162, 0.3);
        color: white;
    }

    .error-message {
        color: #dc3545;
        text-align: center;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .logo-icon {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo-icon img {
        width: 80px;
        height: 80px;
        border-radius: 20px;
    }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="logo-icon">
            <img src="../images/36.png" alt="رادیو سیمرغ">
        </div>
        <div class="login-title">
            ورود به <span>رادیو سیمرغ</span>
        </div>

        <?php if ($error): ?>
        <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="نام کاربری یا ایمیل" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="رمز عبور" required>
            </div>
            <button type="submit" class="btn-login">ورود</button>
        </form>
    </div>
</body>

</html>