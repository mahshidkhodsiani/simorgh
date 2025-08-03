<?php
// session_start() باید اولین دستور در فایل باشد
session_start();
?>
<!doctype html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گالری تصاویر</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
</head>

<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();

    // تنظیم تعداد تصاویر در هر صفحه
    $imagesPerPage = 12;

    // گرفتن شماره صفحه فعلی از URL، اگر تنظیم نشده پیش‌فرض صفحه 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1; // جلوگیری از مقادیر منفی یا صفر

    // --- بخش بهینه‌سازی شده با کشینگ سشن ---
    if (isset($_SESSION['totalImages'])) {
        $totalImages = $_SESSION['totalImages'];
    } else {
        $totalImagesQuery = "SELECT COUNT(*) as total FROM gallery";
        $totalImagesResult = $conn->query($totalImagesQuery);
        $totalImagesRow = $totalImagesResult->fetch_assoc();
        $totalImages = $totalImagesRow['total'];
        $_SESSION['totalImages'] = $totalImages;
    }
    // --- پایان بخش بهینه‌سازی ---

    // محاسبه تعداد صفحات
    $totalPages = ceil($totalImages / $imagesPerPage);

    // محاسبه مقدار شروع تصاویر
    $offset = ($page - 1) * $imagesPerPage;

    // گرفتن تصاویر برای صفحه فعلی
    // توجه: اگر در دیتابیس ستون جداگانه برای تصویر کوچک‌شده و اصلی دارید،
    // باید کوئری را به این صورت تغییر دهید:
    // $sql = "SELECT original_images, thumbnail_images, title FROM gallery ORDER BY id DESC LIMIT $imagesPerPage OFFSET $offset";
    // در غیر این صورت، این کد از همان ستون 'images' برای هر دو استفاده می‌کند.
    $sql = "SELECT * FROM gallery ORDER BY id DESC LIMIT $imagesPerPage OFFSET $offset";
    $result = $conn->query($sql);
    ?>

    <div class="container mt-5">
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="col-md-3 mb-4">
                        <div class="card shadow-sm">
                            <a href="<?= htmlspecialchars($row['images']) ?>" target="_blank" title="<?= htmlspecialchars($row['title']) ?>">
                                <img src="<?= htmlspecialchars($row['images']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>" style="height: 250px; object-fit: cover;" loading="lazy">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title text-center"><?= htmlspecialchars($row['title']) ?></h5>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<h2 class='text-center'>تصویری ثبت نشده است</h2>";
            }
            ?>
        </div>
    </div>


    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span> قبلی
                </a>
            </li>

            <?php
            $start = max(1, $page - 1);
            $end = min($totalPages, $page + 1);

            for ($i = $start; $i <= $end; $i++) { ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                    بعدی <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>


    <?php
    include 'footer.php';
    ?>
</body>

</html>