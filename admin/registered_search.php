<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

include 'includes.php';
include '../config.php';

$search_result = null;
$error_message = '';

if (isset($_GET['search_meli_code'])) {
    $meli_code = $_GET['search_meli_code'];

    // Sanitize the input to prevent SQL injection
    $meli_code = $conn->real_escape_string($meli_code);

    $sql = "SELECT * FROM users WHERE meli_code = '$meli_code'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $search_result = $result->fetch_assoc();
    } else {
        $error_message = 'کاربری با این کد ملی پیدا نشد.';
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جستجوی ثبت‌نام‌کنندگان</title>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .main-content {
            padding: 20px;
        }

        .card-form,
        .result-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 30px;
            border: none;
        }

        .result-card .table th,
        .result-card .table td {
            font-size: 15px;
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
                <h3 class="text-center mb-4">جستجوی اطلاعات ثبت‌نام‌کنندگان</h3>

                <div class="card-form">
                    <form action="" method="GET" class="p-2">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <label for="search_meli_code" class="form-label">کد ملی ثبت‌نام‌کننده:</label>
                                <input type="text" id="search_meli_code" name="search_meli_code" class="form-control" placeholder="کد ملی را اینجا وارد کنید" required>
                            </div>
                            <div class="col-md-4 mt-4 d-flex justify-content-center">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search me-2"></i>جستجو
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                <?php if ($search_result): ?>
                    <div class="result-card">
                        <h5 class="text-center">اطلاعات کامل کاربر</h5>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 25%;">نام و نام خانوادگی:</th>
                                        <td><?= htmlspecialchars($search_result['name']) . ' ' . htmlspecialchars($search_result['family']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>کد ملی:</th>
                                        <td><?= htmlspecialchars($search_result['meli_code']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>شماره موبایل:</th>
                                        <td><?= htmlspecialchars($search_result['mobile']) ?></td>
                                    </tr>

                                    <tr>
                                        <th>عکس پرسنلی:</th>
                                        <td>
                                            <?php if (!empty($search_result['personely'])): ?>
                                                <a href="../user/<?= htmlspecialchars($search_result['personely']) ?>" target="_blank" class="btn btn-sm btn-info">مشاهده عکس</a>
                                            <?php else: ?>
                                                <span>ندارد</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>عکس شناسنامه:</th>
                                        <td>
                                            <?php if (!empty($search_result['shenasname'])): ?>
                                                <a href="../user/<?= htmlspecialchars($search_result['shenasname']) ?>" target="_blank" class="btn btn-sm btn-info">مشاهده عکس</a>
                                            <?php else: ?>
                                                <span>ندارد</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>عکس کارت ملی:</th>
                                        <td>
                                            <?php if (!empty($search_result['photo_meli'])): ?>
                                                <a href="../user/<?= htmlspecialchars($search_result['photo_meli']) ?>" target="_blank" class="btn btn-sm btn-info">مشاهده عکس</a>
                                            <?php else: ?>
                                                <span>ندارد</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php elseif (isset($_GET['search_meli_code'])): ?>
                    <div class="alert alert-warning text-center" role="alert">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>



                <?php
                // Pagination configuration
                $items_per_page = 10; // Number of items per page
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page, default is 1

                // Calculate the offset for the SQL query
                $offset = ($current_page - 1) * $items_per_page;

                // SQL query to retrieve a subset of rows based on pagination
                $sql = "SELECT * FROM users ORDER BY id DESC";
                $result = $conn->query($sql);

                // Display the table
                if ($result->num_rows > 0) {
                    $a = ($current_page - 1) * $items_per_page + 1; // Counter for row numbers
                ?>
                    <div class="table-responsive">
                        <table class="table border border-4">
                            <h4>نگاه کلی :</h4>
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">ردیف</th>
                                    <th scope="col" class="text-center">نام</th>
                                    <th scope="col" class="text-center">نام خانوادگی</th>
                                    <th scope="col" class="text-center">کد ملی</th>
                                    <th scope="col" class="text-center">نقش</th>
                                    <th scope="col" class="text-center">مدارک</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <th scope="row" class="text-center"><?= $a ?></th>
                                        <td class="text-center"><?= $row['name'] ?></td>
                                        <td class="text-center"><?= $row['family'] ?></td>
                                        <td class="text-center"><?= $row['meli_code'] ?></td>
                                        <td class="text-center"><?= $row['level'] == 'admin' ? 'ادمین' : 'کاربر عادی' ?></td>
                                        <td class="text-center">

                                            <?= !empty($row['personely'])
                                                ? '<span style="color:green; font-weight:bold;">دارد</span>'
                                                : 'ندارد' ?>
                                        </td>
                                    </tr>
                                <?php
                                    $a++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php

                    // Pagination links
                    $sql = "SELECT COUNT(*) AS total FROM users";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $total_items = $row['total'];
                    $total_pages = ceil($total_items / $items_per_page);

                    // Display pagination links
                    ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php
                            for ($i = 1; $i <= $total_pages; $i++) {
                            ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                <?php
                } else {
                    echo "<p>No records found.</p>";
                }
                ?>

            </div>
        </div>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>