<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>شب‌های تهران | پخش آنلاین برنامه‌های شبانه | خاطرات پایتخت</title>
    <meta name="description"
        content="شب‌های تهران - روایت دلنشین شب‌های پایتخت، خاطرات شهری، موسیقی ماندگار و لحظات ناب. با ما همراه شوید و از شنیدن بهترین برنامه‌های شبانه لذت ببرید.">
    <meta name="keywords" content="شب‌های تهران, برنامه شبانه, خاطرات تهران, موسیقی ماندگار, رادیو تهران, پخش آنلاین">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="شب‌های تهران | پخش آنلاین برنامه‌های شبانه">
    <meta property="og:description" content="روایت دلنشین شب‌های پایتخت">
    <meta property="og:image" content="../images/tehran-night.jpg">
    <meta property="og:type" content="website">

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    /* استایل اختصاصی شب‌های تهران */
    body {
        background: linear-gradient(135deg, #0a0a2a 0%, #1a1a3a 100%);
        position: relative;
        min-height: 100vh;
    }

    /* افکت ستاره‌ها */
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
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
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

    .tehran-header::after {
        content: '🏙️';
        position: absolute;
        font-size: 120px;
        opacity: 0.1;
        top: -20px;
        left: -20px;
        animation: float 8s ease-in-out infinite reverse;
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

    .moon-glow {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 80px;
        height: 80px;
        background: radial-gradient(circle, rgba(255, 215, 0, 0.3) 0%, rgba(255, 215, 0, 0) 70%);
        border-radius: 50%;
        animation: pulseGlow 4s ease-in-out infinite;
    }

    @keyframes pulseGlow {

        0%,
        100% {
            transform: scale(1);
            opacity: 0.3;
        }

        50% {
            transform: scale(1.3);
            opacity: 0.6;
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
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .playlist-item-tehran {
        background: rgba(26, 26, 62, 0.9);
        backdrop-filter: blur(5px);
        border-radius: 20px;
        margin-bottom: 15px;
        padding: 15px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid rgba(255, 215, 0, 0.2);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        color: #f0f0f0;
    }

    .playlist-item-tehran:hover {
        transform: translateX(-5px);
        background: rgba(45, 27, 78, 0.95);
        border-color: rgba(255, 215, 0, 0.5);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
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
        font-weight: bold;
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
        font-weight: bold;
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
        transition: all 0.3s;
    }

    .stat-card-tehran:hover {
        transform: translateY(-5px);
        border-color: rgba(255, 215, 0, 0.5);
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
        box-shadow: none;
    }

    .search-box-tehran::placeholder {
        color: rgba(255, 255, 255, 0.5);
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

    audio::-webkit-media-controls-panel {
        background: #2d1b4e;
    }

    audio::-webkit-media-controls-current-time-display,
    audio::-webkit-media-controls-time-remaining-display {
        color: white;
    }

    .empty-state-tehran {
        text-align: center;
        padding: 60px 20px;
        background: rgba(26, 26, 62, 0.9);
        border-radius: 20px;
        border: 1px solid rgba(255, 215, 0, 0.2);
    }

    .date-badge {
        font-size: 11px;
        color: rgba(255, 215, 0, 0.6);
        direction: ltr;
        display: inline-block;
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
    }
    </style>
</head>

<body>

    <?php
include 'header.php';
include '../config.php';

// اتصال به دیتابیس radio_tehran
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// دریافت لیست برنامه‌های شب‌های تهران از جدول radio_tehran
$sql = "SELECT * FROM radio_tehran ORDER BY created_at DESC, id DESC";
$result = $conn->query($sql);

$programs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
}

// تابع تبدیل تاریخ به شمسی (اگر needed)
function formatDate($date) {
    if ($date && $date != '0000-00-00 00:00:00') {
        return date('Y/m/d', strtotime($date));
    }
    return '';
}

// شعر شبانه برای هدر
$poems = [
    "شب‌های تهران، قصه‌های ناگفته‌ی شهر...",
];
$randomPoem = $poems[array_rand($poems)];
?>

    <div class="container mt-4 mb-5" style="position: relative; z-index: 1;">
        <!-- هدر شب‌های تهران -->
        <div class="tehran-header">
            <div class="moon-glow"></div>
            <div class="text-center">
                <div class="moon-icon">🌙</div>
                <h1 class="display-4 fw-bold mb-3">شب‌های تهران</h1>
                <p class="lead mb-2"><?php echo $randomPoem; ?></p>
                <p class="mb-0 d-flex justify-content-center gap-3 flex-wrap">
                    <small>🎙️ روایت دلنشین پایتخت</small>
                    <small>📊 <?php echo count($programs); ?> برنامه شبانه</small>
                </p>
            </div>
        </div>

        <div class="row">
            <!-- سمت راست: پلیر و آهنگ در حال پخش -->
            <div class="col-lg-5 mb-4">
                <div class="now-playing-card-tehran">
                    <div class="text-center">
                        <div style="font-size: 80px; margin-bottom: 20px; animation: moonGlow 3s ease-in-out infinite;"
                            id="nowPlayingIconTehran">
                            🌙
                        </div>
                        <h3 id="nowPlayingTitleTehran" class="mb-2">شبانه‌ای انتخاب نشده</h3>
                        <p id="nowPlayingTypeTehran" class="mb-3" style="opacity: 0.8;">به شب‌های تهران خوش آمدید...</p>

                        <div class="audio-player-tehran">
                            <audio id="mainAudioTehran" controls preload="metadata">
                                <source src="" type="audio/mpeg">
                                مرورگر شما از پلیر صوتی پشتیبانی نمی‌کند.
                            </audio>
                        </div>
                    </div>
                </div>

                <!-- آمار و اطلاعات شبانه -->
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
                            <div style="font-size: 30px;">🌙</div>
                            <div class="h3 mb-0" style="color: #ffd700;">۲۴/۷</div>
                            <small>پخش شبانه</small>
                        </div>
                    </div>
                </div>

                <!-- نقل قول شبانه -->
                <div class="stat-card-tehran mt-3">
                    <div style="font-size: 20px; color: #ffd700;">"</div>
                    <p class="mb-0" style="font-size: 13px; line-height: 1.8;">
                        تهران همیشه قشنگ نبود، اما شب‌هایش همیشه خاطره‌انگیزند...
                    </p>
                    <small class="text-muted">- شب‌های تهران</small>
                </div>
            </div>

            <!-- سمت چپ: لیست پخش -->
            <div class="col-lg-7">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h3 class="mb-0" style="color: #ffd700;">📻 لیست پخش شبانه</h3>
                    <div class="input-group w-50">
                        <input type="text" id="searchPlaylistTehran" class="form-control search-box-tehran"
                            placeholder="جستجو در برنامه‌های شبانه..." style="border-radius: 50px;">
                        <span class="input-group-text"
                            style="border-radius: 50px; background: rgba(26,26,62,0.9); border: 1px solid rgba(255,215,0,0.3); color: #ffd700;">
                            🌙
                        </span>
                    </div>
                </div>

                <div id="playlistContainerTehran">
                    <?php if (count($programs) > 0): ?>
                    <?php foreach($programs as $index => $program): ?>
                    <div class="playlist-item-tehran" data-id="<?php echo $program['id']; ?>"
                        data-title="شب‌های تهران - <?php echo htmlspecialchars($program['title']); ?>"
                        data-type="<?php echo htmlspecialchars($program['program_type']); ?>"
                        data-file="<?php echo htmlspecialchars($program['file_path']); ?>"
                        data-date="<?php echo formatDate($program['created_at']); ?>"
                        data-index="<?php echo $index; ?>">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <button class="play-btn-tehran"
                                    onclick="playProgramTehran(this, <?php echo $index; ?>)">
                                    ▶️
                                </button>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($program['title']); ?></h6>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="program-badge-tehran">
                                                🌙 <?php echo htmlspecialchars($program['program_type']); ?>
                                            </span>
                                            <?php if(formatDate($program['created_at'])): ?>
                                            <span class="date-badge">
                                                📅 <?php echo formatDate($program['created_at']); ?>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <small style="color: #ffd700;">
                                        🎙️ شبانه
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="empty-state-tehran">
                        <div style="font-size: 60px; margin-bottom: 20px;">🌙</div>
                        <h4 style="color: #ffd700;">هیچ برنامه‌ای یافت نشد</h4>
                        <p class="text-muted">به زودی با برنامه‌های جدید شب‌های تهران همراه باشید</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    $conn->close();

    ?>

    <script>
    // پلیر شب‌های تهران
    const audioTehran = document.getElementById('mainAudioTehran');
    let currentPlayingButtonTehran = null;
    let currentPlayingIndexTehran = -1;
    let programsTehran = <?php echo json_encode($programs); ?>;

    // تابع پخش برنامه
    function playProgramTehran(button, index) {
        const program = programsTehran[index];
        if (!program) return;

        const filePath = program.file_path;
        const title = "شب‌های تهران - " + program.title;
        const programType = program.program_type;

        // تنظیم منبع صوتی
        audioTehran.src = filePath;

        // به‌روزرسانی اطلاعات نمایش داده شده
        document.getElementById('nowPlayingTitleTehran').innerHTML = title;
        document.getElementById('nowPlayingTypeTehran').innerHTML = programType + " | شبانه";

        // تنظیم آیکون ماه
        document.getElementById('nowPlayingIconTehran').innerHTML = '🌙';

        // پخش فایل
        audioTehran.play().catch(e => console.log('Play error:', e));

        // حذف کلاس playing از دکمه قبلی
        if (currentPlayingButtonTehran) {
            currentPlayingButtonTehran.classList.remove('playing');
            currentPlayingButtonTehran.innerHTML = '▶️';
        }

        // اضافه کردن کلاس playing به دکمه جدید
        button.classList.add('playing');
        button.innerHTML = '⏸️';
        currentPlayingButtonTehran = button;
        currentPlayingIndexTehran = index;

        // اضافه کردن کلاس active به آیتم لیست
        document.querySelectorAll('.playlist-item-tehran').forEach(item => {
            item.classList.remove('active');
        });
        button.closest('.playlist-item-tehran').classList.add('active');
    }

    // رویداد پایان پخش
    audioTehran.addEventListener('ended', function() {
        if (currentPlayingButtonTehran) {
            currentPlayingButtonTehran.classList.remove('playing');
            currentPlayingButtonTehran.innerHTML = '▶️';
            currentPlayingButtonTehran.closest('.playlist-item-tehran').classList.remove('active');
        }
    });

    // رویداد پلی/پاز
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

    // جستجوی زنده
    document.getElementById('searchPlaylistTehran').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const items = document.querySelectorAll('.playlist-item-tehran');

        items.forEach(item => {
            const title = item.getAttribute('data-title').toLowerCase();
            const type = item.getAttribute('data-type').toLowerCase();

            if (title.includes(searchTerm) || type.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // پشتیبانی از کیبورد (Space برای پلی/پاز)
    document.addEventListener('keydown', function(e) {
        if (e.code === 'Space' && !e.target.matches('input, textarea, button')) {
            e.preventDefault();
            if (audioTehran.paused) {
                audioTehran.play();
            } else {
                audioTehran.pause();
            }
        }
    });
    </script>

</body>

</html>