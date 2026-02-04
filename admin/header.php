<?php
// اطمینان از دسترسی به متغیر اتصال به دیتابیس
if (!isset($conn)) {
    include '../config.php';
}

// محاسبه تعداد تیکت‌های در انتظار پاسخ (جدید)
$sql_unread = "SELECT COUNT(*) as unread_count FROM tickets WHERE status = 'pending'";
$result_unread = $conn->query($sql_unread);
$unread_count = 0;
if ($result_unread) {
    $unread_data = $result_unread->fetch_assoc();
    $unread_count = $unread_data['unread_count'];
}
?>

<header class="navbar sticky-top flex-md-nowrap p-0 shadow" style="background-color: #3e3838;">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 d-flex align-items-center" href="../">
        <img src="../images/logo1.png" height="50px" class="me-2">
        <h3 style="color: white;" class="mb-0">موسسه هفت هنر سیمرغ</h3>
    </a>

    <?php
    // استفاده از فایل تقویم جلالی که در پروژه داشتید
    if (file_exists('../PersianCalendar.php')) {
        include '../PersianCalendar.php';
    }
    ?>

    <div style="display: flex; align-items: center; justify-content: space-between; color: white; padding: 10px;">

        <div class="notification-bell me-4" style="position: relative; cursor: pointer;"
            onclick="location.href='admin_tickets.php?status=pending'">
            <i class="fas fa-bell" style="font-size: 1.5rem; color: #ffc107;"></i>
            <?php if ($unread_count > 0): ?>
            <span style="
                    position: absolute;
                    top: -8px;
                    right: -10px;
                    background-color: #dc3545;
                    color: white;
                    border-radius: 50%;
                    padding: 2px 7px;
                    font-size: 11px;
                    font-weight: bold;
                    border: 2px solid #3e3838;
                    line-height: 1;
                ">
                <?= $unread_count ?>
            </span>
            <?php endif; ?>
        </div>

        <h6 style="margin-left: 20px; margin-bottom: 0;">
            امروز: <?php echo mds_date("l j F Y", time(), 0); ?>
        </h6>

        <a href="logout.php" class="btn btn-outline-light btn-sm ms-3">خروج</a>
    </div>
</header>

<style>
.notification-bell:hover i {
    color: #fff !important;
    transition: 0.3s;
}
</style>