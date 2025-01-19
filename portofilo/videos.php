<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گالری ویدیوها</title>
    <?php include "includes.php"; ?>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <style>
        .video-container {
            display: flex;
            flex-wrap: nowrap;
        }
        .video-titles {
            flex: 1;
            border-left: 1px solid #ddd;
            padding: 10px;
            overflow-y: auto;
            max-height: 80vh; /* حداکثر ارتفاع برای اسکرول */
        }
        .video-display {
            flex: 2;
            padding: 10px;
            text-align: center;
        }
        .video-title {
            cursor: pointer;
            margin: 5px 0;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s, color 0.3s;
        }
        .video-title:hover {
            background-color: #f0f0f0;
        }
        .active-title {
            background-color: #f8d7da; /* پس‌زمینه قرمز کمرنگ */
            color: red; /* رنگ متن قرمز */
        }
        video {
            width: 100%;
            max-height: 70vh;
        }
    </style>
</head>
<body>
    <?php
    include 'header.php';
    include '../config.php';

    // گرفتن ویدیوها از دیتابیس
    $sql = "SELECT * FROM videos ORDER BY id DESC";
    $result = $conn->query($sql);
    ?>

    <div class="container mt-5">
        <div class="video-container">
            <!-- ستون نمایش ویدیو -->
            <div class="video-display">
                <video id="mainVideo" controls muted>
                    <source src="" type="video/mp4">
                    مرورگر شما از ویدیو پشتیبانی نمی‌کند.
                </video>
                <h4 id="videoTitle">عنوان ویدیو</h4>
            </div>
            <!-- ستون عنوان‌ها -->
            <div class="video-titles">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="video-title" data-video="<?= htmlspecialchars($row['path']) ?>">
                            <?= htmlspecialchars($row['title']) ?>
                        </div>
                    <?php }
                } else {
                    echo "<p class='text-center'>ویدیویی ثبت نشده است</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // انتخاب عناصر
        const titles = document.querySelectorAll('.video-title');
        const mainVideo = document.getElementById('mainVideo');
        const videoTitle = document.getElementById('videoTitle');

        // افزودن رویداد کلیک به هر عنوان
        titles.forEach(title => {
            title.addEventListener('click', function () {
                // حذف کلاس فعال از تمام عناوین
                titles.forEach(t => t.classList.remove('active-title'));

                // افزودن کلاس فعال به عنوان کلیک‌شده
                this.classList.add('active-title');

                // تنظیم ویدیو و عنوان
                mainVideo.src = this.getAttribute('data-video');
                videoTitle.textContent = this.textContent;

                // پخش ویدیو
                mainVideo.play();
            });
        });

        // نمایش ویدیو پیش‌فرض (اولین ویدیو)
        if (titles.length > 0) {
            titles[0].click();
        }
    </script>
</body>
</html>
