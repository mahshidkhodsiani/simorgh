<?php
require 'vendor/autoload.php';
include 'config.php'; // اطمینان حاصل کنید مسیر صحیح است

use samdark\sitemap\Sitemap;

// ایجاد نمونه سایت مپ
$sitemap = new Sitemap(__DIR__ . '/sitemap.xml');

// افزودن صفحه اصلی
$sitemap->addItem('https://example.com/', time(), Sitemap::DAILY, 1.0);

// افزودن صفحات ثابت
$sitemap->addItem('https://example.com/about.php');
$sitemap->addItem('https://example.com/contact.php');

// افزودن مطالب از دیتابیس
$result = $conn->query("SELECT id, title, created_at FROM courses WHERE show_header = 1");
while ($row = $result->fetch_assoc()) {
    $url = 'https://example.com/course.php?id=' . $row['id'];
    $lastModified = strtotime($row['created_at']);
    $sitemap->addItem($url, $lastModified, Sitemap::WEEKLY, 0.8);
}

// ذخیره سایت مپ
$sitemap->write();

echo 'Sitemap generated successfully!';
