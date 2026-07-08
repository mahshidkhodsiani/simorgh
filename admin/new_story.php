<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت استوری‌ها</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php include 'includes.php'; ?>
    <?php include '../config.php'; ?>
</head>

<body>

    <?php include 'header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 d-flex">
                <?php include 'sidebar.php'; ?>
            </div>

            <div class="col-md-8 mt-5">

                <!-- فرم افزودن استوری -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">➕ افزودن استوری جدید</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">عنوان استوری:</label>
                                        <input type="text" id="title" name="title" class="form-control"
                                            placeholder="مثلا: پکیج جدید" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">تصویر استوری:</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="expire_type">نوع زمان‌بندی:</label>
                                        <select name="expire_type" id="expire_type" class="form-control"
                                            onchange="toggleCustomDays()">
                                            <option value="day">۱ روز</option>
                                            <option value="week">۱ هفته</option>
                                            <option value="month">۱ ماه</option>
                                            <option value="custom">سفارشی</option>
                                            <option value="unlimited">نامحدود</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="customDaysDiv" style="display:none;">
                                    <div class="form-group">
                                        <label for="expire_days">تعداد روز:</label>
                                        <input type="number" name="expire_days" id="expire_days" class="form-control"
                                            min="1" value="7">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">وضعیت:</label>
                                        <select name="status" class="form-control">
                                            <option value="1">فعال</option>
                                            <option value="0">غیرفعال</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="submit_story" class="btn btn-success mt-3">ثبت استوری</button>
                        </form>
                    </div>
                </div>

                <!-- دکمه تست -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">🔧 ابزار تست</h5>
                    </div>
                    <div class="card-body">
                        <a href="?test_stories" class="btn btn-info">نمایش وضعیت استوری‌ها</a>
                        <a href="?reset_test" class="btn btn-secondary">بستن</a>
                    </div>
                    <?php
                    // ===== تست نمایش استوری‌ها =====
                    if (isset($_GET['test_stories'])) {
                        echo "<div class='alert alert-secondary mt-3'>";
                        echo "<h6>وضعیت استوری‌ها در دیتابیس:</h6>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered table-sm'>";
                        echo "<tr><th>ID</th><th>عنوان</th><th>تاریخ انقضا</th><th>وضعیت</th><th>نمایش</th></tr>";
                        
                        $test_sql = "SELECT *, 
                                     CASE 
                                         WHEN expire_at IS NULL THEN 'نامحدود'
                                         WHEN expire_at > NOW() THEN 'فعال'
                                         ELSE 'منقضی'
                                     END as current_status
                                     FROM stories ORDER BY id DESC";
                        $test_result = $conn->query($test_sql);
                        
                        if ($test_result->num_rows > 0) {
                            while ($row = $test_result->fetch_assoc()) {
                                $show = ($row['status'] == 1 && ($row['expire_at'] == null || $row['expire_at'] > date('Y-m-d H:i:s'))) ? '✅' : '❌';
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['title']}</td>
                                        <td>" . ($row['expire_at'] ?: 'نامحدود') . "</td>
                                        <td>{$row['current_status']}</td>
                                        <td>{$show}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>هیچ استوری وجود ندارد</td></tr>";
                        }
                        echo "</table>";
                        echo "<p class='text-muted'>تاریخ فعلی: " . date('Y-m-d H:i:s') . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>

                <!-- لیست استوری‌ها -->
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">📸 لیست استوری‌ها</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php
                            // Pagination
                            $items_per_page = 10;
                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $offset = ($current_page - 1) * $items_per_page;

                            $sql = "SELECT * FROM stories ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $a = ($current_page - 1) * $items_per_page + 1;
                            ?>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">تصویر</th>
                                        <th class="text-center">عنوان</th>
                                        <th class="text-center">زمان</th>
                                        <th class="text-center">انقضا</th>
                                        <th class="text-center">وضعیت</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = $result->fetch_assoc()) {
                                        $expire_labels = [
                                            'day' => '۱ روز',
                                            'week' => '۱ هفته',
                                            'month' => '۱ ماه',
                                            'custom' => $row['expire_days'] . ' روز',
                                            'unlimited' => 'نامحدود'
                                        ];
                                        $status_label = $row['status'] == 1 ? '<span class="badge bg-success">فعال</span>' : '<span class="badge bg-danger">غیرفعال</span>';
                                        $expire_date = $row['expire_at'] ? date('Y-m-d', strtotime($row['expire_at'])) : 'نامحدود';
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $a ?></td>
                                        <td class="text-center">
                                            <?php if(file_exists('../' . $row['image'])): ?>
                                            <img src="../<?= $row['image'] ?>"
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                            <?php else: ?>
                                            <span class="text-danger">❌</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?= $row['title'] ?></td>
                                        <td class="text-center"><?= $expire_labels[$row['expire_type']] ?? 'نامشخص' ?>
                                        </td>
                                        <td class="text-center"><?= $expire_date ?></td>
                                        <td class="text-center"><?= $status_label ?></td>
                                        <td class="text-center">
                                            <a href="edit_story.php?id=<?= $row['id'] ?>"
                                                class="btn btn-warning btn-sm">ویرایش</a>
                                            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                                                onclick="return confirm('حذف شود؟')">حذف</a>
                                        </td>
                                    </tr>
                                    <?php $a++; } ?>
                                </tbody>
                            </table>
                            <?php
                            // Pagination links
                            $sql_total = "SELECT COUNT(*) AS total FROM stories";
                            $total_result = $conn->query($sql_total);
                            $total_row = $total_result->fetch_assoc();
                            $total_items = $total_row['total'];
                            $total_pages = ceil($total_items / $items_per_page);
                            ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                    </li>
                                    <?php for($i = 1; $i <= $total_pages; $i++) { ?>
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
                            <?php } else { ?>
                            <p class="text-center text-muted">هیچ استوری ثبت نشده است!</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

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
// ===== ثبت استوری جدید =====
if (isset($_POST['submit_story'])) {
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

    // آپلود تصویر
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../upload/images/stories/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . rand(1000, 9999) . '.' . $ext;
        $uploadFile = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = "upload/images/stories/" . $filename;
        }
    }

    if ($imagePath) {
        $stmt = $conn->prepare("INSERT INTO stories (title, image, expire_type, expire_days, expire_at, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisi", $title, $imagePath, $expire_type, $expire_days, $expire_at, $status);
        
        if ($stmt->execute()) {
            echo "<script>alert('✅ استوری با موفقیت ثبت شد!'); window.location.href='new_story';</script>";
        } else {
            echo "<div class='alert alert-danger'>خطا: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>آپلود تصویر ناموفق!</div>";
    }
}

// ===== حذف استوری =====
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // گرفتن آدرس تصویر برای حذف فایل
    $img_sql = "SELECT image FROM stories WHERE id = $id";
    $img_result = $conn->query($img_sql);
    if ($img_result->num_rows > 0) {
        $img_row = $img_result->fetch_assoc();
        $file_path = '../' . $img_row['image'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    $stmt = $conn->prepare("DELETE FROM stories WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('🗑️ استوری حذف شد!'); window.location.href='new_story';</script>";
    }
    $stmt->close();
}
?>