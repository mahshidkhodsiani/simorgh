<?php
session_start();

// اگر کاربر وارد نشده است، به صفحه لاگین هدایت شود
//if (!isset($_SESSION['all_data'])) {
    //header("location: ../login.php");
    //exit;
//}

$user_id = $_SESSION['all_data']['id'];
$username = $_SESSION['all_data']['username'];
$message = null;
$message_type = null;

// اطمینان حاصل کنید که مسیر فایل config.php صحیح است
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. بازیابی شماره ملی کاربر از پایگاه داده
    $sql_get_meli_code = "SELECT meli_code FROM users WHERE id = ?";
    $stmt_get_meli = $conn->prepare($sql_get_meli_code);

    if (!$stmt_get_meli) {
        $message = "خطا در آماده‌سازی کوئری: " . $conn->error;
        $message_type = "danger";
    } else {
  
        $stmt_get_meli->bind_param("i", $user_id);
        $stmt_get_meli->execute();
        $result = $stmt_get_meli->get_result();
        $user_data = $result->fetch_assoc();
        $meli_code = $user_data['meli_code'] ?? null;
        $stmt_get_meli->close();
        $stmt_get_meli->bind_param("i", $user_id);
        $stmt_get_meli->execute();
        $result = $stmt_get_meli->get_result();
        $user_data = $result->fetch_assoc();
        $meli_code = $user_data['meli_code'] ?? null;
        $stmt_get_meli->close();

        if (!$meli_code) {
            $message = "خطا: شماره ملی کاربر یافت نشد. لطفاً ابتدا در پروفایل خود شماره ملی را ثبت کنید.";
            $message_type = "danger";
        } else {
            // 2. تعیین مسیر پوشه بر اساس شماره ملی
            $base_upload_dir = __DIR__ . "/madarek";
            $user_upload_dir = $base_upload_dir . "/" . $meli_code;

            // ایجاد پوشه اگر وجود ندارد
            if (!is_dir($user_upload_dir)) {
                if (!mkdir($user_upload_dir, 0755, true)) {
                    $message = "خطا: نمی‌توان پوشه کاربر را ایجاد کرد.";
                    $message_type = "danger";
                }
            }

            if ($message_type !== "danger") { // فقط در صورت عدم وجود خطا ادامه دهد
                // تابع آپلود عکس با اعتبارسنجی
                function upload_file($file_input_name, $target_dir, $file_prefix, $meli_code)
                {
                    if (!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] !== UPLOAD_ERR_OK) {
                        return false;
                    }
                    $uploaded_tmp = $_FILES[$file_input_name]['tmp_name'];
                    $mime = mime_content_type($uploaded_tmp);
                    $allowed_mimes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
                    if (!isset($allowed_mimes[$mime])) {
                        return "unsupported_type";
                    }
                    $extension = $allowed_mimes[$mime];
                    $new_file_name = $file_prefix . "_" . uniqid() . "." . $extension;
                    $final_target_file = rtrim($target_dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $new_file_name;

                    if (move_uploaded_file($uploaded_tmp, $final_target_file)) {
                        $relative_path = "madarek/" . $meli_code . "/" . $new_file_name;
                        return $relative_path;
                    }
                    return "upload_failed";
                }

                // 3. فراخوانی تابع با ارسال $meli_code
                $personely_path = upload_file('personely', $user_upload_dir, 'personely', $meli_code);
                $shenasname_path = upload_file('shenasname', $user_upload_dir, 'shenasname', $meli_code);
                $meli_card_path = upload_file('meli_card', $user_upload_dir, 'meli_card', $meli_code);

                // به‌روزرسانی پایگاه داده
                $sql = "UPDATE users SET personely = ?, shenasname = ?, photo_meli = ? WHERE username = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("ssss", $personely_path, $shenasname_path, $meli_card_path, $username);
                    if ($stmt->execute()) {
                        $message = "اطلاعات با موفقیت به‌روزرسانی شد.";
                        $message_type = "success";
                    } else {
                        $message = "خطا در به‌روزرسانی اطلاعات: " . $stmt->error;
                        $message_type = "danger";
                    }
                    $stmt->close();
                } else {
                    $message = "خطا در آماده‌سازی کوئری: " . $conn->error;
                    $message_type = "danger";
                }
            }
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تکمیل مدارک</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

        <div class="container-fluid py-4">
            <h1 class="h3 mb-4 text-gray-800">تکمیل مدارک</h1>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">فرم تکمیل اطلاعات و آپلود مدارک</h6>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <hr class="my-4">
                                <h5 class="mb-3">آپلود مدارک</h5>
                                <div class="mb-3">
                                    <label for="personely" class="form-label">عکس پرسنلی</label>
                                    <input class="form-control" type="file" id="personely" name="personely" required>
                                </div>
                                <div class="mb-3">
                                    <label for="shenasname" class="form-label">عکس صفحه اول شناسنامه</label>
                                    <input class="form-control" type="file" id="shenasname" name="shenasname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="meli_card" class="form-label">عکس پشت و روی کارت ملی</label>
                                    <input class="form-control" type="file" id="meli_card" name="meli_card" required>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-block">ثبت اطلاعات</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
        });

        const navLinks = document.querySelectorAll('.sidebar .nav-item .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const currentActive = document.querySelector('.sidebar .nav-item.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }
                this.parentElement.classList.add('active');
            });
        });

        // جاوا اسکریپت برای محو شدن پیام
        setTimeout(function() {
            const alert = document.getElementById('alertMessage');
            if (alert) {
                alert.style.transition = "opacity 1s ease-out";
                alert.style.opacity = "0";
                setTimeout(function() {
                    alert.style.display = "none";
                }, 1000); // 1 ثانیه برای انتقال
            }
        }, 5000); // 5 ثانیه انتظار قبل از شروع محو شدن
    </script>
</body>

</html>