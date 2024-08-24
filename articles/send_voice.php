<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ارسال صدای خودتان</title>

   
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



    if(!extension_loaded('curl')){
        echo '<div class="error">
                برای استفاده از درگاه آپ نیازمند ماژول <b>CURL</b> هستید.
                <br>لطفا ابتدا <b>CURL</b> را روی هاست یا سرور خود نصب کنید.
            </div>
            ';
        die();
    }



    $sql = "SELECT * FROM articles WHERE title LIKE '%درباره موسسه%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $counter = 0;
        while ($row = $result->fetch_assoc()) {
    ?>
       <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger" style="border-radius: 40px;">
                        <!-- <img class="mx-auto d-block img-fluid" src="../images/audio.jpg" alt="ثبت گویندگی" style="width: 100%; height: auto;"> -->
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            <div class="row mb-5">
                                <div class="col-md-6">
                                <p><h4 class=""><span style="background-color: rgb(255, 231, 156);">با سلام خدمت شما هنرمندان خوش صدا از سراسر ایران</span></h4>جهت عضویت در آرشیو گویندگان سیمرغ و کسب درآمد یکی از آیتم های مورد نظر را با صدای رسا خوانده و بصورت mp3 فایل را برای ما ارسال کنید . پس از بررسی و ادیت نهایی توسط کارشناسان سیمرغ با اسم و عکس خودتان در سایت آپلود خواهد شد.<br><br>درآمد هر پروژه بصورت درصدی به شما پرداخت خواهد شد.<br><br><span style="background-color: rgb(231, 156, 156);">هزینه عضویت یکساله در سایت<br>500/000 هزارتومان</span><br></p>


                                <br>
                                
                                <form method="post" action="" class="form-group">
                                    <label>مبلغ (تومان) : <span style="font-size:10pt; color:#666">بین 1 هزار تومان و 5 هزار تومان</span></label>
                                    <input type="text" class="form-control" name="amount" value="1000" /> <!-- Example: 1,000 Tomans -->
                                    <br>
                                    <label>شماره موبایل : <span style="font-size:10pt; color:#666"></span></label>
                                    <input type="text" class="form-control" name="mobile" />
                                    <br>
                                    <input type="submit" value="انتقال به درگاه آپ">
                                </form>


                                </div>
                                <div class="col-md-6 border">
                                   <p>یکی از متن های زیر را انتخاب کنید:</p>
                                  <p>1: (تبلیغاتی )</p><p>با انتخابی درست به محدودیت هایتان خاتمه دهید ، اینجا صدایتان شنیده میشود . با ماوهمراه شوید ، رادیو سیمرغ</p><p>2:(نریشن)</p><p>&nbsp;موسسه فرهنگی هنری و آموزشگاه سینمایی سیمرغ ، متشکل از چندین موسسه زیر مجموعه&nbsp; استودیوی صدا و تصویر ، تولید فیلم ، آموزشگاه سینمایی و رادیو هفت سیمرغ از سال ۱۳۹۸ با اهداف آموزش و اشتغال زایی ، نشر آثار هنری هنرمندان در زمینه های مختلف تاسیس و با تولید برنامه های رادیویی مداوم در جمع موسسات برتر کشور نائل آمد.&nbsp;</p><p>3: (تیزر تبلیغاتی)</p><p>در جشنواره تخفیفات میلیونی موسسه سیمرغ ، همراه با آموزش وارد بازار کار شوید ، اینجا هنرتان دیده میشود ، سیمرغ حامی هنر&nbsp;</p><p>4: (کتاب صوتی )</p><p>ته چاهی خشكیده و نیمه تاریك، نیزه‌هایی از كف رسته است. درون چاه دری قرار دارد، كه نمی‌دانیم به كجا باز می‌شود. رستم و رخش ته چاه افتاده‌اند، زخم خورده و خونین. رخش مرده و رستم بی­هوش است. رستم تكا‌نی خورده، چشم باز می­كند، از درد می‌نالد.</p><p>رستم: وای . درد... درد نشانه‌ای به زند‌‌گی­ست. چند روز گذشته؟ شبان به آرامی می‌گذرند و جان لحظه‌لحظه از تن می‌‌‌‌گریزد... وای&nbsp; درد. من با زخم آشنایم، اما این دردِ زخم نیست، چیزی بس جگرسوز‌تر می‌خلد و می‌گدازد و بر جان می‌نشیند، خلیدن پنجه­ی سردش را... آی درد... درد... تشنه‌ام؛ سخت تشنه ‌[به رخش] هی یار دیرین! تو نیز تشنه‌ای؟ رخش!</p><p>‌رخش را تكان میدهد</p><p>رخشِ من‌! [درمی‌یابد كه رخش مرده است] هی یار دیرین! اسب آهنین سُنبِ من! كجا رفت جانت؟ گراز من! سیمرغك!&nbsp;</p><p><br></p><p>5:( خبری )</p><p>پس از چند روز بحث و تبادل نظر در شورای اسلامی پیرامون وزرای پیشنهادی دکتر روحانی سرانجام ترکیب کابینه یازدهم مشخص شد. آقای روحانی با تشکر از نمایندگان ملت برای حضور منسجم در جلسات تایید صلاحیت آرزو کرد کابینه او بتواند در جهت منویات مقام معظم رهبری و خواست ملت بزرگ ایران گام بردارد</p><p>6:(تلفن گویا)</p><p>با سلام ، شما با موسسه فرهنگی هنری هفت هنر سیمرغ تماس گرفته اید</p><p>چنانچه داخلی مورد نظر خود را میدانید آن را شماره گیری نمایید و یا در غیر اینصورت جهت ارتباط با،</p><p>کلاسهای گویندگی عدد۱ ، کلاسهای بازیگری عدد ۲ استودیوی صدا و تصویر عدد۳ رادیو سیمرغ عدد۴ پکیج های آموزشی عدد ۵ و جهت ارتباط با اپراتور عدد صفر را شماره گیری نمایید ، با تشکر از تماس شما</p>

                                </div>
                            </div>

                            <!-- <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="control-label">نام</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">نام خانوادگی </label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>
                              
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="control-label">شماره موبایل </label>
                                            <input type="number" name="name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" name="audioFile" class="form-control" accept="audio/mp3" required>
                                            <button class="btn btn-outline-info btn-block animated-button">آپلود</button>
                                        </div>
                                    </div>
                                </div>
                            </form> -->
                            
                        </div>

                     
                       

                   

                    </div>

                </div>
            </div>
        </div>

    <?php
        }
    }
    ?>

    <?php include 'footer.php'; ?>

  


</body>
</html>



<?php
require 'API/Gateway.php';
require 'ipgcfg.php';

if(!empty($_POST)){
	$CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$CurUrl = substr($CurUrl,0, strrpos($CurUrl, '/')+1);
	$CallBackUrl = $CurUrl.'back.php';	

    $result = Gateway::make()
        ->config($Username,$Password,$merchantConfigID,$CallBackUrl)
        ->amount($_POST['amount'])
        ->invoiceId(time())
        ->token();

    if($result['code'] == 200){	
        Gateway::redirect($result['content'],$_POST['mobile']);
    }
	else{
		if ($result['errortype']){
			echo 
			'<div class="error">
				<span style="color: #d00">خطای ماژول CURL.<br>
				کدخطا: <b>'.$result['code'].'</b></span>
				<p align="right">شرح خطا:</p>
				<div style="text-align: left; direction: ltr;">
					<span style="font:bold 11pt verdana ">'.$result['content'].'</span>
				</div>		
			</div>';		
			exit();
		}
        echo 
		'<div class="error">
			<span style="color: #d00">خطا هنگام ایجاد تراکنش.<br>
			کدخطا: <b>'.$result['code'].'</b></span>
			<div style="text-align:right;">
				شرح خطا:<br><span style="direction:ltr; font:bold 11pt verdana ">'.$result['content'].'</span></div>
				<div style="text-align:justify; direction:rtl; line-height:1.4;  margin-top:30px">برای دریافت شرح کاملتر خطا با مراجعه به نشانی 
				<a href="https://rest.asanpardakht.net" target="_blank">https://rest.asanpardakht.net</a> ، شرح خطای <b>'.$result['code'].'</b> 
				را در متد <b>Token</b> مشاهده کنید.
			</div>		
		</div>';
    }
}

if ($Username == 'Your Username' || 
	$Password == 'Your Password' || 
	$merchantConfigID == 'Your merchantConfigID')
	// echo '<div align="center">
			// <img src="HELP.jpg" />
		  // </div>
			// ';
?>



<?php



// Check if a file was uploaded
// if (isset($_FILES['audioFile']) && $_FILES['audioFile']['error'] == 0) {
//     $fileName = $_FILES['audioFile']['name'];
//     $fileType = $_FILES['audioFile']['type'];
//     $fileSize = $_FILES['audioFile']['size'];
//     $fileData = file_get_contents($_FILES['audioFile']['tmp_name']);

//     // Additional form fields (you need to add these fields in your form)
//     $name = $_POST['name'];
//     $family = $_POST['family'];
//     $number = $_POST['number'];

//     // Prepare and execute the SQL query
//     $stmt = $conn->prepare("INSERT INTO sounds (name, family, number, file_name, file_type, file_size, file_data) VALUES (?, ?, ?, ?, ?, ?, ?)");
//     $stmt->bind_param("sssssis", $name, $family, $number, $fileName, $fileType, $fileSize, $fileData);

//     if ($stmt->execute()) {
//         echo "File uploaded successfully.";
//     } else {
//         echo "Error: " . $stmt->error;
//     }

//     $stmt->close();
// } else {
//     echo "No file uploaded or upload error.";
// }