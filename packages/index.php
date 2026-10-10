<?php
// ==========================================
// تنظیمات اولیه سئو (قبل از هر خروجی)
// ==========================================
include '../config.php';

$limit = 9;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $limit;

// شمارش کل پکیج‌ها
$count_result = $conn->query("SELECT COUNT(id) AS total FROM `packages`");
$total_packages = $count_result ? (int)$count_result->fetch_assoc()['total'] : 0;
$total_pages = max(1, (int)ceil($total_packages / $limit));

// اگر صفحه‌ی درخواستی از محدوده خارج بود، به ۱ برگردان
if ($page > $total_pages) {
    $page = 1;
    $start = 0;
}

// واکشی پکیج‌های همین صفحه (یک بار برای همه‌ی استفاده‌ها)
$packages_list = [];
$sql = "SELECT * FROM `packages` ORDER BY `id` ASC LIMIT $start, $limit";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages_list[] = $row;
    }
}

// ==========================================
// تعیین عنوان و توضیحات متای صفحه (داینامیک برای پیجینیشن)
// ==========================================
$site_url  = 'https://simorghtv.com';
$page_path = '/packages/';

if ($page > 1) {
    $page_title = 'پکیج‌های آموزشی سیمرغ - صفحه ' . $page . ' | آموزش پروژه‌محور با مدرک معتبر';
    $meta_description = 'لیست پکیج‌های آموزشی موسسه هفت هنر سیمرغ - صفحه ' . $page . '. آموزش پروژه‌محور، پشتیبانی آنلاین و ارائه مدرک معتبر.';
    $canonical_url = $site_url . $page_path . '?page=' . $page;
} else {
    $page_title = 'پکیج‌های آموزشی سیمرغ | آموزش پروژه‌محور با مدرک معتبر';
    $meta_description = 'ارتقاء مهارت‌های فردی با پکیج‌های آموزشی جامع موسسه سیمرغ. آموزش‌های پروژه‌محور و بازارکاری در حوزه‌های مختلف با پشتیبانی آنلاین و مدرک معتبر.';
    $canonical_url = $site_url . $page_path;
}

// تصویر پیش‌فرض برای social (اگر پکیج اول تصویر داشت، از آن استفاده می‌کنیم)
$og_image = $site_url . '/images/30.jpg';
if (!empty($packages_list[0]['pictures'])) {
    $og_image = $site_url . '/' . ltrim($packages_list[0]['pictures'], '/');
}

// ============================================
// ✅ بخش کامنت‌ها برای صفحه ایندکس پکیج‌ها
// ============================================
$comment_message = '';
$comment_message_type = '';
$for_type = 'package';
$for_id = 0; // 0 = کامنت‌های صفحه ایندکس پکیج‌ها (نه یک پکیج خاص)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $comment_text = trim($_POST['comment_text'] ?? '');

    if ($full_name === '' || $comment_text === '') {
        $comment_message = '❌ لطفاً نام و متن کامنت را وارد کنید.';
        $comment_message_type = 'danger';
    } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $comment_message = '❌ ایمیل وارد شده معتبر نیست.';
        $comment_message_type = 'danger';
    } else {
        $email_val = $email !== '' ? $email : null;
        $insert_sql = "INSERT INTO comments (full_name, email, comment_text, for_type, for_id) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssssi", $full_name, $email_val, $comment_text, $for_type, $for_id);
        if ($insert_stmt->execute()) {
            $comment_message = '✅ کامنت شما با موفقیت ثبت شد.';
            $comment_message_type = 'success';
        } else {
            $comment_message = '❌ خطا در ثبت کامنت. لطفاً دوباره تلاش کنید.';
            $comment_message_type = 'danger';
        }
        $insert_stmt->close();
    }
}

// ============================================
// ✅ دریافت لیست کامنت‌ها
// ============================================
$comments = [];
$comments_sql = "SELECT id, full_name, comment_text, admin_reply, created_at
                 FROM comments
                 WHERE for_type = 'package' AND for_id = " . (int)$for_id . "
                 ORDER BY created_at DESC";
$comments_result = $conn->query($comments_sql);
if ($comments_result && $comments_result->num_rows > 0) {
    while ($row = $comments_result->fetch_assoc()) {
        $comments[] = $row;
    }
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

    <?php if ($page > 1): ?>
    <link rel="prev" href="<?= $site_url . $page_path . ($page - 1 > 1 ? '?page=' . ($page - 1) : '') ?>" />
    <?php endif; ?>
    <?php if ($page < $total_pages): ?>
    <link rel="next" href="<?= $site_url . $page_path . '?page=' . ($page + 1) ?>" />
    <?php endif; ?>

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
    <meta name="googlebot" content="index, follow, max-image-preview:large" />

    <!-- Open Graph / WhatsApp / Telegram -->
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="موسسه هفت هنر سیمرغ" />
    <meta property="og:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:description" content="<?= htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:locale" content="fa_IR" />

    <meta property="og:image" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:image:secure_url" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8') ?>" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="پکیج‌های آموزشی موسسه هفت هنر سیمرغ" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="twitter:description" content="<?= htmlspecialchars($meta_description, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="twitter:image" content="<?= htmlspecialchars($og_image, ENT_QUOTES, 'UTF-8') ?>" />
    <meta name="twitter:image:alt" content="پکیج‌های آموزشی موسسه هفت هنر سیمرغ" />

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/mainstyles.css">

    <style>
    :root {
        --primary-color: #007bff;
        --success-color: #28a745;
        --text-dark: #212529;
        --text-muted: #6c757d;
    }

    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        overflow: hidden;
        background: #fff;
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-12px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .card-img-container {
        width: 100%;
        height: 270px;
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .card:hover .card-img-top {
        transform: scale(1.08);
    }

    .card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-title {
        font-weight: 800 !important;
        color: var(--text-dark);
        font-size: 1.2rem;
        margin-bottom: 15px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .card-description {
        font-weight: 500;
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 3.2em;
    }

    .package-info {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .price-tag {
        color: var(--success-color);
        font-weight: 800;
        font-size: 1.1rem;
    }

    .btn-add-cart {
        font-weight: 700;
        border-radius: 12px;
        padding: 12px;
        background-color: var(--success-color);
        border: none;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
    }

    .btn-details {
        border-radius: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    .intro-section {
        background: #ffffff;
        border-radius: 30px;
        padding: 20px;
        margin-bottom: 50px;
        border: 8px solid var(--primary-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    /* پیجینیشن */
    .packages-pagination .page-link {
        color: #007bff;
        border-radius: 10px !important;
        margin: 0 3px;
        font-weight: 700;
        border: 1px solid #dee2e6;
    }

    .packages-pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .packages-pagination .page-link:hover {
        background-color: #e9ecef;
    }

    /* ============ کامنت‌ها ============ */
    .comments-section {
        background: #ffffff;
        border-radius: 25px;
        padding: 35px 30px;
        margin-top: 40px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        border: 1px solid #e9ecef;
    }

    .comments-title {
        color: #212529;
        font-weight: 800;
        border-bottom: 3px solid var(--primary-color);
        display: inline-block;
        padding-bottom: 8px;
        margin-bottom: 25px;
    }

    .comment-form-card {
        background: #f8f9fa;
        border-radius: 18px;
        padding: 20px 22px;
        border: 1px solid #e9ecef;
        margin-bottom: 30px;
        max-width: 60%;
        margin-left: auto;
        margin-right: auto;
    }

    .comment-form-card h5 {
        color: var(--primary-color);
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .comment-form-card .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
        padding: 9px 14px;
        font-size: 0.9rem;
    }

    .comment-form-card .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.12);
    }

    .comment-form-card label {
        font-size: 13px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 4px;
    }

    .comment-submit-btn {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 50px;
        padding: 10px 30px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .comment-submit-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 18px rgba(0, 123, 255, 0.4);
        color: white;
    }

    .comment-item {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 18px 20px;
        margin-bottom: 15px;
        border: 1px solid #e9ecef;
        transition: all 0.3s;
    }

    .comment-item:hover {
        border-color: var(--primary-color);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.08);
    }

    .comment-author {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .comment-date {
        color: #adb5bd;
        font-size: 12px;
    }

    .comment-text {
        color: #343a40;
        margin-top: 10px;
        line-height: 1.8;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .admin-reply-box {
        background: #e8f5e9;
        border-right: 4px solid var(--success-color);
        border-radius: 10px;
        padding: 12px 16px;
        margin-top: 15px;
        margin-right: 15px;
    }

    .admin-reply-label {
        color: var(--success-color);
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .admin-reply-text {
        color: #2e7d32;
        line-height: 1.7;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .no-comments {
        text-align: center;
        padding: 40px 20px;
        color: #adb5bd;
    }

    .no-comments .icon {
        font-size: 50px;
        margin-bottom: 15px;
    }

    .comments-count-badge {
        background: rgba(0, 123, 255, 0.15);
        color: var(--primary-color);
        border-radius: 50px;
        padding: 3px 14px;
        font-size: 13px;
        font-weight: 700;
        margin-right: 10px;
    }

    @media (max-width: 768px) {
        .comment-form-card {
            max-width: 100%;
        }
    }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <main class="container mt-5">
        <a class="btn btn-success m-2" href="../user/tickets">ارسال تیکت به پشتیبانی</a>

        <section class="intro-section">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="h2 mb-3 fw-bolder">پکیج‌های آموزشی سیمرغ</h1>
                    <p class="lead text-muted" style="font-weight: 500;">
                        دسترسی به بهترین پکیج‌های آموزشی بصورت پروژه‌محور و کاملاً کاربردی. مهارت خود را همین امروز
                        ارتقاء دهید.
                    </p>
                    <p>
                        جهت استفاده بهتر ویدیوی روبرو را مشاهده کنید و در صورت بروز هرگونه مشکلی به پشتیبانی تیکت بزنید
                    </p>
                </div>
                <div class="col-md-6">
                    <video controls class="w-100 rounded shadow-sm" preload="metadata">
                        <source src="../uploads/packages/12/file_695d261d07bf1.m4v" type="video/mp4">
                        مرورگر شما از تگ ویدئو پشتیبانی نمی‌کند.
                    </video>
                </div>
            </div>
        </section>
        <br>

        <div class="row">
            <?php if (!empty($packages_list)): ?>
            <?php foreach ($packages_list as $package): 
                $cleaned_description = strip_tags($package['description']);
                $cleaned_description = str_replace(array("\r", "\n"), ' ', $cleaned_description);
                $cleaned_description = preg_replace('/\s+/', ' ', $cleaned_description);
                $package_url = 'package.php?id=' . (int)$package['id'];
            ?>
            <article class="col-lg-4 col-md-6 mb-5">
                <div class="card h-100">
                    <div class="card-img-container">
                        <img class="card-img-top"
                            src="../<?php echo htmlspecialchars($package['pictures']); ?>"
                            alt="پکیج آموزشی <?php echo htmlspecialchars($package['name']); ?> - موسسه سیمرغ"
                            loading="lazy" width="400" height="270">
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="<?= $package_url ?>"
                                style="color:inherit; text-decoration:none;">
                                <?php echo htmlspecialchars($package['name']); ?>
                            </a>
                        </h3>

                        <p class="card-description"><?php echo trim($cleaned_description); ?></p>

                        <div class="package-info">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">مدرس دوره:</span>
                                <span class="fw-bold"><?php echo htmlspecialchars($package['teacher']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">مبلغ دوره :</span>
                                <span class="price-tag">
                                    <?php echo number_format($package['price'] / 10); ?> تومان
                                </span>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <form action="cart_handler.php" method="POST">
                                <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                                <button type="submit" class="btn btn-add-cart btn-block w-100 text-white">
                                    🛒 افزودن به سبد خرید
                                </button>
                            </form>
                            <a href="<?= $package_url ?>"
                                class="btn btn-outline-primary btn-details btn-block w-100"
                                title="مشاهده سرفصل‌های پکیج <?= htmlspecialchars($package['name']) ?>">
                                مشاهده سرفصل‌ها
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">هنوز پکیجی برای نمایش وجود ندارد.</div>
            </div>
            <?php endif; ?>
        </div>

        <!-- =========================================== -->
        <!-- پیجینیشن قابل خزش برای گوگل -->
        <!-- =========================================== -->
        <?php if ($total_pages > 1): ?>
        <nav aria-label="صفحه‌بندی پکیج‌ها" class="mt-4 mb-5">
            <ul class="pagination justify-content-center packages-pagination">

                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?page=<?= $page - 1 ?>"
                        rel="prev"
                        aria-label="صفحه قبل">
                        &laquo; قبلی
                    </a>
                </li>
                <?php endif; ?>

                <?php
                // نمایش هوشمند شماره صفحات (با ... در صورت زیاد بودن)
                $range = 2;
                $start_p = max(1, $page - $range);
                $end_p   = min($total_pages, $page + $range);

                if ($start_p > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                    if ($start_p > 2) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                }

                for ($i = $start_p; $i <= $end_p; $i++):
                ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                        href="?page=<?= $i ?>"
                        <?= ($i == $page) ? 'aria-current="page"' : '' ?>>
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor;

                if ($end_p < $total_pages) {
                    if ($end_p < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                }
                ?>

                <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link"
                        href="?page=<?= $page + 1 ?>"
                        rel="next"
                        aria-label="صفحه بعد">
                        بعدی &raquo;
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </nav>
        <?php endif; ?>

        <!-- =========================================== -->
        <!-- ✅ بخش کامنت‌ها -->
        <!-- =========================================== -->
        <div class="comments-section">
            <h3 class="comments-title">
                💬 نظرات شما درباره پکیج‌های آموزشی
                <span class="comments-count-badge"><?php echo count($comments); ?></span>
            </h3>

            <?php if ($comment_message !== ''): ?>
            <div class="alert alert-<?php echo $comment_message_type; ?> text-center">
                <?php echo htmlspecialchars($comment_message); ?>
            </div>
            <?php endif; ?>

            <div class="comment-form-card">
                <h5>✍️ نظر خود را بنویسید</h5>
                <form method="POST" action="">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="full_name">نام و فامیل <span style="color: #dc3545;">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                placeholder="مثال: علی رضایی" required maxlength="120">
                        </div>
                        <div class="col-md-6">
                            <label for="email">ایمیل (اختیاری)</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="example@mail.com" maxlength="150">
                        </div>
                        <div class="col-12">
                            <label for="comment_text">متن کامنت <span style="color: #dc3545;">*</span></label>
                            <textarea class="form-control" id="comment_text" name="comment_text" rows="3"
                                placeholder="نظر خود را درباره پکیج‌های آموزشی سیمرغ بنویسید..." required></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" name="submit_comment" class="comment-submit-btn">
                                📩 ارسال کامنت
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="comments-list">
                <?php if (count($comments) > 0): ?>
                <?php foreach ($comments as $comment): ?>
                <div class="comment-item">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="comment-author">👤 <?php echo htmlspecialchars($comment['full_name']); ?></div>
                        <div class="comment-date">
                            🕐 <?php echo date('Y/m/d H:i', strtotime($comment['created_at'])); ?>
                        </div>
                    </div>
                    <div class="comment-text"><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></div>

                    <?php if (!empty($comment['admin_reply'])): ?>
                    <div class="admin-reply-box">
                        <div class="admin-reply-label">🎙️ پاسخ ادمین:</div>
                        <div class="admin-reply-text"><?php echo nl2br(htmlspecialchars($comment['admin_reply'])); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="no-comments">
                    <div class="icon">💬</div>
                    <h5>هنوز کامنتی ثبت نشده</h5>
                    <p>اولین نفری باشید که نظر خود را می‌نویسید!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- =========================================== -->
        <!-- اسکیمای ItemList + Course برای Rich Snippet -->
        <!-- =========================================== -->
        <?php if (!empty($packages_list)): ?>
        <script type="application/ld+json">
        <?php
        $items = [];
        $position = 1;
        foreach ($packages_list as $p) {
            $items[] = [
                "@type" => "ListItem",
                "position" => $position++,
                "url" => $site_url . $page_path . "package.php?id=" . (int)$p['id'],
                "item" => [
                    "@type" => "Course",
                    "name" => htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8'),
                    "description" => htmlspecialchars(mb_substr(strip_tags($p['description']), 0, 160, 'UTF-8'), ENT_QUOTES, 'UTF-8'),
                    "image" => $site_url . '/' . ltrim($p['pictures'], '/'),
                    "url" => $site_url . $page_path . "package.php?id=" . (int)$p['id'],
                    "inLanguage" => "fa-IR",
                    "provider" => [
                        "@type" => "Organization",
                        "name" => "موسسه هفت هنر سیمرغ",
                        "url" => $site_url
                    ],
                    "offers" => [
                        "@type" => "Offer",
                        "price" => (string)(int)($p['price'] / 10),
                        "priceCurrency" => "IRR",
                        "availability" => "https://schema.org/InStock",
                        "url" => $site_url . $page_path . "package.php?id=" . (int)$p['id']
                    ]
                ]
            ];
        }
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "name" => "پکیج‌های آموزشی سیمرغ",
            "description" => $meta_description,
            "url" => $canonical_url,
            "numberOfItems" => count($items),
            "itemListElement" => $items
        ];
        echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        ?>
        </script>

        <!-- اسکیمای Breadcrumb -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
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
                }
                <?php if ($page > 1): ?>
                ,{
                    "@type": "ListItem",
                    "position": 3,
                    "name": "صفحه <?= $page ?>",
                    "item": "<?= htmlspecialchars($canonical_url, ENT_QUOTES) ?>"
                }
                <?php endif; ?>
            ]
        }
        </script>
        <?php endif; ?>

        <!-- اسکیمای سایت (Organization + WebSite) - یک بار کافیه، ولی اینجا هم بی‌ضرره -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "موسسه هفت هنر سیمرغ",
            "url": "<?= $site_url ?>",
            "logo": "<?= $site_url ?>/images/logo1.png",
            "sameAs": [
                "https://www.instagram.com/haft_simorgh/"
            ],
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+982191300517",
                "contactType": "customer service",
                "areaServed": "IR",
                "availableLanguage": "Persian"
            }
        }
        </script>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "موسسه هفت هنر سیمرغ",
            "url": "<?= $site_url ?>",
            "inLanguage": "fa-IR",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "<?= $site_url ?>/search?q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
        </script>

    </main>

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
        "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load",
            g, !1);
    }();
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>