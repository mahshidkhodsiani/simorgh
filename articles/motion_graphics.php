<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>
    
    <!-- Uncomment the Google Fonts link if needed -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> -->

    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">
</head>
<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();
    ?>

  
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <img class="mx-auto d-block img-fluid" src="../images/logo2.jpg" alt="موسسه هفت هنر سیمرغ" style="max-width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            <!-- <h4 class="card-title text-black"><?= $row['title'] ?></h4> -->
                            <br>
                            <div class="card-text custom-text">
                                <h2 class="text-center">تبلیغات کسب و کار شما به شیوه ساخت تیزر موشن گرافیک</h2>
                                <p>در این نوع تبلیغات شما خلاصه ای از کسب و کارتان را به ما ارائه میدهید و تیم های تخصصی ما با نوشتن <b>سناریو</b> و تایید شما شروع به ساخت تیزر میکنند.</p>
                                <p>شما میتوانید از هرکجای کشور که باشید به ما سفارش دهید ما در کمترین زمان ممکن <b>تیزر</b> شمارا آماده کرده و با کیفیت بالا برایتان ارسال میکنیم</p>
                                <p><br></p>
                                <p>مزایای این نوع تبلیغات:</p>
                                <h6 class="">صرفه جویی در زمان</h6>
                                <h6 class="">کاملا غیر حضوری</h6>
                                <h6 class="">امکان ویرایش مجدد</h6>
                                <p><br></p>
                                <p>بهمراه نریشن با گوینده های خوش صدا جهت دیده شدن و جذب بیشتر مخاطب</p>
                                <p >جهت سفارش و مشاوره بیشتر تماس بگیرید:</p>
                                <p dir="rtl" style="margin-right: 0; margin-left: 0; color: rgb(33, 37, 41); font-family: Verdana;">
                                    <span style="font-size: 11pt; font-family: Calibri, sans-serif;">
                                        <span style="font-size: 16pt; background-color: rgb(155 89 173)">
                                        تلفن : ۰۲۱۸۸۳۴۱۶۵۲
                                        </span>
                                    </span>
                                </p>

                                <p dir="rtl" style="margin-right: 0; margin-left: 0; color: rgb(33, 37, 41); font-family: Verdana;">
                                    <span style="font-size: 11pt; font-family: Calibri, sans-serif;">
                                        <span style="font-size: 16pt; background-color: rgb(155 89 173)">
                                        واتساپ : ۰۹۳۵۴۶۳۷۰۵۵
                                        </span>
                                    </span>
                                </p>
                            </div>
                            <h1 class="mt-4">نمونه کارها</h1>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <video class="w-100" controls>
                                        <source src="../upload/videos/2024/motion1.mp4" type="video/mp4">
                                        تیزر تبلیغاتی 1 موسسه سیمرغ
                                    </video>
                                </div>
                                <div class="col-12 col-md-6">
                                    <video class="w-100" controls>
                                        <source src="../upload/videos/2024/motion2.mp4" type="video/mp4">
                                        تیزر تبلیغاتی 2 موسسه سیمرغ
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 

    <?php include 'footer.php'; ?>



</body>
</html>
