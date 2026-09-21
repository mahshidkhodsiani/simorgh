<?php
// ==========================================
// Sitemap Generator - بدون نیاز به Composer/vendor
// ==========================================
include 'config.php';

$baseUrl = 'https://simorghtv.com';
$urls = [];

// ==========================================
// اولویت ۱: صفحه اصلی
// ==========================================
$urls[] = [
    'loc' => $baseUrl . '/',
    'lastmod' => date('c'),
    'changefreq' => 'daily',
    'priority' => '1.0'
];

// ==========================================
// اولویت ۲: بخش رادیو (اصلی)
// ==========================================
$urls[] = [
    'loc' => $baseUrl . '/radios/',
    'lastmod' => date('c'),
    'changefreq' => 'daily',
    'priority' => '0.95'
];

// ==========================================
// اولویت ۳: سه رادیوی اصلی
// ==========================================
$urls[] = ['loc' => $baseUrl . '/radios/radio_simorgh.php', 'lastmod' => date('c'), 'changefreq' => 'weekly', 'priority' => '0.9'];
$urls[] = ['loc' => $baseUrl . '/radios/tehran.php',        'lastmod' => date('c'), 'changefreq' => 'weekly', 'priority' => '0.9'];
$urls[] = ['loc' => $baseUrl . '/radios/cafe_meh.php',      'lastmod' => date('c'), 'changefreq' => 'weekly', 'priority' => '0.9'];

// ==========================================
// اولویت ۴: بخش پکیج‌ها (اصلی)
// ==========================================
$urls[] = [
    'loc' => $baseUrl . '/packages/',
    'lastmod' => date('c'),
    'changefreq' => 'daily',
    'priority' => '0.9'
];

// ==========================================
// اولویت ۵: تک‌تک پکیج‌ها
// ==========================================
$packagesQuery = "SELECT id FROM packages ORDER BY id DESC";
$packagesResult = $conn->query($packagesQuery);
$total_packages = 0;

if ($packagesResult && $packagesResult->num_rows > 0) {
    $total_packages = $packagesResult->num_rows;
    while ($row = $packagesResult->fetch_assoc()) {
        $urls[] = [
            'loc' => $baseUrl . '/packages/package.php?id=' . (int)$row['id']
            // بدون lastmod چون فیلد تاریخ نداریم
        ];
    }
}

// ==========================================
// اولویت ۶: بخش مقالات (اصلی)
// ==========================================
$urls[] = [
    'loc' => $baseUrl . '/articles/',
    'lastmod' => date('c'),
    'changefreq' => 'daily',
    'priority' => '0.85'
];

// ==========================================
// اولویت ۷: تک‌تک مقالات
// ==========================================
$articlesQuery = "SELECT slug, created_at, updated_at FROM articles";
$articlesResult = $conn->query($articlesQuery);

if ($articlesResult && $articlesResult->num_rows > 0) {
    while ($row = $articlesResult->fetch_assoc()) {
        // اصلاح مهم: rawurlencode به جای urlencode
        $slug = rawurlencode($row['slug']);

        $date = !empty($row['updated_at']) ? $row['updated_at'] : $row['created_at'];

        // اگه article.php بدون .htaccess باز می‌شه:
        $url = $baseUrl . '/articles/article.php?slug=' . $slug;

        $urls[] = [
            'loc' => $url,
            'lastmod' => $date ? date('c', strtotime($date)) : date('c'),
            'changefreq' => 'weekly',
            'priority' => '0.7'
        ];
    }
}

// ==========================================
// اولویت ۸: دوره‌ها (courses) - جدید
// ==========================================
$coursesQuery = "SELECT slug FROM courses WHERE show_header = 1 ORDER BY id DESC";
$coursesResult = $conn->query($coursesQuery);

if ($coursesResult && $coursesResult->num_rows > 0) {
    while ($row = $coursesResult->fetch_assoc()) {
        $slug = rawurlencode($row['slug']);
        $urls[] = [
            'loc' => $baseUrl . '/courses/course.php?slug=' . $slug,
            'lastmod' => date('c'),
            'changefreq' => 'weekly',
            'priority' => '0.8'
        ];
    }
}

// ==========================================
// اولویت ۹: صفحات ثابت مهم
// ==========================================
$urls[] = ['loc' => $baseUrl . '/articles/about',            'lastmod' => date('c'), 'changefreq' => 'monthly', 'priority' => '0.6'];
$urls[] = ['loc' => $baseUrl . '/articles/speakers_archive', 'lastmod' => date('c'), 'changefreq' => 'weekly',  'priority' => '0.7'];
$urls[] = ['loc' => $baseUrl . '/portofilo/pictures',        'lastmod' => date('c'), 'changefreq' => 'weekly',  'priority' => '0.6'];
$urls[] = ['loc' => $baseUrl . '/portofilo/videos',          'lastmod' => date('c'), 'changefreq' => 'weekly',  'priority' => '0.6'];

// ==========================================
// اولویت ۱۰: پیجینیشن پکیج‌ها
// ==========================================
$limit = 9;
$total_pages = (int)ceil($total_packages / $limit);

for ($p = 2; $p <= $total_pages; $p++) {
    $urls[] = [
        'loc' => $baseUrl . '/packages/?page=' . $p,
        'lastmod' => date('c'),
        'changefreq' => 'weekly',
        'priority' => '0.5'
    ];
}

// ==========================================
// ساخت XML
// ==========================================
$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

foreach ($urls as $u) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>" . htmlspecialchars($u['loc'], ENT_XML1, 'UTF-8') . "</loc>\n";

    if (!empty($u['lastmod'])) {
        $xml .= "    <lastmod>" . $u['lastmod'] . "</lastmod>\n";
    }
    if (!empty($u['changefreq'])) {
        $xml .= "    <changefreq>" . $u['changefreq'] . "</changefreq>\n";
    }
    if (!empty($u['priority'])) {
        $xml .= "    <priority>" . $u['priority'] . "</priority>\n";
    }

    $xml .= "  </url>\n";
}

$xml .= '</urlset>';

// ==========================================
// ذخیره در فایل sitemap.xml
// ==========================================
$sitemapPath = __DIR__ . '/sitemap.xml';
file_put_contents($sitemapPath, $xml);

echo 'Sitemap generated successfully! (' . count($urls) . ' URLs)';
?>