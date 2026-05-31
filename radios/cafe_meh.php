<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>کافه مه آلود | فضایی گرم با موسیقی و گفتگوهای دلنشین</title>
    <meta name="description"
        content="کافه مه آلود - فضایی گرم و صمیمی با موسیقی ملایم، دکلمه‌های ناب و گفتگوهای دلنشین. همراه ما باشید و لحظاتی آرام را تجربه کنید.">
    <meta name="keywords" content="کافه مه آلود, موسیقی ملایم, دکلمه, پادکست, رادیو اینترنتی, فضای کافه">

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
    /* استایل‌های کافه‌ای و گرم با پس‌زمینه قهوه‌ای */
    :root {
        --cafe-brown: #6F4E37;
        --cafe-cream: #F5E6D3;
        --cafe-dark: #2C1810;
        --cafe-warm: #D4A373;
        --cafe-light: #FAF0E6;
        --cafe-wall: #5D3A2A;
    }

    /* پس‌زمینه اصلی به سبک کافه */
    body {
        background: linear-gradient(135deg, #2c1810 0%, #3e2723 60%, #4a3028 100%);
        position: relative;
        min-height: 100vh;
    }

    /* بافت دیوار کافه (آجری/چوبی ملایم) */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            radial-gradient(circle at 30% 40%, rgba(210, 180, 140, 0.06) 0%, transparent 60%),
            radial-gradient(circle at 70% 80%, rgba(160, 120, 80, 0.05) 0%, transparent 60%),
            repeating-linear-gradient(45deg, rgba(139, 69, 19, 0.03) 0px, rgba(139, 69, 19, 0.03) 1px, transparent 1px, transparent 10px);
        pointer-events: none;
        z-index: 0;
    }

    /* خطوط چوبی کف کافه */
    body::after {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: repeating-linear-gradient(90deg, rgba(210, 180, 140, 0.08) 0px, rgba(210, 180, 140, 0.08) 2px, transparent 2px, transparent 40px);
        pointer-events: none;
        z-index: 0;
    }

    /* محتوای اصلی */
    .container {
        position: relative;
        z-index: 1;
    }

    /* هدر کافه‌ای */
    .cafe-header {
        background: linear-gradient(135deg, #1a0f0a 0%, #2c1810 50%, #1a0f0a 100%);
        border-radius: 40px;
        padding: 60px 30px;
        margin-bottom: 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(212, 163, 115, 0.3);
    }

    .cafe-header::before {
        content: '☕';
        position: absolute;
        font-size: 300px;
        opacity: 0.06;
        bottom: -50px;
        left: -50px;
        transform: rotate(-15deg);
        pointer-events: none;
    }

    .cafe-header::after {
        content: '✨';
        position: absolute;
        font-size: 200px;
        opacity: 0.05;
        top: -30px;
        right: -30px;
        pointer-events: none;
    }

    .cafe-header h1 {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        position: relative;
        display: inline-block;
        color: #f0e0c0;
    }

    .cafe-header .lead {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        color: #d4c4a8;
    }

    .cafe-header small {
        color: #b8a88a;
    }

    /* کارت پلیر با شیشه مات (کافه‌ای) */
    .cafe-player-card {
        background: rgba(30, 20, 15, 0.7);
        backdrop-filter: blur(12px);
        border-radius: 30px;
        padding: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(212, 163, 115, 0.3);
        position: relative;
        overflow: hidden;
    }

    .coffee-cup-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #D4A373, #B8956A);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

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
        color: #f0e0c0;
        margin-bottom: 10px;
    }

    .now-playing-type {
        background: rgba(212, 163, 115, 0.8);
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.85rem;
        color: #2c1810;
        font-weight: bold;
    }

    /* پلیر صوتی */
    .custom-audio-player {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 60px;
        padding: 15px 20px;
        margin-top: 20px;
    }

    audio {
        width: 100%;
        border-radius: 50px;
    }

    audio::-webkit-media-controls-panel {
        background-color: #2c1810;
    }

    audio::-webkit-media-controls-current-time-display,
    audio::-webkit-media-controls-time-remaining-display {
        color: #f0e0c0;
    }

    /* منوی کافه (لیست برنامه‌ها) */
    .menu-section {
        background: rgba(30, 20, 15, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 30px;
        padding: 25px;
        border: 1px solid rgba(212, 163, 115, 0.25);
    }

    .menu-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #f0e0c0;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #D4A373;
        display: inline-block;
    }

    /* آیتم منو */
    .menu-item {
        background: rgba(45, 35, 30, 0.8);
        backdrop-filter: blur(5px);
        border-radius: 20px;
        margin-bottom: 15px;
        padding: 15px 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid rgba(212, 163, 115, 0.2);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .menu-item::before {
        content: '☕';
        position: absolute;
        right: -20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 50px;
        opacity: 0;
        transition: all 0.3s;
        pointer-events: none;
        color: rgba(212, 163, 115, 0.3);
    }

    .menu-item:hover::before {
        right: 10px;
        opacity: 0.3;
    }

    .menu-item:hover {
        transform: translateX(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        border-color: rgba(212, 163, 115, 0.5);
        background: rgba(55, 45, 40, 0.9);
    }

    .menu-item.active {
        background: rgba(80, 60, 50, 0.9);
        border-color: #D4A373;
        border-width: 2px;
    }

    .menu-item.active .play-btn-cafe {
        background: #D4A373;
        color: #2c1810;
    }

    .play-btn-cafe {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(80, 60, 50, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        cursor: pointer;
        border: 1px solid rgba(212, 163, 115, 0.5);
        font-size: 1.2rem;
        color: #D4A373;
    }

    .play-btn-cafe:hover {
        transform: scale(1.1);
        background: #D4A373;
        color: #2c1810;
    }

    .play-btn-cafe.playing {
        background: #D4A373;
        color: #2c1810;
        animation: pulseCafe 1.5s infinite;
    }

    @keyframes pulseCafe {
        0% {
            box-shadow: 0 0 0 0 rgba(212, 163, 115, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(212, 163, 115, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(212, 163, 115, 0);
        }
    }

    .program-title-cafe {
        font-size: 1rem;
        font-weight: 600;
        color: #f0e0c0;
        margin-bottom: 5px;
    }

    .program-badge-cafe {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        background: rgba(212, 163, 115, 0.2);
        color: #D4A373;
        font-weight: 500;
    }

    /* آمار */
    .cafe-stats {
        background: rgba(30, 20, 15, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 20px;
        margin-top: 25px;
        border: 1px solid rgba(212, 163, 115, 0.25);
    }

    .stat-item-cafe {
        text-align: center;
        padding: 10px;
    }

    .stat-number-cafe {
        font-size: 1.8rem;
        font-weight: bold;
        color: #D4A373;
    }

    .stat-item-cafe small {
        color: #b8a88a;
    }

    /* جستجو */
    .search-input-cafe {
        border-radius: 50px;
        border: 1px solid rgba(212, 163, 115, 0.5);
        padding: 10px 20px;
        background: rgba(45, 35, 30, 0.8);
        color: #f0e0c0;
        transition: all 0.3s;
    }

    .search-input-cafe::placeholder {
        color: #a09080;
    }

    .search-input-cafe:focus {
        box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.2);
        border-color: #D4A373;
        background: rgba(55, 45, 40, 0.9);
        color: #f0e0c0;
    }

    .input-group-text {
        background: rgba(45, 35, 30, 0.8);
        border: 1px solid rgba(212, 163, 115, 0.5);
        color: #D4A373;
        border-right: none;
    }

    /* افکت بخار قهوه */
    .coffee-steam {
        position: fixed;
        bottom: 20px;
        left: 20px;
        font-size: 30px;
        opacity: 0.2;
        pointer-events: none;
        animation: steam 4s ease-in-out infinite;
        z-index: 2;
    }

    @keyframes steam {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 0.2;
        }

        50% {
            transform: translateY(-15px) rotate(5deg);
            opacity: 0.4;
        }
    }

    /* ریسپانسیو */
    @media (max-width: 768px) {
        .cafe-header {
            padding: 40px 20px;
        }

        .cafe-header h1 {
            font-size: 2rem;
        }

        .menu-item {
            padding: 12px 15px;
        }

        .play-btn-cafe {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }

    /* انیمیشن ورود */
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

    .fade-up {
        animation: fadeInUp 0.6s ease forwards;
    }
    </style>
</head>

<body>

    <?php
    include 'header.php';
    include '../config.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // فقط برنامه‌های کافه مه آلود
    $sql = "SELECT * FROM radio WHERE program_type = 'کافه مه آلود' ORDER BY id DESC";
    echo $sql;
    $result = $conn->query($sql);

    $programs = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $programs[] = $row;
        }
    }
    ?>

    <div class="container mt-4 mb-5">
        <!-- هدر کافه‌ای -->
        <div class="cafe-header fade-up">
            <h1>☕ کافه مه آلود</h1>
            <p class="lead">فضایی گرم و صمیمی با موسیقی ملایم، دکلمه‌های ناب و گفتگوهای دلنشین</p>
            <small>🎧 <?php echo count($programs); ?> برنامه برای لحظات آرام شما</small>
        </div>

        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="cafe-player-card fade-up" style="animation-delay: 0.1s;">
                    <div class="text-center">
                        <div class="coffee-cup-icon" id="nowPlayingIcon">
                            ☕
                        </div>
                        <h3 id="nowPlayingTitle" class="now-playing-title">هیچ برنامه‌ای انتخاب نشده</h3>
                        <span id="nowPlayingType" class="now-playing-type">برای شروع یکی از برنامه‌ها را انتخاب
                            کنید</span>

                        <div class="custom-audio-player">
                            <audio id="mainAudio" controls preload="metadata" style="width: 100%;">
                                <source src="" type="audio/mpeg">
                                مرورگر شما از پلیر صوتی پشتیبانی نمی‌کند.
                            </audio>
                        </div>
                    </div>
                </div>

                <div class="cafe-stats fade-up" style="animation-delay: 0.2s;">
                    <div class="row">
                        <div class="col-6">
                            <div class="stat-item-cafe">
                                <div class="stat-number-cafe"><?php echo count($programs); ?></div>
                                <small>برنامه در منو</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item-cafe">
                                <div class="stat-number-cafe">☕</div>
                                <small>نوش جان</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 fade-up" style="animation-delay: 0.15s;">
                <div class="menu-section">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                        <h3 class="menu-title">📋 منوی امروز</h3>
                        <div class="input-group w-50" style="min-width: 180px;">
                            <input type="text" id="searchPlaylist" class="form-control search-input-cafe"
                                placeholder="جستجو در منو...">
                            <span class="input-group-text">
                                🔍
                            </span>
                        </div>
                    </div>

                    <div id="playlistContainer">
                        <?php if (count($programs) > 0): ?>
                        <?php foreach($programs as $index => $program): ?>
                        <div class="menu-item" data-id="<?php echo $program['id']; ?>"
                            data-title="<?php echo htmlspecialchars($program['title']); ?>"
                            data-type="<?php echo htmlspecialchars($program['program_type']); ?>"
                            data-file="<?php echo htmlspecialchars($program['file_path']); ?>"
                            data-index="<?php echo $index; ?>">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <button class="play-btn-cafe" onclick="playProgram(this, <?php echo $index; ?>)">
                                        ▶️
                                    </button>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <h6 class="program-title-cafe mb-1">
                                                <?php echo htmlspecialchars($program['title']); ?>
                                            </h6>
                                            <span class="program-badge-cafe">
                                                🎙️ <?php echo htmlspecialchars($program['program_type']); ?>
                                            </span>
                                        </div>
                                        <small class="text-muted" style="direction: ltr; color: #a09080;">
                                            🎵 MP3
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="text-center py-5">
                            <div style="font-size: 60px; margin-bottom: 20px;">☕</div>
                            <h4 style="color: #f0e0c0;">هنوز برنامه‌ای به منو اضافه نشده</h4>
                            <p class="text-muted" style="color: #b8a88a;">به زودی با برنامه‌های گرم و دلنشین در خدمت شما
                                خواهیم بود</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="coffee-steam">☁️☕☁️</div>

    <?php include 'footer.php'; ?>
    <?php $conn->close(); ?>

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

        if (audio.src !== window.location.origin + '/' + filePath) {
            audio.src = filePath;
        }

        document.getElementById('nowPlayingTitle').innerHTML = title;
        document.getElementById('nowPlayingType').innerHTML = programType;
        document.getElementById('nowPlayingIcon').innerHTML = '☕🎵';

        audio.play().catch(e => console.log('Auto-play prevented'));

        if (currentPlayingButton && currentPlayingButton !== button) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
        }

        button.classList.add('playing');
        button.innerHTML = '⏸️';
        currentPlayingButton = button;
        currentPlayingIndex = index;

        document.querySelectorAll('.menu-item').forEach(item => {
            item.classList.remove('active');
        });
        button.closest('.menu-item').classList.add('active');
    }

    audio.addEventListener('ended', () => {
        if (currentPlayingButton) {
            currentPlayingButton.classList.remove('playing');
            currentPlayingButton.innerHTML = '▶️';
            currentPlayingButton.closest('.menu-item').classList.remove('active');
        }
        document.getElementById('nowPlayingIcon').innerHTML = '☕';
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

    let searchTimeout;
    document.getElementById('searchPlaylist').addEventListener('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = this.value.toLowerCase();
            const items = document.querySelectorAll('.menu-item');

            items.forEach(item => {
                const title = item.getAttribute('data-title').toLowerCase();
                const type = item.getAttribute('data-type').toLowerCase();
                item.style.display = (title.includes(searchTerm) || type.includes(searchTerm)) ?
                    '' : 'none';
            });
        }, 200);
    });

    document.addEventListener('keydown', (e) => {
        if (e.code === 'Space' && !e.target.matches('input, textarea, button')) {
            e.preventDefault();
            audio.paused ? audio.play() : audio.pause();
        }
    });

    audio.preload = 'metadata';
    </script>
</body>

</html>