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

            <?php
            if(isset($_GET['id_photo'])){
                $id_article = $_GET['id_photo'];
                $sql = "SELECT * FROM gallery WHERE id = $id_article";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                }else{
                    echo "<h2 style= 'text-align: center'>چنین مقاله ای پیدا نشد دوباره تلاش کنید !</h2>" ;
                }
                ?>

           
              
            <form action="" method="POST" id="articleForm" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-6">
                        <label for="title">عنوان مقاله:</label>
                        <input type="text" id="title" name="title" class="form-control mb-2" value="<?= $row['title']; ?>">
                    </div>
                    <div class="col-6">
                        <label for="image">تصویر شاخص:</label>
                        <input type="file" name="image" class="form-control" id="inputGroupFile02">
                        <!-- Check if there's an image in the database and display it -->
                        <?php if (!empty($row['images'])): ?>
                            <div class="mb-2">
                                <img src="<?= $row['images']; ?>" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        <?php endif; ?>
                        <!-- Upload new image -->
                    </div>
                </div>

                <input type="hidden" name="content" id="content">
                <br>

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
    $sql = "UPDATE gallery SET title = '$title' WHERE id = '$id_article'";
    $result = $conn->query($sql);
   

    if ($result) {
        // Success Toast
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
          <div class='toast-header bg-success text-white'>
              <strong class='mr-auto'>Success</strong>
              <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
              </button>
          </div>
          <div class='toast-body'>
              پست شما با موفقیت ویرایش شد!
          </div>
        </div>
        <script>
        $(document).ready(function(){
            $('#successToast').toast({
                autohide: true,
                delay: 2000
            }).toast('show');
            setTimeout(function(){
                window.location.href = 'new_pic';
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
                خطایی در ویرایش پست پیش آمده!
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
            Error: " . $conn->error . "
            </div>";
    }


}



