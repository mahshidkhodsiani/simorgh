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

              
                <form id="articleForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6">
                            <label for="title">عنوان دوره:</label>
                            <input type="text" id="title" name="title" class="form-control mb-2" placeholder="عنوان را اینجا وارد کنید">
                        </div>
                        <div class="col-6">
                            <label for="image">تصویر شاخص:</label>
                            <input type="file" name="image" class="form-control" id="inputGroupFile02">
                        </div>
                    </div>
                    
                    <div class="summernote" id="summernote"></div> 
                    <br>

                    <div class="row">
                        <div class="col-md-2 border">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radio" required>
                                <label class="form-check-label" for="radio">دوره</label>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-success" type="submit_radio">ثبت دوره</button>
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

    <script>
        $('.summernote').summernote({

            hint: {

                mentions: ['jayden','sam','alvin','david'],

                match: /\B@(\w*)$/,

                search:function (keyword, callback) {

                    callback($.grep(this.mentions,function (item) {

                        return item.indexOf(keyword) == 0;

                    }));

                },

                content:function (item) {

                    return '@' + item;

                }   

            }

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote();

            $('#articleForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get the content of Summernote and the title
                var articleContent = $('#summernote').summernote('code');
                var title = $('#title').val();
                var type = $('input[name="type"]:checked').val();
                var fileInput = $('#inputGroupFile02')[0].files[0];

                // Prepare FormData
                var formData = new FormData();
                formData.append('title', title);
                formData.append('content', articleContent);
                formData.append('type', type);
                if (fileInput) {
                    formData.append('image', fileInput);
                }

                // Send the data via POST request
                $.ajax({
                    url: 'submit_article.php', // Replace with your actual endpoint
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success
                        alert('مقاله با موفقیت ثبت شد');
                    },
                    error: function(error) {
                        // Handle error
                        alert('خطا در ثبت مقاله');
                    }
                });
            });
        });
    </script>


</body>

</html>