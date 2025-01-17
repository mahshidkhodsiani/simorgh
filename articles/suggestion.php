<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انتقادات و پیشنهادات</title>

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
                                    <textarea class="form-control" id="enteghad-text" name="enteghad" required></textarea>
                                    <br>
                                    <button class="btn mb-2 mb-md-0 btn-outline-quarternary btn-block" name="enteghad_sabt">ثبت انتقاد</button>
                                </div>
                            </form>
                            <form method="post" action="" id="suggest" class="border p-1" style="display: none;">
                                <h3>فرم پیشنهاد</h3>
                                <div class="form-group">
                                    <label for="suggest-text">می توانید پیشنهاد خود را اینجا بنویسید</label>
                                    <textarea class="form-control" id="suggest-text" name="suggest" required></textarea>
                                    <br>
                                    <button class="btn mb-2 mb-md-0 btn-outline-quarternary btn-block" name="suggest_sabt">ثبت پیشنهاد</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

 

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showFeedbackButton = document.getElementById('show-feedback');
            const showSuggestionButton = document.getElementById('show-suggestion');
            const feedbackForm = document.getElementById('enteghad');
            const suggestionForm = document.getElementById('suggest');

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

<?php


if (isset($_POST['enteghad'])) {
    $enteghad = $_POST['enteghad'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO suggestions (text, type) VALUES (?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $type = 'enteghad';
    $stmt->bind_param('ss', $enteghad, $type);

    if ($stmt->execute()) {
        // Success Toast
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    انتقاد شما با موفقیت ثبت شد !
                </div>
              </div>
              <script>
              $(document).ready(function(){
                  $('#successToast').toast({
                      autohide: true,
                      delay: 3000
                  }).toast('show');
                  setTimeout(function(){
                      window.location.href = 'suggestion';
                  }, 3000);
              });
              </script>";
    } else {
        // Error Toast
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در ثبت انتقاد رخ داده!
                </div>
              </div>
              <script>
              $(document).ready(function(){
                  $('#errorToast').toast({
                      autohide: true,
                      delay: 3000
                  }).toast('show');
                  setTimeout(function(){
                      $('#errorToast').toast('hide');
                  }, 3000);
              });
              </script>";
    
        echo "<div class='alert alert-danger mt-2' role='alert'>
                Error: " . $sql . "<br>" . $conn->error . "
              </div>";
    }
}



if (isset($_POST['suggest'])) {
    // Retrieve and sanitize user input
    $suggest = $_POST['suggest'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO suggestions (text, type) VALUES (?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $type = 'suggest';
    $stmt->bind_param('ss', $suggest, $type);




    if ($stmt->execute()) {
        // Success Toast
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    پیشنهاد شما با موفقیت ثبت شد !
                </div>
              </div>
              <script>
              $(document).ready(function(){
                  $('#successToast').toast({
                      autohide: true,
                      delay: 3000
                  }).toast('show');
                  setTimeout(function(){
                      window.location.href = 'suggestion';
                  }, 3000);
              });
              </script>";
    } else {
        // Error Toast
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در ثبت پیشنهاد رخ داده!
                </div>
              </div>
              <script>
              $(document).ready(function(){
                  $('#errorToast').toast({
                      autohide: true,
                      delay: 3000
                  }).toast('show');
                  setTimeout(function(){
                      $('#errorToast').toast('hide');
                  }, 3000);
              });
              </script>";
    
        echo "<div class='alert alert-danger mt-2' role='alert'>
                Error: " . $sql . "<br>" . $conn->error . "
              </div>";
    }


}

