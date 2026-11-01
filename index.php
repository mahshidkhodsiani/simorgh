<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="موسسه فرهنگی هنری هفت هنر سیمرغ؛ رادیو سیمرغ و سریال صوتی شب‌های تهران، پکیج‌های آموزشی و دوره‌های بازیگری، دوبله و گویندگی، گریم سینمایی، موشن گرافیک، عکاسی و تدوین.">
    <meta name="keywords"
        content="موسسه فرهنگی هنری هفت هنر سیمرغ, رادیو سیمرغ, شب‌های تهران, سریال صوتی, پکیج آموزشی, آموزشگاه هنری, آموزش بازیگری, آموزش گویندگی, دوبله, گریم سینمایی, موشن گرافیک, عکاسی, تدوین">
    <meta name="author" content="موسسه فرهنگی هنری هفت هنر سیمرغ">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
    <link rel="canonical" href="https://simorghtv.com/">
    <meta property="og:site_name" content="موسسه فرهنگی هنری هفت هنر سیمرغ">
    <meta property="og:title" content="موسسه فرهنگی هنری هفت هنر سیمرغ">
    <meta property="og:description"
        content="رادیو سیمرغ و سریال صوتی شب‌های تهران، پکیج‌های آموزشی و دوره‌های هنری بازیگری، دوبله، گویندگی، گریم و موشن گرافیک.">
    <meta property="og:image" content="https://simorghtv.com/images/logo1.png">
    <meta property="og:url" content="https://simorghtv.com/">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fa_IR">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="موسسه فرهنگی هنری هفت هنر سیمرغ">
    <meta name="twitter:description"
        content="رادیو سیمرغ، شب‌های تهران و پکیج‌های آموزشی هنری موسسه فرهنگی هنری هفت هنر سیمرغ.">
    <meta name="twitter:image" content="https://simorghtv.com/images/logo1.png">
    <title>موسسه فرهنگی هنری هفت هنر سیمرغ</title>
    <link rel="preload" as="image" href="images/29.jpg" fetchpriority="high">
    <link rel="icon" href="/images/logo1.ico" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">


    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": ["EducationalOrganization", "Organization"],
                "@id": "https://simorghtv.com/#organization",
                "name": "موسسه فرهنگی هنری هفت هنر سیمرغ",
                "alternateName": ["هفت هنر سیمرغ", "رادیو سیمرغ"],
                "url": "https://simorghtv.com/",
                "logo": "https://simorghtv.com/images/logo1.png",
                "description": "موسسه فرهنگی هنری با رادیو سیمرغ، سریال صوتی شب‌های تهران و پکیج‌های آموزشی بازیگری، دوبله، گویندگی، گریم، موشن گرافیک، عکاسی و تدوین.",
                "contactPoint": {
                    "@type": "ContactPoint",
                    "telephone": "+98-21-91300517",
                    "contactType": "customer service",
                    "areaServed": "IR",
                    "availableLanguage": "Persian"
                }
            },
            {
                "@type": "WebSite",
                "@id": "https://simorghtv.com/#website",
                "url": "https://simorghtv.com/",
                "name": "موسسه فرهنگی هنری هفت هنر سیمرغ",
                "inLanguage": "fa-IR",
                "publisher": { "@id": "https://simorghtv.com/#organization" }
            },
            {
                "@type": "RadioSeries",
                "@id": "https://simorghtv.com/radios#radio",
                "name": "رادیو سیمرغ",
                "description": "برنامه‌های رادیویی فرهنگی و هنری با صدای گویندگان حرفه‌ای.",
                "url": "https://simorghtv.com/radios",
                "inLanguage": "fa-IR",
                "publisher": { "@id": "https://simorghtv.com/#organization" }
            },
            {
                "@type": "PodcastSeries",
                "name": "شب‌های تهران",
                "description": "سریال صوتی شب‌های تهران در دو فصل، از رادیو سیمرغ.",
                "url": "https://simorghtv.com/radios/tehran1.php",
                "inLanguage": "fa-IR",
                "publisher": { "@id": "https://simorghtv.com/#organization" }
            }
        ]
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

    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" fetchpriority="high" src="images/29.jpg" alt="موسسه فرهنگی هنری هفت هنر سیمرغ - اسلاید اول">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" loading="lazy" src="images/27.jpg" alt="دوره‌های آموزشی موسسه هفت هنر سیمرغ - اسلاید دوم">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" loading="lazy" src="images/26.jpg" alt="پکیج‌های آموزشی سیمرغ - اسلاید سوم">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" loading="lazy" src="images/28.jpg" alt="آموزش گویندگی و بازیگری سیمرغ - اسلاید چهارم">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" loading="lazy" src="images/25.jpg" alt="گویندگان رادیو سیمرغ - اسلاید پنجم">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
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
        <section id="portfolio" class="quick-section">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-md-5 col-lg-4 text-center">
                        <div class="quick-visual">
                            <img class="img-fluid rounded shadow-lg" src="images/37.png" alt="تصویر سیمرغ"
                                loading="lazy" decoding="async" style="max-height: 650px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="col-md-7 col-lg-8">
                        <div class="row g-3">
                            <?php
                            $quick_links = [
                                ['radios',                  'fa-microphone-lines', 'برنامه‌های رادیویی سیمرغ'],
                                ['packages',                'fa-box-open',         'پکیج‌های آموزشی'],
                                ['portofilo/pictures',      'fa-images',           'گالری و نمونه کارها'],
                                ['articles/speakers_archive','fa-headphones',      'گویندگان رادیو سیمرغ'],
                                ['portofilo/videos',        'fa-circle-play',      'ویدیوهای نمونه کار'],
                                ['register',                'fa-credit-card',      'پرداخت نقدی دوره‌ها'],
                                ['register2',               'fa-calendar-check',   'پرداخت اقساطی دوره‌ها'],
                                ['pardakht',                'fa-hand-holding-dollar','پرداخت آزاد به موسسه'],
                            ];
                            foreach ($quick_links as $q) {
                            ?>
                            <div class="col-6 card-spacing">
                                <a href="<?= $q[0] ?>" class="quick-link text-decoration-none" title="<?= $q[2] ?>">
                                    <div class="card h-100 quick-card">
                                        <div class="card-body d-flex align-items-center justify-content-center gap-3 p-4">
                                            <span class="quick-icon"><i class="fas <?= $q[1] ?>"></i></span>
                                            <h6 class="card-title rtl-title fw-bold mb-0"><?= $q[2] ?></h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- ===== سکشن اختصاصی رادیو سیمرغ ===== -->
    <section class="radio-showcase" id="radioShowcase" aria-labelledby="radioTitle">
        <div class="radio-bg-glow"></div>
        <div class="container position-relative">
            <div class="row align-items-center g-5">

                <div class="col-lg-6 order-lg-2">
                    <div class="radio-visual">
                        <div class="radio-disc">
                            <img src="images/radio-simorgh.jpg" alt="رادیو سیمرغ؛ سریال صوتی شب‌های تهران و برنامه‌های رادیویی" width="340" height="340" loading="lazy" decoding="async">
                        </div>
                        <div class="radio-waves" aria-hidden="true">
                            <span></span><span></span><span></span><span></span><span></span>
                            <span></span><span></span><span></span><span></span><span></span>
                            <span></span><span></span>
                        </div>
                        <div class="radio-floating radio-floating--a"><i class="fas fa-microphone-lines"></i></div>
                        <div class="radio-floating radio-floating--b"><i class="fas fa-headphones"></i></div>
                    </div>
                </div>

                <div class="col-lg-6 order-lg-1 text-center text-lg-end">
                    <span class="radio-badge"><i class="radio-dot"></i> شنیدنی‌های سیمرغ</span>
                    <h2 class="radio-title" id="radioTitle">رادیو سیمرغ</h2>
                    <p class="radio-subtitle">سفری شنیدنی در دنیای فرهنگ و هنر</p>
                    <p class="radio-text">
                        <a href="radios" class="radio-inline-link">برنامه‌های رادیویی سیمرغ</a> و سریال صوتی
                        <a href="radios/tehran1.php" class="radio-inline-link">شب‌های تهران</a> را با صدای گویندگان
                        حرفه‌ای بشنوید؛ گفت‌وگو، روایت و صداهایی که هنر و فرهنگ را به گوش شما می‌رساند.
                        برای سفارش صدا هم می‌توانید از
                        <a href="articles/speakers_archive" class="radio-inline-link">آرشیو گویندگان رادیو سیمرغ</a>
                        استفاده کنید.
                    </p>

                    <div class="radio-chips">
                        <span><a href="radios/tehran1.php" title="سریال صوتی شب‌های تهران فصل اول"><i class="fas fa-moon"></i> شب‌های تهران ۱</a></span>
                        <span><a href="radios/tehran2.php" title="سریال صوتی شب‌های تهران فصل دوم"><i class="fas fa-moon"></i> شب‌های تهران ۲</a></span>
                        <span><a href="radios/cafe_meh.php" title="سریال صوتی کافه مه‌آلود"><i class="fas fa-mug-hot"></i> کافه مه‌آلود</a></span>
                        <span><a href="radios/radio_simorgh.php" title="جمعه‌های سیمرغی"><i class="fas fa-podcast"></i> جمعه‌های سیمرغی</a></span>
                    </div>

                    <div class="radio-actions">
                        <a href="radios" class="btn-radio-main" title="گوش دادن به برنامه‌های رادیو سیمرغ">
                            <i class="fas fa-play"></i> گوش دادن به برنامه‌ها
                        </a>
                        <a href="articles/speakers_archive" class="btn-radio-ghost" title="آرشیو گویندگان رادیو سیمرغ">
                            گویندگان رادیو
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="container-fluid px-4">
        <section class="packages-section">
            <div class="container">
                <div class="sec-head">
                    <span class="sec-eyebrow">پکیج آموزشی ویژه</span>
                    <h2 class="sec-title">
                        <a href="packages" title="مشاهده همه پکیج‌های آموزشی سیمرغ">پکیج آموزشی ویژه سیمرغ</a>
                    </h2>
                    <div class="sec-line"></div>
                </div>

                <?php
                $sql = "SELECT * FROM packages ORDER BY id ASC LIMIT 1"; // اولین پکیج ثبت‌شده
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    if (is_object(json_decode($row["pictures"]))) {
                        $images = json_decode($row["pictures"], true);
                        $image_url = $images["images"]["original"];
                        $image_url = str_replace("/upload", "upload", $image_url);
                    } else {
                        $image_url = $row["pictures"];
                        $image_url = str_replace("../upload", "upload", $image_url);
                    }

                    $plain_desc = trim(preg_replace('/\s+/u', ' ', strip_tags($row['description'])));
                    if (mb_strlen($plain_desc) > 280) {
                        $plain_desc = mb_substr($plain_desc, 0, 280) . '…';
                    }

                    $abs_img = (strpos($image_url, 'http') === 0) ? $image_url : 'https://simorghtv.com/' . ltrim($image_url, '/');
                    $course_ld = [
                        '@context' => 'https://schema.org',
                        '@type' => 'Course',
                        'name' => $row['name'],
                        'description' => $plain_desc,
                        'image' => $abs_img,
                        'url' => 'https://simorghtv.com/packages',
                        'inLanguage' => 'fa-IR',
                        'provider' => [
                            '@type' => 'Organization',
                            'name' => 'موسسه هفت هنر سیمرغ',
                            'sameAs' => 'https://simorghtv.com/'
                        ]
                    ];
                ?>
                <script type="application/ld+json"><?= json_encode($course_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>

                <article class="pkg-feature">
                    <a class="pkg-feature__img" href="packages" title="<?= htmlspecialchars($row['name']) ?>">
                        <img src="<?= htmlspecialchars($image_url) ?>" alt="<?= htmlspecialchars($row['name']) ?>"
                            loading="lazy" decoding="async">
                        <span class="pkg-feature__ribbon"><i class="fas fa-star"></i> پکیج ویژه</span>
                    </a>
                    <div class="pkg-feature__body">
                        <h3 class="pkg-feature__title"><a href="packages"><?= htmlspecialchars($row['name']) ?></a></h3>
                        <div class="pkg-feature__bar"></div>
                        <p class="pkg-feature__desc"><?= htmlspecialchars($plain_desc) ?></p>
                        <div class="pkg-feature__actions">
                            <a href="packages" class="btn-pkg-main"><i class="fas fa-eye"></i> مشاهده پکیج</a>
                            <a href="packages" class="btn-pkg-ghost">همه پکیج‌ها <i class="fas fa-arrow-left"></i></a>
                        </div>
                    </div>
                </article>

                <?php } else {
                    echo '<p class="text-center text-muted">موردی یافت نشد</p>';
                } ?>

                <div class="text-center mt-4">
                    <a href="packages" class="pkg-more">
                        مشاهده بیشتر؛ همه پکیج‌های آموزشی <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <div class="container-fluid px-4">
        <section id="team" class="latest-section">
            <div class="container">
                <div class="sec-head sec-head--light">
                    <span class="sec-eyebrow">پیشنهادهای ویژه</span>
                    <h2 class="sec-title">تازه ترین ها</h2>
                    <div class="sec-line"></div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-4 mb-4">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" loading="lazy" decoding="async" src="images/audio.jpg" alt="card image">
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
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" loading="lazy" decoding="async" src="images/speaking3.jpg" alt="card image">
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
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" loading="lazy" decoding="async" src="images/packages.jpg" alt="card image">
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
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" loading="lazy" decoding="async" src="images/acting1.jpg" alt="card image">
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
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" loading="lazy" decoding="async" src="images/ordering.jpg" alt="card image">
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
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip flip-0">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>
                                                <img class="img-fluid" loading="lazy" decoding="async" src="images/radio-simorgh.jpg" alt="رادیو سیمرغ">
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

        <section class="blog-section">
            <div class="container">
                <div class="sec-head">
                    <span class="sec-eyebrow">مطالب آموزشی</span>
                    <h2 class="sec-title"><a href="articles" title="مشاهده همه مقالات">وبلاگ سیمرغ</a></h2>
                    <div class="sec-line"></div>
                </div>
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 4";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-3 mb-4 col-6">
                        <div class="card-four position-relative overflow-hidden">
                            <a href="articles" class="d-block">
                                <img src="<?= htmlspecialchars($row['images']) ?>" class="img-fluid w-100 hover-zoom"
                                    alt="<?= htmlspecialchars($row['title']) ?>" loading="lazy" decoding="async"
                                    style="height: 200px; object-fit: cover;">
                                <div class="title-overlay">
                                    <h5 class="card-title text-white fw-bold p-2"><?= htmlspecialchars($row['title']) ?></h5>
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
    </div>

    <!-- بنر پایانی: سبک و بدون background-attachment:fixed برای حفظ سرعت -->
    <section class="cta-banner">
        <img class="cta-banner__bg" src="images/33.webp" alt="" loading="lazy" aria-hidden="true">
        <div class="cta-banner__overlay"></div>
        <div class="container cta-banner__content">
            <h2>دنیای هنر در دستان شماست!</h2>
            <p>با دوره‌های تخصصی موسسه هفت هنر سیمرغ، استعدادهای خود را کشف و شکوفا کنید و به جمع هنرمندان حرفه‌ای بپیوندید.</p>
            <a href="register2" class="btn-cta">همین حالا ثبت نام کنید <i class="fas fa-arrow-left"></i></a>
        </div>
    </section>

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

        <!-- ===== استوری ها ===== -->
        <script>
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
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
            integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
        </script>

    <?php include "footer.php"; ?>

</body>

</html>