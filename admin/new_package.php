<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
include '../config.php'; // اتصال به دیتابیس در ابتدا برای استفاده در تمام بخش‌ها
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت پکیج ها</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php include 'includes.php'; ?>
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

    .table-header {
        background-color: #4a5d73;
        color: white;
        padding: 10px;
        border-radius: 8px 8px 0 0;
        font-size: 1.1rem;
        font-weight: 600;
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
                <h3 class="text-center mb-4">مدیریت پکیج ها</h3>

                <div class="card-form">
                    <form action="" method="post" enctype='multipart/form-data' novalidate>
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i><strong>نکته:</strong> در صورت داشتن تخفیف، قیمت با
                            تخفیف را وارد کنید. در غیر این صورت آن را خالی بگذارید.
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">عنوان پکیج:</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="عنوان را اینجا وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pictures" class="form-label">تصویر شاخص:</label>
                                <input type="file" name="pictures" class="form-control" id="inputGroupFile02" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="teacher" class="form-label">نام مدرس:</label>
                                <input type="text" id="teacher" name="teacher" class="form-control"
                                    placeholder="نام مدرس را وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="spot_id" class="form-label">شناسه اسپات پلیر:</label>
                                <input type="text" id="spot_id" name="spot_id" class="form-control"
                                    placeholder="شناسه دوره" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">قیمت اصلی (ریال):</label>
                                <input type="number" id="price" name="price" class="form-control"
                                    placeholder="مثلا 5000000" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="discount_code" class="form-label">کد تخفیف:</label>
                                <input type="text" id="discount_code" name="discount_code" class="form-control"
                                    placeholder="مثلا OFF50">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="discount_price" class="form-label">قیمت تخفیف (ریال):</label>
                                <input type="number" id="discount_price" name="discount_price" class="form-control"
                                    placeholder="اگر تخفیف ندارد خالی بگذارید">
                            </div>

                            <div class="col-12 mb-3">
                                <label for="file1" class="form-label">فایل ضمیمه:</label>
                                <input type="file" id="file1" name="file1" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editor" class="form-label">توضیحات پکیج:</label>
                            <textarea id="editor" name="description" class="form-control"></textarea>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button name="submit_package" class="btn btn-outline-success">
                                <i class="fas fa-plus-circle me-2"></i>ثبت پکیج جدید
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-section">
                    <div class="table-header">
                        <i class="fas fa-list-alt me-2"></i>لیست آخرین پکیج‌ها
                    </div>
                    <div class="table-responsive mt-3">
                        <?php
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        $sql = "SELECT * FROM packages ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">عنوان</th>
                                    <th scope="col" class="text-center">قیمت اصلی</th>
                                    <th scope="col" class="text-center">با تخفیف</th>
                                    <th scope="col" class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <th scope="row" class="text-center"><?= $a ?></th>
                                    <td class="text-center"><?= htmlspecialchars($row['name']) ?></td>
                                    <td class="text-center"><?= number_format($row['price']) ?> ریال</td>
                                    <td class="text-center">
                                        <?php if($row['discount_price'] > 0): ?>
                                        <span class="badge bg-success"><?= number_format($row['discount_price']) ?>
                                            ریال</span>
                                        <br><small
                                            class="text-muted"><?= htmlspecialchars($row['discount_code']) ?></small>
                                        <?php else: ?>
                                        ---
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" value="<?= $row['id'] ?>" name="id_package">
                                            <button type="submit" name="delete_package"
                                                class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">
                                                <i class="fas fa-trash-alt me-1"></i>حذف
                                            </button>
                                            <a href="edit_package.php?id_package=<?= $row['id'] ?>"
                                                class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-edit me-1"></i>ویرایش
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                                <?php $a++; } ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container">
        <div id="successToast" class="toast" role="alert" data-bs-delay="3000">
            <div class="toast-header bg-success text-white"><strong class="me-auto">موفقیت</strong><button type="button"
                    class="btn-close btn-close-white" data-bs-dismiss="toast"></button></div>
            <div class="toast-body">عملیات با موفقیت انجام شد!</div>
        </div>
        <div id="errorToast" class="toast" role="alert" data-bs-delay="3000">
            <div class="toast-header bg-danger text-white"><strong class="me-auto">خطا</strong><button type="button"
                    class="btn-close btn-close-white" data-bs-dismiss="toast"></button></div>
            <div class="toast-body">خطایی در انجام عملیات رخ داد!</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const editor = new Jodit('#editor');
    $('form').submit(function() {
        $('#editor').val(editor.getEditorValue());
    });

    function confirmDelete() {
        return confirm("آیا مطمئن هستید؟");
    }
    </script>
</body>

</html>

<?php
// منطق PHP برای ثبت پکیج
if (isset($_POST['submit_package'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $teacher = $conn->real_escape_string($_POST['teacher']);
    $price = $conn->real_escape_string($_POST['price']);
    $spotplayer = $conn->real_escape_string($_POST['spot_id']);
    
    // مقادیر جدید
    $discount_code = $conn->real_escape_string($_POST['discount_code']);
    $discount_price = !empty($_POST['discount_price']) ? $_POST['discount_price'] : 0;

    if (empty($name) || empty($teacher) || empty($price)) {
        echo "<script>document.addEventListener('DOMContentLoaded', function() { var errorToast = new bootstrap.Toast(document.getElementById('errorToast')); errorToast.show(); });</script>";
        exit();
    }

    // اضافه کردن ستون‌های جدید به INSERT
    $stmt = $conn->prepare("INSERT INTO packages (name, description, teacher, spotplayer, price, discount_code, discount_price, file2, file3) VALUES (?, ?, ?, ?, ?, ?, ?, NULL, NULL)");
    $stmt->bind_param("ssssssd", $name, $description, $teacher, $spotplayer, $price, $discount_code, $discount_price);

    if ($stmt->execute()) {
        $package_id = $conn->insert_id;
        $stmt->close();

        // منطق آپلود فایل (بدون تغییر نسبت به کد اصلی شما)
        $uploadDir = '../uploads/packages/' . $package_id;
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $picture_path = null; $file1_path = null;

        if (isset($_FILES['pictures']) && $_FILES['pictures']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['pictures']['name'], PATHINFO_EXTENSION);
            $path = $uploadDir . '/pic_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['pictures']['tmp_name'], $path)) $picture_path = str_replace('../', '', $path);
        }

        if (isset($_FILES['file1']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['file1']['name'], PATHINFO_EXTENSION);
            $path = $uploadDir . '/file_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['file1']['tmp_name'], $path)) $file1_path = str_replace('../', '', $path);
        }

        $update_stmt = $conn->prepare("UPDATE packages SET pictures = ?, file1 = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $picture_path, $file1_path, $package_id);
        $update_stmt->execute();

        echo "<script>document.addEventListener('DOMContentLoaded', function() { var successToast = new bootstrap.Toast(document.getElementById('successToast')); successToast.show(); setTimeout(function(){ window.location.href = 'new_package.php'; }, 2000); });</script>";
    }
}

// منطق حذف (بدون تغییر نسبت به کد شما)
if (isset($_POST['delete_package'])) {
    $id_package = $_POST['id_package'];
    // ... کدهای حذف فایل و دیتابیس دقیقاً مثل نسخه قبلی شما اینجا قرار می‌گیرد ...
    $sql = "DELETE FROM packages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_package);
    $stmt->execute();
    echo "<script>window.location.href = 'new_package.php';</script>";
}
?>