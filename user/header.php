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
    <div class="container-fluid d-flex align-items-center">

        <!-- بخش چپ: دکمه منو + لوگو -->
        <div class="d-flex align-items-center">
            <!-- دکمه منوی موبایل -->
            <button id="sidebarToggle" class="btn btn-link d-md-none rounded-circle me-2">
                <i class="bi bi-list fs-4"></i>
            </button>

            <!-- لوگو -->
            <a href="../index.php" class="d-flex align-items-center text-decoration-none">
                <img src="../images/logo1.png" alt="Logo" style="height: 45px;">
            </a>
        </div>

        <!-- بخش وسط: تاریخ - فقط در دسکتاپ نمایش داده شود -->
        <h6 class="d-none d-lg-block mb-0 mx-4 text-nowrap flex-grow-1">
            امروز : <?php echo mds_date("l j F Y ", time(), 0); ?>
        </h6>

        <!-- بخش راست: منوی کاربری (همیشه در انتها قرار می‌گیرد) -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="d-none d-sm-inline text-gray-600 small me-2">
                        <?php echo htmlspecialchars($user_name . ' ' . $user_family); ?>
                    </span>
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                        style="width: 35px; height: 35px; font-weight: bold; font-size: 14px;">
                        <?php echo mb_substr($user_name, 0, 1); ?>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-start shadow animated--grow-in" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2 text-gray-400"></i>
                            ویرایش پروفایل</a></li>
                    <li><a class="dropdown-item" href="my_courses.php"><i class="bi bi-book me-2 text-gray-400"></i>
                            دوره‌های من</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../logout.php"><i
                                class="bi bi-box-arrow-left me-2 text-gray-400"></i> خروج</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<style>
/* استایل‌های ریسپانسیو برای هدر */
.topbar {
    position: sticky;
    top: 0;
    z-index: 1030;
    background: #fff !important;
    padding: 8px 0;
    min-height: 70px;
    border-bottom: 1px solid #e3e6f0;
}

.topbar .container-fluid {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: nowrap;
    gap: 10px;
    padding: 0 20px;
}

/* تنظیمات موبایل */
@media (max-width: 767.98px) {
    .topbar .container-fluid {
        gap: 5px;
        padding: 0 10px;
    }

    .topbar img {
        height: 35px !important;
    }

    #sidebarToggle {
        padding: 5px 8px;
        font-size: 1.3rem;
    }

    .topbar .dropdown-menu {
        position: absolute !important;
        right: 0 !important;
        left: auto !important;
        min-width: 180px;
    }

    .topbar .navbar-nav .nav-link {
        padding: 0.3rem 0.5rem;
    }

    /* مخفی کردن نام کاربر در موبایل‌های خیلی کوچک */
    @media (max-width: 575.98px) {
        .topbar .d-none.d-sm-inline {
            display: none !important;
        }
    }
}

/* تنظیمات تبلت */
@media (min-width: 768px) and (max-width: 991.98px) {
    .topbar .container-fluid {
        gap: 15px;
    }

    /* مخفی کردن تاریخ در تبلت */
    .topbar h6.d-none.d-lg-block {
        display: none !important;
    }
}

/* دکمه هامبورگر */
#sidebarToggle {
    color: #4e73df;
    border: none;
    background: transparent;
    transition: all 0.3s ease;
    padding: 8px 10px;
    line-height: 1;
}

#sidebarToggle:hover {
    background: rgba(78, 115, 223, 0.1);
    border-radius: 50%;
}

#sidebarToggle:focus {
    box-shadow: none;
}

/* آواتار کاربر */
.topbar .rounded-circle.bg-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    box-shadow: 0 2px 8px rgba(78, 115, 223, 0.3);
    flex-shrink: 0;
}

/* آیتم‌های دراپ‌داون */
.topbar .dropdown-item {
    padding: 8px 20px;
    transition: all 0.2s ease;
    font-size: 14px;
}

.topbar .dropdown-item:hover {
    background: #f8f9fc;
    color: #4e73df;
}

.topbar .dropdown-item i {
    width: 20px;
    text-align: center;
}

.topbar .dropdown-menu {
    border: none;
    border-radius: 10px;
    padding: 8px 0;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.topbar .dropdown-divider {
    margin: 5px 0;
}

/* لوگو */
.topbar a img {
    transition: all 0.3s ease;
}

.topbar a img:hover {
    transform: scale(1.05);
}

/* تاریخ */
.topbar h6 {
    color: #5a5c69;
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 0.3px;
}

/* نام کاربر */
.topbar .text-gray-600 {
    color: #5a5c69 !important;
    font-weight: 500;
}
</style>