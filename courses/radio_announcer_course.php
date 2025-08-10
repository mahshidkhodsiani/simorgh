<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره های گویندگی</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">



</head>

<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();


    ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card border border-danger" style="border-radius: 40px;">
                    <img class="mx-auto d-block img-fluid" src="../images/speaking1.jpg" alt="دوره های گویندگی موسسه هفت هنر سیمرغ"
                        style="width: 100%; height: auto;">
                    <div class="card-body" dir="rtl" style="text-align: right;">


                        <br>
                        <h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);">فن بیان و گویندگی تخصصی رادیو</h4>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><br></p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">همراه با اجرای برنامه های رادیویی</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">مدرسین دوره</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">سجاد نادر ( تهیه کننده و برنامه ساز رادیو)</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">میترا خواجه ئیان ( استاد دانشگاه و کارشناس رادیو)</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">مینا امامی ( کارشناس ارشد نمایش و مدرس نمایش رادیویی)</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><br></p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">سرفصل های دوره</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️فن بیان و سخنوری&nbsp;</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️انواع حس ، لحن ، بیان و تنفس</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️تیزرهای تبلیغاتی و دکلمه خوانی</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️پادکست ، کتاب صوتی و نریشن</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️آشنایی با انواع گویندگی&nbsp;</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️ اجرای پشت میکروفن</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️انواع نمایشنامه و درک موقعیت</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️ریتم ، تمپو ، موتیف</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️خلق کاراکتر و تخیل فعال</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️نقش بدن در تولید صدا</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">❗️بداهه گویی ، تیپ سازی و صداسازی</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">۱۵ جلسه ۳ ساعته</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">روز های&nbsp; پنجشنبه ساعت 15 الی 18</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="background-color: rgb(181, 165, 214);">هزینه دوره : 13/000/000 میلیون تومان</span></p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">☎️ 02191300517</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">09354637055📞</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp;واتساپ و تلگرام</p>


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


    <?php include 'footer.php'; ?>

</body>

</html>