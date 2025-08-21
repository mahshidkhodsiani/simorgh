<?php
session_start();
include '../config.php';

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];

// Check for form submissions at the very top
if (isset($_POST['submit_pic'])) {
    $title = $_POST['title'];
    $pic = $_FILES['pic']['name'];
    $tmp_name = $_FILES['pic']['tmp_name'];

    // Determine the base folder path
    $baseDir = '../uploads/gallery/';
    $uploadDir = $baseDir . '1'; 

    // Find the next available folder index
    $folderIndex = 1;
    while (is_dir($uploadDir)) {
        $folderIndex++;
        $uploadDir = $baseDir . $folderIndex;
    }

    // Create the new folder
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Full file path to save
    $path = $uploadDir . '/' . $pic;

    // Upload the file
    if (move_uploaded_file($tmp_name, $path)) {
        $stmt = $conn->prepare("INSERT INTO gallery (title, images, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $title, $path);

        if ($stmt->execute()) {
            header("Location: new_pic.php?status=success");
            exit();
        } else {
            header("Location: new_pic.php?status=error");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: new_pic.php?status=error");
        exit();
    }
}

// Handle delete action (using GET as per original code for now, but POST is recommended)
if (isset($_GET['delete_photo'])) {
    $id_photo = $_GET['id_photo'];

    $sql_fetch = "SELECT images FROM gallery WHERE id = ?";
    $stmt_fetch = $conn->prepare($sql_fetch);
    $stmt_fetch->bind_param("i", $id_photo);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $row_fetch = $result_fetch->fetch_assoc();
    $file_path = $row_fetch['images'];
    $stmt_fetch->close();

    // Delete the file from the server
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    // Delete the database entry
    $sql_delete = "DELETE FROM gallery WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_photo);

    if ($stmt_delete->execute()) {
        header("Location: new_pic.php?status=success");
        exit();
    } else {
        header("Location: new_pic.php?status=error");
        exit();
    }
    $stmt_delete->close();
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت گالری</title>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <?php include 'includes.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Vazirmatn', sans-serif;
        }
        .main-content {
            padding: 20px;
        }
        .card-form, .table-section {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 30px;
            border: none;
        }
        .table-header {
            background-color: #4a5d73;
            color: white;
            padding: 10px;
            border-radius: 8px 8px 0 0;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.03);
        }
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-md-9 main-content">
                <h3 class="text-center mb-4">مدیریت گالری تصاویر و ویدیوها</h3>

                <div class="card-form">
                    <h5 class="mb-3">افزودن تصویر به گالری</h5>
                    <form action="" enctype="multipart/form-data" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">عنوان رسانه:</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="عنوان را اینجا وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pic" class="form-label">آپلود تصویر یا ویدیو:</label>
                                <input type="file" name="pic" class="form-control" id="pic" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn btn-outline-success" type="submit" name="submit_pic">
                                <i class="fas fa-plus-circle me-2"></i>ثبت در گالری
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-section">
                    <div class="table-header">
                        <i class="fas fa-list-alt me-2"></i>لیست رسانه‌های گالری
                    </div>
                    <div class="table-responsive mt-3">
                        <?php
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        $sql = "SELECT * FROM gallery ORDER BY id DESC LIMIT ? OFFSET ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $items_per_page, $offset);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">عنوان</th>
                                        <th scope="col" class="text-center">رسانه</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) {
                                        $mediaPath = $row['images'];
                                        $fileExtension = strtolower(pathinfo($mediaPath, PATHINFO_EXTENSION));
                                        $isVideo = in_array($fileExtension, ['mp4', 'mov', 'avi', 'mkv', 'm4v', 'webm']);
                                    ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= htmlspecialchars($row['title']) ?></td>
                                            <td class="text-center">
                                                <?php if ($isVideo) : ?>
                                                    <video height="50px" controls>
                                                        <source src="<?= htmlspecialchars($mediaPath) ?>" type="video/<?= $fileExtension ?>">
                                                        مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                                    </video>
                                                <?php else : ?>
                                                    <img src="<?= htmlspecialchars($mediaPath) ?>" height="50px" alt="<?= htmlspecialchars($row['title']) ?>">
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="edit_pic.php?id_photo=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm">
                                                    <i class="fas fa-edit me-1"></i>ویرایش
                                                </a>
                                                <a href="?delete_photo=1&id_photo=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()">
                                                    <i class="fas fa-trash-alt me-1"></i>حذف
                                                </a>
                                            </td>
                                        </tr>
                                    <?php $a++; } ?>
                                </tbody>
                            </table>
                            <?php
                            $sql_count = "SELECT COUNT(*) AS total FROM gallery";
                            $result_count = $conn->query($sql_count);
                            $row_count = $result_count->fetch_assoc();
                            $total_items = $row_count['total'];
                            $total_pages = ceil($total_items / $items_per_page);
                            ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                        <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php } ?>
                                    <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php } else { ?>
                            <div class="alert alert-warning text-center" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>هیچ محتوایی در گالری وجود ندارد.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">موفقیت</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                عملیات با موفقیت انجام شد!
            </div>
        </div>
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">خطا</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                خطایی در انجام عملیات رخ داد!
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm("آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟");
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                const successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
            } else if (urlParams.get('status') === 'error') {
                const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
            }
        });
    </script>
</body>

</html>