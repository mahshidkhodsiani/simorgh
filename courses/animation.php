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
                        <img class="mx-auto d-block img-fluid" src="../images/animation.jpg" alt="انیمیشن سازی" 
                            style="width: 100%; height: auto;">
                            <div class="card-body" dir="rtl" style="text-align: right;">
                            <h1>دوره انیمیشن سازی</h1>
                            
                            <br>
                            
                            <p>موسسه فرهنگی هنری " سیمرغ "</p><p><br></p><p>آموزش آکادمیک و تخصصی&nbsp; انیمیشن سازی دوبعدی با موهو</p><p><br></p><p><br></p><p>(آموزش بصورت کاملا پروژه محور)</p><p><br></p><p>✅ ساخت انیمیشن های بلند</p><p>✅ انیمیشن کات اوت</p><p>✅ استاپ موشن</p><p>✅ ساخت کاریکاتور</p><p>✅ موشن گرافیک&nbsp;</p><p>✅ نقاشی و طراحی در محیط برنامه</p><p>✅ امکان وارد کردن نقاشی های دستی و طراحی های ایلستریتور در انیمه استودیو</p><p>✅ ضبط دیالوگ در برنامه</p><p>✅ آشنایی با کاراکترهای آماده برای استفاده در محیط خود موهو</p><p>&nbsp;✅ خروجی گرفتن در انواع فرمت های ویدئویی</p><p><br></p><p>۱۲ جلسه</p><p>هزینه دوره .۷.۹۰۰.۰۰۰</p><p><br></p><p>میرزای شیرازی ، پایینتر از مطهری ، کوچه پانزدهم پلاک ۴۴ واحد ۲</p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">تلفن : ۰۲۱۸۸۳۴۱۶۵۲</span></span></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">واتساپ : ۰۹۳۵۴۶۳۷۰۵۵</span></span></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">برای ثبت‌نام، می‌توانید از لینک‌ زیر استفاده کنید.</p>
                            
                            
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="animation" class="btn btn-warning btn-lg btn-block">ثبت نام</button>
                                    <input type="hidden" name="sabtenam">
                                </form>
                                
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
