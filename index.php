<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با ارائه دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta name="keywords" content="گویندگی, انیمیشن, طراحی, موسیقی, آموزش گویندگی, دوره‌های گویندگی, موسسه هنری">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta property="og:title" content="موسسه هفت هنر سیمرغ">
    <meta property="og:description"
        content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta property="og:image" content="images/logo1.png">

    <meta property="og:url" content="https://www.simorghtv.com">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fa_IR">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="موسسه هفت هنر سیمرغ">
    <meta name="twitter:description"
        content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta name="twitter:image" content="URL-to-your-image.jpg">
    <title>هفت هنر سیمرغ</title>
    <link rel="icon" href="/images/logo1.ico" type="image/x-icon">

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="radios/manifest.json">
    <meta name="theme-color" content="#764ba2">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="رادیو سیمرغ">
    <link rel="apple-touch-icon" href="images/36.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

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

    <style>
    @font-face {
        font-family: 'estedad';
        src:
            url('fonts/ttf/Estedad-Medium.ttf') format('truetype'),
    }

    body {
        font-family: 'estedad', sans-serif !important;
        line-height: 2 !important;
    }

    /* ===== دکمه ثابت نصب در سمت چپ ===== */
    .install-fixed-btn {
        position: fixed;
        left: 20px;
        bottom: 100px;
        z-index: 9999;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 14px 20px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 0.95rem;
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(118, 75, 162, 0.4);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'estedad', sans-serif !important;
        writing-mode: horizontal-tb;
        min-width: 160px;
        justify-content: center;
    }

    .install-fixed-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 35px rgba(118, 75, 162, 0.5);
    }

    .install-fixed-btn .icon {
        font-size: 1.3rem;
    }

    /* مخفی کردن دکمه در موبایل کوچک */
    @media (max-width: 576px) {
        .install-fixed-btn {
            left: 10px;
            bottom: 80px;
            padding: 10px 14px;
            font-size: 0.8rem;
            min-width: 120px;
            gap: 6px;
        }

        .install-fixed-btn .icon {
            font-size: 1rem;
        }
    }

    @media (max-width: 400px) {
        .install-fixed-btn {
            left: 5px;
            bottom: 70px;
            padding: 8px 10px;
            font-size: 0.7rem;
            min-width: 90px;
            border-radius: 30px;
        }

        .install-fixed-btn .icon {
            font-size: 0.8rem;
        }
    }
    </style>

</head>

<body>
    <?php
    include "header.php";
    include "config.php";
    include "PersianCalendar.php";
    include "jalaliDate.php";
    $sdate = new SDate();
    ?>

    <!-- ===== دکمه ثابت نصب PWA ===== -->
    <button id="installPwaBtn" class="install-fixed-btn">
        <span class="icon">📲</span>
        <span>نصب رادیو سیمرغ</span>
    </button>

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/29.jpg" alt="سیمرغ">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/27.jpg" alt="سیمرغ">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/26.jpg" alt="سیمرغ">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/28.jpg" alt="سیمرغ">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/25.jpg" alt="سیمرغ">
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

    <!-- ===== بخش استوری‌ها ===== -->
    <div class="container-fluid px-4 mt-3">
        <div class="stories-wrapper">
            <div class="stories-scroll" id="storiesScroll">
                <?php
            $current_date = date('Y-m-d H:i:s');
            $sql_stories = "SELECT * FROM stories 
                           WHERE status = 1 
                           AND (expire_at IS NULL OR expire_at > '$current_date') 
                           ORDER BY id DESC 
                           LIMIT 15";
            $stories_result = $conn->query($sql_stories);
            
            if ($stories_result && $stories_result->num_rows > 0) {
                while ($story = $stories_result->fetch_assoc()) {
                    $expire_labels = [
                        'day' => '۱ روز',
                        'week' => '۱ هفته',
                        'month' => '۱ ماه',
                        'custom' => ($story['expire_days'] ?? 0) . ' روز',
                        'unlimited' => '♾️'
                    ];
                    
                    $image_path = $story['image'];
                    if (strpos($image_path, 'http') !== 0 && strpos($image_path, 'upload/') !== 0) {
                        $image_path = 'upload/images/stories/' . $image_path;
                    }
                    if (!file_exists($image_path) && strpos($image_path, 'http') !== 0) {
                        $image_path = 'images/default-story.jpg';
                    }
            ?>
                <div class="story-item" data-story="<?= $image_path ?>"
                    data-title="<?= htmlspecialchars($story['title']) ?>">
                    <div class="story-avatar" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743);">
                        <div class="story-img" style="background-image: url('<?= $image_path ?>');"></div>
                    </div>
                    <span class="story-name"><?= htmlspecialchars($story['title']) ?></span>
                    <span class="story-badge"><?= $expire_labels[$story['expire_type']] ?? '۱ روز' ?></span>
                </div>
                <?php
                }
            } else {
                echo '<p class="text-muted text-center w-100 my-3">📸 هیچ استوری فعالی وجود ندارد</p>';
            }
            ?>
            </div>
        </div>
    </div>

    <!-- ===== مدال نمایش استوری ===== -->
    <div id="storyModal" class="story-modal" onclick="closeStoryModal()">
        <div class="story-modal-content" onclick="event.stopPropagation();">
            <span class="story-modal-close" onclick="closeStoryModal()">&times;</span>
            <img id="storyModalImage" class="story-modal-img" src="" alt="استوری">
            <h4 id="storyModalTitle" class="story-modal-title"></h4>
        </div>
    </div>
    <!-- ===== پایان بخش استوری‌ها ===== -->

    <div class="container-fluid px-4 mt-4">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="search-wrapper">
                    <div class="search-bubble"></div>
                    <div class="input-group search-box">
                        <input type="text" id="searchInput" name="search_word" class="form-control"
                            placeholder="دوره مورد نظر خود را جستجو کنید..." autocomplete="off">
                        <span class="input-group-text search-icon">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <div id="suggestionsList" class="suggestions-list"></div>
                </div>
            </div>

            <div class="col-md-8" style="text-align: right; direction: rtl;">
                <h3 class="alert-heading mb-1"><b>موسسه هفت هنر سیمرغ</b></h3>
                <p style="font-size: 13px; text-align: right; direction: rtl; margin-bottom: 5px;">
                    اگر به دنیای هنر و رسانه علاقه‌مند هستید، آموزشگاه سیمرغ فضایی حرفه‌ای برای کشف و پرورش استعدادهای
                    شما فراهم کرده است.
                    دوره‌های تخصصی ما شامل بازیگری ، دوبله و گویندگی ، گریم سینمایی، موشن گرافیک، هوش مصنوعی، عکاسی،
                    تدوین ، جلوه‌های ویژه و ... بوده و به‌صورت حضوری و پکیج‌های آموزشی آنلاین ارائه می‌شود.
                    با آموزش‌های کاربردی و راهنمایی اساتید مجرب، مسیر یادگیری تا ورود به بازار کار را هدفمند و حرفه‌ای
                    طی خواهید کرد.
                </p>
                <hr class="mt-1">
            </div>
        </div>
    </div>

    <div class="container-fluid px-4 mt-4">
        <section id="portfolio" class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5 col-lg-4 text-center mb-4 mb-md-0">
                        <img class="img-fluid rounded shadow-lg" src="images/37.png" alt="تصویر سیمرغ"
                            style="max-height: 650px; object-fit: cover;">
                    </div>

                    <div class="col-md-7 col-lg-8">
                        <div class="row">
                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <a href="radios" class="text-decoration-none" title="کلیک کنید">
                                    <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                                            <h6 class="card-title rtl-title text-center fw-bold text-dark mb-0">برنامه
                                                های رادیویی سیمرغ</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <a href="packages" class="text-decoration-none" title="کلیک کنید">
                                    <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                                            <h6 class="card-title rtl-title text-center fw-bold text-dark mb-0">پکیج های
                                                آموزشی</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <a href="portofilo/pictures" class="text-decoration-none" title="کلیک کنید">
                                    <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                                            <h6 class="card-title rtl-title text-center fw-bold text-dark mb-0">گالری و
                                                نمونه کارها</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <a href="articles/speakers_archive" class="text-decoration-none" title="کلیک کنید">
                                    <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                                            <h6 class="card-title rtl-title text-center fw-bold text-dark mb-0">گویندگان
                                                رادیو سیمرغ</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <a href="portofilo/videos" class="text-decoration-none" title="کلیک کنید">
                                    <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                                            <h6 class="card-title rtl-title text-center fw-bold text-dark mb-0">ویدیوهای
                                                نمونه کار</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <a href="register" class="text-decoration-none" title="کلیک کنید">
                                    <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                                            <h6 class="card-title rtl-title text-center fw-bold text-dark mb-0">پرداخت
                                                نقدی دوره ها</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <a href="register2" class="text-decoration-none" title="کلیک کنید">
                                    <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                                            <h6 class="card-title rtl-title text-center fw-bold text-dark mb-0">پرداخت
                                                اقساطی دوره‌ها</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-6 col-md-6 mb-4 card-spacing">
                                <a href="pardakht" class="text-decoration-none" title="کلیک کنید">
                                    <div class="card h-100 shadow-sm animated-card" style="border: 2px solid #d85353;">
                                        <div class="card-body d-flex align-items-center justify-content-center p-4">
                                            <h6 class="card-title rtl-title text-center fw-bold text-dark mb-0">پرداخت
                                                آزاد به موسسه</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <section class="light">
            <div class="container py-2">
                <a href="packages">
                    <h2 class="h1 text-center text-dark fw-bold" id="pageHeaderTitle" title="کلیک کنید">
                        آخرین پکیج‌های سیمرغ
                        <img src="images/link.jpg" height="30px" width="30px" alt="آخرین پکیج‌ها"
                            title="آخرین پکیج‌های سیمرغ">
                    </h2>
                </a>

                <?php
                $sql = "SELECT * FROM packages ORDER BY id DESC LIMIT 4";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $counter = 0;
                    while ($row = $result->fetch_assoc()) {
                        if (is_object(json_decode($row["pictures"]))) {
                            $images = json_decode($row["pictures"], true);
                            $image_url = $images["images"]["original"];
                            $image_url = str_replace("/upload", "upload", $image_url);
                        } else {
                            $image_url = $row["pictures"];
                            $image_url = str_replace("../upload", "upload", $image_url);
                        }

                        $body_content = preg_replace('/<p>/', '<p style="color: black !important; margin-right: 5px !important; font-size: 16px !important;">', $row['description']);

                        if ($counter % 2 == 0) {
                ?>

                <article class="postcard light blue">
                    <a class="postcard__img_link" href="packages">
                        <img class="postcard__img" src="<?= $image_url ?>" alt="<?= $row["name"] ?>" />
                    </a>
                    <div class="postcard__text t-dark">
                        <h3 class="postcard__title blue"><a href="packages"><?= $row["name"] ?></a></h3>
                        <div class="postcard__bar"></div>
                        <div class="postcard__preview-txt mr-5 fw-bold"><?= $body_content ?></div>
                        <ul class="postcard__tagbox">
                            <a href="packages">
                                <li class="tag__item"><i class="fas fa-clock mr-2"></i>مشاهده پکیج</li>
                            </a>
                        </ul>
                    </div>
                </article>

                <?php } else { ?>

                <article class="postcard light red">
                    <a class="postcard__img_link" href="packages">
                        <img class="postcard__img" src="<?= $image_url ?>" alt="<?= $row["name"] ?>" />
                    </a>
                    <div class="postcard__text t-dark">
                        <h3 class="postcard__title red"><a href="packages"><?= $row["name"] ?></a></h3>
                        <div class="postcard__bar"></div>
                        <div class="postcard__preview-txt fw-bold"><?= $body_content ?></div>
                        <ul class="postcard__tagbox">
                            <a href="packages">
                                <li class="tag__item"><i class="fas fa-clock mr-2"></i>مشاهده پکیج</li>
                            </a>
                        </ul>
                    </div>
                </article>

                <?php }
                        $counter++;
                    }
                } else {
                    echo "موردی یافت نشد";
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
                                            <p class="card-text fw-bold">اگر دنبال صداهای جذاب با گوینده های متنوع هستید
                                                کلیک کنید.</p>
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
                                            <p class="card-text fw-bold">آرشیو بهترین گویندگان با صداهای متنوع تیزر
                                                تبلیغاتی، موشن گرافیک ، دوبلوری، پادکست ، کتاب صوتی و هرصدایی که بخواهید
                                                میتوانید ایجا برای آن گوینده پیدا کنید </p>
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
                                            <p class="card-text fw-bold">اگر صدای خوب یا استعداد گویندگی دارید می‌توانید
                                                در آموزشگاه رادیو سیمرغ دوره‌های آکادمیک و تجربی را بگذرانید و در ضبط
                                                برنامه‌ها حضور پیدا کنید.</p>
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
                                            <p class="card-text fw-bold">پکیج‌های آموزشی موسسه سیمرغ، راهی نوین برای
                                                یادگیری و پیشرفت</p>
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
                                            <p class="card-text fw-bold">اگر به دنبال پکیج‌های آموزشی جامع و کاربردی
                                                برای ارتقاء مهارت‌های خود هستید، موسسه سیمرغ بهترین گزینه برای شماست</p>
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
                                            <p class="card-text fw-bold">آیا به دنبال ارتقاء مهارت‌های بازیگری خود
                                                هستید؟</p>
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
                                            <p class="card-text fw-bold">موسسه «سیمرغ»، پیشرو در آموزش بازیگری در ایران،
                                                دوره‌های تخصصی بازیگری مقدماتی و پیشرفته را ارائه می‌دهد. این دوره‌ها با
                                                هدف توسعه توانایی‌های بازیگری شما و آماده‌سازی شما برای ورود به دنیای
                                                هنر طراحی شده‌اند.</p>
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
                                            <p class="card-text fw-bold">آیا به دنبال راهی برای ارتقاء برند خود و جذب
                                                مشتریان بیشتر هستید؟ سفارش تبلیغات می‌تواند بهترین گزینه برای شما باشد!
                                            </p>
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
                                            <p class="card-text fw-bold">با گوش سپردن به برنامه‌های رادیویی موسسه "هفت
                                                هنر سیمرغ"، می‌توانید به یک ماجراجویی شنیدنی در دنیای هنر و فرهنگ قدم
                                                بگذارید</p>
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
                                <img src="<?= $row['images'] ?>" class="img-fluid w-100 hover-zoom" alt="تصویر مقاله"
                                    style="height: 200px; object-fit: cover;">
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

        <hr class="my-4">

        <section class="parallax-section">
            <div class="parallax-content">
                <h2>دنیای هنر در دستان شماست!</h2>
                <p>با دوره‌های تخصصی موسسه هفت هنر سیمرغ، استعدادهای خود را کشف و شکوفا کنید و به جمع هنرمندان حرفه‌ای
                    بپیوندید.</p>
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
                            dataType: "html",
                            success: function(response) {
                                console.log("Response received:", response);
                                if (response.trim().length > 0) {
                                    $("#suggestionsList").html(response).show();
                                } else {
                                    $("#suggestionsList").hide();
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

            $(document).on("click", ".suggestion-item", function() {
                let selectedText = $(this).text();
                $("#searchInput").val(selectedText);
                $("#suggestionsList").hide();
            });

            $(document).on("click", function(e) {
                if (!$(e.target).closest(".search-wrapper").length) {
                    $("#suggestionsList").hide();
                }
            });
        });
        </script>

        <script type="text/javascript">
        ! function() {
            var i = "4Ey6dG",
                a = window,
                d = document;

            function g() {
                var g = d.createElement("script"),
                    s = "https://www.goftino.com/widget/" + i,
                    l = localStorage.getItem("goftino_" + i);
                g.async = !0, g.src = l ? s + "?o=" + l : s;
                d.getElementsByTagName("head")[0].appendChild(g);
            }
            "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load",
                g, !1);
        }();
        </script>

        <!-- ===== اسکریپت PWA ===== -->
        <script>
        // ============================================
        // مدیریت نصب PWA (دکمه ثابت سمت چپ)
        // ============================================
        let deferredPrompt;
        const installBtn = document.getElementById('installPwaBtn');

        // بررسی نصب بودن
        function isInstalled() {
            return window.matchMedia('(display-mode: standalone)').matches ||
                window.navigator.standalone === true;
        }

        // اگر نصب شده، دکمه را مخفی کن
        if (isInstalled()) {
            installBtn.style.display = 'none';
        }

        // رویداد beforeinstallprompt
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
        });

        // نصب
        installBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const result = await deferredPrompt.userChoice;
                if (result.outcome === 'accepted') {
                    installBtn.style.display = 'none';
                    alert('✅ رادیو سیمرغ با موفقیت نصب شد!');
                }
                deferredPrompt = null;
            } else {
                // راهنمای نصب دستی
                const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
                const msg = isIOS ?
                    'در Safari روی Share و سپس Add to Home Screen کلیک کنید.' :
                    'از منوی مرورگر گزینه Add to Home Screen را انتخاب کنید.';
                alert('📱 ' + msg);
            }
        });

        // ثبت سرویس‌ورکر
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('radios/sw.js', {
                    scope: '/radios/'
                });
            });
        }

        // ===== استوری ها =====
        document.addEventListener('DOMContentLoaded', function() {
            var storyItems = document.querySelectorAll('.story-item');

            storyItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    var imgSrc = this.getAttribute('data-story');
                    var title = this.getAttribute('data-title');

                    if (!imgSrc) {
                        var style = this.querySelector('.story-img').style.backgroundImage;
                        imgSrc = style.replace(/.*\(|\).*/g, '');
                        imgSrc = imgSrc.replace(/['"]/g, '');
                    }

                    if (!title) {
                        var nameEl = this.querySelector('.story-name');
                        if (nameEl) {
                            title = nameEl.textContent;
                        } else {
                            title = 'استوری';
                        }
                    }

                    openStoryModal(imgSrc, title);
                });
            });
        });

        function openStoryModal(imageSrc, title) {
            var modal = document.getElementById('storyModal');
            var modalImg = document.getElementById('storyModalImage');
            var modalTitle = document.getElementById('storyModalTitle');

            if (!modal || !modalImg) {
                console.error('مدال پیدا نشد!');
                return;
            }

            modalImg.src = imageSrc;
            modalTitle.textContent = title || 'استوری';
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeStoryModal() {
            var modal = document.getElementById('storyModal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeStoryModal();
            }
        });

        console.log('✅ دکمه نصب PWA در سمت چپ فعال شد');
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
            integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
        </script>

    </div>
    <?php include "footer.php"; ?>
</body>

</html>