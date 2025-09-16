<?php
session_start();



if (isset($_POST['enter'])) {
   // 1. جلوگیری از SQL Injection با Prepared Statements
   require 'config.php';
   include 'PersianCalendar.php';

   $username = $_POST['username'];
   $password = $_POST['password'];

   $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
 
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("s", $username);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // 2. بررسی رمز عبور هش شده با password_verify
      if (password_verify($password, $user['password'])) {

         $_SESSION['all_data'] = $user;

         // 3. هدایت کاربر بر اساس سطح دسترسی (level)
         if ($user['admin'] == 1) {
            header("Location: admin/index");
            exit();
         } else if ($user['admin'] == 0) {
            header("Location: user/profile");
            exit();
         } else {
            echo 'سطح دسترسی شما نامعتبر است.';
            session_destroy();
            exit();
         }
      } else {
         // رمز عبور اشتباه است
         echo 'نام کاربری یا رمز عبور اشتباه است.';
      }
   } else {
      // نام کاربری پیدا نشد
      echo 'نام کاربری یا رمز عبور اشتباه است.';
   }

   $stmt->close();
   $conn->close();
}
