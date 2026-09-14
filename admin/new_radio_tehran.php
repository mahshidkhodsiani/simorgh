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
    <title>مدیریت شب‌های تهران</title>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <?php
    // فقط config رو include کن، includes رو حذف کن
    include '../config.php';
    ?>

    <!-- پیش‌اتصال زودهنگام به دامنه‌های CDN -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://code.jquery.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://code.jquery.com">

    <!-- CSS ضروری (سبک و سریع) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f2f5;
        }
        .main-content {
            padding: 20px;
        }
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
        /* پلیر صوتی کوچک‌تر و بهینه */
        audio {
            width: 150px;
            height: 30px;
        }
        /* لود تنبل برای پلیرها - مخفی کردن پلیرها تا وقتی که اسکرول بشن */
        audio[data-src] {
            display: none;
        }
        audio.loaded {
            display: inline;
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

                <!-- فرم ثبت برنامه -->
                <div class="card-form">
                    <form id="articleForm" enctype="multipart/form-data" method="POST" novalidate>
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i><strong>دقت کنید:</strong> فایل صوتی با فرمت MP3 آپلود شود.
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">نام برنامه (شب‌های تهران):</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="عنوان برنامه را وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kind" class="form-label">نوع برنامه:</label>
                                <input type="text" id="kind" name="kind" class="form-control" placeholder="نوع برنامه را وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">قیمت (ریال):</label>
                                <input type="number" id="price" name="price" class="form-control" placeholder="قیمت را وارد کنید" min="10000" value="10000" required>
                                <small class="text-muted">حداقل قیمت ۱۰۰,۰۰۰ ریال (به دلیل محدودیت درگاه)</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mp3" class="form-label">آپلود فایل صوتی (MP3):</label>
                                <input type="file" name="mp3" class="form-control" id="mp3" accept="audio/mpeg" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-outline-success" type="submit" name="submit_radio_tehran">
                                <i class="fas fa-plus-circle me-2"></i>ثبت برنامه شب‌های تهران
                            </button>
                        </div>
                    </form>
                </div>

                <!-- لیست برنامه‌ها -->
                <div class="table-section">
                    <div class="table-header">
                        <i class="fas fa-list-alt me-2"></i>لیست برنامه‌های شب‌های تهران
                    </div>
                    <div class="table-responsive mt-3">
                        <?php
                        // Pagination configuration
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        // Get total records
                        $total_sql = "SELECT COUNT(*) AS total FROM radio_tehran";
                        $total_result = $conn->query($total_sql);
                        $total_row = $total_result->fetch_assoc();
                        $total_items = $total_row['total'];
                        $total_pages = ceil($total_items / $items_per_page);

                        // Get paginated data
                        $sql = "SELECT * FROM radio_tehran ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">عنوان</th>
                                        <th scope="col" class="text-center">نوع برنامه</th>
                                        <th scope="col" class="text-center">قیمت (ریال)</th>
                                        <th scope="col" class="text-center">برنامه</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $a ?></th>
                                        <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['program_type']) ?></td>
                                        <td class="text-center"><?= number_format($row['price']) ?></td>
                                        <td class="text-center">
                                            <!-- پلیر صوتی با لود تنبل -->
                                            <audio controls preload="none" data-src="<?= htmlspecialchars($row['file_path']) ?>">
                                                <source src="" type="audio/mpeg">
                                                مرورگر شما از پخش صوتی پشتیبانی نمی‌کند.
                                            </audio>
                                        </td>
                                        <td class="text-center">
                                            <a href="edit_radio_tehran.php?id_radio=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm">
                                                <i class="fas fa-edit me-1"></i>ویرایش
                                            </a>
                                            <a href="?delete_radio_tehran=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">
                                                <i class="fas fa-trash-alt me-1"></i>حذف
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $a++; } ?>
                                </tbody>
                            </table>

                            <!-- Pagination Links -->
                            <?php if ($total_pages > 1) { ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
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
                                        <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                    </li>
                                </ul>
                            </nav>
                            <?php } ?>

                        <?php } else { ?>
                            <div class="alert alert-warning text-center" role="alert">
                                هیچ برنامه‌ای برای شب‌های تهران یافت نشد.
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

    <!-- اسکریپت‌ها با defer -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <script>
        // ============================================================
        // ۱. لود تنبل پلیرهای صوتی (Intersection Observer)
        // ============================================================
        document.addEventListener('DOMContentLoaded', function() {
            const audioElements = document.querySelectorAll('audio[data-src]');
            
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const audio = entry.target;
                            const src = audio.getAttribute('data-src');
                            if (src) {
                                // فقط وقتی وارد viewport شد، فایل صوتی لود بشه
                                audio.querySelector('source').src = src;
                                audio.load();
                                audio.classList.add('loaded');
                                audio.removeAttribute('data-src');
                                observer.unobserve(audio);
                            }
                        }
                    });
                }, {
                    rootMargin: '50px' // 50 پیکسل قبل از ورود به viewport شروع به لود کنه
                });

                audioElements.forEach(function(audio) {
                    observer.observe(audio);
                });
            } else {
                // Fallback برای مرورگرهای قدیمی
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

        // ============================================================
        // ۲. تابع تایید حذف
        // ============================================================
        function confirmDelete() {
            return confirm("آیا مطمئن هستید که می‌خواهید این برنامه را حذف کنید؟");
        }
    </script>

</body>

</html>


<?php
// ========== پردازش فرم ثبت ==========
if (isset($_POST['submit_radio_tehran'])) {

    $title = $_POST['title'];
    $programType = $_POST['kind'];
    $price = (int)$_POST['price'];

    // بررسی حداقل قیمت
    if ($price < 10000) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'قیمت نمی‌تواند کمتر از ۱۰۰,۰۰۰ ریال باشد!';
                errorToast.show();
            });
            </script>";
    } else {

        $dest_path = null;

        if (isset($_FILES['mp3']) && $_FILES['mp3']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['mp3']['tmp_name'];
            $fileName = $_FILES['mp3']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // فقط پسوند MP3 مجاز
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
            
            // Create directory if not exists
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
        }

        if ($dest_path) {
            $stmt = $conn->prepare("INSERT INTO radio_tehran (title, program_type, price, file_path) VALUES(?, ?, ?, ?)");
            $stmt->bind_param("ssis", $title, $programType, $price, $dest_path);
            
            if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var successToast = new bootstrap.Toast(document.getElementById('successToast'));
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

// ========== پردازش حذف ==========
if (isset($_GET['delete_radio_tehran'])) {
    $id_radio = (int)$_GET['delete_radio_tehran'];
    
    // ابتدا مسیر فایل را بگیریم تا فایل را هم حذف کنیم
    $file_sql = "SELECT file_path FROM radio_tehran WHERE id = $id_radio";
    $file_res = $conn->query($file_sql);
    if ($file_res->num_rows > 0) {
        $file_row = $file_res->fetch_assoc();
        $file_path = $file_row['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $stmt = $conn->prepare("DELETE FROM radio_tehran WHERE id = ?");
    $stmt->bind_param("i", $id_radio);
    
    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_radio_tehran.php'; }, 1500);
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