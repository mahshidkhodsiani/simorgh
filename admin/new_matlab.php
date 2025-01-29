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
    <!-- <link rel="stylesheet" href="styles.css"> -->



 


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

                <h5>***دقت کنید هرآنچه اینجا وارد کنید در سایت اصلی اولین مطلب می آید. ***</h5>
                <hr>
                <br>
                <form action="" method="post" enctype='multipart/form-data' novalidate>
                
                <div class="row">
                    <div class="col-6">
                        <label for="title">عنوان مطلب:</label>
                        <input type="text" id="title" name="title" class="form-control mb-2" placeholder="عنوان را اینجا وارد کنید" required>
                    </div>
                    <div class="col-6">
                        <label for="image">تصویر شاخص:</label>
                        <input type="file" name="image" class="form-control" id="inputGroupFile02" required>
                    </div>
                    <div class="col-6">
                        <label for="category">انتخاب کنید</label>
                        <select name="category" id="category" class="form-control">
                            <option value="matlab">مطلب جدید</option>
                            <option value="course">دوره جدید</option>
                        </select>
                    </div>

                    <div class="col-6" id="courseOption" style="display: none;" >
                        <label>اسم دوره:</label>
                        <input placeholder="اسم دوره جهت ذخیره در دیتابیس" class="form-control" name="courseName">

                        <label for="courseHeader">نمایش در فهرست دوره ها سایت اصلی</label>
                        <select name="courseHeader" class="form-control">
                            <option value="0">خیر</option>
                            <option value="1">بله</option>
                        </select>

                        <label>قیمت دوره (ریال)</label>
                        <input type="text" name="coursePrice" class="form-control mb-2" placeholder="قیمت را اینجا وارد کنید" required>


                    </div>

                </div>
                <br>

                <textarea id="editor" name="content"></textarea>
                <script>
                    const editor = new Jodit('#editor');
                </script>

                
                <br>

                <button name="submit_post" class="btn btn-primary">ثبت </button>
                </form>


                <div class="row mt-5">
                    <div class="col-md-11">
                        <div class="table-responsive">
                            <?php
                            // Pagination configuration
                            $items_per_page = 10; // Number of items per page
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                            // Calculate the offset for the SQL query
                            $offset = ($current_page - 1) * $items_per_page;

                            // SQL query to retrieve a subset of rows based on pagination
                            $sql = "SELECT * FROM courses ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                            ?>
                                <table class="table border border-4">
                                    <h4>آخرین مقالات :</h4>
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">ردیف</th>
                                            <th scope="col" class="text-center">اسم مقاله</th>
                                            <th scope="col" class="text-center">بدنه</th>
                                            <th scope="col" class="text-center">نمایش در فهرست</th>
                                            <th scope="col" class="text-center">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            // Limit body content to 2 lines
                                            $body_text = strip_tags($row['text']); // Remove any HTML tags
                                            $max_length = 150; // Adjust the max length to fit approximately 2 lines
                                            if (strlen($body_text) > $max_length) {
                                                $body_text = substr($body_text, 0, $max_length) . '...';
                                            }
                                            if($row['show_header']==1){
                                                $show ="بله";
                                            }else{
                                                 $show ="خیر";
                                            }
                                        ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= $row['title'] ?></td>
                                            <td class="text-center"><?= $body_text ?></td>
                                            <td class="text-center"><?= $show ?></td>
                                            <td class="text-center">
                                                <form action="" method="POST">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="id_art">
                                                    <button type="submit" name="delete_article" 
                                                        class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">حذف</button>
                                                    
                                                         <?php
                                                            if($row['category'] == 'course'){
                                                                if($row['show_header']){?>
                                                                <button class="btn btn-outline-warning btn-sm" name="no_show"
                                                                onclick="return confirmDelete()">عدم نمایش در فهرست </button>
                                                                <?php
                                                                }else{
                                                                
                                                                    ?>
                                                                    <button class="btn btn-outline-warning btn-sm" name="yes_show"
                                                                    onclick="return confirmDelete()"> نمایش در فهرست </button>
                                                                <?php
                                                                }
                                                            }
                                                         ?>
                                                    </button>
                                                    <a href="edit_matlab.php?id_matlab=<?=$row['id']?>" class="btn btn-outline-info">ادیت مطلب</a>
                                                </form>
                                            </td>
                                            <script>
                                                function confirmDelete() {
                                                    return confirm("آیا مطمئن هستید ؟ ");
                                                }
                                            </script>
                                        </tr>
                                        <?php
                                            $a++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                // Pagination links
                                $sql = "SELECT COUNT(*) AS total FROM courses";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $total_items = $row['total'];
                                $total_pages = ceil($total_items / $items_per_page);

                                $start_page = max(1, $current_page - 1); // Start at the current page - 1 or 1 if the current page is 1
                                $end_page = min($total_pages, $start_page + 2); // Show 3 pages max

                                // Ensure there are always 3 pages in the pagination unless it's at the beginning or end
                                if ($end_page - $start_page < 2 && $start_page > 1) {
                                    $start_page = max(1, $end_page - 2);
                                }
                                ?>

                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <!-- Previous Button -->
                                        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                        </li>

                                        <?php
                                        // Page Numbers
                                        for ($i = $start_page; $i <= $end_page; $i++) {
                                        ?>
                                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                            </li>
                                        <?php
                                        }
                                        ?>

                                        <!-- Next Button -->
                                        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                        </li>
                                    </ul>
                                </nav>

                            <?php
                            } else {
                                echo "<p>هیچ مشابهی پیدا نشد.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>



                
            </div>
        </div>
    </div>


    <script>
        $('form').submit(function() {
        $('#editor').val(editor.getEditorValue()); // انتقال محتوا به textarea
        });



        // وقتی که انتخاب کاربر تغییر می‌کند
        document.getElementById('category').addEventListener('change', function() {
            var category = this.value; // دریافت مقدار انتخابی
            var courseOption = document.getElementById('courseOption'); // بخش مربوط به دوره جدید

            // اگر "دوره جدید" انتخاب شود نمایش داده شود، در غیر اینصورت مخفی شود
            if (category === 'course') {
                courseOption.style.display = 'block';
            } else {
                courseOption.style.display = 'none';
            }
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
    $courseName = $_POST['courseName'];
    if($_POST['courseHeader'] == 1){
        $courseHeader = 1;
    }else{
        $courseHeader = 0;
    }
   

    // Escape strings to prevent SQL injection
    $title = $conn->real_escape_string($title);
    $type = $conn->real_escape_string($type);

    $image = $_FILES['image'];

    // تعیین مسیر پایه پوشه
    $baseDir = '../uploads/course/';
    $uploadDir = $baseDir . '1'; // شروع از پوشه 1

    // پیدا کردن شماره پوشه بعدی
    $folderIndex = 1;
    while (is_dir($uploadDir)) {
        $folderIndex++;
        $uploadDir = $baseDir . $folderIndex;
    }

    // ساخت پوشه جدید
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // پردازش فایل آپلود شده
    $originalFileName = basename($image['name']); // نام اصلی فایل
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION); // استخراج پسوند فایل
    $uniqueFileName = uniqid() . '.' . $extension; // نام یکتا برای فایل
    $finalPath = $uploadDir . '/' . $uniqueFileName; // مسیر کامل فایل

    if (move_uploaded_file($image['tmp_name'], $finalPath)) {
        $relativePath = str_replace('../', '', $finalPath); // مسیر نسبی برای ذخیره در دیتابیس

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO courses (title, slug, text, amount, category, course, show_header, images, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssssss", $title, $title, $content, $amount, $type, $courseName, $courseHeader, $relativePath);

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
                        پست شما با موفقیت ثبت شد!
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
            echo "خطا در ذخیره پست!";
        }

        $stmt->close();
    } else {
        echo "خطا در آپلود تصویر!";
    }
}



if(isset($_POST['delete_article'])){

    $id_art = $_POST['id_art'];

    $sql = "DELETE FROM courses WHERE id = $id_art";
    $result = $conn->query($sql);
    if ($result) {
        // Use Bootstrap's toast component to show a success toast message
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>Success</strong>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='toast-body'>
                مقاله با موفقیت حذف شد!
            </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast('show');
                setTimeout(function(){
                    $('#successToast').toast('hide');
                    // Redirect after 3 seconds
                    setTimeout(function(){
                        window.location.href = 'new_matlab';
                    }, 1000);
                }, 1000);
            });
            </script>";
    } else {
        // Use Bootstrap's toast component to show an error toast message
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در حذف مقاله پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){
                        $('#errorToast').toast('hide');
                    }, 1000);
                });
              </script>";

        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}

if (isset($_POST['no_show'])){
    $id_art = $_POST['id_art'];
    $sql = "UPDATE courses SET show_header = 0 WHERE id = $id_art";
    $result = $conn->query($sql);
    if ($result) {
    // Success Toast
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
        <div class='toast-header bg-success text-white'>
            <strong class='mr-auto'>Success</strong>
            <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        <div class='toast-body'>
            پست شما با موفقیت ثبت شد!
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
    echo "خطا در ذخیره پست!";
    }

}

if(isset($_POST['yes_show'])){
    $id_art = $_POST['id_art'];
    $sql = "UPDATE courses SET show_header = 1 WHERE id = $id_art";
    $result = $conn->query($sql);
    if ($result) {
        // Success Toast
            echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>Success</strong>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='toast-body'>
                پست شما با موفقیت ثبت شد!
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
        echo "خطا در ذخیره پست!";
        }

}