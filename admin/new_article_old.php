<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

if($_SESSION["all_data"]["admin"] != 1){
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

    /* شمارنده کاراکتر برای فیلدهای SEO */
    .char-counter {
        font-size: 0.8rem;
        color: #6c757d;
        float: left;
    }

    .char-counter.warning {
        color: #dc3545;
        font-weight: 600;
    }

    .seo-helper {
        font-size: 0.8rem;
        color: #6c757d;
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
                            <i class="fas fa-info-circle me-2"></i><strong>دقت کنید:</strong> هر آنچه اینجا وارد کنید در
                            سایت اصلی اولین مطلب می آید.
                        </div>

                        <!-- ردیف اول: عنوان مقاله + عنوان سئو -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">عنوان مقاله: <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="عنوان را اینجا وارد کنید" required>
                                <small class="seo-helper">این عنوان در سایت و لیست مقالات نمایش داده می‌شود.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="meta_title" class="form-label">عنوان سئو (اختیاری):</label>
                                <input type="text" id="meta_title" name="meta_title" class="form-control"
                                    placeholder="اگر خالی بمونه، از عنوان مقاله استفاده می‌شه" maxlength="70">
                                <small class="seo-helper">برای تگ &lt;title&gt; گوگل. پیشنهاد: ۵۰ تا ۶۰ کاراکتر. <span class="char-counter" id="meta_title_counter">0 / 70</span></small>
                            </div>
                        </div>

                        <!-- ردیف دوم: تصویر شاخص + کلمات کلیدی -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">تصویر شاخص: <span class="text-danger">*</span></label>
                                <input type="file" name="image" class="form-control" id="inputGroupFile02" required accept="image/*">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="keywords" class="form-label">کلمات کلیدی: <span class="text-danger">*</span></label>
                                <input type="text" id="keywords" name="keywords" class="form-control"
                                    placeholder="کلمات کلیدی را با کاما جدا کنید" required>
                            </div>
                        </div>

                        <!-- ردیف سوم: متا دیسکریپشن -->
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="meta_description" class="form-label">متا دیسکریپشن (اختیاری):</label>
                                <textarea id="meta_description" name="meta_description" class="form-control" 
                                    rows="3" maxlength="170"
                                    placeholder="اگر خالی بمونه، از ابتدای متن مقاله به‌صورت خودکار ساخته می‌شه"></textarea>
                                <small class="seo-helper">توضیحات متا برای گوگل. پیشنهاد: ۱۲۰ تا ۱۶۰ کاراکتر. <span class="char-counter" id="meta_desc_counter">0 / 170</span></small>
                            </div>
                        </div>

                        <!-- محتوای اصلی -->
                        <div class="mb-3">
                            <label for="editor" class="form-label">محتوای اصلی: <span class="text-danger">*</span></label>
                            <textarea id="editor" name="content" class="form-control"
                                placeholder="برای شروع نوشتن کلیک کنید..."></textarea>
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
                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        if ($current_page < 1) $current_page = 1;
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
                                    <th scope="col" class="text-center">عنوان سئو</th>
                                    <th scope="col" class="text-center">متا دیسکریپشن</th>
                                    <th scope="col" class="text-center">کلمات کلیدی</th>
                                    <th scope="col" class="text-center">بازدید</th>
                                    <th scope="col" class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($row = $result->fetch_assoc()) {
                                        // کوتاه کردن متا دیسکریپشن برای نمایش در جدول (با mb_ برای پشتیبانی از فارسی)
                                        $meta_desc_short = $row['meta_description'] ?? '';
                                        if (mb_strlen($meta_desc_short, 'UTF-8') > 80) {
                                            $meta_desc_short = mb_substr($meta_desc_short, 0, 80, 'UTF-8') . '...';
                                        }
                                    ?>
                                <tr>
                                    <th scope="row" class="text-center"><?= $a ?></th>
                                    <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                    <td class="text-center">
                                        <?= !empty($row['meta_title']) 
                                            ? htmlspecialchars($row['meta_title']) 
                                            : '<span class="text-muted small">— خودکار از عنوان —</span>' ?>
                                    </td>
                                    <td class="text-center">
                                        <?= !empty($row['meta_description']) 
                                            ? htmlspecialchars($meta_desc_short) 
                                            : '<span class="text-muted small">— خودکار از متن —</span>' ?>
                                    </td>
                                    <td class="text-center"><?= htmlspecialchars($row['keywords']) ?></td>
                                    <td class="text-center"><?= $row['views'] ?></td>
                                    <td class="text-center">
                                        <form action="" method="POST" style="display:inline;">
                                            <input type="hidden" value="<?= $row['id'] ?>" name="id_art">
                                            <a href="edit_article.php?id_art=<?= $row['id'] ?>"
                                                class="btn btn-outline-warning btn-sm">
                                                <i class="fas fa-edit me-1"></i>ویرایش
                                            </a>
                                            <button type="submit" name="delete_article"
                                                class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">
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
                                    <a class="page-link"
                                        href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
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
    // ---------------------------------------------------------------
    // لود تنبل (Lazy Load) ادیتور Jodit
    // ---------------------------------------------------------------
    let joditLoaded = false;
    let joditLoadingPromise = null;
    let editorInstance = null;

    function loadJodit() {
        if (joditLoadingPromise) return joditLoadingPromise;

        joditLoadingPromise = new Promise(function(resolve, reject) {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.css';
            document.head.appendChild(link);

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

    document.getElementById('editor').addEventListener('focus', loadJodit, {
        once: true
    });

    // شبکه‌ی ایمنی: قبل از ارسال فرم، مقدار ادیتور رو در textarea بنشون
    document.querySelector('form').addEventListener('submit', function(e) {
        if (joditLoaded && editorInstance) {
            document.getElementById('editor').value = editorInstance.getEditorValue();
        }
    });

    function confirmDelete() {
        return confirm("آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟");
    }

    // ---------------------------------------------------------------
    // شمارنده کاراکتر برای فیلدهای SEO
    // ---------------------------------------------------------------
    function setupCounter(inputId, counterId, max) {
        var input = document.getElementById(inputId);
        var counter = document.getElementById(counterId);
        if (!input || !counter) return;

        function update() {
            var len = input.value.length;
            counter.textContent = len + ' / ' + max;
            if (len > max * 0.9) {
                counter.classList.add('warning');
            } else {
                counter.classList.remove('warning');
            }
        }
        input.addEventListener('input', update);
        update();
    }

    setupCounter('meta_title', 'meta_title_counter', 70);
    setupCounter('meta_description', 'meta_desc_counter', 170);
    </script>

</body>

</html>


<?php
// ============================================================
// پردازش فرم‌ها
// ============================================================

// تابع کمکی: ساخت متا دیسکریپشن خودکار از متن
function buildAutoMetaDescription($html, $limit = 160) {
    // حذف تگ‌ها و فاصله‌های اضافی
    $text = strip_tags($html);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);
    if (mb_strlen($text, 'UTF-8') > $limit) {
        $text = mb_substr($text, 0, $limit, 'UTF-8');
        // تلاش برای بریدن در انتهای کلمه
        $lastSpace = mb_strrpos($text, ' ', 0, 'UTF-8');
        if ($lastSpace !== false && $lastSpace > $limit * 0.7) {
            $text = mb_substr($text, 0, $lastSpace, 'UTF-8');
        }
        $text .= '...';
    }
    return $text;
}

if (isset($_POST['submit_post'])) {
    $title = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    $keywords = trim($_POST['keywords'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');

    // اگر عنوان سئو خالی بود، از عنوان مقاله استفاده کن
    if ($meta_title === '') {
        $meta_title = $title;
    }

    // اگر متا دیسکریپشن خالی بود، از متن مقاله بساز
    if ($meta_description === '') {
        $meta_description = buildAutoMetaDescription($content, 160);
    }

    $imagePath = '';

    // Handle the file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../upload/images/2025/';
        $originalFileName = basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $originalFileName;

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

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
    $stmt = $conn->prepare("INSERT INTO articles 
        (title, meta_title, slug, body, images, keywords, meta_description, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssss", 
        $title, 
        $meta_title, 
        $title,       // slug - بعداً اصلاح می‌شود
        $content, 
        $imagePath, 
        $keywords,
        $meta_description
    );

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
    $id_art = (int)$_POST['id_art'];

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
