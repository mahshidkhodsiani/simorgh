<?php
session_start();
include '../config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ فقط برنامه‌هایی که program_type != 'کافه مه آلود' باشند
$sql = "SELECT * FROM `radio`
    WHERE `title` NOT LIKE '%کافه%'
    AND `program_type` NOT LIKE '%کافه%'
    ORDER BY `id` DESC;
";
$result = $conn->query($sql);

$programs = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
}

// ============================================
// ✅ دریافت آی‌دی رادیو سیمرغ از جدول radios
// ============================================
$radio_info = null;
$radio_query = "SELECT * FROM radios WHERE slug = 'jomeh'";
$radio_result = $conn->query($radio_query);
if ($radio_result && $radio_result->num_rows > 0) {
    $radio_info = $radio_result->fetch_assoc();
}
$for_id = $radio_info['id'] ?? 3;

// ============================================
// ✅ پردازش ارسال کامنت جدید
// ============================================
$comment_message = '';
$comment_message_type = '';

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

$conn->close();
?>

<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ========================================== -->
    <!-- تگ‌های سئو (فقط اضافه شده - متن اصلی حفظ شد) -->
    <!-- ========================================== -->
    <title>رادیو سیمرغ | پخش آنلاین برنامه‌های شنیدنی</title>
    <meta name="description" content="رادیو سیمرغ - مجموعه‌ای از دلنوشته‌ها، دکلمه‌ها، طنزهای رادیویی و برنامه‌های شنیدنی">
    <meta name="keywords" content="رادیو سیمرغ, برنامه رادیویی, دلنوشته, دکلمه, طنز رادیویی">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://simorghtv.com/radios/radio_simorgh.php">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="رادیو سیمرغ | پخش آنلاین برنامه‌های شنیدنی">
    <meta property="og:description" content="رادیو سیمرغ - مجموعه‌ای از دلنوشته‌ها، دکلمه‌ها، طنزهای رادیویی و برنامه‌های شنیدنی">
    <meta property="og:url" content="https://simorghtv.com/radios/radio_simorgh.php">
    <meta property="og:site_name" content="رادیو سیمرغ">
    <meta property="og:image" content="https://simorghtv.com/images/36.png">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="رادیو سیمرغ | پخش آنلاین برنامه‌های شنیدنی">
    <meta name="twitter:description" content="رادیو سیمرغ - مجموعه‌ای از دلنوشته‌ها، دکلمه‌ها، طنزهای رادیویی و برنامه‌های شنیدنی">
    <meta name="twitter:image" content="https://simorghtv.com/images/36.png">

    <!-- JSON-LD Schema.org -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "PodcastSeries",
        "name": "جمعه‌های سیمرغی",
        "description": "پخش زنده و آرشیو بهترین برنامه‌های فرهنگی، هنری و موسیقی",
        "url": "https://simorghtv.com/radios/radio_simorgh.php",
        "language": "fa",
        "genre": "برنامه رادیویی",
        "numberOfEpisodes": "<?php echo count($programs); ?>"
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "رادیو سیمرغ",
        "url": "https://simorghtv.com/radios/radio_simorgh.php",
        "description": "رادیو سیمرغ - مجموعه‌ای از دلنوشته‌ها، دکلمه‌ها، طنزهای رادیویی و برنامه‌های شنیدنی",
        "inLanguage": "fa-IR"
    }
    </script>

    <?php if(count($programs) > 0): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "لیست برنامه‌های رادیو سیمرغ",
        "description": "لیست کامل برنامه‌های رادیو سیمرغ",
        "numberOfItems": "<?php echo count($programs); ?>",
        "itemListElement": [
        <?php foreach($programs as $index => $program): ?>
            {
                "@type": "ListItem",
                "position": <?php echo $index + 1; ?>,
                "item": {
                    "@type": "PodcastEpisode",
                    "name": "<?php echo addslashes(htmlspecialchars($program['title'])); ?>",
                    "description": "برنامه <?php echo addslashes(htmlspecialchars($program['title'])); ?> از رادیو سیمرغ",
                    "contentUrl": "<?php echo htmlspecialchars($program['file_path']); ?>",
                    "inLanguage": "fa",
                    "genre": "<?php echo addslashes(htmlspecialchars($program['program_type'])); ?>"
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
    :root {
        --simorgh-gold: #D4AF37;
        --simorgh-dark: #1a1a2e;
        --simorgh-light: #16213e;
        --simorgh-text: #eee;
    }

    body {
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #0f0f1a 100%);
        position: relative;
        min-height: 100vh;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.05"><path fill="none" stroke="%23D4AF37" stroke-width="0.5" d="M20,50 Q35,30 50,50 T80,50"/><circle cx="50" cy="30" r="5" fill="%23D4AF37"/><path d="M45,55 L50,45 L55,55 Z" fill="%23D4AF37"/></svg>');
        background-repeat: repeat;
        background-size: 60px;
        pointer-events: none;
        z-index: 0;
    }

    .container {
        position: relative;
        z-index: 1;
    }

    .simorgh-header {
        background: linear-gradient(135deg, #0d0d1a 0%, #1a1a3a 100%);
        border-radius: 40px;
        padding: 50px 30px;
        margin-bottom: 40px;
        text-align: center;
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    .simorgh-header::before {
        content: '🦚';
        position: absolute;
        font-size: 200px;
        opacity: 0.05;
        bottom: -40px;
        right: -30px;
        transform: rotate(-15deg);
    }

    .simorgh-header h1 {
        font-size: 2.8rem;
        font-weight: bold;
        color: #D4AF37;
        text-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
    }

    .player-card {
        background: rgba(25, 25, 45, 0.85);
        backdrop-filter: blur(12px);
        border-radius: 30px;
        padding: 30px;
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .simorgh-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .now-playing-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: #D4AF37;
        margin-bottom: 10px;
    }

    .now-playing-type {
        background: rgba(212, 175, 55, 0.2);
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        color: #D4AF37;
    }

    .playlist-section {
        background: rgba(25, 25, 45, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 25px;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .playlist-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #D4AF37;
        border-bottom: 2px solid #D4AF37;
        display: inline-block;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }

    .program-item {
        background: rgba(30, 30, 55, 0.8);
        border-radius: 20px;
        margin-bottom: 12px;
        padding: 12px 18px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .program-item:hover {
        transform: translateX(-5px);
        background: rgba(50, 50, 80, 0.9);
        border-color: rgba(212, 175, 55, 0.5);
    }

    .program-item.active {
        background: rgba(80, 70, 50, 0.9);
        border-color: #D4AF37;
        border-width: 2px;
    }

    .play-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(212, 175, 55, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        border: 1px solid rgba(212, 175, 55, 0.5);
        font-size: 1.1rem;
        color: #D4AF37;
    }

    .play-btn:hover {
        transform: scale(1.1);
        background: #D4AF37;
        color: #1a1a2e;
    }

    .play-btn.playing {
        background: #D4AF37;
        color: #1a1a2e;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(212, 175, 55, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(212, 175, 55, 0);
        }
    }

    .program-title {
        font-weight: 600;
        color: #eee;
        margin-bottom: 5px;
    }

    .program-badge {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 10px;
        background: rgba(212, 175, 55, 0.2);
        color: #D4AF37;
    }

    .search-input {
        border-radius: 50px;
        border: 1px solid rgba(212, 175, 55, 0.5);
        padding: 10px 20px;
        background: rgba(30, 30, 55, 0.8);
        color: #eee;
    }

    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        border-color: #D4AF37;
        background: rgba(40, 40, 65, 0.9);
        color: #eee;
    }

    .input-group-text {
        background: rgba(30, 30, 55, 0.8);
        border: 1px solid rgba(212, 175, 55, 0.5);
        color: #D4AF37;
        border-right: none;
    }

    .stats-card {
        background: rgba(25, 25, 45, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 20px;
        margin-top: 25px;
        text-align: center;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #D4AF37;
    }

    @media (max-width: 768px) {
        .simorgh-header h1 {
            font-size: 1.8rem;
        }

        .playlist-section {
            margin-top: 20px;
        }

        .program-item {
            padding: 10px 12px;
        }

        .play-btn {
            width: 38px;
            height: 38px;
            font-size: 0.9rem;
        }
    }

    /* ============ بردکرامب ============ */
    .breadcrumb-nav {
        margin-bottom: 20px;
        padding: 12px 20px;
        background: rgba(25, 25, 45, 0.7);
        border-radius: 50px;
        border: 1px solid rgba(212, 175, 55, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }

    .breadcrumb-nav a {
        color: #D4AF37;
        text-decoration: none;
        transition: all 0.3s;
    }

    .breadcrumb-nav a:hover {
        color: #fff;
        text-shadow: 0 0 10px rgba(212, 175, 55, 0.5);
    }

    .breadcrumb-nav .separator {
        color: #a09080;
    }

    .breadcrumb-nav .current {
        color: #e0e0e0;
        font-weight: bold;
    }

    /* ============ کامنت‌ها ============ */
    .comments-section {
        background: rgba(25, 25, 45, 0.85);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 35px 30px;
        margin-top: 40px;
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: #f0f0f0;
    }

    .comments-title {
        color: #D4AF37;
        font-weight: bold;
        border-bottom: 2px solid #D4AF37;
        display: inline-block;
        padding-bottom: 8px;
        margin-bottom: 25px;
    }

    .comment-form-card {
        background: rgba(15, 15, 35, 0.8);
        border-radius: 20px;
        padding: 15px 18px;
        border: 1px solid rgba(212, 175, 55, 0.25);
        margin-bottom: 25px;
        max-width: 50%;
        margin-left: auto;
        margin-right: auto;
    }

    .comment-form-card h5 {
        color: #D4AF37;
        font-size: 1rem;
        margin-bottom: 12px;
    }

    .comment-form-card .form-control {
        background: rgba(30, 30, 55, 0.9);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: #f0f0f0;
        border-radius: 12px;
        padding: 8px 14px;
        font-size: 0.9rem;
    }

    .comment-form-card .form-control:focus {
        background: rgba(45, 45, 75, 0.95);
        border-color: #D4AF37;
        color: #fff;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }

    .comment-form-card .form-control::placeholder {
        color: #a09080;
    }

    .comment-form-card label {
        color: #D4AF37;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .comment-form-card textarea.form-control {
        min-height: 70px;
    }

    .comment-submit-btn {
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        color: #1a1a2e;
        font-weight: bold;
        border: none;
        border-radius: 50px;
        padding: 8px 25px;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .comment-submit-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        color: #1a1a2e;
    }

    .comment-item {
        background: rgba(15, 15, 35, 0.7);
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 18px;
        border: 1px solid rgba(212, 175, 55, 0.15);
        transition: all 0.3s;
    }

    .comment-item:hover {
        border-color: rgba(212, 175, 55, 0.4);
        transform: translateX(-3px);
    }

    .comment-author {
        color: #D4AF37;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .comment-date {
        color: #a09080;
        font-size: 12px;
    }

    .comment-text {
        color: #e0e0e0;
        margin-top: 10px;
        line-height: 1.8;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .admin-reply-box {
        background: rgba(212, 175, 55, 0.08);
        border-right: 3px solid #D4AF37;
        border-radius: 12px;
        padding: 12px 18px;
        margin-top: 15px;
        margin-right: 20px;
    }

    .admin-reply-label {
        color: #D4AF37;
        font-weight: bold;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .admin-reply-text {
        color: #d0d0d0;
        line-height: 1.7;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .no-comments {
        text-align: center;
        padding: 40px 20px;
        color: #a09080;
    }

    .no-comments .icon {
        font-size: 50px;
        margin-bottom: 15px;
    }

    .comments-count-badge {
        background: rgba(212, 175, 55, 0.2);
        color: #D4AF37;
        border-radius: 50px;
        padding: 3px 12px;
        font-size: 13px;
        margin-right: 10px;
    }

    @media (max-width: 768px) {
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
        <div class="breadcrumb-nav">
            <a href="index.php">🎙️ همه رادیو ها</a>
            <span class="separator">›</span>
            <span class="current">🦚 رادیو سیمرغ</span>
        </div>

        <div class="simorgh-header">
            <h1>🎙️ رادیو سیمرغ</h1>
            <p class="text-white-50 mb-0">دلنوشته‌ها، دکلمه‌ها، طنزهای رادیویی و برنامه‌های شنیدنی</p>
            <small class="text-muted">🎧 <?php echo count($programs); ?> برنامه برای لحظات ناب شما</small>
        </div>

        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="player-card">
                    <div class="text-center">
                        <div class="simorgh-icon" id="nowPlayingIcon">🦚</div>
                        <h3 id="nowPlayingTitle" class="now-playing-title">هیچ برنامه‌ای انتخاب نشده</h3>
                        <span id="nowPlayingType" class="now-playing-type">برای شروع یکی از برنامه‌ها را انتخاب
                            کنید</span>

                        <div class="mt-4">
                            <audio id="mainAudio" controls preload="metadata" style="width: 100%; border-radius: 50px;">
                                <source src="" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>

                <div class="stats-card">
                    <div class="row">
                        <div class="col-6">
                            <div class="stat-number"><?php echo count($programs); ?></div>
                            <small>برنامه شنیدنی</small>
                        </div>
                        <div class="col-6">
                            <div class="stat-number">🎧</div>
                            <small>رایگان برای همه</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="playlist-section">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <h3 class="playlist-title">📻 لیست برنامه‌ها</h3>
                        <div class="input-group w-50" style="min-width: 180px;">
                            <input type="text" id="searchPlaylist" class="form-control search-input"
                                placeholder="جستجو...">
                            <span class="input-group-text">🔍</span>
                        </div>
                    </div>

                    <div id="playlistContainer">
                        <?php if(count($programs) > 0): ?>
                        <?php foreach($programs as $index => $program): ?>
                        <div class="program-item" data-title="<?php echo htmlspecialchars($program['title']); ?>"
                            data-type="<?php echo htmlspecialchars($program['program_type']); ?>"
                            data-file="<?php echo htmlspecialchars($program['file_path']); ?>"
                            data-index="<?php echo $index; ?>">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <button class="play-btn"
                                        onclick="playProgram(this, <?php echo $index; ?>)">▶️</button>
                                </div>
                                <div class="col">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h6 class="program-title mb-1">
                                                <?php echo htmlspecialchars($program['title']); ?></h6>
                                            <span class="program-badge">🎙️
                                                <?php echo htmlspecialchars($program['program_type']); ?></span>
                                        </div>
                                        <small style="color: #D4AF37;">🎵 MP3</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="text-center py-5">
                            <div style="font-size: 60px;">🎙️</div>
                            <h4 style="color: #D4AF37;">هنوز برنامه‌ای اضافه نشده</h4>
                            <p class="text-muted">به زودی با برنامه‌های جدید در خدمت شما خواهیم بود</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- ✅ بخش کامنت‌ها -->
        <!-- ============================================ -->
        <div class="comments-section">
            <h3 class="comments-title">
                💬 نظرات شما
                <span class="comments-count-badge"><?php echo count($comments); ?></span>
            </h3>

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
                                placeholder="نظر خود را درباره رادیو سیمرغ بنویسید..." required></textarea>
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
                <div class="comment-item">
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
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="no-comments">
                    <div class="icon">💬</div>
                    <h5>هنوز کامنتی ثبت نشده</h5>
                    <p>اولین نفری باشید که نظر خود را می‌نویسید!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>

    <script>
    const audio = document.getElementById('mainAudio');
    let currentPlayingButton = null;
    let currentPlayingIndex = -1;
    let programs = <?php echo json_encode($programs); ?>;

    function playProgram(button, index) {
        const program = programs[index];
        if (!program) return;

        const filePath = program.file_path;
        const title = program.title;
        const programType = program.program_type;

        if (audio.src !== window.location.origin + '/' + filePath && audio.src !== filePath) {
            audio.src = filePath;
        }

        document.getElementById('nowPlayingTitle').innerHTML = title;
        document.getElementById('nowPlayingType').innerHTML = programType;
        document.getElementById('nowPlayingIcon').innerHTML = '🎙️🎵';

        audio.play().catch(e => console.log('Play error:', e));

        if (currentPlayingButton && currentPlayingButton !== button) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
            currentPlayingButton.closest('.program-item')?.classList.remove('active');
        }

        button.classList.add('playing');
        button.innerHTML = '⏸️';
        currentPlayingButton = button;
        currentPlayingIndex = index;

        document.querySelectorAll('.program-item').forEach(item => item.classList.remove('active'));
        button.closest('.program-item').classList.add('active');
    }

    audio.addEventListener('ended', () => {
        if (currentPlayingButton) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
            currentPlayingButton.closest('.program-item')?.classList.remove('active');
        }
        document.getElementById('nowPlayingIcon').innerHTML = '🦚';
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

    const searchInput = document.getElementById('searchPlaylist');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.program-item').forEach(item => {
                const title = item.getAttribute('data-title')?.toLowerCase() || '';
                const type = item.getAttribute('data-type')?.toLowerCase() || '';
                item.style.display = (title.includes(term) || type.includes(term)) ? '' : 'none';
            });
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.code === 'Space' && !e.target.matches('input, textarea, button')) {
            e.preventDefault();
            audio.paused ? audio.play() : audio.pause();
        }
    });
    </script>

</body>

</html>