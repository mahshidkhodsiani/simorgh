<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره های گریم</title>


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
                        <img class="mx-auto d-block img-fluid" src="../images/cinema-grim.jpg" alt="دوره های موشن گرافیک " 
                            style="width: 100%; height: auto;">
                            <div class="card-body" dir="rtl" style="text-align: right;">
                            <h1>دوره های گریم سینمایی</h1>
                            
                            <br>
                            
                            <h4 class="">آموزشگاه سینمایی " سیمرغ " برگزار میکند</h4><h4 class=""><br>&nbsp; دوره های آکادمیک و جامع گریم سینمایی زیر نظر خانم مهرنوش صحابی گریمور سینما و تلویزیون</h4><p><br></p><p>آموزش ببینید : گریمور فیلم و تئاتر شوید</p><p><br></p><p>معرفی به پروژه ها بعنوان گریمور و دستیار با استاد</p><p><br></p><p>&nbsp; گریم مدلهای تیزرهای صنعتی و تبلیغاتی</p><p><br></p><p><br></p><p>✅ گریم سینما ، تئاتر ، فشن ، عروسکی ،&nbsp;</p><p>✅شناخت آناتومی چهره ،گریم متعادل سازی و نامتعادل سازی ،&nbsp;</p><p>✅گریم انواع پیری و جوانی ، بافت مو و سبیل ،</p><p>✅ گریم زخم و صورت ، سوختگی ، حجم سازی ،</p><p>&nbsp;✅گریم انواع بخیه زدن ، قالب گیری ، پتینه و کلاژ ، شناخت آناتومی چهره&nbsp;</p><p><br></p><p><br></p><p>آموزش گریم عملی در سر فیلمبرداری تئاتر و فیلم به همراه استاد</p><p><br></p><p>دوره فشرده به علاقمندان خارج از تهران</p><p>بهمراه ارائه کارت هنری موسسه جهت ورود به بازار کار</p><p><br></p><p>مقدماتی ۱۰ جلسه ۶.۵۰۰.۰۰۰</p><p>پیشرفته ۱۲ جلسه ۸.۰۰۰.۰۰۰</p><p><br></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">تلفن : ۰۲۱۸۸۳۴۱۶۵۲</span></span></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">واتساپ : ۰۹۳۵۴۶۳۷۰۵۵</span></span></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">برای ثبت‌نام، می‌توانید از لینک‌های زیر استفاده کنید.</p>
                            
                            
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="makeup1" class="btn btn-warning btn-lg btn-block">ثبت نام مقدماتی</button>
                                    <button name="makeup2" class="btn btn-warning btn-lg btn-block">ثبت نام پیشرفته</button>
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
