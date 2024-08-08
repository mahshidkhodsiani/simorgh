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
            <img class="d-block w-100" src="images/2.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="images/3.jpg" alt="Second slide">
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
      <div class="section noise mt-3">
        <div class="circle-container">
          <div class="circle" data-modal="dub">
            <span class="straight title">دوبله<br>(کلیک کنید)</span>
            <p class="coursedescibe">دوبله به دو صورتِ همزمان و ناهمزمان، گروهی و تک‌نفره...</p>
          </div>
          <div class="circle" data-modal="anim">
            <span class="straight title">انیمیشن<br>(کلیک کنید)</span>
            <p class="coursedescibe">پویانمایی یا انیمیشن نمایشِ تُند و پیوستهٔ تصاویری...</p>
          </div>
          <div class="circle" data-modal="design">
            <span class="straight title">طراحی<br>(کلیک کنید)</span>
            <p class="coursedescibe">اثر هنری ترکیبی از شرایط مورد نظر است...</p>
          </div>
          <div class="circle" data-modal="music">
            <span class="straight title">موسیقی<br>(کلیک کنید)</span>
            <p class="coursedescibe">سه نظریه زیبایی‌شناسی دربارهٔ موسیقی وجود دارد...</p>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Modal Structure -->
      <div id="modal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2 id="modal-title"></h2>
          <p id="modal-text"></p>
        </div>
      </div>

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
                گالری تصاویر
                </h1>
            </a>

           
        
        </div>
    </section>

      <hr class="my-4">
     


      <section class="light">
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
      </section>







    </div> <!-- End of container-fluid -->



    
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          var circles = document.querySelectorAll('.circle');
          var modal = document.getElementById('modal');
          var modalTitle = document.getElementById('modal-title');
          var modalText = document.getElementById('modal-text');
          var closeBtn = document.querySelector('.close');

          var content = {
              dub: {
                  title: 'دوبله',
                  text: '<p class="coursedescibe">دوبله به دو صورتِ همزمان و ناهمزمان (غیرهمزمان)، گروهی و تک‌نفره انجام می‌گیرد.<br><strong>1-دوبله همزمان</strong><br>دوبله همزمان یک فیلم در حال پخش در سینما است مردم نشسته‌اند و دوبلرها زنده و نفس به نفس دوبله می‌کنند اگر اشتباهی شود و کلمه یا جمله ای جا بیفتد و یا اشتباهی در دوبله کردن انجام شود، امکان برگشت و درست کردن آن وجود ندارد اگر کار دوبله در استودیو انجام شود و مشکل یا اشتباهی به وجود بیاید می‌توان آن را حل کرد اما در دوبله همزمان  باید شش دانگ حواس دوبلورها به کار باشد ، چه کار خوب باشد و چه بد باید دوبله را ادامه دهید.<br><strong>2-دوبلهٔ ناهمزمان</strong><br>در دوبلهٔ ناهمزمان، لزومی برای تطبیق صدای جایگزین با حرکات لبِ افرادِ فیلم وجود ندارد. در این نوع دوبله، صدای اصلی فیلم قطع نمی‌شود و تنها از شدت آن کاسته می‌شود.<br>دیدن بیشتر <a href="#">اینجا</a></p>'
              },
              anim: {
                  title: 'انیمیشن',
                  text: '<p class="coursedescibe">پویانمایی یا انیمیشن (به انگلیسی: Animation) نمایشِ تُند و پیوستهٔ تصاویری از اثرِ هنریِ دوبعدی، یا موقعیت‌های مدل‌های واقعی، برای ایجاد توهم حرکت است.[ب] حرکت روان تصاویرِ پویا در پویانمایی‌ها، ناشی از یک خطای دید است که به دلیل پدیدهٔ ماندگاری تصاویر پدید می‌آید. پویانمایی می‌تواند در قالب هر دو رسانهٔ آنالوگ مانند فیلم متحرک، نوار ویدئو یا در رسانه‌های دیجیتال؛ پویانمایی فِلش، ویدئوی دیجیتال ضبط شده یا "GIF" پویا باشد. برای نمایشِ پویانمایی می‌توان از یک دوربین، رایانه یا یک پروژکتور با فن‌آوری‌های نو استفاده کرد. رایج‌ترین روش برای نمایش پویانمایی، سینما یا ویدئو است. یک پویانمایی، به دو روشِ سنتی و روش دیجیتال ایجاد می‌شود. اِستاپ‌موشن شیوه‌ای از پویانمایی است که در آن با جابجایی یا تغیرِ مکان، شکل یا حالتِ اشیاء به صورت دو یا سه بعدی با استفاده از برشِ لبه‌های کاغذ، رنگ‌آمیزیِ فیلم‌های شفاف یا عروسک؛ و ثبت هر لحظه از قاب به شکل یک تصویر، و نمایشِ پیوسته تصاویر جایگزین شده، با تصاویر قبلی و معمولاً با ۱۲،۱۰،۸، ۲۴،۱۶،۱۵، ۵۰،۳۰،۲۵ یا ۶۰ قاب در ثانیه، یک اثر پویانمایی ایجاد می‌شود.<br>دیدن بیشتر <a href="#">اینجا</a></p>'
              },
              design: {
                  title: 'طراحی',
                  text: '<p class="coursedescibe">«اثر هنری ترکیبی از شرایط مورد نظر است که به منظور ارائه تجربه‌های زیبایی شناختی ارزشمند قادر به نشان دادن ویژگی‌های زیبایی شناختی هنر باشد.»<br>در حالی که کارکردی ها ارزش هنر را وابسته به ماهیت آن می‌دانند، تعریف رویه گرایان صرفاً توصیفی بوده و مبتنی بر ارزیابی نیست. از تعاریف رویه ای ارائه شده می‌توان به تعریف دیکی اشاره کرد که یک تعریف سازمانی محسوب می‌شود. او در درجه اول اثر هنری را به عنوان «اثر تصنعی» و در درجه دوم به عنوان «مجموعه ای از جنبه‌های کلیدی که از طرف برخی از نامزدها برای قدردانی از افراد فعال در منظومه هنر اعطا می‌شود» می‌بیند.<br>دیدن بیشتر <a href="#">اینجا</a></p>'
              },
              music: {
                  title: 'موسیقی',
                  text: '<p class="coursedescibe">سه نظریه زیبایی‌شناسی دربارهٔ موسیقی وجود دارد:<br><strong>1- موسیقی به مثابه زبان احساسات</strong><br><strong>2-موسیقی به مثابه نماد احساس</strong><br><strong>3-ذات موسیقی صدا و حرکت است.</strong><br>بسیاری از پدیده‌های طبیعی مانند آبشار و وزش باد از میان برگ‌های درختان و نوای طبیعی موسیقی ایجاد می‌کنند. پس باید بپذیریم موسیقی پدیده‌ای است در فطرت آدمی. از آنجا که موسیقی، یکی از زیر مجموعه‌های فرهنگ، در همه جوامع وجود دارد، و گاه با افسانه‌ها و حکایت‌ها و احساسات آمیخته شده‌است.<br>دیدن بیشتر <a href="#">اینجا</a></p>'
              }
          };

          circles.forEach(function (circle) {
              circle.addEventListener('click', function () {
                  var modalKey = this.getAttribute('data-modal');
                  modalTitle.innerText = content[modalKey].title;
                  modalText.innerHTML = content[modalKey].text;
                  modal.style.display = 'block';
              });
          });

          closeBtn.addEventListener('click', function () {
              modal.style.display = 'none';
          });

          window.addEventListener('click', function (event) {
              if (event.target == modal) {
                  modal.style.display = 'none';
              }
          });
      });
    </script>

    <?php include 'footer.php'; ?>
  </body>
</html>
