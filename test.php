<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جلوگیری از دانلود ویدیو - راهکارهای امنیتی</title>
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

        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            border-radius: 0 0 20px 20px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            border: none;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 700;
        }

        .solution-card {
            border-left: 5px solid var(--primary-color);
        }

        .prevention-item {
            padding: 15px;
            border-radius: 10px;
            background-color: #f8f9fc;
            margin-bottom: 15px;
            border: 1px solid #e3e6f0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .badge {
            font-size: 0.9em;
            padding: 8px 15px;
            border-radius: 10px;
        }

        .implementation-steps {
            counter-reset: step-counter;
        }

        .step {
            padding: 20px;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .step:before {
            counter-increment: step-counter;
            content: counter(step-counter);
            position: absolute;
            right: -10px;
            top: -10px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .video-demo {
            background-color: #000;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .protection-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 100;
        }

        .code-block {
            background-color: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="container">
            <h1 class="text-center"><i class="bi bi-shield-lock"></i> راهکارهای جلوگیری از دانلود ویدیو</h1>
            <p class="text-center lead">امنیت محتوای ویدیویی در سایت‌های PHP و Bootstrap</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-lightbulb"></i> راهکارهای فنی جلوگیری از دانلود</h3>
                    </div>
                    <div class="card-body">
                        <div class="implementation-steps">
                            <div class="step">
                                <h4>استفاده از سرویس‌های میزبان ویدیو</h4>
                                <p>سرویس‌هایی مانند Vimeo Pro یا Wistia امکان غیرفعال کردن دانلود را فراهم می‌کنند.</p>
                                <span class="badge bg-primary">موثر</span>
                                <span class="badge bg-success">پیشنهادی</span>
                            </div>

                            <div class="step">
                                <h4>تقسیم ویدیو به تکه‌های کوچک (HLS)</h4>
                                <p>استفاده از فناوری HLS که ویدیو را به تکه‌های کوچک تقسیم می‌کند و دانلود آن را سخت می‌کند.</p>
                                <div class="code-block">
                                    // مثال با PHP<br>
                                    $video_path = 'videos/secret_video.mp4';<br>
                                    $video_url = 'videos/secret_video.m3u8'; // فایل HLS
                                </div>
                                <span class="badge bg-warning">متوسط</span>
                            </div>

                            <div class="step">
                                <h4>غیرفعال کردن کلیک راست و کلیدهای ترکیبی</h4>
                                <p>جلوگیری از دسترسی به منوی context برای ذخیره ویدیو</p>
                                <div class="code-block">
                                    document.addEventListener('contextmenu', function(e) {<br>
                                    &nbsp;&nbsp;e.preventDefault();<br>
                                    &nbsp;&nbsp;alert('امکان ذخیره ویدیو وجود ندارد.');<br>
                                    });
                                </div>
                                <span class="badge bg-primary">آسان</span>
                            </div>

                            <div class="step">
                                <h4>رمزگذاری ویدیوها</h4>
                                <p>استفاده از رمزگذاری DRM برای ویدیوها که فقط در پلیر خاصی قابل پخش هستند.</p>
                                <span class="badge bg-danger">پیشرفته</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-code-slash"></i> پیاده‌سازی در PHP</h3>
                    </div>
                    <div class="card-body">
                        <p>نمونه کد PHP برای سرویس دادن ویدیو به صورت امن:</p>
                        <div class="code-block">
                            &lt;?php<br>
                            // بررسی آیا کاربر لاگین کرده است<br>
                            session_start();<br>
                            if (!isset($_SESSION['user_id'])) {<br>
                            &nbsp;&nbsp;header('HTTP/1.0 403 Forbidden');<br>
                            &nbsp;&nbsp;die('دسترسی غیرمجاز');<br>
                            }<br>
                            <br>
                            // بررسی ارجاع (Referer) برای اطمینان از嵌入 ویدیو در سایت خودتان<br>
                            if (isset($_SERVER['HTTP_REFERER'])) {<br>
                            &nbsp;&nbsp;$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);<br>
                            &nbsp;&nbsp;if ($referer != 'yourdomain.com') {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;header('HTTP/1.0 403 Forbidden');<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;die('دسترسی غیرمجاز');<br>
                            &nbsp;&nbsp;}<br>
                            }<br>
                            <br>
                            // ارسال ویدیو<br>
                            $file = 'protected/videos/'.$_GET['vid'];<br>
                            if (file_exists($file)) {<br>
                            &nbsp;&nbsp;header('Content-Type: video/mp4');<br>
                            &nbsp;&nbsp;header('Content-Disposition: inline; filename="video.mp4"');<br>
                            &nbsp;&nbsp;readfile($file);<br>
                            } else {<br>
                            &nbsp;&nbsp;header('HTTP/1.0 404 Not Found');<br>
                            }<br>
                            ?&gt;
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-shield-check"></i> راهکارهای امنیتی</h3>
                    </div>
                    <div class="card-body">
                        <div class="prevention-item">
                            <h5><i class="bi bi-check-circle"></i> احراز هویت کاربران</h5>
                            <p>اجباری کردن ثبت‌نام و لاگین برای دسترسی به ویدیوها</p>
                        </div>

                        <div class="prevention-item">
                            <h5><i class="bi bi-check-circle"></i> محدودیت دسترسی بر اساس IP</h5>
                            <p>اجازه دسترسی فقط از IPهای خاص یا محدود کردن تعداد دستگاه‌های همزمان</p>
                        </div>

                        <div class="prevention-item">
                            <h5><i class="bi bi-check-circle"></i> منقضی شدن لینک‌ها</h5>
                            <p>تولید لینک‌های موقت که پس از مدت زمان مشخص منقضی می‌شوند</p>
                        </div>

                        <div class="prevention-item">
                            <h5><i class="bi bi-check-circle"></i> واترمارک گذاری ویدیو</h5>
                            <p>اضافه کردن واترمارک حاوی نام کاربر یا اطلاعات session به ویدیو</p>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-card-checklist"></i> مراحل پیاده‌سازی</h3>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>تنظیم سیستم احراز هویت کاربران در PHP</li>
                            <li>آپلود ویدیوها در پوشه‌ای خارج از root</li>
                            <li>ایجاد اسکریپت PHP برای سرویس دادن ویدیوها</li>
                            <li>پیاده‌سازی کنترل‌های امنیتی در front-end</li>
                            <li>تست سیستم و رفع اشکالات</li>
                        </ol>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary"><i class="bi bi-download"></i> دریافت کدهای نمونه</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-collection-play"></i> دموی ویدیوی امن</h3>
                    </div>
                    <div class="card-body">
                        <div class="video-demo">
                            <div class="protection-badge">
                                <span class="badge bg-danger">حفاظت شده</span>
                            </div>
                            <video controls style="width: 100%" controlsList="nodownload" oncontextmenu="return false;">
                                <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
                                مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
                            </video>
                        </div>
                        <p class="text-muted small mt-2">این ویدیو با قابلیت‌های حفاظتی نمونه نمایش داده می‌شود.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-question-circle"></i> سوالات متداول</h3>
            </div>
            <div class="card-body">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                آیا این راهکارها ۱۰۰٪ از دانلود جلوگیری می‌کنند؟
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                هیچ راهکار ۱۰۰٪ قطعی وجود ندارد، اما با ترکیب چندین روش می‌توانید دانلود را برای اکثر کاربران غیرفنی بسیار سخت کنید. کاربران بسیار ماهر ممکن است راهی برای دور زدن این محدودیت‌ها پیدا کنند.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                کدام روش برای سایت من مناسب‌تر است؟
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                اگر بودجه کافی دارید، استفاده از سرویس‌های میزبان ویدیو مانند Vimeo Pro بهترین گزینه است. در غیر این صورت، ترکیبی از روش‌های فنی و امنیتی در PHP می‌تواند راهکار مناسبی باشد.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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