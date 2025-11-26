<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>جزئیات پکیج</title>

    <?php include "includes.php"; ?>
    <?php include "../config.php"; ?>

    <?php
    // دریافت دیتای پکیج
    $package = null;
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $package_id = (int) $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM `packages` WHERE `id` = ?");
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $package = $result->fetch_assoc();
        }
        $stmt->close();
    }

    $pageUrl   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
                . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $pageTitle = $package ? "جزئیات پکیج: " . $package['name'] : "جزئیات پکیج";
    $metaDesc  = $package
        ? "دوره " . ($package['name'] ?? 'آموزشی') . " با تدریس " . ($package['teacher'] ?? 'مدرس') . "، شامل توضیحات، قیمت، پیش‌نمایش و ویژگی‌ها."
        : "مشخصات و توضیحات پکیج آموزشی.";
    $imageUrl  = ($package && !empty($package['pictures'])) ? "../" . htmlspecialchars($package['pictures']) : null;
    ?>

    <!-- سئو پایه -->
    <meta name="description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <link rel="canonical" href="<?php echo htmlspecialchars($pageUrl); ?>">
    <meta property="og:locale" content="fa_IR">
    <meta property="og:type" content="product">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($pageUrl); ?>">
    <?php if ($imageUrl): ?>
        <meta property="og:image" content="<?php echo $imageUrl; ?>">
        <meta property="og:image:alt" content="<?php echo htmlspecialchars($package['name']); ?>">
    <?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <?php if ($imageUrl): ?>
        <meta name="twitter:image" content="<?php echo $imageUrl; ?>">
    <?php endif; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
        /* پس‌زمینه کلی صورتی مطابق تصویر */
        body {
            background: #ffe3eb;
            color: #111827;
        }
        .container-narrow { max-width: 1100px; }

        /* هرو دو ستونه با پس‌زمینه صورتی روشن و خطوط ملایم */
        .hero {
            background: #ffd6e3;
            border: 1px solid #ffc6d7;
            border-radius: 1rem;
            padding: 1.5rem;
        }
        .hero-right-title {
            font-size: 2rem;
            font-weight: 900;
            color: #111111;
        }
        .hero-right-sub {
            font-size: 1.05rem;
            color: #5b5b5b;
            margin-bottom: .75rem;
        }

        /* دکمه ثبت‌نام بالا-چپ */
        .register-top {
            display: inline-block;
            background: #111111;
            color: #ffffff;
            font-weight: 800;
            border-radius: .6rem;
            padding: .7rem 1rem;
            text-decoration: none;
        }
        .register-top:hover { background: #000; color: #fff; }

        /* کارت مدرس کارتونی و نشان‌ها */
        .teacher-card {
            background: #ffe9f0;
            border: 1px solid #ffc6d7;
            border-radius: 1rem;
            padding: 1rem;
            text-align: center;
        }
        .teacher-illustration {
            width: 180px; height: 180px; object-fit: cover;
            border-radius: 1rem;
            border: 4px solid #fff;
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
            background: #fff; /* اگر تصویر مدرس ندارید، سفید می‌ماند */
        }
        .teacher-name {
            font-weight: 800; color: #111111; margin-top: .75rem;
        }
        .badge-list {
            margin-top: 1rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .5rem;
        }
        .badge-item {
            background: #ffffff;
            border: 1px solid #ffc6d7;
            color: #111827;
            padding: .5rem .7rem;
            border-radius: .6rem;
            font-weight: 700;
            display: flex; align-items: center; gap: .5rem;
        }

        /* جعبه پکیج سمت راست */
        .package-box {
            background: #fff;
            border: 1px solid #ffc6d7;
            border-radius: .75rem;
            padding: 1rem;
            text-align: center;
        }
        .package-cover {
            width: 100%;
            max-height: 360px;
            object-fit: cover;
            border-radius: .75rem;
            border: 1px solid #ffc6d7;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }
        .package-caption {
            margin-top: .6rem;
            color: #444;
            font-weight: 700;
        }

        /* قیمت و CTA داخل هرو (سمت راست زیر عنوان) */
        .price-wrap {
            display: inline-flex; align-items: center; gap: .5rem;
            background: #fff;
            border: 1px solid #ffc6d7;
            color: #b42318;
            padding: .5rem .8rem;
            border-radius: .6rem;
            font-weight: 800;
        }
        .cta-btn {
            background: #111111; color: #fff; border: none;
            font-weight: 900; padding: .8rem 1.2rem; border-radius: .6rem;
        }
        .cta-btn:hover { background: #000; }

        /* بخش ویدیو + متن توضیح مطابق تصویر دوم */
        .video-section {
            background: #ffe9f0;
            border: 1px solid #ffc6d7;
            border-radius: 1rem;
            padding: 1rem;
        }
        .ratio { position: relative; width: 100%; }
        .ratio-16x9 { padding-top: 56.25%; }
        .ratio > video, .ratio > iframe {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            border-radius: .75rem; border: 1px solid #ffc6d7; background: #fff;
        }
        .course-text {
            margin-top: 1rem; color: #333; line-height: 2;
            font-size: 1rem;
        }
        .course-text h2 {
            font-size: 1.3rem; font-weight: 900; margin-bottom: .75rem; color: #111;
        }

        /* لینک‌ها */
        .file-link { color: #0d6efd; font-weight: 700; text-decoration: none; }
        .file-link:hover { text-decoration: underline; }

        /* ریسپانسیو */
        @media (max-width: 992px) {
            .hero-right-title { font-size: 1.7rem; }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<?php if (!$package): ?>
    <div class="container container-narrow mt-5">
        <div class="alert alert-warning text-center">
            ⚠️ شناسه پکیج (ID) به درستی تعیین نشده یا پکیج یافت نشد. لطفاً از طریق صفحه اصلی اقدام کنید.
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <?php $conn->close(); ?>
    </body>
</html>
<?php exit; endif; ?>

<?php
// آماده‌سازی مقادیر امن
$safeName    = htmlspecialchars($package['name']);
$safeTeacher = htmlspecialchars($package['teacher']);
$safeDesc    = nl2br(htmlspecialchars($package['description']));
$safeAddress = !empty($package['address']) ? htmlspecialchars($package['address']) : null;
$safePrice   = isset($package['price']) ? number_format((int)$package['price']) : "—";
$safeCover   = !empty($package['pictures']) ? "../" . htmlspecialchars($package['pictures']) : null;
$safeFile1   = !empty($package['file1']) ? "../" . htmlspecialchars($package['file1']) : null;
$safeFile2   = !empty($package['file2']) ? "../" . htmlspecialchars($package['file2']) : null;
$safeFile3   = !empty($package['file3']) ? "../" . htmlspecialchars($package['file3']) : null;
$spotPlayer  = !empty($package['spotplayer']) ? htmlspecialchars($package['spotplayer']) : null;

// Badge ها: منبع را از ستون course اگر موجود باشد
$courseBadge = !empty($package['course']) ? htmlspecialchars($package['course']) : "مقدماتی تا پیشرفته";

// ساخت عنوان صفحه
echo "<script>document.title = " . json_encode("جزئیات پکیج: " . $safeName, JSON_UNESCAPED_UNICODE) . ";</script>";
?>

<!-- نوار دکمه ثبت‌نام بالای سمت چپ -->
<div class="container container-narrow mt-4">
    <div class="d-flex justify-content-start">
        <a href="#register" class="register-top">ثبت نام در دوره</a>
    </div>
</div>

<!-- هرو دو ستونه مطابق تصویر: سمت چپ مدرس و نشان‌ها، سمت راست عنوان‌ها و تصویر بسته -->
<main class="container container-narrow my-3">
    <section class="hero">
        <div class="row g-4 align-items-start">
            <!-- سمت چپ: مدرس کارتونی + نشان‌ها -->
            <div class="col-lg-5">
                <div class="teacher-card">
                    <!-- اگر تصویر مدرس دارید، اینجا قرار دهید. فعلاً از کاور به‌عنوان نمونه استفاده نمی‌کنیم تا شبیه تصویر کارتونی باشد -->
                    <div class="teacher-illustration d-inline-block"></div>
                    <div class="teacher-name"><?php echo $safeTeacher; ?></div>

                    <div class="badge-list">
                        <div class="badge-item">🛡️ <span>۱ سال پشتیبانی</span></div>
                        <div class="badge-item">📦 <span>۷ بخش</span></div>
                        <div class="badge-item">⚙️ <span>در حال تکمیل</span></div>
                        <div class="badge-item">🎓 <span>۱۰۰٪ رایگان همراه با ضمانت یادگیری</span></div>
                    </div>

                    <?php if ($spotPlayer): ?>
                        <div class="mt-3">
                            <a class="file-link" href="<?php echo $spotPlayer; ?>" target="_blank" rel="noopener">مشاهده در SpotPlayer</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- سمت راست: عنوان‌ها، قیمت+CTA، تصویر بسته -->
            <div class="col-lg-7">
                <h1 class="hero-right-title">آموزش استادی سینما فوردی</h1>
                <div class="hero-right-sub">مقدماتی تا پیشرفته</div>
                <div class="hero-right-sub">با تدریس <?php echo $safeTeacher; ?></div>

                <div class="d-flex align-items-center gap-3 my-3">
                    <div class="price-wrap">
                        <span>💰 قیمت:</span>
                        <strong><?php echo $safePrice; ?> تومان</strong>
                    </div>
                    <form action="cart_handler.php" method="POST" id="register">
                        <input type="hidden" name="package_id" value="<?php echo (int)$package['id']; ?>">
                        <button type="submit" class="cta-btn">
                            ثبت‌نام و افزودن به سبد خرید
                        </button>
                    </form>
                </div>

                <div class="package-box mt-2">
                    <?php if ($safeCover): ?>
                        <img class="package-cover" src="<?php echo $safeCover; ?>" alt="تصویر پکیج <?php echo $safeName; ?>">
                        <div class="package-caption">دوره آموزش مدل سازی سینما فوردی ۲۰۲۳</div>
                    <?php else: ?>
                        <div class="text-muted">تصویر پکیج موجود نیست</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- بخش ویدیو + متن توضیح مطابق تصویر دوم -->
    <section class="video-section mt-4">
        <div class="row g-4">
            <div class="col-lg-5">
                <?php if ($safeFile1): ?>
                    <div class="ratio ratio-16x9">
                        <video controls preload="metadata" aria-label="پیش‌نمایش دوره <?php echo $safeName; ?>">
                            <source src="<?php echo $safeFile1; ?>" type="video/mp4">
                            مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                        </video>
                    </div>
                <?php else: ?>
                    <div class="text-muted">پیش‌نمایش ویدیویی موجود نیست</div>
                <?php endif; ?>
            </div>
            <div class="col-lg-7">
                <div class="course-text">
                    <h2>آموزش استادی سینما فوردی</h2>
                    <p>
                        دوره آموزش استادی سینما فوردی یک دوره بسیار جامع می‌باشد که شما را از دیگر دوره‌ها بی‌نیاز خواهد کرد.
                        در این دوره بخش ابتدایی که آموزش عمومی سینما فوردی می‌باشد کاملا رایگان در اختیار علاقه‌مندان قرار خواهد گرفت
                        تا با سبک تدریس آشنا شده و در صورت نیاز با اطمینان بیشتری اقدام به خریداری نمایید.
                    </p>
                    <!-- اگر می‌خواهید متن شرح را از دیتابیس جایگزین کنید: -->
                    <div class="mt-3">
                        <?php echo $safeDesc; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- فایل‌ها و منابع اضافه (اختیاری) -->
    <?php if ($safeFile2 || $safeFile3): ?>
    <section class="mt-4">
        <div class="video-section">
            <h3 class="h6 mb-3" style="font-weight:900;color:#111">📁 فایل‌ها و منابع</h3>
            <ul class="list-unstyled m-0">
                <?php if ($safeFile2): ?>
                    <li class="mb-2">
                        <span class="me-2">•</span>
                        <a class="file-link" href="<?php echo $safeFile2; ?>" target="_blank" rel="noopener">دانلود فایل ۲</a>
                    </li>
                <?php endif; ?>
                <?php if ($safeFile3): ?>
                    <li>
                        <span class="me-2">•</span>
                        <a class="file-link" href="<?php echo $safeFile3; ?>" target="_blank" rel="noopener">دانلود فایل ۳</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php
// اسکیما JSON-LD برای سئو
$schemaCourse = [
    "@context" => "https://schema.org",
    "@type" => "Course",
    "name" => $package['name'],
    "description" => strip_tags($package['description']),
    "provider" => [
        "@type" => "Person",
        "name" => $package['teacher']
    ]
];
$schemaProduct = [
    "@context" => "https://schema.org",
    "@type" => "Product",
    "name" => $package['name'],
    "description" => strip_tags($package['description']),
    "image" => $safeCover ?: null,
    "brand" => [ "@type" => "Organization", "name" => "آکادمی آموزشی" ],
    "offers" => [
        "@type" => "Offer",
        "priceCurrency" => "IRR",
        "price" => (string) ((int) $package['price']),
        "availability" => "https://schema.org/InStock",
        "url" => $pageUrl
    ]
];
?>
<script type="application/ld+json">
<?php echo json_encode($schemaCourse, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
</script>
<script type="application/ld+json">
<?php echo json_encode($schemaProduct, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
</script>

<?php include 'footer.php'; ?>
<?php $conn->close(); ?>

<!-- ویجت گفتینو -->
<script type="text/javascript">
!function(){
    var i="4Ey6dG",a=window,d=document;
    function g(){
        var g=d.createElement("script"),
            s="https://www.goftino.com/widget/"+i,
            l=localStorage.getItem("goftino_"+i);
        g.async=!0,g.src=l?s+"?o="+l:s;
        d.getElementsByTagName("head")[0].appendChild(g);
    }
    "complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);
}();
</script>

</body>
</html>
