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
                        <label for="title">نام برنامه:</label>
                        <input type="text" id="title" name="title" class="form-control mb-2" placeholder="عنوان را اینجا وارد کنید" required>

                        <label for="mp3">اپلود فایل صوتی:</label>
                        <input type="file" name="mp3" class="form-control" id="inputGroupFile02">
                    </div>
                    <div class="col-6">
                        <label for="kind">نوع برنامه:</label>
                        <input type="text" id="kind" name="kind" class="form-control mb-2" placeholder="عنوان را اینجا وارد کنید" required>
                    </div>
                </div>

                <br>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-success" type="submit" name="submit_radio">ثبت برنامه</button>
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


if (isset($_POST['submit_radio'])) {
  

    // Get form data
    $title = $_POST['title'];
    $programType = $_POST['kind']; // Field name for 'نوع برنامه'

    // Handle mp3 file upload
    $fileUploaded = false;
    $dest_path = null;

    if (isset($_FILES['mp3']) && $_FILES['mp3']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['mp3']['tmp_name'];
        $fileName = $_FILES['mp3']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory in which to save the uploaded file
        $uploadFileDir = '../upload/radios/2024/';
        $dest_path = $uploadFileDir . $newFileName;

        // Move the file to the target directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $fileUploaded = true;
        } else {
            echo "There was an error moving the uploaded file.";
        }
    }


    $sql = "INSERT INTO radio (title, program_type, file_path) VALUES('$title', '$programType', '$dest_path')";

    $result = $conn->query($sql);

    if ($result){

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
                    window.location.href = 'new_radio';
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


}
?>
