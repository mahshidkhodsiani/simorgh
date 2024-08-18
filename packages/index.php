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

    $sql = "SELECT * FROM articles WHERE title LIKE '%درباره موسسه%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $counter = 0;
        while ($row = $result->fetch_assoc()) {
    ?>
       <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">


                        <div class="card-body" dir="rtl" style="text-align: right;">
                        <h3>پکیج های آموزشی</h3>
                        <p>اگر به دنبال پکیج‌های آموزشی جامع و کاربردی برای ارتقاء مهارت‌های خود هستید، موسسه سیمرغ بهترین گزینه برای شماست. پکیج‌های آموزشی ما با هدف ارائه آموزش‌های حرفه‌ای و به روز در حوزه‌های مختلف طراحی شده‌اند تا به شما کمک کنند تا به بهترین نحو ممکن به اهداف خود برسید.<br></p>

                        <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" src="../images/motion-package.jpg" alt="پکیج موشن گرافیک">
                                        <div class="card-body">
                                            <h4 class="card-title">موشن گرافیک</h4>
                                            <p class="card-text">اگر به دنبال راهی برای بهبود حضور آنلاین و جذب مخاطبان بیشتر هستید،
                                                 پکیج‌های موشن گرافیک موسسه هفت هنر سیمرغ، انتخابی ایده‌آل برای شما خواهد بود.</p>
                                            <a href="motion_graphics" class="btn btn-primary">خرید پکیج</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" src="../images/packages.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">انیمیشن سازی (موهو)</h5>
                                            <p class="card-text">
                                                محتوای پکیج‌های آموزشی ما توسط کارشناسان و متخصصان برجسته طراحی شده است. با استفاده از منابع و متدهای آموزشی به روز، می‌توانید از یادگیری عمیق و کاربردی بهره‌مند شوید.</p>
                                            <a href="#" class="btn btn-primary">خرید پکیج</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" src="../images/packages.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">فتوشاپ</h5>
                                            <p class="card-text">
                                                محتوای پکیج‌های آموزشی ما توسط کارشناسان و متخصصان برجسته طراحی شده است. با استفاده از منابع و متدهای آموزشی به روز، می‌توانید از یادگیری عمیق و کاربردی بهره‌مند شوید.</p>
                                            <a href="#" class="btn btn-primary">خرید پکیج</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" src="../images/packages.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">پریمر (تدوین)</h5>
                                            <p class="card-text">
                                                محتوای پکیج‌های آموزشی ما توسط کارشناسان و متخصصان برجسته طراحی شده است. با استفاده از منابع و متدهای آموزشی به روز، می‌توانید از یادگیری عمیق و کاربردی بهره‌مند شوید.</p>
                                            <a href="#" class="btn btn-primary">خرید پکیج</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" src="../images/packages.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">ایلیستراتور</h5>
                                            <p class="card-text">
                                                محتوای پکیج‌های آموزشی ما توسط کارشناسان و متخصصان برجسته طراحی شده است. با استفاده از منابع و متدهای آموزشی به روز، می‌توانید از یادگیری عمیق و کاربردی بهره‌مند شوید.</p>
                                            <a href="#" class="btn btn-primary">خرید پکیج</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" src="../images/packages.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">ایندیزاین</h5>
                                            <p class="card-text">
                                                محتوای پکیج‌های آموزشی ما توسط کارشناسان و متخصصان برجسته طراحی شده است. با استفاده از منابع و متدهای آموزشی به روز، می‌توانید از یادگیری عمیق و کاربردی بهره‌مند شوید.</p>
                                            <a href="#" class="btn btn-primary">خرید پکیج</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" src="../images/packages.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">سینما فوری</h5>
                                            <p class="card-text">
                                                محتوای پکیج‌های آموزشی ما توسط کارشناسان و متخصصان برجسته طراحی شده است. با استفاده از منابع و متدهای آموزشی به روز، می‌توانید از یادگیری عمیق و کاربردی بهره‌مند شوید.</p>
                                            <a href="#" class="btn btn-primary">خرید پکیج</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <img class="card-img-top" src="../images/packages.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">عکاسی</h5>
                                            <p class="card-text">
                                                محتوای پکیج‌های آموزشی ما توسط کارشناسان و متخصصان برجسته طراحی شده است. با استفاده از منابع و متدهای آموزشی به روز، می‌توانید از یادگیری عمیق و کاربردی بهره‌مند شوید.</p>
                                            <a href="#" class="btn btn-primary">خرید پکیج</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
        }
    }
    ?>

    <?php include 'footer.php'; ?>

  


</body>
</html>
