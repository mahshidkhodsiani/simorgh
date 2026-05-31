<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>رادیو سیمرغ | پخش آنلاین برنامه‌های رادیویی | آرشیو کامل</title>
    <meta name="description"
        content="پخش آنلاین بهترین برنامه‌های رادیو سیمرغ - آرشیو کامل برنامه‌های طنز، دکلمه، موسیقی و برنامه‌های ویژه با کیفیت عالی">
    <meta name="keywords" content="رادیو سیمرغ, پخش آنلاین, برنامه رادیویی, آرشیو رادیو, طنز رادیویی, دکلمه">

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    /* استایل‌های صفحه رادیو سیمرغ */
    .radio-header {
        border-radius: 30px;
        padding: 80px 40px;
        margin-bottom: 40px;
        color: white;
        position: relative;
        overflow: hidden;
        background-image: url('../images/radio-simorgh.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    /* لایه تیره روی عکس برای خوانایی بهتر متن */
    .radio-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.4) 100%);
        z-index: 1;
    }

    /* افکت دایره‌های نورانی روی عکس */
    .radio-header::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        transform: rotate(45deg);
        z-index: 2;
        pointer-events: none;
    }

    /* محتوای هدر باید بالای لایه‌ها قرار بگیره */
    .radio-header>* {
        position: relative;
        z-index: 3;
    }

    .radio-header h1 {
        text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.5);
        font-size: 3rem;
    }

    .radio-header .lead {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        font-size: 1.3rem;
    }

    .radio-header small {
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    .now-playing-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 25px;
        padding: 25px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .playlist-item {
        background: white;
        border-radius: 20px;
        margin-bottom: 15px;
        padding: 15px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .playlist-item:hover {
        transform: translateX(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        border-color: #f5576c;
    }

    .playlist-item.active {
        background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        border-color: #667eea;
        border-width: 2px;
    }

    .playlist-item.active .play-btn {
        background: #667eea;
        color: white;
    }

    .play-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
    }

    .play-btn:hover {
        transform: scale(1.1);
        background: #667eea;
        color: white;
    }

    .play-btn.playing {
        background: #f5576c;
        color: white;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(245, 87, 108, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(245, 87, 108, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(245, 87, 108, 0);
        }
    }

    .program-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-comedy {
        background: #ff6b6b;
        color: white;
    }

    .badge-poem {
        background: #4ecdc4;
        color: white;
    }

    .badge-radio {
        background: #45b7d1;
        color: white;
    }

    .audio-player {
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        border-radius: 60px;
        padding: 15px 25px;
        margin-top: 20px;
    }

    .audio-player audio {
        width: 100%;
        border-radius: 50px;
    }

    audio::-webkit-media-controls-panel {
        background-color: #2d2d2d;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 20px;
    }

    /* انیمیشن برای هدر */
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

    .radio-header h1 {
        animation: fadeInUp 0.8s ease;
    }

    .radio-header .lead {
        animation: fadeInUp 0.8s ease 0.2s both;
    }

    .radio-header small {
        animation: fadeInUp 0.8s ease 0.4s both;
    }

    @media (max-width: 768px) {
        .radio-header {
            padding: 50px 20px;
        }

        .radio-header h1 {
            font-size: 2rem;
        }

        .radio-header .lead {
            font-size: 1rem;
        }

        .playlist-item {
            padding: 10px 15px;
        }

        .program-title {
            font-size: 14px;
        }
    }
    </style>
</head>

<body>

    <?php
include 'header.php';
include '../config.php';

// اتصال به دیتابیس
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM radio WHERE program_type NOT LIKE '%کافه مه%'  ORDER BY id DESC";

$result = $conn->query($sql);

$programs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
}

// تابع تعیین رنگ badge بر اساس نوع برنامه
function getBadgeClass($program_type) {
    switch($program_type) {
        case 'طنز رادیویی':
            return 'badge-comedy';
        case 'دکلمه':
            return 'badge-poem';
        default:
            return 'badge-radio';
    }
}

// تابع آیکون بر اساس نوع برنامه
function getProgramIcon($program_type) {
    switch($program_type) {
        case 'طنز رادیویی':
            return '😄';
        case 'دکلمه':
            return '📖';
        default:
            return '🎙️';
    }
}
?>

    <div class="container mt-4 mb-5">
        <!-- هدر با عکس پس‌زمینه -->
        <div class="radio-header">
            <h1 class="display-4 fw-bold mb-3">🦅 رادیو سیمرغ</h1>
            <p class="lead">آرشیو کامل برنامه‌های رادیویی با کیفیت عالی</p>
            <p class="mb-0"><small>🎧 <?php echo count($programs); ?> برنامه آماده پخش</small></p>
        </div>

        <div class="row">
            <!-- سمت راست: پلیر و آهنگ در حال پخش -->
            <div class="col-lg-5 mb-4">
                <div class="now-playing-card">
                    <div class="text-center">
                        <div style="font-size: 80px; margin-bottom: 20px;" id="nowPlayingIcon">
                            🎵
                        </div>
                        <h3 id="nowPlayingTitle" class="mb-2">هیچ برنامه‌ای انتخاب نشده</h3>
                        <p id="nowPlayingType" class="mb-3" style="opacity: 0.9;">برای شروع یکی از برنامه‌ها را انتخاب
                            کنید</p>

                        <div class="audio-player">
                            <audio id="mainAudio" controls preload="metadata" style="width: 100%;">
                                <source src="" type="audio/mpeg">
                                مرورگر شما از پلیر صوتی پشتیبانی نمی‌کند.
                            </audio>
                        </div>
                    </div>
                </div>

                <!-- آمار و اطلاعات -->
                <div class="card border-0 shadow-sm mt-4" style="border-radius: 20px;">
                    <div class="card-body">
                        <h5 class="mb-3">📊 آمار پخش</h5>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="h4 mb-0" id="totalCount"><?php echo count($programs); ?></div>
                                <small class="text-muted">کل برنامه‌ها</small>
                            </div>
                            <div class="col-4">
                                <div class="h4 mb-0" id="comedyCount">
                                    <?php 
                                $comedyCount = count(array_filter($programs, function($p) { return $p['program_type'] == 'طنز رادیویی'; }));
                                echo $comedyCount;
                                ?>
                                </div>
                                <small class="text-muted">طنز رادیویی</small>
                            </div>
                            <div class="col-4">
                                <div class="h4 mb-0" id="poemCount">
                                    <?php 
                                $poemCount = count(array_filter($programs, function($p) { return $p['program_type'] == 'دکلمه'; }));
                                echo $poemCount;
                                ?>
                                </div>
                                <small class="text-muted">دکلمه</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- سمت چپ: لیست پخش -->
            <div class="col-lg-7">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">📋 لیست پخش</h3>
                    <div class="input-group w-50">
                        <input type="text" id="searchPlaylist" class="form-control" placeholder="جستجو در برنامه‌ها..."
                            style="border-radius: 50px;">
                        <span class="input-group-text" style="border-radius: 50px; background: white;">
                            🔍
                        </span>
                    </div>
                </div>

                <div id="playlistContainer">
                    <?php if (count($programs) > 0): ?>
                    <?php foreach($programs as $index => $program): ?>
                    <div class="playlist-item" data-id="<?php echo $program['id']; ?>"
                        data-title="<?php echo htmlspecialchars($program['title']); ?>"
                        data-type="<?php echo htmlspecialchars($program['program_type']); ?>"
                        data-file="<?php echo htmlspecialchars($program['file_path']); ?>"
                        data-index="<?php echo $index; ?>">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <button class="play-btn" onclick="playProgram(this, <?php echo $index; ?>)">
                                    ▶️
                                </button>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div>
                                        <h6 class="program-title mb-1 fw-bold">
                                            <?php echo htmlspecialchars($program['title']); ?></h6>
                                        <span
                                            class="program-badge <?php echo getBadgeClass($program['program_type']); ?>">
                                            <?php echo getProgramIcon($program['program_type']); ?>
                                            <?php echo htmlspecialchars($program['program_type']); ?>
                                        </span>
                                    </div>
                                    <small class="text-muted" style="direction: ltr;">
                                        🎵 MP3
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="empty-state">
                        <div style="font-size: 60px; margin-bottom: 20px;">📭</div>
                        <h4>هیچ برنامه‌ای یافت نشد</h4>
                        <p class="text-muted">به زودی برنامه‌های جدید اضافه خواهند شد</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <?php $conn->close(); ?>

    <script>
    // پلیر اصلی
    const audio = document.getElementById('mainAudio');
    let currentPlayingButton = null;
    let currentPlayingIndex = -1;
    let programs = <?php echo json_encode($programs); ?>;

    // تابع پخش برنامه
    function playProgram(button, index) {
        const program = programs[index];
        if (!program) return;

        const filePath = program.file_path;
        const title = program.title;
        const programType = program.program_type;

        // تنظیم منبع صوتی
        audio.src = filePath;

        // به‌روزرسانی اطلاعات نمایش داده شده
        document.getElementById('nowPlayingTitle').innerHTML = title;
        document.getElementById('nowPlayingType').innerHTML = programType;

        // تنظیم آیکون بر اساس نوع برنامه
        let icon = '🎵';
        if (programType === 'طنز رادیویی') icon = '😄';
        else if (programType === 'دکلمه') icon = '📖';
        else icon = '🎙️';
        document.getElementById('nowPlayingIcon').innerHTML = icon;

        // پخش فایل
        audio.play();

        // حذف کلاس playing از دکمه قبلی
        if (currentPlayingButton) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
        }

        // اضافه کردن کلاس playing به دکمه جدید
        button.classList.add('playing');
        button.innerHTML = '⏸️';
        currentPlayingButton = button;
        currentPlayingIndex = index;

        // اضافه کردن کلاس active به آیتم لیست
        document.querySelectorAll('.playlist-item').forEach(item => {
            item.classList.remove('active');
        });
        button.closest('.playlist-item').classList.add('active');
    }

    // توقف پخش
    function pauseProgram() {
        audio.pause();
        if (currentPlayingButton) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
        }
    }

    // رویداد پایان پخش
    audio.addEventListener('ended', function() {
        if (currentPlayingButton) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
        }
        if (currentPlayingButton) {
            currentPlayingButton.closest('.playlist-item').classList.remove('active');
        }
    });

    // رویداد پلی/پاز با کلیک روی پلیر
    audio.addEventListener('play', function() {
        if (currentPlayingButton && currentPlayingButton.innerHTML !== '⏸️') {
            currentPlayingButton.innerHTML = '⏸️';
            currentPlayingButton.classList.add('playing');
        }
    });

    audio.addEventListener('pause', function() {
        if (currentPlayingButton && currentPlayingButton.innerHTML !== '▶️') {
            currentPlayingButton.innerHTML = '▶️';
            currentPlayingButton.classList.remove('playing');
        }
    });

    // جستجوی زنده در لیست پخش
    document.getElementById('searchPlaylist').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const items = document.querySelectorAll('.playlist-item');

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
            if (audio.paused) {
                audio.play();
            } else {
                audio.pause();
            }
        }
    });
    </script>

</body>

</html>