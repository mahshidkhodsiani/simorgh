<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION["all_data"]["admin"] != 1) {
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
    <title>مدیریت شب‌های تهران</title>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <?php include '../config.php'; ?>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://code.jquery.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://code.jquery.com">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
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
    audio { width: 150px; height: 30px; }
    audio[data-src] { display: none; }
    audio.loaded { display: inline; }

    /* ✅ چک‌باکس دمو */
    .demo-checkbox-wrapper {
        background: linear-gradient(135deg, #fff8e1, #ffe4b3);
        border: 2px solid #ffc107;
        border-radius: 12px;
        padding: 18px 22px;
        transition: all 0.3s ease;
    }
    .demo-checkbox-wrapper:hover {
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }
    .demo-checkbox-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        margin: 0;
        user-select: none;
    }
    .demo-checkbox-input {
        width: 24px;
        height: 24px;
        margin-left: 12px;
        cursor: pointer;
        accent-color: #ff9800;
        flex-shrink: 0;
    }
    .demo-checkbox-text {
        font-weight: 700;
        color: #856404;
        font-size: 1.05rem;
        line-height: 1.4;
    }

    /* بج‌ها */
    .demo-badge-table {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: #212529;
        box-shadow: 0 3px 8px rgba(255, 193, 7, 0.4);
    }
    .locked-badge-table {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        background: linear-gradient(135deg, #9d7eff, #6d5ed9);
        color: #fff;
        box-shadow: 0 3px 8px rgba(157, 126, 255, 0.3);
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
                <h3 class="text-center mb-4">مدیریت شب‌های تهران</h3>

                <!-- ============================================ -->
                <!-- فرم ثبت قسمت -->
                <!-- ============================================ -->
                <div class="card-form">
                    <form id="articleForm" enctype="multipart/form-data" method="POST" novalidate>
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>توجه:</strong> قیمت اشتراک هر فصل از بخش «رادیوها» تعیین می‌شود.
                            اینجا فقط قسمت‌ها را آپلود می‌کنید. قسمت‌های «دمو» برای همه رایگان هستند.
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">نام قسمت (شب‌های تهران):</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="مثال: شب‌های تهران قسمت ۱" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kind" class="form-label">نوع برنامه:</label>
                                <input type="text" id="kind" name="kind" class="form-control"
                                    placeholder="مثال: سریال صوتی" value="سریال صوتی" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="season" class="form-label">فصل برنامه:</label>
                                <select id="season" name="season" class="form-select" required>
                                    <option value="1" selected>فصل اول</option>
                                    <option value="2">فصل دوم</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mp3" class="form-label">آپلود فایل صوتی (MP3):</label>
                                <input type="file" name="mp3" class="form-control" id="mp3" accept="audio/mpeg"
                                    required>
                            </div>

                            <!-- ✅ چک‌باکس دمو -->
                            <div class="col-12 mb-3">
                                <div class="demo-checkbox-wrapper">
                                    <label for="is_free" class="demo-checkbox-label">
                                        <input type="checkbox" value="1" id="is_free" name="is_free" class="demo-checkbox-input">
                                        <span class="demo-checkbox-text">🎁 این قسمت به‌عنوان «دمو رایگان» باشد</span>
                                    </label>
                                    <small class="text-muted d-block mt-2">
                                        اگر تیک بزنید → این قسمت برای همه کاربران (حتی بدون اشتراک) قابل پخش است.<br>
                                        اگر تیک نزنید → فقط خریداران اشتراک کامل فصل می‌توانند آن را بشنوند.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-outline-success" type="submit" name="submit_radio_tehran">
                                <i class="fas fa-plus-circle me-2"></i>ثبت قسمت جدید
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ============================================ -->
                <!-- لیست قسمت‌ها -->
                <!-- ============================================ -->
                <div class="table-section">
                    <div class="table-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-list-alt me-2"></i>لیست قسمت‌های شب‌های تهران</span>
                    </div>

                    <!-- فیلتر فصل -->
                    <div class="d-flex justify-content-end align-items-center mt-3 mb-2">
                        <form method="GET" class="d-flex gap-2 align-items-center">
                            <label class="mb-0 text-muted"><i class="fas fa-filter me-1"></i>فیلتر فصل:</label>
                            <select name="season_filter" class="form-select form-select-sm" 
                                    onchange="this.form.submit()" style="width:auto;">
                                <option value="0" <?= (isset($_GET['season_filter']) && $_GET['season_filter'] == 0) || !isset($_GET['season_filter']) ? 'selected' : '' ?>>همه</option>
                                <option value="1" <?= isset($_GET['season_filter']) && $_GET['season_filter'] == 1 ? 'selected' : '' ?>>فصل اول</option>
                                <option value="2" <?= isset($_GET['season_filter']) && $_GET['season_filter'] == 2 ? 'selected' : '' ?>>فصل دوم</option>
                            </select>
                        </form>
                    </div>

                    <div class="table-responsive mt-2">
                        <?php
                        // ============================================================
                        // Pagination + Season Filter
                        // ============================================================
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        $season_filter = isset($_GET['season_filter']) ? (int)$_GET['season_filter'] : 0;
                        $where_clause = "";
                        if ($season_filter === 1 || $season_filter === 2) {
                            $where_clause = " WHERE season = $season_filter";
                        }

                        $filter_query = "";
                        if ($season_filter > 0) {
                            $filter_query = "&season_filter=" . $season_filter;
                        }

                        $total_sql = "SELECT COUNT(*) AS total FROM radio_tehran" . $where_clause;
                        $total_result = $conn->query($total_sql);
                        $total_row = $total_result->fetch_assoc();
                        $total_items = $total_row['total'];
                        $total_pages = ceil($total_items / $items_per_page);

                        $sql = "SELECT * FROM radio_tehran" . $where_clause . " ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">#</th>
                                    <th scope="col" class="text-center">عنوان</th>
                                    <th scope="col" class="text-center">نوع</th>
                                    <th scope="col" class="text-center">فصل</th>
                                    <th scope="col" class="text-center">وضعیت</th>
                                    <th scope="col" class="text-center">برنامه</th>
                                    <th scope="col" class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { 
                                    // ✅ دمو فقط بر اساس is_free
                                    $row_is_demo = ((int)($row['is_free'] ?? 0) === 1);
                                ?>
                                <tr>
                                    <th scope="row" class="text-center"><?= $a ?></th>
                                    <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['program_type']) ?></td>
                                    <td class="text-center">
                                        <?php if (isset($row['season']) && $row['season'] == 2) { ?>
                                            <span class="badge bg-info text-dark">فصل دوم</span>
                                        <?php } else { ?>
                                            <span class="badge bg-primary">فصل اول</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($row_is_demo): ?>
                                            <span class="demo-badge-table">🎁 دمو رایگان</span>
                                        <?php else: ?>
                                            <span class="locked-badge-table">🔒 اشتراکی</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <audio controls preload="none"
                                            data-src="<?= htmlspecialchars($row['file_path']) ?>">
                                            <source src="" type="audio/mpeg">
                                            مرورگر شما از پخش صوتی پشتیبانی نمی‌کند.
                                        </audio>
                                    </td>
                                    <td class="text-center">
                                        <a href="edit_radio_tehran.php?id_radio=<?= $row['id'] ?>"
                                            class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-edit me-1"></i>ویرایش
                                        </a>
                                        <a href="?delete_radio_tehran=<?= $row['id'] ?><?= $filter_query ?><?= $current_page > 1 ? '&page=' . $current_page : '' ?>"
                                            class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">
                                            <i class="fas fa-trash-alt me-1"></i>حذف
                                        </a>
                                    </td>
                                </tr>
                                <?php $a++; } ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1) { ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                       href="?page=<?= max(1, $current_page - 1) ?><?= $filter_query ?>">قبلی</a>
                                </li>
                                <?php
                                        $start_page = max(1, $current_page - 1);
                                        $end_page = min($total_pages, $start_page + 2);
                                        if ($end_page - $start_page < 2 && $start_page > 1) {
                                            $start_page = max(1, $end_page - 2);
                                        }
                                        for ($i = $start_page; $i <= $end_page; $i++) { ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?><?= $filter_query ?>"><?= $i ?></a>
                                </li>
                                <?php } ?>
                                <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                       href="?page=<?= min($total_pages, $current_page + 1) ?><?= $filter_query ?>">بعدی</a>
                                </li>
                            </ul>
                        </nav>
                        <?php } ?>

                        <?php } else { ?>
                        <div class="alert alert-warning text-center" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            هیچ قسمتی برای شب‌های تهران یافت نشد.
                        </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Toast notifications -->
    <div class="toast-container">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">موفقیت</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">
                عملیات با موفقیت انجام شد!
            </div>
        </div>
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">خطا</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">
                خطایی در انجام عملیات رخ داد!
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <script>
    // لود تنبل پلیرهای صوتی
    document.addEventListener('DOMContentLoaded', function() {
        const audioElements = document.querySelectorAll('audio[data-src]');

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const audio = entry.target;
                        const src = audio.getAttribute('data-src');
                        if (src) {
                            audio.querySelector('source').src = src;
                            audio.load();
                            audio.classList.add('loaded');
                            audio.removeAttribute('data-src');
                            observer.unobserve(audio);
                        }
                    }
                });
            }, { rootMargin: '50px' });

            audioElements.forEach(function(audio) { observer.observe(audio); });
        } else {
            audioElements.forEach(function(audio) {
                const src = audio.getAttribute('data-src');
                if (src) {
                    audio.querySelector('source').src = src;
                    audio.load();
                    audio.classList.add('loaded');
                    audio.removeAttribute('data-src');
                }
            });
        }
    });

    function confirmDelete() {
        return confirm("آیا مطمئن هستید که می‌خواهید این قسمت را حذف کنید؟");
    }
    </script>

</body>

</html>


<?php
// ============================================================
// پردازش فرم ثبت
// ============================================================
if (isset($_POST['submit_radio_tehran'])) {

    $title       = trim($_POST['title'] ?? '');
    $programType = trim($_POST['kind'] ?? '');
    $season      = (int)($_POST['season'] ?? 0);
    $is_free     = isset($_POST['is_free']) ? 1 : 0;
    $price       = 10000; // ✅ الکی برای پر بودن ستون

    // اعتبارسنجی فصل
    if (!in_array($season, [1, 2], true)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'فصل انتخاب شده معتبر نیست! فقط فصل اول یا دوم مجاز است.';
                errorToast.show();
            });
        </script>";

    } elseif ($title === '' || $programType === '') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'عنوان و نوع برنامه الزامی است!';
                errorToast.show();
            });
        </script>";

    } else {

        $dest_path = null;

        if (isset($_FILES['mp3']) && $_FILES['mp3']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath  = $_FILES['mp3']['tmp_name'];
            $fileName     = $_FILES['mp3']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            if ($fileExtension !== 'mp3') {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                        var toastBody = errorToast._element.querySelector('.toast-body');
                        toastBody.innerText = 'فقط فایل‌های MP3 مجاز هستند!';
                        errorToast.show();
                    });
                </script>";
                exit;
            }

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../upload/radios/tehran/';

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            $dest_path = $uploadFileDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                        var toastBody = errorToast._element.querySelector('.toast-body');
                        toastBody.innerText = 'خطا در آپلود فایل!';
                        errorToast.show();
                    });
                </script>";
                $dest_path = null;
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                    var toastBody = errorToast._element.querySelector('.toast-body');
                    toastBody.innerText = 'لطفاً یک فایل صوتی MP3 انتخاب کنید!';
                    errorToast.show();
                });
            </script>";
        }

        if ($dest_path) {
            // ✅ price = 10000 ثابت، season از سلکت، is_free از چک‌باکس
            $stmt = $conn->prepare(
                "INSERT INTO radio_tehran (title, program_type, season, price, is_free, file_path) 
                 VALUES(?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("ssiiis", $title, $programType, $season, $price, $is_free, $dest_path);

            if ($stmt->execute()) {
                $success_msg = $is_free 
                    ? 'قسمت دمو با موفقیت ثبت شد! 🎁' 
                    : 'قسمت اشتراکی با موفقیت ثبت شد! 🔒';
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                        var toastBody = successToast._element.querySelector('.toast-body');
                        toastBody.innerText = '{$success_msg}';
                        successToast.show();
                        setTimeout(function(){ window.location.href = 'new_radio_tehran.php'; }, 2000);
                    });
                </script>";
            } else {
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
    }
}

// ============================================================
// پردازش حذف
// ============================================================
if (isset($_GET['delete_radio_tehran'])) {
    $id_radio = (int)$_GET['delete_radio_tehran'];

    $file_stmt = $conn->prepare("SELECT file_path FROM radio_tehran WHERE id = ?");
    $file_stmt->bind_param("i", $id_radio);
    $file_stmt->execute();
    $file_res = $file_stmt->get_result();

    if ($file_res->num_rows > 0) {
        $file_row = $file_res->fetch_assoc();
        $file_path = $file_row['file_path'];
        if (!empty($file_path) && file_exists($file_path)) {
            unlink($file_path);
        }
    }
    $file_stmt->close();

    $stmt = $conn->prepare("DELETE FROM radio_tehran WHERE id = ?");
    $stmt->bind_param("i", $id_radio);

    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                var toastBody = successToast._element.querySelector('.toast-body');
                toastBody.innerText = 'قسمت با موفقیت حذف شد!';
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_radio_tehran.php'; }, 1500);
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'خطا در حذف قسمت!';
                errorToast.show();
            });
        </script>";
    }
    $stmt->close();
}
?>