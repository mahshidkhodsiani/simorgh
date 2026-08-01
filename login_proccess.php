<?php
session_start();

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

         // --- اول سطح دسترسی را بررسی کن ---
         if ($user['admin'] == 1) {
            header("Location: /admin/index");
            exit();
         }

         // ==========================================
         // اولویت 1: آدرس برگشت ذخیره شده در سشن
         // ==========================================
         if (isset($_SESSION['redirect_after_login']) && !empty($_SESSION['redirect_after_login'])) {
            $redirect_url = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            
            // اگر آدرس شامل رادیو هست، به همان برو
            header("Location: " . $redirect_url);
            exit();
         }

         // ==========================================
         // اولویت 2: بررسی PWA
         // ==========================================
         if (isset($_SESSION['is_pwa']) && $_SESSION['is_pwa'] === true) {
            // پاک کردن وضعیت PWA تا دفعه بعد دوباره لاگین بخواد
            // اگه میخواید همیشه لاگین بمونه، این دو خط رو کامنت کنید
            // unset($_SESSION['is_pwa']);
            // unset($_SESSION['redirect_after_login']);
            
            // هدایت به صفحه رادیو
            header("Location: /radios/index.php");
            exit();
         }

         // ==========================================
         // اولویت 3: سبد خرید
         // ==========================================
         if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $user_id = $_SESSION['user_id'];

            // آماده‌سازی کوئری برای درج در user_cart
            $insert_sql = "INSERT IGNORE INTO `user_cart` (`user_id`, `package_id`) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ii", $user_id, $package_id);

            foreach ($_SESSION['cart'] as $package_id) {
               $insert_stmt->execute();
            }

            $insert_stmt->close();
            unset($_SESSION['cart']); // پاک کردن سبد خرید موقت

            // هدایت به صفحه سبد خرید نهایی
            header("Location: /user/user_cart.php");
            exit();
         }

         // ==========================================
         // هدایت پیش‌فرض برای کاربر عادی
         // ==========================================
         header("Location: /user/profile");
         exit();
         
      } else {
         // رمز عبور اشتباه
         $_SESSION['login_error'] = 'نام کاربری یا رمز عبور اشتباه است.';
         header("Location: /login.php");
         exit();
      }
   } else {
      // نام کاربری پیدا نشد
      $_SESSION['login_error'] = 'نام کاربری یا رمز عبور اشتباه است.';
      header("Location: login.php");
      exit();
   }

   $stmt->close();
   $conn->close();
}
?>