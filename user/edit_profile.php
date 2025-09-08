<?php  
session_start();  

include '../config.php';  

$errors = [];  
$success = '';  
$username = '';  
$mobile = '';  
$name = '';  
$family = ''; 
$message = '' ;
$password = '';  
$user_id = isset($_SESSION['all_data']['id']) ? $_SESSION['all_data']['id'] : null;  
//if ($user_id === null) {  
    // اگر کاربر لاگین نکرده، هدایتش کنید  
    // header("Location: login.php");  
    // exit;  
//}  

// مقدار اولیه از سشن  
$username = isset($_SESSION['all_data']['username']) ? $_SESSION['all_data']['username'] : '';  
$mobile   = isset($_SESSION['all_data']['mobile']) ? $_SESSION['all_data']['mobile'] : '';  
$name     = isset($_SESSION['all_data']['name']) ? $_SESSION['all_data']['name'] : '';  
$family   = isset($_SESSION['all_data']['family']) ? $_SESSION['all_data']['family'] : '';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  

    // گرفتن داده‌ها از فرم  
    $username     = trim($_POST['username'] ?? '');  
    $mobile       = trim($_POST['mobile'] ?? '');  
    $new_password = trim($_POST['new_password'] ?? '');  
    $name         = trim($_POST['name'] ?? '');  
    $family       = trim($_POST['family'] ?? '');  

    // اعتبارسنجی  
    if (empty($username)) $errors[] = 'نام کامل الزامی است.';  

    $mobilePattern = '/^[0-9]{10,15}$/';  
    if (empty($mobile) || !preg_match($mobilePattern, $mobile)) {  
        $errors[] = 'موبایل معتبر نیست.';  
    }  

    if (!empty($new_password) && strlen($new_password) < 6) {  
        $errors[] = 'پسورد جدید باید حداقل 6 کاراکتر باشد.';  
    }  

    if (empty($errors)) {  
        if (empty($new_password)) {  
            // بدون تغییر رمز  
            $stmt_update = $conn->prepare('UPDATE users SET username = ?, mobile = ?, name = ?, family = ? WHERE id = 3');  
            $stmt_update->bind_param('ssssi', $username, $mobile, $name, $family, $user_id);  
        } else { 
           
            // با تغییر رمز  
            $password = password_hash($new_password, PASSWORD_DEFAULT);  
            $stmt_update = $conn->prepare('UPDATE users SET username = ?, mobile = ?, name = ?, family = ?, password = ? WHERE id = ?');  
            $stmt_update->bind_param('sssssi', $username, $mobile, $name, $family, $password, $user_id);  
        }


               
        if ($stmt_update->execute()) {  
            if (empty($new_password)) {
                $success = 'پروفایل با موفقیت به‌روزرسانی شد.';  
            } else {
                $success = 'پروفایل با موفقیت به‌روزرسانی شد و رمز عبور نیز به‌روز شد.';  
            }
            // آپدیت مقادیر سشن  
            $_SESSION['all_data']['username'] = $username;  
            $_SESSION['all_data']['mobile'] = $mobile;  
            $_SESSION['all_data']['name'] = $name;  
            $_SESSION['all_data']['family'] = $family;  
        } else {  
            $errors[] = 'خطا در به‌روزرسانی: ' . $stmt_update->error;  
        }  
        $stmt_update->close();  
    }  
}  
?>

<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>ویرایش پروفایل</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        :root {
            --primary-color: #FF4500;
            --secondary-color: #f8f9fc;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Vazir', 'Tanha', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
        }

        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            height: 100%;
            width: var(--sidebar-width);
            background-color: #ffffff;
            color: #333;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .sidebar-brand {
            height: 70px;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            z-index: 1;
            color: #333 !important;
        }

        .sidebar .nav-item {
            position: relative;
            margin: 0 10px;
        }

        .sidebar .nav-item .nav-link {
            color: #555;
            font-weight: 500;
            padding: 10px;
            margin: 5px 0;
            border-radius: 10px;
        }

        .sidebar .nav-item .nav-link:hover {
            color: #333;
            background: rgba(255, 69, 0, 0.05);
        }

        .sidebar .nav-item.active .nav-link {
            color: #333;
            background: rgba(255, 69, 0, 0.1);
            font-weight: 700;
        }

        .sidebar .nav-item .nav-link i {
            margin-left: 10px;
        }

        #content-wrapper {
            width: calc(100% - var(--sidebar-width));
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s;
        }

        .topbar {
            height: 70px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-stats .card-body {
            padding: 1rem;
        }

        .card-stats .icon-big {
            font-size: 3rem;
            opacity: 0.3;
        }

        .bg-gradient-primary {
            background: linear-gradient(87deg, #FF4500 0, #FFD700 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(87deg, #1cc88a 0, #13855c 100%) !important;
        }

        .bg-gradient-info {
            background: linear-gradient(87deg, #36b9cc 0, #258391 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(87deg, #FFD700 0, #FF4500 100%) !important;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .dropdown-menu {
            left: 0 !important;
            right: auto !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            body.sidebar-toggled .sidebar {
                width: var(--sidebar-width);
                overflow: visible;
            }

            body.sidebar-toggled #content-wrapper {
                margin-right: var(--sidebar-width);
            }

            #content-wrapper {
                width: 100%;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include 'header.php'; ?>
  <div class="container-fluid py-2">
            <?php if ($message): ?>
                <div id="alertMessage" class="alert alert-<?php echo $message_type; ?> text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </div>


    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="edit_profile.php" class="needs-validation" novalidate>
      <div class="container-fluid py-4">
            <h1 class="h3 mb-4 text-gray-800"> ویرایش پروفایل</h1>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">فرم تکمیل اطلاعات و آپلود مدارک</h6>
                        </div>
                        <div class="card-body">
        <label for="name" class="form-label">نام</label>
        <input type="text" class="form-control" id="name" name="name"
               value="<?= htmlspecialchars($name) ?>">
      </div>

      <div class="card-body">
        <label for="family" class="form-label">نام خانوادگی</label>
        <input type="text" class="form-control" id="family" name="family"
               value="<?= htmlspecialchars($family) ?>">
      </div>
      <div class="card-body">
        <label for="username" class="form-label">یوزر</label>
        <input type="text" class="form-control" id="username" name="username"
               value="<?= htmlspecialchars($username) ?>" required>
        <div class="invalid-feedback">لطفاً نام کاربری خود را وارد کنید.</div>
      </div>
      <div class="card-body">
        <label for="new_password" class="form-label">پسورد جدید (اختیاری)</label>
        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="برای تغییر رمزعبور بنویسید">
      </div>
      <div class="card-body">
        <label for="mobile" class="form-label">موبایل</label>
        <input type="text" class="form-control" id="mobile" name="mobile"
               value="<?= htmlspecialchars($mobile) ?>" required pattern="[0-9]{10,15}">
        <div class="invalid-feedback">لطفاً یک موبایل معتبر وارد کنید.</div>
      </div>

      <button type="submit" class="btn btn-primary">به‌روزرسانی</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <script>
    (function () {
      'use strict';
      var forms = document.querySelectorAll('.needs-validation');
      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    })();
  </script>
</body>
</html>
