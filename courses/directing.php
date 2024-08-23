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
                        <!-- <img class="mx-auto d-block img-fluid" src="../images/speaking2.jpg" alt="دوره های گویندگی موسسه هفت هنر سیمرغ" 
                            style="width: 100%; height: auto;"> -->
                        <div class="card-body" dir="rtl" style="text-align: right;">
                          
                            <br>
                            <h4 class="">آموزش جامع دوره کارگردانی و فیلمسازی&nbsp;</h4><p>با استاد سجاد نادر&nbsp;</p><p><br></p><p>دکتری هنر ، کارگردان سینما ، تلویزیون و مدیرعامل موسسه سینمایی سیمرغ و کمپانی فیلمسازی مولتی آرت ترکیه</p><p><br></p><p>عضو انجمن کارگردانان و تهیه کنندگان خانه سینما</p><p><br></p><p>✔اصول اولیه فیلمنامه نویسی</p><p>✔اصول اولیه دکوپاژ</p><p>✔شناخت عوامل فنی تولید</p><p>✔شناخت انواع نماها و پلان های تصویری</p><p>✔آموزش نورپردازی و نحوه بستن کستینگ&nbsp;</p><p>✔نحوه ساخت و کارگردانی فیلم کوتاه ، تله فیلم ،سینمایی&nbsp;</p><p>✔️ عوامل مورد نیاز و چگونگی تامین آنها</p><p>✔صفرتا صد از ایده تا کارگردانی فیلم.</p><p><br></p><p>‼️تولید یک فیلم کوتاه به تهیه کنندگی موسسه هفت هنر سیمرغ با کارگردانی هنرجویان پس از پایان دوره‼️</p><p><br></p><p>استفاده از هنرجویان خلاق بعنوان دستیار و عوامل فنی در تولیدات موسسه</p><p>&nbsp;</p><p>12 جلسه 3 ساعته</p><p>هزینه دوره 11/000/000 میلیون تومان</p><p>روزهای یکشنبه ساعت 17 لی 20</p><p><br></p><p><br></p><p>‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p><p><br></p><p>☎️ 02188341652</p><p><br></p><p>09354637055📞</p><p>واتساپ و تلگرام</p>

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
