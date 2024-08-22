<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>

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
                        <img class="mx-auto d-block img-fluid" src="../images/dubbing.jpg" alt="دوره های دوبله " 
                            style="width: 100%; height: auto;">
                            <div class="card-body" dir="rtl" style="text-align: right;">
                          
                            
                            <br>
                            
                            <h3 class="">جذب گوینده و دوبلر جهت نمایش های رادیویی</h3><p><br></p><p>موسسه فرهنگی هنری "هفت هنر سیمرغ" برگزار میکند.</p><p><br></p><p>آموزش و جذب دوبلر جهت تولید نمایشهای رادیویی و دوبله فیلم در " آموزشگاه سیمرغ"</p><p>با بیش از صدها فیلم دوبله شده توسط هنرجویان آموزشگاه</p><p><br></p><p>آموزش شخصیت سازی و انواع بازی</p><p>آموزش لیپسینگ و تکنیک های دوبله</p><p>آموزش انواع حس و لحن و بیان</p><p>آموزش بازی پشت میکروفن</p><p>آموزش آواها و زبان ورزی</p><p>آموزش فن بیان در بازیگری دوبلوری</p><p>آموزش رنگ صدا و کارکتر سازی</p><p>تقویت حنجره و تنفس صحیح</p><p>بیان و ترمیم بیان برای گویندگی و راوی داستان</p><p>و تکنیک عملی در استودیوی دوبله</p><p><br></p><p>۱۰ جلسه ۳ ساعته</p><p>هزینه دوره ۷.۵۰۰.۰۰۰</p><p><br></p><p><br></p><p>&nbsp; &nbsp;ماندگاری و جاودانگی با بیان و شیوای رسا&nbsp;</p><p><br></p><p>در کنار ما ، مرحله به مرحله ، به رویای جذاب دوبلری&nbsp; برسید</p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">تلفن : ۰۲۱۸۸۳۴۱۶۵۲</span></span></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">واتساپ : ۰۹۳۵۴۶۳۷۰۵۵</span></span></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">برای ثبت‌نام، می‌توانید از لینک‌های زیر استفاده کنید.</p>

                            
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="dubbing" class="btn btn-warning btn-lg btn-block">ثبت نام </button>
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
