<?php

session_start();

include '../config.php';

// اگر کاربر وارد نشده است، به صفحه لاگین هدایت شود
if (!isset($_SESSION['all_data'])) {
    header("location: login.php");
    exit;
}


$errors = [];
$success = '';
$username = '';
$mobile = '';
$user_id = $_SESSION['all_data']['id'];
$username = $_SESSION['all_data']['username'];
$message = null;
$message_type = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // فیلدهای قابل ویرایش
    $username = $_POST['username'] ?? '';
    $mobile     = $_POST['mobile'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    // اعتبارسنجی ساده
    if (empty($username)) $errors[] = 'نام کامل الزامی است.';
    if (empty($mobile) || !filter_var($mobile)) $errors[] = 'ایمیل معتبر نیست.';

    if (!empty($new_password) && strlen($new_password) < 6) {
        $errors[] = 'پسورد جدید باید حداقل 6 کاراکتر باشد.';
    }

    if (empty($errors)) {
        // شروع به به‌روزرسانی
        if (empty($new_password)) {
            // بدون تغییر رمز
            $stmt = $conn->prepare('UPDATE users SET username = ?, mobile = ? WHERE id = ?');
            $stmt->execute([$username, $mobile, $user_id]);
        } else {
            // تغییر رمز
            $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('UPDATE users SET username = ?, mobile = ?, password_hash = ? WHERE id = ?');
            $stmt->execute([$username, $password_hash, $user_id]);
        }
        $success = 'پروفایل با موفقیت به‌روزرسانی شد.';
        // آپدیت مقادیر نمایش داده شده
    }
} else {
    // بارگذاری داده‌های فعلی برای نمایش در فرم
    $stmt = $conn->prepare('SELECT username, mobile FROM users WHERE id = ?');
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    $username = $row['username'] ?? '';
    $mobile = $row['mobile'] ?? '';
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>ویرایش پروفایل</title></head>
<body>
<h2>ویرایش پروفایل</h2>
<p>کاربر: <?php echo htmlspecialchars($_SESSION['username']); ?></p>

<?php
if (!empty($errors)) {
    echo '<ul style="color:red;">';
    foreach ($errors as $e) echo "<li>$e</li>";
    echo '</ul>';
}
if ($success) echo "<p style='color:green;'>$success</p>";
?>

<form method="post" action="edit_profile.php" class="needs-validation" novalidate>
  <div class="mb-3">
    <label for="username" class="form-label">نام کامل</label>
    <input
      type="text"
      class="form-control"
      id="username"
      name="username"
      value="<?php echo htmlspecialchars($username); ?>"
      required
    >
    <div class="invalid-feedback">
      لطفاً نام کامل خود را وارد کنید.
    </div>
  </div>

  <div class="mb-3">
    <label for="mobile" class="form-label">ایمیل</label>
    <!-- در اصل مقدار ورودی باید ایمیل باشد؛ اگر واقعاً موبایل است، نوع input هم می‌تواند تغییر کند -->
    <input
      type="email"
      class="form-control"
      id="mobile"
      name="mobile"
      value="<?php echo htmlspecialchars($mobile); ?>"
      required
    >
    <div class="invalid-feedback">
      لطفاً یک ایمیل معتبر وارد کنید.
    </div>
  </div>

  <div class="mb-3">
    <label for="new_password" class="form-label">پسورد جدید (اختیاری)</label>
    <input
      type="password"
      class="form-control"
      id="new_password"
      name="new_password"
      placeholder="برای تغییر رمزعبور بنویسید"
    >
  </div>

  <button type="submit" class="btn btn-primary">به‌روزرسانی</button>
</form>

<script>
  // اعتبارسنجی ساده Bootstrap
  (function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
  })()
</script>

</body>
</html>