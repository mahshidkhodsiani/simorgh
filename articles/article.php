<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وبلاگ سیمرغ</title>

    <meta name="description" content="آموزش فن بیان، گویندگی، بازیگری، طراحی سایت، موشن گرافیک و هنرهای فرهنگی در موسسه سیمرغ. بهترین دوره‌های هنری و فرهنگی برای علاقه‌مندان به خلاقیت.">
    <meta name="keywords" content="فن بین و گویندگی , بازیگری , طراحی سایت , موشن گرافیک , آموزش , فرهنگی هنری , هنر">
    <meta name="author" content="سیمرغ">
   

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
</head>
<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();


    if (isset($_GET['a']) AND $_GET['a'] != ''){
        $a = $_GET['a'];
        $sql = "SELECT * FROM articles WHERE title = '$a'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        ?>




        <hr class="mt-4">
        <br>
        <br>


        <div class="container mt-4">
            <div class="row justify-content-center" style="margin-top: 100px; ">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <h2 class="d-flex justify-content-center mt-2"><?=$row['title'] ?></h2>
                        <img src="../<?=$row['images']?>" class="img-fluid" alt="وبلاگ موسسسه فرهنگی هنری سیمرغ">
                        <br>

                        <div class="card-body">
                            <p>تاریخ انتشار: <?= mds_date("l j F Y", strtotime($row['created_at'])) ?></p>
                            <div class="card-text custom-text" style="text-align: center;">             
                                <p class="card-text"><?= $row['body'] ?></p>

                                <br>
                                <p style="color: #621e52;">جهت کسب اطلاعات بیشتر و شرکت دردوره ها با ما در ارتباط باشید.:</p>
                                <p style="color: #621e52;">تلفن: 02188341652</p>
                                <p style="color: #621e52;">واتساپ : 093554637055</p>
                                <a href="../register.php" class="btn mb-2 mb-md-0 btn-outline-quarternary">ثبت نام در دوره ها</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }else{
        echo  '<hr class="mt-4">';
        echo '<h1>مقاله ای یافت نشد!</h1>';
        echo "<a href='../'>بازگشت</a>";
    }

   
   include 'footer.php'; 
   ?>

</body>
</html>
