<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Meta Tags سئو شده -->
    <title>رادیو سیمرغ | پخش آنلاین برنامه‌های رادیویی | شب‌های تهران | کافه مه‌آلود</title>
    <meta name="description"
        content="رادیو سیمرغ، شب‌های تهران و کافه مه‌آلود - پخش آنلاین بهترین برنامه‌های رادیویی، موسیقی، فرهنگ و هنر. با ما همراه شوید و از محتوای جذاب لذت ببرید.">
    <meta name="keywords"
        content="رادیو سیمرغ, شب‌های تهران, کافه مه‌آلود, رادیو آنلاین, برنامه رادیویی, موسیقی, فرهنگ, هنر">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta name="robots" content="index, follow">

    <!-- Open Graph برای شبکه‌های اجتماعی -->
    <meta property="og:title" content="رادیو سیمرغ | پخش آنلاین برنامه‌های رادیویی">
    <meta property="og:description" content="بهترین برنامه‌های رادیویی با کیفیت عالی">
    <meta property="og:image" content="../images/radio-simorgh.jpg">
    <meta property="og:url" content="https://yourdomain.com/radio/index.php">
    <meta property="og:type" content="website">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://yourdomain.com/radio/index.php">

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    /* استایل‌های سفارشی و جذاب */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 30px;
        padding: 60px 20px;
        margin-bottom: 50px;
        text-align: center;
        color: white;
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
        /* تغییر: محتوا به دو بخش بالا و پایین تقسیم میشه */
        align-items: center;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        padding: 30px;
        padding-bottom: 40px;
    }

    /* لایه تیره روی تصویر پس‌زمینه برای خوانایی بهتر متن */
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

    /* همه محتویات داخل کارت باید بالای لایه تیره باشند */
    .radio-card>* {
        position: relative;
        z-index: 2;
    }

    .radio-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 30px 45px -15px rgba(0, 0, 0, 0.3);
    }

    .radio-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
        transform: rotate(45deg);
        transition: all 0.6s;
        opacity: 0;
        z-index: 3;
    }

    .radio-card:hover::before {
        opacity: 1;
        transform: rotate(45deg) scale(1.2);
    }

    /* بخش بالایی کارت (برای آیکون یا فضای خالی) */
    .card-top {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    /* بخش پایینی کارت (متن‌ها و دکمه) */
    .card-bottom {
        width: 100%;
        text-align: center;
        margin-top: auto;
    }

    /* عکس پس‌زمینه برای رادیو سیمرغ */
    .card-simorgh {
        background-image: url('../images/36.png');
    }

    /* عکس پس‌زمینه برای شب‌های تهران */
    .card-tehran {
        background-image: url('../images/34.png');
    }

    /* عکس پس‌زمینه برای کافه مه‌آلود */
    .card-cafe {
        background-image: url('../images/35.png');
        /* این رو می‌تونید تغییر بدید */
    }

    /* اگر عکس کافه مه‌آلود ندارید، می‌تونید از یک عکس پیش‌فرض استفاده کنید */
    /* .card-cafe {
        background-image: url('../images/default-cafe.jpg');
    } */

    .radio-icon {
        font-size: 4rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        width: 100px;
        height: 100px;
        line-height: 100px;
        border-radius: 50px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .radio-card:hover .radio-icon {
        transform: scale(1.1) rotate(5deg);
        background: rgba(255, 255, 255, 0.3);
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
        color: #f5576c;
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
        background: #f8f9fa;
        border-radius: 30px;
        padding: 40px 20px;
        margin-top: 50px;
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

        .radio-card {
            margin-bottom: 30px;
            min-height: 380px;
            padding: 20px;
            padding-bottom: 30px;
        }

        .radio-title {
            font-size: 1.3rem;
        }

        .radio-description {
            font-size: 0.85rem;
        }

        .radio-icon {
            width: 70px;
            height: 70px;
            line-height: 70px;
            font-size: 2rem;
        }

        .btn-listen {
            padding: 8px 20px;
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
        <!-- بخش Hero جذاب -->
        <div class="hero-section">
            <h1 class="hero-title">🎙️ به رادیو سیمرغ خوش آمدید</h1>
            <p class="hero-subtitle">تجربه‌ای نو از شنیدن بهترین برنامه‌های رادیویی با کیفیت عالی</p>
        </div>

        <!-- سه مستطیل اصلی با لینک‌ها -->
        <div class="row justify-content-center">


            <!-- مستطیل 2: شب‌های تهران -->
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="tehran.php" style="text-decoration: none; display: block; height: 100%;">
                    <div class="radio-card card-tehran">
                        <div class="card-top">

                        </div>
                        <div class="card-bottom">
                            <h2 class="radio-title">شب‌های تهران</h2>
                            <p class="radio-description">
                                روایت دلنشین شب‌های پایتخت، خاطرات شهری،<br>
                                موسیقی ماندگار و لحظات ناب
                            </p>
                            <div class="btn-listen">
                                بشنو 🌙
                            </div>
                        </div>
                    </div>
                </a>
            </div>



            <!-- مستطیل 3: کافه مه‌آلود (جدید) -->
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="cafe_meh.php" style="text-decoration: none; display: block; height: 100%;">
                    <div class="radio-card card-cafe">
                        <div class="card-top">

                        </div>
                        <div class="card-bottom">
                            <h2 class="radio-title">کافه مه‌آلود</h2>
                            <p class="radio-description">
                                فضایی گرم و صمیمی با موسیقی ملایم،<br>
                                گفتگوهای دلنشین و لحظاتی به یادماندنی
                            </p>
                            <div class="btn-listen">
                                بنشین ☕
                            </div>
                        </div>
                    </div>
                </a>
            </div>




            <!-- مستطیل 1: رادیو سیمرغ -->
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="radio_simorgh.php" style="text-decoration: none; display: block; height: 100%;">
                    <div class="radio-card card-simorgh">
                        <div class="card-top">

                        </div>
                        <div class="card-bottom">
                            <h2 class="radio-title">جمعه های سیمرغی</h2>
                            <p class="radio-description">
                                پخش زنده و آرشیو بهترین برنامه‌های فرهنگی،<br>
                                هنری و موسیقی با صدای گرم گویندگان حرفه‌ای
                            </p>
                            <div class="btn-listen">
                                گوش کن 🎧
                            </div>
                        </div>
                    </div>
                </a>
            </div>


        </div>

        <!-- بخش آمار جذاب -->
        <div class="stats-section">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">+۱۰۰,۰۰۰</div>
                        <div class="stat-label">شنونده فعال</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">+۵۰۰</div>
                        <div class="stat-label">برنامه متنوع</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">۲۴/۷</div>
                        <div class="stat-label">پخش آنلاین</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- بخش توضیحات اضافی برای سئو -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">بهترین انتخاب برای شنیدن برنامه‌های رادیویی</h3>
                        <p class="text-justify">
                            رادیو سیمرغ با سال‌ها تجربه در تولید محتوای فرهنگی و هنری، همواره تلاش کرده است تا بهترین
                            برنامه‌های رادیویی را برای مخاطبان عزیز فراهم آورد. برنامه "شب‌های تهران" با روایت‌های
                            شنیدنی از پایتخت ایران، شما را به سفری دلنشین در کوچه پس کوچه‌های خاطره‌انگیز تهران می‌برد.
                        </p>
                        <p class="text-justify">
                            "کافه مه‌آلود" فضایی تازه و متفاوت است که شما را به دنیایی از موسیقی ملایم، گفتگوهای صمیمی
                            و لحظاتی آرامش‌بخش دعوت می‌کند. با ما همراه باشید و از شنیدن بهترین موسیقی‌ها، گفتگوهای
                            تخصصی و برنامه‌های متنوع لذت ببرید.
                        </p>
                        <p class="text-justify">
                            کافیست روی هر کدام از مستطیل‌های بالا کلیک کنید تا وارد دنیای جذاب رادیو سیمرغ، شب‌های تهران
                            یا کافه مه‌آلود شوید.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
    // اضافه کردن افکت‌های جذاب با جاوااسکریپت
    document.querySelectorAll('.radio-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // اگر روی دکمه لینک کلیک شده، اجازه بده لینک باز شود
            if (e.target.classList.contains('btn-listen')) {
                return;
            }
            // در غیر این صورت لینک مربوطه را باز کن
            const link = this.closest('a');
            if (link && link.href) {
                window.location.href = link.href;
            }
        });
    });
    </script>

</body>

</html>