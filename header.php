<style>
.social-icon img {
    transition: transform 0.3s, filter 0.3s;
}

.social-icon:hover img,
.social-icon:focus img {
    transform: scale(1.2);
    filter: hue-rotate(120deg);
}

.social-icon:active img {
    transform: scale(1.3);
    filter: hue-rotate(180deg);
}

/* Ensure the navbar and menu items are laid out in a row */
.site-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.site-navigation {
    display: flex;
    flex: 1;
}

.site-menu.main-menu {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
}

.site-menu.main-menu li {
    margin-left: 20px;
}

.site-menu.main-menu li.has-children {
    position: relative;
}

.site-menu.main-menu li.has-children .dropdown {
    display: none;
}

.site-menu.main-menu li.has-children:hover .dropdown {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.site-menu.main-menu li.has-children .dropdown li {
    padding: 10px;
}

.site-logo {
    margin-left: auto;
}

.toggle-button {
    display: none;
}

.btn-outline-quarternary {
    color: #621e52;
    background-color: transparent;
    border-color: #621e52;
}

.btn-outline-quarternary:hover {
    color: #fff;
    background-color: #621e52;
    border-color: #621e52;
}

.welcome-text {
    color: #d9534f;
    font-size: 14px;
    font-family: "BNaznnBd" !important;
    left: 0;
    font-weight: bold;
    margin-bottom: 10px;
}

.workshop-text {
    color: #d9534f;
    font-size: 22px;
    text-align: right;
    font-family: "BNaznnBd" !important;
    font-weight: bold;
}

li {
    font-weight: bold;
    font-size: 14px;
}

.cart-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    padding: 5px 8px;
    border-radius: 50%;
    background-color: #d9534f;
    color: white;
    font-size: 12px;
    font-weight: bold;
}

/* ========================================= */
/* ===== حالت موبایل (max-width: 991px) ===== */
/* ========================================= */
@media (max-width: 991px) {

    /* مخفی کردن منوی دسکتاپ */
    .site-menu.main-menu {
        display: none !important;
    }

    /* دکمه همبرگری */
    .toggle-button {
        display: inline-block;
        font-size: 1.5rem;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f8f8f8;
    }

    /* ===== منوی کلون شده در offcanvas ===== */
    .site-mobile-menu .site-nav-wrap {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .site-mobile-menu .site-nav-wrap li {
        display: block;
        position: relative;
        width: 100%;
    }

    .site-mobile-menu .site-nav-wrap li a {
        padding: 12px 20px;
        display: block;
        color: #212529;
        border-bottom: 1px solid #f0f0f0;
        font-weight: bold;
        text-decoration: none;
    }

    .site-mobile-menu .site-nav-wrap li a:hover {
        color: #007bff;
        background: #f8f9fa;
    }

    /* ===== زیرمنوها در موبایل ===== */
    .site-mobile-menu .site-nav-wrap li ul.dropdown,
    .site-mobile-menu .site-nav-wrap li ul.collapse {
        padding: 0;
        margin: 0;
        list-style: none;
        background: #f9f9f9;
        position: static;
        box-shadow: none;
        border: none;
        display: none;
    }

    .site-mobile-menu .site-nav-wrap li ul.dropdown.show,
    .site-mobile-menu .site-nav-wrap li ul.collapse.show {
        display: block !important;
    }

    .site-mobile-menu .site-nav-wrap li ul li a {
        padding: 10px 40px;
        font-size: 13px;
        font-weight: normal;
        border-bottom: 1px solid #eee;
    }

    /* ===== فلش باز/بسته شدن ===== */
    .site-mobile-menu .arrow-collapse {
        position: absolute;
        right: 15px;
        top: 12px;
        width: 30px;
        height: 30px;
        text-align: center;
        cursor: pointer;
        z-index: 20;
        border-radius: 50%;
        line-height: 30px;
        transition: transform 0.3s;
        background: transparent;
    }

    .site-mobile-menu .arrow-collapse:before {
        content: "▼";
        font-size: 10px;
        color: #666;
        display: inline-block;
        transition: transform 0.3s;
    }

    .site-mobile-menu .arrow-collapse.active:before {
        transform: rotate(180deg);
    }

    .site-mobile-menu .arrow-collapse:hover {
        background: #e9ecef;
    }
}
</style>

<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<h5 style="text-align: center; background-color: #b55a5a;"> به موسسه سینمایی سیمرغ خوش آمدید </h5>

<header class="site-navbar js-sticky-header site-navbar-target" role="banner">
    <nav class="site-navigation text-right ml-auto" role="navigation" aria-label="breadcrumb">
        <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
            <li><a href="./" class="nav-link">صفحه اصلی</a></li>
            <li><a href="articles/about" class="nav-link">درباره موسسه</a></li>

            <li class="has-children">
                <a href="articles/order_ads">سفارش تبلیغات</a>
                <ul class="dropdown arrow-top">
                    <li><a href="articles/motion_graphics" class="nav-link">موشن گرافیک</a></li>
                    <li><a href="articles/teaser" class="nav-link">تیزر ویدیویی</a></li>
                    <li><a href="articles/cinema" class="nav-link">سه بعدی و سینما فوری</a></li>
                    <li><a href="articles/chromakey" class="nav-link">کروماکی و تولید محتوا</a></li>
                </ul>
            </li>

            <li class="has-children">
                <a href="courses">دوره های آموزشی</a>
                <ul class="dropdown arrow-top">
                    <?php
                    include 'config.php';

                    $sql = "SELECT * FROM courses WHERE show_header = 1 ORDER BY id DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($course = $result->fetch_assoc()) {
                            echo '<li><a href="courses/course.php?slug=' . urlencode($course['slug']) . '" class="nav-link">' . htmlspecialchars($course['title']) . '</a></li>';
                        }
                    }
                    ?>
                    <li><a href="register2" class="nav-link">پرداخت اقساطی دوره ها *</a></li>
                    <li><a href="pardakht" class="nav-link">پرداخت به موسسه</a></li>
                </ul>
            </li>

            <li class="has-children">
                <a href="#">نمونه کارها</a>
                <ul class="dropdown arrow-top">
                    <li><a href="portofilo/pictures" class="nav-link">گالری عکس</a></li>
                    <li><a href="portofilo/videos" class="nav-link">ویدیوها</a></li>
                </ul>
            </li>

            <li><a href="articles" class="nav-link">وبلاگ سیمرغ</a></li>
            <li><a href="packages" class="nav-link">پکیج ها</a></li>
            <li><a href="login" style="font-weight: bold !important;">ورود/ ثبت نام</a></li>

            <li>
                <a href="temp_cart.php" class="nav-link" style="position: relative;">
                    <i class="fas fa-shopping-cart"></i>
                    سبد خرید
                    <?php
                    $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                    if ($cart_count > 0) {
                        echo '<span class="cart-badge">' . $cart_count . '</span>';
                    }
                    ?>
                </a>
            </li>
        </ul>
    </nav>

    <div class="toggle-button d-inline-block d-lg-none">
        <a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black">
            <span class="icon-menu h3"></span>
        </a>
    </div>

    <div class="dropdown">
        <button class="btn btn-outline-quarternary dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            ارتباط با ما
        </button>
        <ul class="dropdown-menu">
            <a href="tel:+982191300517" target="_blank" class="ml-3 call-link social-icon"
                style="color:black !important"><img src="images/call.png" height="20px" width="20px"
                    alt="Call Icon"></a>
            <a href="tel:300016343000" class="ml-3 call-link social-icon" target="_blank"><img src="images/sms.png"
                    height="25px" width="25px" alt="Call Icon"></a>
            <a href="https://wa.me/+989354637055" class="ml-3 call-link social-icon" target="_blank"><img
                    src="images/whatsapp.png" height="30px" width="30px" alt="Call Icon"></a>
            <a href="https://t.me/+989354637055" class="ml-3 call-link social-icon" target="_blank"><img
                    src="images/telegram.png" height="30px" width="30px" alt="Call Icon"></a>
            <a href="https://www.instagram.com/haft_simorgh/" class="ml-3 call-link social-icon" target="_blank"><img
                    src="images/instagram.png" height="25px" width="25px" alt="Call Icon"></a>
            <a href="mailto:info@simorghtv.com" class="ml-3 call-link social-icon" target="_blank"><img
                    src="images/email.png" height="30px" width="30px" alt="Call Icon"></a>
        </ul>
    </div>

    <div class="">
        <a href="./">
            <img src="images/logo1.png" height="60px">
        </a>
    </div>
</header>

<!-- ===== اسکریپت مخصوص زیرمنوهای موبایل ===== -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // فقط در حالت موبایل
    function isMobile() {
        return window.innerWidth <= 991;
    }

    // مدیریت کلیک روی فلش‌های باز/بسته کردن زیرمنو
    document.addEventListener('click', function (e) {
        var arrow = e.target.closest('.arrow-collapse');
        if (!arrow) return;

        e.preventDefault();
        e.stopPropagation();

        var $li = arrow.closest('li.has-children');
        if (!$li) return;

        var $submenu = $li.querySelector('ul.dropdown, ul.collapse');
        if (!$submenu) return;

        // بستن سایر زیرمنوهای باز
        document.querySelectorAll('.site-mobile-menu li.has-children ul.show').forEach(function (ul) {
            if (ul !== $submenu) {
                ul.classList.remove('show');
                ul.style.display = 'none';
                var otherArrow = ul.closest('li').querySelector('.arrow-collapse');
                if (otherArrow) otherArrow.classList.remove('active');
            }
        });

        // باز/بسته کردن زیرمنوی فعلی
        if ($submenu.classList.contains('show')) {
            $submenu.classList.remove('show');
            $submenu.style.display = 'none';
            arrow.classList.remove('active');
        } else {
            $submenu.classList.add('show');
            $submenu.style.display = 'block';
            arrow.classList.add('active');
        }
    });

    // جلوگیری از بسته شدن منو وقتی روی لینک‌های داخل زیرمنو کلیک می‌شود
    document.addEventListener('click', function (e) {
        var link = e.target.closest('.site-mobile-menu .site-nav-wrap li ul li a');
        if (link) {
            // اجازه بده لینک به مقصد برود
            return;
        }
    });

});
</script>