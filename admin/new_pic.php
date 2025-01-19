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

    ?>





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

            <h2>افزودن تصویر به گالری</h2>
            
              
            <form action="" enctype="multipart/form-data" method="POST" class="border p-2">
                <div class="row">
                    <div class="col-6">
                        <label for="title">عنوان تصویر:</label>
                        <input type="text" id="title" name="title" class="form-control mb-2" placeholder="عنوان را اینجا وارد کنید" required>

                    
                    </div>
                    <div class="col-6">
                        <label for="pic">اپلود فایل صوتی:</label>
                        <input type="file" name="pic" class="form-control" id="" required>
                    </div>
                  
                </div>

                <br>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-success" type="submit" name="submit_pic">ثبت در گالری</button>
                    </div>
                </div>
            </form>

            <br>





                
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

if (isset($_POST['submit_pic'])) {
    $title = $_POST['title'];
    $pic = $_FILES['pic']['name'];
    $tmp_name = $_FILES['pic']['tmp_name'];

    // تعیین مسیر پایه پوشه
    $baseDir = '../uploads/gallery/';
    $uploadDir = $baseDir . '1'; // شروع از پوشه 1

    // پیدا کردن شماره پوشه بعدی
    $folderIndex = 1;
    while (is_dir($uploadDir)) {
        $folderIndex++;
        $uploadDir = $baseDir . $folderIndex;
    }

    // ساخت پوشه جدید
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // مسیر کامل فایل
    $path = $uploadDir . '/' . $pic;

    // آپلود فایل
    if (move_uploaded_file($tmp_name, $path)) {
        // استفاده از پرسش‌های آماده‌شده
        $stmt = $conn->prepare("INSERT INTO gallery (title, images, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $title, $path);

        if ($stmt->execute()) {
            echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; top: 20px; right: 20px; width: 300px; z-index: 1055;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>Success</strong>
            </div>
            <div class='toast-body'>
                با موفقیت انجام شد!
            </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#successToast').toast({
                        autohide: true,
                        delay: 3000
                    }).toast('show');
                    setTimeout(function(){
                        window.location.href = 'new_pic';
                    }, 3000);
                });
            </script>";
        } else {
            echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; top: 20px; right: 20px; width: 300px; z-index: 1055;'>
            <div class='toast-header bg-danger text-white'>
                <strong class='mr-auto'>Error</strong>
            </div>
            <div class='toast-body'>
                خطایی رخ داده، دوباره امتحان کنید!<br>Error: " . htmlspecialchars($stmt->error) . "
            </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#errorToast').toast({
                        autohide: true,
                        delay: 3000
                    }).toast('show');
                    setTimeout(function(){
                        window.location.href = 'new_pic';
                    }, 3000);
                });
            </script>";
        }

        $stmt->close();
    } else {
        echo "<div id='errorToast' class='toast'>خطا در آپلود فایل!</div>";
    }
}
