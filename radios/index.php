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

    <!-- ========================================== -->
    <!-- سئو -->
    <!-- ========================================== -->
    <title>رادیو سیمرغ | شنیدن سریال صوتی شب‌های تهران و کافه مه‌آلود</title>
    <meta name="description"
        content="رادیو سیمرغ؛ پخش سریال صوتی شب‌های تهران (فصل اول و دوم)، کافه مه‌آلود و جمعه‌های سیمرغی. برنامه‌های رادیویی فرهنگی و هنری با صدای گویندگان حرفه‌ای.">
    <meta name="keywords"
        content="رادیو سیمرغ, رادیو, سریال صوتی, شب‌های تهران, فصل اول شب‌های تهران, فصل دوم شب‌های تهران, کافه مه‌آلود, جمعه‌های سیمرغی, برنامه رادیویی, گویندگان رادیو سیمرغ">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="theme-color" content="#0d1a47">
    <link rel="canonical" href="https://simorghtv.com/radios/">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fa_IR">
    <meta property="og:site_name" content="رادیو سیمرغ">
    <meta property="og:title" content="رادیو سیمرغ | شنیدن سریال صوتی و برنامه‌های رادیویی">
    <meta property="og:description"
        content="پخش سریال صوتی شب‌های تهران (فصل ۱ و ۲)، کافه مه‌آلود و جمعه‌های سیمرغی در رادیو سیمرغ.">
    <meta property="og:url" content="https://simorghtv.com/radios/">
    <meta property="og:image" content="https://simorghtv.com/images/36.png">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:image:alt" content="رادیو سیمرغ">

    <!-- Twitter (تصویر ۵۱۲×۵۱۲ مربع است، پس summary) -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@simorghtv">
    <meta name="twitter:title" content="رادیو سیمرغ | شنیدن سریال صوتی و برنامه‌های رادیویی">
    <meta name="twitter:description"
        content="پخش سریال صوتی شب‌های تهران (فصل ۱ و ۲)، کافه مه‌آلود و جمعه‌های سیمرغی.">
    <meta name="twitter:image" content="https://simorghtv.com/images/36.png">
    <meta name="twitter:image:alt" content="رادیو سیمرغ">

    <!-- JSON-LD یکپارچه -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "Organization",
                "@id": "https://simorghtv.com/#organization",
                "name": "موسسه هفت هنر سیمرغ",
                "alternateName": "رادیو سیمرغ",
                "url": "https://simorghtv.com/",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://simorghtv.com/images/logo1.png"
                }
            },
            {
                "@type": "CollectionPage",
                "@id": "https://simorghtv.com/radios/#webpage",
                "url": "https://simorghtv.com/radios/",
                "name": "رادیو سیمرغ | شنیدن سریال صوتی و برنامه‌های رادیویی",
                "description": "پخش سریال صوتی شب‌های تهران، کافه مه‌آلود و جمعه‌های سیمرغی.",
                "inLanguage": "fa-IR",
                "isPartOf": { "@id": "https://simorghtv.com/#website" },
                "breadcrumb": { "@id": "https://simorghtv.com/radios/#breadcrumb" },
                "about": { "@id": "https://simorghtv.com/radios/#radio" },
                "mainEntity": { "@id": "https://simorghtv.com/radios/#programs" }
            },
            {
                "@type": "WebSite",
                "@id": "https://simorghtv.com/#website",
                "url": "https://simorghtv.com/",
                "name": "هفت هنر سیمرغ",
                "inLanguage": "fa-IR",
                "publisher": { "@id": "https://simorghtv.com/#organization" }
            },
            {
                "@type": "RadioBroadcastService",
                "@id": "https://simorghtv.com/radios/#radio",
                "name": "رادیو سیمرغ",
                "alternateName": "Radio Simorgh",
                "description": "پخش برنامه‌های رادیویی و سریال‌های صوتی فرهنگی و هنری.",
                "url": "https://simorghtv.com/radios/",
                "broadcastDisplayName": "رادیو سیمرغ",
                "inLanguage": "fa-IR",
                "provider": { "@id": "https://simorghtv.com/#organization" }
            },
            {
                "@type": "BreadcrumbList",
                "@id": "https://simorghtv.com/radios/#breadcrumb",
                "itemListElement": [
                    { "@type": "ListItem", "position": 1, "name": "خانه", "item": "https://simorghtv.com/" },
                    { "@type": "ListItem", "position": 2, "name": "رادیو سیمرغ", "item": "https://simorghtv.com/radios/" }
                ]
            },
            {
                "@type": "ItemList",
                "@id": "https://simorghtv.com/radios/#programs",
                "name": "سریال‌ها و برنامه‌های رادیو سیمرغ",
                "itemListElement": [
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "item": {
                            "@type": "PodcastSeries",
                            "name": "شب‌های تهران - فصل اول",
                            "description": "فصل اول سریال صوتی شب‌های تهران؛ روایت‌های شنیدنی از پایتخت.",
                            "url": "https://simorghtv.com/radios/tehran1.php",
                            "image": "https://simorghtv.com/images/44.png",
                            "inLanguage": "fa-IR",
                            "genre": "Audio Drama"
                        }
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "item": {
                            "@type": "PodcastSeries",
                            "name": "شب‌های تهران - فصل دوم",
                            "description": "فصل دوم سریال صوتی شب‌های تهران؛ ادامه ماجراجویی‌ها.",
                            "url": "https://simorghtv.com/radios/tehran2.php",
                            "image": "https://simorghtv.com/images/45.png",
                            "inLanguage": "fa-IR",
                            "genre": "Audio Drama"
                        }
                    },
                    {
                        "@type": "ListItem",
                        "position": 3,
                        "item": {
                            "@type": "PodcastSeries",
                            "name": "کافه مه‌آلود",
                            "description": "سریال صوتی کافه مه‌آلود؛ فضایی آرامش‌بخش با موسیقی و گفتگو.",
                            "url": "https://simorghtv.com/radios/cafe_meh.php",
                            "image": "https://simorghtv.com/images/35.png",
                            "inLanguage": "fa-IR",
                            "genre": "Audio Drama"
                        }
                    },
                    {
                        "@type": "ListItem",
                        "position": 4,
                        "item": {
                            "@type": "PodcastSeries",
                            "name": "جمعه‌های سیمرغی",
                            "description": "بهترین برنامه‌های فرهنگی، هنری و موسیقی با صدای گویندگان حرفه‌ای.",
                            "url": "https://simorghtv.com/radios/radio_simorgh.php",
                            "image": "https://simorghtv.com/images/36.png",
                            "inLanguage": "fa-IR",
                            "genre": "Radio Program"
                        }
                    }
                ]
            }
        ]
    }
    </script>

    <?php include "includes.php"; ?>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    /* همه کلاس‌ها با پیشوند rp- هستند تا با mainstyles.css (مثلاً .radio-title صفحه اصلی) تداخل نکنند */
    :root {
        --rp-navy-900: #060b22;
        --rp-navy-700: #0d1a47;
        --rp-navy-500: #16295f;
        --rp-brown: #a8693f;
        --rp-brown-dark: #3a2a2a;
        --rp-gold: #f5b82e;
        --rp-gold-light: #ffe08a;
        --rp-ink: #1d2340;
    }

    body {
        background: linear-gradient(180deg, #f3f1ee 0%, #e9ecf5 100%);
        min-height: 100vh;
    }

    .rp-page { padding-top: 14px; }

    /* ---------- breadcrumb ---------- */
    .rp-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 16px;
        padding: 0;
        list-style: none;
        font-size: 13px;
        color: #6b6f85;
    }
    .rp-breadcrumb a { color: var(--rp-navy-500); font-weight: 700; }
    .rp-breadcrumb a:hover { color: var(--rp-brown); }
    .rp-breadcrumb li + li::before { content: "‹"; margin-left: 8px; color: #a3a7bb; }

    /* ============ Hero ============ */
    .rp-hero {
        position: relative;
        overflow: hidden;
        margin-bottom: 32px;
        padding: 30px 20px 66px;
        text-align: center;
        color: #fff;
        border-radius: 22px;
        background:
            radial-gradient(circle at 88% 12%, rgba(224, 160, 90, 0.30), transparent 45%),
            radial-gradient(circle at 8% 95%, rgba(139, 90, 60, 0.50), transparent 52%),
            linear-gradient(135deg, var(--rp-navy-900) 0%, var(--rp-navy-700) 45%, var(--rp-navy-500) 78%, var(--rp-brown-dark) 100%);
        box-shadow: 0 24px 56px rgba(13, 26, 71, 0.35);
        isolation: isolate;
    }

    .rp-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        z-index: -1;
        background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
        background-size: 22px 22px;
    }

    .rp-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 5px 18px;
        font-size: 12.5px;
        line-height: 1.8 !important;
        font-weight: 700;
        color: var(--rp-gold-light);
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(245, 184, 46, 0.45);
        border-radius: 999px;
    }

    .rp-dot {
        position: relative;
        display: inline-block;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #ff4d4d;
    }
    .rp-dot::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: #ff4d4d;
        animation: rpPulse 1.8s ease-out infinite;
    }

    .rp-hero__title {
        margin: 10px 0 6px;
        font-size: clamp(1.4rem, 3.4vw, 2.1rem);
        font-weight: 900;
        line-height: 1.5 !important;
        background: linear-gradient(90deg, #fff 0%, var(--rp-gold-light) 55%, var(--rp-gold) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .rp-hero__sub {
        max-width: 640px;
        margin: 0 auto 16px;
        font-size: .95rem;
        line-height: 1.9 !important;
        color: rgba(255, 255, 255, 0.86);
    }

    .rp-hero__chips {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        margin-bottom: 18px;
    }
    .rp-hero__chips a {
        padding: 2px 14px;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 999px;
        transition: background .3s ease, transform .3s ease, color .3s ease;
    }
    .rp-hero__chips a:hover {
        color: var(--rp-navy-700);
        background: var(--rp-gold-light);
        transform: translateY(-2px);
    }

    .rp-hero__cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 26px;
        font-size: 14px;
        font-weight: 800;
        color: var(--rp-navy-700);
        background: linear-gradient(135deg, var(--rp-gold-light), var(--rp-gold));
        border-radius: 999px;
        box-shadow: 0 10px 26px rgba(245, 184, 46, 0.4);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .rp-hero__cta:hover {
        color: var(--rp-navy-700);
        transform: translateY(-3px);
        box-shadow: 0 14px 32px rgba(245, 184, 46, 0.55);
    }

    /* موج صوتی کف هیرو */
    .rp-hero__waves {
        position: absolute;
        right: 0;
        left: 0;
        bottom: 0;
        height: 40px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        gap: 6px;
        padding: 0 16px;
        pointer-events: none;
        opacity: .85;
        -webkit-mask-image: linear-gradient(to top, #000 40%, transparent);
        mask-image: linear-gradient(to top, #000 40%, transparent);
    }
    .rp-hero__waves span {
        flex: 0 0 6px;
        height: 100%;
        border-radius: 6px 6px 0 0;
        background: linear-gradient(to top, var(--rp-brown), var(--rp-gold));
        transform-origin: bottom;
        animation: rpBar 1.3s ease-in-out infinite;
        animation-delay: calc(var(--i) * -0.11s);
    }

    /* ============ تیتر بخش ============ */
    .rp-head { text-align: center; margin-bottom: 34px; }
    .rp-head h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 800;
        color: var(--rp-ink);
    }
    .rp-head p { margin: 6px auto 0; max-width: 620px; color: #5b6079; font-size: 15px; }
    .rp-head__line {
        width: 90px;
        height: 4px;
        margin: 10px auto 0;
        border-radius: 4px;
        background: linear-gradient(90deg, var(--rp-brown), var(--rp-gold), var(--rp-navy-500));
    }

    /* ============ کارت‌ها ============ */
    .rp-card {
        height: 100%;
        overflow: hidden;
        border-radius: 26px;
        background: var(--rp-navy-700);
        box-shadow: 0 18px 34px -12px rgba(13, 26, 71, 0.4);
        transition: transform .35s ease, box-shadow .35s ease;
    }
    .rp-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 28px 50px -14px rgba(13, 26, 71, 0.55);
    }

    .rp-card__link { display: flex; flex-direction: column; height: 100%; color: inherit; }
    .rp-card__link:hover { color: inherit; }

    /* هر ۴ تصویر دقیقاً هم‌اندازه‌اند: قاب با نسبت ثابت + پر کردن کامل قاب (برای تغییر نسبت، --rp-ratio را عوض کنید) */
    .rp-card__media {
        --rp-ratio: 1 / 1;
        position: relative;
        aspect-ratio: var(--rp-ratio);
        overflow: hidden;
        background: var(--rp-navy-900);
        line-height: 0;
    }
    .rp-card__media img {
        position: absolute;
        inset: 0;
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform .6s ease;
    }
    .rp-card:hover .rp-card__media img { transform: scale(1.04); }

    .rp-tag {
        position: absolute;
        top: 14px;
        right: 14px;
        z-index: 2;
        padding: 2px 14px;
        line-height: 1.8 !important;
        font-size: 12.5px;
        font-weight: 800;
        color: var(--rp-navy-700);
        background: linear-gradient(135deg, var(--rp-gold-light), var(--rp-gold));
        border-radius: 999px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    }

    .rp-card__body {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 20px 18px 22px;
        background: linear-gradient(180deg, var(--rp-navy-700), var(--rp-navy-900));
        border-top: 3px solid transparent;
        border-image: linear-gradient(90deg, var(--rp-brown), var(--rp-gold), var(--rp-navy-500)) 1;
    }

    .rp-card__title {
        margin: 0 0 8px;
        font-size: 1.3rem;
        font-weight: 800;
        line-height: 1.6 !important;
        color: #fff;
    }
    .rp-card__title small { display: block; font-size: .8rem; font-weight: 700; color: var(--rp-gold-light); }

    .rp-card__desc {
        flex: 1;
        margin: 0 0 16px;
        font-size: 13.5px;
        line-height: 1.9 !important;
        color: rgba(255, 255, 255, 0.82);
    }

    .rp-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 28px;
        font-size: 14px;
        font-weight: 800;
        color: var(--rp-navy-700);
        background: linear-gradient(135deg, var(--rp-gold-light), var(--rp-gold));
        border-radius: 999px;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .rp-card:hover .rp-btn { transform: scale(1.06); box-shadow: 0 8px 20px rgba(245, 184, 46, 0.45); }

    /* ============ آمار ============ */
    .rp-stats {
        position: relative;
        overflow: hidden;
        margin-top: 50px;
        padding: 44px 20px;
        background: #fff;
        border-radius: 28px;
        box-shadow: 0 14px 38px rgba(13, 26, 71, 0.08);
    }
    .rp-stats::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--rp-brown), var(--rp-gold), var(--rp-navy-500));
    }
    .rp-stat { text-align: center; padding: 18px; transition: transform .3s ease; }
    .rp-stat:hover { transform: translateY(-5px); }
    .rp-stat__icon { display: block; margin-bottom: 8px; font-size: 2.3rem; }
    .rp-stat__num { font-size: 2.1rem; font-weight: 900; color: var(--rp-navy-500); line-height: 1.5 !important; }
    .rp-stat__label { margin-top: 4px; font-size: .95rem; color: #666b82; }

    /* ============ متن سئو ============ */
    .rp-seo {
        margin-top: 40px;
        padding: 38px 32px;
        background: #fff;
        border-radius: 24px;
        border-right: 5px solid var(--rp-gold);
        box-shadow: 0 10px 30px rgba(13, 26, 71, 0.06);
    }
    .rp-seo h2 {
        margin: 0 0 22px;
        text-align: center;
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--rp-ink);
    }
    .rp-seo h3 { margin: 24px 0 10px; font-size: 1.15rem; font-weight: 800; color: var(--rp-navy-500); }
    .rp-seo p { margin: 0 0 14px; color: #4b5068; text-align: justify; line-height: 2.1 !important; }
    .rp-seo a { color: var(--rp-navy-500); font-weight: 800; border-bottom: 1px dashed rgba(22, 41, 95, .4); }
    .rp-seo a:hover { color: var(--rp-brown); border-bottom-color: var(--rp-brown); }

    @keyframes rpBar   { 0%, 100% { transform: scaleY(.18); } 50% { transform: scaleY(1); } }
    @keyframes rpPulse { 0% { transform: scale(1); opacity: .7; } 100% { transform: scale(3.2); opacity: 0; } }

    @media (prefers-reduced-motion: reduce) {
        .rp-hero__waves span, .rp-dot::after { animation: none !important; }
        .rp-card, .rp-card__media img, .rp-stat { transition: none; }
    }

    /* ============ موبایل ============ */
    @media (max-width: 768px) {
        .rp-hero { padding: 24px 14px 52px; margin-bottom: 26px; border-radius: 18px; }
        .rp-hero__sub { font-size: .88rem; }
        .rp-hero__waves { height: 32px; gap: 4px; }
        .rp-hero__waves span { flex-basis: 4px; }
        .rp-hero__waves span:nth-child(n+19) { display: none; }
        .rp-head h2 { font-size: 1.5rem; }
        .rp-card__title { font-size: 1.15rem; }
        .rp-stat__num { font-size: 1.7rem; }
        .rp-seo { padding: 24px 18px; }
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

    <main class="container rp-page mb-5">

        <!-- مسیر صفحه (هماهنگ با BreadcrumbList) -->
        <nav aria-label="مسیر صفحه">
            <ol class="rp-breadcrumb">
                <li><a href="../" title="صفحه اصلی هفت هنر سیمرغ">خانه</a></li>
                <li aria-current="page">رادیو سیمرغ</li>
            </ol>
        </nav>

        <!-- Hero -->
        <header class="rp-hero">
            <span class="rp-hero__badge"><i class="rp-dot"></i> 🎙️ رادیو سیمرغ</span>
            <h1 class="rp-hero__title">رادیو سیمرغ؛ پخش سریال‌های صوتی و برنامه‌های رادیویی</h1>
            <p class="rp-hero__sub">
                تجربه‌ای نو از شنیدن بهترین سریال‌های صوتی و برنامه‌های فرهنگی و هنری با کیفیت عالی و صدای گویندگان حرفه‌ای.
            </p>

            <nav class="rp-hero__chips" aria-label="برنامه‌های رادیو سیمرغ">
                <a href="tehran1.php" title="سریال صوتی شب‌های تهران فصل اول">شب‌های تهران ۱</a>
                <a href="tehran2.php" title="سریال صوتی شب‌های تهران فصل دوم">شب‌های تهران ۲</a>
                <a href="cafe_meh.php" title="سریال صوتی کافه مه‌آلود">کافه مه‌آلود</a>
                <a href="radio_simorgh.php" title="برنامه جمعه‌های سیمرغی">جمعه‌های سیمرغی</a>
            </nav>

            <a href="#programs" class="rp-hero__cta">شروع شنیدن <span aria-hidden="true">🎧</span></a>

            <div class="rp-hero__waves" aria-hidden="true">
                <?php for ($i = 1; $i <= 40; $i++) { ?><span style="--i:<?= $i ?>"></span><?php } ?>
            </div>
        </header>

        <!-- کارت‌ها -->
        <section id="programs" aria-labelledby="programsTitle">
            <div class="rp-head">
                <h2 id="programsTitle">سریال‌ها و برنامه‌های رادیو سیمرغ</h2>
                <p>یکی از برنامه‌ها را انتخاب کنید و همین حالا گوش دهید.</p>
                <div class="rp-head__line"></div>
            </div>

            <div class="row justify-content-center g-4">
                <?php
                $programs = [
                    [
                        'href'  => 'tehran1.php',
                        'img'   => '../images/44.png',
                        'alt'   => 'پوستر سریال صوتی شب‌های تهران فصل اول',
                        'tag'   => 'فصل اول',
                        'title' => 'شب‌های تهران',
                        'sub'   => 'فصل اول',
                        'desc'  => 'داستان ماجراجویی شبانه چند دوست قدیمی در دل رازهای پایتخت',
                        'btn'   => 'بشنو 🌙',
                        'name'  => 'شب‌های تهران - فصل اول',
                    ],
                    [
                        'href'  => 'tehran2.php',
                        'img'   => '../images/45.png',
                        'alt'   => 'پوستر سریال صوتی شب‌های تهران فصل دوم',
                        'tag'   => 'فصل دوم',
                        'title' => 'شب‌های تهران',
                        'sub'   => 'فصل دوم',
                        'desc'  => 'ادامه ماجراجویی‌های شبانه در دل رازهای تازه پایتخت',
                        'btn'   => 'بشنو 🌙',
                        'name'  => 'شب‌های تهران - فصل دوم',
                    ],
                    [
                        'href'  => 'cafe_meh.php',
                        'img'   => '../images/35.png',
                        'alt'   => 'پوستر سریال صوتی کافه مه‌آلود',
                        'tag'   => '',
                        'title' => 'کافه مه‌آلود',
                        'sub'   => '',
                        'desc'  => 'فضایی گرم با موسیقی، گفتگو و لحظاتی آرامش‌بخش',
                        'btn'   => 'بنشین ☕',
                        'name'  => 'کافه مه‌آلود',
                    ],
                    [
                        'href'  => 'radio_simorgh.php',
                        'img'   => '../images/36.png',
                        'alt'   => 'پوستر برنامه رادیویی جمعه‌های سیمرغی',
                        'tag'   => '',
                        'title' => 'جمعه‌های سیمرغی',
                        'sub'   => '',
                        'desc'  => 'بهترین برنامه‌های فرهنگی، هنری و موسیقی با صدای گرم گویندگان',
                        'btn'   => 'گوش کن 🎧',
                        'name'  => 'جمعه‌های سیمرغی',
                    ],
                ];
                foreach ($programs as $p) {
                ?>
                <div class="col-sm-6 col-lg-3">
                    <article class="rp-card">
                        <a class="rp-card__link" href="<?= $p['href'] ?>" title="گوش دادن به <?= $p['name'] ?>">
                            <div class="rp-card__media">
                                <img src="<?= $p['img'] ?>" alt="<?= $p['alt'] ?>" loading="lazy" decoding="async">
                                <?php if ($p['tag']) { ?><span class="rp-tag">📖 <?= $p['tag'] ?></span><?php } ?>
                            </div>
                            <div class="rp-card__body">
                                <h3 class="rp-card__title">
                                    <?= $p['title'] ?>
                                    <?php if ($p['sub']) { ?><small><?= $p['sub'] ?></small><?php } ?>
                                </h3>
                                <p class="rp-card__desc"><?= $p['desc'] ?></p>
                                <span class="rp-btn"><?= $p['btn'] ?></span>
                            </div>
                        </a>
                    </article>
                </div>
                <?php } ?>
            </div>
        </section>

        <!-- آمار -->
        <section class="rp-stats" aria-label="آمار رادیو سیمرغ">
            <div class="row">
                <div class="col-md-4">
                    <div class="rp-stat">
                        <span class="rp-stat__icon" aria-hidden="true">🎧</span>
                        <div class="rp-stat__num">+۱۰۰,۰۰۰</div>
                        <div class="rp-stat__label">شنونده فعال</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rp-stat">
                        <span class="rp-stat__icon" aria-hidden="true">🎙️</span>
                        <div class="rp-stat__num">+۵۰۰</div>
                        <div class="rp-stat__label">قسمت منتشر شده</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="rp-stat">
                        <span class="rp-stat__icon" aria-hidden="true">⏰</span>
                        <div class="rp-stat__num">۲۴/۷</div>
                        <div class="rp-stat__label">پخش</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- متن سئو -->
        <section class="rp-seo" aria-labelledby="seoTitle">
            <h2 id="seoTitle">بهترین انتخاب برای شنیدن سریال‌های صوتی و برنامه‌های رادیویی</h2>

            <p>
                رادیو سیمرغ با تکیه بر تجربه در تولید محتوای فرهنگی و هنری، تلاش می‌کند بهترین برنامه‌های رادیویی را
                برای مخاطبان فراهم کند.
                <a href="tehran1.php">فصل اول سریال صوتی شب‌های تهران</a> با روایت‌های شنیدنی از پایتخت ایران،
                شما را به سفری دلنشین در کوچه‌پس‌کوچه‌های خاطره‌انگیز تهران می‌برد و
                <a href="tehran2.php">فصل دوم این سریال</a> با داستان‌های تازه و هیجان‌انگیز، ادامه‌ای جذاب برای
                طرفداران این مجموعه است.
            </p>

            <h3>کافه مه‌آلود و جمعه‌های سیمرغی</h3>
            <p>
                <a href="cafe_meh.php">کافه مه‌آلود</a> فضایی تازه و متفاوت است که شما را به دنیایی از موسیقی ملایم،
                گفتگوهای صمیمی و لحظاتی آرامش‌بخش دعوت می‌کند. اگر به برنامه‌های فرهنگی، هنری و موسیقی علاقه دارید،
                <a href="radio_simorgh.php">جمعه‌های سیمرغی</a> را از دست ندهید.
            </p>

            <h3>صدای حرفه‌ای در رادیو و آموزش گویندگی</h3>
            <p>
                صدای برنامه‌های رادیو سیمرغ را گویندگان حرفه‌ای اجرا می‌کنند. برای سفارش صدا می‌توانید از
                <a href="../articles/speakers_archive">آرشیو گویندگان رادیو سیمرغ</a> استفاده کنید و اگر دوست دارید
                خودتان گوینده شوید، <a href="../packages">پکیج‌های آموزشی موسسه هفت هنر سیمرغ</a> مسیر یادگیری را برایتان
                هدفمند می‌کند. برای آشنایی بیشتر با موسسه به <a href="../">صفحه اصلی هفت هنر سیمرغ</a> سر بزنید.
            </p>
        </section>

    </main>

    <?php include 'footer.php'; ?>

</body>

</html>