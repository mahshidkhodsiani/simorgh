<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویدیو محافظت شده</title>
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
        }

        .protection-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 100;
        }
    </style>
</head>

<body>
    <div class="video-container">
        <div class="protection-badge">
            <span class="badge bg-danger">حفاظت شده</span>
        </div>
        <video id="myVideo" controls style="width: 100%;" controlsList="nodownload" oncontextmenu="return false;">
            <source src="motion1.mp4" type="video/mp4">
            مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
        </video>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // کدهای JavaScript برای جلوگیری از دانلود
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
        });
    </script>
</body>

</html>