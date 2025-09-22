<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویدیو محافظت شده با واترمارک پررنگ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
        }

        body {
            font-family: 'Vazir', 'Tanha', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
            color: #333;
            line-height: 1.6;
        }

        .video-container {
            position: relative;
            background-color: #000;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            overflow: hidden;
        }

        .protection-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 100;
        }

        /* استایل واترمارک با تغییرات جدید */
        .watermark {
            position: absolute;
            font-size: 1.2em;
            color: rgba(255, 255, 255, 0.7);
            /* رنگ سفید با شفافیت 70% (بیشتر شده) */
            text-shadow: 1px 1px 2px #000;
            /* اضافه شدن سایه متن برای وضوح بیشتر */
            z-index: 10;
            pointer-events: none;
            white-space: nowrap;
            animation: fadeInOut 5s infinite alternate;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0.5;
            }

            /* حداقل شفافیت بیشتر شده */
            50% {
                opacity: 0.7;
            }

            /* حداکثر شفافیت بیشتر شده */
            100% {
                opacity: 0.5;
            }

            /* حداقل شفافیت بیشتر شده */
        }
    </style>
</head>

<body>
    <div class="video-container">
        <div class="protection-badge">
            <span class="badge bg-danger">حفاظت شده</span>
        </div>

        <div class="watermark" id="dynamicWatermark">این ویدیو به [نام کاربر] تعلق دارد</div>

        <video id="myVideo" controls style="width: 100%;" controlsList="nodownload" oncontextmenu="return false;">
            <source src="motion1.mp4" type="video/mp4">
            مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
        </video>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // کدهای JavaScript برای جلوگیری از دانلود (قبلی)
        document.addEventListener('DOMContentLoaded', function() {
            // جلوگیری از کلیک راست
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                alert('امکان ذخیره ویدیو وجود ندارد.');
            });

            // جلوگیری از کشیدن و رها کردن
            document.addEventListener('dragstart', function(e) {
                if (e.target.tagName === 'VIDEO') {
                    e.preventDefault();
                }
            });

            // جلوگیری از کلیدهای ذخیره
            document.addEventListener('keydown', function(e) {
                // Ctrl+S, Ctrl+U, F12
                if ((e.ctrlKey && e.key === 's') || (e.ctrlKey && e.key === 'u') || e.key === 'F12') {
                    e.preventDefault();
                    alert('این عمل مجاز نیست.');
                }
            });

            // --- کدهای جدید برای واترمارک پویا ---
            const videoContainer = document.querySelector('.video-container');
            const watermark = document.getElementById('dynamicWatermark');
            const video = document.getElementById('myVideo');

            const userName = "نام دانشجو/کاربر"; // این را باید به صورت پویا از سیستم خود دریافت کنید
            watermark.textContent = `این ویدیو به ${userName} تعلق دارد`;

            function moveWatermark() {
                const containerWidth = videoContainer.offsetWidth;
                const containerHeight = videoContainer.offsetHeight;
                const watermarkWidth = watermark.offsetWidth;
                const watermarkHeight = watermark.offsetHeight;
                const randomX = Math.floor(Math.random() * (containerWidth - watermarkWidth - 40)) + 20;
                const randomY = Math.floor(Math.random() * (containerHeight - watermarkHeight - 40)) + 20;
                watermark.style.left = `${randomX}px`;
                watermark.style.top = `${randomY}px`;
            }

            moveWatermark();
            setInterval(moveWatermark, 7000);
            window.addEventListener('resize', moveWatermark);
            video.addEventListener('loadedmetadata', moveWatermark);
        });
    </script>
</body>

</html>