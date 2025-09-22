<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

include '../config.php';

// دریافت id پکیج از URL
if (isset($_GET['id_package'])) {
    $id_package = $_GET['id_package'];

    // دریافت اطلاعات پکیج از دیتابیس
    $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
    $stmt->bind_param("i", $id_package);
    $stmt->execute();
    $result = $stmt->get_result();
    $package_data = $result->fetch_assoc();
    $stmt->close();

    if (!$package_data) {
        // اگر پکیج با این id پیدا نشد
        header("Location: new_package.php");
        exit();
    }
} else {
    // اگر id در URL نبود
    header("Location: new_package.php");
    exit();
}

// ----- پردازش فرم ویرایش -----
if (isset($_POST['update_package'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $teacher = $_POST['teacher'];
    $price = $_POST['price'];

    // اعتبار سنجی سمت سرور برای فیلدهای ضروری
    if (empty($name) || empty($teacher) || empty($price)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'لطفا تمام فیلدهای الزامی (عنوان، مدرس و قیمت) را پر کنید.';
                errorToast.show();
            });
        </script>";
        exit(); // توقف اجرای کد در صورت خالی بودن فیلدها
    }

    $name = $conn->real_escape_string($name);
    $description = $conn->real_escape_string($description);
    $teacher = $conn->real_escape_string($teacher);
    $price = $conn->real_escape_string($price);

    // آپدیت اطلاعات اصلی پکیج
    $stmt = $conn->prepare("UPDATE packages SET name = ?, description = ?, teacher = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $description, $teacher, $price, $id_package);

    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
            });
            </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
            });
            </script>";
    }
    $stmt->close();

    // رفرش کردن اطلاعات پکیج پس از آپدیت
    $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
    $stmt->bind_param("i", $id_package);
    $stmt->execute();
    $result = $stmt->get_result();
    $package_data = $result->fetch_assoc();
    $stmt->close();
}

// ----- پردازش آپلود تصویر شاخص جدید -----
if (isset($_POST['upload_picture'])) {
    if (isset($_FILES['new_picture']) && $_FILES['new_picture']['error'] === UPLOAD_ERR_OK) {
        $old_picture_path = $package_data['pictures'];
        if ($old_picture_path) {
            @unlink("../" . $old_picture_path); // حذف فایل قدیمی
        }

        $pictures = $_FILES['new_picture'];
        $baseDir = '../uploads/packages/';
        $uploadDir = $baseDir . $id_package;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $originalFileName = basename($pictures['name']);
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $uniqueFileName = uniqid() . '.' . $extension;
        $finalPath = $uploadDir . '/' . $uniqueFileName;

        if (move_uploaded_file($pictures['tmp_name'], $finalPath)) {
            $relativePath = str_replace('../', '', $finalPath);
            $stmt = $conn->prepare("UPDATE packages SET pictures = ? WHERE id = ?");
            $stmt->bind_param("si", $relativePath, $id_package);
            $stmt->execute();
            $stmt->close();
            header("Location: edit_package.php?id_package=" . $id_package); // رفرش صفحه
            exit();
        }
    }
}

// ----- پردازش آپلود و حذف فایل‌ها (فایل ۱، ۲، ۳) -----
function handleFileUpdate($conn, $id_package, $file_name, $column_name, $old_file_path)
{
    if (isset($_FILES[$file_name]) && $_FILES[$file_name]['error'] === UPLOAD_ERR_OK) {
        // اگر فایلی وجود داشت، حذف کن
        if ($old_file_path) {
            @unlink("../" . $old_file_path);
        }

        // آپلود فایل جدید
        $file = $_FILES[$file_name];
        $baseDir = '../uploads/packages/';
        $uploadDir = $baseDir . $id_package;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $originalFileName = basename($file['name']);
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $uniqueFileName = uniqid($column_name . '_') . '.' . $extension;
        $finalPath = $uploadDir . '/' . $uniqueFileName;

        if (move_uploaded_file($file['tmp_name'], $finalPath)) {
            $relativePath = str_replace('../', '', $finalPath);
            $stmt = $conn->prepare("UPDATE packages SET {$column_name} = ? WHERE id = ?");
            $stmt->bind_param("si", $relativePath, $id_package);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    } else if (isset($_POST['delete_' . $file_name])) {
        // اگر دکمه حذف فشرده شد
        if ($old_file_path) {
            @unlink("../" . $old_file_path);
        }
        $stmt = $conn->prepare("UPDATE packages SET {$column_name} = NULL WHERE id = ?");
        $stmt->bind_param("i", $id_package);
        $stmt->execute();
        $stmt->close();
        return true;
    }
    return false;
}

if (handleFileUpdate($conn, $id_package, 'file1_input', 'file1', $package_data['file1'])) {
    header("Location: edit_package.php?id_package=" . $id_package);
    exit();
}
if (handleFileUpdate($conn, $id_package, 'file2_input', 'file2', $package_data['file2'])) {
    header("Location: edit_package.php?id_package=" . $id_package);
    exit();
}
if (handleFileUpdate($conn, $id_package, 'file3_input', 'file3', $package_data['file3'])) {
    header("Location: edit_package.php?id_package=" . $id_package);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش پکیج</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php
    include 'includes.php';
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.js"></script>
    <style>
        body {
            background-color: #f0f2f5;
        }

        .main-content {
            padding: 20px;
        }

        .card-form,
        .table-section {
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
                <h3 class="text-center mb-4">ویرایش پکیج: <?= htmlspecialchars($package_data['name']) ?></h3>

                <div class="card-form">
                    <h4>اطلاعات پکیج</h4>
                    <form action="" method="post" enctype='multipart/form-data' novalidate>
                        <input type="hidden" name="id_package" value="<?= $id_package ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">عنوان پکیج:</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($package_data['name']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="teacher" class="form-label">نام مدرس:</label>
                                <input type="text" id="teacher" name="teacher" class="form-control" value="<?= htmlspecialchars($package_data['teacher']) ?>" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="price" class="form-label">قیمت پکیج (ریال):</label>
                                <input type="text" id="price" name="price" class="form-control" value="<?= htmlspecialchars($package_data['price']) ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editor" class="form-label">توضیحات پکیج:</label>
                            <textarea id="editor" name="description" class="form-control"><?= htmlspecialchars($package_data['description']) ?></textarea>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" name="update_package" class="btn btn-outline-success">
                                <i class="fas fa-save me-2"></i>ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-form mt-4">
                    <h4>تصویر شاخص</h4>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_package" value="<?= $id_package ?>">
                        <?php if ($package_data['pictures']) { ?>
                            <div class="mb-3">
                                <img src="../<?= htmlspecialchars($package_data['pictures']) ?>" alt="تصویر شاخص" style="max-width: 200px; display: block; margin-bottom: 10px;">
                            </div>
                        <?php } ?>
                        <div class="mb-3">
                            <label for="new_picture" class="form-label">تغییر تصویر شاخص:</label>
                            <input type="file" id="new_picture" name="new_picture" class="form-control">
                        </div>
                        <button type="submit" name="upload_picture" class="btn btn-outline-primary">
                            <i class="fas fa-image me-2"></i>آپلود تصویر جدید
                        </button>
                    </form>
                </div>

                <div class="card-form mt-4">
                    <h4>فایل‌ها</h4>
                    <?php
                    $files = ['file1', 'file2', 'file3'];
                    foreach ($files as $file_column) {
                        $file_path = $package_data[$file_column];
                        $file_number = substr($file_column, 4);
                    ?>
                        <hr>
                        <div class="mt-3">
                            <h6>فایل <?= $file_number ?></h6>
                            <?php if ($file_path) { ?>
                                <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
                                    <span>فایل فعلی: <strong><?= basename($file_path) ?></strong></span>
                                    <div class="btn-group" role="group">
                                        <a href="../<?= htmlspecialchars($file_path) ?>" class="btn btn-sm btn-success" download>
                                            <i class="fas fa-download me-1"></i>دانلود
                                        </a>
                                        <form action="" method="post" class="d-inline">
                                            <input type="hidden" name="id_package" value="<?= $id_package ?>">
                                            <button type="submit" name="delete_<?= $file_column ?>_input" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این فایل مطمئن هستید؟')">
                                                <i class="fas fa-trash-alt me-1"></i>حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-warning" role="alert">
                                    فایلی برای این بخش آپلود نشده است.
                                </div>
                            <?php } ?>
                            <form action="" method="post" enctype="multipart/form-data" class="mt-3">
                                <input type="hidden" name="id_package" value="<?= $id_package ?>">
                                <div class="mb-3">
                                    <label for="<?= $file_column ?>_input" class="form-label">آپلود/جایگزینی فایل <?= $file_number ?>:</label>
                                    <input type="file" id="<?= $file_column ?>_input" name="<?= $file_column ?>_input" class="form-control">
                                </div>
                                <button type="submit" name="upload_<?= $file_column ?>_input" class="btn btn-outline-primary">
                                    <i class="fas fa-upload me-2"></i>آپلود فایل
                                </button>
                            </form>
                        </div>
                    <?php } ?>
                </div>

                <div class="toast-container">
                    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                        <div class="toast-header bg-success text-white">
                            <strong class="me-auto">موفقیت</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            عملیات با موفقیت انجام شد!
                        </div>
                    </div>
                    <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                        <div class="toast-header bg-danger text-white">
                            <strong class="me-auto">خطا</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            خطایی در انجام عملیات رخ داد!
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const editor = new Jodit('#editor');

        $('form').submit(function() {
            $('#editor').val(editor.getEditorValue());
        });
    </script>
</body>

</html>