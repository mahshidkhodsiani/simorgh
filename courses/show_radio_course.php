<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره های گویندگی</title>


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
                        <img class="mx-auto d-block img-fluid" src="../images/speaking4.jpg" alt="دوره های گویندگی موسسه هفت هنر سیمرغ" 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                          
                            
                            <br>
                            <h4 class="">دوره آموزشی نمایش رادیویی</h4><p><br></p><p>مخصوص اجرای نمایش رادیویی</p><p><br></p><p>مدرس دوره</p><p>مینا امامی ( کارشناس ارشد نمایش ، بازیگر و مدرس نمایش رادیویی ، )</p><p><br></p><p><br></p><p>سرفصل های دوره</p><p>❗️انواع نمایشنامه</p><p>❗️تخیل فعال</p><p>❗️خلق کاراکتر</p><p>❗️ریتم ، تمپو ، موتیف</p><p>❗️درک موقعیت و نقش بدن در تولید صدا</p><p><br></p><p>8 جلسه ۲ ساعته</p><p>روز های یکشنبه یا پنجشنبه</p><p>ساعت ۵ الی ۷</p><p>هزینه دوره 4/9/00/000 میلیون تومان</p><p><br></p><p>‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p><p><br></p><p>☎️ 02188341652</p><p><br></p><p>09354637055📞</p><p>واتساپ و تلگرام</p>

                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="speaking4" class="btn btn-warning btn-lg btn-block">ثبت نام و پرداخت</button>
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
