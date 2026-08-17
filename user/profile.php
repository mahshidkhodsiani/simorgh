<?php
session_start();

// اگر کاربر وارد نشده است، به صفحه لاگین هدایت شود
if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION['all_data']['id'];

// بررسی پیام موفقیت از صفحه update_profile.php
$success_message = '';
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // حذف پیام از سشن بعد از نمایش
}

include '../config.php';

// دریافت اطلاعات کاربر با prepared statement
$stmt = $conn->prepare("SELECT name, family, username, meli_code, mobile FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_user = $stmt->get_result();

$name = '';
$family = '';
$username = '';
$meli_code = ''; 
$mobile = '';

if ($result_user->num_rows > 0) {
    $row = $result_user->fetch_assoc();
    $name = $row['name'];
    $family = $row['family'];
    $username = $row['username'];
    $meli_code = $row['meli_code'];
    $mobile = $row['mobile'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش پروفایل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
    <style>
    /* استایل‌های اضافی برای بهبود فاصله‌گذاری */
    .content-wrapper {
        padding: 0;
        margin: 0;
    }

    .main-container {
        padding: 20px 30px;
    }

    .page-header {
        padding: 10px 0 20px 0;
        margin-bottom: 20px;
    }

    .card-custom {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header-custom {
        padding: 15px 25px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card-header-custom h6 {
        color: #fff !important;
        font-weight: 600;
    }

    .card-body-custom {
        padding: 30px 25px !important;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }

    .form-group-custom label {
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    .form-group-custom label i {
        color: #667eea;
    }

    .form-control-custom {
        border-radius: 8px;
        border: 2px solid #e1e5eb;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-custom {
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .alert-custom {
        border-radius: 10px;
        padding: 15px 20px;
    }

    @media (max-width: 768px) {
        .main-container {
            padding: 15px;
        }

        .card-body-custom {
            padding: 20px 15px !important;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }
    }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper" class="content-wrapper">
        <?php include 'header.php'; ?>

        <div class="main-container">
            <div class="page-header">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="bi bi-person-gear me-2"></i>ویرایش پروفایل
                </h1>
                <p class="text-muted mt-2 mb-0">اطلاعات شخصی خود را به‌روزرسانی کنید</p>
            </div>

            <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>موفقیت!</strong> <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="card shadow-lg card-custom">
                        <div class="card-header card-header-custom">
                            <h6 class="m-0 font-weight-bold">
                                <i class="bi bi-info-circle me-2"></i>اطلاعات پروفایل
                            </h6>
                        </div>
                        <div class="card-body card-body-custom">
                            <form action="update_profile.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label for="name" class="form-label">
                                                <i class="bi bi-person me-2"></i>نام
                                            </label>
                                            <input type="text" class="form-control form-control-custom" id="name"
                                                name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label for="family" class="form-label">
                                                <i class="bi bi-people me-2"></i>نام خانوادگی
                                            </label>
                                            <input type="text" class="form-control form-control-custom" id="family"
                                                name="family" value="<?php echo htmlspecialchars($family); ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label for="mobile" class="form-label">
                                                <i class="bi bi-phone me-2"></i>شماره موبایل
                                            </label>
                                            <input type="text" class="form-control form-control-custom" id="mobile"
                                                name="mobile" value="<?php echo htmlspecialchars($mobile); ?>" required
                                                maxlength="11" pattern="09\d{9}"
                                                title="شماره موبایل باید با ۰۹ شروع و ۱۱ رقم باشد.">
                                            <small class="text-muted">مثال: 09123456789</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label for="meli_code" class="form-label">
                                                <i class="bi bi-credit-card me-2"></i>کد ملی
                                            </label>
                                            <input type="text" class="form-control form-control-custom" id="meli_code"
                                                name="meli_code" value="<?php echo htmlspecialchars($meli_code); ?>"
                                                required maxlength="10" pattern="\d{10}"
                                                title="کد ملی باید ۱۰ رقم باشد.">
                                            <small class="text-muted">۱۰ رقم بدون خط تیره</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label for="username" class="form-label">
                                        <i class="bi bi-person-circle me-2"></i>یوزرنیم
                                    </label>
                                    <input type="text" class="form-control form-control-custom" id="username"
                                        name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                                </div>

                                <div class="form-group-custom">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-key me-2"></i>رمز عبور جدید
                                    </label>
                                    <input type="password" class="form-control form-control-custom" id="password"
                                        name="password" placeholder="در صورت عدم تغییر، خالی بگذارید">
                                    <small class="text-muted">حداقل ۸ کاراکتر</small>
                                </div>

                                <hr class="my-4">

                                <button type="submit" class="btn btn-primary btn-custom w-100">
                                    <i class="bi bi-save me-2"></i>ذخیره تغییرات
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <script>
    // تاگل سایدبار
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
        });
    }

    // اعتبارسنجی فرم با SweetAlert
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        if (password.length > 0 && password.length < 8) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'خطا در رمز عبور',
                text: 'رمز عبور باید حداقل ۸ کاراکتر باشد!',
                confirmButtonColor: '#667eea',
            });
        }
    });

    // نمایش خودکار SweetAlert برای پیام موفقیت
    <?php if ($success_message): ?>
    Swal.fire({
        icon: 'success',
        title: 'موفقیت!',
        text: '<?php echo htmlspecialchars($success_message); ?>',
        timer: 3000,
        timerProgressBar: true,
        confirmButtonColor: '#667eea',
    });
    <?php endif; ?>
    </script>
</body>

</html>