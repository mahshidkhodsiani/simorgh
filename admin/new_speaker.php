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
    <title>خانه</title>

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

                <form id="articleForm" enctype="multipart/form-data" method="POST" class="border p-2">
                    <div class="row">
                        <div class="col-6">
                            <label for="name">نام و نام خانوادگی گوینده:</label>
                            <input type="text" id="name" name="name" class="form-control mb-2"
                                placeholder="نام و نام خانوادگی را اینجا وارد کنید" required>

                            <label for="mp3">اپلود صدا:</label>
                            <input type="file" name="mp3" class="form-control" id="inputGroupFile02" accept="audio/*">
                        </div>
                        <div class="col-6">
                            <label for="kind">نوع صدا:</label>
                            <input type="text" id="kind" name="kind" class="form-control mb-2" placeholder="نوع صدا"
                                required>

                            <label for="image">اپلود عکس:</label>
                            <input type="file" name="image" class="form-control" id="inputGroupFile02" accept="image/*">
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-success" type="submit" name="submit_speaker">ثبت
                                برنامه</button>
                        </div>
                    </div>
                </form>
                <br>

                <div class="row mt-5">
                    <div class="col-md-11">
                        <div class="table-responsive">
                            <?php
                            $items_per_page = 10;
                            $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                            $offset = ($current_page - 1) * $items_per_page;

                            $sql = "SELECT * FROM speakers ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                $a = ($current_page - 1) * $items_per_page + 1;
                            ?>
                            <table class="table border border-4">
                                <h4>آخرین مقالات :</h4>
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">ردیف</th>
                                        <th scope="col" class="text-center">نام</th>
                                        <th scope="col" class="text-center">نوع برنامه</th>
                                        <th scope="col" class="text-center">تصویر</th>
                                        <th scope="col" class="text-center">پخش صدا</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while ($row = $result->fetch_assoc()) {
                                            // --- پردازش تصویر ---
                                            $images = $row['image'] ?? '';
                                            $imageData = json_decode($images, true);
                                            if (json_last_error() === JSON_ERROR_NONE && is_array($imageData)) {
                                                $mediaSrc = $imageData['thumb'] ?? '';
                                            } else {
                                                $mediaSrc = $images;
                                            }

                                            if (!empty($mediaSrc)) {
                                                // اگه ../ یا http یا / نداشت، ../ اضافه کن
                                                if (strpos($mediaSrc, '../') === 0 || strpos($mediaSrc, 'http') === 0 || strpos($mediaSrc, '/') === 0) {
                                                    $mediaPath = htmlspecialchars($mediaSrc);
                                                } else {
                                                    $mediaPath = "../" . htmlspecialchars($mediaSrc);
                                                }
                                            } else {
                                                $mediaPath = '';
                                            }

                                            // --- پردازش فایل صوتی ---
                                            $mp3 = $row['mp3'] ?? '';
                                            if (!empty($mp3) && $mp3 !== 'NULL' && strtolower($mp3) !== 'null') {
                                                if (strpos($mp3, '../') === 0 || strpos($mp3, 'http') === 0 || strpos($mp3, '/') === 0) {
                                                    $mp3Path = htmlspecialchars($mp3);
                                                } else {
                                                    $mp3Path = "../" . htmlspecialchars($mp3);
                                                }
                                            } else {
                                                $mp3Path = '';
                                            }
                                        ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $a ?></th>
                                        <td class="text-center"><?= htmlspecialchars($row['name']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['kind']) ?></td>
                                        <td class="text-center">
                                            <?php if ($mediaPath): ?>
                                            <img src="<?= $mediaPath ?>" height="50px">
                                            <?php else: ?>
                                            <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($mp3Path): ?>
                                            <audio controls preload="none" style="width: 220px;">
                                                <source src="<?= $mp3Path ?>" type="audio/mpeg">
                                                مرورگر شما از پخش صدا پشتیبانی نمی‌کند.
                                            </audio>
                                            <?php else: ?>
                                            <span class="text-muted">فایلی آپلود نشده</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <form action="" method="GET" style="display:inline;">
                                                <input type="hidden" value="<?= $row['id'] ?>" name="id_speaker">
                                                <a href="edit_speaker.php?id_speaker=<?= $row['id'] ?>"
                                                    class="btn btn-outline-warning btn-sm"> ویرایش</a>
                                                <button type="submit" name="delete_speaker"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirmDelete()">حذف</button>
                                            </form>
                                        </td>
                                        <script>
                                        function confirmDelete() {
                                            return confirm("آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟");
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
                                $sql = "SELECT COUNT(*) AS total FROM speakers";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                $total_items = $row['total'];
                                $total_pages = ceil($total_items / $items_per_page);

                                $start_page = max(1, $current_page - 1);
                                $end_page = min($total_pages, $start_page + 2);

                                if ($end_page - $start_page < 2 && $start_page > 1) {
                                    $start_page = max(1, $end_page - 2);
                                }
                                ?>

                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                    </li>

                                    <?php for ($i = $start_page; $i <= $end_page; $i++) { ?>
                                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                    <?php } ?>

                                    <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                        <a class="page-link"
                                            href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
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
    $(document).ready(function() {
        $('.nav-link').click(function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
    });

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

// ==================== ثبت گوینده جدید ====================
if (isset($_POST['submit_speaker'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $programType = $conn->real_escape_string($_POST['kind']);

    // ========== آپلود فایل صوتی ==========
    // مسیر ذخیره دقیقاً مثل قبلی‌ها: با ../
    $mp3DestPath = null;
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
                // مسیر ذخیره در دیتابیس با ../ دقیقاً مثل رکوردهای قدیمی
                $mp3DestPath = '../upload/radios/2024/' . $newFileName;
            } else {
                echo "<div class='alert alert-danger mt-2'>خطا در جابجایی فایل صوتی.</div>";
            }
        }
    }

    // ========== آپلود تصویر ==========
    // دقیقاً مثل رکوردهای قدیمی: نام پوشه = نام گوینده (بدون sanitize)
    // مسیر ذخیره در دیتابیس: ../upload/sounds/{name}/1.ext
    $imageDestPath = null;
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

            // پوشه با نام گوینده (بدون تغییر) - مثل قبلی‌ها
            $speakerDir = '../upload/sounds/' . $_POST['name'] . '/';
            $imageFullPath = $speakerDir . $newImageFileName;

            if (!file_exists($speakerDir)) {
                mkdir($speakerDir, 0777, true);
            }

            if (move_uploaded_file($imageTmpPath, $imageFullPath)) {
                // مسیر ذخیره در دیتابیس با ../ دقیقاً مثل رکوردهای قدیمی
                $imageDestPath = '../upload/sounds/' . $_POST['name'] . '/' . $newImageFileName;
            } else {
                echo "<div class='alert alert-danger mt-2'>خطا در جابجایی تصویر.</div>";
            }
        }
    }

    // ========== درج در دیتابیس ==========
    $stmt = $conn->prepare("INSERT INTO speakers (name, kind, mp3, image) VALUES(?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $programType, $mp3DestPath, $imageDestPath);

    if ($stmt->execute()) {
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong class='mr-auto'>Success</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    فایل شما با موفقیت ثبت شد!
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast({ autohide: true, delay: 3000 }).toast('show');
                setTimeout(function(){ window.location.href = 'new_speaker'; }, 3000);
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
                    خطایی در افزودن فایل پیش آمده!
                </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#errorToast').toast({ autohide: true, delay: 3000 }).toast('show');
                setTimeout(function(){ $('#errorToast').toast('hide'); }, 3000);
            });
            </script>";

        echo "<div class='alert alert-danger mt-2' role='alert'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}


// ==================== حذف گوینده ====================
if (isset($_GET['delete_speaker'])) {

    $id_speaker = intval($_GET['id_speaker']);

    // اول اطلاعات فایل‌ها رو بگیر
    $stmt = $conn->prepare("SELECT mp3, image FROM speakers WHERE id = ?");
    $stmt->bind_param("i", $id_speaker);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    // حذف فایل‌های فیزیکی
    if ($row) {
        if (!empty($row['mp3'])) {
            $mp3File = $row['mp3'];
            if (file_exists($mp3File)) @unlink($mp3File);
            elseif (file_exists('../' . $mp3File)) @unlink('../' . $mp3File);
        }
        if (!empty($row['image'])) {
            $imgFile = $row['image'];
            if (file_exists($imgFile)) @unlink($imgFile);
            elseif (file_exists('../' . $imgFile)) @unlink('../' . $imgFile);
        }
    }

    // حذف رکورد
    $stmt = $conn->prepare("DELETE FROM speakers WHERE id = ?");
    $stmt->bind_param("i", $id_speaker);
    $ok = $stmt->execute();
    $stmt->close();

    if ($ok) {
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>Success</strong>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='toast-body'>
                گوینده با موفقیت حذف شد!
            </div>
            </div>
            <script>
            $(document).ready(function(){
                $('#successToast').toast('show');
                setTimeout(function(){
                    $('#successToast').toast('hide');
                    setTimeout(function(){ window.location.href = 'new_speaker'; }, 1000);
                }, 1000);
            });
            </script>";
    } else {
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
                <div class='toast-header bg-danger text-white'>
                    <strong class='mr-auto'>Error</strong>
                    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='toast-body'>
                    خطایی در حذف گوینده پیش آمده!
                </div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#errorToast').toast('show');
                    setTimeout(function(){ $('#errorToast').toast('hide'); }, 1000);
                });
              </script>";

        echo "Error: " . $conn->error;
    }
}