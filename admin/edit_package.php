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
        header("Location: new_package.php");
        exit();
    }
} else {
    header("Location: new_package.php");
    exit();
}

// ----- پردازش فرم ویرایش اطلاعات اصلی -----
if (isset($_POST['update_package'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $teacher = $_POST['teacher'];
    $price = $_POST['price'];
    $spotplayer = $_POST['spot_id'];
    $discount_code = $_POST['discount_code'];
    $discount_price = !empty($_POST['discount_price']) ? $_POST['discount_price'] : 0;

    // اعتبار سنجی
    if (empty($name) || empty($teacher) || empty($price)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
            });
        </script>";
    } else {
        // آپدیت اطلاعات شامل فیلدهای تخفیف
        $stmt = $conn->prepare("UPDATE packages SET name = ?, description = ?, teacher = ?, price = ?, spotplayer = ?, discount_code = ?, discount_price = ? WHERE id = ?");
        $stmt->bind_param("ssssssdi", $name, $description, $teacher, $price, $spotplayer, $discount_code, $discount_price, $id_package);

        if ($stmt->execute()) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                    successToast.show();
                });
                </script>";
            
            // رفرش اطلاعات نمایش داده شده در فرم
            $package_data['name'] = $name;
            $package_data['description'] = $description;
            $package_data['teacher'] = $teacher;
            $package_data['price'] = $price;
            $package_data['spotplayer'] = $spotplayer;
            $package_data['discount_code'] = $discount_code;
            $package_data['discount_price'] = $discount_price;
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                    errorToast.show();
                });
                </script>";
        }
        $stmt->close();
    }
}

// ----- پردازش آپلود تصویر شاخص جدید -----
if (isset($_POST['upload_picture'])) {
    if (isset($_FILES['new_picture']) && $_FILES['new_picture']['error'] === UPLOAD_ERR_OK) {
        $old_picture_path = $package_data['pictures'];
        if ($old_picture_path && file_exists("../" . $old_picture_path)) {
            @unlink("../" . $old_picture_path);
        }

        $baseDir = '../uploads/packages/' . $id_package;
        if (!is_dir($baseDir)) mkdir($baseDir, 0777, true);

        $ext = pathinfo($_FILES['new_picture']['name'], PATHINFO_EXTENSION);
        $finalPath = $baseDir . '/pic_' . uniqid() . '.' . $ext;

        if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $finalPath)) {
            $relativePath = str_replace('../', '', $finalPath);
            $stmt = $conn->prepare("UPDATE packages SET pictures = ? WHERE id = ?");
            $stmt->bind_param("si", $relativePath, $id_package);
            $stmt->execute();
            header("Location: edit_package.php?id_package=" . $id_package);
            exit();
        }
    }
}

// ----- پردازش آپلود و حذف فایل ضمیمه -----
if (isset($_POST['upload_file1_input'])) {
    if (isset($_FILES['file1_input']) && $_FILES['file1_input']['error'] === UPLOAD_ERR_OK) {
        if ($package_data['file1'] && file_exists("../" . $package_data['file1'])) {
            @unlink("../" . $package_data['file1']);
        }
        $baseDir = '../uploads/packages/' . $id_package;
        if (!is_dir($baseDir)) mkdir($baseDir, 0777, true);

        $ext = pathinfo($_FILES['file1_input']['name'], PATHINFO_EXTENSION);
        $finalPath = $baseDir . '/file_' . uniqid() . '.' . $ext;

        if (move_uploaded_file($_FILES['file1_input']['tmp_name'], $finalPath)) {
            $relativePath = str_replace('../', '', $finalPath);
            $stmt = $conn->prepare("UPDATE packages SET file1 = ? WHERE id = ?");
            $stmt->bind_param("si", $relativePath, $id_package);
            $stmt->execute();
            header("Location: edit_package.php?id_package=" . $id_package);
            exit();
        }
    }
}

if (isset($_POST['delete_file1_input'])) {
    if ($package_data['file1'] && file_exists("../" . $package_data['file1'])) {
        @unlink("../" . $package_data['file1']);
    }
    $stmt = $conn->prepare("UPDATE packages SET file1 = NULL WHERE id = ?");
    $stmt->bind_param("i", $id_package);
    $stmt->execute();
    header("Location: edit_package.php?id_package=" . $id_package);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش پکیج | مدیریت</title>
    <?php include 'includes.php'; ?>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.js"></script> -->
    <style>
    body {
        background-color: #f0f2f5;
    }

    .main-content {
        padding: 20px;
    }

    .card-form {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
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
            <div class="col-md-3"><?php include 'sidebar.php'; ?></div>
            <div class="col-md-9 main-content">
                <h3 class="mb-4">ویرایش پکیج: <?= htmlspecialchars($package_data['name']) ?></h3>

                <div class="card-form">
                    <form action="" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">عنوان پکیج:</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?= htmlspecialchars($package_data['name']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">نام مدرس:</label>
                                <input type="text" name="teacher" class="form-control"
                                    value="<?= htmlspecialchars($package_data['teacher']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">شناسه اسپات پلیر:</label>
                                <input type="text" name="spot_id" class="form-control"
                                    value="<?= htmlspecialchars($package_data['spotplayer']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">قیمت اصلی (ریال):</label>
                                <input type="number" name="price" class="form-control"
                                    value="<?= htmlspecialchars($package_data['price']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">کد تخفیف:</label>
                                <input type="text" name="discount_code" class="form-control"
                                    value="<?= htmlspecialchars($package_data['discount_code'] ?? '') ?>"
                                    placeholder="مثلا OFF50">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">میزان تخفیف (ریال):</label>
                                <input type="number" name="discount_price" class="form-control"
                                    value="<?= htmlspecialchars($package_data['discount_price'] ?? 0) ?>"
                                    placeholder="اگر تخفیف ندارد 0 بگذارید">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">توضیحات پکیج:</label>
                            <textarea id="editor"
                                name="description"><?= htmlspecialchars($package_data['description']) ?></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="update_package" class="btn btn-success px-5">
                                <i class="fas fa-save me-2"></i>ذخیره تغییرات کلی
                            </button>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card-form">
                            <h5>تصویر شاخص</h5>
                            <?php if ($package_data['pictures']): ?>
                            <img src="../<?= htmlspecialchars($package_data['pictures']) ?>" class="img-thumbnail mb-3"
                                style="max-height: 150px;">
                            <?php endif; ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="file" name="new_picture" class="form-control mb-2" required>
                                <button type="submit" name="upload_picture" class="btn btn-primary btn-sm w-100">آپلود
                                    تصویر جدید</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-form">
                            <h5>فایل ضمیمه</h5>
                            <?php if ($package_data['file1']): ?>
                            <div class="alert alert-light border d-flex justify-content-between align-items-center">
                                <small><?= basename($package_data['file1']) ?></small>
                                <form action="" method="post">
                                    <button type="submit" name="delete_file1_input" class="btn btn-danger btn-sm"
                                        onclick="return confirm('حذف شود؟')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <?php else: ?>
                            <p class="text-muted small">فایلی آپلود نشده است.</p>
                            <?php endif; ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="file" name="file1_input" class="form-control mb-2" required>
                                <button type="submit" name="upload_file1_input"
                                    class="btn btn-primary btn-sm w-100">آپلود فایل جدید</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container">
        <div id="successToast" class="toast" role="alert">
            <div class="toast-header bg-success text-white"><strong class="me-auto">موفقیت</strong><button type="button"
                    class="btn-close" data-bs-dismiss="toast"></button></div>
            <div class="toast-body">تغییرات با موفقیت ذخیره شد.</div>
        </div>
        <div id="errorToast" class="toast" role="alert">
            <div class="toast-header bg-danger text-white"><strong class="me-auto">خطا</strong><button type="button"
                    class="btn-close" data-bs-dismiss="toast"></button></div>
            <div class="toast-body">لطفاً فیلدهای الزامی را پر کنید.</div>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <script>
    const editor = new Jodit('#editor');
    $('form').submit(function() {
        $('#editor').val(editor.getEditorValue());
    });
    </script>
</body>

</html>