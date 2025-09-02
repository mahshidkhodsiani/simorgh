<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نمایش ویدیوی حفاظت شده</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
        }

        body {
            font-family: 'Vazir', 'Tanha', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ec 100%);
            margin: 0;
            padding: 20px;
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 900px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .video-container {
            position: relative;
            padding: 20px;
            background: #000;
        }

        video {
            width: 100%;
            height: auto;
            max-height: 500px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .protection-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.3s;
            border-radius: 10px;
        }

        .video-container:hover .protection-overlay {
            opacity: 1;
        }

        .protection-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 100;
        }

        .controls {
            padding: 15px 20px;
            background: #f8f9fc;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            border: none;
        }

        .security-features {
            padding: 20px;
            background: white;
            border-top: 1px solid #e3e6f0;
        }

        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fc;
            border-radius: 10px;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-left: 15px;
            flex-shrink: 0;
        }

        .message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .watermark {
            position: absolute;
            bottom: 30px;
            right: 30px;
            color: rgba(255, 255, 255, 0.3);
            font-size: 18px;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                border-radius: 15px;
            }

            .controls {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2><i class="bi bi-shield-lock"></i> ویدیوی حفاظت شده</h2>
            <p class="mb-0">امکان دانلود این ویدیو غیرفعال شده است</p>
        </div>

        <div class="video-container">
            <div class="protection-badge">
                <span class="badge bg-danger"><i class="bi bi-shield-check"></i> حفاظت شده</span>
            </div>

            <video id="myVideo" controls controlsList="nodownload" oncontextmenu="return false;">
                <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
                مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
            </video>

            <div class="protection-overlay">
                <div class="text-center">
                    <i class="bi bi-shield-lock" style="font-size: 48px;"></i>
                    <p>این ویدیو در برابر دانلود محافظت شده است</p>
                </div>
            </div>

            <div class="watermark" id="watermark">کاربر: مهمان - تاریخ: 1402/08/15</div>
        </div>

        <div class="controls">
            <button class="btn btn-primary" onclick="playVideo()">
                <i class="bi bi-play-fill"></i> پخش
            </button>
            <button class="btn btn-primary" onclick="pauseVideo()">
                <i class="bi bi-pause-fill"></i> توقف
            </button>
            <button class="btn btn-primary" onclick="toggleMute()">
                <i class="bi bi-volume-mute-fill"></i> قطع صدا
            </button>
            <button class="btn btn-primary" onclick="toggleFullscreen()">
                <i class="bi bi-arrows-fullscreen"></i> تمام صفحه
            </button>
        </div>

     
    </div>

    <div class="message" id="message"></div>

    <script>
        const video = document.getElementById('myVideo');
        const message = document.getElementById('message');

        // نمایش پیام به کاربر
        function showMessage(text) {
            message.textContent = text;
            message.style.opacity = '1';

            setTimeout(() => {
                message.style.opacity = '0';
            }, 2000);
        }

        // کنترل‌های ویدیو
        function playVideo() {
            video.play();
            showMessage('ویدیو در حال پخش است');
        }

        function pauseVideo() {
            video.pause();
            showMessage('ویدیو متوقف شد');
        }

        function toggleMute() {
            video.muted = !video.muted;
            showMessage(video.muted ? 'صدا قطع شد' : 'صدا روشن شد');
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                video.requestFullscreen().catch(err => {
                    console.error('خطا در حالت تمام صفحه:', err);
                });
            } else {
                document.exitFullscreen();
            }
        }

        // جلوگیری از دانلود
        document.addEventListener('DOMContentLoaded', function() {
            // جلوگیری از کلیک راست
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                showMessage('امکان ذخیره ویدیو وجود ندارد');
            });

            // جلوگیری از کشیدن و رها کردن ویدیو
            document.addEventListener('dragstart', function(e) {
                if (e.target.tagName === 'VIDEO') {
                    e.preventDefault();
                    showMessage('امکان ذخیره ویدیو وجود ندارد');
                }
            });

            // جلوگیری از کلیدهای ذخیره
            document.addEventListener('keydown', function(e) {
                // Ctrl+S, Ctrl+U, F12
                if ((e.ctrlKey && e.key === 's') || (e.ctrlKey && e.key === 'u') || e.key === 'F12') {
                    e.preventDefault();
                    showMessage('این عمل مجاز نیست');
                }
            });

            // اضافه کردن واترمارک پویا
            updateWatermark();
            setInterval(updateWatermark, 60000); // بروزرسانی واترمارک هر 1 دقیقه
        });

        // تابع بروزرسانی واترمارک
        function updateWatermark() {
            const now = new Date();
            const dateString = now.toLocaleDateString('fa-IR');
            const timeString = now.toLocaleTimeString('fa-IR');
            document.getElementById('watermark').textContent = `کاربر: مهمان - تاریخ: ${dateString} - زمان: ${timeString}`;
        }
    </script>
</body>

</html>