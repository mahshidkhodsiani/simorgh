<?php
session_start();

// اگر کاربر وارد نشده است، به صفحه لاگین هدایت شود
if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

// فرض می‌کنیم کد ملی کاربر در session['all_data'] ذخیره شده است
$user_meli_code = $_SESSION['all_data']['meli_code'];
$user_name = $_SESSION['all_data']['name'] . ' ' . $_SESSION['all_data']['family'];

include '../config.php';

// استفاده از Prepared Statement برای جلوگیری از SQL Injection
// اطلاعات دوره های کاربر را بر اساس کد ملی او از جدول contacts دریافت می کنیم
$stmt_courses = $conn->prepare("SELECT * FROM contacts WHERE meli_code = ? ORDER BY created_at DESC");
$stmt_courses->bind_param("s", $user_meli_code);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();

// ایجاد آرایه ای برای ذخیره نتایج
$enrolled_courses = [];
if ($result_courses->num_rows > 0) {
    while ($row = $result_courses->fetch_assoc()) {
        $enrolled_courses[] = $row;
    }
}
$stmt_courses->close();
$conn->close();

// محاسبه آمار
$total_courses = count($enrolled_courses);
$paid_courses = 0;
$total_amount = 0;

foreach ($enrolled_courses as $course) {
    if ($course['pardakht'] == 1) {
        $paid_courses++;
    }
    $total_amount += $course['amount'];
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره‌های من</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
    /* استایل‌های اختصاصی صفحه دوره‌های من */
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 20px 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid #e3e6f0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .stats-card .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 12px;
    }

    .stats-card .stats-icon.blue {
        background: rgba(78, 115, 223, 0.1);
        color: #4e73df;
    }

    .stats-card .stats-icon.green {
        background: rgba(56, 161, 105, 0.1);
        color: #38a169;
    }

    .stats-card .stats-icon.orange {
        background: rgba(237, 137, 54, 0.1);
        color: #ed8936;
    }

    .stats-card .stats-icon.purple {
        background: rgba(118, 75, 162, 0.1);
        color: #764ba2;
    }

    .stats-card .stats-number {
        font-size: 28px;
        font-weight: 700;
        color: #2d3748;
    }

    .stats-card .stats-label {
        font-size: 14px;
        color: #858796;
        font-weight: 500;
    }

    .card-courses {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .card-courses .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 18px 25px;
        border: none;
    }

    .card-courses .card-header h6 {
        color: white;
        font-weight: 600;
    }

    .card-courses .card-header h6 i {
        margin-left: 10px;
    }

    .card-courses .card-body {
        padding: 25px;
    }

    .course-table {
        border-radius: 12px;
        overflow: hidden;
    }

    .course-table thead {
        background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
    }

    .course-table thead th {
        font-weight: 600;
        color: #2d3748;
        border-bottom: 2px solid #e3e6f0;
        padding: 15px 20px;
        font-size: 14px;
        text-align: center;
    }

    .course-table tbody td {
        padding: 15px 20px;
        vertical-align: middle;
        text-align: center;
        font-size: 14px;
    }

    .course-table tbody tr {
        transition: all 0.2s ease;
    }

    .course-table tbody tr:hover {
        background: #f8f9fc;
    }

    .status-badge {
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    .status-badge.paid {
        background: rgba(56, 161, 105, 0.15);
        color: #38a169;
    }

    .status-badge.pending {
        background: rgba(237, 137, 54, 0.15);
        color: #ed8936;
    }

    .status-badge.cancelled {
        background: rgba(229, 62, 62, 0.15);
        color: #e53e3e;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state .empty-icon {
        font-size: 80px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #2d3748;
        font-weight: 600;
    }

    .empty-state p {
        color: #858796;
        max-width: 400px;
        margin: 10px auto 20px;
    }

    .course-number {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        border-radius: 50%;
        background: #e9ecef;
        color: #2d3748;
        font-weight: 600;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .stats-card {
            padding: 15px 20px;
        }

        .stats-card .stats-number {
            font-size: 22px;
        }

        .card-courses .card-body {
            padding: 15px;
        }

        .course-table thead th,
        .course-table tbody td {
            padding: 10px 12px;
            font-size: 12px;
        }

        .status-badge {
            padding: 4px 12px;
            font-size: 11px;
        }

        .table-responsive {
            font-size: 12px;
        }
    }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include 'header.php'; ?>

        <div class="container-fluid py-4">
            <!-- هدر صفحه -->
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="bi bi-book me-2 text-primary"></i>دوره‌های من
                    </h1>
                    <p class="text-muted mb-0">
                        <i class="bi bi-person me-1"></i>
                        <?php echo htmlspecialchars($user_name); ?>
                        <span class="mx-2">•</span>
                        <i class="bi bi-clock me-1"></i>
                        <?php echo count($enrolled_courses); ?> دوره ثبت‌نام شده
                    </p>
                </div>

            </div>

            <!-- کارت‌های آمار -->
            <div class="row g-4 mb-4">
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-icon blue">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="stats-number"><?php echo $total_courses; ?></div>
                        <div class="stats-label">تعداد کل دوره‌ها</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="stats-number"><?php echo $paid_courses; ?></div>
                        <div class="stats-label">دوره‌های پرداخت شده</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-icon orange">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="stats-number"><?php echo $total_courses - $paid_courses; ?></div>
                        <div class="stats-label">در انتظار پرداخت</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-card">
                        <div class="stats-icon purple">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="stats-number"><?php echo number_format($total_amount); ?></div>
                        <div class="stats-label">مجموع مبلغ (تومان)</div>
                    </div>
                </div>
            </div>

            <!-- جدول دوره‌ها -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-courses shadow">
                        <div class="card-header">
                            <h6 class="m-0">
                                <i class="bi bi-list-ul"></i>
                                لیست دوره‌های ثبت‌نام شده
                                <?php if ($total_courses > 0): ?>
                                <span class="badge bg-light text-dark ms-2 rounded-pill">
                                    <?php echo $total_courses; ?>
                                </span>
                                <?php endif; ?>
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if ($total_courses > 0): ?>
                            <div class="table-responsive">
                                <table class="table course-table">
                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>نام دوره</th>
                                            <th>مبلغ</th>
                                            <th>وضعیت پرداخت</th>
                                            <th>تاریخ ثبت‌نام</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 1; ?>
                                        <?php foreach ($enrolled_courses as $course): ?>
                                        <tr>
                                            <td>
                                                <span class="course-number"><?php echo $counter++; ?></span>
                                            </td>
                                            <td class="fw-500">
                                                <?php echo htmlspecialchars($course['course']); ?>
                                            </td>
                                            <td>
                                                <span class="fw-600 text-dark">
                                                    <?php echo number_format($course['amount']); ?>
                                                </span>
                                                <small class="text-muted">تومان</small>
                                            </td>
                                            <td>
                                                <?php if ($course['pardakht'] == 1): ?>
                                                <span class="status-badge paid">
                                                    <i class="bi bi-check-circle-fill me-1"></i>
                                                    پرداخت شده
                                                </span>
                                                <?php else: ?>
                                                <span class="status-badge pending">
                                                    <i class="bi bi-clock-fill me-1"></i>
                                                    در انتظار پرداخت
                                                </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <i class="bi bi-calendar3 me-1 text-muted"></i>
                                                <?php echo htmlspecialchars($course['created_at']); ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- خلاصه پایین جدول -->
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <div>
                                    <span class="text-muted small">
                                        <i class="bi bi-info-circle me-1"></i>
                                        نمایش <?php echo $total_courses; ?> دوره
                                    </span>
                                </div>
                                <div>
                                    <span class="text-muted small">
                                        آخرین به‌روزرسانی: <?php echo date('Y/m/d H:i'); ?>
                                    </span>
                                </div>
                            </div>

                            <?php else: ?>
                            <!-- حالت خالی -->
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-book"></i>
                                </div>
                                <h5>هنوز در هیچ دوره‌ای ثبت‌نام نکرده‌اید!</h5>
                                <p class="text-muted">
                                    برای شروع یادگیری، از بین دوره‌های موجود یکی را انتخاب کنید.
                                </p>
                                <a href="../courses.php" class="btn btn-primary bg-gradient px-5"
                                    style="border-radius: 10px;">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    مشاهده دوره‌ها
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <script>
    // تاگل سایدبار
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
        });
    }

    // Highlight rows with pending payment
    document.querySelectorAll('.status-badge.pending').forEach(badge => {
        const row = badge.closest('tr');
        if (row) {
            row.style.borderRight = '3px solid #ed8936';
        }
    });

    // نمایش پیام خوش‌آمدگویی با SweetAlert
    <?php if ($total_courses > 0): ?>
    // فقط در اولین بازدید
    <?php endif; ?>
    </script>
</body>

</html>