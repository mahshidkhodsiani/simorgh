<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
// $admin = $_SESSION["all_data"]['admin'];
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
    // include 'config.php';
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
include "../config.php";

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
    $stmt = $conn->prepare("INSERT INTO gallery (title, images, created_at) VALUES (?, ?,  NOW())");
    $stmt->bind_param("ss", $title, $imagePath);



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
?>
