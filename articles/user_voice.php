<?php
session_start();

?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درباره هفت هنر سیمرغ</title>

   

    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
</head>
<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();

    if (isset($_SESSION['new_id'])){
    ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <!-- <img class="mx-auto d-block img-fluid" src="../images/logo2.jpg" alt="موسسه هفت هنر سیمرغ" style="max-width: 100%; height: auto;"> -->
                        <div class="card-body" dir="rtl" style="text-align: right;"> 
                            <div class="row">
                                <div class="col-md-6">

                                <form class="form-group border p-3" action="" method="POST" enctype="multipart/form-data">
                                    <h4 style="color: #7d0319;">صدای خودرا اینجا آپلود کنید</h4>
                                    <input class="form-control" type="file" name="audioFile" accept="audio/mp3" required>
                                    <br />
                                    <input type="submit" class="btn btn-outline-success" value="ارسال">
                                </form>



                                </div>
                                <div class="col-md-6 border">

                                <p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="font-family: Vazirmatn; white-space-collapse: preserve; background-color: rgb(148, 189, 123);">جهت عضویت در آرشیو گویندگان و معرفی به بازار کار و کسب درآمد یکی از آیتم های مورد نظر را با صدای رسا خوانده و بصورت mp3 برای ما ارسال کنید. یا یک نمونه کار با صدای خودتان جهت بارگذاری در سایت برای ما ارسال کنید</span><br></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><span style="background-color: var(--bs-body-bg); font-size: var(--bs-body-font-size); font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);">پس از بررسی توسط کارشناسان سیمرغ با اسم و عکس خودتان در سایت بارگذاری خواهد شد.</span><br></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">1: (تبلیغاتی )</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">با انتخابی درست به محدودیت هایتان خاتمه دهید ، اینجا صدایتان شنیده میشود . با ماوهمراه شوید ، رادیو سیمرغ</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">2:(نریشن)</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">&nbsp;موسسه فرهنگی هنری و آموزشگاه سینمایی سیمرغ ، متشکل از چندین موسسه زیر مجموعه&nbsp; استودیوی صدا و تصویر ، تولید فیلم ، آموزشگاه سینمایی و رادیو هفت سیمرغ از سال ۱۳۹۸ با اهداف آموزش و اشتغال زایی ، نشر آثار هنری هنرمندان در زمینه های مختلف تاسیس و با تولید برنامه های رادیویی مداوم در جمع موسسات برتر کشور نائل آمد.&nbsp;</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">3: (تیزر تبلیغاتی)</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">در جشنواره تخفیفات میلیونی موسسه سیمرغ ، همراه با آموزش وارد بازار کار شوید ، اینجا هنرتان دیده میشود ، سیمرغ حامی هنر&nbsp;</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">4: (کتاب صوتی )</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">ته چاهی خشكیده و نیمه تاریك، نیزه‌هایی از كف رسته است. درون چاه دری قرار دارد، كه نمی‌دانیم به كجا باز می‌شود. رستم و رخش ته چاه افتاده‌اند، زخم خورده و خونین. رخش مرده و رستم بی­هوش است. رستم تكا‌نی خورده، چشم باز می­كند، از درد می‌نالد.</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">رستم: وای . درد... درد نشانه‌ای به زند‌‌گی­ست. چند روز گذشته؟ شبان به آرامی می‌گذرند و جان لحظه‌لحظه از تن می‌‌‌‌گریزد... وای&nbsp; درد. من با زخم آشنایم، اما این دردِ زخم نیست، چیزی بس جگرسوز‌تر می‌خلد و می‌گدازد و بر جان می‌نشیند، خلیدن پنجه­ی سردش را... آی درد... درد... تشنه‌ام؛ سخت تشنه ‌[به رخش] هی یار دیرین! تو نیز تشنه‌ای؟ رخش!</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">‌رخش را تكان میدهد</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">رخشِ من‌! [درمی‌یابد كه رخش مرده است] هی یار دیرین! اسب آهنین سُنبِ من! كجا رفت جانت؟ گراز من! سیمرغك!&nbsp;</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;"><br></p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">5:( خبری )</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">پس از چند روز بحث و تبادل نظر در شورای اسلامی پیرامون وزرای پیشنهادی دکتر روحانی سرانجام ترکیب کابینه یازدهم مشخص شد. آقای روحانی با تشکر از نمایندگان ملت برای حضور منسجم در جلسات تایید صلاحیت آرزو کرد کابینه او بتواند در جهت منویات مقام معظم رهبری و خواست ملت بزرگ ایران گام بردارد</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">6:(تلفن گویا)</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">با سلام ، شما با موسسه فرهنگی هنری هفت هنر سیمرغ تماس گرفته اید</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">چنانچه داخلی مورد نظر خود را میدانید آن را شماره گیری نمایید و یا در غیر اینصورت جهت ارتباط با،</p><p style="color: rgb(33, 37, 41); font-family: &quot;B Titr&quot;;">کلاسهای گویندگی عدد۱ ، کلاسهای بازیگری عدد ۲ استودیوی صدا و تصویر عدد۳ رادیو سیمرغ عدد۴ پکیج های آموزشی عدد ۵ و جهت ارتباط با اپراتور عدد صفر را شماره گیری نمایید ، با تشکر از تماس شما</p>
                                

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php

    }else{
    ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <!-- <img class="mx-auto d-block img-fluid" src="../images/logo2.jpg" alt="موسسه هفت هنر سیمرغ" style="max-width: 100%; height: auto;"> -->
                        
                        <div class="card-body" dir="rtl" style="text-align: right;"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <form class="form-group border p-3" action="" method="POST">
                                        <label for="">شماره موبایل خودرا وارد کنید :</label>
                                        <input type="text" class="form-control" name="number">
                                        <br>
                                        <input type="submit" class="btn btn-primary" value="جستجو" name="search_user">
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    <?php

    }
    ?>


        
  

    <?php include 'footer.php'; ?>

</body>
</html>


<?php

if(isset($_POST['search_user'])){
    $number = $_POST['number'];
    $sql = "SELECT * FROM `contacts` WHERE mobile = '$number'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $_SESSION['new_id'] = $row['id'];
            header("Location: user_voice.php");
            exit; // Stop further execution after redirecting to about.php page.
        }
    }else{
        echo "<script>alert('شماره موبایل وارد شده در سیستم موجود نمی باشد.')</script>";
    }
}




if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['audioFile'])) {
    // Get file details
    $fileName = $_FILES['audioFile']['name'];
    $fileType = $_FILES['audioFile']['type'];
    $fileSize = $_FILES['audioFile']['size'];
    $fileData = file_get_contents($_FILES['audioFile']['tmp_name']);

    $contact_id = $_SESSION['new_id'];
    
    // Save file to the server
  // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO sounds (contact_id, file_name, file_type, file_size, file_data) 
                            VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("issis",$contact_id, $fileName, $fileType, $fileSize, $fileData);
    $stmt->send_long_data(3, $fileData); // 3 is the index of the `file_data` parameter
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

}

