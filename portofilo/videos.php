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

    // محاسبه مقدار شروع تصاویر
    $offset = ($page - 1) * $imagesPerPage;

    // گرفتن کل تعداد تصاویر
    $totalImagesQuery = "SELECT COUNT(*) as total FROM videos";
    $totalImagesResult = $conn->query($totalImagesQuery);
    $totalImagesRow = $totalImagesResult->fetch_assoc();
    $totalImages = $totalImagesRow['total'];

    // محاسبه تعداد صفحات
    $totalPages = ceil($totalImages / $imagesPerPage);

    // گرفتن تصاویر برای صفحه فعلی
    $sql = "SELECT * FROM videos ORDER BY id DESC LIMIT $imagesPerPage OFFSET $offset";
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
                            <!-- لینک برای نمایش ویدیو در مدال -->
                            <a href="javascript:void(0);" class="gallery-item" 
                                data-bs-toggle="modal" 
                                data-bs-target="#videoModal" 
                                data-video="<?= htmlspecialchars($row['path']) ?>" 
                                data-title="<?= htmlspecialchars($row['title']) ?>">
                                <!-- ویدیو در کارت -->
                                <video class="card-img-top" style="height: 200px; object-fit: cover;" controls muted>
                                    <source src="<?= htmlspecialchars($row['path']) ?>" type="video/mp4">
                                    مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                                </video>
                            </a>
                            <div class="card-body">
                                <h5 class="card-title text-center"><?= htmlspecialchars($row['title']) ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<h2 class='text-center'>ویدیویی ثبت نشده است</h2>";
            }
            ?>
        </div>
    </div>






    
    <!-- صفحه‌بندی -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <!-- دکمه قبلی -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span> قبلی
                </a>
            </li>

            <!-- شماره صفحات -->
            <?php
            // محاسبه محدوده صفحات برای نمایش
            $start = max(1, $page - 1); // شروع از یکی قبل از صفحه فعلی (حداقل 1)
            $end = min($totalPages, $page + 1); // پایان در یکی بعد از صفحه فعلی (حداکثر کل صفحات)

            for ($i = $start; $i <= $end; $i++) { ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            <!-- دکمه بعدی -->
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

