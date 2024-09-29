<!doctype html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وبلاگ سیمرغ</title>
  
    
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> -->


    <link rel="stylesheet" href="../fonts/icomoon/style.css">

    <link rel="stylesheet" href="../css/owl.carousel.min.css">


    <link rel="stylesheet" href="../css/bootstrap.min.css">
    

    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="../css/mainstyles.css">
    
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

    // Count total number of results from the gallery table
    $countSql = "SELECT COUNT(*) as total FROM gallery";  // Changed to 'gallery'
    $countResult = $conn->query($countSql);
    $totalCount = $countResult->fetch_assoc()['total'];
    
    // Calculate total pages
    $totalPages = ceil($totalCount / $articlesPerPage);
    
    // Get current page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $articlesPerPage;
    
    // Query with LIMIT and ORDER BY for pagination and descending order
    $sql = "SELECT * FROM gallery ORDER BY id DESC LIMIT $offset, $articlesPerPage";  
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
                            // Decode the JSON to access the media URLs
                            $images = $article['images'];
                            $imageData = json_decode($images, true);

                            // Determine the media source
                            if (json_last_error() === JSON_ERROR_NONE && is_array($imageData)) {
                                $mediaSrc = $imageData['thumb']; // Use 'thumb' or choose 'original', '300', '600', '900'
                            } else {
                                $mediaSrc = $images;
                            }

                            // Check if the path starts with "../"
                            if (strpos($mediaSrc, '../') === 0) {
                                $mediaPath = htmlspecialchars($mediaSrc);
                            } else {
                                $mediaPath = "../" . htmlspecialchars($mediaSrc);
                            }

                            // Determine if the file is a video or an image based on its extension
                            $fileExtension = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
                            $isVideo = in_array($fileExtension, ['mp4', 'mov', 'avi', 'mkv', 'm4v']); // Add more video formats if needed

                            // Check the file type (video or image)
                            if ($isVideo) {
                                // Display video element
                                echo '<video class="card-img-top" controls>
                                        <source src="' . $mediaPath . '" type="video/mp4">
                                        مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                    </video>';
                            } else {
                                // Display image element
                                echo '<img class="card-img-top" src="' . $mediaPath . '" alt="موسسه هفت هنر سیمرغ">';
                            }
                            ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#articleModal<?php echo $article['id']; ?>">دیدن بیشتر</button>
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
                                    <?php
                                    if ($isVideo) {
                                        // Display video in the modal
                                        echo '<video class="card-img-top" controls width="100%">
                                                <source src="' . $mediaPath . '" type="video/mp4">
                                                مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                            </video>';
                                    } else {
                                        // Display image in the modal
                                        echo '<img class="card-img-top" src="' . $mediaPath . '" alt="موسسه هفت هنر سیمرغ" width="100%">';
                                    }
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination code here -->

        <?php else: ?>
            <p class="text-center">نمونه کاری یافت نشد!</p>
        <?php endif; ?>
    </div>








<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



  


     <?php
      include '../footer.php';
     ?>
  </body>
</html>

