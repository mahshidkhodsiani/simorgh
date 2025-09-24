<?php
session_start();

include '../config.php';

include '../PersianCalendar.php';
include '../jalaliDate.php';

$sdate = new SDate();

$title_slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$article_title = "وبلاگ سیمرغ";
$article_description = "آموزش فن بیان، گویندگی، بازیگری، طراحی سایت، موشن گرافیک و هنرهای فرهنگی در موسسه سیمرغ. بهترین دوره‌های هنری و فرهنگی برای علاقه‌مندان به خلاقیت.";
$article_keywords = "فن بین و گویندگی , بازیگری , طراحی سایت , موشن گرافیک , آموزش , فرهنگی هنری , هنر";

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
                <div class="row justify-content-center" style="margin-top: 100px; ">
                    <div class="col-12 col-md-10">
                        <div class="card border border-danger" style="border-radius: 40px;">
                            <h2 class="d-flex justify-content-center mt-2"><?= $row['title'] ?></h2>
                            <img src="../<?= $row['images'] ?>" class="img-fluid" alt="وبلاگ موسسسه فرهنگی هنری سیمرغ">
                            <br>

                            <div class="card-body">
                                <p>تاریخ انتشار: <?= mds_date("l j F Y", strtotime($row['created_at'])) ?></p>
                                <p><strong>تعداد بازدید:</strong> <?= $row['views'] ?></p>

                                <div class="card-text custom-text" style="text-align: center;">
                                    <p class="card-text"><?= $row['body'] ?></p>

                                    <br>
                                    <p style="color: #621e52;">جهت کسب اطلاعات بیشتر و شرکت در دوره‌ها با ما در ارتباط باشید:</p>
                                    <p style="color: #621e52;">تلفن: 021-91300517</p>
                                    <p style="color: #621e52;">واتساپ: 093554637055</p>
                                    <a href="../register.php" class="btn mb-2 mb-md-0 btn-outline-quarternary">ثبت نام در دوره‌ها</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <?php
        } else {
            echo '<hr class="mt-4">';
            echo '<h1>مقاله‌ای یافت نشد!</h1>';
            echo "<a href='../'>بازگشت</a>";
        }
    } else {
        echo '<hr class="mt-4">';
        echo '<h1>مقاله‌ای یافت نشد!</h1>';
        echo "<a href='../'>بازگشت</a>";
    }


    include 'footer.php';
    ?>


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
            "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !1);
        }();
    </script>

</body>

</html>