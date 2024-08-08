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
                            
                            <p>آموزشگاه فرهنگی هنری و سینمایی سیمرغ</p><p><br></p><p>کمتر از سه ماه با آموزش تخصصی تولید محتوا</p><p>نرم افزارهای آموزشی</p><p>افترافکت ، پریمیر ،فتوشاپ و ایلیستراتور</p><p>آموزش موشن گرافیک&nbsp; و ساخت تیزر تبلیغاتی</p><p>آموزش ادیت ویدیو و صداگذاری</p><p>آموزش ساخت کلیپ و تولید محتوا</p><p>آموزش فتوشاپ و طراحی بنر و پوستر</p><p><br></p><p>✔ اگه شغل مناسب ندارین ،یا دنبال شغل دوم با درآمد بالا هستین ،&nbsp;</p><p>میتونین رشته موشن گرافیک یاد بگیرین و بصورت حضوری و حتی دورکاری در منزل خودتون تولید محتوا بسازید و کسب درآمد کنید.</p><p>کلاسها بصورت حضوری و آنلاین</p><p>هزینه ثبت نام&nbsp;</p><p>نه میلیون و پونصد هزار تومان</p><p>❗شهریه بصورت اقساطی❗</p><p>پرداخت بصورت یکجا</p><p>هشت میلیون و پانصد هزار تومان</p><p>در صورت پرداخت اقساطی حداقل یک سوم پرداخت کنید و فیش واریزی را در واتساپ یا تلگرام موسسه بفرستید .</p><p>❗ با ارائه مدرک❗</p><p>آدرس؛ میرزای شیرازی ، پایینتر از مطهری کوچه پانزدهم پلاک</p>
                            
                            
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
