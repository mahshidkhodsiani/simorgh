<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
// $admin = $_SESSION["all_data"]['admin'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت مقالات</title>

    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';
    ?>

    <!-- پیش‌اتصال زودهنگام به دامنه‌های CDN تا DNS/TLS handshake از قبل انجام بشه -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://code.jquery.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://code.jquery.com">

    <!-- فقط CSS ای که برای نمایش اولیه‌ی صفحه لازمه اینجا لود می‌شه (رندر-بلاکینگ ولی سبک) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--
        نکته: CSS ادیتور Jodit عمداً از اینجا حذف و پایین صفحه، هم‌زمان با خود اسکریپت
        Jodit به‌صورت تنبل (lazy) لود می‌شه؛ چون این ادیتور سنگین‌ترین بخش صفحه است
        و لود اولیه رو به‌شدت کند می‌کرد.
    -->

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

        /* جای‌نگهدار ادیتور تا زمانی که Jodit واقعی لود بشه، صفحه پرش (layout shift) نداشته باشه */
        #editor {
            min-height: 300px;
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
                <h3 class="text-center mb-4">مدیریت مقالات</h3>

                <div class="card-form">
                    <form action="" method="post" enctype='multipart/form-data' novalidate>
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i><strong>دقت کنید:</strong> هر آنچه اینجا وارد کنید در سایت اصلی اولین مطلب می آید.
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">عنوان مقاله:</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="عنوان را اینجا وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">تصویر شاخص:</label>
                                <input type="file" name="image" class="form-control" id="inputGroupFile02" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="keywords" class="form-label">کلمات کلیدی:</label>
                                <input type="text" id="keywords" name="keywords" class="form-control" placeholder="کلمات کلیدی را با کاما جدا کنید" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editor" class="form-label">محتوای اصلی:</label>
                            <textarea id="editor" name="content" class="form-control" placeholder="برای شروع نوشتن کلیک کنید..."></textarea>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button name="submit_post" class="btn btn-outline-success">
                                <i class="fas fa-plus-circle me-2"></i>ثبت مقاله جدید
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-section">
                    <div class="table-header">
                        <i class="fas fa-list-alt me-2"></i>لیست آخرین مقالات
                    </div>
                    <div class="table-responsive mt-3">
                        <?php
                        // Pagination configuration
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        // SQL query to retrieve a subset of rows based on pagination
                        $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">ردیف</th>
                                        <th scope="col" class="text-center">عنوان مقاله</th>
                                        <th scope="col" class="text-center">بدنه</th>
                                        <th scope="col" class="text-center">کلمات کلیدی</th>
                                        <th scope="col" class="text-center">بازدید</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        // Limit body content to 2 lines
                                        $body_text = strip_tags($row['body']);
                                        $max_length = 150;
                                        if (strlen($body_text) > $max_length) {
                                            $body_text = substr($body_text, 0, $max_length) . '...';
                                        }
                                    ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($body_text) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($row['keywords']) ?></td>
                                            <td class="text-center"><?= $row['views'] ?></td>
                                            <td class="text-center">
                                                <form action="" method="POST" style="display:inline;">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="id_art">
                                                    <a href="edit_article.php?id_art=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm">
                                                        <i class="fas fa-edit me-1"></i>ویرایش
                                                    </a>
                                                    <button type="submit" name="delete_article" class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">
                                                        <i class="fas fa-trash-alt me-1"></i>حذف
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                        $a++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            // Pagination links
                            $sql_count = "SELECT COUNT(*) AS total FROM articles";
                            $result_count = $conn->query($sql_count);
                            $row_count = $result_count->fetch_assoc();
                            $total_items = $row_count['total'];
                            $total_pages = ceil($total_items / $items_per_page);

                            $start_page = max(1, $current_page - 1);
                            $end_page = min($total_pages, $start_page + 2);

                            if ($end_page - $start_page < 2 && $start_page > 1) {
                                $start_page = max(1, $end_page - 2);
                            }
                            ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                    </li>
                                    <?php for ($i = $start_page; $i <= $end_page; $i++) { ?>
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
                                هیچ مقاله‌ای در پایگاه داده وجود ندارد.
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

    <!--
        اسکریپت‌ها به انتهای body منتقل شدن و از defer استفاده می‌کنن،
        تا مرورگر HTML را قبل از دانلود/اجرای JS به‌طور کامل پارس و رندر کنه.
        این خودش باعث می‌شه صفحه خیلی زودتر قابل مشاهده و تعامل بشه.
    -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <script>
        // ---------------------------------------------------------------
        // لود تنبل (Lazy Load) ادیتور Jodit
        // ادیتور سنگین‌ترین بخش صفحه است (چند صد کیلوبایت CSS+JS).
        // به‌جای لود شدنش هم‌زمان با باز شدن صفحه، فقط وقتی که کاربر
        // واقعاً روی فیلد "محتوای اصلی" کلیک/فوکوس کنه لود و فعال می‌شه.
        // اگر هم کاربر بدون کلیک روی فیلد، مستقیم دکمه‌ی ثبت رو بزنه،
        // قبل از سابمیت به‌صورت خودکار لود و مقداردهی می‌شه تا محتوا گم نشه.
        // ---------------------------------------------------------------
        let joditLoaded = false;
        let joditLoadingPromise = null;
        let editorInstance = null;

        function loadJodit() {
            if (joditLoadingPromise) return joditLoadingPromise;

            joditLoadingPromise = new Promise(function(resolve, reject) {
                // CSS ادیتور
                var link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.css';
                document.head.appendChild(link);

                // JS ادیتور
                var script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.js';
                script.onload = function() {
                    editorInstance = new Jodit('#editor');
                    joditLoaded = true;
                    resolve(editorInstance);
                };
                script.onerror = reject;
                document.body.appendChild(script);
            });

            return joditLoadingPromise;
        }

        // فعال‌سازی با اولین فوکوس/کلیک روی فیلد محتوا
        document.getElementById('editor').addEventListener('focus', loadJodit, {
            once: true
        });

        // شبکه‌ی ایمنی: قبل از ارسال فرم، مطمئن می‌شویم مقدار ادیتور (اگر لود شده) در textarea نشسته
        document.querySelector('form').addEventListener('submit', function(e) {
            if (joditLoaded && editorInstance) {
                document.getElementById('editor').value = editorInstance.getEditorValue();
            }
            // اگر ادیتور اصلاً لود نشده باشه (کاربر روش کلیک نکرده)، مقدار ساده‌ی
            // خود textarea همون‌طور که هست ارسال می‌شه.
        });

        function confirmDelete() {
            return confirm("آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟");
        }
    </script>

</body>

</html>


<?php

if (isset($_POST['submit_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $keywords = $_POST['keywords'];

    // Escape strings to prevent SQL injection
    $title = $conn->real_escape_string($title);
    $keywords = $conn->real_escape_string($keywords);

    $imagePath = '';

    // Handle the file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../upload/images/2025/';
        $originalFileName = basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $originalFileName;

        // Ensure the upload directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = "upload/images/2025/" . $originalFileName;
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
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO articles (title, slug, body, images, keywords, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $title, $title, $content, $imagePath, $keywords);

    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_article'; }, 3000);
            });
            </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'خطا در ثبت مقاله!';
                errorToast.show();
            });
            </script>";
    }

    $stmt->close();
}

if (isset($_POST['delete_article'])) {
    $id_art = $_POST['id_art'];

    $sql = "DELETE FROM articles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_art);
    
    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_article'; }, 3000);
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