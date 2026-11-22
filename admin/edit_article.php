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
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش مقاله</title>

    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';
    ?>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://code.jquery.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://code.jquery.com">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f0f2f5;
    }

    .main-content {
        padding: 20px;
    }

    .card-form {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 25px;
        margin-bottom: 30px;
        border: none;
    }

    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
    }

    #editor {
        min-height: 400px;
    }

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

    .current-image {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 4px;
        background: #fafafa;
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
                <h3 class="text-center mb-4">ویرایش مقاله</h3>

                <?php
                if (isset($_GET['id_art'])) {
                    $id_article = (int)$_GET['id_art'];

                    // امن: prepared statement
                    $stmt_get = $conn->prepare("SELECT * FROM articles WHERE id = ?");
                    $stmt_get->bind_param("i", $id_article);
                    $stmt_get->execute();
                    $result = $stmt_get->get_result();

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                ?>

                <div class="card-form">
                    <form action="" method="POST" id="articleForm" enctype="multipart/form-data" novalidate>

                        <!-- ردیف اول: عنوان مقاله + عنوان سئو -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">عنوان مقاله: <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="<?= htmlspecialchars($row['title']) ?>" required>
                                <small class="seo-helper">این عنوان در سایت و لیست مقالات نمایش داده می‌شود.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="meta_title" class="form-label">عنوان سئو (اختیاری):</label>
                                <input type="text" id="meta_title" name="meta_title" class="form-control"
                                    value="<?= htmlspecialchars($row['meta_title'] ?? '') ?>"
                                    placeholder="اگر خالی بمونه، از عنوان مقاله استفاده می‌شه" maxlength="70">
                                <small class="seo-helper">برای تگ &lt;title&gt; گوگل. پیشنهاد: ۵۰ تا ۶۰ کاراکتر. <span class="char-counter" id="meta_title_counter">0 / 70</span></small>
                            </div>
                        </div>

                        <!-- ردیف دوم: تصویر شاخص + کلمات کلیدی -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">تصویر شاخص:</label>
                                <input type="file" name="image" class="form-control" id="inputGroupFile02" accept="image/*">
                                <small class="seo-helper">اگر خالی بگذارید، تصویر فعلی حفظ می‌شود.</small>
                                <?php if (!empty($row['images'])) { ?>
                                    <div class="mt-2">
                                        <img src="../<?= htmlspecialchars($row['images']) ?>" alt="تصویر فعلی" class="current-image">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="keywords" class="form-label">کلمات کلیدی:</label>
                                <input type="text" id="keywords" name="keywords" class="form-control"
                                    value="<?= htmlspecialchars($row['keywords'] ?? '') ?>"
                                    placeholder="کلمات کلیدی را با کاما جدا کنید">
                            </div>
                        </div>

                        <!-- ردیف سوم: متا دیسکریپشن -->
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="meta_description" class="form-label">متا دیسکریپشن (اختیاری):</label>
                                <textarea id="meta_description" name="meta_description" class="form-control" 
                                    rows="3" maxlength="170"
                                    placeholder="اگر خالی بمونه، از ابتدای متن مقاله به‌صورت خودکار ساخته می‌شه"><?= htmlspecialchars($row['meta_description'] ?? '') ?></textarea>
                                <small class="seo-helper">توضیحات متا برای گوگل. پیشنهاد: ۱۲۰ تا ۱۶۰ کاراکتر. <span class="char-counter" id="meta_desc_counter">0 / 170</span></small>
                            </div>
                        </div>

                        <!-- محتوای اصلی -->
                        <div class="mb-3">
                            <label for="editor" class="form-label">محتوای اصلی: <span class="text-danger">*</span></label>
                            <textarea id="editor" name="content" class="form-control"><?= htmlspecialchars($row['body']) ?></textarea>
                        </div>

                        <div class="d-flex justify-content-center mt-4 gap-2">
                            <button class="btn btn-outline-success" type="submit" name="submit_post">
                                <i class="fas fa-save me-2"></i>ثبت تغییرات
                            </button>
                            <a href="new_article.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-right me-2"></i>بازگشت
                            </a>
                        </div>
                    </form>
                </div>

                <?php
                    } else {
                        echo '<div class="alert alert-warning text-center">چنین مقاله‌ای پیدا نشد. <a href="new_article.php">بازگشت به لیست</a></div>';
                    }
                    $stmt_get->close();
                } else {
                    echo '<div class="alert alert-warning text-center">هنوز مقاله‌ای انتخاب نکردید! <a href="new_article.php">بازگشت به لیست</a></div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Toast ها -->
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

    // در این صفحه، چون محتوا از قبل هست، ادیتور رو بلافاصله بعد از لود صفحه فعال می‌کنیم
    // تا کاربر برای دیدن محتوا لازم نباشه کلیک کنه
    window.addEventListener('DOMContentLoaded', function() {
        loadJodit().catch(function() {
            console.error('خطا در لود ادیتور');
        });
    });

    // قبل از ارسال فرم، مطمئن شو مقدار ادیتور در textarea هست
    document.getElementById('articleForm').addEventListener('submit', function(e) {
        if (joditLoaded && editorInstance) {
            document.getElementById('editor').value = editorInstance.getEditorValue();
        }
    });

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
// پردازش فرم ویرایش
// ============================================================

// تابع کمکی: ساخت متا دیسکریپشن خودکار از متن
function buildAutoMetaDescription($html, $limit = 160) {
    $text = strip_tags($html);
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);
    if (mb_strlen($text, 'UTF-8') > $limit) {
        $text = mb_substr($text, 0, $limit, 'UTF-8');
        $lastSpace = mb_strrpos($text, ' ', 0, 'UTF-8');
        if ($lastSpace !== false && $lastSpace > $limit * 0.7) {
            $text = mb_substr($text, 0, $lastSpace, 'UTF-8');
        }
        $text .= '...';
    }
    return $text;
}

if (isset($_POST['submit_post']) && isset($_GET['id_art'])) {
    $id_article = (int)$_GET['id_art'];

    $title = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    $keywords = trim($_POST['keywords'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');

    // Fallback ها
    if ($meta_title === '') {
        $meta_title = $title;
    }
    if ($meta_description === '') {
        $meta_description = buildAutoMetaDescription($content, 160);
    }

    $imagePath = null;

    // آپلود تصویر جدید (اختیاری)
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

    // اگر تصویر جدید آپلود شده → با تصویر، وگرنه بدون تصویر
    if ($imagePath !== null) {
        $stmt = $conn->prepare("UPDATE articles 
            SET title = ?, meta_title = ?, body = ?, keywords = ?, meta_description = ?, images = ?, updated_at = NOW() 
            WHERE id = ?");
        $stmt->bind_param("ssssssi", $title, $meta_title, $content, $keywords, $meta_description, $imagePath, $id_article);
    } else {
        $stmt = $conn->prepare("UPDATE articles 
            SET title = ?, meta_title = ?, body = ?, keywords = ?, meta_description = ?, updated_at = NOW() 
            WHERE id = ?");
        $stmt->bind_param("sssssi", $title, $meta_title, $content, $keywords, $meta_description, $id_article);
    }

    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_article'; }, 2000);
            });
            </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                var toastBody = errorToast._element.querySelector('.toast-body');
                toastBody.innerText = 'خطا در ویرایش مقاله!';
                errorToast.show();
            });
            </script>";
    }

    $stmt->close();
}


// ============================================================
// پردازش حذف (از طریق GET — همان‌طور که در کد قبلی بود)
// ============================================================
if (isset($_GET['delete_article']) && isset($_GET['id_art'])) {
    $id_art = (int)$_GET['id_art'];

    $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id_art);

    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(function(){ window.location.href = 'new_article'; }, 2000);
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