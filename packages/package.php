<?php
// ==========================================
// منطق سئو (قبل از هر خروجی) - یک بار واکشی همه چیز
// ==========================================
include_once '../config.php';

$site_url  = 'https://simorghtv.com';
$page_path = '/packages/';

$package = null;
$package_id = 0;
$not_found = false;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $package_id = (int)$_GET['id'];

    $sql = "SELECT id, name, pictures, description, teacher, address, course, price, spotplayer, file1, file2, file3 
            FROM `packages` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $package = $result->fetch_assoc();
        } else {
            $not_found = true;
        }
        $stmt->close();
    } else {
        $not_found = true;
    }
} else {
    $not_found = true;
}

// ==========================================
// آماده‌سازی متاها بر اساس نتیجه
// ==========================================
if ($package) {
    // عنوان صفحه
    $page_title = 'پکیج آموزشی ' . $package['name'] . ' | موسسه هفت هنر سیمرغ';

    // توضیحات متا (160 کاراکتر)
    $raw_desc = strip_tags($package['description']);
    $raw_desc = trim(preg_replace('/\s+/', ' ', $raw_desc));
    if (mb_strlen($raw_desc, 'UTF-8') < 30) {
        $raw_desc = 'پکیج آموزشی ' . $package['name'] . ' در موسسه هفت هنر سیمرغ. آموزش پروژه‌محور، پشتیبانی آنلاین و ارائه مدرک معتبر.';
    }
    $meta_description = mb_substr($raw_desc, 0, 160, 'UTF-8');

    // URL و تصویر
    $canonical_url = $site_url . $page_path . 'package.php?id=' . $package_id;

    // تصویر social (مطلق)
    if (!empty($package['pictures'])) {
        $og_image = $site_url . '/' . ltrim($package['pictures'], '/');
    } else {
        $og_image = $site_url . '/images/30.jpg';
    }

    // مسیر تصویر برای نمایش
    $picture = !empty($package['pictures'])
        ? ('../' . ltrim($package['pictures'], '/'))
        : '../images/default-course.jpg';

    // قیمت
    $price_toman = (int)($package['price'] / 10);
    $price_text  = $package['price'] > 0
        ? number_format($price_toman) . ' تومان'
        : 'رایگان';

} else {
    // پکیج پیدا نشد
    $page_title       = 'پکیج مورد نظر یافت نشد | موسسه هفت هنر سیمرغ';
    $meta_description = 'پکیج مورد نظر یافت نشد. لطفاً از صفحه پکیج‌های آموزشی سیمرغ، پکیج مورد نظر خود را انتخاب کنید.';
    $canonical_url    = $site_url . $page_path;
    $og_image         = $site_url . '/images/30.jpg';
}
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>

    <!-- SEO Core -->
    <meta name="description" content="<?= htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="robots"
        content="<?= $package ? 'index, follow, max-image-preview:large, max-snippet:-1' : 'noindex, follow' ?>" />
    <meta name="author" content="موسسه هفت هنر سیمرغ">

    <!-- Open Graph -->
    <meta property="og:type" content="product" />
    <meta property="og:site_name" content="موسسه هفت هنر سیمرغ" />
    <meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:image" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:image:secure_url" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt"
        content="<?= htmlspecialchars($package['name'] ?? 'پکیج آموزشی سیمرغ', ENT_QUOTES, 'UTF-8') ?>" />

    <?php if ($package && $price_toman > 0): ?>
    <meta property="product:price:amount" content="<?= $price_toman ?>" />
    <meta property="product:price:currency" content="IRR" />
    <?php endif; ?>

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="twitter:image" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="twitter:image:alt"
        content="<?= htmlspecialchars($package['name'] ?? 'پکیج آموزشی سیمرغ', ENT_QUOTES, 'UTF-8') ?>" />

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/mainstyles.css">

    <style>
    .detail-item strong {
        display: inline-block;
        min-width: 150px;
    }

    .file-link {
        color: #007bff;
        text-decoration: none;
    }

    .file-link:hover {
        text-decoration: underline;
    }

    .promo-card {
        background: linear-gradient(135deg, #b5122aff 0%, #d18093ff 100%);
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
        background: #1b0b92ff;
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

    .session-item:hover {
        background-color: #e9ecef;
    }

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
        color: #dc3545;
        margin-left: 10px;
    }

    .description-content img {
        max-width: 100%;
        height: auto;
        object-fit: cover;
        object-position: center;
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

    .description-content {
        position: relative;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
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

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-15px);
        }
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

    <?php include 'header.php'; ?>

    <?php if (!$package): ?>

    <!-- =========================================== -->
    <!-- حالت پکیج پیدا نشد -->
    <!-- =========================================== -->
    <div class="container mt-5 mb-5">
        <div class="alert alert-danger text-center">
            ⚠️ پکیج مورد نظر پیدا نشد. لطفاً از صفحه
            <a href="./">پکیج‌های آموزشی سیمرغ</a>
            پکیج مورد نظر خود را انتخاب کنید.
        </div>
    </div>

    <?php else: ?>

    <!-- =========================================== -->
    <!-- اسکیمای Course + Breadcrumb + Product -->
    <!-- =========================================== -->
    <script type="application/ld+json">
    <?php
    $schema_course = [
        "@context" => "https://schema.org",
        "@type" => "Course",
        "name" => htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8'),
        "description" => htmlspecialchars(mb_substr(strip_tags($package['description']), 0, 300, 'UTF-8'), ENT_QUOTES, 'UTF-8'),
        "image" => $og_image,
        "url" => $canonical_url,
        "inLanguage" => "fa-IR",
        "provider" => [
            "@type" => "Organization",
            "name" => "موسسه هفت هنر سیمرغ",
            "url" => $site_url,
            "logo" => $site_url . "/images/logo1.png"
        ],
        "offers" => [
            "@type" => "Offer",
            "price" => (string)$price_toman,
            "priceCurrency" => "IRR",
            "availability" => "https://schema.org/InStock",
            "url" => $canonical_url,
            "seller" => [
                "@type" => "Organization",
                "name" => "موسسه هفت هنر سیمرغ"
            ]
        ],
        "hasCourseInstance" => [
            "@type" => "CourseInstance",
            "courseMode" => "online",
            "courseWorkload" => "PT" . max(1, count(explode("\n", $package['description']))) . "H"
        ]
    ];

    // اگر مدرس داریم، به عنوان instructor اضافه کن
    if (!empty($package['teacher'])) {
        $schema_course["provider"]["employee"] = [
            "@type" => "Person",
            "name" => htmlspecialchars($package['teacher'], ENT_QUOTES, 'UTF-8'),
            "jobTitle" => "مدرس"
        ];
    }

    echo json_encode($schema_course, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    ?>
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "صفحه اصلی",
                "item": "<?= $site_url ?>/"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "پکیج‌های آموزشی",
                "item": "<?= $site_url . $page_path ?>"
            },
            {
                "@type": "ListItem",
                "position": 3,
                "name": "<?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') ?>",
                "item": "<?= htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8') ?>"
            }
        ]
    }
    </script>

    <!-- =========================================== -->
    <!-- Hero / Promo Card -->
    <!-- =========================================== -->
    <section class="promo-card">
        <div class="row align-items-center">
            <div class="col-md-6 text-center mb-4 mb-md-0">
                <img class="promo-avatar rounded-circle shadow-lg"
                    src="<?= htmlspecialchars($picture, ENT_QUOTES, 'UTF-8') ?>"
                    alt="پکیج آموزشی <?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') ?> - موسسه سیمرغ"
                    loading="eager" width="300" height="300">

                <div class="mt-4">
                    <div class="feature-item text-dark">پشتیبانی آنلاین</div>
                    <div class="feature-item text-dark">ارائه مدرک معتبر</div>
                </div>

                <div class="mt-4">
                    <form action="cart_handler.php" method="POST">
                        <input type="hidden" name="package_id" value="<?= (int)$package['id'] ?>">
                        <button type="submit" class="register-btn">
                            🛒 افزودن به سبد خرید
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-6 text-md-right">
                <h1 class="mb-1 bold h2"><?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') ?></h1>
                <p>دوره مخصوص ورود به بازار کار</p>
                <?php if (!empty($package['teacher'])): ?>
                <h3 class="h5">با تدریس <?= htmlspecialchars($package['teacher'], ENT_QUOTES, 'UTF-8') ?></h3>
                <?php endif; ?>

                <hr>

                <div class="my-3">
                    <strong>قیمت</strong>
                    <h2 class="text-white fw-bold h4">
                        <?= $price_toman > 0 ? number_format($price_toman) . ' تومان' : 'رایگان' ?>
                    </h2>
                </div>

                <?php if (!empty($package['file1'])): ?>
                <div class="my-4">
                    <video controls class="w-100 rounded shadow-sm" preload="metadata"
                        poster="<?= htmlspecialchars($picture, ENT_QUOTES, 'UTF-8') ?>">
                        <source src="../<?= htmlspecialchars($package['file1'], ENT_QUOTES, 'UTF-8') ?>"
                            type="video/mp4">
                        مرورگر شما از تگ ویدئو پشتیبانی نمی‌کند.
                    </video>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>


    <div class="container mt-4">

        <div class="row mt-5">

            <div class="col-lg-9">
                <!-- =========================================== -->
                <!-- توضیحات پکیج -->
                <!-- =========================================== -->
                <section class="course-card mb-4">
                    <h2 class="h6 mb-3"><i class="fas fa-file-alt me-2"></i>توضیحات کامل پکیج
                        <?= htmlspecialchars($package['name'], ENT_QUOTES, 'UTF-8') ?>
                    </h2>
                    <div class="description-content">
                        <?php echo $package['description']; ?>
                    </div>
                </section>

                <!-- =========================================== -->
                <!-- سرفصل‌ها و جلسات -->
                <!-- =========================================== -->
                <section class="course-card">
                    <h2 class="h6 mb-3"><i class="fas fa-list-ol me-2"></i>سرفصل‌ها و جلسات دوره</h2>

                    <?php
                    $sessions_sql = "SELECT * FROM `sessions` WHERE `package_id` = ? ORDER BY id ASC";
                    $sessions_stmt = $conn->prepare($sessions_sql);

                    if ($sessions_stmt) {
                        $sessions_stmt->bind_param("i", $package_id);
                        $sessions_stmt->execute();
                        $sessions_result = $sessions_stmt->get_result();

                        if ($sessions_result && $sessions_result->num_rows > 0) {
                            $session_count = 1;
                            while ($session = $sessions_result->fetch_assoc()) {
                                $duration = (int)$session['duration_minutes'];
                                $minutes = floor($duration);
                                $seconds = str_pad(round(($duration - $minutes) * 60), 2, '0', STR_PAD_LEFT);
                                $duration_formatted = $duration > 0 ? $minutes . ':' . $seconds : 'نامشخص';
                            ?>
                    <div class="session-item" onclick="showSpotPlayerAlert()" role="button" tabindex="0">
                        <div class="session-info">
                            <span class="session-number">درس <?= $session_count ?></span>
                            <span
                                class="session-title"><?= htmlspecialchars($session['title'], ENT_QUOTES, 'UTF-8') ?></span>
                            <?php if (!empty($session['description'])): ?>
                            <p id="des_session">
                                <?= htmlspecialchars(mb_substr(strip_tags($session['description']), 0, 200, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <?php endif; ?>
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
                    } else {
                        echo "<div class='alert alert-warning text-center'>خطا در واکشی جلسات.</div>";
                    }
                    ?>

                </section>
            </div>


            <div class="col-lg-3">
                <!-- =========================================== -->
                <!-- سایدبار: پکیج‌های دیگر -->
                <!-- =========================================== -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="h5 mb-0"><i class="fas fa-layer-group me-2"></i>دیگر پکیج‌های سیمرغ</h2>
                    </div>

                    <div class="accordion accordion-flush" id="packagesAccordion">
                        <?php
                        $other_packages_sql = "SELECT id, name, description FROM `packages` WHERE `id` != ? ORDER BY name ASC";
                        $other_stmt = $conn->prepare($other_packages_sql);

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

                                    $raw_description = strip_tags($other_package['description']);
                                    $description_text = mb_substr($raw_description, 0, 70, 'UTF-8');
                                    if (mb_strlen($raw_description, 'UTF-8') > 70) {
                                        $description_text .= '...';
                                    }
                            ?>
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="<?= $heading_id ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#<?= $target_id ?>" aria-expanded="false"
                                    aria-controls="<?= $target_id ?>">
                                    <i class="fas fa-cube me-2 text-muted"></i> <?= $package_name ?>
                                </button>
                            </h3>
                            <div id="<?= $target_id ?>" class="accordion-collapse collapse"
                                aria-labelledby="<?= $heading_id ?>" data-bs-parent="#packagesAccordion">
                                <div class="accordion-body">
                                    <p><?= htmlspecialchars($description_text, ENT_QUOTES, 'UTF-8') ?></p>
                                    <a href="<?= $package_link ?>" class="btn btn-outline-primary w-100 btn-compact"
                                        title="مشاهده پکیج <?= $package_name ?>">
                                        مشاهده پکیج
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                                $other_stmt->close();
                            } else {
                                echo "<div class='p-3 text-center text-muted' style='font-size:0.85rem;'>پکیج دیگری موجود نیست.</div>";
                            }
                        }
                        ?>
                    </div>
                </div>


                <!-- =========================================== -->
                <!-- سایدبار: جدیدترین مقالات -->
                <!-- =========================================== -->
                <div class="card sidebar-card mb-5">
                    <div class="card-header bg-dark text-white text-center">
                        <h2 class="h5 m-0">📚 جدیدترین مقالات</h2>
                    </div>
                    <div class="list-group list-group-flush sidebar-list">
                        <?php
                        $recentStmt = $conn->prepare("SELECT title FROM articles ORDER BY created_at DESC LIMIT 6");
                        if ($recentStmt) {
                            $recentStmt->execute();
                            $recentResult = $recentStmt->get_result();

                            if ($recentResult->num_rows > 0) {
                                while ($recentRow = $recentResult->fetch_assoc()) {
                                    $recentTitle = htmlspecialchars($recentRow['title'], ENT_QUOTES, 'UTF-8');
                                    echo '<a href="../articles/article.php?slug=' . urlencode($recentRow['title']) . '" class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-arrow-left"></i>' . $recentTitle . '</a>';
                                }
                            } else {
                                echo '<p class="text-center p-3 m-0 text-muted">مقاله‌ای برای نمایش نیست.</p>';
                            }
                            $recentStmt->close();
                        }
                        ?>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a href="../articles" class="btn btn-block sidebar-btn">مشاهده همه مقالات 🚀</a>
                    </div>
                </div>

            </div>

        </div>

        <br><br><br>

        <!-- =========================================== -->
        <!-- Toast هشدار Spot Player -->
        <!-- =========================================== -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="spotPlayerAlert" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-delay="3000">
                <div class="toast-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong class="me-auto">هشدار مهم</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body text-danger">
                    ⚠️ تماشای جلسات فقط از طریق نرم‌افزار اسپات پلیر (Spot Player) امکان‌پذیر است. لطفاً دوره را
                    خریداری کرده و لایسنس را در پلیر خود وارد کنید.
                </div>
            </div>
        </div>

    </div>

    <?php endif; ?>

    <?php
    // بستن اتصال دیتابیس (اگر باز است)
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
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
        "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !
            1);
    }();
    </script>

    <script>
    function showSpotPlayerAlert() {
        var toastEl = document.getElementById('spotPlayerAlert');
        if (!toastEl) return;
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
    </script>

</body>

</html>