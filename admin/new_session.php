<?php
session_start();

// بررسی وضعیت ورود کاربر
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
    <title>مدیریت جلسات پکیج ها</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php
    // فرض می‌شود این فایل‌ها شامل لینک‌ها و تنظیمات مورد نیاز هستند
    include 'includes.php';
    // فرض می‌شود فایل config.php اتصال به دیتابیس ($conn) را فراهم می‌کند.
    include '../config.php';
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.js"></script>

    <style>
        /* استایل‌های پایه برای هماهنگی با new_package.php */
        body { background-color: #f0f2f5; }
        .main-content { padding: 20px; }
        .card-form, .table-section {
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
                <h3 class="text-center mb-4">مدیریت جلسات</h3>

                <div class="card-form">
                    <form action="" method="post" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="package_id" class="form-label">انتخاب پکیج: <span class="text-danger">*</span></label>
                                <select id="package_id" name="package_id" class="form-select" required>
                                    <option value="">یکی از پکیج‌ها را انتخاب کنید</option>
                                    <?php
                                    // کوئری برای گرفتن لیست پکیج‌ها جهت انتخاب
                                    $package_query = "SELECT id, name FROM packages ORDER BY name ASC";
                                    $package_result = $conn->query($package_query);
                                    if ($package_result && $package_result->num_rows > 0) {
                                        while ($pkg = $package_result->fetch_assoc()) {
                                            echo "<option value='" . $pkg['id'] . "'>" . htmlspecialchars($pkg['name']) . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>هیچ پکیجی ثبت نشده است</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">عنوان جلسه: <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="عنوان جلسه را وارد کنید" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="duration" class="form-label">مدت زمان جلسه (اختیاری - بر حسب دقیقه):</label>
                                <input type="number" id="duration" name="duration" class="form-control" placeholder="مدت زمان را به دقیقه وارد کنید" min="1">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editor" class="form-label">توضیحات جلسه (اختیاری):</label>
                            <textarea id="editor" name="description" class="form-control"></textarea>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button name="submit_session" class="btn btn-outline-success">
                                <i class="fas fa-plus-circle me-2"></i>ثبت جلسه جدید
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-section">
                    <div class="table-header">
                        <i class="fas fa-list-alt me-2"></i>لیست آخرین جلسات
                    </div>
                    <div class="table-responsive mt-3">
                        <?php
                        // منطق صفحه‌بندی
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        // کوئری برای نمایش جلسات به همراه نام پکیج مرتبط
                        $sql = "SELECT s.*, p.name AS package_name 
                                FROM sessions s
                                JOIN packages p ON s.package_id = p.id
                                ORDER BY s.id DESC 
                                LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">عنوان جلسه</th>
                                        <th scope="col" class="text-center">پکیج</th>
                                        <th scope="col" class="text-center">مدت زمان (دقیقه)</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($row['package_name']) ?></td>
                                            <td class="text-center"><?= $row['duration_minutes'] ?? '-' ?></td>
                                            <td class="text-center">
                                                <a href="edit_session.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm me-2">
                                                    <i class="fas fa-edit me-1"></i>ویرایش
                                                </a>
                                                 
                                                <form action="" method="POST" style="display:inline;">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="id_session">
                                                    <button type="submit" name="delete_session" class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">
                                                        <i class="fas fa-trash-alt me-1"></i>حذف
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php $a++;
                                    } ?>
                                </tbody>
                            </table>
                            <?php
                            // محاسبه تعداد کل صفحات برای صفحه‌بندی
                            $sql_count = "SELECT COUNT(*) AS total FROM sessions";
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
                                هیچ جلسه‌ای در پایگاه داده وجود ندارد.
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
            <div class="toast-body">عملیات با موفقیت انجام شد!</div>
        </div>
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">خطا</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">خطایی در انجام عملیات رخ داد!</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // فعال‌سازی ادیتور Jodit
        const editor = new Jodit('#editor', {
             direction: 'rtl',
             language: 'fa',
             toolbarAdaptive: false 
        });

        // اطمینان از ارسال محتوای ادیتور در هنگام ثبت فرم
        // توجه: این بخش فقط برای فرم 'ثبت جدید' در همین صفحه است.
        $('form').submit(function() {
            // تنها اگر نام دکمه 'submit_session' وجود دارد، محتوای ادیتور را تنظیم کن.
            if ($('button[name="submit_session"]').length > 0) {
                 $('#editor').val(editor.getEditorValue());
            }
        });

        // تابع تایید حذف
        function confirmDelete() {
            return confirm("آیا مطمئن هستید که می‌خواهید این جلسه را حذف کنید؟");
        }
    </script>
</body>

</html>


<?php
// ----------------------------------------------------------------------
// --- منطق سمت سرور برای ثبت و حذف ---
// ----------------------------------------------------------------------

// --- منطق ثبت جلسه جدید ---
if (isset($_POST['submit_session'])) {
    $package_id = $_POST['package_id'];
    $title = $_POST['title'];
    // duration_minutes اختیاری است
    // استفاده از عملگر سه‌تایی برای جلوگیری از خطا در صورتی که فیلد خالی باشد.
    $duration_minutes = $_POST['duration'] !== '' ? (int)$_POST['duration'] : null;
    $description = $_POST['description'];

    // اعتبار سنجی سمت سرور برای فیلدهای الزامی
    if (empty($package_id) || empty($title)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'لطفا تمام فیلدهای الزامی (پکیج و عنوان) را پر کنید.';
                errorToast.show();
            });
        </script>";
        // استفاده از 'goto' یا بازگرداندن تابع یا... برای جلوگیری از ادامه اجرای کد.
        // در اینجا به دلیل ساختار فایل، `exit()` مناسب است.
        exit(); 
    }

    $package_id = (int)$package_id;
    $title = $conn->real_escape_string($title);
    $description = $conn->real_escape_string($description);
    // duration_minutes نیازی به real_escape_string ندارد چون یا null است یا int

    // درج اطلاعات در دیتابیس با استفاده از Prepared Statement
    $stmt = $conn->prepare("INSERT INTO sessions (package_id, title, description, duration_minutes) VALUES (?, ?, ?, ?)");
    // نوع پارامترها: i: integer (برای package_id و duration_minutes), s: string (برای title و description)
    // دقت کنید که $duration_minutes در اینجا می‌تواند null باشد و PDO یا MySQLi آن را مدیریت می‌کند.
    $stmt->bind_param("issi", $package_id, $title, $description, $duration_minutes);

    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                // رفرش صفحه برای نمایش جلسه جدید و پاک شدن فرم
                setTimeout(function(){ window.location.href = 'new_session.php'; }, 3000);
            });
            </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'خطا در ثبت جلسه: " . $conn->error . "';
                errorToast.show();
            });
        </script>";
    }
    $stmt->close();
}


// --- منطق حذف جلسه ---
if (isset($_POST['delete_session'])) {
    $id_session = (int)$_POST['id_session'];

    $sql = "DELETE FROM sessions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_session);
    
    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_session.php'; }, 3000);
            });
            </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'خطا در حذف جلسه: " . $conn->error . "';
                errorToast.show();
            });
            </script>";
    }
    $stmt->close();
}
// $conn->close(); // بستن اتصال به دیتابیس در انتهای فایل یا در فایل config.php باید انجام شود.
?>