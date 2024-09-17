<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
// $admin = $_SESSION["all_data"]['admin'];

// header("Cache-Control: public, max-age=31536000"); // Cache for 1 year
// header("Pragma: cache");

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خانه</title>


    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';
    // include 'functions.php';
    // include 'PersianCalendar.php';
    ?>
    <!-- <link rel="stylesheet" href="styles.css"> -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="../summernote-0.8.20-dist/cdn/jquery.min.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-bs5.css" />

    <script src="../summernote-0.8.20-dist/summernote-bs5.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-bs4.css" />

    <script src="../summernote-0.8.20-dist/summernote-bs4.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote.css" />

    <script src="../summernote-0.8.20-dist/summernote.js"></script>

    <link rel="stylesheet" href="../summernote-0.8.20-dist/summernote-lite.css" />

    <script src="../summernote-0.8.20-dist/summernote-lite.js"></script>

    <script src="../summernote-0.8.20-dist/lang/summernote-es-ES.js"></script>


</head>

<body>

   

<?php include 'header.php'; ?>
    <div class="container-fluid">


        <div class="row">
            <div class="col-md-3 d-flex">
                <?php
                include 'sidebar.php';
                ?>
              
            </div>

            <div class="col-md-8 mt-5">

              
                <form action="" id="articleForm" method="POST" enctype="multipart/form-data" class="border p-4">
                    <div class="row">
                        <div class="col-6">
                            <label for="title">عنوان تصویر:</label>
                            <input type="text" id="title" name="title" class="form-control mb-2" placeholder="عنوان را اینجا وارد کنید" required>
                        </div>
                        <div class="col-6">
                            <label for="image">تصویر شاخص:</label>
                            <input type="file" name="image" class="form-control" id="inputGroupFile02" required>
                        </div>
                    </div>
                    
                

                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="image">تصویر یا ویدیو :</label>
                            <select class="form-control" name="type">
                                <option value="">انتخاب کنید</option>
                                <option value="photo">عکس</option>
                                <option value="video">ویدیو</option>
                            </select>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-md-2 border">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" value="gallery" id="gallery" required>
                                <label class="form-check-label" for="gallery">نمونه کار</label>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-success" type="submit" name="submit_gallery">ثبت نمونه کار</button>
                        </div>
                    </div>
                </form>


                <div class="row mt-5">
                    <div class="col-md-11">
                        <div class="table-responsive">
                            <?php
                            // Pagination configuration
                            $items_per_page = 10; // Number of items per page
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                            // Calculate the offset for the SQL query
                            $offset = ($current_page - 1) * $items_per_page;

                            // SQL query to retrieve a subset of rows based on pagination
                            $sql = "SELECT * FROM gallery ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                            ?>
                                <table class="table border border-4">
                                    <h4>آخرین مقالات :</h4>
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">ردیف</th>
                                            <th scope="col" class="text-center">عنوان</th>
                                            <th scope="col" class="text-center">رسانه</th>
                                            <th scope="col" class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {

                                            $images = $row['images'];

                                            // Attempt to decode the JSON string
                                            $imageData = json_decode($images, true);

                                            // Check if decoding was successful (i.e., it's JSON)
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($imageData)) {
                                                $mediaSrc = $imageData['thumb']; // Use 'thumb' or another size if necessary
                                            } else {
                                                // It's a simple string (path to the image/video)
                                                $mediaSrc = $images;
                                            }

                                            // Check if the path starts with "../"
                                            if (strpos($mediaSrc, '../') === 0) {
                                                $mediaPath = htmlspecialchars($mediaSrc);
                                            } else {
                                                $mediaPath = "../" . htmlspecialchars($mediaSrc);
                                            }

                                            // Determine if the media is a video or an image
                                            $fileExtension = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
                                            $isVideo = in_array($fileExtension, ['mp4', 'mov', 'avi', 'mkv', 'm4v']); // Add more video formats if needed

                                            ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $a ?></th>
                                                <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                                <td class="text-center">
                                                    <?php if ($isVideo): ?>
                                                        <!-- Display video if it's a video file -->
                                                        <video height="50px" controls>
                                                            <source src="<?= $mediaPath ?>" type="video/mp4">
                                                            مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                                        </video>
                                                    <?php else: ?>
                                                        <!-- Display image if it's an image file -->
                                                        <img src="<?= $mediaPath ?>" height="50px">
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <form action="" method="GET">
                                                        <input type="hidden" value="<?= $row['id'] ?>" name="id_photo">
                                                        <a href="edit_work.php?id_photo=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm"> ویرایش</a>
                                                        <button type="submit" name="delete_photo" 
                                                            class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">حذف</button>
                                                    </form>
                                                </td>
                                                <script>
                                                    function confirmDelete() {
                                                        return confirm("آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟");
                                                    }
                                                </script>
                                            </tr>
                                        <?php
                                            $a++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <?php
                                // Pagination logic
                                $sql = "SELECT COUNT(*) AS total FROM gallery";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $total_items = $row['total'];
                                $total_pages = ceil($total_items / $items_per_page);

                                $start_page = max(1, $current_page - 1); // Start at the current page - 1 or 1 if the current page is 1
                                $end_page = min($total_pages, $start_page + 2); // Show 3 pages max

                                // Ensure there are always 3 pages in the pagination unless it's at the beginning or end
                                if ($end_page - $start_page < 2 && $start_page > 1) {
                                    $start_page = max(1, $end_page - 2);
                                }
                                ?>

                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <!-- Previous Button -->
                                        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                        </li>

                                        <?php
                                        // Page Numbers
                                        for ($i = $start_page; $i <= $end_page; $i++) {
                                        ?>
                                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php
                                        }
                                        ?>

                                        <!-- Next Button -->
                                        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                        </li>
                                    </ul>
                                </nav>

                            <?php
                            } else {
                                echo "<p>هیچ مشابهی پیدا نشد.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>




                
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });
        });

    </script>

    

</body>

</html>


<?php


if (isset($_POST['submit_gallery'])) {
    $title = $_POST['title'];
    // $content = $_POST['content'];
    $type = $_POST['type'];

    // Ensure the title, content, and type are properly escaped to prevent SQL injection
    $title = $conn->real_escape_string($title);
    // $content = $conn->real_escape_string($content);
    $type = $conn->real_escape_string($type);

    $imagePath = '';

    // Handle the file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../upload/images/2024/';
        $originalFileName = basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $originalFileName;

        // Ensure the upload directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile; // Save the path for the database entry
        } else {
            echo "Failed to upload file.";
            exit;
        }
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO gallery (title, images, type, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $title, $imagePath, $type); // Bind all parameters including type



    if ($stmt->execute()) {
        // Success Toast
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    پست شما با موفقیت ثبت شد!
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast({
                    autohide: true,
                    delay: 3000
                }).toast('show');
                setTimeout(function(){
                    window.location.href = 'new_work';
                }, 3000);
            });
            </script>";
    } else {
        // Error Toast
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در افزودن پست پیش آمده!
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#errorToast').toast({
                    autohide: true,
                    delay: 3000
                }).toast('show');
                setTimeout(function(){
                    $('#errorToast').toast('hide');
                }, 3000);
            });
            </script>";

        echo "<div class='alert alert-danger mt-2' role='alert'>
                Error: " . $stmt->error . "
            </div>";
    }

    $stmt->close();
}




if(isset($_GET['delete_photo'])){

    $id_photo = $_GET['id_photo'];

    $sql = "DELETE FROM gallery WHERE id = $id_photo";
    $result = $conn->query($sql);
    if ($result) {
        // Use Bootstrap's toast component to show a success toast message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>Success</strong>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='toast-body'>
                تصویر با موفقیت حذف شد!
            </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast('show');
                setTimeout(function(){
                    $('#successToast').toast('hide');
                    // Redirect after 3 seconds
                    setTimeout(function(){
                        window.location.href = 'new_work';
                    }, 1000);
                }, 1000);
            });
            </script>";
    } else {
        // Use Bootstrap's toast component to show an error toast message
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در حذف تصویر پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){
                        $('#errorToast').toast('hide');
                    }, 1000);
                });
              </script>";

        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}