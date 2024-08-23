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
                        <img class="mx-auto d-block img-fluid" src="../images/speaking1.jpg" alt="دوره های گویندگی موسسه هفت هنر سیمرغ" 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                          
                            
                            <br>
                            <h4 class="">فن بیان و گویندگی تخصصی رادیو</h4><p><br></p><p>همراه با اجرای برنامه های رادیویی</p><p>مدرسین دوره</p><p>سجاد نادر ( تهیه کننده و برنامه ساز رادیو)</p><p>میترا خواجه ئیان ( استاد دانشگاه و کارشناس رادیو)</p><p>مینا امامی ( کارشناس ارشد نمایش و مدرس نمایش رادیویی)</p><p><br></p><p>سرفصل های دوره</p><p>❗️فن بیان و سخنوری&nbsp;</p><p>❗️انواع حس ، لحن ، بیان و تنفس</p><p>❗️تیزرهای تبلیغاتی و دکلمه خوانی</p><p>❗️پادکست ، کتاب صوتی و نریشن</p><p>❗️آشنایی با انواع گویندگی&nbsp;</p><p>❗️ اجرای پشت میکروفن</p><p>❗️انواع نمایشنامه و درک موقعیت</p><p>❗️ریتم ، تمپو ، موتیف</p><p>❗️خلق کاراکتر و تخیل فعال</p><p>❗️نقش بدن در تولید صدا</p><p>❗️بداهه گویی ، تیپ سازی و صداسازی</p><p><br></p><p>۱۵ جلسه ۳ ساعته</p><p>روز های یکشنبه یا پنجشنبه</p><p>هزینه دوره : 13/000/000 میلیون تومان</p><p><br></p><p>‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p><p><br></p><p>☎️ 02188341652</p><p><br></p><p>09354637055📞</p><p>&nbsp;واتساپ و تلگرام</p>
                            
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="speaking1" class="btn btn-warning btn-lg btn-block">ثبت نام و پرداخت</button>
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
