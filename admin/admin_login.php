<?php
session_start();
include '../config.php';

// اگر قبلاً ادمین لاگین کرده، مستقیم بره پنل
if (isset($_SESSION["all_data"]) && (int)($_SESSION["all_data"]["admin"] ?? 0) === 1) {
    header("Location: code_takhfif.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'لطفاً نام کاربری و رمز عبور را وارد کنید.';
    } else {
        // فقط با username (چون ستون email وجود نداره)
        $sql = "SELECT id, name, family, username, password, admin, speaker
                FROM users
                WHERE username = ?
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if ((int)$user['admin'] !== 1) {
                    $error = 'این حساب دسترسی ادمین ندارد.';
                } else {
                    if (password_verify($password, $user['password'])) {
                        // ساخت session مطابق انتظار code_takhfif.php
                        $_SESSION["all_data"] = [
                            'id'       => (int)$user['id'],
                            'name'     => $user['name'],
                            'family'   => $user['family'],
                            'username' => $user['username'],
                            'admin'    => 1,
                            'speaker'  => (int)($user['speaker'] ?? 0),
                        ];
                        $_SESSION["user_id"] = (int)$user['id'];

                        header("Location: code_takhfif.php");
                        exit();
                    } else {
                        $error = 'رمز عبور اشتباه است.';
                    }
                }
            } else {
                $error = 'کاربری با این نام کاربری یافت نشد.';
            }
            $stmt->close();
        } else {
            $error = 'خطای پایگاه داده.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود ادمین</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <?php include 'includes.php'; ?>

    <style>
    body {
        min-height: 100vh;
        margin: 0;
        background: linear-gradient(135deg, #060b22 0%, #0d1a47 50%, #16295f 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: inherit;
        padding: 20px;
    }

    .al-card {
        width: 100%;
        max-width: 400px;
        background: rgba(15, 15, 30, .85);
        border: 1px solid rgba(245, 184, 46, .3);
        border-radius: 20px;
        padding: 36px 28px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, .55);
        color: #fff;
    }

    .al-title {
        text-align: center;
        font-size: 1.4rem;
        font-weight: 800;
        color: #f5b82e;
        margin: 0 0 24px;
    }

    .al-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: rgba(255, 255, 255, .85);
        margin-bottom: 6px;
    }

    .al-input {
        width: 100%;
        padding: 11px 14px;
        font-size: .95rem;
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(245, 184, 46, .3);
        border-radius: 12px;
        color: #fff;
        outline: none;
        transition: border-color .3s, box-shadow .3s;
    }

    .al-input:focus {
        border-color: #f5b82e;
        box-shadow: 0 0 0 3px rgba(245, 184, 46, .2);
    }

    .al-input::placeholder { color: rgba(255, 255, 255, .35); }

    .al-field { margin-bottom: 16px; }

    .al-btn {
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        font-weight: 800;
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #ffe08a, #f5b82e);
        color: #0d1a47;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 10px 25px rgba(245, 184, 46, .35);
        margin-top: 8px;
    }

    .al-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(245, 184, 46, .5);
    }

    .al-error {
        padding: 10px 14px;
        border-radius: 10px;
        font-size: .9rem;
        font-weight: 600;
        margin-bottom: 18px;
        background: rgba(220, 53, 69, .18);
        border: 1px solid rgba(220, 53, 69, .5);
        color: #ff9ba6;
        text-align: center;
    }
    </style>
</head>

<body>

    <div class="al-card">
        <h1 class="al-title">🛡️ ورود ادمین</h1>

        <?php if ($error !== ''): ?>
            <div class="al-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="al-field">
                <label for="username" class="al-label">نام کاربری</label>
                <input type="text" id="username" name="username" class="al-input"
                    placeholder="نام کاربری" required autofocus
                    value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>

            <div class="al-field">
                <label for="password" class="al-label">رمز عبور</label>
                <input type="password" id="password" name="password" class="al-input"
                    placeholder="رمز عبور" required>
            </div>

            <button type="submit" class="al-btn">ورود</button>
        </form>
    </div>

</body>

</html>