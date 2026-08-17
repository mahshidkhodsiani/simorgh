<?php
session_start();

// اگر کاربر وارد نشده است، به صفحه لاگین هدایت شود
if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION['all_data']['id'];
$username = $_SESSION['all_data']['username'];
$message = null;
$message_type = null;

// اطمینان حاصل کنید که مسیر فایل config.php صحیح است
include '../config.php';

// **کد جدید: بازیابی مسیرهای عکس‌ها از پایگاه داده**
$personely_path = null;
$shenasname_path = null;
$meli_card_path = null;

$sql_get_paths = "SELECT personely, shenasname, photo_meli FROM users WHERE id = ?";
$stmt_paths = $conn->prepare($sql_get_paths);
if ($stmt_paths) {
    $stmt_paths->bind_param("i", $user_id);
    $stmt_paths->execute();
    $result_paths = $stmt_paths->get_result();
    $user_paths = $result_paths->fetch_assoc();
    if ($user_paths) {
        $personely_path = $user_paths['personely'];
        $shenasname_path = $user_paths['shenasname'];
        $meli_card_path = $user_paths['photo_meli'];
    }
    $stmt_paths->close();
}

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

            if ($message_type !== "danger") {
                // تابع آپلود عکس با اعتبارسنجی
                function upload_file($file_input_name, $target_dir, $file_prefix, $meli_code)
                {
                    if (!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] !== UPLOAD_ERR_OK) {
                        return false;
                    }

                    $uploaded_tmp = $_FILES[$file_input_name]['tmp_name'];
                    $mime = mime_content_type($uploaded_tmp);
                    
                    $allowed_mimes = [
                        'image/jpeg' => 'jpg',
                        'image/png' => 'png',
                        'image/gif' => 'gif',
                        'image/webp' => 'webp',
                        'image/svg+xml' => 'svg',
                        'image/bmp' => 'bmp',
                        'image/tiff' => 'tiff'
                    ];

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

                // آپلود فقط در صورت انتخاب فایل
                $new_personely_path = isset($_FILES['personely']) && $_FILES['personely']['error'] === UPLOAD_ERR_OK ? upload_file('personely', $user_upload_dir, 'personely', $meli_code) : $personely_path;
                $new_shenasname_path = isset($_FILES['shenasname']) && $_FILES['shenasname']['error'] === UPLOAD_ERR_OK ? upload_file('shenasname', $user_upload_dir, 'shenasname', $meli_code) : $shenasname_path;
                $new_meli_card_path = isset($_FILES['meli_card']) && $_FILES['meli_card']['error'] === UPLOAD_ERR_OK ? upload_file('meli_card', $user_upload_dir, 'meli_card', $meli_code) : $meli_card_path;

                // به‌روزرسانی پایگاه داده
                $sql = "UPDATE users SET personely = ?, shenasname = ?, photo_meli = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("sssi", $new_personely_path, $new_shenasname_path, $new_meli_card_path, $user_id);
                    if ($stmt->execute()) {
                        $message = "مدارک با موفقیت آپلود شدند.";
                        $message_type = "success";
                        $personely_path = $new_personely_path;
                        $shenasname_path = $new_shenasname_path;
                        $meli_card_path = $new_meli_card_path;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
    /* استایل‌های اختصاصی صفحه مدارک */
    .upload-section {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 20px;
        border: 2px dashed #d1d3e2;
        transition: all 0.3s ease;
    }

    .upload-section:hover {
        border-color: #4e73df;
        background: #f0f2f7;
    }

    .upload-section .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .upload-section .form-label i {
        color: #4e73df;
        margin-left: 8px;
    }

    .file-preview {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 10px 15px;
        background: white;
        border-radius: 8px;
        border: 1px solid #e3e6f0;
        margin-top: 10px;
    }

    .file-preview img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e3e6f0;
    }

    .file-preview .file-info {
        flex: 1;
    }

    .file-preview .file-info .file-name {
        font-weight: 500;
        color: #2d3748;
    }

    .file-preview .file-info .file-status {
        font-size: 13px;
        color: #38a169;
    }

    .btn-change-file {
        background: #edf2f7;
        border: none;
        color: #4a5568;
        padding: 5px 15px;
        border-radius: 6px;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .btn-change-file:hover {
        background: #e2e8f0;
        color: #2d3748;
    }

    .btn-change-file i {
        margin-left: 5px;
    }

    .custom-file-input {
        display: none;
    }

    .custom-file-label {
        display: inline-block;
        padding: 10px 20px;
        background: white;
        border: 2px dashed #4e73df;
        border-radius: 8px;
        color: #4e73df;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        width: 100%;
        text-align: center;
    }

    .custom-file-label:hover {
        background: #4e73df;
        color: white;
    }

    .custom-file-label i {
        margin-left: 8px;
    }

    .card-documents {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .card-documents .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 18px 25px;
        border: none;
    }

    .card-documents .card-header h6 {
        color: white;
        font-weight: 600;
    }

    .card-documents .card-header h6 i {
        margin-left: 10px;
    }

    .card-documents .card-body {
        padding: 30px;
    }

    .btn-submit-documents {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-submit-documents:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-submit-documents i {
        margin-left: 8px;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        position: relative;
        padding: 0 15px;
    }

    .progress-steps::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 30px;
        right: 30px;
        height: 2px;
        background: #e3e6f0;
        z-index: 0;
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 1;
        background: white;
        padding: 0 10px;
    }

    .progress-step .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #e3e6f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        color: #858796;
        transition: all 0.3s ease;
    }

    .progress-step.active .step-circle {
        background: #4e73df;
        color: white;
    }

    .progress-step.completed .step-circle {
        background: #38a169;
        color: white;
    }

    .progress-step .step-label {
        margin-top: 8px;
        font-size: 12px;
        color: #858796;
        font-weight: 500;
    }

    .progress-step.active .step-label {
        color: #4e73df;
    }

    .progress-step.completed .step-label {
        color: #38a169;
    }

    @media (max-width: 768px) {
        .card-documents .card-body {
            padding: 20px;
        }

        .file-preview {
            flex-wrap: wrap;
        }

        .file-preview img {
            width: 50px;
            height: 50px;
        }

        .progress-steps {
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .progress-steps::before {
            display: none;
        }
    }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include 'header.php'; ?>

        <!-- پیام‌های سیستم -->
        <?php if ($message): ?>
        <div class="container-fluid py-2">
            <div id="alertMessage"
                class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show text-center" role="alert"
                style="border-radius: 12px;">
                <i
                    class="bi <?php echo $message_type == 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> me-2"></i>
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php endif; ?>

        <div class="container-fluid py-3">
            <!-- هدر صفحه -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="bi bi-file-earmark-text me-2 text-primary"></i>تکمیل مدارک
                    </h1>
                    <p class="text-muted mb-0">لطفاً مدارک مورد نیاز را آپلود کنید</p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-primary bg-gradient p-2 px-3 rounded-pill">
                        <i class="bi bi-check-circle me-1"></i>
                        <?php 
                            $completed = 0;
                            if ($personely_path) $completed++;
                            if ($shenasname_path) $completed++;
                            if ($meli_card_path) $completed++;
                            echo $completed . " از 3 آپلود شده";
                        ?>
                    </span>
                </div>
            </div>

            <!-- مراحل پیشرفت -->
            <div class="progress-steps">
                <div class="progress-step <?php echo $personely_path ? 'completed' : 'active'; ?>">
                    <div class="step-circle"><?php echo $personely_path ? '✓' : '1'; ?></div>
                    <span class="step-label">عکس پرسنلی</span>
                </div>
                <div
                    class="progress-step <?php echo $shenasname_path ? 'completed' : ($personely_path ? 'active' : ''); ?>">
                    <div class="step-circle"><?php echo $shenasname_path ? '✓' : '2'; ?></div>
                    <span class="step-label">شناسنامه</span>
                </div>
                <div
                    class="progress-step <?php echo $meli_card_path ? 'completed' : ($shenasname_path ? 'active' : ''); ?>">
                    <div class="step-circle"><?php echo $meli_card_path ? '✓' : '3'; ?></div>
                    <span class="step-label">کارت ملی</span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card card-documents shadow">
                        <div class="card-header">
                            <h6 class="m-0">
                                <i class="bi bi-upload"></i>
                                آپلود مدارک
                            </h6>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data" id="documentsForm">

                                <!-- عکس پرسنلی -->
                                <div class="upload-section mb-4">
                                    <label class="form-label">
                                        <i class="bi bi-person-badge"></i>
                                        عکس پرسنلی
                                        <small class="text-muted">(فرمت‌های مجاز: jpg, png, webp)</small>
                                    </label>

                                    <?php if ($personely_path): ?>
                                    <div class="file-preview">
                                        <img src="<?php echo htmlspecialchars($personely_path); ?>" alt="عکس پرسنلی">
                                        <div class="file-info">
                                            <div class="file-name">عکس پرسنلی</div>
                                            <div class="file-status">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                آپلود شده
                                            </div>
                                        </div>
                                        <button type="button" class="btn-change-file"
                                            onclick="toggleFileInput('personely')">
                                            <i class="bi bi-pencil"></i>
                                            تغییر
                                        </button>
                                    </div>
                                    <input class="custom-file-input" type="file" id="personely" name="personely"
                                        accept="image/*">
                                    <?php else: ?>
                                    <label for="personely" class="custom-file-label">
                                        <i class="bi bi-cloud-upload"></i>
                                        انتخاب عکس پرسنلی
                                    </label>
                                    <input class="custom-file-input" type="file" id="personely" name="personely"
                                        accept="image/*" required>
                                    <?php endif; ?>
                                </div>

                                <!-- عکس شناسنامه -->
                                <div class="upload-section mb-4">
                                    <label class="form-label">
                                        <i class="bi bi-card-heading"></i>
                                        عکس صفحه اول شناسنامه
                                        <small class="text-muted">(فرمت‌های مجاز: jpg, png, webp)</small>
                                    </label>

                                    <?php if ($shenasname_path): ?>
                                    <div class="file-preview">
                                        <img src="<?php echo htmlspecialchars($shenasname_path); ?>" alt="عکس شناسنامه">
                                        <div class="file-info">
                                            <div class="file-name">عکس شناسنامه</div>
                                            <div class="file-status">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                آپلود شده
                                            </div>
                                        </div>
                                        <button type="button" class="btn-change-file"
                                            onclick="toggleFileInput('shenasname')">
                                            <i class="bi bi-pencil"></i>
                                            تغییر
                                        </button>
                                    </div>
                                    <input class="custom-file-input" type="file" id="shenasname" name="shenasname"
                                        accept="image/*">
                                    <?php else: ?>
                                    <label for="shenasname" class="custom-file-label">
                                        <i class="bi bi-cloud-upload"></i>
                                        انتخاب عکس شناسنامه
                                    </label>
                                    <input class="custom-file-input" type="file" id="shenasname" name="shenasname"
                                        accept="image/*" required>
                                    <?php endif; ?>
                                </div>

                                <!-- عکس کارت ملی -->
                                <div class="upload-section mb-4">
                                    <label class="form-label">
                                        <i class="bi bi-credit-card"></i>
                                        عکس پشت و روی کارت ملی
                                        <small class="text-muted">(فرمت‌های مجاز: jpg, png, webp)</small>
                                    </label>

                                    <?php if ($meli_card_path): ?>
                                    <div class="file-preview">
                                        <img src="<?php echo htmlspecialchars($meli_card_path); ?>" alt="عکس کارت ملی">
                                        <div class="file-info">
                                            <div class="file-name">عکس کارت ملی</div>
                                            <div class="file-status">
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                آپلود شده
                                            </div>
                                        </div>
                                        <button type="button" class="btn-change-file"
                                            onclick="toggleFileInput('meli_card')">
                                            <i class="bi bi-pencil"></i>
                                            تغییر
                                        </button>
                                    </div>
                                    <input class="custom-file-input" type="file" id="meli_card" name="meli_card"
                                        accept="image/*">
                                    <?php else: ?>
                                    <label for="meli_card" class="custom-file-label">
                                        <i class="bi bi-cloud-upload"></i>
                                        انتخاب عکس کارت ملی
                                    </label>
                                    <input class="custom-file-input" type="file" id="meli_card" name="meli_card"
                                        accept="image/*" required>
                                    <?php endif; ?>
                                </div>

                                <hr>

                                <div class="d-flex gap-3">
                                    <button type="submit" class="btn btn-submit-documents">
                                        <i class="bi bi-save"></i>
                                        ذخیره و آپلود مدارک
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary px-4"
                                        style="border-radius: 10px;">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                        بازنشانی
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <script>
    // تاگل سایدبار
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-toggled');
    });

    // تابع نمایش/پنهان کردن فیلد آپلود
    function toggleFileInput(id) {
        const fileInput = document.getElementById(id);
        const isHidden = fileInput.style.display === "none" || fileInput.style.display === "";

        if (isHidden) {
            fileInput.style.display = "block";
            fileInput.required = true;
            // اسکرول به سمت فیلد
            fileInput.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        } else {
            fileInput.style.display = "none";
            fileInput.required = false;
        }
    }

    // نمایش نام فایل انتخاب شده
    document.querySelectorAll('.custom-file-input').forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'فایلی انتخاب نشده';
            const label = this.previousElementSibling;
            if (label && label.classList.contains('custom-file-label')) {
                label.innerHTML = `<i class="bi bi-file-earmark"></i> ${fileName}`;
            }
        });
    });

    // اعتبارسنجی فرم با SweetAlert
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredInputs = this.querySelectorAll('input[required]');
        let allFilled = true;

        requiredInputs.forEach(input => {
            if (!input.files || input.files.length === 0) {
                allFilled = false;
            }
        });

        if (!allFilled) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'تکمیل مدارک',
                text: 'لطفاً تمام مدارک مورد نیاز را آپلود کنید!',
                confirmButtonColor: '#667eea',
                confirmButtonText: 'متوجه شدم'
            });
        }
    });

    // نمایش SweetAlert برای پیام موفقیت
    <?php if ($message && $message_type == 'success'): ?>
    Swal.fire({
        icon: 'success',
        title: 'آپلود موفق!',
        text: '<?php echo $message; ?>',
        timer: 3000,
        timerProgressBar: true,
        confirmButtonColor: '#667eea',
        confirmButtonText: 'باشه'
    });
    <?php endif; ?>

    // محو شدن پیام هشدار
    setTimeout(function() {
        const alert = document.getElementById('alertMessage');
        if (alert) {
            alert.style.transition = "opacity 0.8s ease";
            alert.style.opacity = "0";
            setTimeout(() => {
                alert.style.display = "none";
            }, 800);
        }
    }, 5000);
    </script>
</body>

</html>