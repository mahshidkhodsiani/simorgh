<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آرشیو گویندگان</title>
    <?php include "includes.php"; ?>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <style>
    .speaker-card {
        transition: transform 0.3s;
        margin-bottom: 20px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .speaker-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .speaker-img {
        width: 100%;
        height: auto;
        object-fit: contain;
        background-color: #f8f9fa;
    }
    .card-body {
        padding: 15px;
        text-align: center;
    }
    .speaker-name {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 5px;
    }
    .speaker-type {
        color: #666;
        font-size: 14px;
    }
    .speaker-audio {
        width: 100%;
        margin-top: 8px;
    }
    .no-audio {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
    }

    /* ====== جلوگیری از دانلود و منوی راست‌کلیک روی پلیر ====== */
    audio::-internal-media-controls-download-button {
        display: none;
    }
    audio::-webkit-media-controls-enclosure {
        overflow: hidden;
    }
    audio::-webkit-media-controls-panel {
        width: calc(100% + 30px);
    }
    audio {
        pointer-events: auto;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-touch-callout: none;
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
                <div class="card border border-danger" style="border-radius: 40px;">
                    <div class="card-body" dir="rtl" style="text-align: right;">
                        <h3>کانون گویندگان رادیو سیمرغ</h3>

                        <p>مرجع رسمی معرفی گویندگان رادیویی آموزشگاه سیمرغ</p>

                        <p>
                            کانون گویندگان سیمرغ به‌عنوان یکی از بخش‌های تخصصی آموزشگاه سیمرغ، با هدف شناسایی، معرفی و
                            اعتباربخشی به گویندگان توانمند شکل گرفته است. در این کانون، گویندگانی معرفی می‌شوند که دارای
                            سابقه فعالیت در برنامه‌های رادیویی بوده و مسیر حرفه‌ای خود را به‌صورت رسمی آغاز کرده‌اند.
                            هر گوینده‌ی معرفی‌شده در این صفحه، دارای کارت شناسایی معتبر کانون گویندگان سیمرغ است و
                            اطلاعات درج‌شده شامل رزومه‌ی اجرایی در برنامه‌های رادیویی می‌باشد. این ساختار به تهیه‌کنندگان،
                            مدیران رسانه، کارفرمایان و مجموعه‌های فرهنگی کمک می‌کند تا فرآیند شناسایی و انتخاب گوینده را با
                            اطمینان و شفافیت بیشتری انجام دهند.
                            کانون گویندگان سیمرغ پلی میان آموزش تخصصی و حضور حرفه‌ای در فضای رسانه‌ای است و تلاش می‌کند
                            با ایجاد یک مرجع قابل اعتماد، دسترسی به گویندگان دارای تجربه‌ی واقعی اجرا را ساده‌تر و معتبرتر
                            کند.
                        </p>

                        <div class="row mt-4">
                            <?php
                            // ============================================================
                            // خواندن شماره صفحه - سه روش برای اطمینان
                            // ============================================================
                            $current_page = 0;

                            // روش ۱: از GET
                            if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                                $current_page = intval($_GET['page']);
                            }

                            // روش ۲: از QUERY_STRING
                            if ($current_page === 0 && !empty($_SERVER['QUERY_STRING'])) {
                                if (preg_match('/(?:^|&)page=(\d+)/', $_SERVER['QUERY_STRING'], $m)) {
                                    $current_page = intval($m[1]);
                                }
                            }

                            // روش ۳: از REQUEST_URI
                            if ($current_page === 0 && !empty($_SERVER['REQUEST_URI'])) {
                                if (preg_match('/[?&]page=(\d+)/', $_SERVER['REQUEST_URI'], $m)) {
                                    $current_page = intval($m[1]);
                                }
                            }

                            // پیش‌فرض
                            if ($current_page < 1) {
                                $current_page = 1;
                            }

                            $items_per_page = 9;
                            $offset = ($current_page - 1) * $items_per_page;

                            // تعداد کل
                            $countRes = $conn->query("SELECT COUNT(*) AS total FROM speakers");
                            $total_items = $countRes->fetch_assoc()['total'];
                            $total_pages = max(1, ceil($total_items / $items_per_page));

                            // اصلاح در صورت خارج بودن از محدوده
                            if ($current_page > $total_pages) {
                                $current_page = $total_pages;
                                $offset = ($current_page - 1) * $items_per_page;
                            }

                            $sql = "SELECT * FROM speakers ORDER BY id ASC LIMIT $items_per_page OFFSET $offset";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="speaker-card">
                                    <img src="<?= $row['image'] ?>" class="speaker-img" alt="<?= $row['name'] ?>">
                                    <div class="card-body">
                                        <div class="speaker-name"><?= $row['name'] ?></div>
                                        <div class="speaker-type"><?= $row['kind'] ?></div>

                                        <?php
                                        $mp3 = $row['mp3'] ?? '';
                                        if (!empty($mp3) && $mp3 !== 'NULL' && strtolower($mp3) !== 'null') {
                                            if (strpos($mp3, '../') === 0 || strpos($mp3, 'http') === 0) {
                                                $mp3Path = $mp3;
                                            } else {
                                                $mp3Path = "../" . $mp3;
                                            }
                                        ?>
                                            <audio controls preload="none" class="speaker-audio"
                                                controlsList="nodownload noplaybackrate"
                                                oncontextmenu="return false;"
                                                disablePictureInPicture
                                                onloadedmetadata="this.volume=1;">
                                                <source src="<?= htmlspecialchars($mp3Path) ?>" type="audio/mpeg">
                                                مرورگر شما از پخش صدا پشتیبانی نمی‌کند.
                                            </audio>
                                        <?php } else { ?>
                                            <div class="no-audio">فایل صوتی ثبت نشده</div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            } else {
                                echo '<div class="col-12 text-center py-4"><p>هیچ گوینده ای پیدا نشد.</p></div>';
                            }
                            ?>
                        </div>

                        <?php
                        if ($total_pages > 1) {
                            $start_page = max(1, $current_page - 1);
                            $end_page = min($total_pages, $start_page + 2);
                            if ($end_page - $start_page < 2 && $start_page > 1) {
                                $start_page = max(1, $end_page - 2);
                            }
                        ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                </li>

                                <?php for ($i = $start_page; $i <= $end_page; $i++) { ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                                <?php } ?>

                                <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                </li>
                            </ul>
                        </nav>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>