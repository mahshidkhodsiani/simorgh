<?php
session_start();
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درباره هفت هنر سیمرغ</title>

   
    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
</head>
<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();
    if(isset($_SESSION['invoice'])){

        $user_id = $_SESSION['invoice'];

        $sql = "SELECT * FROM contacts WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } 

        $_SESSION['new_id'] = $row['id'];
 
    ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger p-4 text-center">
                        <div style="text-align: center; margin : 20px ">
                            <img src="../images/tik.jpg" height="70px" width="70px" >
                        </div>
                        <h3 style="text-align: center; " class=""><span style="background-color: rgb(107, 165, 74);">رسید پرداختی</span></h3><p> پرداخت شما با موفقیت انجام شد .</p><p><br></p>
                        <br>
                        <button class="btn btn-success mt-3">در حال انتقال به صفحه اصلی</button>
                    </div>
                </div>
            </div>
        </div>

        
        <script>
            // Redirect to user_voice.php after 3 seconds
            setTimeout(function() {
                window.location.href = 'user_voice.php';
            }, 10000);
        </script>

    <?php
    }else{
        echo "<h1 style='text-align : center'>". "هنوز ثبت نام نکردید" ."</h1>"; ;
    }
    ?>
 

    <?php include 'footer.php'; ?>

</body>
</html>
