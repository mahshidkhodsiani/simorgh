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


    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';

    ?>





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

            <h2>افزودن ویدیوی جدید</h2>
              
            <form action="" enctype="multipart/form-data" method="POST" class="border p-2">
                <div class="row">
                    <div class="col-6">
                        <label for="title">عنوان ویدیو:</label>
                        <input type="text" id="title" name="title" class="form-control mb-2" placeholder="عنوان را اینجا وارد کنید" required>

                    
                    </div>
                    <div class="col-6">
                        <label for="new_video">اپلود فایل صوتی:</label>
                        <input type="file" name="new_video" class="form-control" id="" required>
                    </div>
                  
                </div>

                <br>

                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-6">
                        <button class="btn btn-outline-success" type="submit" name="submit_video">ثبت در ویدیوها</button>
                    </div>
                </div>
            </form>

            <br>


            <div class="table-responsive mt-4">
                <?php
                // صفحه‌بندی ویدیوها
                $items_per_page = 10; // تعداد ویدیو در هر صفحه
                $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1; // صفحه فعلی
                $offset = ($current_page - 1) * $items_per_page;

                // کوئری برای گرفتن ویدیوها
                $sql = "SELECT * FROM videos ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $a = ($current_page - 1) * $items_per_page + 1; // شمارنده ردیف‌ها
                ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="text-center">عنوان</th>
                                <th class="text-center">پخش ویدیو</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td class="text-center"><?= $a ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                    <td class="text-center">
                                        <video height="50" controls>
                                            <source src="<?= htmlspecialchars($row['path']) ?>" type="video/mp4">
                                            مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                        </video>
                                    </td>
                                    <td class="text-center">
                                        <form action="" method="GET">
                                            <input type="hidden" name="video_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" value="<?= $row['id'] ?>" name="id_photo">
                                                    <a href="edit_video.php?video_id=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm"> ویرایش</a>
                                                    
                                            <button type="submit" name="delete_video" class="btn btn-outline-danger btn-sm" onclick="return confirm('آیا از حذف این ویدیو مطمئن هستید؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php $a++; } ?>
                        </tbody>
                    </table>

                    <?php
                    // محاسبه تعداد کل صفحات
                    $sql = "SELECT COUNT(*) AS total FROM videos";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $total_pages = ceil($row['total'] / $items_per_page);
                    ?>

                    <!-- نمایش صفحه‌بندی -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $current_page - 1 ?>">قبلی</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php } ?>
                            <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $current_page + 1 ?>">بعدی</a>
                            </li>
                        </ul>
                    </nav>
                <?php
                } else {
                    echo "<p>هیچ ویدیویی یافت نشد.</p>";
                }
                ?>
            </div>





                
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active');
                $(this).addClass('active');
            });
        });

    </script>

    <script>
        function toggleCheckbox(checkedId, uncheckedId) {
            var checkedBox = document.getElementById(checkedId);
            var uncheckedBox = document.getElementById(uncheckedId);
            if (checkedBox.checked) {
                uncheckedBox.checked = false;
            }
        }
    </script>




</body>

</html>

<?php
if (isset($_POST['submit_video'])) {
    $title = $_POST['title'];
    $new_video = $_FILES['new_video']['name'];
    $tmp_name = $_FILES['new_video']['tmp_name'];

    // مسیر پایه پوشه
    $baseDir = '../uploads/video/';
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

    // مسیر نهایی فایل ویدیو
    $path = $uploadDir . '/' . $new_video;

    // آپلود فایل
    if (move_uploaded_file($tmp_name, $path)) {
        // ذخیره اطلاعات ویدیو در دیتابیس
        $stmt = $conn->prepare("INSERT INTO videos (title, path, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $title, $path);

        if ($stmt->execute()) {
            echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; top: 20px; right: 20px; width: 300px; z-index: 1055;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>Success</strong>
            </div>
            <div class='toast-body'>
                ویدیو با موفقیت آپلود شد!
            </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#successToast').toast({
                        autohide: true,
                        delay: 3000
                    }).toast('show');
                    setTimeout(function(){
                        window.location.href = 'new_video';
                    }, 3000);
                });
            </script>";
        } else {
            echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; top: 20px; right: 20px; width: 300px; z-index: 1055;'>
            <div class='toast-header bg-danger text-white'>
                <strong class='mr-auto'>Error</strong>
            </div>
            <div class='toast-body'>
                خطایی رخ داده، دوباره امتحان کنید!<br>Error: " . htmlspecialchars($stmt->error) . "
            </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#errorToast').toast({
                        autohide: true,
                        delay: 3000
                    }).toast('show');
                    setTimeout(function(){
                        window.location.href = 'new_video';
                    }, 3000);
                });
            </script>";
        }

        $stmt->close();
    } else {
        echo "<div id='errorToast' class='toast'>خطا در آپلود ویدیو!</div>";
    }
}


// بخش حذف ویدیو
if (isset($_GET['delete_video'])) {
    $video_id = intval($_GET['video_id']); // اطمینان از نوع عددی ID

    // ابتدا مسیر فایل ویدیو را از دیتابیس دریافت کنید
    $stmt = $conn->prepare("SELECT path FROM videos WHERE id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = '../' . $row['path']; // مسیر فایل ویدیو

        // حذف رکورد از دیتابیس
        $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
        $stmt->bind_param("i", $video_id);

        if ($stmt->execute()) {
            // حذف فایل ویدیو از سرور
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // پیام موفقیت
            echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    ویدیو با موفقیت حذف شد!
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){
                        window.location.href = 'new_video';
                    }, 3000);
                });
            </script>";
        } else {
            // پیام خطا
            echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در حذف ویدیو پیش آمد!
                </div>
            </div>";
        }
    } else {
        echo "<div id='errorToast' class='toast'>
            <div class='toast-header bg-warning text-white'>
                <strong class='mr-auto'>Error</strong>
            </div>
            <div class='toast-body'>
                ویدیو یافت نشد.
            </div>
        </div>";
    }

    $stmt->close();
}
?>