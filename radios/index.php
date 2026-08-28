<?php
session_start();
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#764ba2">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="رادیو سیمرغ">
    <link rel="apple-touch-icon" href="../images/36.png">

    <!-- ========================================== -->
    <!-- عنوان و توضیحات بهینه‌شده برای سئو          -->
    <!-- ========================================== -->
    <title>رادیو سیمرغ | پادکست و داستان‌های صوتی شب‌های تهران و کافه مه‌آلود</title>
    <meta name="description" content="رادیو سیمرغ: پخش آنلاین پادکست و داستان‌های صوتی شب‌های تهران و کافه مه‌آلود. بهترین برنامه‌های رادیویی، داستان‌های صوتی و پادکست‌های فرهنگی را با کیفیت عالی بشنوید.">
    <meta name="keywords" content="رادیو, رادیو آنلاین, پادکست, داستان صوتی, کتاب صوتی, شب‌های تهران, کافه مه‌آلود, رادیو سیمرغ, پادکست فارسی, داستان شب, برنامه رادیویی, موسیقی سنتی, فرهنگ و هنر">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
    <link rel="canonical" href="https://simorghtv.com/radios/index.php">

    <!-- ========================================== -->
    <!-- تگ‌های Open Graph برای شبکه‌های اجتماعی    -->
    <!-- ========================================== -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="رادیو سیمرغ | پادکست و داستان‌های صوتی شب‌های تهران و کافه مه‌آلود">
    <meta property="og:description" content="رادیو سیمرغ، پخش آنلاین پادکست و داستان‌های صوتی با کیفیت بالا. شب‌های تهران، کافه مه‌آلود و جمعه‌های سیمرغی.">
    <meta property="og:url" content="https://simorghtv.com/radios/index.php">
    <meta property="og:site_name" content="رادیو سیمرغ">
    <meta property="og:image" content="https://simorghtv.com/images/36.png">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">

    <!-- ========================================== -->
    <!-- تگ‌های Twitter Card                         -->
    <!-- ========================================== -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="رادیو سیمرغ | پادکست و داستان‌های صوتی شب‌های تهران و کافه مه‌آلود">
    <meta name="twitter:description" content="رادیو سیمرغ، پخش آنلاین پادکست و داستان‌های صوتی با کیفیت بالا.">
    <meta name="twitter:image" content="https://simorghtv.com/images/36.png">

    <!-- ========================================== -->
    <!-- دیتاهای ساختاریافته (JSON-LD) برای سئو پیشرفته -->
    <!-- ========================================== -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "رادیو سیمرغ",
        "url": "https://simorghtv.com/radios/",
        "description": "پخش آنلاین پادکست و داستان‌های صوتی شب‌های تهران و کافه مه‌آلود",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://simorghtv.com/radios/search?q={search_term_string}",
            "query-input": "required name=search_term_string"
        },
        "sameAs": [
            "https://www.instagram.com/simorghtv/",
            "https://t.me/simorgh_radio"
        ]
    }
    </script>

    <!-- Schema.org برای برنامه رادیویی -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RadioBroadcastService",
        "name": "رادیو سیمرغ",
        "description": "پخش آنلاین پادکست و داستان‌های صوتی",
        "url": "https://simorghtv.com/radios/",
        "broadcastDisplayName": "رادیو سیمرغ",
        "inLanguage": "fa-IR"
    }
    </script>

    <!-- Schema.org برای هر سریال صوتی -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "PodcastSeries",
        "name": "شب‌های تهران",
        "description": "سریال صوتی شب‌های تهران، روایت‌های شنیدنی از پایتخت ایران",
        "url": "https://simorghtv.com/radios/tehran.php",
        "language": "fa",
        "genre": "داستان صوتی"
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "PodcastSeries",
        "name": "کافه مه‌آلود",
        "description": "سریال صوتی کافه مه‌آلود، فضایی آرامش‌بخش با موسیقی و گفتگو",
        "url": "https://simorghtv.com/radios/cafe_meh.php",
        "language": "fa",
        "genre": "پادکست فرهنگی"
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "PodcastSeries",
        "name": "جمعه‌های سیمرغی",
        "description": "پخش زنده و آرشیو بهترین برنامه‌های فرهنگی، هنری و موسیقی",
        "url": "https://simorghtv.com/radios/radio_simorgh.php",
        "language": "fa",
        "genre": "برنامه رادیویی"
    }
    </script>

    <!-- ========================================== -->
    <!-- لینک‌های هدر (فاوآیکن و ...)              -->
    <!-- ========================================== -->
    <?php include "includes.php"; ?>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    /* ===== استایل‌های صفحه (بدون تغییر در منطق) ===== */
    body {
        background: #f5f5f5;
    }
    
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 30px;
        padding: 60px 20px;
        margin-bottom: 50px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        animation: fadeInUp 0.8s ease;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.95;
        animation: fadeInUp 0.8s ease 0.2s both;
    }

    .install-permanent-btn {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 1rem;
        margin-top: 20px;
        animation: fadeInUp 0.8s ease 0.4s both;
        display: inline-block;
    }

    .install-permanent-btn:hover {
        background: white;
        color: #764ba2;
        transform: scale(1.05);
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }

    .radio-card {
        border-radius: 30px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
        min-height: 450px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 30px;
        padding-bottom: 40px;
    }

    .radio-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
        transition: all 0.4s;
    }

    .radio-card:hover::after {
        background: rgba(0, 0, 0, 0.6);
    }

    .radio-card>* {
        position: relative;
        z-index: 2;
    }

    .radio-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 45px -15px rgba(0, 0, 0, 0.3);
    }

    .card-simorgh {
        background-image: url('../images/36.png');
    }

    .card-tehran {
        background-image: url('../images/34.png');
    }

    .card-cafe {
        background-image: url('../images/35.png');
    }

    .radio-title {
        font-weight: bold;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        font-size: 1.8rem;
        margin-bottom: 10px;
    }

    .radio-description {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.95);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .btn-listen {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border: 2px solid white;
        color: white;
        padding: 10px 30px;
        border-radius: 50px;
        transition: all 0.3s;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        margin-top: 5px;
    }

    .btn-listen:hover {
        background: white;
        color: #764ba2;
        transform: scale(1.05);
        text-decoration: none;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stats-section {
        background: white;
        border-radius: 30px;
        padding: 40px 20px;
        margin-top: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .stat-item {
        text-align: center;
        padding: 20px;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #667eea;
    }

    .stat-label {
        color: #666;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 1.8rem;
        }
        .hero-subtitle {
            font-size: 1rem;
        }
        .radio-card {
            margin-bottom: 30px;
            min-height: 350px;
            padding: 20px;
            padding-bottom: 30px;
        }
        .radio-title {
            font-size: 1.3rem;
        }
        .radio-description {
            font-size: 0.85rem;
        }
        .btn-listen {
            padding: 8px 20px;
            font-size: 0.9rem;
        }
        .install-permanent-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }
    }
    </style>
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
        
        <div class="hero-section">
            <h1 class="hero-title">🎙️ رادیو سیمرغ | پادکست و داستان‌های صوتی</h1>
            <p class="hero-subtitle">بهترین برنامه‌های رادیویی، پادکست‌های فرهنگی و داستان‌های صوتی را با کیفیت عالی بشنوید</p>
            
            <button id="installPermanentBtn" class="install-permanent-btn">
                📲 نصب اپلیکیشن رادیو سیمرغ
            </button>
        </div>

        <div class="row justify-content-center">

            <div class="col-md-6 col-lg-4 mb-4">
                <a href="tehran.php" style="text-decoration: none; display: block; height: 100%;">
                    <div class="radio-card card-tehran">
                        <div class="card-top"></div>
                        <div class="card-bottom">
                            <h2 class="radio-title">سریال صوتی شب‌های تهران</h2>
                            <p class="radio-description">
                                داستان‌های شنیدنی از پایتخت ایران، روایت‌هایی دلنشین از تهران قدیم
                            </p>
                            <div class="btn-listen">
                                بشنو 🌙
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <a href="cafe_meh.php" style="text-decoration: none; display: block; height: 100%;">
                    <div class="radio-card card-cafe">
                        <div class="card-top"></div>
                        <div class="card-bottom">
                            <h2 class="radio-title">سریال صوتی کافه مه‌آلود</h2>
                            <p class="radio-description">
                                پادکستی آرامش‌بخش با موسیقی ملایم، گفتگوهای صمیمی و لحظاتی ناب
                            </p>
                            <div class="btn-listen">
                                بنشین ☕
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4 mb-4">
                <a href="radio_simorgh.php" style="text-decoration: none; display: block; height: 100%;">
                    <div class="radio-card card-simorgh">
                        <div class="card-top"></div>
                        <div class="card-bottom">
                            <h2 class="radio-title">جمعه‌های سیمرغی</h2>
                            <p class="radio-description">
                                پخش زنده و آرشیو بهترین برنامه‌های فرهنگی، هنری و موسیقی با صدای گرم گویندگان حرفه‌ای
                            </p>
                            <div class="btn-listen">
                                گوش کن 🎧
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="stats-section">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">+۱۰۰,۰۰۰</div>
                        <div class="stat-label">شنونده فعال پادکست و رادیو</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">+۵۰۰</div>
                        <div class="stat-label">داستان صوتی و برنامه</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">۲۴/۷</div>
                        <div class="stat-label">پخش آنلاین رادیو و پادکست</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">بهترین انتخاب برای شنیدن پادکست و داستان‌های صوتی</h2>
                        <p class="text-justify">
                            <strong>رادیو سیمرغ</strong> با سال‌ها تجربه در تولید محتوای فرهنگی و هنری، همواره تلاش کرده است تا بهترین
                            <strong>پادکست‌ها و داستان‌های صوتی</strong> را برای مخاطبان عزیز فراهم آورد. 
                            <strong>سریال صوتی شب‌های تهران</strong> با روایت‌های شنیدنی از پایتخت ایران، شما را به سفری 
                            دلنشین در کوچه پس کوچه‌های خاطره‌انگیز تهران می‌برد.
                        </p>
                        <p class="text-justify">
                            <strong>سریال صوتی کافه مه‌آلود</strong> فضایی تازه و متفاوت است که شما را به دنیایی از 
                            موسیقی ملایم، گفتگوهای صمیمی و لحظاتی آرامش‌بخش دعوت می‌کند. 
                            با ما همراه باشید و از شنیدن بهترین موسیقی‌ها، گفتگوهای تخصصی و برنامه‌های متنوع لذت ببرید.
                        </p>
                        <p class="text-justify">
                            اگر به دنبال <strong>پادکست فارسی</strong>، <strong>داستان صوتی</strong> یا 
                            <strong>برنامه رادیویی</strong> با کیفیت بالا هستید، رادیو سیمرغ بهترین انتخاب برای شماست.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
    // ============================================
    // مدیریت نصب PWA (دقیقاً مشابه قبل - بدون تغییر)
    // ============================================
    let deferredPrompt;
    const installBtn = document.getElementById('installPermanentBtn');

    function isInstalled() {
        return window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
    }

    if (isInstalled()) {
        installBtn.style.display = 'none';
    }

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
    });

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
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const msg = isIOS ? 
                'در Safari روی Share و سپس Add to Home Screen کلیک کنید.' :
                'از منوی مرورگر گزینه Add to Home Screen را انتخاب کنید.';
            alert('📱 ' + msg);
        }
    });

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('sw.js', { scope: '/radios/' });
        });
    }
    </script>

</body>

</html>