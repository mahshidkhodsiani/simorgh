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
              
                // Prepare and execute the SQL query
                $sql ="SELECT * from sounds";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<audio controls>';
                        echo    '<source src="data:audio/mpeg;base64,'.base64_encode($row['file_data']).'">';
                        echo '</audio><br>';
                    }
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
        });

    </script>

    

</body>

</html>


