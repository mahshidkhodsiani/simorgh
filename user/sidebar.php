<?php
// دریافت نام فایل فعلی (مثلاً 'index.php' یا 'documents.php')
$current_page_name = basename($_SERVER['PHP_SELF']);

// برای مقایسه راحت‌تر، پسوند .php را حذف می‌کنیم
$current_page = rtrim($current_page_name, '.php');

?>
<div class="sidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text mx-3">پنل مدیریت</div>
    </a>

    <hr class="sidebar-divider my-0">

    <ul class="nav flex-column">
        <li class="nav-item <?php echo ($current_page == 'index') ? 'active' : ''; ?>">
            <a class="nav-link" href="./">
                <i class="bi bi-house-door"></i>
                <span>داشبورد</span>
            </a>
        </li>

        <li class="nav-item <?php echo ($current_page == 'documents') ? 'active' : ''; ?>">
            <a class="nav-link" href="documents">
                <i class="bi bi-people"></i>
                <span>تکمیل مدارک</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($current_page == 'edit_profile.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="edit_profile">
                <i class="bi bi-people"></i>
                <span>ادیت پروفایل</span>
            </a>
        </li>
    </ul>
</div>