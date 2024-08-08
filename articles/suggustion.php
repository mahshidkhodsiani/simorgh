<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هفت هنر سیمرغ</title>

    <!-- Uncomment the Google Fonts link if needed -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> -->

    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/mainstyles.css">
</head>
<body>

    <?php
    include 'header.php';
    include '../config.php';
    include '../PersianCalendar.php';
    include '../jalaliDate.php';
    $sdate = new SDate();

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
                        <img class="mx-auto d-block img-fluid" src="../images/logo2.jpg" alt="موسسه هفت هنر سیمرغ" style="max-width: 100%; height: auto;">
                        <div class="card-body" dir="rtl" style="text-align: right;"> <!-- Ensured text-align right for RTL text -->
                            <h4 class="card-title" style="color: black !important;"><?= $row['title'] ?></h4> <!-- Ensured black text color -->
                            <br>
                            دوستان عزیز و همراهان همیشگی موسسه هفت هنر سیمرغ.
                            ما آماده دریافت انتقادات و پیشنهاد های شما نسبت به عملکرد موسسه ، اساتید و شیوه آموزشی هستیم.
                            با کمک در این راستا میتوانید ما را در بهبود بهتر شدن شیوه آموزشی و تولیدات یاری نمایید.
                            هدف ما جلب رضایت شما و کمک به هرچه بهتر شدن هنر شماست.
                            پیام های شما کاملا محرمانه بدون ذکر نام به مدیریت موسسه ارسال میشود.
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
