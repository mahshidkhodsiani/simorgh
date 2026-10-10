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

// ============================================
// ✅ بخش کامنت‌ها برای مقاله
// ============================================
$comment_message = '';
$comment_message_type = '';
$for_type = 'article';
$for_id = 0;

$article_id_for_comments = 0;
if (!empty($title_slug)) {
    $id_stmt = $conn->prepare("SELECT id FROM articles WHERE title = ? LIMIT 1");
    $id_stmt->bind_param("s", $title_slug);
    $id_stmt->execute();
    $id_result = $id_stmt->get_result();
    if ($id_result && $id_result->num_rows > 0) {
        $article_id_for_comments = (int)$id_result->fetch_assoc()['id'];
    }
    $id_stmt->close();
}
$for_id = $article_id_for_comments;

if ($article_id_for_comments > 0 && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
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

$comments = [];
if ($article_id_for_comments > 0) {
    $comments_sql = "SELECT id, full_name, comment_text, admin_reply, created_at
                     FROM comments
                     WHERE for_type = 'article' AND for_id = " . (int)$for_id . "
                     ORDER BY created_at DESC";
    $comments_result = $conn->query($comments_sql);
    if ($comments_result && $comments_result->num_rows > 0) {
        while ($c = $comments_result->fetch_assoc()) {
            $comments[] = $c;
        }
    }
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
            font-family: 'estedad', sans-serif !important;
        }

        .article-content p {
            font-size: 1rem;
            text-align: justify;
            text-align-last: right;
            line-height: 2 !important;
        }

        @media (max-width: 767.98px) {
            .article-card h1 {
                font-size: 1.5rem;
            }
        }

        /* ============ کامنت‌ها ============ */
        .comments-section {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px 25px;
            margin-top: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #621e52;
            font-family: 'estedad', sans-serif !important;
        }

        .comments-title {
            color: #621e52;
            font-weight: bold;
            border-bottom: 3px solid #621e52;
            display: inline-block;
            padding-bottom: 8px;
            margin-bottom: 25px;
        }

        .comment-form-card {
            background: #f7e6f4;
            border-radius: 15px;
            padding: 18px 20px;
            border: 1px solid #d4b8cc;
            margin-bottom: 25px;
            max-width: 60%;
            margin-left: auto;
            margin-right: auto;
        }

        .comment-form-card h5 {
            color: #621e52;
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .comment-form-card .form-control {
            border-radius: 10px;
            border: 1px solid #d4b8cc;
            padding: 8px 14px;
            font-size: 0.9rem;
        }

        .comment-form-card .form-control:focus {
            border-color: #621e52;
            box-shadow: 0 0 0 3px rgba(98, 30, 82, 0.12);
        }

        .comment-form-card label {
            font-size: 13px;
            font-weight: 600;
            color: #621e52;
            margin-bottom: 4px;
        }

        .comment-submit-btn {
            background: linear-gradient(135deg, #621e52, #7d276b);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            padding: 9px 28px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .comment-submit-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 18px rgba(98, 30, 82, 0.4);
            color: white;
        }

        .comment-item {
            background: #faf5f9;
            border-radius: 15px;
            padding: 18px 20px;
            margin-bottom: 15px;
            border: 1px solid #e8d5e2;
            transition: all 0.3s;
        }

        .comment-item:hover {
            border-color: #621e52;
            box-shadow: 0 4px 15px rgba(98, 30, 82, 0.08);
        }

        .comment-author {
            color: #621e52;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .comment-date {
            color: #a08998;
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
            border-right: 4px solid #28a745;
            border-radius: 10px;
            padding: 12px 16px;
            margin-top: 15px;
            margin-right: 15px;
        }

        .admin-reply-label {
            color: #28a745;
            font-weight: bold;
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
            color: #a08998;
        }

        .no-comments .icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .comments-count-badge {
            background: rgba(98, 30, 82, 0.15);
            color: #621e52;
            border-radius: 50px;
            padding: 3px 14px;
            font-size: 13px;
            font-weight: bold;
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .comment-form-card {
                max-width: 100%;
            }
        }

        /* ============================================ */
        /* 🌙 پاپ‌آپ شب‌های تهران (نسخه بهینه) */
        /* ============================================ */
        .tehran-popup-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 10, 30, 0.85);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 15px;
            animation: fadeInOverlay 0.25s ease;
        }

        .tehran-popup-overlay.show {
            display: flex;
        }

        @keyframes fadeInOverlay {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .tehran-popup {
            position: relative;
            width: 100%;
            max-width: 420px;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
            border: 2px solid rgba(255, 215, 0, 0.5);
            animation: popupBounce 0.4s cubic-bezier(0.34, 1.4, 0.64, 1);
        }

        @keyframes popupBounce {
            0% { transform: scale(0.85) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }

        .tehran-popup-close {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 5;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            font-size: 16px;
            transition: background 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tehran-popup-close:hover {
            background: #ff4757;
            border-color: #ff4757;
            transform: rotate(90deg);
        }

        .tehran-popup-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, #0a0a2a 0%, #1a1a3e 45%, #2d1b4e 100%);
        }

        .tehran-popup-stars {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(2px 2px at 15% 20%, #fff, transparent),
                radial-gradient(1.5px 1.5px at 65% 15%, #fff, transparent),
                radial-gradient(2px 2px at 85% 45%, #ffd700, transparent),
                radial-gradient(1.5px 1.5px at 25% 75%, #fff, transparent),
                radial-gradient(2px 2px at 78% 82%, #fff, transparent),
                radial-gradient(1.5px 1.5px at 45% 55%, #ffd700, transparent),
                radial-gradient(1.5px 1.5px at 92% 22%, #fff, transparent),
                radial-gradient(2px 2px at 8% 88%, #fff, transparent);
            opacity: 0.9;
        }

        .tehran-popup-moon {
            position: absolute;
            top: 20px;
            left: 25px;
            font-size: 50px;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.8);
        }

        .tehran-popup-content {
            position: relative;
            z-index: 2;
            padding: 70px 28px 28px;
            color: #f0e0c0;
            text-align: center;
        }

        .tehran-popup-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ffd700, #ff8c00);
            color: #1a1a3e;
            padding: 5px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 14px;
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
        }

        .tehran-popup-title {
            font-size: 1.8rem;
            font-weight: 900;
            color: #ffd700;
            margin-bottom: 10px;
            text-shadow: 0 0 15px rgba(255, 215, 0, 0.6);
            letter-spacing: 0.5px;
        }

        .tehran-popup-subtitle {
            font-size: 0.9rem;
            color: #d4c4a8;
            line-height: 1.9;
            margin-bottom: 22px;
            padding: 0 5px;
        }

        .tehran-popup-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            background: linear-gradient(135deg, #ffd700 0%, #ff8c00 100%);
            color: #1a1a3e;
            text-decoration: none;
            font-weight: 900;
            font-size: 1rem;
            padding: 14px 24px;
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }

        .tehran-popup-btn:hover {
            transform: scale(1.03);
            color: #1a1a3e;
            text-decoration: none;
            box-shadow: 0 12px 30px rgba(255, 215, 0, 0.65);
        }

        .btn-icon {
            font-size: 1.1rem;
        }

        .tehran-popup-later {
            background: transparent;
            border: none;
            color: #a09080;
            font-size: 0.85rem;
            margin-top: 12px;
            cursor: pointer;
            text-decoration: underline;
            transition: color 0.3s;
        }

        .tehran-popup-later:hover {
            color: #ffd700;
        }

        .tehran-popup-footer {
            margin-top: 18px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 215, 0, 0.15);
            font-size: 11px;
            color: #a09080;
        }

        @media (max-width: 480px) {
            .tehran-popup-content {
                padding: 65px 20px 22px;
            }
            .tehran-popup-title {
                font-size: 1.5rem;
            }
            .tehran-popup-subtitle {
                font-size: 0.85rem;
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
         

            <div class="container mt-4">
                <div class="row" style="margin-top: 50px;">

                    <div class="col-12 col-md-9 order-1 order-md-1">
                        <div class="card article-card">
                            <h1 class="d-flex justify-content-center mt-4 p-2 text-center"><?= $row['title'] ?></h1>
                            <img class="img-fluid" src="../<?= $row['images'] ?>" alt="<?= htmlspecialchars($row['title']) . ' - تصویر مقاله' ?>">
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

                                <div class="alert text-center mt-4" style="background-color: #f7e6f4; border-color: #621e52; color: #621e52;" role="alert">
                                    <h4 class="alert-heading" style="font-family: 'estedad', sans-serif !important;">جهت کسب اطلاعات بیشتر و شرکت در دوره‌ها با ما در ارتباط باشید:</h4>
                                    <p class="mb-0 h4">تلفن: 021-91300517 | واتساپ: 093554637055</p>
                                    <hr>
                                    <a href="../register.php" class="btn sidebar-btn">ثبت نام در دوره‌ها</a>
                                </div>

                            </div>
                        </div>

                        <!-- ============================================ -->
                        <!-- ✅ بخش کامنت‌ها -->
                        <!-- ============================================ -->
                        <div class="comments-section">
                            <h3 class="comments-title">
                                💬 نظرات شما
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
                                                placeholder="نظر خود را درباره این مقاله بنویسید..." required></textarea>
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
                                <a href="../courses/course.php?slug=دوبله+پیشرفته" class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-microphone-alt"></i> دوره دوبله پیشرفته</a>
                                <a href="../courses/course.php?slug=فن+بیان+و+گویندگی+کودکان" class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-child"></i> دوره گویندگی و فن بیان کودکان</a>
                                <a href="../courses/course.php?slug=موشن+گرافیک" class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-pen-nib"></i> موشن گرافیک</a>
                                <a href="../courses/course.php?slug=تدوین+فیلم" class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-film"></i> تدوین فیلم</a>
                                <a href="../courses/course.php?slug=بازیگری+بزرگسال" class="list-group-item list-group-item-action sidebar-item"><i class="fas fa-theater-masks"></i> کلاس بازیگری</a>
                                
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


    <!-- ============================================ -->
    <!-- 🌙 پاپ‌آپ شب‌های تهران -->
    <!-- ============================================ -->
    <div class="tehran-popup-overlay" id="tehranPopupOverlay">
        <div class="tehran-popup">
            <button class="tehran-popup-close" onclick="closeTehranPopup()" aria-label="بستن">✕</button>

            <div class="tehran-popup-bg">
                <div class="tehran-popup-stars"></div>
                <div class="tehran-popup-moon">🌙</div>
            </div>

            <div class="tehran-popup-content">
                <div class="tehran-popup-badge">✨ پیشنهاد ویژه</div>
                <h3 class="tehran-popup-title">شب‌های تهران</h3>
                <p class="tehran-popup-subtitle">
                    دلنوشته‌ها، داستان‌های واقعی و لحظه‌های آرامش‌بخش رو با سریال صوتی ما تجربه کن...
                </p>

                <a href="../radios/tehran.php" class="tehran-popup-btn">
                    <span class="btn-icon">🎧</span>
                    <span>همین حالا گوش بده</span>
                </a>

                <button class="tehran-popup-later" onclick="closeTehranPopup()">
                    بعداً
                </button>

                <div class="tehran-popup-footer">
                    🎵 پخش آنلاین • رایگان برای اعضا
                </div>
            </div>
        </div>
    </div>


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
            "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !1);
        }();
    </script>

    <script>
        // ============================================
        // 🌙 پاپ‌آپ شب‌های تهران
        // ============================================
        (function() {
            var POPUP_KEY = 'tehran_popup_seen_v1';
            var SHOW_DELAY = 5000;                    // ۵ ثانیه
            var HIDE_DURATION = 24 * 60 * 60 * 1000;  // ۲۴ ساعت

            // اگه قبلاً دیده، نشون نده
            var lastSeen = localStorage.getItem(POPUP_KEY);
            if (lastSeen && (Date.now() - parseInt(lastSeen)) < HIDE_DURATION) {
                return;
            }

            // بعد از ۵ ثانیه نشون بده
            setTimeout(function() {
                var overlay = document.getElementById('tehranPopupOverlay');
                if (overlay) {
                    overlay.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }, SHOW_DELAY);

            // تابع بستن
            window.closeTehranPopup = function() {
                var overlay = document.getElementById('tehranPopupOverlay');
                if (overlay) {
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                    localStorage.setItem(POPUP_KEY, Date.now().toString());
                }
            };

            // بستن با کلیک روی overlay (بیرون پاپ‌آپ)
            document.addEventListener('click', function(e) {
                if (e.target && e.target.id === 'tehranPopupOverlay') {
                    window.closeTehranPopup();
                }
            });

            // بستن با دکمه Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    window.closeTehranPopup();
                }
            });
        })();
    </script>

</body>

</html>