<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره های گریم</title>

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
                    <img class="mx-auto d-block img-fluid" src="../images/cinema-grim.jpg" alt="دوره های موشن گرافیک "
                        style="width: 100%; height: auto;">
                    <div class="card-body" dir="rtl" style="text-align: right;">


                        <br>

                        <h1 style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);">دوره های گریم سینمایی</h1>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><br></p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">آموزشگاه سینمایی "سیمرغ" برگزار میکند</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">دوره های آکادمیک و جامع گریم سینمایی زیر نظر خانم&nbsp;<span style="font-weight: bolder;">مهرنوش صحابی&nbsp;</span>گریمور سنمای و تلویزیون</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">آموزش ببینید : گریمور فیلم و تئاتر شوید</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">معرفی به پروژه ها بعنوان گریمور و دستیار با استاد</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp; گریم مدلهای تیزرهای صنعتی و تبلیغاتی</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><br></p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">✅ گریم سینما ، تئاتر ، فشن ، عروسکی ،&nbsp;</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">✅شناخت آناتومی چهره ،گریم متعادل سازی و نامتعادل سازی ،&nbsp;</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">✅گریم انواع پیری و جوانی ، بافت مو و سبیل ،</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">✅ گریم زخم و صورت ، سوختگی ، حجم سازی ،</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp;✅گریم انواع بخیه زدن ، قالب گیری ، پتینه و کلاژ ، شناخت آناتومی چهره&nbsp;</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">آموزش گریم عملی در سر فیلمبرداری تئاتر و فیلم به همراه استاد</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">دوره فشرده به علاقمندان خارج از تهران</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">بهمراه ارائه کارت هنری موسسه جهت ورود به بازار کار</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="background-color: rgb(181, 165, 214);">مقدماتی ۱۰ جلسه ۶/۵۰۰/۰۰۰</span></p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="background-color: rgb(181, 165, 214);">پیشرفته ۱۲ جلسه ۸/۰۰۰/۰۰۰</span></p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">‼️جهت کسب اطلاعات بیشتر با کارشناسان ما تماس بگیرید یا در بسترهای مجازی جهت مشاوره بیشتر در ارتباط باشید.‼️</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">☎️ 02191300517</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">09354637055📞</p>
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp;واتساپ و تلگرام</p>


                        <div class="col-6 col-md-6">
                            <form method="post" action="../register">
                                <button name="makeup" class="btn btn-warning btn-lg btn-block">ثبت نام و پرداخت</button>
                                <input type="hidden" name="sabtenam">
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