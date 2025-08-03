<?php
// gallery_data.php

// اتصال به پایگاه داده
// فرض می‌شود فایل config.php حاوی اطلاعات اتصال به پایگاه داده است
include '../config.php';

// کوئری برای گرفتن تمامی تصاویر از جدول gallery
// تصاویر بر اساس id به صورت نزولی مرتب شده‌اند (جدیدترین تصاویر در ابتدا)
$sql = "SELECT * FROM gallery ORDER BY id DESC";
$result = $conn->query($sql);

$images = array();
if ($result->num_rows > 0) {
    // گرفتن هر سطر به عنوان یک آرایه انجمنی (associative array)
    while ($row = $result->fetch_assoc()) {
        $images[] = $row;
    }
}

// تنظیم هدر (Header) برای پاسخ JSON
// این کار به مرورگر می‌گوید که محتوای ارسالی، یک فایل JSON است
header('Content-Type: application/json');

// تبدیل آرایه تصاویر به یک رشته JSON و ارسال آن به عنوان خروجی
echo json_encode($images);

// بستن اتصال به پایگاه داده
$conn->close();
