<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<!doctype html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با ارائه دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta name="keywords" content="گویندگی, انیمیشن, طراحی, موسیقی, آموزش گویندگی, دوره‌های گویندگی, موسسه هنری">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta property="og:title" content="موسسه هفت هنر سیمرغ">
    <meta property="og:description" content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta property="og:image" content="URL-to-your-image.jpg">
    <meta property="og:url" content="https://www.simorghtv.com">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fa_IR">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="موسسه هفت هنر سیمرغ">
    <meta name="twitter:description" content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta name="twitter:image" content="URL-to-your-image.jpg">
    <title>هفت هنر سیمرغ</title>
    <link rel="icon" href="/images/logo1.ico" type="image/x-icon">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "موسسه هفت هنر سیمرغ",
            "url": "https://simorghtv.com",
            "logo": "https://simorghtv.com/images/logo1.png",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+02191300517",
                "contactType": "customer service",
                "areaServed": "IR",
                "availableLanguage": "Persian"
            }
        }
    </script>

    <?php
    include "includes.php";

    ?>



</head>

<body>
    <?php
    include "header.php";
    include "config.php";
    include "PersianCalendar.php";
    include "jalaliDate.php";
    $sdate = new SDate();
    ?>



    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/25.jpg" alt="سیمرغ">
                <!-- <div class="carousel-caption d-none d-md-block">
                    <h5>استودیو صدا</h5>
                    <p>بهترین استادیوی صدا برای ضبط کلاسها</p>
                </div> -->
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/27.jpg" alt="سیمرغ">
                <!-- <div class="carousel-caption d-none d-md-block">
                    <h5>رادیو سیمرغ</h5>
                    <p>برنامه های جدید و جذاب</p>
                </div> -->
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/26.jpg" alt="سیمرغ">
                <!-- <div class="carousel-caption d-none d-md-block">
                    <h5>جمعه های سیمرغی</h5>
                    <p>در جمعه های سیمرغی با شما هستیم </p>
                </div> -->
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/28.jpg" alt="سیمرغ">
                <!-- <div class="carousel-caption d-none d-md-block">
                    <h5>جمعه های سیمرغی</h5>
                    <p>در جمعه های سیمرغی با شما هستیم </p>
                </div> -->
            </div>
        </div>


        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>



    <div class="container-fluid px-4 mt-4">


        <div class="row">
            <div class="col-md-4">
                <div class="search-wrapper">
                    <div class="search-bubble"></div>
                    <div class="input-group search-box">
                        <input type="text" id="searchInput" name="search_word" class="form-control" placeholder="دوره مورد نظر خود را جستجو کنید..." autocomplete="off">
                        <span class="input-group-text">
                            <i class="fas fa-magnifying-glass"></i>
                        </span>
                    </div>
                    <div id="suggestionsList" class="suggestions-list"></div>
                </div>
            </div>

            <div class="col-md-8">
                <h3 class="alert-heading"><b>موسسه هفت هنر سیمرغ</b></h3>
                <p>اگر به هنر، گویندگی و سینما علاقه‌مند هستید، اینجا جایی‌ست که می‌توانید استعدادهای خود را شکوفا کرده، مهارت‌های لازم را بیاموزید و با راهنمایی اساتید مجرب، قدم به دنیای حرفه‌ای هنر بگذارید.</p>
                <hr>

            </div>
        </div>
    </div>




    <div class="container-fluid px-4 mt-4">



        <section id="portfolio" class="py-5">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-md-5 col-lg-4 text-center mb-4 mb-md-0">
                        <img class="img-fluid rounded shadow-lg" src="images/20.jpeg" alt="تصویر سیمرغ" style="max-height: 650px; object-fit: cover;">
                    </div>
                    <div class="col-md-7 col-lg-8">
                        <div class="row">

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                    <div class="card-body d-flex flex-row justify-content-between align-items-center p-4">
                                        <h4 class="card-title rtl-title fw-bold text-dark mb-0">پرداخت اقساطی دوره ها</h4>
                                        <a href="register2" class="btn btn-outline-quarternary fw-bold">ثبت نام &rarr;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                    <div class="card-body d-flex flex-row justify-content-between align-items-center p-4">
                                        <h4 class="card-title rtl-title fw-bold text-dark mb-0">پرداخت نقدی دوره ها</h4>
                                        <a href="register" class="btn btn-outline-quarternary fw-bold">رفتن به صفحه &rarr;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                    <div class="card-body d-flex flex-row justify-content-between align-items-center p-4">
                                        <h4 class="card-title rtl-title fw-bold text-dark mb-0">پرداخت آزاد به موسسه</h4>
                                        <a href="pardakht" class="btn btn-outline-quarternary fw-bold">پرداخت &rarr;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                    <div class="card-body d-flex flex-row justify-content-between align-items-center p-4">
                                        <h4 class="card-title rtl-title fw-bold text-dark mb-0">پکیج های آموزشی</h4>
                                        <a href="#" class="btn btn-outline-quarternary fw-bold">ثبت نام &rarr;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                    <div class="card-body d-flex flex-row justify-content-between align-items-center p-4">
                                        <h4 class="card-title rtl-title fw-bold text-dark mb-0">گالری و نمونه کارها</h4>
                                        <a href="portofilo/pictures" class="btn btn-outline-quarternary fw-bold">رفتن به صفحه &rarr;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                    <div class="card-body d-flex flex-row justify-content-between align-items-center p-4">
                                        <h4 class="card-title rtl-title fw-bold text-dark mb-0">ویدیوهای نمونه کار</h4>
                                        <a href="portofilo/videos" class="btn btn-outline-quarternary fw-bold">رفتن به صفحه &rarr;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                    <div class="card-body d-flex flex-row justify-content-between align-items-center p-4">
                                        <h4 class="card-title rtl-title fw-bold text-dark mb-0">گویندگان رادیو سیمرغ</h4>
                                        <a href="articles/speakers_archive" class="btn btn-outline-quarternary fw-bold">رفتن به صفحه &rarr;</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                    <div class="card-body d-flex flex-row justify-content-between align-items-center p-4">
                                        <h4 class="card-title rtl-title fw-bold text-dark mb-0">انتقاد و پیشنهاد به سیمرغ</h4>
                                        <a href="articles/suggestion" class="btn btn-outline-quarternary fw-bold">رفتن به صفحه &rarr;</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>


        <hr>










        <section class="light">
            <div class="container py-2">
                <a href="courses">
                    <h1 class="h1 text-center text-dark fw-bold" id="pageHeaderTitle" title="کلیک کنید">
                        آخرین مطالب سیمرغ
                        <img src="images/link.jpg" height="30px" width="30px" alt="آخرین مقالات" title="آخرین مقالات سیمرغ">
                    </h1>
                </a>

                <?php
                $sql = "SELECT * FROM courses WHERE show_index =1 ORDER BY id DESC LIMIT 4";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $counter = 0;
                    while ($row = $result->fetch_assoc()) {
                        if (is_object(json_decode($row["images"]))) {
                            $images = json_decode($row["images"], true);
                            $image_url = $images["images"]["original"];
                            $image_url = str_replace("/upload", "upload", $image_url);
                        } else {
                            $image_url = $row["images"];
                            $image_url = str_replace(
                                "../upload",
                                "upload",
                                $image_url
                            );
                        }

                        $body_content = preg_replace('/<p>/', '<p style="color: black !important; margin-right: 5px !important; font-size: 16px !important;">', $row['text']);

                        if ($counter % 2 == 0) {
                ?>


                            <article class="postcard light blue">
                                <a class="postcard__img_link" href="courses">
                                    <img class="postcard__img" src="<?= $image_url ?>" alt="موسسه هفت هنر سیمرغ" />
                                </a>
                                <div class="postcard__text t-dark">
                                    <h1 class="postcard__title blue"><a href="courses"><?= $row["title"] ?></a></h1>
                                    <div class="postcard__subtitle small">
                                        <time datetime="<?= $sdate->toShaDate($row["created_at"]) ?>">
                                            <i class="fas fa-calendar-alt mr-2"></i><?= $sdate->toShaDate(
                                                                                        $row["created_at"]
                                                                                    ) ?>
                                        </time>
                                    </div>
                                    <div class="postcard__bar"></div>
                                    <div class="postcard__preview-txt mr-5 fw-bold"><?= $body_content ?></div>
                                    <ul class="postcard__tagbox">
                                        <a href="courses/course.php?slug=<?= $row['title'] ?>">
                                            <li class="tag__item"><i class="fas fa-clock mr-2"></i>ادامه مطلب</li>
                                        </a>

                                    </ul>
                                </div>
                            </article>


                        <?php } else { ?>

                            <article class="postcard light red">
                                <a class="postcard__img_link" href="courses">
                                    <img class="postcard__img" src="<?= $image_url ?>" alt="موسسه هفت هنر سیمرغ" />
                                </a>
                                <div class="postcard__text t-dark">
                                    <h1 class="postcard__title red"><a href="courses"><?= $row["title"] ?></a></h1>
                                    <div class="postcard__subtitle small">
                                        <time datetime="<?= $sdate->toShaDate($row["created_at"]) ?>">
                                            <i class="fas fa-calendar-alt mr-2"></i><?= $sdate->toShaDate(
                                                                                        $row["created_at"]
                                                                                    ) ?>
                                        </time>
                                    </div>
                                    <div class="postcard__bar"></div>
                                    <div class="postcard__preview-txt fw-bold"><?= $body_content ?></div>
                                    <ul class="postcard__tagbox">
                                        <a href="courses/course.php?slug=<?= $row['title'] ?>">
                                            <li class="tag__item"><i class="fas fa-clock mr-2"></i>ادامه مطلب</li>
                                        </a>

                                    </ul>
                                </div>
                            </article>

                <?php }
                        $counter++;
                    }
                } else {
                    echo "0 results";
                }
                ?>
            </div>
        </section>


        <hr class="my-4">



        <section id="team" class="pb-5">
            <div class="container">
                <h5 class="section-title h1 fw-bold">تازه ترین ها</h5>
                <div class="row">


                    <div class="col-6 col-sm-4 mb-4">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" src="images/audio.jpg" alt="card image">
                                            </p>
                                            <h4 class="card-title fw-bold">گویندگان سیمرغ</h4>
                                            <p class="card-text fw-bold">اگر دنبال صداهای جذاب با گوینده های متنوع هستید کلیک کنید.</p>
                                            <a href="articles/speakers_archive" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <a href="articles/speakers_archive">
                                                <h4 class="card-title fw-bold">سفارش صدا (کلیک کنید)</h4>
                                            </a>
                                            <p class="card-text fw-bold">آرشیو بهترین گویندگان با صداهای متنوع تیزر تبلیغاتی، موشن گرافیک ، دوبلوری، پادکست ، کتاب صوتی و هرصدایی که بخواهید میتوانید ایجا برای آن گوینده پیدا کنید </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 mb-4">
                        <div class="image-flip">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" src="images/speaking3.jpg" alt="card image">
                                            </p>
                                            <h4 class="card-title fw-bold">آموزش فن بیان و گویندگی</h4>
                                            <p class="card-text fw-bold">اینجا صدایتان شنیده می‌شود!</p>
                                            <a href="courses/speaking_training_course" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <a href="courses/speaking_training_course">
                                                <h4 class="card-title fw-bold">فن بیان و گویندگی (کلیک کنید)</h4>
                                            </a>
                                            <p class="card-text fw-bold">اگر صدای خوب یا استعداد گویندگی دارید می‌توانید در آموزشگاه رادیو سیمرغ دوره‌های آکادمیک و تجربی را بگذرانید و در ضبط برنامه‌ها حضور پیدا کنید.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 mb-4">
                        <div class="image-flip">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" src="images/packages.jpg" alt="card image">
                                            </p>
                                            <h4 class="card-title fw-bold">پکیج‌های آموزشی</h4>
                                            <p class="card-text fw-bold">پکیج‌های آموزشی موسسه سیمرغ، راهی نوین برای یادگیری و پیشرفت</p>
                                            <a href="packages" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <a href="packages">
                                                <h4 class="card-title fw-bold">پکیج‌های آموزشی (کلیک کنید)</h4>
                                            </a>
                                            <p class="card-text fw-bold">اگر به دنبال پکیج‌های آموزشی جامع و کاربردی برای ارتقاء مهارت‌های خود هستید، موسسه سیمرغ بهترین گزینه برای شماست</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 mb-4">
                        <div class="image-flip">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" src="images/acting1.jpg" alt="card image">
                                            </p>
                                            <h4 class="card-title fw-bold">آموزش بازیگری</h4>
                                            <p class="card-text fw-bold">آیا به دنبال ارتقاء مهارت‌های بازیگری خود هستید؟</p>
                                            <a href="courses/acting1" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <a href="courses/acting1">
                                                <h4 class="card-title fw-bold">آموزش بازیگری (کلیک کنید)</h4>
                                            </a>
                                            <p class="card-text fw-bold">موسسه «سیمرغ»، پیشرو در آموزش بازیگری در ایران، دوره‌های تخصصی بازیگری مقدماتی و پیشرفته را ارائه می‌دهد. این دوره‌ها با هدف توسعه توانایی‌های بازیگری شما و آماده‌سازی شما برای ورود به دنیای هنر طراحی شده‌اند.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 mb-4">
                        <div class="image-flip">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" src="images/ordering.jpg" alt="card image">
                                            </p>
                                            <h4 class="card-title fw-bold">سفارش تبلیغات شما</h4>
                                            <p class="card-text fw-bold">اینجا کسب و کارتان دیده می‌شود</p>
                                            <a href="articles/order_ads" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <a href="articles/order_ads">
                                                <h4 class="card-title fw-bold">سفارش تبلیغات (کلیک کنید)</h4>
                                            </a>
                                            <p class="card-text fw-bold">آیا به دنبال راهی برای ارتقاء برند خود و جذب مشتریان بیشتر هستید؟ سفارش تبلیغات می‌تواند بهترین گزینه برای شما باشد!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 mb-4">
                        <div class="image-flip">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" src="images/radio-simorgh.jpg" alt="رادیو سیمرغ">
                                            </p>
                                            <h4 class="card-title fw-bold">رادیو سیمرغ</h4>
                                            <p class="card-text fw-bold"> سفری شنیدنی در دنیای فرهنگ و هنر</p>
                                            <a href="radios" class="btn btn-primary btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="backside">
                                    <div class="card">
                                        <div class="card-body text-center mt-4">
                                            <a href="radios">
                                                <h4 class="card-title fw-bold">برنامه های رادیویی (کلیک کنید)</h4>
                                            </a>
                                            <p class="card-text fw-bold">با گوش سپردن به برنامه‌های رادیویی موسسه "هفت هنر سیمرغ"، می‌توانید به یک ماجراجویی شنیدنی در دنیای هنر و فرهنگ قدم بگذارید</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr class="my-4">


        <section class="border">
            <div class="container">
                <a href="articles">
                    <h3 class="p text-center text-dark fw-bold" title="کلیک کنید">وبلاگ سیمرغ</h3>
                </a>
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 4";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>

                            <div class="col-md-3 mb-4 col-6">
                                <div class="card-four position-relative overflow-hidden">
                                    <a href="articles" class="d-block">
                                        <img src="<?= $row['images'] ?>" class="img-fluid w-100 hover-zoom" alt="تصویر مقاله" style="height: 200px; object-fit: cover;">
                                        <div class="title-overlay">
                                            <h5 class="card-title text-white fw-bold p-2"><?= $row['title'] ?></h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <style>

        </style>



        <hr class="my-4">


        <section class="parallax-section">
            <div class="parallax-content">
                <h2>دنیای هنر در دستان شماست!</h2>
                <p>با دوره‌های تخصصی موسسه هفت هنر سیمرغ، استعدادهای خود را کشف و شکوفا کنید و به جمع هنرمندان حرفه‌ای بپیوندید.</p>
                <a href="register2" class="btn btn-light btn-lg mt-4 fw-bold">همین حالا ثبت نام کنید</a>
            </div>
        </section>



        <hr class="my-4">
        <script>
            $(document).ready(function() {
                let timer;

                $("#searchInput").on("keyup", function() {
                    clearTimeout(timer);
                    let search_word = $(this).val().trim();

                    if (search_word.length > 0) {
                        timer = setTimeout(function() {
                            $.ajax({
                                url: "search_box.php",
                                type: "POST",
                                data: {
                                    search_word: search_word
                                },
                                dataType: "html", // اطمینان از دریافت پاسخ HTML
                                success: function(response) {
                                    console.log("Response received:", response); // ✅ نمایش پاسخ در کنسول

                                    if (response.trim().length > 0) {
                                        $("#suggestionsList").html(response).show(); // نمایش لیست پیشنهادات
                                    } else {
                                        $("#suggestionsList").hide(); // در صورت خالی بودن نتیجه، لیست پنهان شود
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("AJAX Error:", error);
                                }
                            });
                        }, 300);
                    } else {
                        $("#suggestionsList").hide();
                    }
                });

                // انتخاب پیشنهادات با کلیک
                $(document).on("click", ".suggestion-item", function() {
                    let selectedText = $(this).text();
                    $("#searchInput").val(selectedText);
                    $("#suggestionsList").hide();
                });

                // بستن پیشنهادات هنگام کلیک بیرون
                $(document).on("click", function(e) {
                    if (!$(e.target).closest(".search-wrapper").length) {
                        $("#suggestionsList").hide();
                    }
                });
            });
        </script>



    </div>
    <?php include "footer.php"; ?>
</body>

</html>