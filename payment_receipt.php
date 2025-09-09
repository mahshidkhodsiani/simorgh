<?php
session_start();

?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درباره هفت هنر سیمرغ</title>



    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mainstyles.css">

    <link rel="icon" href="images/logo1.ico" type="image/x-icon">
</head>

<body>

    <?php
    include 'header.php';
    include 'config.php';
    include 'PersianCalendar.php';
    include 'jalaliDate.php';
    $sdate = new SDate();

    if (isset($_SESSION['invoice'])) {

        $user_id = $_SESSION['invoice'];

        $sql = "SELECT * FROM contacts WHERE user_id = $user_id";
        $result = $conn->query($sql);

        $row = null;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }


        

        $name = $row['name'];
        $lastname = $row['lastname'];
        $mobile = $row['mobile'];
        $meli_code = $row['meli_code'];

        $user = "SELECT * FROM users WHERE username = '$meli_code'";
        $reseult_user = $conn->query($user);

        if ($reseult_user === false) {
            die("خطا در اجرای کوئری users: " . $conn->error);
        }

        if ($reseult_user->num_rows == 0) {
            // هش کردن پسورد (می‌تونی همون شماره موبایل رو به عنوان پسورد اولیه بذاری)
            $hashedPassword = password_hash($meli_code, PASSWORD_DEFAULT);

            $insert_user = "INSERT INTO users (name, family, username, password, meli_code, mobile, level, admin, created_at)
                VALUES ('$name', '$lastname', '$meli_code', '$hashedPassword', '$meli_code', '$mobile', 'user', 0, NOW())";

            $create_user = $conn->query($insert_user);

            if ($create_user === false) {
                die("خطا در ثبت کاربر: " . $conn->error);
            }
        }




    ?>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card border border-danger p-4 text-center">
                        <div style="text-align: center; margin : 20px ">
                            <img src="images/tik.jpg" height="70px" width="70px">
                        </div>
                        <h3 style="text-align: center; " class=""><span style="background-color: rgb(107, 165, 74);">رسید پرداختی</span></h3>
                        <p> پرداخت شما با موفقیت انجام شد.</p>
                        <p><br></p>
                        <p>مبلغ : <?= $row['amount']; ?></p>
                        <p><br></p>
                        <p>بزودی کارشناسان ما در وقت اداری با شما تماس خواهند گرفت.</p>
                        <button class="btn btn-success mt-3">در حال انتقال به صفحه اصلی</button>
                    </div>
                </div>
            </div>
        </div>



        <?php
        $username = "09124366786";
        $password = "96139290@sN";
        $from     = "300016343000";
        $to       = $row['mobile'];

        // $message = "ثبت نام در سیمرغ با موفقیت انجام شد\nمبلغ واریزی شما : {$row['amount']}\nیوزرنیم و پسورد شما جهت لاگین : {$row['mobile']}";


        $message = "با سپاس از انتخاب شما\nثبت‌نام شما در آموزشگاه سیمرغ با موفقیت انجام شد.\nمبلغ پرداختی: {$row['amount']} ریال\nنام کاربری و رمز عبور جهت ورود به پنل کاربری: {$row['meli_code']}\nشماره تماس پشتیبانی: 02191300517\nبا آرزوی موفقیت روزافزون برای شما.";


        // ساخت URL
        $url = "https://niksms.com/fa/publicapi/groupsms";

        // آماده‌سازی داده‌ها
        $data = [
            "username"     => $username,
            "password"     => $password,
            "numbers"      => $to,
            "sendernumber" => $from,
            "message"      => $message,
        ];

        // ارسال با cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        // echo $response;
        ?>



        <script>
            // Redirect to user_voice.php after 3 seconds
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 10000);
        </script>

    <?php
    } else {
        echo "<h1 style='text-align : center'>" . "هنوز ثبت نام نکردید" . "</h1>";;
    }
    ?>


    <?php include 'footer.php'; ?>

</body>

</html>