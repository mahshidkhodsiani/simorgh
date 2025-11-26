<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جزئیات پکیج</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <?php
    // اگر id معتبر ارسال شده باشد، برای تولید متاها از دیتابیس استفاده می‌کنیم
    $meta_description = "جزئیات پکیج آموزشی";
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        include_once '../config.php';
        $tmp_id = (int)$_GET['id'];
        if (isset($conn) && $conn instanceof mysqli) {
            $q = $conn->prepare("SELECT `name`, `description`, `pictures` FROM `packages` WHERE `id` = ?");
            if ($q) {
                $q->bind_param("i", $tmp_id);
                $q->execute();
                $r = $q->get_result();
                if ($r && $r->num_rows) {
                    $p_tmp = $r->fetch_assoc();
                    $meta_description = mb_substr(strip_tags($p_tmp['description'] ?: $p_tmp['name']), 0, 160);
                    // عنوان صفحه را در تگ title هم قرار می‌دهیم
                    echo '<script>document.title = "جزئیات پکیج: ' . htmlspecialchars($p_tmp['name'], ENT_QUOTES, 'UTF-8') . '";</script>';
                }
                $q->close();
            }
            $conn->close();
        }
    }
    ?>

    <meta name="description" content="<?php echo htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="robots" content="index, follow">

    <style>
        /* استایل سفارشی برای نمایش بهتر جزئیات */
        .detail-item strong {
            display: inline-block;
            min-width: 150px;
            /* برای هم‌راستایی بهتر عناوین */
        }

        .file-link {
            color: #007bff;
            text-decoration: none;
        }

        .file-link:hover {
            text-decoration: underline;
        }

        /* استایل‌های بلوک تبلیغی شبیه تصویر */
        .promo-card {
            background: linear-gradient(135deg, #f7c6e0 0%, #f0a6d1 100%);
            border-radius: 12px;
            padding: 22px;
            color: #222;
        }

        .promo-avatar {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.18);
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: 700;
            color: #fff;
            margin: 6px;
            display: inline-block;
        }

        .register-btn {
            background: #ff5c9e;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 800;
            text-decoration: none;
        }

        .course-card {
            background: #fff;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        @media (max-width: 767px) {
            .promo-avatar {
                width: 140px;
                height: 140px;
            }

            .promo-card {
                padding: 14px;
            }
        }
    </style>
</head>

<body>

    <?php
    include 'header.php';
    include '../config.php';

    // --- منطق بازیابی اطلاعات ---
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $package_id = (int)$_GET['id'];

        // کوئری برای دریافت تمام ستون‌های پکیج
        $sql = "SELECT id, name, pictures, description, teacher, address, course, price, spotplayer, file1, file2, file3 FROM `packages` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "<div class='container mt-5'><div class='alert alert-danger text-center'>خطا در آماده‌سازی کوئری.</div></div>";
            include 'footer.php';
            exit;
        }
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $package = $result->fetch_assoc();
            // عنوان صفحه را به‌روز می‌کنیم (برای مرورگرهایی که JS ندارند، تگ title در head هم تنظیم شده بود)
            echo "<script>document.title = 'جزئیات پکیج: " . htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') . "';</script>";
            // مسیر تصویر را امن‌سازی می‌کنیم
            $picture = !empty($package['pictures']) ? ('../' . ltrim($package['pictures'], '/')) : '../images/default-course.jpg';
            $price_text = !empty($package['price']) ? htmlspecialchars($package['price'], ENT_QUOTES, 'UTF-8') . ' تومان' : 'رایگان';
    ?>




                <section class="promo-card">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center mb-4 mb-md-0">
                            <img class="promo-avatar rounded-circle shadow-lg" 
                                src="<?php echo htmlspecialchars($picture, ENT_QUOTES, 'UTF-8'); ?>" 
                                alt="تصویر پکیج <?php echo htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                loading="lazy" 
                                width="300" 
                                height="300">
                            
                            <div class="mt-4">
                                <div class="feature-item">۱ سال پشتیبانی</div>
                                
                                <div class="feature-item">تکمیل شده</div>
                                
                            </div>
                            
                            <div class="mt-4">
                                
                                <form action="cart_handler.php" method="POST">
                                    <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                                    <button type="submit" class="register-btn">
                                        🛒 افزودن به سبد خرید
                                    </button>
                                </form>
                                
                            </div>
                        </div>

                        <div class="col-md-6 text-md-right">
                            
                            <h2 class="mb-1 bold"><?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                            <p>مقدماتی تا پیشرفته</p>
                            <h5>با تدریس <?= $package['teacher'] ?></h5>
                            
                            <hr>
                            
                            <div class="my-3">
                                <strong>قیمت</strong>
                                <h3 class="text-success fw-bold"><?= number_format($package['price']) ?> تومان</h3>
                            </div>

                            <div class="my-4">
                                <video controls class="w-100 rounded shadow-sm">
                                    <source src="../<?= $package['file1'] ?>" type="video/mp4">
                                    مرورگر شما از تگ ویدئو پشتیبانی نمی‌کند.
                                </video>
                            </div>
                            
                      
                        </div>
                    </div>
                </section>

                <div class="container">

                <!-- فایل‌ها و سرفصل‌ها -->
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <h4 class="h6">توضیحات</h4>
                            <p class="lead" style="max-width:95%;"><?php echo $package['description']; ?></p>
                        </div>

                    </div>
                </div>         

            <br><br><br>

    <?php
        } else {
            // پکیجی با این ID پیدا نشد
            echo "<div class='container mt-5'><div class='alert alert-danger text-center'>⚠️ پکیج مورد نظر با شناسه " . htmlspecialchars($package_id, ENT_QUOTES, 'UTF-8') . " پیدا نشد.</div></div>";
        }
        $stmt->close();
    } else {
        // پارامتر ID در آدرس وجود نداشت
        echo "<div class='container mt-5'><div class='alert alert-warning text-center'>⚠️ شناسه پکیج (ID) به درستی تعیین نشده است. لطفاً از طریق صفحه اصلی اقدام کنید.</div></div>";
    }

    $conn->close();
    include 'footer.php';
    ?>

    <script type="text/javascript">
        // کد گفتینو
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
            "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !1);
        }();
    </script>

</body>

</html>
