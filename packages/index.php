<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پکیج‌های آموزشی سیمرغ | مرجع یادگیری حرفه‌ای</title>

    <meta name="description"
        content="ارتقاء مهارت‌های فردی با پکیج‌های آموزشی جامع موسسه سیمرغ. آموزش‌های پروژه‌محور و بازارکاری در حوزه‌های مختلف.">
    <!-- SEO Core -->
    <link rel="canonical" href="https://simorghtv.com/packages" />

    <meta name="robots" content="index, follow, max-image-preview:large" />
    <meta name="googlebot" content="index, follow, max-image-preview:large" />


    <!-- Open Graph / WhatsApp -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="پکیج‌های آموزشی سیمرغ | آموزش پروژه‌محور و بازارکار" />
    <meta property="og:description"
        content="دوره‌ها و پکیج‌های آموزشی سیمرغ؛ آموزش کاملاً عملی، پروژه‌محور و مناسب ورود به بازار کار." />
    <meta property="og:url" content="https://simorghtv.com/packages" />

    <meta property="og:image" content="https://simorghtv.com/images/30.jpg" />
    <meta property="og:image:secure_url" content="https://simorghtv.com/images/30.jpg" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />


    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="پکیج‌های آموزشی سیمرغ" />
    <meta name="twitter:description" content="مرجع یادگیری حرفه‌ای با آموزش‌های پروژه‌محور" />
    <meta name="twitter:image" content="https://simorghtv.com/images/30.jpg" />



    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/mainstyles.css">





    <style>
    :root {
        --primary-color: #007bff;
        --success-color: #28a745;
        --text-dark: #212529;
        --text-muted: #6c757d;
    }

    /* 1. استایل کلی کارت */
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        overflow: hidden;
        background: #fff;
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-12px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    /* 2. بزرگ‌تر کردن تصویر */
    .card-img-container {
        width: 100%;
        height: 270px;
        /* افزایش ارتفاع تصویر */
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* حفظ نسبت تصویر و پر کردن کامل قاب */
        transition: transform 0.5s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.08);
        /* افکت زوم روی تصویر هنگام هاور */
    }

    /* 3. تنظیم دقیق دو خط توضیحات */
    .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-title {
        font-weight: 800 !important;
        color: var(--text-dark);
        font-size: 1.2rem;
        margin-bottom: 15px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .card-description {
        font-weight: 500;
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;

        /* تنظیم دقیق برای نمایش 2 خط */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* محدودیت به 2 خط */
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 3.2em;
        /* (line-height 1.6 * 2 lines) */
    }

    .package-info {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .price-tag {
        color: var(--success-color);
        font-weight: 800;
        font-size: 1.1rem;
    }

    /* دکمه‌ها */
    .btn-add-cart {
        font-weight: 700;
        border-radius: 12px;
        padding: 12px;
        background-color: var(--success-color);
        border: none;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
    }

    .btn-details {
        border-radius: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    .intro-section {
        background: #ffffff;
        border-radius: 30px;
        padding: 20px;
        margin-bottom: 50px;
        border: 8px solid var(--primary-color);
        /* border-left: 8px solid var(--primary-color); */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }
    </style>




</head>

<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    
    $limit = 9;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $start = ($page - 1) * $limit;

    $count_result = $conn->query("SELECT COUNT(id) AS total FROM `packages`");
    $total_packages = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_packages / $limit);
    ?>

    <main class="container mt-5">
        <section class="intro-section">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="h2 mb-3 fw-bolder">پکیج‌های آموزشی سیمرغ</h1>
                    <p class="lead text-muted" style="font-weight: 500;">
                        دسترسی به بهترین پکیج‌های آموزشی بصورت پروژه‌محور و کاملاً کاربردی. مهارت خود را همین امروز
                        ارتقاء دهید.
                    </p>
                    <p>
                        جهت استفاده بهتر ویدیوی روبرو را مشاهده کنید و در صورت بروز هرگونه مشکلی از نشان پیام پایین صفحه
                        به پشتیبان های ما پیام دهید
                    </p>
                </div>
                <div class="col-md-6">



                    <video controls class="w-100 rounded shadow-sm">
                        <source src="../uploads/packages/12/file_695d261d07bf1.m4v" type="video/mp4">
                        مرورگر شما از تگ ویدئو پشتیبانی نمی‌کند.
                    </video>


                </div>

            </div>
        </section>
        <br>

        <div class="row">
            <?php
            $sql = "SELECT * FROM `packages` ORDER BY `id` DESC LIMIT $start, $limit"; 
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($package = $result->fetch_assoc()) {
                    // تمیز کردن متن برای نمایش صاف و بدون کاراکترهای مخفی
                    $cleaned_description = strip_tags($package['description']);
                    $cleaned_description = str_replace(array("\r", "\n"), ' ', $cleaned_description);
                    $cleaned_description = preg_replace('/\s+/', ' ', $cleaned_description);
            ?>
            <article class="col-lg-4 col-md-6 mb-5">
                <div class="card h-100">
                    <div class="card-img-container">
                        <img class="card-img-top" src="../<?php echo htmlspecialchars($package['pictures']); ?>"
                            alt="<?php echo htmlspecialchars($package['name']); ?>" loading="lazy">
                    </div>
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($package['name']); ?></h2>

                        <p class="card-description"><?php echo trim($cleaned_description); ?></p>

                        <div class="package-info">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">مدرس دوره:</span>
                                <span class="fw-bold"><?php echo htmlspecialchars($package['teacher']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    مبلغ دوره :</span>

                                <span class="price-tag">
                                    <?php echo number_format($package['price'] / 10); ?> تومان
                                </span>

                            </div>
                        </div>

                        <div class="mt-auto">
                            <form action="cart_handler.php" method="POST">
                                <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                                <button type="submit" class="btn btn-add-cart btn-block w-100 text-white">
                                    🛒 افزودن به سبد خرید
                                </button>
                            </form>
                            <a href="package.php?id=<?php echo $package['id']; ?>"
                                class="btn btn-outline-primary btn-details btn-block w-100">
                                مشاهده سرفصل‌ها
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            <?php
                }
            }
            ?>
        </div>

    </main>


    <script type="text/javascript">
    ! function() {
        var i = "4Ey6dG",
            a = window,
            d = document;

        function g() {
            var g = d.createElement("script"),
                s = "https://www.goftino.com/widget/" + i,
                l = localStorage.getItem("goftino_" + i);
            g.async = !0, g.src = l ? s + "?o=" + l : s;
            d.getElementsByTagName("head")[0].appendChild(g);
        }
        "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load",
            g, !1);
    }();
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>