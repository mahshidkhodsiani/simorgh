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
    <title>مدیریت شب‌های تهران</title>

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

                <!-- فرم ثبت برنامه شب‌های تهران -->
                <form id="articleForm" enctype="multipart/form-data" method="POST" class="border p-2">
                    <div class="row">
                        <div class="col-6">
                            <label for="title">نام برنامه (شب‌های تهران):</label>
                            <input type="text" id="title" name="title" class="form-control mb-2"
                                placeholder="عنوان برنامه را وارد کنید" required>

                            <label for="mp3">آپلود فایل صوتی:</label>
                            <input type="file" name="mp3" class="form-control" id="inputGroupFile02" accept="audio/*"
                                required>
                        </div>
                        <div class="col-6">
                            <label for="kind">نوع برنامه:</label>
                            <input type="text" id="kind" name="kind" class="form-control mb-2"
                                placeholder="نوع برنامه را وارد کنید" required>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-success" type="submit" name="submit_radio_tehran">ثبت برنامه
                                شب‌های تهران</button>
                        </div>
                    </div>
                </form>

                <br>

                <div class="row mt-5">
                    <div class="col-md-11">
                        <div class="table-responsive">
                            <?php
                        // Pagination configuration
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        // Get total records
                        $total_sql = "SELECT COUNT(*) AS total FROM radio_tehran";
                        $total_result = $conn->query($total_sql);
                        $total_row = $total_result->fetch_assoc();
                        $total_items = $total_row['total'];
                        $total_pages = ceil($total_items / $items_per_page);

                        // Get paginated data
                        $sql = "SELECT * FROM radio_tehran ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                            <table class="table border border-4">
                                <h4>لیست برنامه‌های شب‌های تهران :</h4>
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">ردیف</th>
                                        <th scope="col" class="text-center">عنوان</th>
                                        <th scope="col" class="text-center">نوع برنامه</th>
                                        <th scope="col" class="text-center">برنامه</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $a ?></th>
                                        <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['program_type']) ?></td>
                                        <td class="text-center">
                                            <audio controls>
                                                <source src='<?= htmlspecialchars($row['file_path']) ?>'
                                                    type='audio/mpeg'>
                                            </audio>
                                        </td>
                                        <td class="text-center">
                                            <a href="edit_radio_tehran.php?id_radio=<?= $row['id'] ?>"
                                                class="btn btn-outline-warning btn-sm">ویرایش</a>
                                            <a href="?delete_radio_tehran=<?= $row['id'] ?>"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirmDelete()">حذف</a>
                                        </td>
                                    </tr>
                                    <?php $a++; } ?>
                                </tbody>
                            </table>

                            <!-- Pagination Links -->
                            <?php if ($total_pages > 1) { ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                    </li>
                                    <?php
                                        $start_page = max(1, $current_page - 1);
                                        $end_page = min($total_pages, $start_page + 2);
                                        if ($end_page - $start_page < 2 && $start_page > 1) {
                                            $start_page = max(1, $end_page - 2);
                                        }
                                        for ($i = $start_page; $i <= $end_page; $i++) { ?>
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
                            <?php } ?>

                            <?php } else { ?>
                            <p>هیچ برنامه‌ای برای شب‌های تهران یافت نشد.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    function confirmDelete() {
        return confirm("آیا مطمئن هستید که می‌خواهید این برنامه را حذف کنید؟");
    }
    </script>

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
// ========== پردازش فرم ثبت ==========
if (isset($_POST['submit_radio_tehran'])) {

    $title = $_POST['title'];
    $programType = $_POST['kind'];

    $dest_path = null;

    if (isset($_FILES['mp3']) && $_FILES['mp3']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['mp3']['tmp_name'];
        $fileName = $_FILES['mp3']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../upload/radios/tehran/';
        
        // Create directory if not exists
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $dest_path)) {
            echo "<script>alert('خطا در آپلود فایل');</script>";
            $dest_path = null;
        }
    }

    if ($dest_path) {
        $sql = "INSERT INTO radio_tehran (title, program_type, file_path) VALUES('$title', '$programType', '$dest_path')";
        if ($conn->query($sql)) {
            echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                    <div class='toast-header bg-success text-white'>
                        <strong class='mr-auto'>موفق</strong>
                        <button type='button' class='ml-2 mb-1 close' data-dismiss='toast'>&times;</button>
                    </div>
                    <div class='toast-body'>برنامه شب‌های تهران با موفقیت ثبت شد!</div>
                  </div>
                  <script>
                    $(document).ready(function(){
                        $('#successToast').toast('show');
                        setTimeout(function(){ window.location.href = 'new_radio_tehran.php'; }, 2000);
                    });
                  </script>";
        } else {
            echo "<div class='alert alert-danger'>خطا در ثبت: " . $conn->error . "</div>";
        }
    }
}

// ========== پردازش حذف ==========
if (isset($_GET['delete_radio_tehran'])) {
    $id_radio = (int)$_GET['delete_radio_tehran'];
    
    // ابتدا مسیر فایل را بگیریم تا فایل را هم حذف کنیم
    $file_sql = "SELECT file_path FROM radio_tehran WHERE id = $id_radio";
    $file_res = $conn->query($file_sql);
    if ($file_res->num_rows > 0) {
        $file_row = $file_res->fetch_assoc();
        $file_path = $file_row['file_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $sql = "DELETE FROM radio_tehran WHERE id = $id_radio";
    if ($conn->query($sql)) {
        echo "<div id='successToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 20px; right: 20px; width: 300px;'>
                <div class='toast-header bg-success text-white'>
                    <strong>موفق</strong>
                    <button type='button' class='close' data-dismiss='toast'>&times;</button>
                </div>
                <div class='toast-body'>برنامه مورد نظر حذف شد.</div>
              </div>
              <script>
                $(document).ready(function(){
                    $('#successToast').toast('show');
                    setTimeout(function(){ window.location.href = 'new_radio_tehran.php'; }, 1500);
                });
              </script>";
    } else {
        echo "<div class='alert alert-danger'>خطا در حذف: " . $conn->error . "</div>";
    }
}
?>