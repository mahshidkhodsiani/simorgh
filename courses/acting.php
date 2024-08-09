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
                        <img class="mx-auto d-block img-fluid" src="../images/acting.jpg" alt="دوره های بازیگری " 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            <h1>دوره های بازیگری</h1>
                            
                            <br>

                            <h3 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);"><span style="font-weight: bolder;">دوره‌های بازیگری مقدماتی و پیشرفته موسسه «سیمرغ»</span></h3><p style="color: rgb(33, 37, 41); font-family: Verdana;">آیا به دنبال ارتقاء مهارت‌های بازیگری خود هستید؟ موسسه «سیمرغ»، پیشرو در آموزش بازیگری در ایران، دوره‌های تخصصی بازیگری مقدماتی و پیشرفته را ارائه می‌دهد. این دوره‌ها با هدف توسعه توانایی‌های بازیگری شما و آماده‌سازی شما برای ورود به دنیای هنر طراحی شده‌اند.</p><h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);"><span style="font-weight: bolder;">دوره بازیگری مقدماتی:</span></h4><p style="color: rgb(33, 37, 41); font-family: Verdana;">دوره مقدماتی بازیگری موسسه «سیمرغ» برای کسانی طراحی شده است که تازه وارد دنیای بازیگری شده‌اند. در این دوره، با اصول اولیه بازیگری، تکنیک‌های بیان و حرکات بدن آشنا خواهید شد. مدرسین ما با سال‌ها تجربه در صنعت سینما و تئاتر، شما را با مهارت‌های ضروری بازیگری آشنا می‌کنند.</p><h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);"><span style="font-weight: bolder;">دوره بازیگری پیشرفته:</span></h4><p style="color: rgb(33, 37, 41); font-family: Verdana;">اگر تجربه‌ای در زمینه بازیگری دارید و به دنبال ارتقاء توانایی‌های خود هستید، دوره بازیگری پیشرفته موسسه «سیمرغ» بهترین گزینه برای شماست. در این دوره، تکنیک‌های پیشرفته بازیگری، تحلیل عمیق شخصیت‌ها و آماده‌سازی برای نقش‌های پیچیده‌تر آموزش داده می‌شود. با استفاده از روش‌های مدرن و تکنیک‌های روز، به شما کمک می‌کنیم تا به سطح بالاتری از هنر بازیگری برسید.</p><h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);"><span style="font-weight: bolder;">چرا موسسه «سیمرغ»؟</span></h4><p style="color: rgb(33, 37, 41); font-family: Verdana;">موسسه «سیمرغ» با ارائه دوره‌های متنوع و با کیفیت، به یکی از معتبرترین مراکز آموزش بازیگری در ایران تبدیل شده است. ما به شما این اطمینان را می‌دهیم که با شرکت در دوره‌های ما، گام‌های موثری در جهت پیشرفت حرفه‌ای خود خواهید برداشت.</p><h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);"><span style="font-weight: bolder;">مزایای دوره بازیگری:</span></h4><ul style="color: rgb(33, 37, 41); font-family: Verdana;"><li>معرفی به کار</li><li>اجرای گروهی</li><li>اجرای گروهی در سالن‌های معتبر</li></ul><p style="color: rgb(33, 37, 41); font-family: Verdana;"><br></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; font-family: Verdana; color: rgb(33, 37, 41);"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">تلفن : ۰۲۱۸۸۳۴۱۶۵۲</span></span></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; font-family: Verdana; color: rgb(33, 37, 41);"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">واتساپ : ۰۹۳۵۴۶۳۷۰۵۵</span></span></p><p style="color: rgb(33, 37, 41); font-family: Verdana;">برای ثبت‌نام، می‌توانید از لینک‌های زیر استفاده کنید.</p>

                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="acting1" class="btn btn-warning btn-lg btn-block">ثبت نام مقدماتی</button>
                                    <button name="acting2" class="btn btn-warning btn-lg btn-block">ثبت نام پیشرفته</button>
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
