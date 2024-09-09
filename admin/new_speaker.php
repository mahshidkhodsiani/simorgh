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


    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';
    // include 'functions.php';
    // include 'PersianCalendar.php';
    ?>
    <!-- <link rel="stylesheet" href="styles.css"> -->





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

            
              
            <form id="articleForm" enctype="multipart/form-data" method="POST" class="border p-2">
                <div class="row">
                    <div class="col-6">
                        <label for="name">نام و نام خانوادگی گوینده:</label>
                        <input type="text" id="name" name="name" class="form-control mb-2" 
                            placeholder="نام و نام خانوادگی را اینجا وارد کنید" required>

                        <label for="mp3">اپلود صدا:</label>
                        <input type="file" name="mp3" class="form-control" id="inputGroupFile02">
                    </div>
                    <div class="col-6">
                        <label for="kind">نوع صدا:</label>
                        <input type="text" id="kind" name="kind" class="form-control mb-2" placeholder="نوع صدا" required>

                        <label for="image">اپلود عکس:</label>
                        <input type="file" name="image" class="form-control" id="inputGroupFile02">
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-success" type="submit" name="submit_speaker">ثبت برنامه</button>
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

    <script>
        function toggleCheckbox(checkedId, uncheckedId) {
            var checkedBox = document.getElementById(checkedId);
            var uncheckedBox = document.getElementById(uncheckedId);
            if (checkedBox.checked) {
                uncheckedBox.checked = false;
            }
        }
    </script>




</body>

</html>

<?php


if (isset($_POST['submit_speaker'])) {
    // Get form data
    $name = $_POST['name']; // Field name for 'نام و نام خانوادگی گوینده'
    $programType = $_POST['kind']; // Field name for 'نوع صدا'

    // Escape form data to prevent SQL injection
    $name = $conn->real_escape_string($name);
    $programType = $conn->real_escape_string($programType);

    // Handle mp3 file upload
    $mp3Uploaded = false;
    $mp3DestPath = null;

    if (isset($_FILES['mp3']) && $_FILES['mp3']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['mp3']['tmp_name'];
        $fileName = $_FILES['mp3']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory in which to save the uploaded file
        $uploadMp3Dir = '../upload/radios/2024/';
        $mp3DestPath = $uploadMp3Dir . $newFileName;

        // Ensure the directory exists
        if (!file_exists($uploadMp3Dir)) {
            mkdir($uploadMp3Dir, 0777, true);
        }

        // Move the file to the target directory
        if (move_uploaded_file($fileTmpPath, $mp3DestPath)) {
            $mp3Uploaded = true;
        } else {
            echo "There was an error moving the uploaded mp3 file.";
        }
    }

    // Handle image upload with dynamic directory based on speaker's name
    $imageUploaded = false;
    $imageDestPath = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageNameCmps = explode(".", $imageName);
        $imageExtension = strtolower(end($imageNameCmps));

        // Sanitize image file name
        $newImageFileName = '1.' . $imageExtension; // Use '1' as the base file name

        // Directory for image upload using the speaker's name
        $speakerDir = '../upload/sounds/' . $name . '/';

        // Ensure the directory exists, creating it if necessary
        if (!file_exists($speakerDir)) {
            mkdir($speakerDir, 0777, true);
        }

        // Destination path for the uploaded image
        $imageDestPath = $speakerDir . $newImageFileName;

        // Move the image file to the target directory
        if (move_uploaded_file($imageTmpPath, $imageDestPath)) {
            $imageUploaded = true;
        } else {
            echo "There was an error moving the uploaded image file.";
        }
    }

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO speakers (name, kind, mp3, image) VALUES(?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $programType, $mp3DestPath, $imageDestPath);

    if ($stmt->execute()) {
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    فایل شما با موفقیت ثبت شد!
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast({
                    autohide: true,
                    delay: 3000
                }).toast('show');
                setTimeout(function(){
                    window.location.href = 'new_speaker';
                }, 3000);
            });
            </script>";
    } else {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در افزودن فایل پیش آمده!
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

