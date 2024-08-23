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
                        <img class="mx-auto d-block img-fluid" src="../images/acting2.jpg" alt="دوره های بازیگری " 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            
                            <br>
                            <h4 class="">دوره آموزش بازیگری مخصوص کودکان</h4><p><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);"><br></span></p><p><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">از سنین ۵ الی ۱۵ سال</span><br></p><p><br></p><p>مدرس دوره : مینا امامی</p><p>بازیگر برتر جشنواره بین المللی تئاتر مسکو</p><p>سرفصل های دوره</p><p>✔️رها سازی و آرامش</p><p>✔️بداهه پردازی</p><p>✔️انعظاف پذیری</p><p>✔️مشاهده و گوش دادن</p><p>✔️پرورش تخیل</p><p>✔️تمرکز و حل مسئله</p><p>✔️سخنرانی خود جوش</p><p><br></p><p>بهمراه اجرای گروهی پایان دوره و معرفی به کار در پروژه ها</p><p><br></p><p>۱۲ جلسه ۳ ساعته</p><p>هزینه دوره ۷/۵۰۰/۰۰۰</p><p>روزهای پنجشنبه ساعت ۴ الی ۷</p><p><br></p><p><br></p><p><br></p><p>‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p><p><br></p><p>☎️ 02188341652</p><p><br></p><p>09354637055📞</p><p>واتساپ و تلگرام</p>
                            

                          
                           
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="acting2" class="btn btn-warning btn-lg btn-block">ثبت نام و پرداخت</button>
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
