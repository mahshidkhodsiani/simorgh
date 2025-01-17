<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سینما فوری و سه بعدی</title>
    

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
                                <h2 class="text-center">سه بعدی و سینما فوری</h2>
                                <p>سینما فوردی یکی از محبوب‌ترین و پرطرفدارترین نرم‌افزار ساخت تیزر های سه‌بعدی به حساب می‌آید. با کمک سینما فوردی می‌توانیم در حوزه انیمیشن‌سازی، مدلینگ، ساخت موشن‌گرافیک، ساخت تیزر تبلیغاتی و موارد مشابه تولید محتوا بسازیم.<br><br>تیزرهای سه بعدی و سینمافوردی به دلیل هزینه بر بودن تولیدشان بیشتر جهت ساخت پیام های بازرگانی برای تلویزیون و پلتفرم های حرفه ای ساخته میشوند.<br>تبلیغات با روش سه بعدی و سینما فوردی باعت بهتر دیده شدن جزئیات و حرفه ای بودن کسب و کار شمارا نشان میدهد.<br>تیم های سه بعدی کار و سینمافوردی کاران موسسه سیمرغ متشکل از چندین گرافیک کار حرفه ای پس از دریافت اطلاعات و سناریونویسی در کمترین زمان شروع به ساخت تیزر شما میکنند.<br><br>هرنوع کسب و کاری که دارید ما میتوانیم محصولات شمارا مدل سازی کرده و در ساخت تبلیغات از همون مدل منحصر بفرد خودتان استفاده کنیم.<br></p>
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
                                        <source src="../upload/videos/2024/3d1.mp4" type="video/mp4">
                                        تیزر تبلیغاتی 1 موسسه سیمرغ
                                    </video>
                                </div>
                                <div class="col-12 col-md-6">
                                    <video class="w-100" controls>
                                        <source src="../upload/videos/2024/3d2.mp4" type="video/mp4">
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
