<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره های گویندگی کوتاه</title>

 
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
                        <img class="mx-auto d-block img-fluid" src="../images/short-speaking.jpg" alt="دوره های گویندگی " 
                            style="width: 100%; height: auto;">
                            <div class="card-body" dir="rtl" style="text-align: right;">
                            <h1>دوره گویندگی کوتاه مدت</h1>
                            
                            <br>
                            
                            <p>رادیو سیمرغ برگزار میکند.</p><p><br></p><p>اینجا صدایتان شنیده میشود</p><p><br></p><h4 class="">دوره های کوتاه مدت&nbsp;<br>گویندگی رادیو و نمایش های رادیویی</h4><p><br></p><p>فرصتی مناسبی برای علاقمندان کار در رادیو</p><p><br></p><p>ویژه کسانیکه دوره های مقدماتی یا پیشرفته گویندگی را گذرانده ان.</p><p>۵ جلسه عملی در استودیو</p><p>بهمراه شرکت در تولید برنامه های رادیویی</p><p><br></p><p>ارائه گواهینامه شرکت در دوره</p><p>همکاری در رادیو</p><p><br></p><p>هزینه دوره: ۱.۹۰۰.۰۰۰</p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">تلفن : ۰۲۱۸۸۳۴۱۶۵۲</span></span></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">واتساپ : ۰۹۳۵۴۶۳۷۰۵۵</span></span></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">برای ثبت‌نام، می‌توانید از لینک‌ زیر استفاده کنید.</p>
                            
                            
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="short-speaking" class="btn btn-warning btn-lg btn-block">ثبت نام</button>
                                    <!-- <button name="speaking2" class="btn btn-warning btn-lg btn-block">ثبت نام پیشرفته</button> -->
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
