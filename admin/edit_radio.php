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
    include '../config.php';
    // include 'functions.php';
    // include 'PersianCalendar.php';
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

            <?php
            if(isset($_GET['id_radio'])){
                $id_article = $_GET['id_radio'];
                $sql = "SELECT * FROM radio WHERE id = $id_article";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                }else{
                    echo "<h2 style= 'text-align: center'>چنین فایل ای پیدا نشد دوباره تلاش کنید !</h2>" ;
                }
                ?>

           
              
            <form action="" method="POST" id="articleForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-6">
                        <label for="title">نام برنامه:</label>
                        <input type="text" id="title" name="title" class="form-control mb-2" value="<?=$row['title']?>">

                        <label for="mp3">آپلود فایل صوتی:</label>
                        <?php if (!empty($row['file_path'])): ?>
                            <div class="mb-2">
                                <audio controls>
                                    <source src="<?= $row['file_path']; ?>" type="audio/mpeg">
                                    مرورگر شما از پخش فایل صوتی پشتیبانی نمی‌کند.
                                </audio>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="mp3" class="form-control" id="inputGroupFile02">
                    </div>
                    <div class="col-6">
                        <label for="kind">نوع برنامه:</label>
                        <input type="text" id="kind" name="kind" class="form-control mb-2" value="<?=$row['program_type']?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-success" type="submit" name="submit_post">ثبت تغییرات</button>
                    </div>
                </div>
            </form>




            
            <?php
                }else {
                echo "<h2 style= 'text-align: center'>هنوز مقاله ای انتخاب نکردید !</h2>" ;
            }
            ?>

                
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });

            // Initialize Summernote
            $('#summernote').summernote({
                hint: {
                    mentions: ['jayden', 'sam', 'alvin', 'david'],
                    match: /\B@(\w*)$/,
                    search: function(keyword, callback) {
                        callback($.grep(this.mentions, function(item) {
                            return item.indexOf(keyword) == 0;
                        }));
                    },
                    content: function(item) {
                        return '@' + item;
                    }
                }
            });

            // Transfer content from Summernote to hidden input field before form submission
            $('#articleForm').on('submit', function() {
                var summernoteContent = $('#summernote').summernote('code');
                $('#content').val(summernoteContent);
            });
        });
    </script>




</body>

</html>


<?php



if (isset($_POST['submit_post'])) {
    $title = $_POST['title'];
    $kind = $_POST['kind'];

    // Escape strings to prevent SQL injection
    $title = $conn->real_escape_string($title);
    $kind = $conn->real_escape_string($kind);

    $audioPath = '';

    // Handle the audio file upload
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

        // Ensure the upload directory exists
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        // Move the file to the target directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $audioPath = "upload/radios/2024/" . $newFileName; // Save the relative path for the database entry
            $fileUploaded = true;
        } else {
            echo "There was an error moving the uploaded file.";
            exit;
        }

        // Update query when an audio file is provided
        $stmt = $conn->prepare("UPDATE radio SET title = ?, program_type = ?, file_path = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $kind, $audioPath, $id_article);
    } else {
        // Update query when no audio file is provided
        $stmt = $conn->prepare("UPDATE radio SET title = ?, program_type = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $kind, $id_article);
    }

    // Execute the query
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
              برنامه با موفقیت ویرایش شد!
          </div>
        </div>
        <script>
        $(document).ready(function(){
            $('#successToast').toast({
                autohide: true,
                delay: 2000
            }).toast('show');
            setTimeout(function(){
                window.location.href = 'new_radio';
            }, 2000);
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
                خطایی در ویرایش برنامه پیش آمده!
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
    }

    $stmt->close();
}
