<?php
session_start();
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درباره هفت هنر سیمرغ</title>

   

    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
</head>
<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();
    if(isset($_SESSION['invoice'])){
 
    ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger p-4 text-center">
                        <h2 style="text-align: center; " class=""><span style="background-color: rgb(107, 165, 74);">رسید پرداختی</span></h2><p>با سپاس .پرداخت شما با موفقیت انجام شد.</p><p><br></p>
                            <p>مبلغ : <?= $_SESSION['amount']?></p>
                        <p><br></p><p>در اولین فرصت همکاران ما با شما تماس خواهند گرفت.</p><p>لطفا از رسید خود عکس بگیرید</p><p><br></p>
                        <button class="btn btn-success mt-3">در حال انتقال به صفحه اصلی</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Redirect to user_voice.php after 3 seconds
            setTimeout(function() {
                window.location.href = 'user_voice.php';
            }, 10000);
        </script>

    <?php
    }else{
        echo "<h1 style='text-align : center'>". "هنوز ثبت نام نکردید" ."</h1>"; ;
    }
    ?>
 

    <?php include 'footer.php'; ?>

</body>
</html>
