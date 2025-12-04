<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پکیج های سیمرغ</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/mainstyles.css">

    <style>
        /* 1. پررنگ کردن فونت عنوان و متن اصلی */
        .card-title {
            font-weight: 700 !important; /* پررنگ‌تر کردن عنوان */
            color: #212529;
            font-size: 1.25rem;
        }
        
        .card-text {
            font-weight: 500 !important; /* پررنگ‌تر کردن متن‌های معمولی */
        }

        /* 2. تثبیت ارتفاع توضیحات برای رفع بهم ریختگی سطرها و محدودیت به 2 خط */
        .card-text.text-muted {
            height: 3em; /* ارتفاع دقیق برای 2 خط (1.5em * 2) */
            line-height: 1.5em; 
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2; /* محدودیت به 2 خط */
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
            background-color: #f8f9fa; 
            border: 1px solid #dee2e6;
            border-radius: 40px;
            padding: 20px;
            margin-bottom: 25px; 
        }
        
        /* 5. استایل برای لینک‌های صفحه‌بندی (Pagination) */
        .pagination .page-link {
            color: #007bff;
            border-radius: 50px;
            margin: 0 5px;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        .pagination {
            justify-content: center; /* وسط چین کردن */
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

    // تنظیمات صفحه‌بندی
    $limit = 9; // 3 ردیف 3 تایی = 9 پکیج در هر صفحه
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    // 1. کوئری برای محاسبه کل تعداد پکیج‌ها
    $count_sql = "SELECT COUNT(id) AS total FROM `packages`";
    $count_result = $conn->query($count_sql);
    $total_packages = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_packages / $limit);

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
                    // 2. کوئری برای دریافت پکیج‌های صفحه جاری
                    $sql = "SELECT * FROM `packages` ORDER BY `id` DESC LIMIT $start, $limit"; 
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        // نمایش هر پکیج در قالب یک کارت
                        while ($package = $result->fetch_assoc()) {
                            
                            // 1. پاکسازی توضیحات از تگ‌های HTML
                            $cleaned_description = strip_tags($package['description']);

                            // 2. آرایه‌ای از کاراکترهایی که باید حذف یا جایگزین شوند (شامل خطوط جدید، بک‌اسلش و تیک)
                            $chars_to_remove = array("\r\n", "\n", "\r", "\\", "✅", "⭐", "•"); 

                            // 3. حذف کاراکترهای ناخواسته و جایگزین کردن آن‌ها با فضای خالی
                            $cleaned_description = str_replace($chars_to_remove, ' ', $cleaned_description);
                            
                            // 4. حذف فاصله‌های اضافی پی در پی که ممکن است پس از حذف کاراکترها ایجاد شده باشند
                            $cleaned_description = preg_replace('/\s+/', ' ', $cleaned_description);
                            
                            // 5. حذف فضای خالی از ابتدا و انتهای رشته
                            $cleaned_description = trim($cleaned_description);

                            // در دسکتاپ (md) هر پکیج 4 ستون از 12 ستون را اشغال می‌کند (3 کارت در یک ردیف)
                    ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <img class="card-img-top" src="../<?php echo htmlspecialchars($package['pictures']); ?>" alt="تصویر پکیج" loading="lazy">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($package['name']); ?></h5>
                                                
                                                <p class="card-text text-muted"><?php echo htmlspecialchars($cleaned_description); ?></p> 
                                                
                                                <p class="card-text">
                                                    <strong>مدرس دوره:</strong> <?php echo htmlspecialchars($package['teacher']); ?><br>
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
                                echo "<div class='col-12'><div class='alert alert-warning text-center'>هیچ پکیجی برای نمایش وجود ندارد.</div></div>";
                            }
                            ?>
                        </div>
                        
                        <?php if ($total_pages > 1): ?>
                            <nav aria-label="صفحه‌بندی پکیج‌ها">
                                <ul class="pagination mt-5 mb-5">
                                    
                                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                        
                </div>
        </div>
    </div>
    <br><br><br>

    <?php include 'footer.php'; ?>

    <script type="text/javascript">
        // کد گفتینو بدون تغییر باقی ماند
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