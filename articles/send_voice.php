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
                                   <h5>لطفا از روی متن بخوانید و صدای خود را ضبط کنید و برای ما ارسال کنید</h5>
                                </div>
                                <div class="col-md-6">
                                   <p>متن:</p>
                                   <p style="color: #b53e53;">اینجا متن خواندن</p>
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

                     
                        <form method="post" action="">
                            <label>مبلغ : <span style="font-size:10pt; color:#666">(حداقل 12000 ریال)</label>
                            <input type="text" name="amount" value="12000" />
                            <br>
                            <label>شماره موبایل : <span style="font-size:10pt; color:#666">(اختیاری)</label>
                            <input type="text" name="mobile" />
                            <br>
                            <input type="submit" value="انتقال به درگاه آپ">
                        </form>

                   

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

// include 'config.php';


require '../rest/API/Gateway.php';
require '../rest/ipgcfg.php';

if(!empty($_POST)){
    $CurUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $CurUrl = substr($CurUrl, 0, strrpos($CurUrl, '/')+1);
    $CallBackUrl = $CurUrl.'../rest/back.php';

    $result = Gateway::make()
        ->config($Username, $Password, $merchantConfigID, $CallBackUrl)
        ->amount($_POST['amount'])
        ->invoiceId(time())
        ->token();

    if($result['code'] == 200){    
        Gateway::redirect($result['content'], $_POST['mobile']);
    } else {
        handlePaymentError($result);
    }
}

function handlePaymentError($result){
    $errorHtml = '<div class="error"><span style="color: #d00">خطا هنگام ایجاد تراکنش.<br>
                  کدخطا: <b>'.$result['code'].'</b></span>';
    if ($result['errortype']) {
        $errorHtml .= '<div style="text-align:right;">شرح خطا:<br><span style="direction:ltr; font:bold 11pt verdana ">'.$result['content'].'</span></div>';
    } else {
        $errorHtml .= '<div style="text-align:justify; direction:rtl; line-height:1.4; margin-top:30px">برای دریافت شرح کاملتر خطا با مراجعه به نشانی 
                       <a href="https://rest.asanpardakht.net" target="_blank">https://rest.asanpardakht.net</a> ، شرح خطای <b>'.$result['code'].'</b> 
                       را در متد <b>Token</b> مشاهده کنید.</div>';
    }
    echo $errorHtml.'</div>';

    // Log error details for further analysis
    error_log('Payment Error: ' . print_r($result, true));

    exit();
}



// if ($Username == 'Your Username' || 
// 	$Password == 'Your Password' || 
// 	$merchantConfigID == 'Your merchantConfigID')
	// echo '<div align="center">
			// <img src="HELP.jpg" />
		  // </div>
			// ';








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