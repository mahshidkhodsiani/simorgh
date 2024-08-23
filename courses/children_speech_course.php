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
                        <img class="mx-auto d-block img-fluid" src="../images/speaking2.jpg" alt="دوره های گویندگی موسسه هفت هنر سیمرغ" 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                          
                            
                            <br>
                            <h4 class="">آموزش دوبله و گویندگی مخصوص کودکان</h4><p><br></p><p>❗️اگر فن بیان و اعتماد بنفس کودکتان ضعیفه نگران نباشید ❗️</p><p><br></p><p>دوره های تخصصی فن بیان و گویندگی در آموزشگاه سیمرغ راه حل شماست.</p><p><br></p><p>&nbsp;</p><p>فن بیان و ارتباط کلامی</p><p>افزایش اعتماد بنفس و صحبت در جمع</p><p>ادای صحیح حروف و کلمات</p><p>کاهش استرس و اضطراب</p><p>شیوا و رسا صحبت کردن</p><p>کار عملی در استودیو جهت افزایش ارتباط گیری</p><p>بهمراه شرکت در تولیدات رادیویی رادیو سیمرغ</p><p><br></p><p>کلاسها بصورت عملی در استودیوی صدا برگزار میشود.</p><p><br></p><p>۱۰ جلسه ۲ ساعته</p><p>هفته ای یک جلسه</p><p>هزینه دوره : 4/900/000 هزار تومان</p><p>&nbsp;روزهای دوشنبه یا سه شنبه</p><p>ساعت ۵ الی ۷</p><p><br></p><p>پایان دوره به جمع گویندگان رادیو سیمرغ اضافه شده و در تولیدات رادیویی شرکت خواهند کرد.</p><p><br></p><p><br></p><p>‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p><p><br></p><p>☎️ 02188341652</p><p><br></p><p>09354637055📞</p><p>واتساپ و تلگرام</p><p><br></p><p>ادرس</p><p>مترو میرزای شیرازی ، پایینتر از مطهری ، کوچه پانزدهم پلاک ۴۴</p>
                            
                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="speaking2" class="btn btn-warning btn-lg btn-block">ثبت نام و پرداخت</button>
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
