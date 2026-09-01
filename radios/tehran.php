<?php
session_start();

if(!isset($_SESSION['user_id'])){
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
}

include '../config.php';

// ========== بررسی گوینده بودن کاربر ==========
$is_speaker = false;
if(isset($_SESSION['user_id'])) {
    $speaker_check_sql = "SELECT speaker FROM users WHERE id = ?";
    $speaker_stmt = $conn->prepare($speaker_check_sql);
    $speaker_stmt->bind_param("i", $_SESSION['user_id']);
    $speaker_stmt->execute();
    $speaker_result = $speaker_stmt->get_result();
    if($speaker_result->num_rows > 0) {
        $speaker_data = $speaker_result->fetch_assoc();
        if(isset($speaker_data['speaker']) && $speaker_data['speaker'] == 1) {
            $is_speaker = true;
        }
    }
    $speaker_stmt->close();
}
// ========== پایان بررسی گوینده ==========

$radio_slug = 'tehran';
$radio_info = null;
$radio_price = 0;

$radio_query = "SELECT * FROM radios WHERE slug = '$radio_slug'";
$radio_result = $conn->query($radio_query);
if($radio_result->num_rows > 0) {
    $radio_info = $radio_result->fetch_assoc();
    $radio_price = $radio_info['price'];
}

// دریافت برنامه‌ها از جدول radio_tehran
$programs = [];
$sql = "SELECT * FROM radio_tehran ORDER BY created_at DESC";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
}

function formatDate($date) {
    if ($date && $date != '0000-00-00 00:00:00') {
        return date('Y/m/d', strtotime($date));
    }
    return '';
}

$poems = ["#سریال_صوتی"];
$randomPoem = $poems[array_rand($poems)];

// ========== بررسی دسترسی کاربر ==========
$has_full_access = false;
$user_purchased_programs = [];
$payment_message = '';

// اگر گوینده باشه، همه چی براش مجانی و کامل هست
if($is_speaker) {
    $has_full_access = true;  // گوینده به همه چیز دسترسی کامل داره
} 
elseif(isset($_SESSION['user_id'])) {
    // بقیه کاربرها مثل قبل، فقط اونایی که خرید کردن
    $user_id = $_SESSION['user_id'];
    
    $check_full_sql = "SELECT * FROM user_radio WHERE user_id = ? AND radio_type = 'tehran' AND paid = 1 AND program_id IS NULL LIMIT 1";
    $check_stmt = $conn->prepare($check_full_sql);
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    if($check_stmt->get_result()->num_rows > 0) {
        $has_full_access = true;
    }
    $check_stmt->close();
    
    if(!$has_full_access) {
        $prog_sql = "SELECT program_id FROM user_radio WHERE user_id = ? AND radio_type = 'tehran' AND paid = 1 AND program_id IS NOT NULL";
        $prog_stmt = $conn->prepare($prog_sql);
        $prog_stmt->bind_param("i", $user_id);
        $prog_stmt->execute();
        $prog_result = $prog_stmt->get_result();
        while($row = $prog_result->fetch_assoc()) {
            $user_purchased_programs[] = $row['program_id'];
        }
        $prog_stmt->close();
    }
}

if(isset($_GET['payment'])) {
    if($_GET['payment'] == 'success') {
        $payment_message = '<div class="alert alert-success text-center">✅ پرداخت شما با موفقیت انجام شد! از شنیدن برنامه‌ها لذت ببرید. 🌙</div>';
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $has_full_access = false;
            $user_purchased_programs = [];
            
            $check_full_sql = "SELECT * FROM user_radio WHERE user_id = ? AND radio_type = 'tehran' AND paid = 1 AND program_id IS NULL LIMIT 1";
            $check_stmt = $conn->prepare($check_full_sql);
            $check_stmt->bind_param("i", $user_id);
            $check_stmt->execute();
            if($check_stmt->get_result()->num_rows > 0) {
                $has_full_access = true;
            }
            $check_stmt->close();
            
            if(!$has_full_access) {
                $prog_sql = "SELECT program_id FROM user_radio WHERE user_id = ? AND radio_type = 'tehran' AND paid = 1 AND program_id IS NOT NULL";
                $prog_stmt = $conn->prepare($prog_sql);
                $prog_stmt->bind_param("i", $user_id);
                $prog_stmt->execute();
                $prog_result = $prog_stmt->get_result();
                while($row = $prog_result->fetch_assoc()) {
                    $user_purchased_programs[] = $row['program_id'];
                }
                $prog_stmt->close();
            }
        }
    } elseif($_GET['payment'] == 'failed') {
        $payment_message = '<div class="alert alert-danger text-center">❌ پرداخت ناموفق بود. لطفاً مجدداً تلاش کنید.</div>';
    } elseif($_GET['payment'] == 'already') {
        $payment_message = '<div class="alert alert-info text-center">ℹ️ این تراکنش قبلاً ثبت شده است.</div>';
    }
}

// آدرس فعلی برای بازگشت بعد از لاگین
$current_url = $_SERVER['REQUEST_URI'];
?>

<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ========================================== -->
    <!-- تگ‌های سئو (فقط اضافه شده - متن اصلی حفظ شد) -->
    <!-- ========================================== -->
    <title>شب‌های تهران | پخش آنلاین برنامه‌های شبانه</title>
    <meta name="description" content="شب‌های تهران - روایت دلنشین شب‌های پایتخت">
    <meta name="keywords" content="شب های تهران, برنامه رادیویی, رادیو آنلاین, سریال صوتی">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://simorghtv.com/radios/tehran.php">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="شب‌های تهران | پخش آنلاین برنامه‌های شبانه">
    <meta property="og:description" content="شب‌های تهران - روایت دلنشین شب‌های پایتخت">
    <meta property="og:url" content="https://simorghtv.com/radios/tehran.php">
    <meta property="og:site_name" content="رادیو سیمرغ">
    <meta property="og:image" content="https://simorghtv.com/images/34.png">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="شب‌های تهران | پخش آنلاین برنامه‌های شبانه">
    <meta name="twitter:description" content="شب‌های تهران - روایت دلنشین شب‌های پایتخت">
    <meta name="twitter:image" content="https://simorghtv.com/images/34.png">

    <!-- JSON-LD Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "PodcastSeries",
        "name": "شب‌های تهران",
        "description": "سریال صوتی شب‌های تهران، روایت‌های شنیدنی از پایتخت ایران",
        "url": "https://simorghtv.com/radios/tehran.php",
        "language": "fa",
        "genre": "برنامه رادیویی",
        "numberOfEpisodes": "<?php echo count($programs); ?>"
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "رادیو سیمرغ - شب‌های تهران",
        "url": "https://simorghtv.com/radios/tehran.php",
        "description": "شب‌های تهران - روایت دلنشین شب‌های پایتخت",
        "inLanguage": "fa-IR"
    }
    </script>

    <?php if(count($programs) > 0): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "لیست برنامه‌های شب‌های تهران",
        "description": "لیست کامل برنامه‌های سریال صوتی شب‌های تهران",
        "numberOfItems": "<?php echo count($programs); ?>",
        "itemListElement": [
            <?php foreach($programs as $index => $program): ?> {
                "@type": "ListItem",
                "position": <?php echo $index + 1; ?>,
                "item": {
                    "@type": "PodcastEpisode",
                    "name": "<?php echo addslashes(htmlspecialchars($program['title'])); ?>",
                    "description": "برنامه <?php echo addslashes(htmlspecialchars($program['title'])); ?> از سریال صوتی شب‌های تهران",
                    "contentUrl": "<?php echo htmlspecialchars($program['file_path']); ?>",
                    "inLanguage": "fa",
                    "genre": "برنامه رادیویی"
                }
            }
            <?php if($index < count($programs) - 1) echo ','; ?>
            <?php endforeach; ?>
        ]
    }
    </script>
    <?php endif; ?>

    <?php include "includes.php"; ?>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    body {
        background: linear-gradient(135deg, #0a0a2a 0%, #1a1a3a 100%);
        min-height: 100vh;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(white 1px, transparent 1px);
        background-size: 50px 50px;
        pointer-events: none;
        opacity: 0.3;
        z-index: 0;
    }

    .tehran-header {
        background: linear-gradient(135deg, #1a1a3e 0%, #2d1b4e 50%, #0f0f2d 100%);
        border-radius: 30px;
        padding: 50px 40px;
        margin-bottom: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 215, 0, 0.3);
    }

    .tehran-header::before {
        content: '🌙';
        position: absolute;
        font-size: 180px;
        opacity: 0.15;
        bottom: -30px;
        right: -30px;
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    .now-playing-card-tehran {
        background: linear-gradient(135deg, rgba(26, 26, 62, 0.95) 0%, rgba(45, 27, 78, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 30px;
        color: white;
        border: 1px solid rgba(255, 215, 0, 0.3);
    }

    .playlist-item-tehran {
        background: rgba(26, 26, 62, 0.9);
        backdrop-filter: blur(5px);
        border-radius: 20px;
        margin-bottom: 15px;
        padding: 15px 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 215, 0, 0.2);
        color: #f0f0f0;
    }

    .playlist-item-tehran:hover {
        transform: translateX(-5px);
        background: rgba(45, 27, 78, 0.95);
        border-color: rgba(255, 215, 0, 0.5);
    }

    .playlist-item-tehran.active {
        background: linear-gradient(135deg, rgba(255, 215, 0, 0.2) 0%, rgba(255, 150, 0, 0.2) 100%);
        border-color: #ffd700;
        border-width: 2px;
    }

    .play-btn-tehran {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ffd700 0%, #ff8c00 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
        color: #1a1a3e;
        font-size: 1.2rem;
    }

    .play-btn-tehran:hover {
        transform: scale(1.1);
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
    }

    .play-btn-tehran.playing {
        background: linear-gradient(135deg, #ff8c00 0%, #ff4500 100%);
        animation: glowPulse 1.5s infinite;
        color: white;
    }

    @keyframes glowPulse {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.4);
        }

        50% {
            box-shadow: 0 0 0 10px rgba(255, 215, 0, 0);
        }
    }

    .program-badge-tehran {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        background: rgba(255, 215, 0, 0.2);
        color: #ffd700;
        border: 1px solid rgba(255, 215, 0, 0.3);
    }

    .stat-card-tehran {
        background: rgba(26, 26, 62, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        border: 1px solid rgba(255, 215, 0, 0.2);
    }

    .moon-icon {
        font-size: 60px;
        margin-bottom: 15px;
        animation: moonGlow 3s ease-in-out infinite;
    }

    @keyframes moonGlow {

        0%,
        100% {
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        50% {
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.8);
        }
    }

    .search-box-tehran {
        background: rgba(26, 26, 62, 0.9);
        border: 1px solid rgba(255, 215, 0, 0.3);
        color: white;
        border-radius: 50px;
    }

    .search-box-tehran:focus {
        background: rgba(45, 27, 78, 0.95);
        border-color: #ffd700;
        color: white;
    }

    .audio-player-tehran {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 60px;
        padding: 10px;
        margin-top: 20px;
    }

    audio {
        width: 100%;
        border-radius: 50px;
    }

    .empty-state-tehran {
        text-align: center;
        padding: 60px 20px;
        background: rgba(26, 26, 62, 0.9);
        border-radius: 20px;
    }

    .buy-btn {
        background: linear-gradient(135deg, #ff9800, #ff5722);
        border: none;
        border-radius: 50px;
        padding: 8px 20px;
        color: white;
        font-weight: bold;
        transition: all 0.3s;
    }

    .buy-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(255, 87, 34, 0.5);
    }

    .purchased-badge {
        background: #28a745;
        border-radius: 50px;
        padding: 5px 15px;
        font-size: 12px;
        color: white;
    }

    .speaker-badge {
        background: linear-gradient(135deg, #ffd700, #ff8c00);
        border-radius: 50px;
        padding: 8px 20px;
        font-size: 14px;
        color: #1a1a3e;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 15px;
    }

    /* استایل دکمه خروج */
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

    @media (max-width: 768px) {
        .tehran-header {
            padding: 30px 20px;
        }

        .tehran-header::before {
            font-size: 100px;
        }

        .playlist-item-tehran {
            padding: 12px 15px;
        }

        .logout-btn {
            bottom: 20px;
            right: 20px;
            padding: 10px 18px;
            font-size: 13px;
            gap: 6px;
        }
    }

    .hashtag-tehran {
        display: inline-block;
        padding: 5px 16px;
        border-radius: 50px;
        background: rgba(255, 215, 0, 0.15);
        color: #ffd700;
        border: 1.5px solid #ffd700;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: default;
    }

    .hashtag-tehran:hover {
        background: rgba(255, 215, 0, 0.25);
        transform: scale(1.03);
        box-shadow: 0 0 15px rgba(255, 215, 0, 0.2);
    }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-4 mb-5" style="position: relative; z-index: 1;">
        <?php echo $payment_message; ?>

        <?php if($is_speaker): ?>
        <div class="alert alert-success text-center mb-3"
            style="background: linear-gradient(135deg, #c6d0cb, #0a5433); border: 1px solid #ffd700;">
            🌟🌟 به پنل گویندگی خوش آمدید! شما به عنوان گوینده، دسترسی رایگان و کامل به تمام برنامه‌ها دارید. 🌟🌟
        </div>
        <?php endif; ?>

        <div class="tehran-header">
            <div class="text-center">
                <div class="moon-icon">🌙</div>
                <h1 class="display-4 fw-bold mb-3"><?php echo $radio_info['name'] ?? 'شب‌های تهران'; ?></h1>
                <p class="lead mb-2"><?php echo $randomPoem; ?></p>
                <p class="mb-0"><?php echo $radio_info['description'] ?? ''; ?></p>

                <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
                    <span class="hashtag-tehran">#سریال_صوتی</span>
                    <span class="hashtag-tehran">#تهران_گردی</span>
                    <span class="hashtag-tehran">#داستان_شب</span>
                    <span class="hashtag-tehran">#رادیو_سیمرغ</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="now-playing-card-tehran">
                    <div class="text-center">
                        <div style="font-size: 80px; margin-bottom: 20px;" id="nowPlayingIconTehran">🌙</div>
                        <h3 id="nowPlayingTitleTehran" class="mb-2">شبانه‌ای انتخاب نشده</h3>
                        <p id="nowPlayingTypeTehran" class="mb-3" style="opacity: 0.8;">به شب‌های تهران خوش آمدید...</p>
                        <div class="audio-player-tehran">
                            <audio id="mainAudioTehran" controls controlsList="nodownload" preload="metadata">
                                <source src="" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-6">
                        <div class="stat-card-tehran">
                            <div style="font-size: 30px;">🎧</div>
                            <div class="h3 mb-0" style="color: #ffd700;"><?php echo count($programs); ?></div>
                            <small>برنامه شبانه</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-card-tehran">
                            <div style="font-size: 30px;">💰</div>
                            <div class="h3 mb-0" style="color: #ffd700;">
                                <?php echo $is_speaker ? 'رایگان' : 'پرداختی'; ?>
                            </div>
                            <small><?php echo $is_speaker ? 'دسترسی ویژه' : 'قیمت هر برنامه'; ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <?php if(!isset($_SESSION['user_id'])): ?>
                <div class="text-center mb-4">
                    <div class="alert alert-warning">برای دسترسی به برنامه‌ها، لطفاً <a
                            href="../login.php?redirect=<?php echo urlencode($current_url); ?>">وارد
                            شوید</a></div>
                    <button class="btn btn-info btn-lg"
                        onclick="location.href='../login.php?redirect=<?php echo urlencode($current_url); ?>'">🔐 ورود
                        یا
                        ثبت‌نام</button>
                </div>
                <div id="playlistContainerTehran">
                    <?php foreach($programs as $program): ?>
                    <div class="playlist-item-tehran opacity-50" style="cursor: not-allowed;">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="play-btn-tehran" style="opacity:0.5;">🔒</div>
                            </div>
                            <div class="col">
                                <h6 class="mb-1"><?php echo htmlspecialchars($program['title']); ?></h6>
                                <span class="program-badge-tehran">🌙
                                    <?php echo htmlspecialchars($program['program_type']); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h3 class="mb-0" style="color: #ffd700;">📻 لیست پخش شبانه</h3>
                    <div class="input-group w-50">
                        <input type="text" id="searchPlaylistTehran" class="form-control search-box-tehran"
                            placeholder="جستجو در برنامه‌های شبانه..." style="border-radius: 50px;">
                        <span class="input-group-text"
                            style="border-radius: 50px; background: rgba(26,26,62,0.9); border: 1px solid rgba(255,215,0,0.3); color: #ffd700;">🌙</span>
                    </div>
                </div>
                <div id="playlistContainerTehran">
                    <?php if(count($programs) > 0): ?>
                    <?php foreach($programs as $index => $program): 
                        $has_access_to_this = $has_full_access || in_array($program['id'], $user_purchased_programs);
                    ?>
                    <div class="playlist-item-tehran" data-title="<?php echo htmlspecialchars($program['title']); ?>"
                        data-type="<?php echo htmlspecialchars($program['program_type']); ?>"
                        data-file="<?php echo htmlspecialchars($program['file_path']); ?>"
                        data-program-id="<?php echo $program['id']; ?>" data-index="<?php echo $index; ?>">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <?php if($has_access_to_this): ?>
                                <button class="play-btn-tehran"
                                    onclick="playProgramTehran(this, <?php echo $index; ?>)">▶️</button>
                                <?php else: ?>
                                <button class="play-btn-tehran" style="background: #555;"
                                    onclick="buyProgram(<?php echo $program['id']; ?>, '<?php echo addslashes($program['title']); ?>', <?php echo ($program['price'] / 10); ?>)">
                                    💰
                                </button>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <h6 class="mb-1 fw-bold">
                                            <?php echo htmlspecialchars($program['title']); ?>
                                            <?php if($has_access_to_this): ?>
                                            <span class="purchased-badge ms-2">✅ خریداری شده</span>
                                            <?php endif; ?>
                                            <?php if($is_speaker): ?>
                                            <span class="purchased-badge ms-2"
                                                style="background: #ffd700; color: #1a1a3e;">🎙️ گوینده</span>
                                            <?php endif; ?>
                                        </h6>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="program-badge-tehran">🌙
                                                <?php echo htmlspecialchars($program['program_type']); ?></span>
                                            <?php if(formatDate($program['created_at'])): ?>
                                            <span class="date-badge">📅
                                                <?php echo formatDate($program['created_at']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if(!$has_access_to_this && !$is_speaker): ?>
                                    <small style="color: #ff9800; cursor:pointer;"
                                        onclick="buyProgram(<?php echo $program['id']; ?>, '<?php echo addslashes($program['title']); ?>', <?php echo ($program['price'] / 10); ?>)">
                                        💰 <?php echo number_format($program['price'] / 10); ?> تومان
                                    </small>
                                    <?php elseif($is_speaker): ?>
                                    <small style="color: #ffd700;">🎙️ دسترسی ویژه گوینده</small>
                                    <?php else: ?>
                                    <small style="color: #ffd700;">🎙️ شبانه</small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="empty-state-tehran">
                        <div style="font-size: 60px;">🌙</div>
                        <h4 style="color: #ffd700;">هیچ برنامه‌ای یافت نشد</h4>
                        <p class="text-muted">به زودی با برنامه‌های جدید همراه باشید</p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- دکمه خروج - فقط در صورتی که کاربر وارد شده باشد نشان داده می‌شود -->
    <?php if(isset($_SESSION['user_id'])): ?>
    <a href="logout.php" class="logout-btn" title="خروج از حساب کاربری">
        <svg viewBox="0 0 24 24">
            <path
                d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" />
        </svg>
        خروج
    </a>
    <?php endif; ?>

    <?php $conn->close(); ?>
    <script>
    const audioTehran = document.getElementById('mainAudioTehran');
    let currentPlayingButtonTehran = null;
    let currentPlayingIndexTehran = -1;
    let programsTehran = <?php echo json_encode($programs); ?>;

    function playProgramTehran(button, index) {
        const program = programsTehran[index];
        if (!program) return;
        audioTehran.src = program.file_path;
        document.getElementById('nowPlayingTitleTehran').innerHTML = program.title;
        document.getElementById('nowPlayingTypeTehran').innerHTML = program.program_type + " | شبانه";
        document.getElementById('nowPlayingIconTehran').innerHTML = '🌙';
        audioTehran.play().catch(e => console.log('Play error:', e));
        if (currentPlayingButtonTehran) {
            currentPlayingButtonTehran.classList.remove('playing');
            currentPlayingButtonTehran.innerHTML = '▶️';
        }
        button.classList.add('playing');
        button.innerHTML = '⏸️';
        currentPlayingButtonTehran = button;
        currentPlayingIndexTehran = index;
        document.querySelectorAll('.playlist-item-tehran').forEach(item => item.classList.remove('active'));
        button.closest('.playlist-item-tehran').classList.add('active');
    }

    function buyProgram(programId, programTitle, programPrice) {
        if (confirm(
                `آیا می‌خواهید برنامه "${programTitle}" را به مبلغ ${new Intl.NumberFormat().format(programPrice)} تومان خریداری کنید؟`
            )) {
            window.location.href = `payment_program.php?program_id=${programId}`;
        }
    }

    audioTehran.addEventListener('ended', function() {
        if (currentPlayingButtonTehran) {
            currentPlayingButtonTehran.classList.remove('playing');
            currentPlayingButtonTehran.innerHTML = '▶️';
            currentPlayingButtonTehran.closest('.playlist-item-tehran').classList.remove('active');
        }
    });

    audioTehran.addEventListener('play', function() {
        if (currentPlayingButtonTehran && currentPlayingButtonTehran.innerHTML !== '⏸️') {
            currentPlayingButtonTehran.innerHTML = '⏸️';
            currentPlayingButtonTehran.classList.add('playing');
        }
    });

    audioTehran.addEventListener('pause', function() {
        if (currentPlayingButtonTehran && currentPlayingButtonTehran.innerHTML !== '▶️') {
            currentPlayingButtonTehran.innerHTML = '▶️';
            currentPlayingButtonTehran.classList.remove('playing');
        }
    });

    const searchInput = document.getElementById('searchPlaylistTehran');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            document.querySelectorAll('.playlist-item-tehran').forEach(item => {
                const title = item.getAttribute('data-title')?.toLowerCase() || '';
                const type = item.getAttribute('data-type')?.toLowerCase() || '';
                item.style.display = (title.includes(searchTerm) || type.includes(searchTerm)) ? '' :
                    'none';
            });
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.code === 'Space' && !e.target.matches('input, textarea, button')) {
            e.preventDefault();
            audioTehran.paused ? audioTehran.play() : audioTehran.pause();
        }
    });
    </script>
</body>

</html>