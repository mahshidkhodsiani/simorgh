<?php
// ============================================
// ✅ شروع سشن با تنظیمات واحد (باید دقیقاً مثل tehran.php و login.php باشه)
// ============================================
if (session_status() === PHP_SESSION_NONE) {
    $isSecure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    if (!$isSecure && isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        $isSecure = true;
    }
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

if (isset($_POST['enter'])) {
   require 'config.php';

   $username = $_POST['username'];
   $password = $_POST['password'];

   // استفاده از Prepared Statements برای جلوگیری از SQL Injection
   $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("s", $username);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // بررسی رمز عبور هش شده
      if (password_verify($password, $user['password'])) {
         $_SESSION['user_id'] = $user['id'];
         $_SESSION['username'] = $user['username'];
         $_SESSION['all_data'] = $user;

         // ==========================================
         // اولویت 0: ادمین
         // ==========================================
         if ($user['admin'] == 1) {
            unset($_SESSION['redirect_after_login']);
            unset($_SESSION['is_pwa']);
            header("Location: /admin/index");
            exit();
         }

         // ==========================================
         // اولویت 1 (مطلق): آدرس برگشت ذخیره شده
         // هر صفحه‌ای که کاربر ازش اومده بود، همون‌جا برمی‌گرده
         // ==========================================
         if (isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])) {
            $redirect_url = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            // پاک کردن PWA چون redirect اولویت داره
            unset($_SESSION['is_pwa']);

            header("Location: " . $redirect_url);
            exit();
         }

         // ==========================================
         // اولویت 2: سبد خرید
         // ==========================================
         if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $user_id = $_SESSION['user_id'];

            $insert_sql = "INSERT IGNORE INTO `user_cart` (`user_id`, `package_id`) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ii", $user_id, $package_id);

            foreach ($_SESSION['cart'] as $package_id) {
               $insert_stmt->execute();
            }

            $insert_stmt->close();
            unset($_SESSION['cart']);
            unset($_SESSION['is_pwa']);

            header("Location: /user/user_cart.php");
            exit();
         }

         // ==========================================
         // اولویت 3: PWA (فقط اگر redirect نداشتیم)
         // ==========================================
         if (isset($_SESSION['is_pwa']) && $_SESSION['is_pwa'] === true) {
            unset($_SESSION['is_pwa']);
            header("Location: /radios/index.php");
            exit();
         }

         // ==========================================
         // پیش‌فرض: کاربر عادی
         // ==========================================
         unset($_SESSION['is_pwa']);
         header("Location: /user/profile");
         exit();

      } else {
         $_SESSION['login_error'] = 'نام کاربری یا رمز عبور اشتباه است.';
         // حفظ redirect برای تلاش مجدد
         header("Location: /login.php");
         exit();
      }
   } else {
      $_SESSION['login_error'] = 'نام کاربری یا رمز عبور اشتباه است.';
      header("Location: /login.php");
      exit();
   }

   $stmt->close();
   $conn->close();
}
?>