<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>

    <!-- Uncomment the Google Fonts link if needed -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> -->

    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">



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
                        <img class="mx-auto d-block img-fluid" src="../images/audio.jpg" alt="ثبت گویندگی" style="width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;">
                         
                       
                       <h3 class="">آرشیو گویندگان موسسه سیمرغ: منبعی برای یادگیری و الهام</h3>
                       <p>آرشیو گویندگان <a href="https://simorghtv.com/" target="_blank">موسسه سیمرغ</a> یکی از منابع ارزشمند و منحصر به فرد برای علاقه‌مندان به هنر گویندگی و تولید محتوا است. این آرشیو شامل مجموعه‌ای گسترده از آثار و فایل‌های صوتی تولید شده توسط گویندگان برجسته و حرفه‌ای موسسه سیمرغ است که می‌تواند به عنوان منبعی غنی برای یادگیری و الهام‌بخشی به کار رود.</p><p><br></p><h3 class="">ویژگی‌های کلیدی آرشیو گویندگان موسسه سیمرغ:</h3><p><b>1- تنوع و گستردگی محتوا</b>: آرشیو ما شامل فایل‌های صوتی و ویدئویی از گویندگان مختلف با سبک‌های متنوع است. این تنوع به شما این امکان را می‌دهد که با سبک‌های مختلف گویندگی آشنا شوید و از تجربه‌های مختلف بهره‌برداری کنید.</p><p><b>2- کیفیت بالا</b>: تمامی محتواهای موجود در آرشیو موسسه سیمرغ از کیفیت صوتی و تصویری بسیار بالایی برخوردارند. این کیفیت بالا به شما این امکان را می‌دهد که به بهترین نحو ممکن به تحلیل و بررسی محتوا بپردازید.</p><p><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align);"><b>3- دسترسی آسان</b></span><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">: با استفاده از پلتفرم آنلاین موسسه سیمرغ، شما می‌توانید به راحتی به آرشیو گویندگان دسترسی پیدا کنید و از محتوای موجود بهره‌برداری کنید. رابط کاربری ساده و امکانات جستجوی پیشرفته این امکان را فراهم می‌کند که به سرعت به مطالب مورد نظر خود دست یابید.</span><br></p><p><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); text-align: var(--bs-body-text-align);"><b>4- آموزش و توسعه مهارت‌ها</b></span><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">: آرشیو گویندگان موسسه سیمرغ نه تنها به عنوان یک منبع آموزشی برای گویندگان جدید عمل می‌کند، بلکه به گویندگان با تجربه نیز کمک می‌کند تا مهارت‌های خود را بهبود بخشند و از تکنیک‌های جدید بهره‌برداری کنند.</span></p><p><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);"><br></span></p><h3 class="">ارسال صدای خود به موسسه سیمرغ: فرصتی برای شناخته شدن و مشارکت</h3><p>آیا به دنبال فرصتی برای به اشتراک‌گذاری صدای خود با دنیای گسترده‌تر هستید؟ <a href="https://simorghtv.com/" target="_blank">موسسه سیمرغ</a> با افتخار از شما دعوت می‌کند تا صدای خود را برای ما ارسال کنید و بخشی از آرشیو ارزشمند ما شوید. این فرصت بی‌نظیر می‌تواند قدمی بزرگ در مسیر حرفه‌ای شما باشد و به شما کمک کند تا استعدادهای خود را به نمایش بگذارید.</p><p style="color: rgb(33, 37, 41); font-family: Verdana;">می توانید صدای خود را از طریق یکی از شبکات اجتماعی برای ما ارسال کنید :</p><h4 style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot; sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);" class="">۰۹۳۵۴۶۳۷۰۵۵</h4>



                        <div class="table-responsive mt-5">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">ردیف</th>
                                        <th class="text-center">اسم گوینده</th>
                                        <th class="text-center">صدا</th>
                                        <th class="text-center">تصویر گوینده</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows -->
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">آیدا نصیری</td>
                                        <td class="text-center"> 
                                            <audio controls>
                                            <source src="../upload/sounds/2024/aida-nasiri/aida-nasiri.mp3" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                            </audio>
                                        </td>
                                        <td class="text-center">
                                            <img src="../upload/sounds/2024/aida-nasiri/pro.jpg" alt="تمرین گویندگی " height="80px">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">زری راد</td>
                                        <td class="text-center"> 
                                            <audio controls>
                                            <source src="../upload/sounds/2024/zari-rad/zari-rad.mp3" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                            </audio>
                                        </td>
                                        <td class="text-center">
                                            <img src="../upload/sounds/2024/zari-rad/pro.jpg" alt="تمرین گویندگی " height="80px">
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Table pagination">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">قبلی</a>
                                </li>
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">1</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">بعدی</a>
                                </li>
                            </ul>
                        </nav>
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
