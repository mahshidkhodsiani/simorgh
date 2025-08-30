<?php

include '../config.php';

// بررسی ارسال فرم
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // دریافت اطلاعات از فرم
    $meli_code = $_POST['meli_code'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];

    // ایجاد پوشه برای کاربر بر اساس کد ملی
    $target_dir = "../contacts/" . $meli_code . "/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // تابع آپلود عکس
    function upload_file($file_input_name, $target_dir, $file_prefix)
    {
        if (!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $file_name = basename($_FILES[$file_input_name]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // تغییر نام فایل برای جلوگیری از تکرار و استانداردسازی
        $new_file_name = $file_prefix . "." . $file_type;
        $final_target_file = $target_dir . $new_file_name;

        // انتقال فایل به پوشه مقصد
        if (move_uploaded_file($_FILES[$file_input_name]["tmp_name"], $final_target_file)) {
            return "contacts/" . $meli_code . "/" . $new_file_name;
        } else {
            return false;
        }
    }

    // آپلود عکس‌ها
    $photo_path = upload_file('photo', $target_dir, 'photo');
    $birth_cert_path = upload_file('birth_cert', $target_dir, 'birth_cert');
    $id_card_path = upload_file('id_card', $target_dir, 'id_card');

    // به‌روزرسانی پایگاه داده
    $sql = "UPDATE contacts SET 
                name=?, lastname=?, photo_path=?, birth_cert_path=?, id_card_path=?
            WHERE meli_code=?";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param(
            "ssssss",
            $name,
            $lastname,
            $photo_path,
            $birth_cert_path,
            $id_card_path,
            $meli_code
        );

        if ($stmt->execute()) {
            echo "<div class='alert alert-success' role='alert'>اطلاعات با موفقیت به‌روزرسانی شد.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>خطا در به‌روزرسانی اطلاعات: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>خطا در آماده‌سازی کوئری: " . $conn->error . "</div>";
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

        /* استایل سایدبار کاملا سفید */
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            height: 100%;
            width: var(--sidebar-width);
            background-color: #ffffff;
            /* پس زمینه سفید */
            color: #333;
            /* رنگ متن تیره برای خوانایی بهتر */
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
            /* رنگ تیره برای متن برند */
        }

        .sidebar .nav-item {
            position: relative;
            margin: 0 10px;
        }

        .sidebar .nav-item .nav-link {
            color: #555;
            /* رنگ متن لینک‌ها */
            font-weight: 500;
            padding: 10px;
            margin: 5px 0;
            border-radius: 10px;
        }

        /* حالت شناور (Hover) با رنگ قرمز کمرنگ */
        .sidebar .nav-item .nav-link:hover {
            color: #333;
            background: rgba(255, 69, 0, 0.05);
        }

        /* حالت فعال (Active) با رنگ قرمز بسیار کمرنگ */
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

        /* استایل‌های جدید برای حالت موبایل */
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
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">نام</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastname" class="form-label">نام خانوادگی</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="meli_code" class="form-label">کد ملی</label>
                                    <input type="text" class="form-control" id="meli_code" name="meli_code" required>
                                </div>
                                <hr class="my-4">
                                <h5 class="mb-3">آپلود مدارک</h5>
                                <div class="mb-3">
                                    <label for="photo" class="form-label">عکس پرسنلی</label>
                                    <input class="form-control" type="file" id="photo" name="photo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="birth_cert" class="form-label">عکس صفحه اول شناسنامه</label>
                                    <input class="form-control" type="file" id="birth_cert" name="birth_cert" required>
                                </div>
                                <div class="mb-3">
                                    <label for="id_card" class="form-label">عکس پشت و روی کارت ملی</label>
                                    <input class="form-control" type="file" id="id_card" name="id_card" required>
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
    </script>
</body>

</html>