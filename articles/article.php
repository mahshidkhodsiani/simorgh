<?php
session_start();

include '../config.php';

// فرض بر این است که این فایل‌ها برای تقویم شمسی وجود دارند
include '../PersianCalendar.php';
include '../jalaliDate.php';

$sdate = new SDate();

$title_slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$article_title = "وبلاگ سیمرغ";
$article_description = "آموزش فن بیان، گویندگی، بازیگری، طراحی سایت، موشن گرافیک و هنرهای فرهنگی در موسسه سیمرغ. بهترین دوره‌های هنری و فرهنگی برای علاقه‌مندان به خلاقیت.";
$article_keywords = "فن بین و گویندگی , بازیگری , طراحی سایت , موشن گرافیک , آموزش , فرهنگی هنری , هنر";

// دریافت اطلاعات متا برای SEO
if (!empty($title_slug)) {
    // برای جلوگیری از SQL Injection از prepared statement استفاده می‌شود
    $stmt_select = $conn->prepare("SELECT title, body, keywords FROM articles WHERE title = ?");
    $stmt_select->bind_param("s", $title_slug);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($result_select->num_rows > 0) {
        $row_meta = $result_select->fetch_assoc();
        $article_title = $row_meta['title'];
        $article_keywords = $row_meta['keywords'];
        // استفاده از mb_substr برای پشتیبانی از UTF-8 در برش متن
        $article_description = mb_substr(strip_tags($row_meta['body']), 0, 150, 'UTF-8') . '...';
    }
    $stmt_select->close();
}

?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article_title) ?></title>

    <meta name="description" content="<?= htmlspecialchars($article_description) ?>">

    <?php
    if (!empty($article_keywords)) {
    ?>
    <meta name="keywords" content="<?= htmlspecialchars($article_keywords) ?>">
    <?php
    }
    ?>

    <meta name="author" content="سیمرغ">

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
    /* تعریف فونت */
    @font-face {
        font-family: 'estedad';
        src: url('../fonts/ttf/Estedad-SemiBold.ttf') format('truetype');
    }

    /* --- استایل‌های سایدبار (شامل فونت) --- */
    .sidebar-card {
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #621e52;
        margin-bottom: 30px;
        /* اعمال فونت بر سایدبار */
        font-family: 'estedad', sans-serif !important;
    }

    .sidebar-header {
        background-color: #f7e6f4;
        padding: 15px;
        border-bottom: 1px solid #d4edda;
        color: #621e52;
        font-weight: bold;
    }

    .sidebar-list .list-group-item {
        border-right: 5px solid transparent;
        transition: all 0.3s ease;
        padding: 12px 15px;
        text-align: right;
        border-left: none;
    }

    .sidebar-list .list-group-item:hover {
        background-color: #faeaf7;
        border-right-color: #621e52;
        color: #621e52;
        font-weight: 600;
    }

    .sidebar-list .list-group-item i {
        color: #621e52;
        margin-left: 10px;
    }

    .sidebar-btn {
        border-radius: 10px;
        font-weight: bold;
        margin: 10px;
        background-color: #621e52;
        color: white;
        border: none;
        transition: background-color 0.3s;
    }

    .sidebar-btn:hover {
        background-color: #7d276b;
        color: white;
    }

    /* --- استایل‌های کارت اصلی مقاله --- */
    .article-card {
        border-radius: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        margin-bottom: 40px;
        border: 1px solid #621e52;
    }

    .article-card h1 {
        /* اعمال فونت استدلال بر هدر (عنوان اصلی) */
        font-size: 2rem;
        font-weight: bold;
        font-family: 'estedad', sans-serif !important;
    }

    .article-card img {
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
        width: 100%;
        height: auto;
    }

    .article-content {
        padding: 20px;
        /* اعمال فونت بر کل محتوای کارت (شامل تاریخ و بازدید) */
        font-family: 'estedad', sans-serif !important;
    }

    .article-content p {
        font-size: 1rem;
        text-align: justify;
        text-align-last: right;
        line-height: 2 !important;
        /* خط فاصله مناسب برای خوانایی */
    }

    @media (max-width: 767.98px) {
        .article-card h1 {
            font-size: 1.5rem;
            /* کوچکتر کردن عنوان برای موبایل */
        }
    }
    </style>
</head>

<body>

    <?php
    include 'header.php';

    if (isset($_GET['slug']) and $_GET['slug'] != '') {
        $a = $_GET['slug'];

        // افزایش تعداد بازدید
        $stmt_update = $conn->prepare("UPDATE articles SET views = views + 1 WHERE title = ?");
        $stmt_update->bind_param("s", $a);
        $stmt_update->execute();
        $stmt_update->close();

        // دریافت اطلاعات مقاله
        $stmt_select_article = $conn->prepare("SELECT * FROM articles WHERE title = ?");
        $stmt_select_article->bind_param("s", $a);
        $stmt_select_article->execute();
        $result_article = $stmt_select_article->get_result();
        $row = $result_article->fetch_assoc();
        $stmt_select_article->close();

        if ($row) {
    ?>

    <hr class="mt-4">
    <br>
    <br>

    <div class="container mt-4">
        <div class="row" style="margin-top: 50px;">

            <div class="col-12 col-md-9 order-1 order-md-1">
                <div class="card article-card">
                    <h1 class="d-flex justify-content-center mt-4 p-2 text-center"><?= $row['title'] ?></h1>
                    <img class="img-fluid" src="../<?= $row['images'] ?>"
                        alt="<?= htmlspecialchars($row['title']) . ' - تصویر مقاله' ?>">
                    <br>

                    <div class="card-body article-content">
                        <p class="text-muted small">
                            <i class="far fa-calendar-alt ml-2"></i>
                            تاریخ انتشار:
                            <?= function_exists('mds_date') ? mds_date("l j F Y", strtotime($row['created_at'])) : date('Y/m/d', strtotime($row['created_at'])) ?>
                        </p>
                        <p class="text-muted small">
                            <i class="fas fa-eye ml-2"></i>
                            <strong>تعداد بازدید:</strong> <?= $row['views'] ?>
                        </p>
                        <hr>

                        <div class="card-text custom-text">
                            <p class="article-text"><?= $row['body'] ?></p>
                        </div>
                        <hr>

                        <div class="alert text-center mt-4"
                            style="background-color: #f7e6f4; border-color: #621e52; color: #621e52;" role="alert">
                            <h4 class="alert-heading" style="font-family: 'estedad', sans-serif !important;">جهت کسب
                                اطلاعات بیشتر و شرکت در دوره‌ها با ما در ارتباط باشید:</h4>
                            <p class="mb-0 h4">تلفن: 91300517-021 | واتساپ: 09354637055</p>
                            <hr>
                            <a href="../register.php" class="btn sidebar-btn">ثبت نام در دوره‌ها</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 order-2 order-md-2 mt-5 mt-md-0">

                <div class="card sidebar-card mb-5">
                    <div class="card-header sidebar-header text-center">
                        <h5 class="m-0">📚 جدیدترین مقالات</h5>
                    </div>
                    <div class="list-group list-group-flush sidebar-list">
                        <?php
                                $recentStmt = $conn->prepare("SELECT title FROM articles ORDER BY created_at DESC LIMIT 5");
                                $recentStmt->execute();
                                $recentResult = $recentStmt->get_result();

                                if ($recentResult->num_rows > 0) {
                                    while ($recentRow = $recentResult->fetch_assoc()) {
                                        $recentTitle = htmlspecialchars($recentRow['title']);
                                        echo '<a href="article.php?slug=' . urlencode($recentTitle) . '" class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-arrow-left"></i>' . $recentTitle . '</a>';
                                    }
                                } else {
                                    echo '<p class="text-center p-3 m-0 text-muted">مقاله‌ای برای نمایش نیست.</p>';
                                }
                                $recentStmt->close();
                                ?>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a href="../blog" class="btn btn-block sidebar-btn">مشاهده همه مقالات 🚀</a>
                    </div>
                </div>

                <div class="card sidebar-card mt-4">
                    <div class="card-header sidebar-header text-center">
                        <h5 class="m-0">🎭 دوره‌ها و خدمات سیمرغ</h5>
                    </div>

                    <div class="list-group list-group-flush sidebar-list">
                        <a href="../courses/course.php?slug=دوبله+پیشرفته"
                            class="list-group-item list-group-item-action sidebar-item"><i
                                class="fas fa-microphone-alt"></i> دوره دوبله پیشرفته</a>
                        <a href="../courses/course.php?slug=فن+بیان+و+گویندگی+کودکان"
                            class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-child"></i>
                            دوره گویندگی و فن بیان کودکان</a>
                        <a href="../courses/course.php?slug=موشن+گرافیک"
                            class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-pen-nib"></i>
                            موشن گرافیک</a>
                        <a href="../courses/course.php?slug=تدوین+فیلم"
                            class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-film"></i>
                            تدوین فیلم</a>
                        <a href="../courses/course.php?slug=بازیگری+بزرگسال"
                            class="list-group-item list-group-item-action sidebar-item"><i
                                class="fas fa-theater-masks"></i> کلاس بازیگری</a>

                        <a href="../packages" class="list-group-item list-group-item-action sidebar-item">
                            <i class="fas fa-cubes"></i> پکیج های آموزشی سیمرغ
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
        } else {
            echo '<hr class="mt-4">';
            echo '<div class="container text-center py-5">';
            echo '<h1 class="text-danger">مقاله‌ای یافت نشد!</h1>';
            echo '<p>متأسفانه مقاله با عنوان درخواستی پیدا نشد.</p>';
            echo "<a href='../' class='btn btn-success mt-3'>بازگشت به صفحه اصلی</a>";
            echo '</div>';
        }
    } else {
        echo '<hr class="mt-4">';
        echo '<div class="container text-center py-5">';
        echo '<h1 class="text-warning">مقاله‌ای مشخص نشده است!</h1>';
        echo '<p>لطفاً یک مقاله را برای مشاهده انتخاب کنید.</p>';
        echo "<a href='../blog' class='btn btn-info mt-3'>مشاهده لیست مقالات</a>";
        echo '</div>';
    }


    include 'footer.php';
    if (isset($conn)) {
        $conn->close();
    }
    ?>


    <script type="text/javascript">
    // کد گوفتینو (Goftino) برای چت آنلاین
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

</body>

</html>