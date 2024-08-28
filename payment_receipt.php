<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درباره هفت هنر سیمرغ</title>

   

    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mainstyles.css">

    <link rel="icon" href="images/logo1.ico" type="image/x-icon">
</head>
<body>

    <?php
    include 'header.php';
    include 'config.php';
    include 'PersianCalendar.php';
    include 'jalaliDate.php';
    $sdate = new SDate();

    if(isset($_SESSION['new_id'])){

 
    ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger p-4 text-center">
                        <h2 class="">اطلاعات شما به درستی ذخیره شد و شما ثبت نام شدید. از این صفحه اسکرین شات بگیرید</h2>
                        <button class="btn btn-success mt-3">در حال انتقال به صفحه اصلی</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Redirect to user_voice.php after 3 seconds
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 5000);
        </script>

        <?php
    }else{
        echo "<h1 style='text-align : center'>". "هنوز ثبت نام نکردید" ."</h1>"; ;
    }
    ?>
 

    <?php include 'footer.php'; ?>

</body>
</html>
