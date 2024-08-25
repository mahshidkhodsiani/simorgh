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
                            <h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);">آموزش دوبله و گویندگی مخصوص کودکان</h4><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><br></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️اگر فن بیان و اعتماد بنفس کودکتان ضعیفه نگران نباشید ❗️</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><br></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">دوره های تخصصی فن بیان و گویندگی در آموزشگاه سیمرغ راه حل شماست.</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp;<span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">فن بیان و ارتباط کلامی</span></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">افزایش اعتماد بنفس و صحبت در جمع</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">ادای صحیح حروف و کلمات</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">کاهش استرس و اضطراب</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">شیوا و رسا صحبت کردن</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">کار عملی در استودیو جهت افزایش ارتباط گیری</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">بهمراه شرکت در تولیدات رادیویی رادیو سیمرغ</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">کلاسها بصورت عملی در استودیوی صدا برگزار میشود.</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">۱۰ جلسه ۲ ساعته</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">هفته ای یک جلسه</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="background-color: rgb(181, 165, 214);">هزینه دوره : 5/900/000 هزار تومان</span></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp;روزهای سه شنبه</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">ساعت 17 الی&nbsp; 19</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">پایان دوره به جمع گویندگان رادیو سیمرغ اضافه شده و در تولیدات رادیویی شرکت خواهند کرد.</span></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">☎️ 02188341652</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">09354637055📞</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">واتساپ و تلگرام</p>
                            
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
