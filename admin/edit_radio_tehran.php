<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش برنامه - شب‌های تهران</title>

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
                <?php include 'sidebar.php'; ?>
            </div>

            <div class="col-md-8 mt-5">

                <?php
            if (isset($_GET['id_radio'])) {
                $id_article = (int)$_GET['id_radio'];
                $sql = "SELECT * FROM radio_tehran WHERE id = $id_article";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                } else {
                    echo "<h2 style='text-align: center'>چنین فایلی پیدا نشد، دوباره تلاش کنید!</h2>";
                }
                ?>

                <form action="" method="POST" id="articleForm" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6">
                            <label for="title">نام برنامه (شب‌های تهران):</label>
                            <input type="text" id="title" name="title" class="form-control mb-2"
                                value="<?= htmlspecialchars($row['title']) ?>">

                            <label for="mp3">آپلود فایل صوتی جدید (اختیاری):</label>
                            <?php if (!empty($row['file_path'])): ?>
                            <div class="mb-2">
                                <audio controls>
                                    <source src="<?= htmlspecialchars($row['file_path']); ?>" type="audio/mpeg">
                                    مرورگر شما از پخش فایل صوتی پشتیبانی نمی‌کند.
                                </audio>
                                <div class="text-muted small">فایل فعلی - در صورت آپلود فایل جدید، جایگزین می‌شود</div>
                            </div>
                            <?php endif; ?>
                            <input type="file" name="mp3" class="form-control" id="inputGroupFile02" accept="audio/*">
                        </div>
                        <div class="col-6">
                            <label for="kind">نوع برنامه:</label>
                            <input type="text" id="kind" name="kind" class="form-control mb-2"
                                value="<?= htmlspecialchars($row['program_type']) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-warning" type="submit" name="submit_edit_tehran">ذخیره
                                تغییرات</button>
                            <a href="new_radio_tehran.php" class="btn btn-outline-secondary">بازگشت</a>
                        </div>
                    </div>
                </form>

                <?php
            } else {
                echo "<h2 style='text-align: center'>هنوز برنامه‌ای انتخاب نکردید!</h2>";
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
// ========== پردازش ویرایش ==========
if (isset($_POST['submit_edit_tehran']) && isset($_GET['id_radio'])) {
    $id_article = (int)$_GET['id_radio'];
    $title = $_POST['title'];
    $kind = $_POST['kind'];

    // Escape strings to prevent SQL injection
    $title = $conn->real_escape_string($title);
    $kind = $conn->real_escape_string($kind);

    $audioPath = '';

    // Handle the audio file upload if new file is provided
    if (isset($_FILES['mp3']) && $_FILES['mp3']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['mp3']['tmp_name'];
        $fileName = $_FILES['mp3']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory for Tehran radio files
        $uploadFileDir = '../upload/radios/tehran/';
        
        // Ensure the upload directory exists
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        // Move the file to the target directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $audioPath = $dest_path; // Save the full path for the database entry
            
            // Delete old file if exists
            $old_file_sql = "SELECT file_path FROM radio_tehran WHERE id = $id_article";
            $old_result = $conn->query($old_file_sql);
            if ($old_result->num_rows > 0) {
                $old_row = $old_result->fetch_assoc();
                if (!empty($old_row['file_path']) && file_exists($old_row['file_path'])) {
                    unlink($old_row['file_path']);
                }
            }
            
            $fileUploaded = true;
        } else {
            echo "<div class='alert alert-danger'>خطا در آپلود فایل جدید!</div>";
            exit;
        }

        // Update query when a new audio file is provided
        $stmt = $conn->prepare("UPDATE radio_tehran SET title = ?, program_type = ?, file_path = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $kind, $audioPath, $id_article);
    } else {
        // Update query when no new audio file is provided
        $stmt = $conn->prepare("UPDATE radio_tehran SET title = ?, program_type = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $kind, $id_article);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Success Toast
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px; z-index: 9999;'>
            <div class='toast-header bg-success text-white'>
                <strong class='mr-auto'>موفق</strong>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='toast-body'>
                برنامه شب‌های تهران با موفقیت ویرایش شد!
            </div>
        </div>
        <script>
        $(document).ready(function(){
            $('#successToast').toast({
                autohide: true,
                delay: 2000
            }).toast('show');
            setTimeout(function(){
                window.location.href = 'new_radio_tehran.php';
            }, 2000);
        });
        </script>";
    } else {
        // Error Toast
        echo "<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px; z-index: 9999;'>
            <div class='toast-header bg-danger text-white'>
                <strong class='mr-auto'>خطا</strong>
                <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='toast-body'>
                خطایی در ویرایش برنامه پیش آمده!<br>خطا: " . $conn->error . "
            </div>
        </div>
        <script>
        $(document).ready(function(){
            $('#errorToast').toast({
                autohide: true,
                delay: 3000
            }).toast('show');
        });
        </script>";
    }

    $stmt->close();
}
?>