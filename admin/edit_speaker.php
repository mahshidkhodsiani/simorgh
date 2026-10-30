<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

if($_SESSION["all_data"]["admin"] != 1){
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
    <title>ویرایش گوینده</title>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">

    <?php
    include 'includes.php';
    include '../config.php';
    // include 'functions.php';
    // include 'PersianCalendar.php';
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

                <?php
            if (isset($_GET['id_speaker'])) {
                $id_article = intval($_GET['id_speaker']);
                $stmt = $conn->prepare("SELECT * FROM speakers WHERE id = ?");
                $stmt->bind_param("i", $id_article);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $stmt->close();

                    // --- پردازش مسیر عکس فعلی ---
                    $currentImage = $row['image'] ?? '';
                    if (!empty($currentImage)) {
                        $imgData = json_decode($currentImage, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($imgData)) {
                            $imgSrc = $imgData['thumb'] ?? '';
                        } else {
                            $imgSrc = $currentImage;
                        }
                        if (!empty($imgSrc) && strpos($imgSrc, '../') !== 0 && strpos($imgSrc, 'http') !== 0 && strpos($imgSrc, '/') !== 0) {
                            $imgSrc = '../' . $imgSrc;
                        }
                    } else {
                        $imgSrc = '';
                    }

                    // --- پردازش مسیر صدا فعلی ---
                    $currentMp3 = $row['mp3'] ?? '';
                    if (!empty($currentMp3) && $currentMp3 !== 'NULL' && strtolower($currentMp3) !== 'null') {
                        if (strpos($currentMp3, '../') !== 0 && strpos($currentMp3, 'http') !== 0 && strpos($currentMp3, '/') !== 0) {
                            $mp3Src = '../' . $currentMp3;
                        } else {
                            $mp3Src = $currentMp3;
                        }
                    } else {
                        $mp3Src = '';
                    }
                    ?>

                <form id="articleForm" enctype="multipart/form-data" method="POST" class="border p-2">
                    <input type="hidden" name="id_speaker" value="<?= $row['id'] ?>">

                    <div class="row">
                        <div class="col-6">
                            <label for="name">نام و نام خانوادگی گوینده:</label>
                            <input type="text" id="name" name="name" class="form-control mb-2"
                                value="<?= htmlspecialchars($row['name']) ?>" required>

                            <label for="mp3">اپلود صدای جدید (اختیاری):</label>
                            <input type="file" name="mp3" class="form-control" id="inputGroupFile02" accept="audio/*">
                            <?php if (!empty($mp3Src)): ?>
                            <div class="mt-2">
                                <small class="text-muted">صدای فعلی:</small><br>
                                <audio controls preload="none" style="width: 100%;">
                                    <source src="<?= htmlspecialchars($mp3Src) ?>" type="audio/mpeg">
                                    مرورگر شما از پخش صدا پشتیبانی نمی‌کند.
                                </audio>
                            </div>
                            <?php else: ?>
                            <small class="text-danger">هنوز فایل صوتی برای این گوینده ثبت نشده است.</small>
                            <?php endif; ?>
                        </div>

                        <div class="col-6">
                            <label for="kind">نوع صدا:</label>
                            <input type="text" id="kind" name="kind" class="form-control mb-2"
                                value="<?= htmlspecialchars($row['kind']) ?>" required>

                            <label for="image">اپلود عکس جدید (اختیاری):</label>
                            <input type="file" name="image" class="form-control" id="inputGroupFile02" accept="image/*">
                            <?php if (!empty($imgSrc)): ?>
                            <div class="mt-2">
                                <small class="text-muted">عکس فعلی:</small><br>
                                <img src="<?= htmlspecialchars($imgSrc) ?>" height="80px" class="border">
                            </div>
                            <?php else: ?>
                            <small class="text-danger">هنوز عکسی برای این گوینده ثبت نشده است.</small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-success" type="submit" name="submit_speaker">ذخیره
                                تغییرات</button>
                            <a href="new_speaker" class="btn btn-outline-secondary">انصراف</a>
                        </div>
                    </div>
                </form>

                <?php
                } else {
                    $stmt->close();
                    echo "<h2 style='text-align: center'>چنین فایلی پیدا نشد دوباره تلاش کنید !</h2>";
                }
            } else {
                echo "<h2 style='text-align: center'>هنوز گوینده‌ای انتخاب نکردید !</h2>";
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
    });
    </script>

</body>

</html>


<?php
// ==================== ویرایش گوینده ====================
if (isset($_POST['submit_speaker'])) {

    // شناسه گوینده از hidden input
    $id_speaker = intval($_POST['id_speaker']);

    // مقادیر ورودی
    $name = $conn->real_escape_string($_POST['name']);
    $kind = $conn->real_escape_string($_POST['kind']);

    // --- دریافت مقادیر فعلی از دیتابیس ---
    $stmt = $conn->prepare("SELECT name, mp3, image FROM speakers WHERE id = ?");
    $stmt->bind_param("i", $id_speaker);
    $stmt->execute();
    $res = $stmt->get_result();
    $current = $res->fetch_assoc();
    $stmt->close();

    if (!$current) {
        echo "<div class='alert alert-danger mt-2'>گوینده مورد نظر یافت نشد.</div>";
        exit;
    }

    $mp3DestPath  = $current['mp3'];   // پیش‌فرض: مقدار قبلی
    $imageDestPath = $current['image']; // پیش‌فرض: مقدار قبلی

    // ========== آپلود فایل صوتی جدید ==========
    if (isset($_FILES['mp3']) && $_FILES['mp3']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['mp3']['tmp_name'];
        $fileName = $_FILES['mp3']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedAudio = ['mp3', 'wav', 'ogg', 'm4a'];
        if (!in_array($fileExtension, $allowedAudio)) {
            echo "<div class='alert alert-danger mt-2'>فرمت فایل صوتی مجاز نیست. فقط mp3, wav, ogg, m4a</div>";
        } else {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadMp3Dir = '../upload/radios/2024/';
            $mp3FullPath = $uploadMp3Dir . $newFileName;

            if (!file_exists($uploadMp3Dir)) {
                mkdir($uploadMp3Dir, 0777, true);
            }

            if (move_uploaded_file($fileTmpPath, $mp3FullPath)) {
                // حذف فایل صوتی قبلی (با هر دو حالت مسیر)
                if (!empty($current['mp3']) && $current['mp3'] !== 'NULL') {
                    $oldMp3 = $current['mp3'];
                    if (file_exists($oldMp3)) @unlink($oldMp3);
                    elseif (file_exists('../' . $oldMp3)) @unlink('../' . $oldMp3);
                }
                // مسیر ذخیره در دیتابیس با ../ مثل قبلی‌ها
                $mp3DestPath = '../upload/radios/2024/' . $newFileName;
            } else {
                echo "<div class='alert alert-danger mt-2'>خطا در جابجایی فایل صوتی.</div>";
            }
        }
    }

    // ========== آپلود تصویر جدید ==========
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageNameCmps = explode(".", $imageName);
        $imageExtension = strtolower(end($imageNameCmps));

        $allowedImg = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($imageExtension, $allowedImg)) {
            echo "<div class='alert alert-danger mt-2'>فرمت تصویر مجاز نیست.</div>";
        } else {
            $newImageFileName = '1.' . $imageExtension;

            // پوشه با نام گوینده (بدون sanitize) - مثل قبلی‌ها
            $speakerDir = '../upload/sounds/' . $_POST['name'] . '/';
            $imageFullPath = $speakerDir . $newImageFileName;

            if (!file_exists($speakerDir)) {
                mkdir($speakerDir, 0777, true);
            }

            if (move_uploaded_file($imageTmpPath, $imageFullPath)) {
                // حذف تصویر قبلی (اگه مسیرش با جدید فرق داشت)
                if (!empty($current['image'])) {
                    $oldImg = $current['image'];
                    if ($oldImg !== $imageDestPath) {
                        if (file_exists($oldImg)) @unlink($oldImg);
                        elseif (file_exists('../' . $oldImg)) @unlink('../' . $oldImg);
                    }
                }
                // مسیر ذخیره در دیتابیس با ../ مثل قبلی‌ها
                $imageDestPath = '../upload/sounds/' . $_POST['name'] . '/' . $newImageFileName;
            } else {
                echo "<div class='alert alert-danger mt-2'>خطا در جابجایی تصویر.</div>";
            }
        }
    }

    // ========== بروزرسانی دیتابیس ==========
    $stmt = $conn->prepare("UPDATE speakers SET name = ?, kind = ?, mp3 = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $kind, $mp3DestPath, $imageDestPath, $id_speaker);

    if ($stmt->execute()) {
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
          <div class='toast-header bg-success text-white'>
              <strong class='mr-auto'>Success</strong>
              <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                  <span aria-hidden='true'>&times;</span>
              </button>
          </div>
          <div class='toast-body'>
              برنامه با موفقیت ویرایش شد!
          </div>
        </div>
        <script>
        $(document).ready(function(){
            $('#successToast').toast({ autohide: true, delay: 2000 }).toast('show');
            setTimeout(function(){
                window.location.href = 'new_speaker';
            }, 2000);
        });
        </script>";
    } else {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
            <div class='toast-header bg-danger text-white'>
                <strong class='mr-auto'>Error</strong>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='toast-body'>
                خطایی در ویرایش برنامه پیش آمده!
            </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#errorToast').toast({ autohide: true, delay: 3000 }).toast('show');
                setTimeout(function(){ $('#errorToast').toast('hide'); }, 3000);
            });
            </script>";

        echo "<div class='alert alert-danger mt-2'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}