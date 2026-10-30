<?php
session_start();
include '../config.php';

// ========== بررسی گوینده ==========
$is_speaker = false;
if (isset($_SESSION['user_id'])) {
    $speaker_check_sql = "SELECT speaker FROM users WHERE id = ?";
    $speaker_stmt = $conn->prepare($speaker_check_sql);
    $speaker_stmt->bind_param("i", $_SESSION['user_id']);
    $speaker_stmt->execute();
    $speaker_result = $speaker_stmt->get_result();
    if ($speaker_result->num_rows > 0) {
        $speaker_data = $speaker_result->fetch_assoc();
        if (isset($speaker_data['speaker']) && $speaker_data['speaker'] == 1) {
            $is_speaker = true;
        }
    }
    $speaker_stmt->close();
}

// ========== دریافت اطلاعات فصل دوم از radios (id = 4) ==========
$tehran_radio_id = 4;
$radio_query = "SELECT * FROM radios WHERE id = $tehran_radio_id";
$radio_result = $conn->query($radio_query);
$radio_info = $radio_result ? $radio_result->fetch_assoc() : null;
$tehran_price = $radio_info['price'] ?? 5000;
$tehran_name  = $radio_info['name']  ?? 'شب های تهران فصل 2';
$tehran_desc  = $radio_info['description'] ?? 'فصل دوم سریال صوتی شب‌های تهران - ادامه ماجراجویی‌های شبانه در پایتخت...';

// ========== بررسی دسترسی کامل کاربر ==========
$has_full_tehran_access = false;
if ($is_speaker) {
    $has_full_tehran_access = true;
} elseif (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check_full_sql = "SELECT id FROM user_radio 
                       WHERE user_id = ? 
                       AND radio_type = 'tehran2' 
                       AND program_id IS NULL 
                       AND paid = 1 
                       LIMIT 1";
    $check_stmt = $conn->prepare($check_full_sql);
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        $has_full_tehran_access = true;
    }
    $check_stmt->close();
}

// ========== پرداخت موفق ==========
$payment_message = '';
if (isset($_GET['payment'])) {
    if ($_GET['payment'] == 'success') {
        $payment_message = '<div class="alert alert-success text-center">✅ پرداخت شما با موفقیت انجام شد! از شنیدن فصل دوم لذت ببرید. 🌃</div>';
    } elseif ($_GET['payment'] == 'failed') {
        $payment_message = '<div class="alert alert-danger text-center">❌ پرداخت ناموفق بود. لطفاً مجدداً تلاش کنید.</div>';
    } elseif ($_GET['payment'] == 'already') {
        $payment_message = '<div class="alert alert-info text-center">ℹ️ شما قبلاً اشتراک فصل دوم را خریداری کرده‌اید.</div>';
    }
}

// ========== دریافت قسمت‌های فصل دوم ==========
// ✅ دموها اول (is_free DESC)، بعد بقیه بر اساس id ASC
$programs = [];
$sql = "SELECT * FROM radio_tehran 
        WHERE season = 2 
        ORDER BY is_free DESC, id ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
}

// ========== شمارش کل قسمت‌های فصل دوم ==========
$total_episodes = 0;
$total_sql = "SELECT COUNT(*) AS total FROM radio_tehran WHERE season = 2";
$total_result = $conn->query($total_sql);
if ($total_result) {
    $total_row = $total_result->fetch_assoc();
    $total_episodes = (int)$total_row['total'];
}

// ============================================
// ✅ پردازش ارسال کامنت جدید
// ============================================
$comment_message = '';
$comment_message_type = '';
$for_id = $radio_info['id'] ?? 4;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $comment_text = trim($_POST['comment_text'] ?? '');

    if ($full_name === '' || $comment_text === '') {
        $comment_message = '❌ لطفاً نام و متن کامنت را وارد کنید.';
        $comment_message_type = 'danger';
    } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $comment_message = '❌ ایمیل وارد شده معتبر نیست.';
        $comment_message_type = 'danger';
    } else {
        $email_val = $email !== '' ? $email : null;
        $for_type = 'radio';
        $insert_sql = "INSERT INTO comments (full_name, email, comment_text, for_type, for_id) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssssi", $full_name, $email_val, $comment_text, $for_type, $for_id);
        if ($insert_stmt->execute()) {
            $comment_message = '✅ کامنت شما با موفقیت ثبت شد.';
            $comment_message_type = 'success';
        } else {
            $comment_message = '❌ خطا در ثبت کامنت. لطفاً دوباره تلاش کنید.';
            $comment_message_type = 'danger';
        }
        $insert_stmt->close();
    }
}

// ============================================
// ✅ دریافت لیست کامنت‌ها
// ============================================
$comments = [];
$comments_sql = "SELECT id, full_name, comment_text, admin_reply, created_at
                 FROM comments
                 WHERE for_type = 'radio' AND for_id = " . (int)$for_id . "
                 ORDER BY created_at DESC";
$comments_result = $conn->query($comments_sql);
if ($comments_result && $comments_result->num_rows > 0) {
    while ($row = $comments_result->fetch_assoc()) {
        $comments[] = $row;
    }
}

$current_url = $_SERVER['REQUEST_URI'];
$login_url = '../login.php?redirect=' . urlencode($current_url);

// ========== متغیرهای سئو ==========
$canonical_url     = 'https://simorghtv.com/radios/tehran2.php';
$og_image          = 'https://simorghtv.com/images/tehran-season2.jpg';
$page_title        = 'شب های تهران فصل 2 | سریال صوتی | رادیو سیمرغ';
$page_description  = 'پخش آنلاین فصل دوم (فصل 2) سریال صوتی شب های تهران از رادیو سیمرغ. ادامه ماجراجویی شبانه چند دوست قدیمی در پایتخت. دسترسی رایگان به قسمت دمو و خرید اشتراک کامل فصل.';
$episode_count     = $total_episodes;
?>
<!doctype html>
<html lang="fa" dir="rtl" xml:lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO Meta -->
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords"
        content="شب های تهران, فصل دوم, فصل 2, سریال صوتی, رادیو سیمرغ, پادکست فارسی, داستان صوتی, audio drama, دمو رایگان">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="language" content="Persian">
    <meta name="rating" content="general">
    <meta name="theme-color" content="#0f0f1e">

    <!-- Canonical & hreflang -->
    <link rel="canonical" href="<?php echo $canonical_url; ?>">
    <link rel="alternate" hreflang="fa-IR" href="<?php echo $canonical_url; ?>">
    <link rel="alternate" hreflang="x-default" href="<?php echo $canonical_url; ?>">

    <!-- Series navigation -->
    <link rel="prev" href="https://simorghtv.com/radios/tehran1.php">

    <!-- Preconnect -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fa_IR">
    <meta property="og:site_name" content="رادیو سیمرغ">
    <meta property="og:url" content="<?php echo $canonical_url; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:image" content="<?php echo $og_image; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="شب های تهران - فصل 2">
    <meta property="og:audio" content="<?php echo $canonical_url; ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@simorghtv">
    <meta name="twitter:creator" content="@simorghtv">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="twitter:image" content="<?php echo $og_image; ?>">
    <meta name="twitter:image:alt" content="شب های تهران - فصل 2">

    <!-- JSON-LD: PodcastSeries -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "PodcastSeries",
        "name": "شب های تهران - فصل 2",
        "alternateName": "Shab-haye Tehran Season 2",
        "description": <?php echo json_encode($page_description, JSON_UNESCAPED_UNICODE); ?>,
        "url": "<?php echo $canonical_url; ?>",
        "image": "<?php echo $og_image; ?>",
        "inLanguage": "fa-IR",
        "genre": ["Drama", "Audio Drama", "سریال صوتی"],
        "numberOfEpisodes": <?php echo (int)$episode_count; ?>,
        "author": {
            "@type": "Organization",
            "name": "موسسه هفت هنر سیمرغ",
            "url": "https://simorghtv.com"
        },
        "publisher": {
            "@type": "Organization",
            "name": "رادیو سیمرغ",
            "logo": {
                "@type": "ImageObject",
                "url": "https://simorghtv.com/images/35.png"
            }
        },
        "partOfSeries": {
            "@type": "PodcastSeries",
            "name": "شب های تهران"
        },
        "potentialAction": {
            "@type": "ListenAction",
            "target": "<?php echo $canonical_url; ?>"
        }
    }
    </script>

    <!-- JSON-LD: BreadcrumbList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "رادیو سیمرغ",
                "item": "https://simorghtv.com/radios/index.php"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "شب های تهران - فصل 1",
                "item": "https://simorghtv.com/radios/tehran1.php"
            },
            {
                "@type": "ListItem",
                "position": 3,
                "name": "شب های تهران - فصل 2",
                "item": "<?php echo $canonical_url; ?>"
            }
        ]
    }
    </script>

    <!-- JSON-LD: Episode List -->
    <?php if ($episode_count > 0): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "لیست قسمت‌های فصل 2 شب های تهران",
        "numberOfItems": <?php echo (int)$episode_count; ?>,
        "itemListElement": [
            <?php foreach ($programs as $i => $p): 
                $ep_is_demo = ((int)($p['is_free'] ?? 0) === 1);
            ?> {
                "@type": "ListItem",
                "position": <?php echo $i + 1; ?>,
                "item": {
                    "@type": "PodcastEpisode",
                    "name": <?php echo json_encode(htmlspecialchars($p['title']), JSON_UNESCAPED_UNICODE); ?>,
                    "url": "<?php echo $canonical_url; ?>",
                    "description": "قسمت <?php echo $i + 1; ?> از فصل 2 سریال صوتی شب های تهران",
                    "episodeNumber": <?php echo $i + 1; ?>,
                    "partOfSeason": {
                        "@type": "PodcastSeason",
                        "seasonNumber": 2
                    },
                    "inLanguage": "fa-IR",
                    "isAccessibleForFree": <?php echo $ep_is_demo ? 'true' : 'false'; ?>
                }
            }
            <?php echo ($i < count($programs) - 1) ? ',' : ''; ?>
            <?php endforeach; ?>
        ]
    }
    </script>
    <?php endif; ?>

    <?php include "includes.php"; ?>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    body {
        background: linear-gradient(135deg, #0f0f1e 0%, #1a1a2e 50%, #16213e 100%);
        min-height: 100vh;
        position: relative;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            radial-gradient(circle at 20% 30%, rgba(157, 126, 255, 0.08) 0%, transparent 50%),
            radial-gradient(circle at 80% 70%, rgba(226, 185, 111, 0.05) 0%, transparent 50%),
            radial-gradient(2px 2px at 15% 25%, rgba(255, 255, 255, 0.7), transparent),
            radial-gradient(1px 1px at 45% 65%, rgba(255, 255, 255, 0.5), transparent),
            radial-gradient(2px 2px at 75% 35%, rgba(255, 255, 255, 0.6), transparent),
            radial-gradient(1px 1px at 90% 85%, rgba(255, 255, 255, 0.4), transparent),
            radial-gradient(1px 1px at 30% 80%, rgba(255, 255, 255, 0.5), transparent);
        pointer-events: none;
        z-index: 0;
    }

    .container {
        position: relative;
        z-index: 1;
    }

    /* ✅ هدر با تصویر پس‌زمینه 44.png — ارتفاع ۴۵۰، عرض کامل */
    .tehran-header {
        background-image: linear-gradient(135deg, rgba(10, 10, 26, 0.55), rgba(26, 26, 46, 0.55), rgba(10, 10, 26, 0.55)), url('../images/46.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 40px;
        width: 100%;
        height: 450px;
        min-height: 450px;
        max-height: 450px;
        margin-bottom: 30px;
        padding: 0 30px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(157, 126, 255, 0.3);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-sizing: border-box;
    }

    .tehran-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 50% 50%, transparent 0%, rgba(0, 0, 0, 0.35) 100%);
        pointer-events: none;
        z-index: 0;
    }

    .tehran-header>* {
        position: relative;
        z-index: 1;
    }

    .tehran-header h1 {
        font-size: 3rem;
        font-weight: bold;
        color: #e8e0ff;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9), 0 0 20px rgba(157, 126, 255, 0.5);
    }

    .tehran-header .lead {
        color: #e0d8f0;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.9);
    }

    .tehran-header .season-badge {
        display: inline-block;
        background: linear-gradient(135deg, #9d7eff, #6d5ed9);
        color: #fff;
        padding: 6px 22px;
        border-radius: 50px;
        font-weight: bold;
        margin-top: 15px;
        font-size: 0.9rem;
        box-shadow: 0 5px 20px rgba(157, 126, 255, 0.4);
    }

    .tehran-header small {
        color: #d0c8e8;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.9);
    }

    /* ============ باکس قیمت کل ============ */
    .tehran-price-box {
        background: linear-gradient(135deg, rgba(157, 126, 255, 0.15), rgba(226, 185, 111, 0.1));
        border: 2px solid rgba(157, 126, 255, 0.4);
        border-radius: 25px;
        padding: 25px 30px;
        margin-bottom: 30px;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(157, 126, 255, 0.2);
    }

    .price-label {
        color: #c8c0e0;
        font-size: 0.95rem;
        margin-bottom: 5px;
    }

    .price-value {
        color: #e2b96f;
        font-size: 2.2rem;
        font-weight: bold;
        text-shadow: 0 0 15px rgba(226, 185, 111, 0.4);
        line-height: 1.2;
    }

    .price-unit {
        font-size: 1rem;
        color: #c8c0e0;
        font-weight: normal;
    }

    .price-hint {
        color: #a090c0;
        display: block;
        margin-top: 8px;
        line-height: 1.6;
    }

    .price-hint a {
        color: #9d7eff;
        font-weight: bold;
        text-decoration: underline;
    }

    .btn-buy-main {
        background: linear-gradient(135deg, #9d7eff, #6d5ed9);
        color: #fff !important;
        font-weight: bold;
        border: none;
        border-radius: 50px;
        padding: 14px 30px;
        font-size: 1.05rem;
        transition: all 0.3s;
        box-shadow: 0 5px 20px rgba(157, 126, 255, 0.4);
        text-decoration: none;
        display: inline-block;
    }

    .btn-buy-main:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 10px 30px rgba(157, 126, 255, 0.6);
        color: #fff !important;
    }

    /* ✅ کارت پلیر — بدون تصویر پس‌زمینه */
    .tehran-player-card {
        background: rgba(15, 15, 30, 0.85);
        backdrop-filter: blur(12px);
        border-radius: 30px;
        padding: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(157, 126, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .tehran-player-card>* {
        position: relative;
        z-index: 1;
    }

    .moon-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #9d7eff, #6d5ed9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        box-shadow: 0 10px 30px rgba(157, 126, 255, 0.6);
        animation: floatNight 3s ease-in-out infinite;
    }

    @keyframes floatNight {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .now-playing-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #e8e0ff;
    }

    .now-playing-type {
        background: rgba(157, 126, 255, 0.85);
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.85rem;
        color: #fff;
        font-weight: bold;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
    }

    .custom-audio-player {
        background: rgba(0, 0, 0, 0.55);
        border-radius: 60px;
        padding: 15px 20px;
        margin-top: 20px;
    }

    audio {
        width: 100%;
        border-radius: 50px;
    }

    audio::-webkit-media-controls-enclosure {
        overflow: hidden;
    }

    audio::-webkit-media-controls-panel {
        width: calc(100% + 30px);
    }

    audio::-webkit-media-controls-current-time-display,
    audio::-webkit-media-controls-time-remaining-display {
        display: none;
    }

    audio::-moz-media-controls-download-button {
        display: none !important;
    }

    audio::-ms-media-controls-download-button {
        display: none !important;
    }

    .menu-section {
        background: rgba(15, 15, 30, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 25px;
        border: 1px solid rgba(157, 126, 255, 0.25);
    }

    .menu-title {
        font-size: 1.7rem;
        font-weight: bold;
        color: #e8e0ff;
        border-bottom: 3px solid #9d7eff;
        display: inline-block;
        padding-bottom: 10px;
    }

    .menu-item {
        background: rgba(25, 25, 45, 0.85);
        backdrop-filter: blur(5px);
        border-radius: 20px;
        margin-bottom: 15px;
        padding: 15px 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(157, 126, 255, 0.2);
        position: relative;
    }

    .menu-item:hover {
        transform: translateX(-5px);
        border-color: rgba(157, 126, 255, 0.5);
        background: rgba(35, 35, 60, 0.95);
    }

    .menu-item.is-demo {
        border-color: rgba(226, 185, 111, 0.6);
        background: linear-gradient(135deg, rgba(30, 30, 50, 0.9), rgba(45, 40, 25, 0.9));
        box-shadow: 0 0 20px rgba(226, 185, 111, 0.15);
    }

    .menu-item.active {
        background: linear-gradient(135deg, rgba(157, 126, 255, 0.2), rgba(109, 94, 217, 0.2));
        border-color: #9d7eff;
        border-width: 2px;
    }

    .play-btn-tehran {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(60, 50, 90, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(157, 126, 255, 0.5);
        font-size: 1.2rem;
        color: #9d7eff;
        cursor: pointer;
        transition: all 0.3s;
    }

    .play-btn-tehran:hover {
        transform: scale(1.1);
        background: #9d7eff;
        color: #fff;
    }

    .play-btn-tehran.playing {
        background: #9d7eff;
        color: #fff;
        animation: pulseTehran 1.5s infinite;
    }

    @keyframes pulseTehran {
        0% {
            box-shadow: 0 0 0 0 rgba(157, 126, 255, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(157, 126, 255, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(157, 126, 255, 0);
        }
    }

    .program-title-tehran {
        font-size: 1rem;
        font-weight: 600;
        color: #e8e0ff;
    }

    .program-badge-tehran {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        background: rgba(157, 126, 255, 0.2);
        color: #b8a5ff;
    }

    .demo-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        background: linear-gradient(135deg, #e2b96f, #c99b4a);
        color: #1a1a2e;
        margin-left: 8px;
        box-shadow: 0 3px 10px rgba(226, 185, 111, 0.4);
        animation: demoPulse 2s ease-in-out infinite;
    }

    @keyframes demoPulse {

        0%,
        100% {
            box-shadow: 0 3px 10px rgba(226, 185, 111, 0.4);
        }

        50% {
            box-shadow: 0 3px 20px rgba(226, 185, 111, 0.7);
        }
    }

    .tehran-buy-btn {
        background: linear-gradient(135deg, #9d7eff, #6d5ed9);
        color: #fff !important;
        font-weight: bold !important;
        border: none !important;
        border-radius: 50px !important;
        padding: 10px 25px;
        transition: all 0.3s ease;
    }

    .tehran-buy-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 20px rgba(157, 126, 255, 0.5);
        color: #fff !important;
    }

    .tehran-stats {
        background: rgba(15, 15, 30, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 20px;
        margin-top: 25px;
        border: 1px solid rgba(157, 126, 255, 0.25);
    }

    .stat-number-tehran {
        font-size: 1.8rem;
        font-weight: bold;
        color: #9d7eff;
    }

    .search-input-tehran {
        border-radius: 50px;
        border: 1px solid rgba(157, 126, 255, 0.5);
        padding: 10px 20px;
        background: rgba(25, 25, 45, 0.8);
        color: #e8e0ff;
    }

    .search-input-tehran:focus {
        box-shadow: 0 0 0 3px rgba(157, 126, 255, 0.2);
        border-color: #9d7eff;
        background: rgba(35, 35, 60, 0.9);
        color: #e8e0ff;
    }

    .night-glow {
        position: fixed;
        bottom: 20px;
        left: 20px;
        font-size: 30px;
        opacity: 0.2;
        pointer-events: none;
        animation: glowPulse 4s ease-in-out infinite;
        z-index: 2;
    }

    @keyframes glowPulse {

        0%,
        100% {
            opacity: 0.2;
            transform: scale(1);
        }

        50% {
            opacity: 0.4;
            transform: scale(1.1);
        }
    }

    .logout-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border: none;
        border-radius: 60px;
        padding: 12px 24px;
        font-weight: bold;
        font-size: 15px;
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        font-family: inherit;
        cursor: pointer;
    }

    .logout-btn:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 12px 35px rgba(220, 53, 69, 0.5);
        color: white;
        background: linear-gradient(135deg, #c82333, #a71d2a);
    }

    .logout-btn svg {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    .breadcrumb-nav {
        margin-bottom: 20px;
        padding: 12px 20px;
        background: rgba(15, 15, 30, 0.8);
        border-radius: 50px;
        border: 1px solid rgba(157, 126, 255, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .breadcrumb-nav a {
        color: #9d7eff;
        text-decoration: none;
        transition: all 0.3s;
    }

    .breadcrumb-nav a:hover {
        color: #e8e0ff;
        text-shadow: 0 0 10px rgba(157, 126, 255, 0.5);
    }

    .breadcrumb-nav .separator {
        color: #7a7090;
    }

    .breadcrumb-nav .current {
        color: #e8e0ff;
        font-weight: bold;
    }

    .comments-section {
        background: rgba(15, 15, 30, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 35px 30px;
        margin-top: 40px;
        border: 1px solid rgba(157, 126, 255, 0.3);
        color: #e8e0ff;
    }

    .comments-title {
        color: #9d7eff;
        font-weight: bold;
        border-bottom: 2px solid #9d7eff;
        display: inline-block;
        padding-bottom: 8px;
        margin-bottom: 25px;
    }

    .comment-form-card {
        background: rgba(10, 10, 20, 0.9);
        border-radius: 20px;
        padding: 15px 18px;
        border: 1px solid rgba(157, 126, 255, 0.25);
        margin-bottom: 25px;
        max-width: 50%;
        margin-left: auto;
        margin-right: auto;
    }

    .comment-form-card h5 {
        color: #9d7eff;
        font-size: 1rem;
        margin-bottom: 12px;
    }

    .comment-form-card .form-control {
        background: rgba(25, 25, 45, 0.9);
        border: 1px solid rgba(157, 126, 255, 0.3);
        color: #e8e0ff;
        border-radius: 12px;
        padding: 8px 14px;
        font-size: 0.9rem;
    }

    .comment-form-card .form-control:focus {
        background: rgba(35, 35, 60, 0.95);
        border-color: #9d7eff;
        color: #fff;
        box-shadow: 0 0 0 3px rgba(157, 126, 255, 0.15);
    }

    .comment-form-card .form-control::placeholder {
        color: #7a7090;
    }

    .comment-form-card label {
        color: #9d7eff;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .comment-form-card textarea.form-control {
        min-height: 70px;
    }

    .comment-submit-btn {
        background: linear-gradient(135deg, #9d7eff, #6d5ed9);
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 50px;
        padding: 8px 25px;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .comment-submit-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(157, 126, 255, 0.5);
        color: #fff;
    }

    .comment-item {
        background: rgba(10, 10, 20, 0.8);
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 18px;
        border: 1px solid rgba(157, 126, 255, 0.15);
        transition: all 0.3s;
    }

    .comment-item:hover {
        border-color: rgba(157, 126, 255, 0.4);
        transform: translateX(-3px);
    }

    .comment-author {
        color: #9d7eff;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .comment-date {
        color: #7a7090;
        font-size: 12px;
    }

    .comment-text {
        color: #d8d0f0;
        margin-top: 10px;
        line-height: 1.8;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .admin-reply-box {
        background: rgba(157, 126, 255, 0.08);
        border-right: 3px solid #9d7eff;
        border-radius: 12px;
        padding: 12px 18px;
        margin-top: 15px;
        margin-right: 20px;
    }

    .admin-reply-label {
        color: #9d7eff;
        font-weight: bold;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .admin-reply-text {
        color: #c8c0e0;
        line-height: 1.7;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .no-comments {
        text-align: center;
        padding: 40px 20px;
        color: #7a7090;
    }

    .no-comments .icon {
        font-size: 50px;
        margin-bottom: 15px;
    }

    .comments-count-badge {
        background: rgba(157, 126, 255, 0.2);
        color: #9d7eff;
        border-radius: 50px;
        padding: 3px 12px;
        font-size: 13px;
        margin-right: 10px;
    }

    .purchased-badge {
        background: #28a745;
        border-radius: 50px;
        padding: 4px 12px;
        font-size: 11px;
        color: white;
        margin-right: 6px;
    }

    @media (max-width: 768px) {
        .tehran-header {
            padding: 30px 20px;
            height: auto;
            min-height: 280px;
            max-height: none;
        }

        .tehran-header h1 {
            font-size: 2rem;
        }

        .tehran-price-box {
            padding: 20px;
        }

        .price-value {
            font-size: 1.6rem;
        }

        .btn-buy-main {
            padding: 12px 22px;
            font-size: 0.95rem;
        }

        .menu-item {
            padding: 12px 15px;
        }

        .play-btn-tehran {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .logout-btn {
            bottom: 20px;
            right: 20px;
            padding: 10px 18px;
            font-size: 13px;
            gap: 6px;
        }

        .comment-form-card {
            max-width: 100%;
        }

        .breadcrumb-nav {
            font-size: 0.8rem;
            padding: 10px 15px;
        }
    }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-4 mb-5">

        <!-- بردکرامب -->
        <nav class="breadcrumb-nav" aria-label="مسیر صفحه">
            <a href="index.php">🎙️ همه رادیو ها</a>
            <span class="separator">›</span>
            <a href="tehran1.php">🌃 فصل اول</a>
            <span class="separator">›</span>
            <span class="current">📖 فصل دوم</span>
        </nav>

        <?php echo $payment_message; ?>

        <?php if ($is_speaker): ?>
        <div class="alert alert-success text-center mb-3"
            style="background: linear-gradient(135deg, #9d7eff, #6d5ed9); color: #fff; border: none;">
            🎙️ به پنل گویندگی خوش آمدید! دسترسی رایگان و کامل به تمام برنامه‌ها. 🌟
        </div>
        <?php endif; ?>

        <!-- ✅ هدر با تصویر پس‌زمینه 44.png -->
        <header class="tehran-header">
            <h1>🌃 شب‌های تهران - فصل دوم</h1>
            <p class="lead"><?php echo htmlspecialchars($tehran_desc); ?></p>
            <div class="season-badge">📖 فصل دوم — قسمت 11 تا 20 </div>
            <br>
            <small>🎧 <?php echo $total_episodes; ?> قسمت برای شنیدن</small>
        </header>

        <!-- ✅ باکس قیمت کل اشتراک (بالای صفحه) -->
        <?php if ($is_speaker): ?>
        <div class="tehran-price-box"
            style="border-color: #9d7eff; background: linear-gradient(135deg, rgba(157,126,255,0.15), rgba(157,126,255,0.05));">
            <div class="text-center">
                <div style="font-size: 1.3rem; color: #9d7eff; font-weight: bold;">
                    🎙️ دسترسی ویژه گوینده به همه قسمت‌ها فعال است
                </div>
            </div>
        </div>
        <?php elseif ($has_full_tehran_access): ?>
        <div class="tehran-price-box"
            style="border-color: #28a745; background: linear-gradient(135deg, rgba(40,167,69,0.15), rgba(40,167,69,0.05));">
            <div class="text-center">
                <div style="font-size: 1.3rem; color: #28a745; font-weight: bold;">
                    ✅ دسترسی کامل به فصل دوم برای شما فعال است
                </div>
                <small style="color: #a090c0;">می‌توانید تمام قسمت‌ها را بشنوید</small>
            </div>
        </div>
        <?php else: ?>
        <div class="tehran-price-box">
            <div class="row align-items-center">
                <div class="col-md-8 text-center text-md-start mb-3 mb-md-0">
                    <div class="price-label">💰 قیمت اشتراک کامل فصل دوم:</div>
                    <div class="price-value"><?php echo number_format($tehran_price); ?> <span
                            class="price-unit">تومان</span></div>
                    <small class="price-hint">
                        با یک بار خرید، به <strong>تمام <?php echo $total_episodes; ?> قسمت</strong> فصل دوم دسترسی
                        دائمی پیدا می‌کنید.
                        <?php if (!isset($_SESSION['user_id'])): ?>
                        <br>برای خرید ابتدا باید <a href="<?php echo htmlspecialchars($login_url); ?>">وارد شوید</a>.
                        <?php endif; ?>
                    </small>
                </div>
                <div class="col-md-4 text-center">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo htmlspecialchars($login_url); ?>" class="btn btn-buy-main">
                        🔐 ورود و خرید
                    </a>
                    <?php else: ?>
                    <a href="buy_tehran.php?season=2" class="btn btn-buy-main">
                        💳 خرید اشتراک
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-5 mb-4">
                <!-- ✅ کارت پلیر بدون تصویر پس‌زمینه -->
                <div class="tehran-player-card">
                    <div class="text-center">
                        <div class="moon-icon" id="nowPlayingIcon" aria-label="نوازنده">🌙</div>
                        <h2 id="nowPlayingTitle" class="now-playing-title">هیچ برنامه‌ای انتخاب نشده</h2>
                        <span id="nowPlayingType" class="now-playing-type">برای شروع یکی از قسمت‌ها را انتخاب
                            کنید</span>
                        <div class="custom-audio-player">
                            <audio id="mainAudio" controls controlsList="nodownload noremoteplayback" preload="metadata"
                                style="width: 100%;" oncontextmenu="return false;" aria-label="پخش‌کننده صوتی">
                                <source src="" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
                <div class="tehran-stats">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="stat-number-tehran"><?php echo $total_episodes; ?></div>
                                <small>قسمت در فصل</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="stat-number-tehran"><?php echo $is_speaker ? '🎙️' : '💰'; ?></div>
                                <small><?php echo $is_speaker ? 'دسترسی ویژه' : 'اشتراک فصل'; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <section class="menu-section">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                        <h3 class="menu-title">📋 قسمت‌های فصل دوم</h3>
                        <div class="input-group w-50" style="min-width: 180px;">
                            <input type="text" id="searchPlaylist" class="form-control search-input-tehran"
                                placeholder="جستجو..." aria-label="جستجوی قسمت">
                            <span class="input-group-text">🔍</span>
                        </div>
                    </div>

                    <div id="playlistContainer">
                        <?php if (count($programs) > 0): ?>
                        <?php foreach ($programs as $index => $program): 
                            // ✅ دمو فقط بر اساس is_free
                            $is_demo = ((int)($program['is_free'] ?? 0) === 1);
                            $is_logged_in = isset($_SESSION['user_id']);
                            
                            // ✅ منطق دسترسی:
                            // - دمو → همه (حتی مهمان)
                            // - گوینده / خریدار → همه
                            // - مهمان غیر دمو → دکمه ورود
                            // - کاربر لاگین بدون اشتراک → دکمه خرید
                            $can_play = $is_demo || $is_speaker || $has_full_tehran_access;
                        ?>
                        <article class="menu-item <?php echo $is_demo ? 'is-demo' : ''; ?>"
                            data-id="<?php echo $program['id']; ?>"
                            data-title="<?php echo htmlspecialchars($program['title']); ?>"
                            data-type="<?php echo htmlspecialchars($program['program_type']); ?>"
                            data-file="<?php echo htmlspecialchars($program['file_path']); ?>"
                            data-index="<?php echo $index; ?>">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <?php if ($can_play): ?>
                                    <!-- ✅ پخش (دمو / گوینده / خریدار) -->
                                    <button class="play-btn-tehran" onclick="playProgram(this, <?php echo $index; ?>)"
                                        aria-label="پخش <?php echo htmlspecialchars($program['title']); ?>">▶️</button>
                                    <?php elseif (!$is_logged_in): ?>
                                    <!-- ✅ مهمان → برو لاگین -->
                                    <button class="play-btn-tehran" style="background:#444; cursor:pointer;"
                                        onclick="location.href='<?php echo htmlspecialchars($login_url); ?>'"
                                        title="برای شنیدن این قسمت، وارد شوید." aria-label="ورود برای شنیدن">🔒</button>
                                    <?php else: ?>
                                    <!-- ✅ کاربر لاگین بدون اشتراک → برو خرید -->
                                    <button class="play-btn-tehran" style="background:#444; cursor:pointer;"
                                        onclick="location.href='buy_tehran.php?season=2'"
                                        title="برای شنیدن این قسمت، اشتراک فصل را بخرید."
                                        aria-label="خرید اشتراک">💰</button>
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <?php if ($is_demo): ?>
                                            <span class="demo-badge">🎁 دمو رایگان</span>
                                            <?php endif; ?>
                                            <?php if ($is_logged_in && ($has_full_tehran_access || $is_speaker) && !$is_demo): ?>
                                            <span class="purchased-badge">✅ خریداری شده</span>
                                            <?php endif; ?>
                                            <h3 class="program-title-tehran mb-1">
                                                <?php echo htmlspecialchars($program['title']); ?></h3>
                                            <span class="program-badge-tehran">🎙️
                                                <?php echo htmlspecialchars($program['program_type']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="text-center py-5">
                            <div style="font-size: 60px; margin-bottom: 20px;">🌃</div>
                            <h3 style="color: #e8e0ff;">هنوز قسمتی به فصل دوم اضافه نشده</h3>
                            <p class="text-muted" style="color: #a090c0;">به زودی با قسمت‌های جدید در خدمت شما خواهیم
                                بود</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- ✅ بخش کامنت‌ها -->
        <!-- ============================================ -->
        <section class="comments-section">
            <h2 class="comments-title">
                💬 نظرات شما
                <span class="comments-count-badge"><?php echo count($comments); ?></span>
            </h2>

            <?php if ($comment_message !== ''): ?>
            <div class="alert alert-<?php echo $comment_message_type; ?> text-center">
                <?php echo htmlspecialchars($comment_message); ?>
            </div>
            <?php endif; ?>

            <div class="comment-form-card">
                <h5>✍️ نظر خود را بنویسید</h5>
                <form method="POST" action="">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="full_name">نام و فامیل <span style="color: #ff5555;">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                placeholder="مثال: علی رضایی" required maxlength="120">
                        </div>
                        <div class="col-md-6">
                            <label for="email">ایمیل (اختیاری)</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="example@mail.com" maxlength="150">
                        </div>
                        <div class="col-12">
                            <label for="comment_text">متن کامنت <span style="color: #ff5555;">*</span></label>
                            <textarea class="form-control" id="comment_text" name="comment_text" rows="3"
                                placeholder="نظر خود را درباره فصل دوم شب‌های تهران بنویسید..." required></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" name="submit_comment" class="comment-submit-btn">
                                📩 ارسال کامنت
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="comments-list">
                <?php if (count($comments) > 0): ?>
                <?php foreach ($comments as $comment): ?>
                <article class="comment-item">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="comment-author">👤 <?php echo htmlspecialchars($comment['full_name']); ?></div>
                        <div class="comment-date">
                            🕐 <?php echo date('Y/m/d H:i', strtotime($comment['created_at'])); ?>
                        </div>
                    </div>
                    <div class="comment-text"><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></div>

                    <?php if (!empty($comment['admin_reply'])): ?>
                    <div class="admin-reply-box">
                        <div class="admin-reply-label">🎙️ پاسخ ادمین:</div>
                        <div class="admin-reply-text"><?php echo nl2br(htmlspecialchars($comment['admin_reply'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="no-comments">
                    <div class="icon">💬</div>
                    <h4>هنوز کامنتی ثبت نشده</h4>
                    <p>اولین نفری باشید که نظر خود را می‌نویسید!</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

    </div>
    <div class="night-glow" aria-hidden="true">🌙✨⭐</div>

    <?php include 'footer.php'; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
    <a href="logout.php" class="logout-btn" title="خروج از حساب کاربری">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path
                d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
        </svg>
        خروج
    </a>
    <?php endif; ?>

    <?php $conn->close(); ?>
    <script>
    const audio = document.getElementById('mainAudio');
    let currentPlayingButton = null;
    let programs = <?php echo json_encode($programs, JSON_UNESCAPED_UNICODE); ?>;

    document.addEventListener('dragstart', function(e) {
        if (e.target.tagName === 'A' || e.target.tagName === 'IMG') {
            e.preventDefault();
        }
    });

    document.addEventListener('contextmenu', function(e) {
        if (e.target.closest('.custom-audio-player') || e.target.tagName === 'AUDIO') {
            e.preventDefault();
            return false;
        }
    });

    function playProgram(button, index) {
        const program = programs[index];
        if (!program) return;
        if (audio.src !== window.location.origin + '/' + program.file_path) {
            audio.src = program.file_path;
        }
        document.getElementById('nowPlayingTitle').innerHTML = program.title;
        document.getElementById('nowPlayingType').innerHTML = program.program_type;
        document.getElementById('nowPlayingIcon').innerHTML = '🌙🎵';
        audio.play().catch(e => console.log('Auto-play prevented'));
        if (currentPlayingButton && currentPlayingButton !== button) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
        }
        button.classList.add('playing');
        button.innerHTML = '⏸️';
        currentPlayingButton = button;
        document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
        button.closest('.menu-item').classList.add('active');
    }
    audio.addEventListener('ended', () => {
        if (currentPlayingButton) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
            currentPlayingButton.closest('.menu-item').classList.remove('active');
        }
        document.getElementById('nowPlayingIcon').innerHTML = '🌙';
    });
    audio.addEventListener('play', () => {
        if (currentPlayingButton && currentPlayingButton.innerHTML !== '⏸️') {
            currentPlayingButton.innerHTML = '⏸️';
            currentPlayingButton.classList.add('playing');
        }
    });
    audio.addEventListener('pause', () => {
        if (currentPlayingButton && currentPlayingButton.innerHTML !== '▶️') {
            currentPlayingButton.innerHTML = '▶️';
            currentPlayingButton.classList.remove('playing');
        }
    });
    document.getElementById('searchPlaylist').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.menu-item').forEach(item => {
            const title = item.getAttribute('data-title').toLowerCase();
            const type = item.getAttribute('data-type').toLowerCase();
            item.style.display = (title.includes(searchTerm) || type.includes(searchTerm)) ? '' :
                'none';
        });
    });
    document.addEventListener('keydown', (e) => {
        if (e.code === 'Space' && !e.target.matches('input, textarea, button')) {
            e.preventDefault();
            audio.paused ? audio.play() : audio.pause();
        }
    });
    </script>
</body>

</html>