<?php
session_start();

// اگر کاربر وارد نشده است، به صفحه لاگین هدایت شود
if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

// تعریف همه متغیرها در ابتدا
$user_id = $_SESSION['all_data']['id'] ?? 0;
$username = $_SESSION['all_data']['username'] ?? 'کاربر';
$user_name = $_SESSION['all_data']['name'] ?? '';
$user_family = $_SESSION['all_data']['family'] ?? '';
$full_name = trim($user_name . ' ' . $user_family);

// اگر نام کامل خالی است از username استفاده کن
if (empty($full_name)) {
    $full_name = $username;
}

include '../config.php';

// تعریف آرایه stats با مقادیر پیش‌فرض
$stats = [
    'courses' => 0,
    'paid_courses' => 0,
    'tickets' => 0,
    'cart_items' => 0,
    'total_spent' => 0,
    'pending_tickets' => 0
];

// دریافت آمار کاربر - با try/catch برای جلوگیری از خطا
try {
    // بررسی وجود جدول contacts
    $check_table = $conn->query("SHOW TABLES LIKE 'contacts'");
    if ($check_table->num_rows > 0) {
        // تعداد دوره‌ها
        $stmt = $conn->prepare("SELECT COUNT(*) as total, SUM(pardakht) as paid FROM contacts WHERE meli_code = (SELECT meli_code FROM users WHERE id = ?)");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $stats['courses'] = $row['total'] ?? 0;
                $stats['paid_courses'] = $row['paid'] ?? 0;
            }
            $stmt->close();
        }
    }

    // بررسی وجود جدول tickets
    $check_table = $conn->query("SHOW TABLES LIKE 'tickets'");
    if ($check_table->num_rows > 0) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending FROM tickets WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $stats['tickets'] = $row['total'] ?? 0;
                $stats['pending_tickets'] = $row['pending'] ?? 0;
            }
            $stmt->close();
        }
    }

    // بررسی وجود جدول user_cart
    $check_table = $conn->query("SHOW TABLES LIKE 'user_cart'");
    if ($check_table->num_rows > 0) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM user_cart WHERE user_id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $stats['cart_items'] = $row['total'] ?? 0;
            }
            $stmt->close();
        }
    }

    // مجموع پرداختی‌ها
    $check_table = $conn->query("SHOW TABLES LIKE 'contacts'");
    if ($check_table->num_rows > 0) {
        $stmt = $conn->prepare("SELECT SUM(amount) as total FROM contacts WHERE meli_code = (SELECT meli_code FROM users WHERE id = ?) AND pardakht = 1");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $stats['total_spent'] = $row['total'] ?? 0;
            }
            $stmt->close();
        }
    }
} catch (Exception $e) {
    // در صورت خطا، stats با مقادیر پیش‌فرض باقی می‌ماند
}

// فعالیت‌های اخیر
$recent_activities = [];

try {
    $check_table = $conn->query("SHOW TABLES LIKE 'contacts'");
    if ($check_table->num_rows > 0) {
        $stmt = $conn->prepare("SELECT course, created_at, pardakht FROM contacts WHERE meli_code = (SELECT meli_code FROM users WHERE id = ?) ORDER BY created_at DESC LIMIT 3");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $recent_activities[] = [
                    'type' => 'course',
                    'title' => $row['course'] ?? 'بدون عنوان',
                    'date' => $row['created_at'] ?? date('Y-m-d H:i:s'),
                    'status' => ($row['pardakht'] ?? 0) == 1 ? 'پرداخت شده' : 'در انتظار پرداخت',
                    'icon' => ($row['pardakht'] ?? 0) == 1 ? 'bi-check-circle-fill text-success' : 'bi-clock-fill text-warning'
                ];
            }
            $stmt->close();
        }
    }
} catch (Exception $e) {
    // در صورت خطا، recent_activities خالی می‌ماند
}

$conn->close();

// تابع برای نمایش تاریخ (در صورت وجود mds_date)
function show_date() {
    if (function_exists('mds_date')) {
        return mds_date("l j F Y", time(), 0);
    }
    return date('Y/m/d');
}

function show_time() {
    if (function_exists('mds_date')) {
        return mds_date("H:i", time(), 0);
    }
    return date('H:i');
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد کاربری</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 30px 35px;
        color: white;
        border: none;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
    }

    .welcome-card .welcome-content {
        position: relative;
        z-index: 1;
    }

    .welcome-card .welcome-greeting {
        font-size: 14px;
        opacity: 0.8;
        font-weight: 400;
    }

    .welcome-card .welcome-name {
        font-size: 28px;
        font-weight: 700;
        margin: 5px 0 10px;
    }

    .welcome-card .welcome-text {
        font-size: 15px;
        opacity: 0.9;
        max-width: 500px;
    }

    .welcome-card .welcome-date {
        font-size: 13px;
        opacity: 0.7;
        margin-top: 10px;
    }

    .welcome-card .welcome-icon {
        position: absolute;
        left: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 80px;
        opacity: 0.15;
        z-index: 0;
    }

    .stats-card {
        background: white;
        border-radius: 14px;
        padding: 20px 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid #f0f2f7;
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .stats-card .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .stats-card:hover .stats-icon {
        transform: scale(1.05);
    }

    .stats-card .stats-icon.blue {
        background: rgba(78, 115, 223, 0.12);
        color: #4e73df;
    }

    .stats-card .stats-icon.green {
        background: rgba(56, 161, 105, 0.12);
        color: #38a169;
    }

    .stats-card .stats-icon.orange {
        background: rgba(237, 137, 54, 0.12);
        color: #ed8936;
    }

    .stats-card .stats-icon.purple {
        background: rgba(118, 75, 162, 0.12);
        color: #764ba2;
    }

    .stats-card .stats-number {
        font-size: 26px;
        font-weight: 700;
        color: #2d3748;
        line-height: 1.2;
    }

    .stats-card .stats-label {
        font-size: 14px;
        color: #858796;
        font-weight: 500;
        margin-top: 2px;
    }

    .stats-card .stats-link {
        font-size: 13px;
        color: #4e73df;
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 8px;
        transition: all 0.2s ease;
    }

    .stats-card .stats-link:hover {
        color: #2e59d9;
        gap: 10px;
    }

    .stats-card .stats-link i {
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .stats-card .stats-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        font-size: 11px;
        padding: 3px 12px;
        border-radius: 20px;
        font-weight: 600;
    }

    .card-dashboard {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .card-dashboard .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 16px 25px;
        border: none;
    }

    .card-dashboard .card-header h6 {
        color: white;
        font-weight: 600;
        margin: 0;
    }

    .card-dashboard .card-header h6 i {
        margin-left: 10px;
    }

    .card-dashboard .card-body {
        padding: 25px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 15px;
        border-radius: 10px;
        background: #f8f9fc;
        transition: all 0.2s ease;
        border-right: 3px solid transparent;
    }

    .activity-item:hover {
        background: #f0f2f7;
        transform: translateX(-3px);
    }

    .activity-item .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        background: white;
        flex-shrink: 0;
    }

    .activity-item .activity-content {
        flex: 1;
        min-width: 0;
    }

    .activity-item .activity-title {
        font-weight: 600;
        color: #2d3748;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .activity-item .activity-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: #858796;
        margin-top: 2px;
        flex-wrap: wrap;
    }

    .activity-item .activity-meta .badge-status {
        font-size: 11px;
        padding: 2px 10px;
        border-radius: 20px;
    }

    .quick-action-btn {
        background: #f8f9fc;
        border: 2px dashed #d1d3e2;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        color: #2d3748;
        height: 100%;
    }

    .quick-action-btn:hover {
        border-color: #4e73df;
        background: #f0f2f7;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        color: #2d3748;
    }

    .quick-action-btn .action-icon {
        font-size: 32px;
        color: #4e73df;
        margin-bottom: 10px;
        display: block;
    }

    .quick-action-btn .action-label {
        font-weight: 600;
        font-size: 14px;
    }

    .quick-action-btn .action-desc {
        font-size: 12px;
        color: #858796;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .welcome-card {
            padding: 20px 25px;
        }

        .welcome-card .welcome-name {
            font-size: 22px;
        }

        .welcome-card .welcome-icon {
            font-size: 50px;
            left: 15px;
        }

        .stats-card {
            padding: 15px 20px;
        }

        .stats-card .stats-number {
            font-size: 20px;
        }

        .card-dashboard .card-body {
            padding: 18px;
        }

        .activity-item {
            padding: 10px 12px;
        }

        .quick-action-btn {
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .welcome-card .welcome-icon {
            display: none;
        }

        .stats-card .stats-badge {
            display: none;
        }
    }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include 'header.php'; ?>

        <div class="container-fluid py-4">

            <!-- کارت خوش‌آمدگویی -->
            <div class="welcome-card mb-4">
                <div class="welcome-content">
                    <div class="welcome-greeting">
                        <i class="bi bi-hand-index-thumb me-2"></i>
                        خوش آمدید
                    </div>
                    <div class="welcome-name">
                        <?php echo htmlspecialchars($full_name); ?>
                    </div>
                    <div class="welcome-text">
                        به پنل کاربری خود خوش آمدید. از اینجا می‌توانید دوره‌های خود را مدیریت کنید، تیکت‌های پشتیبانی
                        را پیگیری کنید و اطلاعات شخصی خود را بروزرسانی نمایید.
                    </div>
                    <div class="welcome-date">
                        <i class="bi bi-calendar3 me-1"></i>
                        <?php echo show_date(); ?>
                        <span class="mx-2">•</span>
                        <i class="bi bi-clock me-1"></i>
                        <?php echo show_time(); ?>
                    </div>
                </div>
                <div class="welcome-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
            </div>

            <!-- کارت‌های آمار -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="stats-card">
                        <span class="stats-badge bg-primary text-white">دوره‌ها</span>
                        <div class="stats-icon blue">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="stats-number"><?php echo $stats['courses']; ?></div>
                        <div class="stats-label">دوره ثبت‌نام شده</div>
                        <a href="my_courses.php" class="stats-link">
                            مشاهده دوره‌ها
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="stats-card">
                        <span class="stats-badge bg-success text-white">پرداخت‌ها</span>
                        <div class="stats-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stats-number"><?php echo $stats['paid_courses']; ?></div>
                        <div class="stats-label">دوره پرداخت شده</div>
                        <a href="my_courses.php?filter=paid" class="stats-link">
                            مشاهده جزئیات
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="stats-card">
                        <span class="stats-badge bg-warning text-dark">تیکت‌ها</span>
                        <div class="stats-icon orange">
                            <i class="bi bi-ticket"></i>
                        </div>
                        <div class="stats-number"><?php echo $stats['tickets']; ?></div>
                        <div class="stats-label">تیکت ثبت شده</div>
                        <?php if ($stats['pending_tickets'] > 0): ?>
                        <div style="font-size:12px; color:#ed8936; margin-top:2px;">
                            <i class="bi bi-clock me-1"></i>
                            <?php echo $stats['pending_tickets']; ?> در انتظار پاسخ
                        </div>
                        <?php endif; ?>
                        <a href="tickets.php" class="stats-link">
                            مدیریت تیکت‌ها
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="stats-card">
                        <span class="stats-badge bg-purple text-white">سبد خرید</span>
                        <div class="stats-icon purple">
                            <i class="bi bi-cart"></i>
                        </div>
                        <div class="stats-number"><?php echo $stats['cart_items']; ?></div>
                        <div class="stats-label">آیتم در سبد خرید</div>
                        <?php if ($stats['cart_items'] > 0): ?>
                        <div style="font-size:12px; color:#38a169; margin-top:2px;">
                            <i class="bi bi-check-circle me-1"></i>
                            آماده برای پرداخت
                        </div>
                        <?php endif; ?>
                        <a href="user_cart.php" class="stats-link">
                            مشاهده سبد خرید
                            <i class="bi bi-arrow-left"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- بخش اصلی -->
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card card-dashboard shadow h-100">
                        <div class="card-header">
                            <h6>
                                <i class="bi bi-clock-history"></i>
                                فعالیت‌های اخیر
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_activities)): ?>
                            <?php foreach ($recent_activities as $activity): ?>
                            <div class="activity-item mb-2">
                                <div class="activity-icon">
                                    <i class="bi bi-book text-primary"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title"><?php echo htmlspecialchars($activity['title']); ?>
                                    </div>
                                    <div class="activity-meta">
                                        <span>
                                            <i class="bi bi-calendar3 me-1"></i>
                                            <?php echo htmlspecialchars($activity['date']); ?>
                                        </span>
                                        <span
                                            class="badge-status <?php echo $activity['status'] == 'پرداخت شده' ? 'bg-success text-white' : 'bg-warning text-dark'; ?>">
                                            <i class="bi <?php echo $activity['icon']; ?> me-1"></i>
                                            <?php echo $activity['status']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 48px; color: #d1d3e2;"></i>
                                <p class="text-muted mt-2">هنوز فعالیتی ثبت نشده است</p>
                                <a href="../courses.php" class="btn btn-primary bg-gradient px-4"
                                    style="border-radius: 10px;">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    شروع یادگیری
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card card-dashboard shadow h-100">
                        <div class="card-header">
                            <h6>
                                <i class="bi bi-speedometer2"></i>
                                دسترسی سریع
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <a href="my_courses.php" class="quick-action-btn">
                                        <span class="action-icon"><i class="bi bi-book"></i></span>
                                        <span class="action-label">دوره‌های من</span>
                                        <span class="action-desc">مشاهده و مدیریت</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="tickets.php" class="quick-action-btn">
                                        <span class="action-icon"><i class="bi bi-ticket"></i></span>
                                        <span class="action-label">تیکت‌ها</span>
                                        <span class="action-desc">پشتیبانی و پیگیری</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="user_cart.php" class="quick-action-btn">
                                        <span class="action-icon"><i class="bi bi-cart"></i></span>
                                        <span class="action-label">سبد خرید</span>
                                        <span class="action-desc">پرداخت و تسویه</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="documents.php" class="quick-action-btn">
                                        <span class="action-icon"><i class="bi bi-file-earmark-text"></i></span>
                                        <span class="action-label">مدارک</span>
                                        <span class="action-desc">آپلود و تکمیل</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="profile.php" class="quick-action-btn">
                                        <span class="action-icon"><i class="bi bi-person-gear"></i></span>
                                        <span class="action-label">پروفایل</span>
                                        <span class="action-desc">ویرایش اطلاعات</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="my_packages.php" class="quick-action-btn">
                                        <span class="action-icon"><i class="bi bi-box-seam"></i></span>
                                        <span class="action-label">پکیج‌ها</span>
                                        <span class="action-desc">پکیج‌های من</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- اطلاعات حساب -->
            <div class="row g-4 mt-2">
                <div class="col-12">
                    <div class="card card-dashboard shadow">
                        <div class="card-header">
                            <h6>
                                <i class="bi bi-info-circle"></i>
                                اطلاعات حساب کاربری
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3 col-6">
                                    <div class="text-muted small">نام کاربری</div>
                                    <div class="fw-600"><?php echo htmlspecialchars($username); ?></div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-muted small">نام کامل</div>
                                    <div class="fw-600"><?php echo htmlspecialchars($full_name); ?></div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-muted small">تعداد دوره‌ها</div>
                                    <div class="fw-600"><?php echo $stats['courses']; ?> دوره</div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="text-muted small">مجموع پرداختی</div>
                                    <div class="fw-600 text-success">
                                        <?php echo number_format($stats['total_spent']); ?>
                                        <small class="text-muted">تومان</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <script>
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-toggled');
    });

    <?php if (!isset($_SESSION['dashboard_welcome_shown'])): ?>
    <?php $_SESSION['dashboard_welcome_shown'] = true; ?>
    Swal.fire({
        icon: 'success',
        title: 'به پنل کاربری خوش آمدید!',
        text: '<?php echo htmlspecialchars($full_name); ?> عزیز، امیدواریم از خدمات ما راضی باشید.',
        confirmButtonColor: '#667eea',
        confirmButtonText: 'متوجه شدم',
        timer: 4000,
        timerProgressBar: true
    });
    <?php endif; ?>
    </script>

</body>

</html>