<?php
session_start();

// بررسی وضعیت ورود کاربر
if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION["all_data"]['id'];
$session_id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // دریافت شناسه جلسه از URL

// بررسی معتبر بودن شناسه
if ($session_id === 0) {
    // بازگشت به صفحه مدیریت جلسات در صورت عدم وجود شناسه معتبر
    header("Location: new_session.php");
    exit();
}

// فرض می‌شود فایل config.php اتصال به دیتابیس ($conn) را فراهم می‌کند.
include '../config.php';


// ----------------------------------------------------------------------
// --- منطق سمت سرور برای به‌روزرسانی جلسه ---
// ----------------------------------------------------------------------
if (isset($_POST['update_session'])) {
    $update_id = (int)$_POST['session_id'];
    $package_id = $_POST['package_id'];
    $title = $_POST['title'];
    // duration_minutes اختیاری است و اگر خالی باشد باید null ذخیره شود
    $duration_minutes = $_POST['duration'] !== '' ? (int)$_POST['duration'] : null;
    // $description = $_POST['description'];

    // اعتبار سنجی سمت سرور برای فیلدهای الزامی
    if (empty($package_id) || empty($title) || $update_id !== $session_id) {
        $error_message = 'خطا: تمام فیلدهای الزامی (پکیج و عنوان) را پر کنید یا شناسه جلسه نامعتبر است.';
    } else {
        $package_id = (int)$package_id;
        $title = $conn->real_escape_string($title);
        // $description = $conn->real_escape_string($description);

        $description = $_POST['description'];


        // به‌روزرسانی اطلاعات در دیتابیس با استفاده از Prepared Statement
        $stmt = $conn->prepare("UPDATE sessions SET package_id = ?, title = ?, description = ?, duration_minutes = ? WHERE id = ?");
        // نوع پارامترها: i: integer, s: string
        $stmt->bind_param("issii", $package_id, $title, $description, $duration_minutes, $update_id);

        if ($stmt->execute()) {
            $success_message = 'اطلاعات جلسه با موفقیت به‌روزرسانی شد.';
            // نیازی به رفرش نیست، زیرا داده‌ها در ادامه مجددا لود می‌شوند
        } else {
            $error_message = 'خطا در به‌روزرسانی جلسه: ' . $conn->error;
        }
        $stmt->close();
    }
}


// ----------------------------------------------------------------------
// --- کوئری برای دریافت اطلاعات فعلی جلسه ---
// ----------------------------------------------------------------------
$session_data = null;
$stmt = $conn->prepare("SELECT * FROM sessions WHERE id = ?");
$stmt->bind_param("i", $session_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $session_data = $result->fetch_assoc();
} else {
    // اگر جلسه‌ای با این شناسه پیدا نشد
    header("Location: new_session.php");
    exit();
}
$stmt->close();

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش جلسه: <?= htmlspecialchars($session_data['title']) ?></title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php
    include 'includes.php';
    ?>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.js"></script> -->

    <style>
    /* استایل‌های پایه برای هماهنگی با new_package.php */
    body {
        background-color: #f0f2f5;
    }

    .main-content {
        padding: 20px;
    }

    .card-form {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 20px;
        margin-bottom: 30px;
        border: none;
    }

    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
    }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-md-9 main-content">
                <h3 class="text-center mb-4">ویرایش جلسه: **<?= htmlspecialchars($session_data['title']) ?>**</h3>

                <?php if (isset($success_message)): ?>
                <div class="alert alert-success text-center" role="alert">
                    <?= $success_message ?>
                </div>
                <?php endif; ?>

                <?php if (isset($error_message)): ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= $error_message ?>
                </div>
                <?php endif; ?>

                <div class="card-form">
                    <form action="" method="post" novalidate>
                        <input type="hidden" name="session_id" value="<?= $session_data['id'] ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="package_id" class="form-label">انتخاب پکیج: <span
                                        class="text-danger">*</span></label>
                                <select id="package_id" name="package_id" class="form-select" required>
                                    <option value="">یکی از پکیج‌ها را انتخاب کنید</option>
                                    <?php
                                    // کوئری برای گرفتن لیست پکیج‌ها جهت انتخاب
                                    $package_query = "SELECT id, name FROM packages ORDER BY name ASC";
                                    $package_result = $conn->query($package_query);
                                    if ($package_result && $package_result->num_rows > 0) {
                                        while ($pkg = $package_result->fetch_assoc()) {
                                            $selected = ($pkg['id'] == $session_data['package_id']) ? 'selected' : '';
                                            echo "<option value='" . $pkg['id'] . "' " . $selected . ">" . htmlspecialchars($pkg['name']) . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>هیچ پکیجی ثبت نشده است</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">عنوان جلسه: <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="عنوان جلسه را وارد کنید"
                                    value="<?= htmlspecialchars($session_data['title']) ?>" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="duration" class="form-label">مدت زمان جلسه (اختیاری - بر حسب دقیقه):</label>
                                <input type="number" id="duration" name="duration" class="form-control"
                                    placeholder="مدت زمان را به دقیقه وارد کنید" min="1"
                                    value="<?= $session_data['duration_minutes'] ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editor" class="form-label">توضیحات جلسه (اختیاری):</label>
                            <textarea id="editor" name="description"
                                class="form-control"><?= htmlspecialchars($session_data['description']) ?></textarea>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button name="update_session" class="btn btn-outline-primary me-3">
                                <i class="fas fa-save me-2"></i>ذخیره تغییرات
                            </button>
                            <a href="new_session.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>بازگشت به لیست جلسات
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script>
    // فعال‌سازی ادیتور Jodit
    const editor = new Jodit('#editor', {
        direction: 'rtl',
        language: 'fa',
        toolbarAdaptive: false
    });

    // اطمینان از ارسال محتوای ادیتور در هنگام ثبت فرم
    $('form').submit(function() {
        // تنظیم مقدار textarea با محتوای Jodit قبل از ارسال فرم
        $('#editor').val(editor.getEditorValue());
    });
    </script>
</body>

</html>