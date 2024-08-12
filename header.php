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
    font-family: 'Titr', sans-serif;
    left: 0;
    font-weight: bold; /* Make the font bold */
    margin-bottom: 10px; /* Add space below the paragraph */
}

/* Style for the workshop message */
.workshop-text {
    color: #d9534f; /* Match the color with the welcome text */
    font-size: 22px; /* Slightly smaller font size */
    text-align: right;
    font-family: 'Titr', sans-serif;
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


<div class="top-bar">
    <div class="container">
        <div class="row">
        <div class="col-5">
        

            <div class="float-right">
                <a href="https://wa.me/+989354637055" target="_blank" class="ml-3 social-icon">
                    <img src="images/whatsapp.png" height="20px" width="20px">
                </a>
                <a href="https://t.me/+989354637055" target="_blank" class="ml-3 social-icon">
                    <img src="images/telegram.png" height="25px" width="25px">
                </a>
                <a href="https://www.instagram.com/haft_simorgh/" target="_blank" class="ml-3 social-icon">
                    <img src="images/instagram.png" height="19px" width="19px">
                </a>
                <a href="mailto:sajadnader@yahoo.com" class="ml-2 email-link social-icon">
                    <img src="images/email.png" height="20px" width="20px" alt="Email Icon">
                </a>
                <a href="tel:+989354637055" target="_blank" class="ml-3 call-link social-icon">
                    <img src="images/call.png" height="20px" width="20px" alt="Call Icon">
                </a>
            </div>


           

         

        </div>
        <div class="col-7">
            <p class="welcome-text">به سایت آموزشگاه سینمایی و موسسه هفت هنر سیمرغ خوش آمدید</p>
        </div>


        </div>

    </div>
</div>


<header class="site-navbar js-sticky-header site-navbar-target" role="banner">

    
    
 
    

                    
        <nav class="site-navigation text-right ml-auto" role="navigation">
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
                    <a href="#">دوره های آموزشی</a>
                    <ul class="dropdown arrow-top">
                        
                        <li class="has-children">
                            <a href="#">فن بیان و گویندگی</a>
                            <ul class="dropdown">
                            <li><a href="courses/speaking">مقدماتی</a></li>
                            <li><a href="courses/speaking">پیشرفته</a></li>
                            </ul>
                        </li>
                        <li><a href="courses/short_speaking" class="nav-link">گویندگی کوتاه مدت رادیو</a></li>

                        <li class="has-children">
                            <a href="#">بازیگری</a>
                            <ul class="dropdown">
                            <li><a href="courses/acting">مقدماتی</a></li>
                            <li><a href="courses/acting">پیشرفته</a></li>
                            </ul>
                        </li>
                        <li><a href="#faq-section" class="nav-link">بازیگری کودک</a></li>
                        <li><a href="courses/motion_graphics" class="nav-link">موشن گرافیک</a></li>
                        <li><a href="#faq-section" class="nav-link">عکاسی</a></li>



                        
                        <li class="has-children">
                            <a href="courses/dubbing">دوبله</a>
                            <ul class="dropdown">
                            <li><a href="courses/dubbing">مقدماتی</a></li>
                            <li><a href="courses/dubbing">پیشرفته</a></li>
                            </ul>
                        </li>
                        
                       
                        <li><a href="courses/animation" class="nav-link">انیمیشن سازی</a></li>
                        
                        <li class="has-children">
                            <a href="courses/makeup">گریم سینمایی</a>
                            <ul class="dropdown">
                            <li><a href="courses/makeup">مقدماتی</a></li>
                            <li><a href="courses/makeup">پیشرفته</a></li>
                            </ul>
                        </li>
                        <li><a href="#faq-section" class="nav-link">کارگردانی</a></li>
                        <li><a href="#faq-section" class="nav-link">تدوین فیلم</a></li>
                        <li><a href="#faq-section" class="nav-link">نقاشی</a></li>
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

             
                
             
                <li class="has-children">
                    <a href="#">برنامه های رادیویی</a>
                    <ul class="dropdown arrow-top">
                        <li><a href="#pricing-section" class="nav-link">برنامه های رادیویی</a></li>
                        <li><a href="#faq-section" class="nav-link">پادکست</a></li>
                        <li><a href="#faq-section" class="nav-link">کتاب صوتی</a></li>
                    </ul>
                </li>
              
                <li><a href="articles/suggestion" class="nav-link">انتقادات و پیشنهادات</a></li>

            </ul>
        </nav>
              


        <div class="toggle-button d-inline-block d-lg-none"><a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black"><span class="icon-menu h3"></span></a></div>
       


        <div class="">
            <a href="./" >
                <img src="images/logo1.png" height="60px">
              
            </a>
        </div>


</header>