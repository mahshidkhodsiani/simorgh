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
    $totalImagesQuery = "SELECT COUNT(*) as total FROM gallery";
    $totalImagesResult = $conn->query($totalImagesQuery);
    $totalImagesRow = $totalImagesResult->fetch_assoc();
    $totalImages = $totalImagesRow['total'];

    // محاسبه تعداد صفحات
    $totalPages = ceil($totalImages / $imagesPerPage);

    // گرفتن تصاویر برای صفحه فعلی
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
                            <!-- لینک برای نمایش تصویر در مدال -->
                            <a href="javascript:void(0);" class="gallery-item" 
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            data-image="<?= htmlspecialchars($row['images']) ?>" 
                            data-title="<?= htmlspecialchars($row['title']) ?>">
                                <img src="<?= htmlspecialchars($row['images']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>" style="height: 200px; object-fit: cover;">
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


    <!-- Modal برای نمایش تصویر -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="موسسه هفت هنر سیمرغ">
                </div>
            </div>
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




    <script>
        // جاوااسکریپت برای نمایش تصویر در مدال
        document.addEventListener('DOMContentLoaded', function () {
            const galleryItems = document.querySelectorAll('.gallery-item');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('imageModalLabel');

            galleryItems.forEach(item => {
                item.addEventListener('click', function () {
                    const image = this.getAttribute('data-image');
                    const title = this.getAttribute('data-title');

                    modalImage.src = image;
                    modalTitle.textContent = title;
                });
            });
        });
    </script>
  


     <?php
      include 'footer.php';
     ?>
  </body>
</html>

