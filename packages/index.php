<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پکیج های سیمرغ</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <style>
        /* 1. پررنگ کردن فونت عنوان و متن اصلی (درخواست شما) */
        .card-title {
            font-weight: 700 !important; /* پررنگ‌تر کردن عنوان */
            color: #212529;
            font-size: 1.25rem;
        }
        
        .card-text {
            font-weight: 500 !important; /* پررنگ‌تر کردن متن‌های معمولی */
        }

        /* 2. تثبیت ارتفاع توضیحات برای رفع بهم ریختگی سطرها (stepping issue) */
        .card-text.text-muted {
            height: 4.5em; /* ارتفاع دقیق برای 3 خط */
            line-height: 1.5em; 
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* محدودیت به 3 خط */
            -webkit-box-orient: vertical;
            white-space: normal;
            margin-bottom: 15px !important;
        }

        /* 3. تثبیت ساختار کارت با فلکس‌باکس برای چسباندن دکمه‌ها به پایین */
        .card-body {
            display: flex; 
            flex-direction: column;
        }

        .mt-auto {
            margin-top: auto !important;
        }
        
        /* 4. استایل برای کارت معرفی بالای صفحه */
        .intro-card {
            background-color: #f8f9fa; /* رنگی شبیه به border-danger قبلی، اما تمیزتر */
            border: 1px solid #dee2e6;
            border-radius: 40px;
            padding: 20px;
            margin-bottom: 25px; /* فاصله از لیست پکیج‌ها */
        }
    </style>
    </head>

<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();
    ?>


    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12">
                
                <div class="intro-card" dir="rtl" style="text-align: right;">
                    <h3>پکیج های آموزشی</h3>
                    <p>
                        اگر به دنبال پکیج‌های آموزشی جامع و کاربردی برای ارتقاء مهارت‌های خود هستید، موسسه سیمرغ بهترین گزینه برای شماست. پکیج‌های آموزشی ما با هدف ارائه آموزش‌های حرفه‌ای و به روز در حوزه‌های مختلف طراحی شده‌اند تا به شما کمک کنند تا به بهترین نحو ممکن به اهداف خود برسید.
                    </p>
                </div>
                <div class="row mt-4">
                    <?php
                    // کوئری برای دریافت همه پکیج‌ها
                    $sql = "SELECT * FROM `packages` ORDER BY `id` ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // نمایش هر پکیج در قالب یک کارت
                        while ($package = $result->fetch_assoc()) {
                            // در دسکتاپ (md) هر پکیج 4 ستون از 12 ستون را اشغال می‌کند (3 کارت در یک ردیف)
                    ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <img class="card-img-top" src="../<?php echo htmlspecialchars($package['pictures']); ?>" alt="تصویر پکیج" loading="lazy">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title"><?php echo htmlspecialchars($package['name']); ?></h5>
                                                <p class="card-text text-muted"><?php echo $package['description']; ?></p> 
                                                <p class="card-text">
                                                    <strong>مدرس دوره:</strong> <?php echo $package['teacher']; ?><br>
                                                    <strong>قیمت:</strong> <?php echo number_format($package['price']); ?> ریال
                                                </p>


                                                <div class="mt-auto">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            <form action="cart_handler.php" method="POST">
                                                                <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                                                                <button type="submit" class="btn btn-success btn-block w-100">🛒 افزودن به سبد خرید</button>
                                                            </form>
                                                        </div>
                                                        <div class="col-12">
                                                            <a href="package.php?id=<?php echo $package['id']; ?>" class="btn btn-outline-info btn-block w-100">
                                                                مشاهده جزئیات
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<div class='alert alert-warning text-center'>هیچ پکیجی برای نمایش وجود ندارد.</div>";
                            }
                            ?>
                        </div>
                </div>
        </div>
    </div>
    <br><br><br>

    <?php include 'footer.php'; ?>

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