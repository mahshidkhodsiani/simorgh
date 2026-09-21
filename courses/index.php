<!doctype html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره ها و مطالب جدید سیمرغ</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    /* یکسان‌سازی ارتفاع کارت‌ها و تصاویر */
    .course-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .course-card .card-body {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .course-card .card-text {
        flex: 1;
    }

    .course-card .btn {
        align-self: flex-start;
    }
    </style>
</head>

<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();

    $articlesPerPage = 9;

    $countSql = "SELECT COUNT(*) as total FROM courses";
    $countResult = $conn->query($countSql);
    $totalCount = $countResult->fetch_assoc()['total'];

    $totalPages = ceil($totalCount / $articlesPerPage);

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $articlesPerPage;

    $sql = "SELECT * FROM courses ORDER BY id DESC LIMIT $offset, $articlesPerPage";
    $result = $conn->query($sql);

    $articles = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
    }
    ?>

    <div class="container mt-5">
        <?php if (!empty($articles)): ?>
        <div class="row g-4">
            <?php foreach ($articles as $article): ?>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card shadow-sm course-card">
                    <?php
                  $images = $article['images'];
                  $imageData = json_decode($images, true);
                  if (json_last_error() === JSON_ERROR_NONE && is_array($imageData) && isset($imageData['thumb'])) {
                      $imageSrc = $imageData['thumb'];
                  } else {
                      $imageSrc = $images;
                  }
                ?>
                    <img class="card-img-top" src="../<?= htmlspecialchars($imageSrc) ?>" alt="موسسه هفت هنر سیمرغ">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                        <p class="card-text"><?= mb_substr(strip_tags($article['text']), 0, 100, 'UTF-8') ?>...</p>
                        <a href="course.php?slug=<?= urlencode($article['slug'] ?? $article['title']) ?>"
                            class="btn btn-outline-primary">مطالعه بیشتر</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">قبلی</a>
                </li>
                <?php endif; ?>

                <?php
              $startPage = max(1, $page - 1);
              $endPage = min($totalPages, $startPage + 2);
              for ($i = $startPage; $i <= $endPage; $i++):
            ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">بعدی</a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>

        <?php else: ?>
        <p class="text-center">مقاله‌ای یافت نشد.</p>
        <?php endif; ?>
    </div>

    <?php include '../footer.php'; ?>
</body>

</html>