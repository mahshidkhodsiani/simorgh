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
    <title>مدیریت استوری‌ها</title>

    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    // فقط config رو include کن
    include '../config.php';
    ?>

    <!-- پیش‌اتصال زودهنگام به دامنه‌های CDN -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://code.jquery.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://code.jquery.com">

    <!-- CSS ضروری -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .card-header-custom {
            background-color: #4a5d73;
            color: white;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            font-size: 1.1rem;
            font-weight: 600;
            margin: -20px -20px 20px -20px;
        }

        .card-header-custom i {
            margin-left: 8px;
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

        .story-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .story-image-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
            font-size: 20px;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .badge-active {
            background-color: #28a745;
            color: white;
        }

        .badge-inactive {
            background-color: #dc3545;
            color: white;
        }

        .badge-expired {
            background-color: #6c757d;
            color: white;
        }

        .toolbar-btn {
            margin: 2px;
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
                <h3 class="text-center mb-4">
                    <i class="fas fa-photo-video me-2"></i>مدیریت استوری‌ها
                </h3>

                <!-- ============================================================ -->
                <!-- فرم افزودن استوری -->
                <!-- ============================================================ -->
                <div class="card-form">
                    <div class="card-header-custom">
                        <i class="fas fa-plus-circle"></i>افزودن استوری جدید
                    </div>

                    <form action="" method="post" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">
                                    <i class="fas fa-tag me-1"></i>عنوان استوری:
                                </label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="مثلا: پکیج جدید" required maxlength="255">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">
                                    <i class="fas fa-image me-1"></i>تصویر استوری:
                                </label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                                <small class="text-muted">فرمت‌های مجاز: JPG, PNG, GIF</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="expire_type" class="form-label">
                                    <i class="fas fa-clock me-1"></i>نوع زمان‌بندی:
                                </label>
                                <select name="expire_type" id="expire_type" class="form-control"
                                    onchange="toggleCustomDays()">
                                    <option value="day">۱ روز</option>
                                    <option value="week" selected>۱ هفته</option>
                                    <option value="month">۱ ماه</option>
                                    <option value="custom">سفارشی</option>
                                    <option value="unlimited">نامحدود</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3" id="customDaysDiv" style="display:none;">
                                <label for="expire_days" class="form-label">
                                    <i class="fas fa-calendar-day me-1"></i>تعداد روز:
                                </label>
                                <input type="number" name="expire_days" id="expire_days" class="form-control"
                                    min="1" max="365" value="7">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-toggle-on me-1"></i>وضعیت:
                                </label>
                                <select name="status" class="form-control">
                                    <option value="1">فعال</option>
                                    <option value="0">غیرفعال</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" name="submit_story" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>ثبت استوری
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ============================================================ -->
                <!-- ابزار تست -->
                <!-- ============================================================ -->
                <div class="card-form">
                    <div class="card-header-custom" style="background-color: #17a2b8;">
                        <i class="fas fa-tools"></i>ابزار تست
                    </div>

                    <div class="d-flex gap-2 mb-3">
                        <a href="?test_stories" class="btn btn-info">
                            <i class="fas fa-eye me-1"></i>نمایش وضعیت استوری‌ها
                        </a>
                        <a href="?reset_test" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>بستن
                        </a>
                    </div>

                    <?php
                    // ===== تست نمایش استوری‌ها =====
                    if (isset($_GET['test_stories'])) {
                        echo "<div class='alert alert-secondary mt-3'>";
                        echo "<h6><i class='fas fa-database me-2'></i>وضعیت استوری‌ها در دیتابیس:</h6>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered table-sm'>";
                        echo "<thead><tr>
                                <th>ID</th>
                                <th>عنوان</th>
                                <th>تاریخ انقضا</th>
                                <th>وضعیت</th>
                                <th>نمایش</th>
                              </tr></thead><tbody>";

                        $test_sql = "SELECT *, 
                                     CASE 
                                         WHEN expire_at IS NULL THEN 'نامحدود'
                                         WHEN expire_at > NOW() THEN 'فعال'
                                         ELSE 'منقضی'
                                     END as current_status
                                     FROM stories ORDER BY id DESC";
                        $test_result = $conn->query($test_sql);

                        if ($test_result->num_rows > 0) {
                            while ($row = $test_result->fetch_assoc()) {
                                $show = ($row['status'] == 1 && ($row['expire_at'] == null || $row['expire_at'] > date('Y-m-d H:i:s'))) ? '✅' : '❌';
                                $status_class = ($row['current_status'] == 'فعال') ? 'badge-active' : (($row['current_status'] == 'نامحدود') ? 'badge-active' : 'badge-expired');
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>" . htmlspecialchars($row['title']) . "</td>
                                        <td>" . ($row['expire_at'] ?: 'نامحدود') . "</td>
                                        <td><span class='badge-status {$status_class}'>{$row['current_status']}</span></td>
                                        <td class='text-center'>{$show}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>هیچ استوری وجود ندارد</td></tr>";
                        }
                        echo "</tbody></table>";
                        echo "<p class='text-muted'><i class='fas fa-clock me-1'></i>تاریخ فعلی: " . date('Y-m-d H:i:s') . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>

                <!-- ============================================================ -->
                <!-- لیست استوری‌ها -->
                <!-- ============================================================ -->
                <div class="table-section">
                    <div class="card-header-custom" style="background-color: #6c757d;">
                        <i class="fas fa-list-alt"></i>لیست استوری‌ها
                    </div>

                    <div class="table-responsive">
                        <?php
                        // ===== Pagination با Prepared Statement =====
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        // تعداد کل رکوردها
                        $count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM stories");
                        $count_stmt->execute();
                        $count_result = $count_stmt->get_result();
                        $total_row = $count_result->fetch_assoc();
                        $total_items = $total_row['total'];
                        $total_pages = ceil($total_items / $items_per_page);
                        $count_stmt->close();

                        // دریافت داده‌ها با Prepared Statement
                        $stmt = $conn->prepare("SELECT * FROM stories ORDER BY id DESC LIMIT ? OFFSET ?");
                        $stmt->bind_param("ii", $items_per_page, $offset);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">تصویر</th>
                                        <th class="text-center">عنوان</th>
                                        <th class="text-center">مدت</th>
                                        <th class="text-center">انقضا</th>
                                        <th class="text-center">وضعیت</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) {
                                        // لیبل‌های زمان
                                        $expire_labels = [
                                            'day' => '۱ روز',
                                            'week' => '۱ هفته',
                                            'month' => '۱ ماه',
                                            'custom' => $row['expire_days'] . ' روز',
                                            'unlimited' => 'نامحدود'
                                        ];

                                        // وضعیت نمایشی
                                        $is_active = ($row['status'] == 1 && ($row['expire_at'] == null || $row['expire_at'] > date('Y-m-d H:i:s')));
                                        $status_badge = $is_active 
                                            ? '<span class="badge-status badge-active">فعال</span>' 
                                            : ($row['status'] == 1 
                                                ? '<span class="badge-status badge-expired">منقضی</span>' 
                                                : '<span class="badge-status badge-inactive">غیرفعال</span>');

                                        // تاریخ انقضا
                                        $expire_date = $row['expire_at'] 
                                            ? date('Y-m-d', strtotime($row['expire_at'])) 
                                            : 'نامحدود';

                                        // تصویر
                                        $image_path = '../' . $row['image'];
                                        $image_html = (file_exists($image_path) && !empty($row['image']))
                                            ? "<img src='{$image_path}' class='story-image' alt='استوری'>"
                                            : "<div class='story-image-placeholder'><i class='fas fa-image'></i></div>";
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $a ?></td>
                                            <td class="text-center"><?= $image_html ?></td>
                                            <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                            <td class="text-center"><?= $expire_labels[$row['expire_type']] ?? 'نامشخص' ?></td>
                                            <td class="text-center"><?= $expire_date ?></td>
                                            <td class="text-center"><?= $status_badge ?></td>
                                            <td class="text-center">
                                                <a href="edit_story.php?id=<?= (int)$row['id'] ?>" 
                                                   class="btn btn-outline-warning btn-sm toolbar-btn">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="?delete=<?= (int)$row['id'] ?>" 
                                                   class="btn btn-outline-danger btn-sm toolbar-btn"
                                                   onclick="return confirm('آیا از حذف این استوری مطمئن هستید؟')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php $a++;
                                    } ?>
                                </tbody>
                            </table>

                            <!-- ===== Pagination Links ===== -->
                            <?php if ($total_pages > 1) { ?>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">
                                                <i class="fas fa-chevron-right"></i> قبلی
                                            </a>
                                        </li>

                                        <?php
                                        $start_page = max(1, $current_page - 1);
                                        $end_page = min($total_pages, $start_page + 2);
                                        if ($end_page - $start_page < 2 && $start_page > 1) {
                                            $start_page = max(1, $end_page - 2);
                                        }
                                        for ($i = $start_page; $i <= $end_page; $i++) { ?>
                                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php } ?>

                                        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">
                                                بعدی <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php } ?>

                        <?php } else { ?>
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                <p>هیچ استوری ثبت نشده است!</p>
                            </div>
                        <?php } ?>
                        <?php $stmt->close(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- Toast Notifications -->
    <!-- ============================================================ -->
    <div class="toast-container">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">موفقیت</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">عملیات با موفقیت انجام شد!</div>
        </div>

        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-danger text-white">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong class="me-auto">خطا</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">خطایی در انجام عملیات رخ داد!</div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- Scripts با defer -->
    <!-- ============================================================ -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <script>
        // ===== نمایش/مخفی کردن فیلد روزهای سفارشی =====
        function toggleCustomDays() {
            var type = document.getElementById('expire_type').value;
            var customDiv = document.getElementById('customDaysDiv');
            customDiv.style.display = (type === 'custom') ? 'block' : 'none';
        }

        // ===== فعال کردن تابع در بارگذاری =====
        document.addEventListener('DOMContentLoaded', function() {
            toggleCustomDays();
        });

        // ===== تابع تایید حذف (اضافی) =====
        function confirmDelete() {
            return confirm("آیا از حذف این استوری مطمئن هستید؟");
        }

        // ===== اتصال تابع به لینک‌های حذف =====
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a[href*="delete="]').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    if (!confirm('آیا از حذف این استوری مطمئن هستید؟')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>

</body>

</html>


<?php
// ============================================================
// ========== پردازش‌های بک‌اند ==========
// ============================================================

// ===== ۱. ثبت استوری جدید =====
if (isset($_POST['submit_story'])) {

    // ===== اعتبارسنجی ورودی‌ها =====
    $title = trim($_POST['title'] ?? '');
    $expire_type = $_POST['expire_type'] ?? 'week';
    $expire_days = ($expire_type == 'custom') ? intval($_POST['expire_days'] ?? 7) : null;
    $status = intval($_POST['status'] ?? 1);

    // Validation
    $errors = [];
    if (empty($title) || strlen($title) > 255) {
        $errors[] = 'عنوان باید بین ۱ تا ۲۵۵ کاراکتر باشد';
    }
    if (!in_array($expire_type, ['day', 'week', 'month', 'custom', 'unlimited'])) {
        $errors[] = 'نوع زمان‌بندی نامعتبر است';
    }
    if ($expire_type == 'custom' && ($expire_days < 1 || $expire_days > 365)) {
        $errors[] = 'تعداد روز باید بین ۱ تا ۳۶۵ باشد';
    }
    if (!in_array($status, [0, 1])) {
        $errors[] = 'وضعیت نامعتبر است';
    }

    // ===== بررسی فایل =====
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'لطفاً یک تصویر انتخاب کنید';
    }

    if (!empty($errors)) {
        $error_msg = implode(' | ', $errors);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = '" . addslashes($error_msg) . "';
                errorToast.show();
            });
            </script>";
        exit;
    }

    // ===== محاسبه تاریخ انقضا =====
    $expire_at = null;
    $now = new DateTime();

    switch ($expire_type) {
        case 'day':
            $expire_at = $now->modify('+1 day')->format('Y-m-d H:i:s');
            break;
        case 'week':
            $expire_at = $now->modify('+1 week')->format('Y-m-d H:i:s');
            break;
        case 'month':
            $expire_at = $now->modify('+1 month')->format('Y-m-d H:i:s');
            break;
        case 'custom':
            $expire_at = $now->modify("+$expire_days days")->format('Y-m-d H:i:s');
            break;
        case 'unlimited':
            $expire_at = null;
            break;
    }

    // ===== آپلود تصویر با اعتبارسنجی =====
    $imagePath = '';
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_types)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'فرمت تصویر مجاز نیست. فقط JPG، PNG، GIF و WebP';
                errorToast.show();
            });
            </script>";
        exit;
    }

    // بررسی حجم (حداکثر ۵ مگابایت)
    if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'حجم تصویر نباید بیشتر از ۵ مگابایت باشد';
                errorToast.show();
            });
            </script>";
        exit;
    }

    $uploadDir = '../upload/images/stories/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = time() . '_' . rand(1000, 9999) . '.' . $ext;
    $uploadFile = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        $imagePath = "upload/images/stories/" . $filename;
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'خطا در آپلود تصویر!';
                errorToast.show();
            });
            </script>";
        exit;
    }

    // ===== INSERT با Prepared Statement =====
    $stmt = $conn->prepare("INSERT INTO stories (title, image, expire_type, expire_days, expire_at, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisi", $title, $imagePath, $expire_type, $expire_days, $expire_at, $status);

    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                var toastBody = successToast._element.querySelector('.toast-body');
                toastBody.innerText = '✅ استوری با موفقیت ثبت شد!';
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_story'; }, 2000);
            });
            </script>";
    } else {
        // در صورت خطا، فایل آپلود شده رو پاک کن
        if (file_exists($uploadFile)) {
            unlink($uploadFile);
        }
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'خطا در ثبت: " . addslashes($conn->error) . "';
                errorToast.show();
            });
            </script>";
    }
    $stmt->close();
}

// ===== ۲. حذف استوری =====
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    if ($id <= 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'شناسه نامعتبر!';
                errorToast.show();
            });
            </script>";
        exit;
    }

    // ===== استفاده از تراکنش برای حذف همزمان فایل و رکورد =====
    $conn->begin_transaction();

    try {
        // گرفتن مسیر تصویر
        $img_stmt = $conn->prepare("SELECT image FROM stories WHERE id = ?");
        $img_stmt->bind_param("i", $id);
        $img_stmt->execute();
        $img_result = $img_stmt->get_result();

        if ($img_result->num_rows > 0) {
            $img_row = $img_result->fetch_assoc();
            $file_path = '../' . $img_row['image'];
            $img_stmt->close();

            // حذف رکورد
            $delete_stmt = $conn->prepare("DELETE FROM stories WHERE id = ?");
            $delete_stmt->bind_param("i", $id);

            if ($delete_stmt->execute()) {
                // حذف فایل
                if (!empty($img_row['image']) && file_exists($file_path)) {
                    unlink($file_path);
                }
                $conn->commit();

                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                        var toastBody = successToast._element.querySelector('.toast-body');
                        toastBody.innerText = '🗑️ استوری با موفقیت حذف شد!';
                        successToast.show();
                        setTimeout(function(){ window.location.href = 'new_story'; }, 1500);
                    });
                    </script>";
            } else {
                throw new Exception("خطا در حذف رکورد: " . $conn->error);
            }
            $delete_stmt->close();
        } else {
            throw new Exception("استوری مورد نظر یافت نشد!");
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = '" . addslashes($e->getMessage()) . "';
                errorToast.show();
            });
            </script>";
    }
}

// ===== ۳. ریست تست =====
if (isset($_GET['reset_test'])) {
    header("Location: new_story");
    exit();
}
?>