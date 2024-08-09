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
                        <div class="card-body" dir="rtl" style="text-align: right;">
                            <br>
                            دوستان عزیز و همراهان همیشگی موسسه هفت هنر سیمرغ.
                            ما آماده دریافت انتقادات و پیشنهاد های شما نسبت به عملکرد موسسه ، اساتید و شیوه آموزشی هستیم.
                            با کمک در این راستا میتوانید ما را در بهبود بهتر شدن شیوه آموزشی و تولیدات یاری نمایید.
                            هدف ما جلب رضایت شما و کمک به هرچه بهتر شدن هنر شماست.
                            پیام های شما کاملا محرمانه بدون ذکر نام به مدیریت موسسه ارسال میشود.

                            <br><br>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <button type="button" id="show-feedback" class="btn mb-2 mb-md-0 btn-outline-secondary btn-block">ثبت انتقاد</button>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <button type="button" id="show-suggestion" class="btn mb-2 mb-md-0 btn-outline-secondary btn-block">ثبت پیشنهاد</button>
                                </div>
                            </div>

                            <br>
                            <form method="post" action="" id="enteghad" class="border p-1" style="display: none;">
                                <h3>فرم انتقاد</h3>
                                <div class="form-group">
                                    <label for="enteghad-text">می توانید متن خود را اینجا بنویسید</label>
                                    <textarea class="form-control" id="enteghad-text" name="enteghad"></textarea>
                                    <br>
                                    <button class="btn mb-2 mb-md-0 btn-outline-quarternary btn-block" name="enteghad_sabt">ثبت انتقاد</button>
                                </div>
                            </form>
                            <form method="post" action="" id="suggust" class="border p-1" style="display: none;">
                                <h3>فرم پیشنهاد</h3>
                                <div class="form-group">
                                    <label for="suggust-text">می توانید پیشنهاد خود را اینجا بنویسید</label>
                                    <textarea class="form-control" id="suggust-text" name="suggust"></textarea>
                                    <br>
                                    <button class="btn mb-2 mb-md-0 btn-outline-quarternary btn-block" name="suggust_sabt">ثبت پیشنهاد</button>
                                </div>
                            </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showFeedbackButton = document.getElementById('show-feedback');
            const showSuggestionButton = document.getElementById('show-suggestion');
            const feedbackForm = document.getElementById('enteghad');
            const suggestionForm = document.getElementById('suggust');

            showFeedbackButton.addEventListener('click', function() {
                feedbackForm.style.display = 'block';
                suggestionForm.style.display = 'none';
            });

            showSuggestionButton.addEventListener('click', function() {
                suggestionForm.style.display = 'block';
                feedbackForm.style.display = 'none';
            });
        });

    </script>

</body>
</html>
