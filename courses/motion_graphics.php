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
                        <img class="mx-auto d-block img-fluid" src="../images/motion.jpg" alt="دوره های موشن گرافیک " 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            <h1>دوره های موشن گرافیک</h1>
                            
                            <br>
                            
                           <p style="color: rgb(33, 37, 41); font-family: Verdana;">آموزشگاه فرهنگی هنری و سینمایی سیمرغ</p><p style="color: rgb(33, 37, 41); font-family: Verdana;"><br></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">کمتر از سه ماه با آموزش تخصصی تولید محتوا</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">نرم افزارهای آموزشی</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">افترافکت ، پریمیر ،فتوشاپ و ایلیستراتور</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">آموزش موشن گرافیک&nbsp; و ساخت تیزر تبلیغاتی</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">آموزش ادیت ویدیو و صداگذاری</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">آموزش ساخت کلیپ و تولید محتوا</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">آموزش فتوشاپ و طراحی بنر و پوستر</p><p style="color: rgb(33, 37, 41); font-family: Verdana;"><br></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">✔ اگه شغل مناسب ندارین ،یا دنبال شغل دوم با درآمد بالا هستین ،&nbsp;</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">میتونین رشته موشن گرافیک یاد بگیرین و بصورت حضوری و حتی دورکاری در منزل خودتون تولید محتوا بسازید و کسب درآمد کنید.</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">کلاسها بصورت حضوری و آنلاین</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">هزینه ثبت نام&nbsp;</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">نه میلیون و پونصد هزار تومان</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">❗شهریه بصورت اقساطی❗</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">پرداخت بصورت یکجا</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">هشت میلیون و پانصد هزار تومان</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">در صورت پرداخت اقساطی حداقل یک سوم پرداخت کنید و فیش واریزی را در واتساپ یا تلگرام موسسه بفرستید .</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">❗ با ارائه مدرک❗</p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; font-family: Verdana; color: rgb(33, 37, 41);"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">تلفن : ۰۲۱۸۸۳۴۱۶۵۲</span></span></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; font-family: Verdana; color: rgb(33, 37, 41);"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">واتساپ : ۰۹۳۵۴۶۳۷۰۵۵</span></span></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">آدرس؛ میرزای شیرازی ، پایینتر از مطهری کوچه پانزدهم پلاک</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">برای ثبت نام می توانید از لینک زیر استفاده کنید.<br></p>
                           
                            
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="motion" class="btn btn-warning btn-lg btn-block">ثبت نام</button>
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
