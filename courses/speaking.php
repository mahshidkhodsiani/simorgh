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
                        <img class="mx-auto d-block img-fluid" src="../images/speaking.jpg" alt="دوره های گویندگی موسسه هفت هنر سیمرغ" 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            <h1>دوره های فن بیان و گویندگی</h1>
                            
                            <br>
                    
                            <p style="color: rgb(33, 37, 41); font-family: Verdana;">موسسه&nbsp;<span style="font-weight: bolder;">"هفت هنر سیمرغ"</span>&nbsp;با هدف ارتقاء مهارت‌های فن بیان و گویندگی تاسیس شده است. این موسسه با بهره‌گیری از روش‌های نوین آموزشی و تیمی مجرب از اساتید برجسته، دوره‌های متنوعی را در زمینه فن بیان، گویندگی و هنرهای گفتاری ارائه می‌دهد.</p><p style="color: rgb(33, 37, 41); font-family: Verdana;"><font color="#212529">دوره‌های آموزشی&nbsp;</font><span style="font-weight: bolder;">"هفت هنر سیمرغ"</span><font color="#212529">&nbsp;شامل تکنیک‌های پیشرفته فن بیان، گویندگی رادیویی و تلویزیونی، و مهارت‌های ارتباطی موثر هستند که به دوره&nbsp;</font><span style="background-color: rgb(255, 231, 156);">مقدماتی&nbsp;</span><font color="#212529">و&nbsp;</font><span style="background-color: rgb(255, 231, 156);">پیشرفته&nbsp;</span><font color="#212529">تقسیم می شود.</font></p><p style="color: rgb(33, 37, 41); font-family: Verdana;"><h3 class=""><font color="#212529">مزایای دوره گویندگی :&nbsp;</font></h3><font color="#212529">-اعطای مدرک معتبر</font></p><p style="color: rgb(33, 37, 41); font-family: Verdana;"><font color="#212529">-همکاری در تولیدات رادیویی بعد از پایان دوره</font></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">برای ثبت نام می توانید از لینک های زیر استفاده کنید.</p>

                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="speaking1" class="btn btn-warning btn-lg btn-block">ثبت نام مقدماتی</button>
                                    <button name="speaking2" class="btn btn-warning btn-lg btn-block">ثبت نام پیشرفته</button>
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
