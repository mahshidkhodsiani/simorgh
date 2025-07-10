<?php
header("Cache-Control: public, max-age=31536000"); // Cache for 1 year
header("Pragma: cache");
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
            height: 200px;
            object-fit: cover;
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
                        <h3>آرشیو گویندگان موسسه سیمرغ</h3>
                        <p>منبعی ارزشمند از صداهای بی نظیر و مهارت های حرفه ای متنوع جهت گویندگی متن های شماست.</p>
                        <p>پس از انتخاب گوینده متن خود را به همراه اسم گوینده در تلگرام یا واتساپ برای ما ارسال کنید تا با کیفیت عالی در استودیوی سیمرغ برای شما ضبط و ارسال کنیم.</p>

                        <div class="row mt-4">
                            <?php
                            // Pagination configuration
                            $items_per_page = 9; // 3x3 grid
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $offset = ($current_page - 1) * $items_per_page;

                            // SQL query
                            $sql = "SELECT * FROM speakers ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="speaker-card">
                                            <img src="<?= $row['image'] ?>" class="speaker-img" alt="<?= $row['name'] ?>">
                                            <div class="card-body">
                                                <div class="speaker-name"><?= $row['name'] ?></div>
                                                <div class="speaker-type"><?= $row['kind'] ?></div>
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
                        // Pagination links
                        $sql = "SELECT COUNT(*) AS total FROM speakers";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        $total_items = $row['total'];
                        $total_pages = ceil($total_items / $items_per_page);

                        $start_page = max(1, $current_page - 1);
                        $end_page = min($total_pages, $start_page + 2);

                        if ($end_page - $start_page < 2 && $start_page > 1) {
                            $start_page = max(1, $end_page - 2);
                        }

                        if ($total_pages > 1) {
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