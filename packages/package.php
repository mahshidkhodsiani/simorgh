<?php
// این بخش در <head> قرار می‌گیرد، بنابراین کد زیر از فایل قبلی حفظ می‌شود
// اگر id معتبر ارسال شده باشد، برای تولید متاها از دیتابیس استفاده می‌کنیم
$meta_description = "جزئیات پکیج آموزشی";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    include_once '../config.php';
    $tmp_id = (int)$_GET['id'];
    if (isset($conn) && $conn instanceof mysqli) {
        $q = $conn->prepare("SELECT * FROM `packages` WHERE `id` = ?");
        if ($q) {
            $q->bind_param("i", $tmp_id);
            $q->execute();
            $r = $q->get_result();
            if ($r && $r->num_rows) {
                $p_tmp = $r->fetch_assoc();
                // 160 کاراکتر برای توضیحات متا
                $meta_description = mb_substr(strip_tags($p_tmp['description'] ?: $p_tmp['name']), 0, 160, 'UTF-8');
                // عنوان صفحه را در تگ title هم قرار می‌دهیم
                echo '<script>document.title = "جزئیات پکیج: ' . htmlspecialchars($p_tmp['name'], ENT_QUOTES, 'UTF-8') . '";</script>';
            }
            $q->close();
        }
        // اگر اتصال باز باشد، آن را می‌بندیم. (این اتصال موقت برای متاها بود)
        $conn->close();
        unset($conn);
    }
}
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جزئیات پکیج</title>
    
    <?php include "includes.php"; ?>
    
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    
    <meta name="description" content="<?php echo htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8'); ?>">
   
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta property="og:title" content="موسسه هفت هنر سیمرغ">
    <meta property="og:description" content="<?php echo htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?= $p_tmp['pictures'] ?>">
    
    <meta property="og:url" content="https://www.simorghtv.com">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fa_IR">
    
    <meta name="twitter:title" content="موسسه هفت هنر سیمرغ">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image" content="<?= $p_tmp['pictures'] ?>">




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="../css/mainstyles.css">

    
    <style>
        /* استایل سفارشی برای نمایش بهتر جزئیات */
        .detail-item strong { display: inline-block; min-width: 150px; }
        .file-link { color: #007bff; text-decoration: none; }
        .file-link:hover { text-decoration: underline; }
        .promo-card { background: linear-gradient(135deg, #b5122aff 0%, #d18093ff 100%); border-radius: 12px; padding: 22px; color: #222; }
        .promo-avatar { width: 220px; height: 220px; border-radius: 50%; object-fit: cover; border: 6px solid rgba(255, 255, 255, 0.6); box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12); }
        .feature-item { background: rgba(255, 255, 255, 0.18); padding: 8px 12px; border-radius: 999px; font-weight: 700; color: #fff; margin: 6px; display: inline-block; }
        .register-btn { background: #1b0b92ff; color: #fff; border: none; padding: 10px 18px; border-radius: 10px; font-weight: 800; text-decoration: none; }
        .course-card { background: #fff; border-radius: 12px; padding: 14px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06); }
        @media (max-width: 767px) {
            .promo-avatar { width: 140px; height: 140px; }
            .promo-card { padding: 14px; }
        }

        /* --- استایل جدید برای لیست جلسات --- */
        .session-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 8px;
            background-color: #6f74acff;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .session-item:hover { background-color: #e9ecef; }
        .session-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }
        .session-number {
            font-weight: bold;
            color: #0b0b0bff;
            min-width: 60px;
            text-align: right;
        }
        .session-title {
            margin-right: 15px;
            font-weight: 600;
        }
        .session-duration {
            font-size: 0.85em;
            color: #495057;
            text-align: left;
            min-width: 80px;
        }
        .play-icon {
            color: #dc3545; /* رنگ قرمز برای هشدار */
            margin-left: 10px;
        }
        
        /* اصلاح استایل توضیحات */
        .description-content img {
            max-width: 100%;
            height: auto;
        }
        .description-content p {
            margin-bottom: 1rem;
            line-height: 1.8;
            text-align: justify;
        }
        #des_session {
            text-align: justify;
            margin-top: 5px;
            color: #555;
        }
        

        /* ........ */
        .description-content {
            position: relative;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .description-content::before,
        .description-content::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            opacity: 0.25;
            animation: floatBubble 12s infinite ease-in-out;
        }

        .description-content::before {
            width: 180px;
            height: 180px;
            background: radial-gradient(circle at center, #9b1c22ff, #c70d16ff);
            top: -40px;
            left: -40px;
        }

        .description-content::after {
            width: 120px;
            height: 120px;
            background: radial-gradient(circle at center, #6f42c1, #c70d16ff);
            bottom: -30px;
            right: -30px;
        }

        @keyframes floatBubble {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .description-content p {
            position: relative;
            z-index: 1;
            color: #333;
            line-height: 1.9;
            font-size: 1.05em;
        }



    </style>
</head>

<body>

    <?php 
    // اینکلود هدر
    include 'header.php'; 
    // ایجاد مجدد اتصال دیتابیس برای ادامه صفحه
    include '../config.php';
    ?>

    <?php
    // --- منطق بازیابی اطلاعات ---
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $package_id = (int)$_GET['id'];

        // کوئری برای دریافت تمام ستون‌های پکیج
        $sql = "SELECT id, name, pictures, description, teacher, address, course, price, spotplayer, file1, file2, file3 FROM `packages` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "<div class='container mt-5'><div class='alert alert-danger text-center'>خطا در آماده‌سازی کوئری.</div></div>";
            $conn->close(); // بستن اتصال در صورت خطا
            include 'footer.php';
            exit;
        }
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $package = $result->fetch_assoc();
            // عنوان صفحه را به‌روز می‌کنیم 
            echo "<script>document.title = 'جزئیات پکیج: " . htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') . "';</script>";
            // مسیر تصویر را امن‌سازی می‌کنیم
            $picture = !empty($package['pictures']) ? ('../' . ltrim($package['pictures'], '/')) : '../images/default-course.jpg';
            $price_text = !empty($package['price']) ? htmlspecialchars($package['price'], ENT_QUOTES, 'UTF-8') . ' ریال' : 'رایگان';
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
                    <div class="feature-item text-dark">پشتیبانی آنلاین</div>
                    <div class="feature-item text-dark">ارائه مدرک معتبر</div>
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
                <p>دوره مخصوص ورود به بازار کار</p>
                <h5>با تدریس <?= $package['teacher'] ?></h5>
                
                <hr>
                
                <div class="my-3">
                    <strong>قیمت</strong>
                    <h3 class="text-white fw-bold"><?= number_format($package['price']) ?> ریال</h3>
                </div>

                <div class="my-4">
                    <video controls class="w-100 rounded shadow-sm">
                        <source src="../<?= htmlspecialchars($package['file1'], ENT_QUOTES, 'UTF-8') ?>" type="video/mp4">
                        مرورگر شما از تگ ویدئو پشتیبانی نمی‌کند.
                    </video>
                </div>
            </div>
        </div>
    </section>


    

    <div class="container mt-4">

        <div class="row mt-5">

            <div class="col-lg-9">
                <div class="course-card mb-4">
                    <h4 class="h6 mb-3"><i class="fas fa-file-alt me-2"></i>توضیحات کامل پکیج</h4>
                    <div class="description-content">
                        <?php 
                        // محتوا به صورت HTML رندر می‌شود و اگر HTML شامل تگ‌های نامناسب باشد، مشکل از آنجاست.
                        echo $package['description']; 
                        ?>
                    </div>
                </div>

                <div class="course-card">
                    <h4 class="h6 mb-3"><i class="fas fa-list-ol me-2"></i>سرفصل‌ها و جلسات دوره</h4>
                    
                    <?php
                    // کوئری برای دریافت جلسات مربوط به این پکیج
                    $sessions_sql = "SELECT * FROM `sessions` WHERE `package_id` = ? ORDER BY id ASC";
                    $sessions_stmt = $conn->prepare($sessions_sql);
                    $sessions_stmt->bind_param("i", $package_id);
                    $sessions_stmt->execute();
                    $sessions_result = $sessions_stmt->get_result();

                    if ($sessions_result->num_rows > 0) {
                        $session_count = 1;
                        while ($session = $sessions_result->fetch_assoc()) {
                            $duration = (int)$session['duration_minutes'];
                            // تبدیل دقیقه به قالب M:S
                            $minutes = floor($duration);
                            // 3 ثانیه برای حالت پیش‌فرض و 3 ثانیه برای کلیک
                            $seconds = str_pad(round(($duration - $minutes) * 60), 2, '0', STR_PAD_LEFT); 
                            $duration_formatted = $duration > 0 ? $minutes . ':' . $seconds : 'نامشخص';
                        ?>
                            <div class="session-item" onclick="showSpotPlayerAlert()">
                                <div class="session-info">
                                    <span class="session-number">درس <?= $session_count ?></span>
                                    <span class="session-title"><?= htmlspecialchars($session['title'], ENT_QUOTES, 'UTF-8') ?></span>
                                    <p id="des_session"><?= $session['description'] ?></p>
                                </div>
                                <div class="session-duration">
                                    <?= $duration_formatted ?> دقیقه
                                </div>
                                <div class="play-icon">
                                    <i class="fas fa-play-circle"></i>
                                </div>
                            </div>
                        <?php
                            $session_count++;
                        }
                        $sessions_stmt->close();
                    } else {
                        echo "<div class='alert alert-info text-center'>هنوز هیچ جلسه‌ای برای این پکیج ثبت نشده است.</div>";
                    }
                    ?>

                </div>
            </div>

            
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 mb-5"> 
                    <div class="card-header bg-dark text-white text-center">
                        <h4 class="h5 mb-0"><i class="fas fa-layer-group me-2"></i>دیگر پکیج‌های سیمرغ</h4> 
                    </div>
                    
                    <div class="accordion accordion-flush" id="packagesAccordion">
                        <?php
                        // کوئری اصلاح شده: از ستون 'description' به جای 'short_description' استفاده می‌کند.
                        $other_packages_sql = "SELECT id, name, description FROM `packages` WHERE `id` != ? ORDER BY name ASC";
                        $other_stmt = $conn->prepare($other_packages_sql);
                        
                        // بررسی موفقیت آماده‌سازی
                        if ($other_stmt === false) {
                            echo "<div class='p-3 text-center text-danger'>خطا در آماده‌سازی کوئری پکیج‌ها.</div>";
                        } else {
                            $other_stmt->bind_param("i", $package_id);
                            $other_stmt->execute();
                            $other_result = $other_stmt->get_result();

                            if ($other_result->num_rows > 0) {
                                while ($other_package = $other_result->fetch_assoc()) {
                                    $target_id = "collapse-" . $other_package['id'];
                                    $heading_id = "heading-" . $other_package['id'];
                                    $package_link = "package.php?id=" . htmlspecialchars($other_package['id'], ENT_QUOTES, 'UTF-8');
                                    $package_name = htmlspecialchars($other_package['name'], ENT_QUOTES, 'UTF-8');
                                    
                                    // 🌟🌟🌟 قسمت اصلاح شده برای کوتاه کردن توضیحات 🌟🌟🌟
                                    $raw_description = strip_tags($other_package['description']); // حذف تگ‌های HTML
                                    $description_text = mb_substr($raw_description, 0, 100, 'UTF-8'); // برش متن تا ۱۰۰ کاراکتر
                                    if (mb_strlen($raw_description, 'UTF-8') > 100) {
                                        $description_text .= '...'; // افزودن سه‌نقطه در صورت برش
                                    }
                                    // 🌟🌟🌟 پایان قسمت اصلاح شده 🌟🌟🌟
                            ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="<?= $heading_id ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $target_id ?>" aria-expanded="false" aria-controls="<?= $target_id ?>">
                                            <?= $package_name ?>
                                        </button>
                                    </h2>
                                    <div id="<?= $target_id ?>" class="accordion-collapse collapse" aria-labelledby="<?= $heading_id ?>" data-bs-parent="#packagesAccordion">
                                        <div class="accordion-body">
                                            <p class="text-muted small"><?= htmlspecialchars($description_text, ENT_QUOTES, 'UTF-8') ?></p>
                                            <a href="<?= $package_link ?>" class="btn btn-sm btn-outline-primary w-100 mt-2">
                                                <i class="fas fa-eye me-1"></i> مشاهده کامل پکیج
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                                $other_stmt->close();
                            } else {
                                echo "<div class='p-3 text-center text-muted'>پکیج دیگری موجود نیست.</div>";
                            }
                        }
                        ?>
                    </div>
                </div>

                
                <div class="card sidebar-card mb-5">
                    <div class="card-header bg-dark text-white text-center">
                        <h5 class="m-0">📚 جدیدترین مقالات</h5>
                    </div>
                    <div class="list-group list-group-flush sidebar-list">
                        <?php
                        $recentStmt = $conn->prepare("SELECT title FROM articles ORDER BY created_at DESC LIMIT 6");
                        $recentStmt->execute();
                        $recentResult = $recentStmt->get_result();

                        if ($recentResult->num_rows > 0) {
                            while ($recentRow = $recentResult->fetch_assoc()) {
                                $recentTitle = htmlspecialchars($recentRow['title']);
                                echo '<a href="../articles/article.php?slug=' . urlencode($recentTitle) . '" class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-arrow-left"></i>' . $recentTitle . '</a>';
                            }
                        } else {
                            echo '<p class="text-center p-3 m-0 text-muted">مقاله‌ای برای نمایش نیست.</p>';
                        }
                        $recentStmt->close();
                        ?>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a href="../articles" class="btn btn-block sidebar-btn">مشاهده همه مقالات 🚀</a>
                    </div>
                </div>

            </div>

        </div> 

        <br><br><br>
        
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="spotPlayerAlert" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="toast-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong class="me-auto">هشدار مهم</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body text-danger">
                    ⚠️ تماشای جلسات فقط از طریق **نرم‌افزار اسپات پلیر (Spot Player)** امکان‌پذیر است. لطفاً دوره را خریداری کرده و لایسنس را در پلیر خود وارد کنید.
                </div>
            </div>
        </div>


    </div>


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
    // اینکلود فوتر
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
    
    <script>
        function showSpotPlayerAlert() {
            // ایجاد و نمایش Toast
            var toastEl = document.getElementById('spotPlayerAlert');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    </script>

</body>
</html>