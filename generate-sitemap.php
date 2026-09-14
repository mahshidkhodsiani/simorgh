<?php
require 'vendor/autoload.php';
include 'config.php'; // فایل اتصال به دیتابیس که متغیر $conn در آن است

use samdark\sitemap\Sitemap;

// تنظیم مسیر خروجی (دقیقاً در پوشه simorgh)
$sitemapPath = __DIR__ . '/sitemap.xml';
$sitemap = new Sitemap($sitemapPath);

$baseUrl = 'https://simorghtv.com';

// 1. صفحه اصلی سایت
$sitemap->addItem($baseUrl . '/', time(), Sitemap::DAILY, 1.0);

// 2. صفحات اصلی بخش‌ها (ایندکس‌ها)
$sitemap->addItem($baseUrl . '/radios/', time(), Sitemap::WEEKLY, 0.9);
$sitemap->addItem($baseUrl . '/articles/', time(), Sitemap::DAILY, 0.9);
$sitemap->addItem($baseUrl . '/packages/', time(), Sitemap::DAILY, 0.9);

// 3. صفحات ثابت رادیو
$sitemap->addItem($baseUrl . '/radios/radio_simorgh.php', time(), Sitemap::WEEKLY, 0.8);
$sitemap->addItem($baseUrl . '/radios/tehran.php', time(), Sitemap::WEEKLY, 0.8);
$sitemap->addItem($baseUrl . '/radios/cafe_meh.php', time(), Sitemap::WEEKLY, 0.8);

// 4. دریافت و افزودن مقالات از دیتابیس
$articlesQuery = "SELECT slug, created_at, updated_at FROM articles";
$articlesResult = $conn->query($articlesQuery);

if ($articlesResult && $articlesResult->num_rows > 0) {
    while ($row = $articlesResult->fetch_assoc()) {
        // انکود کردن نامک فارسی برای جلوگیری از خطای XML
        $slug = urlencode($row['slug']);
        $url = $baseUrl . '/articles/article?slug=' . $slug;
        
        // اولویت با تاریخ آپدیت است، اگر نبود تاریخ ساخت
        $date = !empty($row['updated_at']) ? $row['updated_at'] : $row['created_at'];
        $lastModified = $date ? strtotime($date) : time();

        $sitemap->addItem($url, $lastModified, Sitemap::WEEKLY, 0.7);
    }
}

// 5. دریافت و افزودن پکیج‌ها از دیتابیس
$packagesQuery = "SELECT id FROM packages ORDER BY id DESC";
$packagesResult = $conn->query($packagesQuery);

if ($packagesResult && $packagesResult->num_rows > 0) {
    while ($row = $packagesResult->fetch_assoc()) {
        $url = $baseUrl . '/packages/package.php?id=' . $row['id'];
        
        // چون در جدول packages فیلد تاریخ ندارید، زمان حال را در نظر می‌گیریم
        $sitemap->addItem($url, time(), Sitemap::WEEKLY, 0.8);
    }
}

// تولید و ذخیره فایل XML
$sitemap->write();

echo 'Sitemap generated successfully!';
?>
