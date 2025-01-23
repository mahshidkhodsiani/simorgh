<link href="https://fonts.googleapis.com/css2?family=Titr:wght@400;700&display=swap" rel="stylesheet">


<style>
.social-icon img {
    transition: transform 0.3s, filter 0.3s;
}

.social-icon:hover img, .social-icon:focus img {
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
    margin-left: 20px; /* Adjust spacing between menu items */
}

.site-menu.main-menu li.has-children {
    position: relative;
}

.site-menu.main-menu li.has-children .dropdown {
    display: none; /* Hide dropdowns by default */
}

.site-menu.main-menu li.has-children:hover .dropdown {
    display: block; /* Show dropdown on hover */
    position: absolute;
    top: 100%;
    left: 0;
    background: white; /* Background color for dropdown */
    border: 1px solid #ddd; /* Border for dropdown */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for dropdown */
}

.site-menu.main-menu li.has-children .dropdown li {
    padding: 10px;
}

.site-logo {
    margin-left: auto; /* Push the logo to the far right */
}

/* Ensure the toggle button is visible on smaller screens */
.toggle-button {
    display: none;
}

/* Show toggle button on small screens */
@media (max-width: 991px) {
    .toggle-button {
        display: inline-block;
    }
    .site-menu.main-menu {
        display: none; /* Hide menu items */
    }
    .site-menu.main-menu.js-clone-nav {
        display: block; /* Show menu items in mobile view */
        flex-direction: column;
        position: absolute;
        top: 60px; /* Adjust as needed */
        right: 0;
        background: white;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .site-menu.main-menu li {
        margin: 0; /* Remove margin for mobile view */
    }
    .site-menu.main-menu li a {
        padding: 10px; /* Adjust padding for mobile view */
        display: block;
    }
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


/* Style for the welcome message */
.welcome-text {
    color: #d9534f; /* A soft red color */
    font-size: 14px; /* Larger font size for prominence */
    font-family: "B Titr"  !important; 
    left: 0;
    font-weight: bold; /* Make the font bold */
    margin-bottom: 10px; /* Add space below the paragraph */
}

/* Style for the workshop message */
.workshop-text {
    color: #d9534f; /* Match the color with the welcome text */
    font-size: 22px; /* Slightly smaller font size */
    text-align: right;
    font-family: "B Titr"  !important; 
    font-weight: bold; /* Regular font weight */
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


<h5 style="text-align: center; background-color : #c71f1f ">** به موسسه فرهنگی هنری هفت هنر سیمرغ خوش آمدید **</h5>





<header class="site-navbar js-sticky-header site-navbar-target" role="banner">

                    
        <nav class="site-navigation text-right ml-auto" role="navigation" aria-label="breadcrumb">
            <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block">
                <li><a href="./" class="nav-link">صفحه اصلی</a></li>
                <!-- <li><a href="articles/index.php?title=درباره موسسه" class="nav-link">درباره موسسه</a></li> -->
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
                        // فرض بر این است که اتصال به دیتابیس در اینجا برقرار شده است (با استفاده از $conn)
                        include 'config.php'; // فایل کانفیگ که اتصال به دیتابیس را شامل می‌شود.

                        // پرس و جو برای دریافت دوره‌های آموزشی که show_header = 1 دارند.
                        $sql = "SELECT * FROM courses WHERE show_header = 1";
                        $result = $conn->query($sql);

                        
                       // چک کردن اینکه آیا نتایج در دیتابیس وجود دارند
                        if ($result->num_rows > 0) {
                            // نمایش هر دوره آموزشی
                            while($course = $result->fetch_assoc()) {
                                // درست کردن لینک برای صفحه دوره
                                echo '<li><a href="courses/course.php?slug=' . urlencode($course['slug']) . '" class="nav-link">' . htmlspecialchars($course['title']) . '</a></li>';
                            }
                        }

                        

                        ?>
                        <li class="has-children">
                            <a href="">فن بیان و گویندگی</a>
                            <ul class="dropdown">
                            <li><a href="courses/radio_announcer_course">دوره تخصصی گویندگی رادیو</a></li>
                            <li><a href="courses/children_speech_course">فن بیان و گویندگی کودکان</a></li>
                            <li><a href="courses/speaking_training_course">دوره آموزشی فن بیان و گویندگی</a></li>
                            <li><a href="courses/show_radio_course">دوره آموزشی نمایش رادیویی</a></li>
                            </ul>
                        </li>
                     
                        <li class="has-children">
                            <a href="">بازیگری</a>
                            <ul class="dropdown">
                            <li><a href="courses/acting1">بازیگری بزرگسال</a></li>
                            <li><a href="courses/acting2">بازیگری کودک</a></li>
                            </ul>
                        </li>
                       
                        <li><a href="courses/motion_graphics" class="nav-link">موشن گرافیک</a></li>
                        <li><a href="#faq-section" class="nav-link">عکاسی</a></li>
                        <li><a href="courses/dubbing" class="nav-link">دوبله</a></li>
                        <li><a href="courses/animation" class="nav-link">انیمیشن سازی</a></li>
                        <li><a href="courses/makeup" class="nav-link">گریم سینمایی</a></li>
                        <li><a href="courses/directing" class="nav-link">کارگردانی</a></li>
                        <li><a href="courses/edit_film" class="nav-link">تدوین و ادیت فیلم</a></li>
                        <li><a href="courses/workshop" class="nav-link">ورکشاپ</a></li>
                        <li><a href="register2" class="nav-link">پرداخت اقساطی دوره ها *</a></li>
                        <li><a href="pardakht" class="nav-link">پرداخت به موسسه</a></li>
                    </ul>
                </li>

                <!-- <li class="has-children">
                    <a href="#">پکیج های آموزشی</a>
                    <ul class="dropdown arrow-top">
                        <li><a href="#pricing-section" class="nav-link">موشن گرافیک</a></li>
                        <li><a href="#faq-section" class="nav-link">فن بیان</a></li>
                        <li><a href="#faq-section" class="nav-link">انیمیشن سازی</a></li>
                        <li><a href="#faq-section" class="nav-link">تدوین فیلم</a></li>
                        <li><a href="#faq-section" class="nav-link">فوتوشاپ</a></li>
                        
                    </ul>
                </li> -->


              
                <li><a href="articles/suggestion" class="nav-link">انتقادات و پیشنهادات</a></li>
                <!-- <li><a href="gallery/all" class="nav-link">نمونه کارها(گالری)</a></li> -->

                <li class="has-children">
                    <a href="#">نمونه کارها</a>
                    <ul class="dropdown arrow-top">
                        <li><a href="portofilo/pictures" class="nav-link">گالری عکس</a></li>
                        <li><a href="portofilo/videos" class="nav-link">ویدیوها</a></li>
                    </ul>
                </li>

                <li><a href="articles" class="nav-link">وبلاگ سیمرغ</a></li>
                <!-- <li><a href="gallery/all" class="nav-link">پرداخت اقساطی دوره ها</a></li> -->

                <li><a href="register" class="btn mb-2 mb-md-0 btn-danger btn-block btn-sm">ثبت نام</a></li>

                     
              
            </ul>
       

        </nav>

              


        <div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
       

        <div class="dropdown">
            <button class="btn btn-outline-quarternary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                ارتباط با ما
            </button>
            <ul class="dropdown-menu">
            <a href="tel:+989354637055" target="_blank" class="ml-3 call-link social-icon" style="color:black !important"><img src="images/call.png" height="20px" width="20px" alt="Call Icon"></a>
            <a href="tel:300016343000" class="ml-3 call-link social-icon" target="_blank"><img src="images/sms.png" height="25px" width="25px" alt="Call Icon"></a>
            <a href="https://wa.me/+989354637055" class="ml-3 call-link social-icon" target="_blank"><img src="images/whatsapp.png" height="30px" width="30px" alt="Call Icon"></a>
            <a href="https://t.me/+989354637055" class="ml-3 call-link social-icon" target="_blank"><img src="images/telegram.png" height="30px" width="30px" alt="Call Icon"></a>
            <a href="https://www.instagram.com/haft_simorgh/" class="ml-3 call-link social-icon" target="_blank"><img src="images/instagram.png" height="25px" width="25px" alt="Call Icon"></a>
            <a href="mailto:info@simorghtv.com" class="ml-3 call-link social-icon" target="_blank"><img src="images/email.png" height="30px" width="30px" alt="Call Icon"></a>
            
            </ul>
        </div>




        

        <div class="">
            <a href="./" >
                <img src="images/logo1.png" height="60px">
            </a>
        </div>


</header>