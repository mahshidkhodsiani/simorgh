<?php
session_start();
?>
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
  


 
    ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger p-4 text-center">
                        <div style="text-align: center; margin : 20px ">
                            <img src="images/tik.jpg" height="70px" width="70px" >
                        </div>
                        <h3 style="text-align: center; " class=""><span style="background-color: rgb(107, 165, 74);">رسید پرداختی</span></h3><p> پرداخت شما با موفقیت انجام شد.</p><p><br></p>
                            <p>مبلغ : <?= $row['amount']. " هزار تومان" ;?></p>
                        <p><br></p><p>به زودی کارشناسان ما در وقت اداری با شما تماس خواهند گرفت.</p><p>لطفا از رسید خود عکس بگیرید</p><p><br></p>
                        <button class="btn btn-success mt-3">در حال انتقال به صفحه اصلی</button>
                    </div>
                </div>
            </div>
        </div>



    <?php
 
    ?>
 

    <?php include 'footer.php'; ?>

</body>
</html>
