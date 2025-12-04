<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت پکیج ها</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php
    include 'includes.php';
    include '../config.php';
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

        .table-header {
            background-color: #4a5d73;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.03);
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
                            <i class="fas fa-info-circle me-2"></i><strong>دقت کنید:</strong> هر آنچه اینجا وارد کنید در سایت اصلی اولین پکیج می آید.
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">عنوان پکیج:</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="عنوان را اینجا وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pictures" class="form-label">تصویر شاخص:</label>
                                <input type="file" name="pictures" class="form-control" id="inputGroupFile02" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="teacher" class="form-label">نام مدرس:</label>
                                <input type="text" id="teacher" name="teacher" class="form-control" placeholder="نام مدرس را وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="spot_id" class="form-label">شناسه اسپات پلیر:</label>
                                <input type="text" id="spot_id" name="spot_id" class="form-control" placeholder="شناسه اسپات پلیر این دوره را وارد نید" required>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="price" class="form-label">قیمت پکیج (ریال):</label>
                                <input type="text" id="price" name="price" class="form-control" placeholder="قیمت را وارد کنید" required>
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
                                        <th scope="col" class="text-center">مدرس</th>
                                        <th scope="col" class="text-center">قیمت</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= htmlspecialchars($row['name']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($row['teacher']) ?></td>
                                            <td class="text-center"><?= number_format($row['price']) ?> ریال</td>
                                            <td class="text-center">
                                                <form action="" method="POST" style="display:inline;">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="id_package">
                                                    <button type="submit" name="delete_package" class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">
                                                        <i class="fas fa-trash-alt me-1"></i>حذف
                                                    </button>
                                                    <a href="edit_package.php?id_package=<?= $row['id'] ?>" class="btn btn-outline-info btn-sm">
                                                        <i class="fas fa-edit me-1"></i>ویرایش
                                                    </a>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php $a++;
                                    } ?>
                                </tbody>
                            </table>
                            <?php
                            $sql_count = "SELECT COUNT(*) AS total FROM packages";
                            $result_count = $conn->query($sql_count);
                            $row_count = $result_count->fetch_assoc();
                            $total_items = $row_count['total'];
                            $total_pages = ceil($total_items / $items_per_page);
                            ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                        <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php } ?>
                                    <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php } else { ?>
                            <div class="alert alert-warning text-center" role="alert">
                                هیچ پکیجی در پایگاه داده وجود ندارد.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const editor = new Jodit('#editor');

        $('form').submit(function() {
            $('#editor').val(editor.getEditorValue());
        });

        function confirmDelete() {
            return confirm("آیا مطمئن هستید که می‌خواهید این پکیج را حذف کنید؟");
        }
    </script>
</body>

</html>


<?php
if (isset($_POST['submit_package'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $teacher = $_POST['teacher'];
    $price = $_POST['price'];
    $spotplayer = $_POST['spot_id'];

    // اعتبار سنجی سمت سرور برای فیلدهای ضروری
    // فیلد فایل ضمیمه (file1) اختیاری است و نیازی به بررسی UPLOAD_ERR_OK نیست
    if (empty($name) || empty($teacher) || empty($price) || !isset($_FILES['pictures']) || $_FILES['pictures']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'لطفا تمام فیلدهای الزامی (عنوان، تصویر، مدرس و قیمت) را پر کنید.';
                errorToast.show();
            });
        </script>";
        exit();
    }

    $name = $conn->real_escape_string($name);
    $description = $conn->real_escape_string($description);
    $teacher = $conn->real_escape_string($teacher);
    $price = $conn->real_escape_string($price);
    $spotplayer = $conn->real_escape_string($spotplayer); // اضافه شده برای تمیزی بیشتر کد

    // مرحله اول: درج اطلاعات اصلی پکیج در دیتابیس
    // توجه: ستون‌های file2 و file3 همچنان در کوئری INSERT حضور دارند اما مقدار آنها NULL در نظر گرفته می‌شود.
    // اگر ساختار جدول پایگاه داده شما به‌روزرسانی نشده باشد، این بخش باید همچنان با تمامی ستون‌های مربوط به فایل‌ها کار کند.
    // فرض بر این است که ستون‌های file2 و file3 را در دیتابیس نگه می‌دارید تا کد دیتابیس شما تغییر نکند.
    $stmt = $conn->prepare("INSERT INTO packages (name, description, teacher, spotplayer, price, file2, file3) VALUES (?, ?, ?, ?, ?, NULL, NULL)");
    $stmt->bind_param("ssssd", $name, $description, $teacher, $spotplayer, $price);


    if ($stmt->execute()) {
        $package_id = $conn->insert_id;
        $stmt->close();

        $baseDir = '../uploads/packages/';
        $uploadDir = $baseDir . $package_id;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $picture_path = null;
        $file1_path = null;
        $file2_path = null; // حذف شده
        $file3_path = null; // حذف شده

        // آپلود تصویر شاخص
        $pictures = $_FILES['pictures'];
        $originalFileName = basename($pictures['name']);
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $uniqueFileName = uniqid('picture_') . '.' . $extension;
        $finalPath = $uploadDir . '/' . $uniqueFileName;
        if (move_uploaded_file($pictures['tmp_name'], $finalPath)) {
            $picture_path = str_replace('../', '', $finalPath);
        }

        // آپلود فایل اول (فایل ضمیمه)
        if (isset($_FILES['file1']) && $_FILES['file1']['error'] === UPLOAD_ERR_OK) {
            $file1 = $_FILES['file1'];
            $file1_originalName = basename($file1['name']);
            $file1_extension = pathinfo($file1_originalName, PATHINFO_EXTENSION);
            $file1_uniqueName = uniqid('file1_') . '.' . $file1_extension;
            $file1_finalPath = $uploadDir . '/' . $file1_uniqueName;
            if (move_uploaded_file($file1['tmp_name'], $file1_finalPath)) {
                $file1_path = str_replace('../', '', $file1_finalPath);
            }
        }
        
        // آپلود فایل دوم (حذف شده)
        // آپلود فایل سوم (حذف شده)

        // مرحله دوم: به‌روزرسانی مسیر فایل‌ها در دیتابیس
        // فقط file1 و pictures به‌روزرسانی می‌شوند، file2 و file3 همچنان NULL باقی می‌مانند.
        $update_stmt = $conn->prepare("UPDATE packages SET pictures = ?, file1 = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $picture_path, $file1_path, $package_id);
        $update_stmt->execute();
        $update_stmt->close();

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_package.php'; }, 3000);
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
}

if (isset($_POST['delete_package'])) {
    $id_package = $_POST['id_package'];

    // حذف فایل‌ها از سرور قبل از حذف از دیتابیس
    $sql_select = "SELECT pictures, file1, file2, file3 FROM packages WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $id_package);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();
    $row = $result_select->fetch_assoc();
    $stmt_select->close();

    if ($row) {
        if ($row['pictures']) @unlink("../" . $row['pictures']);
        if ($row['file1']) @unlink("../" . $row['file1']);
        // حذف فیزیکی file2 و file3
        if ($row['file2']) @unlink("../" . $row['file2']); 
        if ($row['file3']) @unlink("../" . $row['file3']);
        // حذف پوشه مربوطه
        @rmdir("../uploads/packages/" . $id_package);
    }

    $sql = "DELETE FROM packages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_package);
    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_package.php'; }, 3000);
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
}
?>