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
// ✅ تغییر در اینجا: اضافه کردن meli_code به کوئری
$stmt = $conn->prepare("SELECT name, family, username, meli_code FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_user = $stmt->get_result();

$name = '';
$family = '';
$username = '';
$meli_code = ''; // ✅ تعریف متغیر جدید

if ($result_user->num_rows > 0) {
    $row = $result_user->fetch_assoc();
    $name = $row['name'];
    $family = $row['family'];
    $username = $row['username'];
    $meli_code = $row['meli_code']; // ✅ دریافت مقدار meli_code
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
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include 'header.php'; ?>

        <div class="container-fluid">
            <div class="main">
                <div class="container py-4">
                    <h1 class="h3 mb-4 text-gray-800">ویرایش پروفایل</h1>
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <?php if ($success_message): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>موفقیت!</strong> <?php echo htmlspecialchars($success_message); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">اطلاعات پروفایل</h6>
                                </div>
                                <div class="card-body">
                                    <form action="update_profile.php" method="POST">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"><i class="bi bi-person me-2"></i>نام</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="family" class="form-label"><i class="bi bi-people me-2"></i>نام خانوادگی</label>
                                            <input type="text" class="form-control" id="family" name="family" value="<?php echo htmlspecialchars($family); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="meli_code" class="form-label"><i class="bi bi-credit-card me-2"></i>کد ملی</label>
                                            <input type="text" class="form-control" id="meli_code" name="meli_code" value="<?php echo htmlspecialchars($meli_code); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label"><i class="bi bi-person-circle me-2"></i>یوزرنیم</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label"><i class="bi bi-key me-2"></i>رمز عبور</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="اگر قصد تغییر ندارید، خالی بگذارید">
                                        </div>
                                        <button type="submit" class="btn btn-primary d-block w-100">
                                            <i class="bi bi-save me-2"></i>ذخیره تغییرات
                                        </button>
                                    </form>
                                </div>
                            </div>
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
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-toggled');
            });
        }
    </script>
</body>

</html>