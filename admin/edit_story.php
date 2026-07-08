<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

include '../config.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش استوری</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php include 'includes.php'; ?>
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
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $sql = "SELECT * FROM stories WHERE id = $id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                ?>
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">✏️ ویرایش استوری</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">عنوان استوری:</label>
                                        <input type="text" id="title" name="title" class="form-control"
                                            value="<?= $row['title'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تصویر فعلی:</label>
                                        <div>
                                            <?php if(file_exists('../' . $row['image'])): ?>
                                            <img src="../<?= $row['image'] ?>"
                                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                            <?php else: ?>
                                            <span class="text-danger">تصویر وجود ندارد</span>
                                            <?php endif; ?>
                                        </div>
                                        <label for="image">تصویر جدید (اختیاری):</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="expire_type">نوع زمان‌بندی:</label>
                                        <select name="expire_type" id="expire_type" class="form-control"
                                            onchange="toggleCustomDays()">
                                            <option value="day" <?= $row['expire_type'] == 'day' ? 'selected' : '' ?>>۱
                                                روز</option>
                                            <option value="week" <?= $row['expire_type'] == 'week' ? 'selected' : '' ?>>
                                                ۱ هفته</option>
                                            <option value="month"
                                                <?= $row['expire_type'] == 'month' ? 'selected' : '' ?>>۱ ماه</option>
                                            <option value="custom"
                                                <?= $row['expire_type'] == 'custom' ? 'selected' : '' ?>>سفارشی</option>
                                            <option value="unlimited"
                                                <?= $row['expire_type'] == 'unlimited' ? 'selected' : '' ?>>نامحدود
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="customDaysDiv"
                                    style="display: <?= $row['expire_type'] == 'custom' ? 'block' : 'none' ?>;">
                                    <div class="form-group">
                                        <label for="expire_days">تعداد روز:</label>
                                        <input type="number" name="expire_days" id="expire_days" class="form-control"
                                            min="1" value="<?= $row['expire_days'] ?: 7 ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">وضعیت:</label>
                                        <select name="status" class="form-control">
                                            <option value="1" <?= $row['status'] == 1 ? 'selected' : '' ?>>فعال</option>
                                            <option value="0" <?= $row['status'] == 0 ? 'selected' : '' ?>>غیرفعال
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="update_story" class="btn btn-primary mt-3">به‌روزرسانی</button>
                            <a href="new_story" class="btn btn-secondary mt-3">بازگشت</a>
                        </form>
                    </div>
                </div>
                <?php
                    } else {
                        echo "<div class='alert alert-danger'>استوری پیدا نشد!</div>";
                    }
                } else {
                    echo "<div class='alert alert-warning'>شناسه استوری مشخص نیست!</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
    function toggleCustomDays() {
        var type = document.getElementById('expire_type').value;
        document.getElementById('customDaysDiv').style.display = (type === 'custom') ? 'block' : 'none';
    }
    </script>

</body>

</html>

<?php
// ===== به‌روزرسانی استوری =====
if (isset($_POST['update_story'])) {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $expire_type = $_POST['expire_type'];
    $expire_days = ($expire_type == 'custom') ? intval($_POST['expire_days']) : null;
    $status = intval($_POST['status']);

    // محاسبه تاریخ انقضا
    $expire_at = null;
    $now = new DateTime();
    
    if ($expire_type == 'day') {
        $expire_at = $now->modify('+1 day')->format('Y-m-d H:i:s');
    } elseif ($expire_type == 'week') {
        $expire_at = $now->modify('+1 week')->format('Y-m-d H:i:s');
    } elseif ($expire_type == 'month') {
        $expire_at = $now->modify('+1 month')->format('Y-m-d H:i:s');
    } elseif ($expire_type == 'custom' && $expire_days > 0) {
        $expire_at = $now->modify("+$expire_days days")->format('Y-m-d H:i:s');
    } elseif ($expire_type == 'unlimited') {
        $expire_at = null;
    }

    // آپلود تصویر جدید (اگر آپلود شده باشد)
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../upload/images/stories/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . rand(1000, 9999) . '.' . $ext;
        $uploadFile = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // حذف تصویر قدیمی
            $old_img_sql = "SELECT image FROM stories WHERE id = $id";
            $old_img_result = $conn->query($old_img_sql);
            if ($old_img_result->num_rows > 0) {
                $old_img_row = $old_img_result->fetch_assoc();
                $old_file = '../' . $old_img_row['image'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            $imagePath = "upload/images/stories/" . $filename;
        }
    }

    // ساخت کوئری
    if ($imagePath) {
        $stmt = $conn->prepare("UPDATE stories SET title = ?, image = ?, expire_type = ?, expire_days = ?, expire_at = ?, status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("sssissi", $title, $imagePath, $expire_type, $expire_days, $expire_at, $status, $id);
    } else {
        $stmt = $conn->prepare("UPDATE stories SET title = ?, expire_type = ?, expire_days = ?, expire_at = ?, status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("sssisi", $title, $expire_type, $expire_days, $expire_at, $status, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('✅ استوری با موفقیت به‌روزرسانی شد!'); window.location.href='new_story';</script>";
    } else {
        echo "<div class='alert alert-danger'>خطا: " . $conn->error . "</div>";
    }
    $stmt->close();
}
?>