<?php
session_start();
include '../config.php';
include '../PersianCalendar.php';
include '../jalaliDate.php';
$sdate = new SDate();

// ============================================================
// Pagination + دریافت مقالات
// ============================================================
$articlesPerPage = 9;

$countSql = "SELECT COUNT(*) as total FROM articles";
$countResult = $conn->query($countSql);
$totalCount = (int)$countResult->fetch_assoc()['total'];
$totalPages = max(1, (int)ceil($totalCount / $articlesPerPage));

// اعتبارسنجی صفحه
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;
$offset = ($page - 1) * $articlesPerPage;

$sql = "SELECT * FROM articles ORDER BY id DESC LIMIT $offset, $articlesPerPage";
$result = $conn->query($sql);

$articles = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
}

// ============================================================
// SEO: عنوان و توضیحات داینامیک بر اساس صفحه
// ============================================================
$siteName = "وبلاگ سیمرغ";
if ($page == 1) {
    $pageTitle = $siteName . " | مقالات و مطالب آموزشی";
    $pageDescription = "وبلاگ رسمی سیمرغ — جدیدترین مقالات، مطالب آموزشی و اخبار در حوزه گویندگی، رادیو و هنر.";
} else {
    $pageTitle = $siteName . " | صفحه " . $page;
    $pageDescription = "صفحه " . $page . " از " . $totalPages . " — آرشیو مقالات وبلاگ سیمرغ.";
}

// Canonical URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = str_replace('/admin', '', dirname($_SERVER['SCRIPT_NAME']));
$canonicalUrl = $protocol . '://' . $host . $basePath . '/blog' . ($page > 1 ? '?page=' . $page : '');
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== SEO Meta Tags ===== -->
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">

    <!-- ===== Open Graph ===== -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($siteName) ?>">
    <meta property="og:locale" content="fa_IR">

    <!-- ===== Twitter Card ===== -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">

    <!-- ===== Robots (صفحه‌بندی: صفحه ۱ index، بقیه هم index) ===== -->
    <meta name="robots" content="index, follow">

    <!-- ===== Preconnect ===== -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <?php include "includes.php"; ?>

    <style>
    /* ============================================================
       استایل اختصاصی صفحه وبلاگ
       ============================================================ */
    body {
        background-color: #f6f7f9;
    }

    .blog-hero {
        background: linear-gradient(135deg, #1f2d3d 0%, #4a5d73 100%);
        color: #fff;
        padding: 50px 20px;
        text-align: center;
        border-radius: 0 0 20px 20px;
        margin-bottom: 40px;
    }

    .blog-hero h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .blog-hero p {
        font-size: 1.05rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto;
    }

    /* کارت مقاله */
    .article-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #eef0f3;
    }

    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.10);
    }

    .article-card .card-img-wrapper {
        position: relative;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background: #e9ecef;
    }

    .article-card .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .article-card:hover .card-img-wrapper img {
        transform: scale(1.05);
    }

    .article-card .card-body {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .article-card .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1f2d3d;
        margin-bottom: 10px;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .article-card .card-text {
        font-size: 0.9rem;
        color: #5a6773;
        line-height: 1.8;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .article-card .btn-read-more {
        align-self: flex-start;
        font-size: 0.88rem;
        font-weight: 600;
        border-radius: 8px;
        padding: 7px 16px;
        border: 1.5px solid #4a5d73;
        color: #4a5d73;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .article-card .btn-read-more:hover {
        background: #4a5d73;
        color: #fff;
    }

    .article-meta {
        display: flex;
        gap: 12px;
        font-size: 0.78rem;
        color: #8a95a1;
        margin-bottom: 10px;
    }

    .article-meta i {
        margin-left: 3px;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        color: #cbd3da;
        margin-bottom: 20px;
    }

    /* Pagination */
    .pagination .page-link {
        color: #4a5d73;
        border-radius: 8px;
        margin: 0 3px;
        border: 1px solid #dee2e6;
        font-weight: 600;
    }

    .pagination .page-item.active .page-link {
        background-color: #4a5d73;
        border-color: #4a5d73;
    }

    .pagination .page-link:hover {
        background-color: #eef0f3;
        color: #1f2d3d;
    }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<!-- ===== Hero ===== -->
<div class="blog-hero">
    <h1><i class="fas fa-feather-alt me-2"></i>وبلاگ سیمرغ</h1>
    <p>جدیدترین مقالات، مطالب آموزشی و اخبار در حوزه گویندگی، رادیو و هنر</p>
</div>

<!-- ===== لیست مقالات ===== -->
<div class="container mb-5">
    <?php if (!empty($articles)): ?>
        <div class="row g-4">
            <?php foreach ($articles as $article):
                // --- پردازش تصویر ---
                $images = $article['images'] ?? '';
                $imageSrc = '';
                $imageData = json_decode($images, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($imageData)) {
                    $imageSrc = $imageData['thumb'] ?? $imageData['original'] ?? '';
                } else {
                    $imageSrc = $images;
                }
                if (empty($imageSrc)) {
                    $imageSrc = 'assets/img/placeholder.jpg'; // مسیر پیش‌فرض
                }

                // --- توضیحات کوتاه (از meta_description یا body) ---
                $shortDesc = $article['meta_description'] ?? '';
                if (empty($shortDesc)) {
                    $shortDesc = strip_tags($article['body'] ?? '');
                }
                $shortDesc = preg_replace('/\s+/', ' ', trim($shortDesc));
                if (mb_strlen($shortDesc, 'UTF-8') > 140) {
                    $shortDesc = mb_substr($shortDesc, 0, 140, 'UTF-8') . '...';
                }

                // --- لینک مقاله (slug واقعی) ---
                $slug = !empty($article['slug']) ? $article['slug'] : $article['id'];
                $articleUrl = 'article?slug=' . urlencode($slug);
            ?>
            <div class="col-md-6 col-lg-4">
                <article class="article-card">
                    <a href="<?= htmlspecialchars($articleUrl) ?>" class="text-decoration-none">
                        <div class="card-img-wrapper">
                            <img src="../<?= htmlspecialchars($imageSrc) ?>"
                                 alt="<?= htmlspecialchars($article['title']) ?>"
                                 loading="lazy"
                                 width="400" height="225">
                        </div>
                    </a>
                    <div class="card-body">
                        <div class="article-meta">
                            <span><i class="far fa-eye"></i><?= (int)($article['views'] ?? 0) ?> بازدید</span>
                            <?php if (!empty($article['created_at'])): ?>
                                <span><i class="far fa-calendar"></i><?= htmlspecialchars(substr($article['created_at'], 0, 10)) ?></span>
                            <?php endif; ?>
                        </div>
                        <h2 class="card-title">
                            <a href="<?= htmlspecialchars($articleUrl) ?>" class="text-decoration-none text-dark">
                                <?= htmlspecialchars($article['title']) ?>
                            </a>
                        </h2>
                        <p class="card-text"><?= htmlspecialchars($shortDesc) ?></p>
                        <a href="<?= htmlspecialchars($articleUrl) ?>" class="btn-read-more">
                            مطالعه بیشتر <i class="fas fa-arrow-left me-1"></i>
                        </a>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ===== Pagination ===== -->
        <?php if ($totalPages > 1): ?>
        <nav aria-label="صفحه‌بندی مقالات" class="mt-5">
            <ul class="pagination justify-content-center">
                <!-- قبلی -->
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="قبلی">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>

                <!-- شماره‌ها -->
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($totalPages, $startPage + 4);
                if ($endPage - $startPage < 4) {
                    $startPage = max(1, $endPage - 4);
                }
                for ($i = $startPage; $i <= $endPage; $i++):
                ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- بعدی -->
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= min($totalPages, $page + 1) ?>" aria-label="بعدی">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>

    <?php else: ?>
        <div class="empty-state">
            <i class="far fa-newspaper"></i>
            <h3>هنوز مقاله‌ای منتشر نشده</h3>
            <p>به‌زودی مطالب جدیدی در این بخش منتشر خواهد شد.</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<!-- ===== Scripts ===== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>