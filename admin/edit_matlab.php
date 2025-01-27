<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
// $admin = $_SESSION["all_data"]['admin'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خانه</title>


    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';
    // include 'functions.php';
    // include 'PersianCalendar.php';
    ?>



    <link href="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jodit/build/jodit.min.js"></script>

</head>

<body>

   

<?php include 'header.php'; ?>
    <div class="container-fluid">


        <div class="row">
            <div class="col-md-3 d-flex">
                <?php
                include 'sidebar.php';
                ?>
              
            </div>

            <div class="col-md-8 mt-5">

            <?php
            if(isset($_GET['id_matlab'])){
                $id_article = $_GET['id_matlab'];
                $sql = "SELECT * FROM courses WHERE id = $id_article";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                }else{
                    echo "<h2 style= 'text-align: center'>چنین مقاله ای پیدا نشد دوباره تلاش کنید !</h2>" ;
                }
                ?>

           
              
            <form action="" method="post" enctype="multipart/form-data" novalidate>
                <div class="row">
                    <!-- عنوان مطلب -->
                    <div class="col-6">
                        <label for="title">عنوان مطلب:</label>
                        <input type="text" id="title" name="title" class="form-control mb-2" 
                            value="<?= isset($row['title']) ? htmlspecialchars($row['title']) : '' ?>" required>
                    </div>

                    <!-- تصویر شاخص -->
                    <div class="col-6">
                        <label for="image">تصویر شاخص:</label>
                        <input type="file" name="image" class="form-control" id="inputGroupFile02" accept="image/*">
                        <?php if (!empty($row['images'])): ?>
                            <small>تصویر فعلی: <?= htmlspecialchars($row['images']) ?></small>
                        <?php endif; ?>
                    </div>

                    <!-- انتخاب دسته‌بندی -->
                    <div class="col-6">
                        <label for="category">انتخاب دسته‌بندی:</label>
                        <select name="category" id="category" class="form-control" onchange="toggleCourseOptions()">
                            <option value="matlab" <?= (isset($row['category']) && $row['category'] === 'matlab') ? 'selected' : '' ?>>
                                مطلب جدید
                            </option>
                            <option value="course" <?= (isset($row['category']) && $row['category'] === 'course') ? 'selected' : '' ?>>
                                دوره جدید
                            </option>
                        </select>
                    </div>

                    <!-- تنظیمات مخصوص دوره -->
                    <div class="col-6" id="courseOption" style="display: <?= (isset($row['category']) && $row['category'] === 'course') ? 'block' : 'none' ?>;">
                        <label for="courseHeader">نمایش در فهرست دوره‌ها:</label>
                        <select name="courseHeader" class="form-control">
                            <option value="0" <?= (isset($row['show_header']) && !$row['show_header']) ? 'selected' : '' ?>>خیر</option>
                            <option value="1" <?= (isset($row['show_header']) && $row['show_header']) ? 'selected' : '' ?>>بله</option>
                        </select>

                        <label for="coursePrice">قیمت دوره:</label>
                        <input type="text" name="coursePrice" class="form-control mb-2" 
                            value="<?= isset($row['coursePrice']) ? htmlspecialchars($row['coursePrice']) : '' ?>" 
                            placeholder="قیمت را اینجا وارد کنید">
                    </div>
                </div>
                <br>

                <!-- ویرایشگر متن -->
                <textarea id="editor" name="content"><?= isset($row['text']) ? htmlspecialchars($row['text']) : '' ?></textarea>
                <script>
                    const editor = new Jodit('#editor');
                </script>
                <br>

                <button name="submit_post" class="btn btn-primary">ثبت</button>
            </form>


            
            <?php
                }else {
                echo "<h2 style= 'text-align: center'>هنوز مقاله ای انتخاب نکردید !</h2>" ;
            }
            ?>

                
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });

            // Initialize Summernote
            $('#summernote').summernote({
                hint: {
                    mentions: ['jayden', 'sam', 'alvin', 'david'],
                    match: /\B@(\w*)$/,
                    search: function(keyword, callback) {
                        callback($.grep(this.mentions, function(item) {
                            return item.indexOf(keyword) == 0;
                        }));
                    },
                    content: function(item) {
                        return '@' + item;
                    }
                }
            });

            // Transfer content from Summernote to hidden input field before form submission
            $('#articleForm').on('submit', function() {
                var summernoteContent = $('#summernote').summernote('code');
                $('#content').val(summernoteContent);
            });
        });
    </script>


    <script>
        $('form').submit(function() {
        $('#editor').val(editor.getEditorValue()); // انتقال محتوا به textarea
        });
    </script>


</body>

</html>


<?php




if (isset($_POST['submit_post'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['category'];
    $amount = $_POST['coursePrice'];
    $courseHeader = ($_POST['courseHeader'] == 1) ? 1 : 0;

    // Escape strings to prevent SQL injection
    $title = $conn->real_escape_string($title);
    $type = $conn->real_escape_string($type);

    $image = $_FILES['image'];
    $imageUpdated = false; // وضعیت آپدیت تصویر

    // مسیر آپلود تصویر
    $baseDir = '../uploads/course/';
    $uploadDir = $baseDir . $id_article; // استفاده از `id` برای پوشه

    // ساخت پوشه اگر وجود ندارد
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!empty($image['name'])) { // بررسی وجود فایل برای آپلود
        $originalFileName = basename($image['name']); // نام اصلی فایل
        $extension = pathinfo($originalFileName, PATHINFO_EXTENSION); // استخراج پسوند فایل
        $uniqueFileName = uniqid() . '.' . $extension; // نام یکتا برای فایل
        $finalPath = $uploadDir . '/' . $uniqueFileName; // مسیر کامل فایل

        if (move_uploaded_file($image['tmp_name'], $finalPath)) {
            $relativePath = str_replace('../', '', $finalPath); // مسیر نسبی برای ذخیره در دیتابیس
            $imageUpdated = true;
        } else {
            echo "خطا در آپلود تصویر!";
            exit;
        }
    }

    // کوئری آپدیت با توجه به وجود یا عدم وجود تصویر جدید
    if ($imageUpdated) {
        $sql = "UPDATE courses SET title = '$title', slug = '$title', text = '$content', amount = '$amount', category = '$type', show_header = '$courseHeader', images = '$relativePath' WHERE id = $id_article";
    } else {
        $sql = "UPDATE courses SET title = '$title', slug = '$title', text = '$content', amount = '$amount', category = '$type', show_header = '$courseHeader' WHERE id = $id_article";
    }


    // اجرای کوئری
    if ($conn->query($sql)) {
        // Success Toast
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    پست شما با موفقیت به‌روزرسانی شد!
                </div>
              </div>
              <script>
              $(document).ready(function(){
                  $('#successToast').toast({
                      autohide: true,
                      delay: 3000
                  }).toast('show');
                  setTimeout(function(){
                      window.location.href = 'new_matlab';
                  }, 3000);
              });
              </script>";
    } else {
        echo "خطا در به‌روزرسانی پست: " . $conn->error;
    }
}
