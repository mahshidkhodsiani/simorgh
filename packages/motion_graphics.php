<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>موشن گرافیک</title>
 
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
                        <img class="mx-auto d-block img-fluid" src="../images/motion-package.jpg" alt="پکیج موشن گرافیک" style="max-width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            <!-- <h4 class="card-title text-black"><?= $row['title'] ?></h4> -->
                            <br>
                            <div class="card-text custom-text">

                                <p><a href="https://simorghtv.com/" target="_blank">موسسه هفت هنر سیمرغ</a> با ارائه پکیج‌های <b>موشن گرافیک حرفه‌ای</b>، خدماتی ویژه در زمینه تولید محتوای تصویری و انیمیشنی ارائه می‌دهد.<span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">این پکیج‌ها شامل طراحی و تولید موشن گرافیک‌های خلاقانه، با کیفیت بالا و متناسب با نیازهای کسب و کار شما می‌باشد.</span></p><p><strong style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align);">پکیج موشن گرافیک</strong><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);"> موسسه هفت هنر سیمرغ، ابزار قدرتمندی برای افزایش تعامل کاربران و جذابیت بصری محتوای شما است. با استفاده از این پکیج‌ها می‌توانید پیام خود را به صورت داستانی جذاب و بصری به مخاطبان منتقل کنید و برند خود را از رقبا متمایز سازید. همچنین، این موشن گرافیک‌ها با بهره‌گیری از تکنیک‌های روز دنیا، بهینه‌سازی شده برای سئو و قابل استفاده در تمامی پلتفرم‌های دیجیتال هستند.</span></p><p>اگر به دنبال راهی برای بهبود حضور آنلاین و جذب مخاطبان بیشتر هستید، پکیج‌های موشن گرافیک موسسه هفت هنر سیمرغ، انتخابی ایده‌آل برای شما خواهد بود. ما با تیمی مجرب و متخصص در زمینه موشن گرافیک، آماده‌ایم تا بهترین خدمات را به شما ارائه دهیم و محتوای تصویری شما را به سطحی بالاتر ارتقا دهیم.</p><p><br></p>

                                
                                <form action="dargah" method="post">
                                    <button name="package-motion" class="btn mb-2 mb-md-0 btn-outline-quarternary ">خرید پکیج</button>
                                    <input type="hidden" name="packages">
                                </form>

                            </div>
                            <h1 class="mt-4">نمونه کارها</h1>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <video class="w-100" controls>
                                        <source src="../upload/videos/2024/motion1.mp4" type="video/mp4">
                                        تیزر تبلیغاتی 1 موسسه سیمرغ
                                    </video>
                                </div>
                            
                            </div>

                            <br>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
 

    <?php include 'footer.php'; ?>



</body>
</html>
