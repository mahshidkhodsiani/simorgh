<!doctype html>
<html lang="en" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>
  
    
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> -->


    <link rel="stylesheet" href="../fonts/icomoon/style.css">

    <link rel="stylesheet" href="../css/owl.carousel.min.css">


    <link rel="stylesheet" href="../css/bootstrap.min.css">
    

    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="../css/mainstyles.css">

  
  </head>
  <body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();


    if(isset($_GET['title']) && $_GET['title'] != ''){

      $title = $_GET['title'];
      $sql = "SELECT * FROM articles WHERE title LIKE '%$title%'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          $counter = 0;
          while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
          }
      }


    }

    
    ?>


   



    <div class="container mt-5">
      <h1 class="text-center">Search Results for "<?php echo htmlspecialchars($title); ?>"</h1>
      <?php if (!empty($articles)): ?>
          <div class="row">
              <?php foreach ($articles as $article): ?>
                  <div class="col-md-4">
                      <div class="card mb-4 shadow-sm">
                          <div class="card-body">
                              <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
                              <p class="card-text"><?php echo htmlspecialchars(substr($article['description'], 0, 100)); ?>...</p>
                              <a href="article.php?id=<?php echo $article['id']; ?>" class="btn btn-primary">Read More</a>
                          </div>
                      </div>
                  </div>
              <?php endforeach; ?>
          </div>
      <?php else: ?>
          <p class="text-center">No articles found.</p>
      <?php endif; ?>
    </div>



   





  


     <?php
      include '../footer.php';
     ?>
  </body>
</html>

