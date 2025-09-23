<?php
// این کد را در بالای فایل header.php قرار دهید تا سشن را شروع و اطلاعات کاربر را دریافت کند
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_name = 'کاربر';
$user_family = '';
$user_image = 'https://via.placeholder.com/40';

// اگر اطلاعات کاربر در سشن موجود باشد، از آنها استفاده کن
if (isset($_SESSION['all_data'])) {
    $user_name = $_SESSION['all_data']['name'];
    $user_family = $_SESSION['all_data']['family'];
    // فرض می‌کنیم مسیر تصویر پروفایل نیز در سشن ذخیره شده است
    if (isset($_SESSION['all_data']['profile_image'])) {
        $user_image = $_SESSION['all_data']['profile_image'];
    }
}

// نمایش تاریخ امروز به صورت شمسی
function gregorian_to_jalali($gy, $gm, $gd, $mod = '')
{
    $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
    $gy2 = ($gy > 959) ? 1600 : 0;
    $gm2 = ($gm > 2) ? $gm - 2 : $gm + 10;
    $gd2 = $gd + (($gm > 2) ? $g_d_m[$gm - 3] : $g_d_m[$gm + 9] + (30 * 24 + 10));
    $g_day_no = 365 * ($gy - $gy2) + ($gd2 - 1) + intval(($gy - $gy2 + 3) / 4) - intval(($gy - $gy2 + 99) / 100) + intval(($gy - $gy2 + 399) / 400);
    $j_day_no = $g_day_no - 79;
    $j_np = intval($j_day_no / 12053);
    $j_day_no %= 12053;
    $j_4y = intval($j_day_no / 1461);
    $j_day_no %= 1461;
    $j_day_no2 = ($j_day_no > 365) ? $j_day_no - 1 : $j_day_no;
    $jm_no = intval($j_day_no2 / 31);
    $j_d = ($j_day_no2 % 31) + 1;
    $jy = 979 + (33 * $j_np) + (4 * $j_4y) + intval($j_day_no / 365);
    $jm = $jm_no + 1;
    if ($jm_no == 12 && $j_day_no > 365) {
        $jm_no = 13;
        $j_d = 0;
    }
    $jm_d = array(0, 31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
    $jm_d2 = array(0, 31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 30);
    if ($jm_no == 13) {
        $jm = 12;
        $j_d = $j_day_no - 365;
    }
    if ($jm > 12) {
        $jy++;
        $jm = 1;
    }
    if ($j_d > $jm_d[$jm]) {
        $j_d = $j_d - $jm_d[$jm];
        $jm++;
    }
    if ($mod == '') {
        return "$jy/$jm/$j_d";
    } elseif ($mod == 'array') {
        return array($jy, $jm, $j_d);
    } else {
        return "$jy/$jm/$j_d";
    }
}

include "../PersianCalendar.php";

?>

<nav class="navbar navbar-expand topbar mb-4 static-top shadow-sm bg-white">
    <div class="container-fluid">
        <button id="sidebarToggle" class="btn btn-link d-md-none rounded-circle me-3">
            <i class="bi bi-list fs-4"></i>
        </button>


        <h6 style="margin-left: 20px;">امروز : <?php echo mds_date("l j F Y ", time(), 0); ?></h6>


        <ul class="navbar-nav ms-auto">
            <div class="d-none d-sm-block topbar-divider"></div>
        </ul>

        <ul>
            <a href="../index.php" class="d-flex align-items-center text-decoration-none">
                <img src="../images/logo1.png" alt="Logo" style="height: 60px; margin-right: 60px;">
            </a>
        </ul>

        <ul class="navbar-nav me-auto">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-none d-lg-inline text-gray-600 small me-2"><?php echo htmlspecialchars($user_name . ' ' . $user_family); ?></span>
                    <!-- <img class="img-profile rounded-circle" src="<?php echo htmlspecialchars($user_image); ?>" alt="Profile Picture"> -->
                </a>
                <ul class="dropdown-menu dropdown-menu-start shadow animated--grow-in" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2 text-gray-400"></i> ویرایش پروفایل</a></li>
                    <li><a class="dropdown-item" href="my_courses.php"><i class="bi bi-book me-2 text-gray-400"></i> دوره‌های من</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-left me-2 text-gray-400"></i> خروج</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>