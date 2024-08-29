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
                        <img class="mx-auto d-block img-fluid" src="../images/edit_film.jpg" alt="دوره های گویندگی موسسه هفت هنر سیمرغ" 
                            style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                        
                            
                            <br>

                          
                            <h3 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);">آموزش تخصصی تدوین فیلم ، تیزر و کلیپ های صنعتی بهمراه آموزش فتوشاپ</h3><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">تدوین محتواهای سوشال مدیال</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">همراه با مبانی فیلمنامه و کارگردانی</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">آموزش ساخت تیزر تبلیغاتی، آنونس و تریلر</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">تدوین فیلم سینمایی داستانی و</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp;مستند</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">ساخت بنر تبلیغاتی ، پوستر اینستاگرامی ، کارت ویزیت و ...</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">10 جلسه دو ساعته</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="background-color: rgb(181, 165, 214);">هزینه دوره&nbsp;<span style="font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">پریمیر بهمراه فتوشاپ&nbsp;</span><span style="font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">6/500/000 تومان</span></span></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">☎️ 02188341652</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">09354637055📞</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp;واتساپ و تلگرام</p>
                            

                            <div class="col-6 col-md-6">
                                <form method="post" action="../register">
                                    <button name="edit_film" class="btn btn-warning btn-lg btn-block">ثبت نام و پرداخت</button>
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
