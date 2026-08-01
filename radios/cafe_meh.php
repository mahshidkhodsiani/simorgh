<?php
session_start();
include '../config.php';

// ========== بررسی گوینده ==========
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

// ========== بررسی پرداخت موفق ==========
$payment_message = '';
if(isset($_GET['payment']) && $_GET['payment'] == 'success') {
    $payment_message = '<div class="alert alert-success text-center">✅ پرداخت شما با موفقیت انجام شد! از شنیدن برنامه‌ها لذت ببرید. ☕</div>';
}

// ========== دریافت قیمت کافه ==========
$cafe_id = 2;
$radio_query = "SELECT * FROM radios WHERE id = $cafe_id";
$radio_result = $conn->query($radio_query);
$radio_info = $radio_result->fetch_assoc();
$cafe_price = $radio_info['price'] ?? 35000;

// ========== بررسی دسترسی کاربر ==========
$has_full_cafe_access = false;

if($is_speaker) {
    $has_full_cafe_access = true; 
} 
elseif(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    $check_full_sql = "SELECT * FROM user_radio WHERE user_id = ? AND radio_type = 'cafe' AND paid = 1 AND program_id IS NULL LIMIT 1";
    $check_stmt = $conn->prepare($check_full_sql);
    $check_stmt->bind_param("i", $user_id);
    $check_stmt->execute();
    if($check_stmt->get_result()->num_rows > 0) {
        $has_full_cafe_access = true;
    }
    $check_stmt->close();
}

// ========== دریافت برنامه‌ها ==========
$programs = [];
$sql = "SELECT * FROM radio WHERE program_type = 'کافه مه آلود' ORDER BY id DESC";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $programs[] = $row;
    }
}

// ذخیره آدرس فعلی برای بازگشت بعد از لاگین
$current_url = $_SERVER['REQUEST_URI'];
?>

<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کافه مه آلود | فضایی گرم با موسیقی و گفتگوهای دلنشین</title>
    <?php include "includes.php"; ?>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <style>
    :root {
        --cafe-brown: #6F4E37;
        --cafe-cream: #F5E6D3;
        --cafe-dark: #2C1810;
        --cafe-warm: #D4A373;
    }

    body {
        background: linear-gradient(135deg, #2c1810 0%, #3e2723 60%, #4a3028 100%);
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
        background-image: radial-gradient(circle at 30% 40%, rgba(210, 180, 140, 0.06) 0%, transparent 60%), radial-gradient(circle at 70% 80%, rgba(160, 120, 80, 0.05) 0%, transparent 60%), repeating-linear-gradient(45deg, rgba(139, 69, 19, 0.03) 0px, rgba(139, 69, 19, 0.03) 1px, transparent 1px, transparent 10px);
        pointer-events: none;
        z-index: 0;
    }

    .container {
        position: relative;
        z-index: 1;
    }

    .cafe-header {
        background: linear-gradient(135deg, #1a0f0a 0%, #2c1810 50%, #1a0f0a 100%);
        border-radius: 40px;
        padding: 60px 30px;
        margin-bottom: 40px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(212, 163, 115, 0.3);
        position: relative;
        overflow: hidden;
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

    .cafe-header h1 {
        font-size: 3rem;
        font-weight: bold;
        color: #f0e0c0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .cafe-header .lead {
        color: #d4c4a8;
    }

    .cafe-player-card {
        background: rgba(30, 20, 15, 0.7);
        backdrop-filter: blur(12px);
        border-radius: 30px;
        padding: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(212, 163, 115, 0.3);
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
        border-bottom: 3px solid #D4A373;
        display: inline-block;
        padding-bottom: 10px;
    }

    .menu-item {
        background: rgba(45, 35, 30, 0.8);
        backdrop-filter: blur(5px);
        border-radius: 20px;
        margin-bottom: 15px;
        padding: 15px 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(212, 163, 115, 0.2);
        position: relative;
    }

    .menu-item:hover {
        transform: translateX(-5px);
        border-color: rgba(212, 163, 115, 0.5);
        background: rgba(55, 45, 40, 0.9);
    }

    .play-btn-cafe {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(80, 60, 50, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(212, 163, 115, 0.5);
        font-size: 1.2rem;
        color: #D4A373;
        cursor: pointer;
        transition: all 0.3s;
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
    }

    .program-badge-cafe {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11px;
        background: rgba(212, 163, 115, 0.2);
        color: #D4A373;
    }

    .cafe-buy-btn {
        background: linear-gradient(135deg, #D4A373, #b8956a);
        color: #2c1810 !important;
        font-weight: bold !important;
        border: none !important;
        border-radius: 50px !important;
        padding: 10px 25px;
        transition: all 0.3s ease;
    }

    .cafe-buy-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(212, 163, 115, 0.4);
    }

    .cafe-stats {
        background: rgba(30, 20, 15, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 20px;
        margin-top: 25px;
        border: 1px solid rgba(212, 163, 115, 0.25);
    }

    .stat-number-cafe {
        font-size: 1.8rem;
        font-weight: bold;
        color: #D4A373;
    }

    .search-input-cafe {
        border-radius: 50px;
        border: 1px solid rgba(212, 163, 115, 0.5);
        padding: 10px 20px;
        background: rgba(45, 35, 30, 0.8);
        color: #f0e0c0;
    }

    .search-input-cafe:focus {
        box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.2);
        border-color: #D4A373;
        background: rgba(55, 45, 40, 0.9);
        color: #f0e0c0;
    }

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
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-4 mb-5">
        <?php 
if(isset($_GET['payment']) && $_GET['payment'] == 'already') {
    echo '<div class="alert alert-info text-center">ℹ️ شما قبلاً اشتراک کامل کافه مه‌آلود را خریداری کرده‌اید.</div>';
}
if(isset($_GET['payment']) && $_GET['payment'] == 'success') {
    echo '<div class="alert alert-success text-center">✅ پرداخت شما با موفقیت انجام شد! از شنیدن برنامه‌ها لذت ببرید. ☕</div>';
}
if(isset($_GET['payment']) && $_GET['payment'] == 'failed') {
    echo '<div class="alert alert-danger text-center">❌ پرداخت با شکست مواجه شد. لطفاً مجدداً تلاش کنید.</div>';
}
?>
        <?php if($is_speaker): ?>
        <div class="alert alert-success text-center mb-3"
            style="background: linear-gradient(135deg, #D4A373, #b8956a); color: #2c1810; border: none;">🌟🌟 به پنل
            گویندگی خوش آمدید! دسترسی رایگان و کامل به تمام برنامه‌ها. 🌟🌟</div>
        <?php endif; ?>
        <div class="cafe-header fade-up">
            <h1>☕ کافه مه آلود</h1>
            <p class="lead">داستان یک کافه قدیمی در نزدیکی ایستگاه قطار متروکه، با باریستای مرموز که فقط نیمه شبها باز
                میشه.</p>
            <small>🎧 <?php echo count($programs); ?> برنامه برای لحظات آرام شما</small>
        </div>
        <div class="row">
            <div class="col-lg-5 mb-4">
                <div class="cafe-player-card fade-up" style="animation-delay: 0.1s;">
                    <div class="text-center">
                        <div class="coffee-cup-icon" id="nowPlayingIcon">☕</div>
                        <h3 id="nowPlayingTitle" class="now-playing-title">هیچ برنامه‌ای انتخاب نشده</h3>
                        <span id="nowPlayingType" class="now-playing-type">برای شروع یکی از برنامه‌ها را انتخاب
                            کنید</span>
                        <div class="custom-audio-player">
                            <audio id="mainAudio" controls preload="metadata" style="width: 100%;">
                                <source src="" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>
                </div>
                <div class="cafe-stats fade-up" style="animation-delay: 0.2s;">
                    <div class="row">
                        <div class="col-6">
                            <div class="stat-item-cafe">
                                <div class="stat-number-cafe"><?php echo count($programs); ?></div><small>برنامه در
                                    منو</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item-cafe">
                                <div class="stat-number-cafe"><?php echo $is_speaker ? '🎙️' : '💰'; ?></div>
                                <small><?php echo $is_speaker ? 'دسترسی ویژه' : 'اشتراک کامل'; ?></small>
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
                            <span class="input-group-text">🔍</span>
                        </div>
                    </div>
                    <?php if(!isset($_SESSION['user_id'])): ?>
                    <div class="text-center mb-4">
                        <div class="alert alert-warning">برای دسترسی به برنامه‌ها، لطفاً <a
                                href="../login.php?redirect=<?php echo urlencode($current_url); ?>">وارد شوید</a></div>
                        <button class="btn btn-info btn-lg"
                            onclick="location.href='../login.php?redirect=<?php echo urlencode($current_url); ?>'">🔐
                            ورود یا ثبت‌نام</button>
                    </div>
                    <?php else: ?>
                    <div class="alert text-center mb-4"
                        style="background: rgba(212, 163, 115, 0.15); border: 1px solid #D4A373; color: #f0e0c0; border-radius: 20px;">
                        <?php if($is_speaker): ?>
                        <span style="color: #D4A373; font-weight: bold; font-size: 1.1rem;">🎙️ دسترسی ویژه گوینده به
                            تمام برنامه‌ها فعال است!</span>
                        <?php elseif($has_full_cafe_access): ?>
                        <span style="color: #D4A373; font-weight: bold; font-size: 1.1rem;">✅ دسترسی کامل به تمام
                            برنامه‌های کافه مه‌آلود برای شما فعال است! ☕</span>
                        <?php else: ?>
                        <strong>☕ دسترسی به همه اپیزودها یک‌جا</strong><br>
                        <small>با خرید اشتراک کامل، تمام برنامه‌های کافه برای شما باز می‌شود.</small><br>

                        <a href="buy_cafe.php" class="btn cafe-buy-btn mt-2">💰 خرید اشتراک کامل
                            (<?php echo number_format($cafe_price); ?> تومان)</a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
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
                                    <?php if(isset($_SESSION['user_id']) && ($is_speaker || $has_full_cafe_access)): ?>
                                    <button class="play-btn-cafe"
                                        onclick="playProgram(this, <?php echo $index; ?>)">▶️</button>
                                    <?php else: ?>
                                    <button class="play-btn-cafe" style="background: #555; cursor: not-allowed;"
                                        title="برای شنیدن این برنامه، اشتراک کامل کافه را بخرید.">🔒</button>
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                        <div>
                                            <h6 class="program-title-cafe mb-1">
                                                <?php echo htmlspecialchars($program['title']); ?></h6>
                                            <span class="program-badge-cafe">🎙️
                                                <?php echo htmlspecialchars($program['program_type']); ?></span>
                                        </div>
                                        <small class="text-muted" style="direction: ltr; color: #a09080;">🎵 MP3</small>
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
    <?php include 'footer.php'; $conn->close(); ?>
    <script>
    const audio = document.getElementById('mainAudio');
    let currentPlayingButton = null;
    let programs = <?php echo json_encode($programs); ?>;

    function playProgram(button, index) {
        const program = programs[index];
        if (!program) return;
        if (audio.src !== window.location.origin + '/' + program.file_path) {
            audio.src = program.file_path;
        }
        document.getElementById('nowPlayingTitle').innerHTML = program.title;
        document.getElementById('nowPlayingType').innerHTML = program.program_type;
        document.getElementById('nowPlayingIcon').innerHTML = '☕🎵';
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