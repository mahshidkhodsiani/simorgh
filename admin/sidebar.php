<style>
    /* Sidebar base */
    .sidebar {
        width: 240px;
        background: linear-gradient(180deg, #2c3e50, #34495e);
        position: fixed;
        right: 0;
        top: 0;
        height: 100%;
        overflow-y: auto;
        padding-top: 10px;
        box-shadow: -3px 0 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    /* Sidebar header (user info) */
    .sidebar h5 {
        font-size: 18px;
        color: #ecf0f1;
        text-align: center;
        padding: 18px 12px;
        margin: 0;
        background: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Sidebar links */
    .sidebar a,
    .dropdown-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        color: #ecf0f1;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        border-radius: 6px;
        margin: 4px 8px;
    }

    .sidebar a i,
    .dropdown-btn i {
        width: 20px;
        text-align: center;
    }

    /* Active & Hover state */
    .sidebar a.active,
    .sidebar a:hover,
    .dropdown-btn:hover {
        background: #b85ed6ff;
        color: #fff;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.2);
    }

    /* Dropdown container */
    .dropdown-container {
        display: none;
        flex-direction: column;
        margin: 0 10px;
        padding-left: 10px;
        border-left: 2px solid rgba(255, 255, 255, 0.15);
        animation: slideDown 0.3s ease;
    }

    .dropdown-container.show {
        display: flex;
    }

    /* Dropdown animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Content */
    div.content {
        margin-right: 240px;
        padding: 20px;
        background: #fdfdfd;
        min-height: 100vh;
        transition: margin-right 0.3s ease;
    }

    /* Scrollbar styling */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    /* Mobile styles */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
            transform: translateX(100%);
            z-index: 1000;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        div.content {
            margin-right: 0;
        }

        /* Add a backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-backdrop.show {
            display: block;
        }

        .sidebar-toggle {
            position: fixed;
            top: 15px;
            right: 15px;
            background: #b85ed6ff;
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 6px;
            z-index: 1100;
            cursor: pointer;
            font-size: 16px;
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<div class="sidebar" id="sidebar">
    <h5><?= $_SESSION['all_data']['name'] . " " . $_SESSION['all_data']['family'] ?></h5>

    <a href="index" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'index') echo 'active'; ?>">
        <i class="fas fa-home"></i> صفحه اول
    </a>
    <a href="code_takhfif" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'code_takhfif') echo 'active'; ?>">
        <i class="fas fa-tags"></i> وارد کردن کد تخفیف
    </a>
    <a href="new_matlab" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'new_matlab') echo 'active'; ?>">
        <i class="fas fa-book-open"></i> افزودن مطلب و دوره
    </a>

    <a href="javascript:void(0);" class="dropdown-btn">
        <i class="fas fa-briefcase"></i> افزودن نمونه کار جدید
    </a>
    <div class="dropdown-container">
        <a href="new_pic" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'new_pic') echo 'active'; ?>">
            <i class="fas fa-images"></i> گالری عکس
        </a>
        <a href="new_video" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'new_video') echo 'active'; ?>">
            <i class="fas fa-video"></i> ویدیوی جدید
        </a>
    </div>

    <a href="new_article" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'new_article') echo 'active'; ?>">
        <i class="fas fa-file-alt"></i> افزودن مقاله جدید
    </a>
    <a href="new_radio" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'new_radio') echo 'active'; ?>">
        <i class="fas fa-podcast"></i> افزودن رادیو
    </a>
    <a href="new_speaker" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'new_speaker') echo 'active'; ?>">
        <i class="fas fa-microphone-alt"></i> افزودن گوینده
    </a>
    <a href="new_user" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'new_user') echo 'active'; ?>">
        <i class="fas fa-users"></i> مدیریت یوزرها
    </a>
    <a href="suggests" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'suggests') echo 'active'; ?>">
        <i class="fas fa-lightbulb"></i> پیشنهادات
    </a>
    <a href="registered" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'registered') echo 'active'; ?>">
        <i class="fas fa-clipboard-list"></i> اطلاعات ثبت نامی
    </a>
    <a href="sounds" class="<?php if (basename($_SERVER['REQUEST_URI']) === 'sounds') echo 'active'; ?>">
        <i class="fas fa-music"></i> صداهای ارسالی
    </a>
</div>

<div class="sidebar-backdrop" id="sidebar-backdrop"></div>
<button class="sidebar-toggle" id="sidebar-toggle">☰</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown toggle
        document.querySelectorAll('.dropdown-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                this.nextElementSibling.classList.toggle('show');
            });
        });

        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const toggleBtn = document.getElementById('sidebar-toggle');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            backdrop.classList.toggle('show');
        });

        backdrop.addEventListener('click', () => {
            sidebar.classList.remove('active');
            backdrop.classList.remove('show');
        });
    });
</script>