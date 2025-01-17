<!doctype html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وبلاگ سیمرغ</title>
  
    
    <?php include "includes.php"; ?>
    
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">


    <style>
      /* Ensure modal is on top */
    .modal {
        z-index: 1050; /* Bootstrap's default value; you can increase this if needed */
    }

    /* Bold modal header and content */
    .modal-content {
        border: 2px solid #000; /* Add a bold border */
        font-weight: bold; /* Make text bold */
    }

    /* Bold modal header */
    .modal-header {
        background-color: #343a40; /* Dark background for header */
        color: white; /* White text */
        font-weight: bold; /* Bold text */
    }

    /* Bold modal title */
    .modal-title {
        font-size: 1.5rem; /* Increase title size */
        font-weight: bold; /* Bold title */
    }

    /* Bold modal body */
    .modal-body {
        font-size: 1.1rem; /* Increase body text size */
        line-height: 1.5; /* Improve readability */
    }

    /* Modal footer buttons */
    .modal-footer .btn {
        font-weight: bold; /* Bold buttons */
        padding: 0.5rem 1rem; /* Add padding */
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
    
    // Count total number of results
    $countSql = "SELECT COUNT(*) as total FROM articles";
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
        <div class="row">
            <?php foreach ($articles as $article): ?>
              <div class="col-md-4">
                  <div class="card mb-4 shadow-sm">
                    <?php
                    // Decode the JSON to access the image URLs
                    
                    $images = $article['images'];
                    
                    // Attempt to decode the JSON string
                    $imageData = json_decode($images, true);
                    
                    // Check if decoding was successful (i.e., it's JSON)
                    if (json_last_error() === JSON_ERROR_NONE && is_array($imageData)) {
                        // It's a JSON string with multiple sizes
                        $imageSrc = $imageData['thumb']; // Use 'thumb' or choose 'original', '300', '600', '900'
                    } else {
                        // It's a simple string (path to the image)
                        $imageSrc = $images;
                    }
                    ?>
                    <img class="card-img-top" src="<?php echo htmlspecialchars($imageSrc); ?>" alt="موسسه هفت هنر سیمرغ">
                    
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                        <p class="card-text"><?php echo substr($article['text'], 0, 100); ?>...</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#articleModal<?php echo $article['id']; ?>">مطالعه بیشتر</button>
                    </div>
                </div>
              </div>

                <!-- Modal -->
                <div class="modal fade" id="articleModal<?php echo $article['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <img class="card-img-top" src="<?php echo  htmlspecialchars($imageSrc); ?>" alt="موسسه هفت هنر سیمرغ">
                                <p><?php echo "<p>". $article['text']. "</p>"; ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">

                <!-- Previous button -->
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">قبلی</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Page numbers -->
                <?php
                $startPage = max(1, $page - 1);
                $endPage = min($totalPages, $startPage + 2);
                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next button -->
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
            <p class="text-center">No articles found.</p>
        <?php endif; ?>
    </div>






   



  <!-- Bootstrap CSS -->
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- Bootstrap JS (Include after jQuery) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



  


     <?php
      include '../footer.php';
     ?>
  </body>
</html>

