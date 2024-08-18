<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-7 col-sm-12 border">
                    <?php
                    if(isset($_POST['sabtenam'])){
                        if(isset($_POST['speaking1'])){
                            $course = 'فن بیان و گویندگی(مقدماتی) "16 جلسه دو ساعته" - قیمت : 7/500/000 تومان ';
                            $dargah = "speaking1";
                        }
                        if(isset($_POST['speaking2'])){
                            $course = 'فن بیان و گویندگی(پیشرفته) "16 جلسه دو ساعته" - قیمت : 8/900/000 تومان ';
                            $dargah = "speaking2";
                        }
                        if(isset($_POST['motion'])){
                            $course = 'موشن گرافیک "16 جلسه سه ساعته" - قیمت : 9/500/000 تومان ';
                            $dargah = "motion";
                        }
                        if(isset($_POST['acting1'])){
                            $course = 'بازیگری (مقدماتی) "15 جلسه سه ساعته" - قیمت : 8/800/000 تومان ';
                            $dargah = "acting1";
                        }
                        if(isset($_POST['acting2'])){
                            $course = 'بازیگری (پیشرفته) "16 جلسه سه ساعته" - قیمت : 12/800/000 تومان ';
                            $dargah = "acting2";
                        }
                        if(isset($_POST['short-speaking'])){
                            $course = 'گویندگی کوتاه مدت "5 جلسه دو ساعته" - قیمت : 2/300/000 تومان ';
                            $dargah = "short-speaking";
                        }
                        if(isset($_POST['dubbing'])){
                            $course = 'دوبله "10 جلسه سه ساعته" - قیمت : 7/500/000 تومان ';
                            $dargah = "dubbing";
                        }
                        if(isset($_POST['animation'])){
                            $course = 'انیمیشن سازی "12 جلسه " - قیمت : 7/900/000 تومان ';
                            $dargah = "animation";
                        }
                        if(isset($_POST['makeup1'])){
                            $course = 'گریم سینمایی (مقدماتی) "10 جلسه" - قیمت : 6/500/000 تومان ';
                            $dargah = "makeup1";
                        }
                        if(isset($_POST['makeup2'])){
                            $course = 'گریم سینمایی (پیشرفته) "12 جلسه" - قیمت : 8/000/000 تومان ';
                            $dargah = "makeup2";
                        }

                        ?>
                        <form class="p-2" action="" method="POST">
                            <h2 style="text-align: center;">فرم ثبت نام</h2>
                            <h6 style="text-align: right;">اطلاعات شما :</h6>
                            <div class="form-group" style="text-align: right;">
                                <label for="name">نام</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="family">نام خانوادگی</label>
                                <input type="text" class="form-control" name="family" id="family">
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="family">کد ملی</label>
                                <input type="text" class="form-control" name="family" id="family">
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="number">شماره همراه</label>
                                <input type="text" class="form-control" name="number" id="number">
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="email">ایمیل</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="age">سن</label>
                                <select class="form-control" name="age" id="age">
                                    <option value="1">زیر 18</option>
                                    <option value="2">بالای 18</option>
                                </select>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="age">وضعیت تاهل</label>
                                <select class="form-control" name="age" id="age">
                                    <option value="1">مجرد</option>
                                    <option value="2">متاهل</option>
                                </select>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="email">آدرس</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <h6 style="text-align: right;">اطلاعات ثبت نامی :</h6>
                            <div class="form-group" style="text-align: right;">
                                <label for="course">دوره انتخابی</label>
                                <select class="form-control" name="course" id="course">
                                    <option><?=$course ?></option>
                                </select>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <label for="explain">توضیحات</label>
                                <textarea class="form-control" name="explain" id="explain"></textarea>
                            </div>
                            <div class="form-group" style="text-align: right;">
                                <p>نحوه آشنایی با موسسه :</p>
                                <label for="internet">اینترنت</label>
                                <input class="form-check-input" type="checkbox" name="reference[]" value="internet" id="internet">
                                <br>
                                <label for="relation">آشنایان</label>
                                <input class="form-check-input" type="checkbox" name="reference[]" value="relation" id="relation">
                                <br>
                                <label for="others">غیره</label>
                                <input class="form-check-input" type="checkbox" name="reference[]" value="others" id="others">
                            </div>
                            <input type="hidden" name="which_course" value="<?= $dargah?>">
                            <button class="btn mb-2 mb-md-0 btn-outline-info btn-block" name="pre-submit">پرداخت</button>
                        </form>

                    <?php
                    }else{
                        echo '<h3 style="text-align: center;">هنوز دوره ای انتخاب نکردید</h3>';
                    }
                    ?>
                   

                </div>
            </div>
        </div>
 

    <?php include 'footer.php'; ?>

</body>
</html>

<?php

