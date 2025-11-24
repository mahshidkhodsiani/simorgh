<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جزئیات پکیج</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
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
    </style>
</head>

<body>

    <?php
    include 'header.php';
    include '../config.php';

    // --- منطق بازیابی اطلاعات ---
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $package_id = $_GET['id'];

        // کوئری برای دریافت تمام ستون‌های پکیج
        $sql = "SELECT * FROM `packages` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $package = $result->fetch_assoc();
            echo "<script>document.title = 'جزئیات پکیج: " . htmlspecialchars($package['name']) . "';</script>";

    ?>

            <div class="container mt-5 mb-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-xl-10">

                        <div class="text-center mb-4">
                            <h1 class="display-6 text-primary border-bottom pb-2">
                                <?php echo htmlspecialchars($package['name']); ?>
                            </h1>
                        </div>

                        <div class="row g-4" dir="rtl" style="text-align: right;">

                            <div class="col-md-5">
                                <div class="card p-3 shadow-lg h-100">
                                    <img class="img-fluid rounded-3 mb-3" src="../<?php echo htmlspecialchars($package['pictures']); ?>" alt="تصویر پکیج <?php echo htmlspecialchars($package['name']); ?>" style="max-height: 400px; object-fit: cover;">

                                    <div class="text-center mb-3">
                                        <span class="badge bg-danger p-2 fs-5">
                                            💰 قیمت: <?php echo number_format($package['price']); ?> تومان
                                        </span>
                                    </div>

                                    <form action="cart_handler.php" method="POST">
                                        <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                                        <button type="submit" class="btn btn-success btn-lg w-100 mt-2">
                                            🛒 افزودن به سبد خرید
                                        </button>
                                    </form>

                                    <?php if (!empty($package['file1'])) : ?>
                                        <h6 class="mt-4 mb-2 text-primary">🎬 پیش‌نمایش ویدیویی:</h6>
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <video class="embed-responsive-item w-100 rounded-3" controls>
                                                <source src="../<?= htmlspecialchars($package['file1']) ?>" type="video/mp4">
                                                مرورگر شما از تگ ویدیو پشتیبانی نمی‌کند.
                                            </video>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-7">

                                <div class="card p-4 shadow mb-4">
                                    <h4 class="text-danger mb-3">📝 خلاصه و توضیحات دوره:</h4>
                                    <p class="text-justify lh-lg">
                                        <?php echo nl2br(htmlspecialchars($package['description'])); ?>
                                    </p>
                                </div>

                                <div class="card p-4 shadow">
                                    <h4 class="text-primary mb-3">⚙️ مشخصات و اطلاعات کلیدی:</h4>

                                    <dl class="row detail-list">
                                        <dt class="col-sm-4 text-muted detail-item">🧑‍🏫 مدرس دوره:</dt>
                                        <dd class="col-sm-8 font-weight-bold text-dark">
                                            <?php echo htmlspecialchars($package['teacher']); ?>
                                        </dd>

                                        <dt class="col-sm-4 text-muted detail-item">📚 عنوان آموزشی:</dt>
                                        <dd class="col-sm-8">
                                            <?php echo htmlspecialchars($package['name']); ?>
                                        </dd>

                                        <dt class="col-sm-4 text-muted detail-item">💰 قیمت کل:</dt>
                                        <dd class="col-sm-8 text-danger font-weight-bold fs-5">
                                            <?php echo number_format($package['price']); ?> تومان
                                        </dd>

                                        <?php if (!empty($package['address'])) : ?>
                                            <dt class="col-sm-4 text-muted detail-item">📍 آدرس برگزاری:</dt>
                                            <dd class="col-sm-8">
                                                <?php echo htmlspecialchars($package['address']); ?>
                                            </dd>
                                        <?php endif; ?>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br><br>

        <?php
        } else {
            // پکیجی با این ID پیدا نشد
            echo "<div class='container mt-5'><div class='alert alert-danger text-center'>⚠️ پکیج مورد نظر با شناسه " . htmlspecialchars($package_id) . " پیدا نشد.</div></div>";
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