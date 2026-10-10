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

    li {
        font-weight: 600;
        font-size: 14px;
    }

    /* ========================================= */
    /* ===== حالت موبایل (max-width: 991px) ===== */
    /* ========================================= */
    @media (max-width: 991px) {

        .toggle-button {
            display: inline-block;
            font-size: 2.5rem;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
        }

        .site-menu.main-menu {
            display: none;
        }

        .site-menu.main-menu.js-clone-nav {
            display: block;
            flex-direction: column;
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .site-menu.main-menu li {
            margin: 0;
        }

        .site-menu.main-menu li a {
            padding: 10px;
            display: block;
        }

        /* ===== زیرمنوها در منوی موبایل (کلون شده) ===== */
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
        .site-mobile-menu .site-nav-wrap li.has-children {
            position: relative;
        }

        .site-mobile-menu .arrow-collapse {
            position: absolute;
            left: 15px;
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


<header class="site-navbar js-sticky-header site-navbar-target" role="banner">

    <nav class="site-navigation text-right ml-auto" role="navigation">
        <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
            <li><a href="../" class="nav-link">صفحه اصلی</a></li>
            <li><a href="../articles/about" class="nav-link">درباره موسسه</a></li>

            <li class="has-children">
                <a href="../articles/about">سفارش تبلیغات</a>
                <ul class="dropdown arrow-top">
                    <li><a href="../articles/motion_graphics" class="nav-link">موشن گرافیک</a></li>
                    <li><a href="../articles/teaser" class="nav-link">تیزر ویدیویی</a></li>
                    <li><a href="../articles/cinema" class="nav-link">سه بعدی و سینما فوری</a></li>
                    <li><a href="../articles/chromakey" class="nav-link">کروماکی و تولید محتوا</a></li>
                </ul>
            </li>

            <li class="has-children">
                <a href="#">دوره های آموزشی</a>
                <ul class="dropdown arrow-top">
                    <?php
                    include '../config.php';

                    $sql = "SELECT * FROM courses WHERE show_header = 1 ORDER BY id DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($course = $result->fetch_assoc()) {
                            echo '<li><a href="course.php?slug=' . urlencode($course['slug']) . '" class="nav-link">' . htmlspecialchars($course['title']) . '</a></li>';
                        }
                    }
                    ?>

                    <li><a href="../register2" class="nav-link">پرداخت اقساطی دوره ها *</a></li>
                    <li><a href="../pardakht" class="nav-link">پرداخت به موسسه</a></li>
                </ul>
            </li>

            <li><a href="../articles/speakers_archive" class="nav-link">کانون گویندگان</a></li>

            <li class="has-children">
                <a href="#">نمونه کارها</a>
                <ul class="dropdown arrow-top">
                    <li><a href="../portofilo/pictures" class="nav-link">گالری عکس</a></li>
                    <li><a href="../portofilo/videos" class="nav-link">ویدیوها</a></li>
                </ul>
            </li>

            <li><a href="../articles" class="nav-link">وبلاگ سیمرغ</a></li>
            <li><a href="../packages" class="nav-link">پکیج ها</a></li>
            <li><a href="../login" style="font-weight: bold !important;">ورود/ ثبت نام</a></li>
        </ul>
    </nav>

    <div class="toggle-button d-inline-block d-lg-none">
        <a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black">
            <span class="icon-menu h3"></span>
        </a>
    </div>

    <div class="dropdown">
        <button class="btn btn-outline-quarternary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            ارتباط با ما
        </button>
        <ul class="dropdown-menu">
            <a href="tel:+982191300517" target="_blank" class="ml-3 call-link social-icon" style="color:black !important"><img src="../images/call.png" height="20px" width="20px" alt="Call Icon"></a>
            <a href="tel:300016343000" class="ml-3 call-link social-icon" target="_blank"><img src="../images/sms.png" height="25px" width="25px" alt="Call Icon"></a>
            <a href="https://wa.me/+989354637055" class="ml-3 call-link social-icon" target="_blank"><img src="../images/whatsapp.png" height="30px" width="30px" alt="Call Icon"></a>
            <a href="https://t.me/+989354637055" class="ml-3 call-link social-icon" target="_blank"><img src="../images/telegram.png" height="30px" width="30px" alt="Call Icon"></a>
            <a href="https://www.instagram.com/haft_simorgh/" class="ml-3 call-link social-icon" target="_blank"><img src="../images/instagram.png" height="25px" width="25px" alt="Call Icon"></a>
            <a href="mailto:info@simorghtv.com" class="ml-3 call-link social-icon" target="_blank"><img src="../images/email.png" height="30px" width="30px" alt="Call Icon"></a>
        </ul>
    </div>

    <div class="">
        <a href="../">
            <img src="../images/logo1.png" height="60px">
        </a>
    </div>

</header>

<!-- ===== اسکریپت مخصوص زیرمنوهای موبایل ===== -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== اضافه کردن فلش به زیرمنوهای منوی موبایل =====
    function addArrowsToMobileMenu() {
        var mobileBody = document.querySelector('.site-mobile-menu-body');
        if (!mobileBody) return;

        var items = mobileBody.querySelectorAll('li.has-children');
        items.forEach(function (li) {
            if (li.querySelector(':scope > .arrow-collapse')) return;

            var arrow = document.createElement('span');
            arrow.className = 'arrow-collapse';
            li.insertBefore(arrow, li.firstChild);
        });
    }

    // چند بار با تاخیر اجرا میشه چون اسکریپت تم، منو رو کلون میکنه
    setTimeout(addArrowsToMobileMenu, 300);
    setTimeout(addArrowsToMobileMenu, 800);
    setTimeout(addArrowsToMobileMenu, 1500);
    setTimeout(addArrowsToMobileMenu, 2500);

    // ===== مدیریت کلیک روی فلشها =====
    document.addEventListener('click', function (e) {
        var arrow = e.target.closest('.arrow-collapse');
        if (!arrow) return;

        if (window.innerWidth > 991) return;

        e.preventDefault();
        e.stopPropagation();

        var li = arrow.closest('li.has-children');
        if (!li) return;

        var submenu = li.querySelector('ul.dropdown, ul.collapse');
        if (!submenu) return;

        // بستن سایر زیرمنوهای باز
        document.querySelectorAll('.site-mobile-menu li.has-children ul.show').forEach(function (ul) {
            if (ul !== submenu) {
                ul.classList.remove('show');
                ul.style.display = 'none';
                var otherArrow = ul.closest('li').querySelector('.arrow-collapse');
                if (otherArrow) otherArrow.classList.remove('active');
            }
        });

        // باز/بسته کردن زیرمنوی فعلی
        if (submenu.classList.contains('show')) {
            submenu.classList.remove('show');
            submenu.style.display = 'none';
            arrow.classList.remove('active');
        } else {
            submenu.classList.add('show');
            submenu.style.display = 'block';
            arrow.classList.add('active');
        }
    });

});
</script>