<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include '../config.php';

    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    $title = "عنوان سایت شما"; // عنوان پیش‌فرض در صورت عدم یافتن مقاله
    $description = "توضیحات پیش‌فرض سایت شما"; // توضیحات پیش‌فرض
    $keywords = "کلمات کلیدی، پیش‌فرض، سایت"; // کلمات کلیدی پیش‌فرض

    if ($slug) {
        $sql = "SELECT title, text, keywords FROM courses WHERE slug = '$slug' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $title = $row['title'];
            $keywords = $row['keywords'];
            // ایجاد دیسکریپشن از ابتدای متن مقاله
            $description = strip_tags($row['title']);
        }
    }
    ?>
    <title><?= htmlspecialchars($title) ?></title>
    <?php
    if (!empty($keywords)) {
    ?>
        <meta name="keywords" content="<?= htmlspecialchars($keywords) ?>">
    <?php
    }
    ?>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

</head>

<body>

    <?php
    include 'header.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();

    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';


    // اگر slug موجود باشد، دوره را جستجو کنیم
    if ($slug) {
        // پرس و جوی SQL برای جستجوی دوره بر اساس slug
        $sql = "SELECT * FROM courses WHERE slug = '$slug' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // دریافت اطلاعات دوره
            $row = $result->fetch_assoc();
            $category = $row['category'];
        } else {
            // اگر دوره‌ای پیدا نشد
            echo "<p>دوره‌ای با این مشخصات پیدا نشد.</p>";
            exit;
        }

    ?>

        <hr class="mt-4">
        <br>
        <br>

        <div class="container mt-4">
            <div class="row justify-content-center" style="margin-top: 100px; ">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <?php
                        if ($category == 'matlab') {
                        ?>
                            <h2 class="d-flex justify-content-center mt-2"><?= $row['title'] ?></h2>
                        <?php
                        } else {
                        ?>
                            <h2 class="d-flex justify-content-center mt-2">نام دوره : <?= $row['title'] ?></h2>

                             
                        <?php
                        }
                        ?>
                        <img src="../<?= $row['images'] ?>" class="img-fluid" alt="وبلاگ موسسسه فرهنگی هنری سیمرغ">
                        <br>

                        <div class="card-body">
                            <p>تاریخ انتشار: <?= mds_date("l j F Y", strtotime($row['created_at'])) ?></p>
                            <?php
                            if ($category == 'course') {
                            ?>
                                <p>قیمت دوره : <?= number_format($row['amount']) ?> ریال</p>
                            <?php
                            }
                            ?>

                            <div class="card-text custom-text" style="text-align: center;">
                                <p class="card-text"><?= $row['text'] ?></p>

                                <br>
                                <p style="color: #621e52;">جهت کسب اطلاعات بیشتر و شرکت دردوره ها با ما در ارتباط باشید.:</p>
                                <p style="color: #621e52;">تلفن: 021-91300517</p>
                                <p style="color: #621e52;">واتساپ : 093554637055</p>
                                <a href="../register.php" class="btn mb-2 mb-md-0 btn-outline-quarternary">ثبت نام در دوره ها</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    } else {
    }


    include 'footer.php';
    ?>

</body>

</html>