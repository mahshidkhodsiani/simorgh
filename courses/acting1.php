<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره های بازیکری</title>

  
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
                        <img class="mx-auto d-block img-fluid" src="../images/acting1.jpg" alt="دوره های بازیگری " 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                           
                            
                            <br>

                            <h4 class="" style="font-family: &quot;B Titr&quot;; color: rgb(33, 37, 41);"><span style="background-color: var(--bs-body-bg); font-size: 1.75rem; text-align: var(--bs-body-text-align); font-weight: var(--bs-body-font-weight);">دوره‌های بازیگری بزرگسال موسسه «سیمرغ»</span></h4><h4 class="" style="font-family: &quot;B Titr&quot;; color: rgb(33, 37, 41);"><br></h4><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">آیا به دنبال ارتقاء مهارت‌های بازیگری خود هستید؟ موسسه «سیمرغ»، پیشرو در آموزش بازیگری در ایران، دوره‌های تخصصی بازیگری مقدماتی و پیشرفته را ارائه می‌دهد. این دوره‌ها با هدف توسعه توانایی‌های بازیگری شما و آماده‌سازی شما برای ورود به دنیای هنر طراحی شده‌اند.</p><h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);">سر فصل های دوره</h4><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-بازیگری روی صحنه</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-بدن و بیان در بازیگری</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-فن بیان در‌ بازیگری</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-بداهه گویی و بداهه پردازی</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-شخصیت سازی و شخصیت پردازی</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-خلاقیت و تنوع در خلق و ارائه کاراکتر</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">پلاتو رایگان جهت تمرین درطول دوره</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="font-weight: bolder;">16جلسه آموزش و تمرین همراه با&nbsp; اجرای عموم در یک سالن معتبر تئاتر</span></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">تئوری: آشنایی با سبک ها و مبانی بازیگری</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">عملی: خلق کاراکتر و اجرای نمایش</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">مزایای دوره بازیگری:</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">ارائه مدرک معتبر</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">اجرای گروهی در سالنهای معتبر</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">معرفی به کار</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">پلاتو رایگان درطول دوره</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">16 جلسه</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="background-color: rgb(181, 165, 214);">هزینه دوره 8/800/00 تومان</span></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><font color="#212529" face="B Titr">‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</font></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><font color="#212529" face="B Titr">☎️ 02188341652</font></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><font color="#212529" face="B Titr">09354637055📞</font></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><font color="#212529" face="B Titr">&nbsp;واتساپ و تلگرام</font></p>
                            
                           
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="acting1" class="btn btn-warning btn-lg btn-block">ثبت نام و پرداخت</button>
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
