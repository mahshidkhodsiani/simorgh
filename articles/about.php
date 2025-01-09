<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درباره هفت هنر سیمرغ</title>

   

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


    ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <img class="mx-auto d-block img-fluid" src="../images/logo2.jpg" alt="موسسه هفت هنر سیمرغ" style="max-width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;"> <!-- Ensured text-align right for RTL text -->
                            <h4 class="card-title" style="color: black !important;">درباره ما</h4> <!-- Ensured black text color -->
                            <br>
                            
                            <p dir="rtl" style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">موسسه فرهنگی هنری چند منظوره "هفت هنر سیمرغ" در سال 1398 با شماره ثبت 49237 در اداره فرهنگ و ارشاد اسلامی استان تهران به منظور آموزش و اشتغال رشته های هنری اعم از : کارگردانی ، بازیگری ، دوبله ، گویندگی ، انیمیشن سازی ، نویسندگی ، گریم سینمایی ، موسیقی و در زمینه تهیه و تولید فیلم ، تهیه کنندگی و حمایت از فیلمسازان و پروژه های تولیدی بخصوص حمایت از تولیدات دانشجویان و کار اولی ها و همچنین برگزاری جشنواره و سیمنار و نمایشگاه&nbsp; به ثبت رسیده و شروع به فعالیت نمود.همچنین طی این سال ها&nbsp;&nbsp;رادیو سیمرغ با همت هنرجویان این موسسه و حمایت ها و تهیه کنندگی سجاد نادر به ثبت رسید وماهانه بیش از 500&nbsp; دقیقه برنامه رادیویی طنز تولید و پخش میشود</span></span></span></span></p>

                            <p dir="rtl" style="margin-left:0in; margin-right:0in"><span style="font-family:B Koodak"><span style="font-size:21.3333px"><em>اعضای هیئت موسس موسسه به شرح زیر می باشد.</em></span></span></p>

                            <p dir="rtl" style="margin-left:0in; margin-right:0in"><span style="font-family:B Koodak"><span style="font-size:21.3333px"><em>مدیر عامل موسسه : سجاد نادر</em></span></span></p>

                            <p dir="rtl" style="margin-left:0in; margin-right:0in"><span style="font-family:B Koodak"><span style="font-size:21.3333px"><em>هیئت موسسین : سجاد نادر&nbsp; ، شهره جوانبخت ، ندا کریمی&nbsp;</em></span></span></p>

                            <p dir="rtl" style="margin-left:0in; margin-right:0in"><span style="font-family:B Koodak"><span style="font-size:21.3333px"><em>اعضا هیئت مدیره : سجاد نادر ، میترا خواجه ئیان ، سمیه غفاری</em></span></span></p>

                            <p dir="rtl" style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">خلاصه ای از زمینه فعالیت موسسه به شرح زیر است :</span></span> </span></span></p>

                            <ul dir="rtl">
                                <li><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">برگزاری همایش</span></span></span></span></li>
                                <li><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">گردهمایی</span></span></span></span></li>
                                <li><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">سمینار و همکاری در برپایی نمایشگاه ها و جشنواره های فرهنگی و هنری و مشارکت در برگزاری همایش ها و سمینارهای تخصصی از طریق خدمات فرهنگی هنری</span></span></span></span></li>
                                <li><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">تهیه و عرضه محصولات فرهنگی، هنری دارای مجوز از قبیل: کتاب، اقلام رایانه ای در زمینه زبان و ادبیات فارسی، معارف اسلامی و علوم قرآنی و نیز فیلمهای مستند و سینمایی(دارای مجوز ). </span></span></span></span><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">گردآوری، تنظیم، تدوین و انتشار نمایه نامه و فهرستهای موضوعی و ارایه خدمات فهرست نویسی</span></span></span></span></li>
                                <li><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">نمایه سازی</span></span></span></span></li>
                                <li><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">سند آرایی مدارک و اسناد فرهنگی و تاریخی و نیز طراحی و تشکیل بانکهای اطلاعاتی</span></span></span></span></li>
                                <li><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">آسیب شناسی و معرفی آسیبهای اجتماعی به اقشار مختلف مردم و ارایه راه کارهای مقابله با آنها</span></span></span></span></li>
                                <li><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="font-family:&quot;B Koodak&quot;">طراحی و برگزاری دوره آموزشی فرهنگی هنری مهارت های آزاد و مهارتی کار دانش طبق نظر اداره کل فرهنگ و ارشاد اسلامی استان تهران از تاریخ ثبت به مدت نامحدودمی باشد.</span></span></span></span></li>
                            </ul>

                            <p dir="rtl" style="margin-left:0in; margin-right:0in"><span style="font-size:11pt"><span style="font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"><span dir="RTL" lang="AR-SA" style="font-size:16.0pt"><span style="background-color:white"><span style="font-family:&quot;B Koodak&quot;"><span style="color:#212529">مرکز اصلی موسسه : تهران ، میرزای شیرازی ، بعد از پمپ بنزین ، کوچه پانزدهم پلاک 44 طبقه اول&nbsp;</span></span></span></span></span></span></p>

                            <p dir="rtl" style="margin-right: 0px; margin-left: 0px; background-color: rgb(255, 255, 255); color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">تلفن : ۰۲۱۸۸۳۴۱۶۵۲</span></span></p><p dir="rtl" style="margin-right: 0px; margin-left: 0px; background-color: rgb(255, 255, 255); color: rgb(33, 37, 41); font-family: Verdana;"><span style="font-size: 11pt; font-family: Calibri, sans-serif;"><span style="font-size: 16pt; background-color: rgb(155, 89, 173);">واتساپ : ۰۹۳۵۴۶۳۷۰۵۵</span></span></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php include 'footer.php'; ?>

</body>
</html>
