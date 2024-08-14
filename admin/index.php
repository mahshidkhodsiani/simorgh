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

            <div class="col-md-8">

            <h3 style="text-align: center;">تازه ترین ها </h3>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table border border-4">
                        <h5>آخرین انتقاد و پیشنهادات :</h5>
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">ردیف</th>
                                    <th scope="col" class="text-center">متن پیام</th>
                                    <th scope="col" class="text-center">نوع</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            $sql = "SELECT * FROM suggestions ORDER BY id DESC LIMIT 5";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $a ?></th>
                                        <td class="text-center"><?= $row['text'] ?></td>
                                        <td class="text-center"><?= $row['type'] ?></td>
                                    </tr>
                                <?php
                                $a++;

                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6"></div>
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