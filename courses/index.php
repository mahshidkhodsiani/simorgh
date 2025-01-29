<!doctype html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره ها و مطالب جدید سیمرغ</title>
  
    
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

   
    $articlesPerPage = 9;
    
    // Count total number of results
    $countSql = "SELECT COUNT(*) as total FROM courses";
    $countResult = $conn->query($countSql);
    $totalCount = $countResult->fetch_assoc()['total'];
    
    // Calculate total pages
    $totalPages = ceil($totalCount / $articlesPerPage);
    
    // Get current page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $articlesPerPage;
    
    // Query with LIMIT and ORDER BY for pagination and descending order
    $sql = "SELECT * FROM courses ORDER BY id DESC LIMIT $offset, $articlesPerPage";  // Change 'id' to another column if necessary
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
    }

   
    ?>
    

    <div class="container mt-5">
        <?php if (!empty($articles)): ?>
            <div class="row"> <!-- ردیف برای مقالات -->
            <?php foreach ($articles as $article): ?>
                <div class="col-12 col-sm-6 col-md-4 mb-4"> <!-- هر مقاله یک ستون -->
                    <div class="card shadow-sm">
                        <?php
                        $images = $article['images'];
                        $imageData = json_decode($images, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($imageData)) {
                            $imageSrc = $imageData['thumb'];
                        } else {
                            $imageSrc = $images;
                        }
                        ?>
                        <img class="card-img-top" src="../<?= $imageSrc ?>" alt="موسسه هفت هنر سیمرغ">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                            <p class="card-text"><?php echo substr($article['text'], 0, 100); ?>...</p>
                            <!-- Button to trigger modal -->
                                <button class="btn btn-outline-primary">
                                        <a href="course.php?slug=<?=$article['title']?>" class="text-decoration-none text-primary">مطالعه بیشتر</a>
                                </button>

                        </div>
                    </div>
                </div>


            <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                    <span aria-hidden="true">قبلی</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php
                $startPage = max(1, $page - 1);
                $endPage = min($totalPages, $startPage + 2);
                for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                    <span aria-hidden="true">بعدی</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            </nav>

        <?php else: ?>
            <p class="text-center">مقاله‌ای یافت نشد.</p>
        <?php endif; ?>
    </div>




    <!-- Add necessary Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



     <?php
      include '../footer.php';
     ?>
  </body>
</html>

