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
  
    <?php include 'includes.php'; ?>
</head>

  <body>

      <?php
      include 'header.php';
      include 'config.php';
      include 'PersianCalendar.php';
      include 'jalaliDate.php';
      $sdate = new SDate();
      ?>

      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="images/1.jpg" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/3.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/6.jpg" alt="Second slide">
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







      <!-- Team -->
      <section id="team" class="pb-5">
          <div class="container">
              <h5 class="section-title h1">برگزاری دوره های هنری ، فنی</h5>
              <div class="row">
                  <!-- Team member -->
                  <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="image-flip" >
                          <div class="mainflip flip-0">
                              <div class="frontside">
                                  <div class="card">
                                      <div class="card-body text-center">
                                          <p><img class=" img-fluid" src="images/speaking.jpg" alt="card image"></p>
                                          <h4 class="card-title">فن بیان و گویندگی</h4>
                                          <p class="card-text">اینجا صدایتان شنیده می شود!</p>
                                          <a href="courses/speaking" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                      </div>
                                  </div>
                              </div>
                              <div class="backside">
                                  <div class="card">
                                      <div class="card-body text-center mt-4">
                                          <a href="courses/speaking"><h4 class="card-title">فن بیان و گویندگی</h4></a>
                                          <p class="card-text">اگر صدای خوب یا استعداد گویندگی
                                             دارید میتوانید در آموزشگاه رادیو سیمرغ دوره های آکادمیک و تجربی رو بگذرونید و در ضبط برنامه ها حضور پیدا کنید.</p>
                                  
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- ./Team member -->
                  <!-- Team member -->
                  <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                          <div class="mainflip">
                              <div class="frontside">
                                  <div class="card">
                                      <div class="card-body text-center">
                                          <p><img class=" img-fluid" src="images/audio.jpg" alt="card image"></p>
                                          <h4 class="card-title">آرشیو گویندگان</h4>
                                          <p class="card-text">آرشیو گویندگان موسسه سیمرغ ذخیره‌ای بی‌نظیر از استعدادها و مهارت‌ها</p>
                                          <a href="https://www.fiverr.com/share/qb8D02" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                      </div>
                                  </div>
                              </div>
                              <div class="backside">
                                  <div class="card">
                                      <div class="card-body text-center mt-4">
                                          <a href="#"><h4 class="card-title">آرشیو گویندگان</h4></a>
                                          <p class="card-text">موسسه سیمرغ، با سابقه‌ای درخشان در زمینه تولید محتوا و دوبله،
                                             به‌عنوان یکی از برترین مراکز آموزشی و تولیدی در صنعت صدا و تصویر شناخته می‌شود. آرشیو گویندگان موسسه سیمرغ، منبعی ارزشمند از استعدادهای بی‌نظیر و مهارت‌های حرفه‌ای در زمینه گویندگی و دوبله است.</p>
                                          <ul class="list-inline">
                                              <li class="list-inline-item">
                                                  <a class="social-icon text-xs-center" target="_blank" href="https://www.fiverr.com/share/qb8D02">
                                                      <i class="fa fa-facebook"></i>
                                                  </a>
                                              </li>
                                              <li class="list-inline-item">
                                                  <a class="social-icon text-xs-center" target="_blank" href="https://www.fiverr.com/share/qb8D02">
                                                      <i class="fa fa-twitter"></i>
                                                  </a>
                                              </li>
                                              <li class="list-inline-item">
                                                  <a class="social-icon text-xs-center" target="_blank" href="https://www.fiverr.com/share/qb8D02">
                                                      <i class="fa fa-skype"></i>
                                                  </a>
                                              </li>
                                              <li class="list-inline-item">
                                                  <a class="social-icon text-xs-center" target="_blank" href="https://www.fiverr.com/share/qb8D02">
                                                      <i class="fa fa-google"></i>
                                                  </a>
                                              </li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- ./Team member -->
                  <!-- Team member -->
                  <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="image-flip" >
                          <div class="mainflip flip-0">
                              <div class="frontside">
                                  <div class="card">
                                      <div class="card-body text-center">
                                          <p><img class=" img-fluid" src="images/acting.jpg" alt="card image"></p>
                                          <h4 class="card-title">بازیگری</h4>
                                          <p class="card-text">آیا به دنبال ارتقاء مهارت‌های بازیگری خود هستید؟</p>
                                          <a href="courses/speaking" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                      </div>
                                  </div>
                              </div>
                              <div class="backside">
                                  <div class="card">
                                      <div class="card-body text-center mt-4">
                                          <a href="courses/acting"><h4 class="card-title">آموزش بازیگری</h4></a>
                                          <p class="card-text">موسسه «سیمرغ»، پیشرو در آموزش بازیگری در ایران، دوره‌های تخصصی بازیگری مقدماتی و پیشرفته را ارائه می‌دهد.
                                             این دوره‌ها با هدف توسعه توانایی‌های بازیگری شما و آماده‌سازی شما برای ورود به دنیای هنر طراحی شده‌اند.</p>
                                  
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- ./Team member -->
                  <!-- Team member -->
                  <div class="col-xs-12 col-sm-6 col-md-3">
                      <div class="image-flip" >
                          <div class="mainflip flip-0">
                              <div class="frontside">
                                  <div class="card">
                                      <div class="card-body text-center">
                                          <p><img class=" img-fluid" src="images/speaking.jpg" alt="card image"></p>
                                          <h4 class="card-title">موشن گرافیک</h4>
                                          <p class="card-text">اگه شغل مناسب ندارین ،یا دنبال شغل دوم با درآمد بالا هستین... </p>
                                          <a href="courses/speaking" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                      </div>
                                  </div>
                              </div>
                              <div class="backside">
                                  <div class="card">
                                      <div class="card-body text-center mt-4">
                                          <a href="courses/motion_graphics"><h4 class="card-title">آموزش موشن گرافیک</h4></a>
                                          <p class="card-text">میتونین رشته موشن گرافیک یاد بگیرین و بصورت حضوری و حتی دورکاری در منزل خودتون تولید محتوا بسازید و کسب درآمد کنید.
                                            کلاسها بصورت حضوری و آنلاین</p>
                                  
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
          <h1 class="h1 text-center text-dark" id="pageHeaderTitle">
            آخرین مقالات
          </h1>

          <?php
          $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 4";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $counter = 0;
            while ($row = $result->fetch_assoc()) {

              if(is_object(json_decode($row['images']))){
                $images = json_decode($row['images'], true);
                $image_url = $images['images']['original']; 
                $image_url = str_replace("/upload","upload", $image_url);
              }else{
                $image_url = $row['images']; 
                $image_url = str_replace("../upload","upload", $image_url);
              }
              
              // var_dump($image_url);
              $body_content = preg_replace('/<p>/', '<p style="color: black !important; margin-right: 5px !important; ">', $row['body']);
              if ($counter % 2 == 0) { 
          ?>

          <article class="postcard light blue">
            <a class="postcard__img_link" href="#">
              <img class="postcard__img" src="<?=$image_url?>" alt="موسسه هفت هنر سیمرغ" />
            </a>
            <div class="postcard__text t-dark">
              <h1 class="postcard__title blue"><a href="#"><?= $row['title'] ?></a></h1>
              <div class="postcard__subtitle small">
                <time datetime="<?= $sdate->toShaDate($row['created_at']) ?>">
                  <i class="fas fa-calendar-alt mr-2"></i><?= $sdate->toShaDate($row['created_at']) ?>
                </time>
              </div>
              <div class="postcard__bar"></div>
              <div class="postcard__preview-txt"><?= $body_content ?></div>
              <ul class="postcard__tagbox">
                <li class="tag__item"><i class="fas fa-clock mr-2"></i><?= $row['type'] ?></li>
                <li class="tag__item play blue">
                  <a href="#"><i class="fas fa-play mr-2"></i>مقالات</a>
                </li>
              </ul>
            </div>
          </article>

          <?php 
              } else { 
          ?>

          <article class="postcard light red">
            <a class="postcard__img_link" href="#">
              <img class="postcard__img" src="<?= $image_url ?>" alt="موسسه هفت هنر سیمرغ" />
            </a>
            <div class="postcard__text t-dark">
              <h1 class="postcard__title red"><a href="#"><?= $row['title'] ?></a></h1>
              <div class="postcard__subtitle small">
                <time datetime="<?= $sdate->toShaDate($row['created_at']) ?>">
                  <i class="fas fa-calendar-alt mr-2"></i><?= $sdate->toShaDate($row['created_at']) ?>
                </time>
              </div>
              <div class="postcard__bar"></div>
              <div class="postcard__preview-txt"><?= $body_content ?></div>
              <ul class="postcard__tagbox">
                <li class="tag__item"><i class="fas fa-clock mr-2"></i><?= $row['type'] ?></li>
                <li class="tag__item play red">
                  <a href="#"><i class="fas fa-play mr-2"></i>مقالات</a>
                </li>
              </ul>
            </div>
          </article>

          <?php 
              }
              $counter++;
            }
          } else {
            echo "0 results";
          }
          ?>
        </div>
      </section>

      <hr class="my-4">

      


    <section class="light">
        <div class="container py-2">
            <a href="gallery/all">
              
                <h1 class="h1 text-center text-dark" id="pageHeaderTitle">
                <img src="images/link.jpg" height="30px" width="30px" alt="گالری سیمرغ"/>
                نمونه کارها
                </h1>
            </a>

           
        
        </div>
    </section>

      <hr class="my-4">
     


      <!-- <section class="light">
        <div class="container py-2">
          <a href="gallery/all">
            <h1 class="h1 text-center text-dark" id="pageHeaderTitle">
              <img src="images/link.jpg" height="30px" width="30px" alt="گالری سیمرغ" /> ثبت نام ها
            </h1>
          </a>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <img src="upload/images/2024/79-min.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">ثبت نام گویندگی</h5>
                  <p class="card-text">موسسه هفت هنر سیمرغ فرصت‌های زیادی برای علاقمندان به گویندگی فراهم کرده است. برای ثبت نام در دوره‌های گویندگی و اطلاع از جزئیات بیشتر با ما تماس بگیرید.</p>
                  <a href="#" class="btn mb-2 mb-md-0 btn-outline-secondary btn-block">ثبت نام</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              
            </div>
            <div class="col-md-4">
             
            </div>
          </div>
      
        </div>
      </section> -->







    </div> <!-- End of container-fluid -->



    <?php include 'footer.php'; ?>
  </body>
</html>
