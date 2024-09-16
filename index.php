<!doctype html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با ارائه دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta name="keywords" content="گویندگی, انیمیشن, طراحی, موسیقی, آموزش گویندگی, دوره‌های گویندگی, موسسه هنری">
    <meta name="author" content="موسسه هفت هنر سیمرغ">
    <meta property="og:title" content="موسسه هفت هنر سیمرغ">
    <meta property="og:description" content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta property="og:image" content="URL-to-your-image.jpg">
    <meta property="og:url" content="https://www.simorghtv.com">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fa_IR">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="موسسه هفت هنر سیمرغ">
    <meta name="twitter:description" content="موسسه هفت هنر سیمرغ، پیشرو در آموزش گویندگی، انیمیشن، طراحی و موسیقی با دوره‌های تخصصی و کارگاه‌های عملی.">
    <meta name="twitter:image" content="URL-to-your-image.jpg">
    <title>هفت هنر سیمرغ</title>

    <link rel="icon" href="/images/logo1.ico" type="image/x-icon">
  
    <?php include "includes.php"; ?>
</head>

  <body>

      <?php
      include "header.php";
      include "config.php";
      include "PersianCalendar.php";
      include "jalaliDate.php";
      $sdate = new SDate();
      ?>

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/1.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h3 style="color: red;">تولیدات رادیویی</h3>
                    <p style="color: red;">انواع برنامه های رادیویی و گویندگی.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/3.jpg" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                 
                </div>
            </div>
           
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>





    <div class="container-fluid px-4"> <!-- Add custom padding using Bootstrap classes -->
    <p class="workshop-text"> * برگزاری ورکشاپ, کارگاه و دوره های تخصصی و آموزشی *</p>

    

     <!-- Team -->
    <section id="team" class="pb-5">


        <div class="container">
            <h5 class="section-title h1">تازه ترین ها</h5>
            <div class="row">
                <!-- Team member -->
                <div class="col-6 col-sm-4 mb-4">
                    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p><img class="img-fluid" src="images/audio.jpg" alt="card image"></p>
                                        <h4 class="card-title">آرشیو گویندگان</h4>
                                        <p class="card-text">اگر دنبال صداهای جذاب با گوینده های متنوع هستید کلیک کنید.</p>
                                        <a href="articles/speakers_archive" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card">
                                    <div class="card-body text-center mt-4">
                                        <a href="articles/speakers_archive"><h4 class="card-title">سفارش صدا (کلیک کنید)</h4></a>
                                        <p class="card-text">آرشیو بهترین گویندگان با صداهای متنوع تیزر تبلیغاتی، موشن گرافیک ، دوبلوری، پادکست ،
                                            کتاب صوتی و هرصدایی که بخواهید میتوانید ایجا برای آن گوینده پیدا کنید
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Team member -->
                <!-- Team member -->
                <div class="col-6 col-sm-4 mb-4">
                    <div class="image-flip" >
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p><img class="img-fluid" src="images/speaking3.jpg" alt="card image"></p>
                                        <h4 class="card-title">آموزش فن بیان و گویندگی</h4>
                                        <p class="card-text">اینجا صدایتان شنیده می‌شود!</p>
                                        <a href="courses/speaking_training_course" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card">
                                    <div class="card-body text-center mt-4">
                                        <a href="courses/speaking_training_course"><h4 class="card-title">فن بیان و گویندگی (کلیک کنید)</h4></a>
                                        <p class="card-text">اگر صدای خوب یا استعداد گویندگی دارید می‌توانید در آموزشگاه رادیو سیمرغ دوره‌های آکادمیک و تجربی را بگذرانید و در ضبط برنامه‌ها حضور پیدا کنید.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Team member -->
                <!-- Team member -->
                <div class="col-6 col-sm-4 mb-4">
                    <div class="image-flip" >
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p><img class="img-fluid" src="images/packages.jpg" alt="card image"></p>
                                        <h4 class="card-title">پکیج‌های آموزشی</h4>
                                        <p class="card-text">پکیج‌های آموزشی موسسه سیمرغ، راهی نوین برای یادگیری و پیشرفت</p>
                                        <a href="packages" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card">
                                    <div class="card-body text-center mt-4">
                                        <a href="packages"><h4 class="card-title">پکیج‌های آموزشی (کلیک کنید)</h4></a>
                                        <p class="card-text">اگر به دنبال پکیج‌های آموزشی جامع و کاربردی برای ارتقاء مهارت‌های خود هستید، موسسه سیمرغ بهترین گزینه برای شماست</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Team member -->
                <!-- Team member -->
                <div class="col-6 col-sm-4 mb-4">
                    <div class="image-flip" >
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p><img class="img-fluid" src="images/acting1.jpg" alt="card image"></p>
                                        <h4 class="card-title">آموزش بازیگری</h4>
                                        <p class="card-text">آیا به دنبال ارتقاء مهارت‌های بازیگری خود هستید؟</p>
                                        <a href="courses/acting1" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card">
                                    <div class="card-body text-center mt-4">
                                        <a href="courses/acting1"><h4 class="card-title">آموزش بازیگری (کلیک کنید)</h4></a>
                                        <p class="card-text">موسسه «سیمرغ»، پیشرو در آموزش بازیگری در ایران، دوره‌های تخصصی بازیگری مقدماتی و پیشرفته را ارائه می‌دهد. این دوره‌ها با هدف توسعه توانایی‌های بازیگری شما و آماده‌سازی شما برای ورود به دنیای هنر طراحی شده‌اند.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Team member -->
                <!-- Team member -->
                <div class="col-6 col-sm-4 mb-4">
                    <div class="image-flip" >
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p><img class="img-fluid" src="images/ordering.jpg" alt="card image"></p>
                                        <h4 class="card-title">سفارش تبلیغات شما</h4>
                                        <p class="card-text">اینجا کسب و کارتان دیده می‌شود</p>
                                        <a href="articles/order_ads" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card">
                                    <div class="card-body text-center mt-4">
                                        <a href="articles/order_ads"><h4 class="card-title">سفارش تبلیغات (کلیک کنید)</h4></a>
                                        <p class="card-text">آیا به دنبال راهی برای ارتقاء برند خود و جذب مشتریان بیشتر هستید؟ سفارش تبلیغات می‌تواند بهترین گزینه برای شما باشد!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Team member -->
                <!-- Team member -->
                <div class="col-6 col-sm-4 mb-4">
                    <div class="image-flip" >
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <p><img class="img-fluid" src="images/radio-simorgh.jpg" alt="رادیو سیمرغ"></p>
                                        <h4 class="card-title">رادیو سیمرغ</h4>
                                        <p class="card-text"> سفری شنیدنی در دنیای فرهنگ و هنر</p>
                                        <a href="radios" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card">
                                    <div class="card-body text-center mt-4">
                                        <a href="radios"><h4 class="card-title">برنامه های رادیویی (کلیک کنید)</h4></a>
                                        <p class="card-text">با گوش سپردن به برنامه‌های رادیویی موسسه "هفت هنر سیمرغ"، می‌توانید به یک ماجراجویی شنیدنی در دنیای هنر و فرهنگ قدم بگذارید</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Team member -->
            </div>
        </div>
    </section>
    <!-- Team -->



      <hr class="my-4">

   



      <section class="light">
        <div class="container py-2">
            <a href="articles">
                <h1 class="h1 text-center text-dark" id="pageHeaderTitle" title="کلیک کنید">
                آخرین مقالات
                <img src="images/link.jpg" height="30px" width="30px" alt="آخرین مقالات" title="آخرین مقالات سیمرغ">
                </h1>
            </a>

         
 

          
            <article class="postcard light blue">
                <a href="courses/workshop" class="postcard__img_link">
                    <img class="postcard__img" src="images/workshop.jpg" alt="موسسه هفت هنر سیمرغ" height="400px"/>
                </a>
                <div class="postcard__text t-dark">
                    <h1 class="postcard__title blue"><a href="courses/workshop">ورکشاپ گویندگی رادیو</a></h1>
                    <div class="postcard__subtitle small">
                    
                        
                    </div>
                    <div class="postcard__bar"></div>
                    <div class="postcard__preview-txt mr-5">
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">تجربه ای متفاوت در رادیو سیمرغ</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">همراه با گویندگان رادیو</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">شماهم اگر استعداد یا علاقه ای در زمینه گویندگی دارید میتوانید روزهای پنجشنبه هرهفته با شرکت در ورکشاپ گویندگی در ضبط برنامه رادیویی حضور داشته باشید.</p>

                    </div>
                    <ul class="postcard__tagbox">
                        <a href="courses/workshop"><li class="tag__item"><i class="fas fa-clock mr-2"></i>ادامه</li></a>
                    </ul>
                </div>
            </article>




            <article class="postcard light red">
                <a class="postcard__img_link"  href="courses/speaking_training_course">
                    <img class="postcard__img" src="images/speaking3.jpg" alt="موسسه هفت هنر سیمرغ" height="400px"/>
                </a>
                <div class="postcard__text t-dark">
                    <h1 class="postcard__title blue"><a href="courses/speaking_training_course">دوره آموزشی فن بیان و گویندگی</a></h1>

                    <div class="postcard__subtitle small">
                        
                    </div>
                    <div class="postcard__bar"></div>
                    <div class="postcard__preview-txt">
                        <h4 class="" style="font-family: &quot;Open Sans&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, &quot;Noto Sans&quot;, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;, &quot;Noto Color Emoji&quot;; color: rgb(33, 37, 41);"><p style="font-family: &quot;B Titr&quot;; font-size: 16px;">سرفصل های دوره</p><p style="font-family: &quot;B Titr&quot;; font-size: 16px;">❗️فن بیان و سخنوری&nbsp;</p><p style="font-family: &quot;B Titr&quot;; font-size: 16px;">❗️انواع حس ، لحن ، بیان و تنفس</p><p style="font-family: &quot;B Titr&quot;; font-size: 16px;">❗️تیزرهای تبلیغاتی و دکلمه خوانی ...</p></h4>

                    </div>
                    <ul class="postcard__tagbox">
                        <a href="courses/speaking_training_course"><li class="tag__item"><i class="fas fa-clock mr-2"></i>ادامه</li></a>
                    
                    </ul>
                </div>
            </article>


            <article class="postcard light blue">
                <a href="courses/acting1" class="postcard__img_link">
                    <img class="postcard__img" src="images/acting1.jpg" alt="موسسه هفت هنر سیمرغ" height="400px"/>
                </a>
                <div class="postcard__text t-dark">
                    <h1 class="postcard__title blue"><a href="courses/acting1">دوره‌های بازیگری بزرگسال موسسه «سیمرغ» </a></h1>
                    <div class="postcard__subtitle small">
                    
                        
                    </div>
                    <div class="postcard__bar"></div>
                    <div class="postcard__preview-txt mr-5">
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">سرفصل های دوره&nbsp;</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-بازیگری روی صحنه</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-بدن و بیان در بازیگری</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-فن بیان در‌ بازیگری</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">-بداهه گویی و بداهه پردازی</p>

                    </div>
                    <ul class="postcard__tagbox">
                        <a href="courses/acting1"><li class="tag__item"><i class="fas fa-clock mr-2"></i>ادامه</li></a>
                    </ul>
                </div>
            </article>




            <article class="postcard light red">
                <a class="postcard__img_link"  href="courses/motion_graphics">
                    <img class="postcard__img" src="images/motion.jpg" alt="موسسه هفت هنر سیمرغ" height="400px"/>
                </a>
                <div class="postcard__text t-dark">
                    <h1 class="postcard__title blue"><a href="courses/motion_graphics">دوره آکادمیک و تخصصی موشن گرافیک و  تولید محتوا </a></h1>

                    <div class="postcard__subtitle small">
                        
                    </div>
                    <div class="postcard__bar"></div>
                    <div class="postcard__preview-txt">
                        <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">آموزشگاه فرهنگی هنری و سینمایی سیمرغ</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">کمتر از سه ماه با آموزش تخصصی تولید محتوا</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">نرم افزارهای آموزشی</p>

                    </div>
                    <ul class="postcard__tagbox">
                        <a href="courses/motion_graphics"><li class="tag__item"><i class="fas fa-clock mr-2"></i>ادامه</li></a>
                    
                    </ul>
                </div>
            </article>

    
        </div>
      </section>

      <hr class="my-4">



      


    <section class="light">
        <div class="container py-2">
           

    

        <div class="row">
            <div class="col-sm-6 mb-4">
                <div class="card rounded-5 shadow-lg border-0" style="transition: transform 0.3s, box-shadow 0.3s;">
                    <div class="card-body" style="background: linear-gradient(135deg, #c4afcf, #e4c1f9);">
                        <h5 class="card-title d-flex justify-content-center fw-bold" >عضویت در آرشیو گویندگان</h5>
                        <a href="articles/send_voice" class="btn btn-primary w-100" style="background-color: #3b0b59; border: none;">عضویت</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-4">
                <div class="card rounded-5 shadow-lg border-0" style="transition: transform 0.3s, box-shadow 0.3s;">
                    <div class="card-body" style="background: linear-gradient(135deg, #c4afcf, #e4c1f9);">
                        <h5 class="card-title d-flex justify-content-center fw-bold">رادیو سیمرغ</h5>
                        <a href="radios" class="btn btn-primary w-100" style="background-color: #3b0b59; border: none;">شنیدن بیشتر</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 mb-4">
                <div class="card rounded-5 shadow-lg border-0" style="transition: transform 0.3s, box-shadow 0.3s;">
                    <div class="card-body" style="background: linear-gradient(135deg, #c4afcf, #e4c1f9);">
                        <h5 class="card-title d-flex justify-content-center fw-bold">پرداخت اقساطی دوره ها</h5>
                        <a href="register2" class="btn btn-primary w-100" style="background-color: #3b0b59; border: none;">ثبت نام</a>
                    </div>
                </div>
            </div>
        </div>


           
        
        </div>
    </section>







    </div> <!-- End of container-fluid -->



    <?php include "footer.php"; ?>
  </body>
</html>
