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
    <title>خانه</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php
    include 'includes.php';
    include '../config.php';
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f0f2f5;
    }

    .main-content {
        padding: 20px;
    }

    .dashboard-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 20px;
        margin-bottom: 20px;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    .dashboard-card .card-icon {
        font-size: 2.5rem;
        color: #b85ed6;
    }

    .dashboard-card h5 {
        font-size: 1rem;
        color: #6c757d;
        margin-top: 10px;
        font-weight: 500;
    }

    .dashboard-card .card-value {
        font-size: 2rem;
        font-weight: 700;
        color: #34495e;
        margin-top: 5px;
    }

    .data-table-section {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 20px;
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
    </style>
</head>

<body>

    <?php include 'header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php include 'sidebar.php'; ?>
            </div>

            <div class="col-md-9 main-content">

                <h3 class="mb-4 text-center">داشبورد مدیریتی</h3>

                <?php
                    $total_users_query = $conn->query("SELECT COUNT(*) FROM users");
                    $total_users = $total_users_query->fetch_row()[0];

                    $total_suggestions_query = $conn->query("SELECT COUNT(*) FROM suggestions");
                    $total_suggestions = $total_suggestions_query->fetch_row()[0];

                    $total_sounds_query = $conn->query("SELECT COUNT(*) FROM sounds");
                    $total_sounds = $total_sounds_query->fetch_row()[0];
                ?>

                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="dashboard-card text-center">
                            <div class="card-icon"><i class="fas fa-users"></i></div>
                            <div class="card-value"><?= $total_users ?></div>
                            <h5>تعداد کل کاربران</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-card text-center">
                            <div class="card-icon"><i class="fas fa-comment-dots"></i></div>
                            <div class="card-value"><?= $total_suggestions ?></div>
                            <h5>تعداد پیشنهادات</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-card text-center">
                            <div class="card-icon"><i class="fas fa-microphone-alt"></i></div>
                            <div class="card-value"><?= $total_sounds ?></div>
                            <h5>تعداد صداهای ارسالی</h5>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="data-table-section">
                            <div class="table-header">
                                <i class="fas fa-comment-alt-lines me-2"></i>آخرین انتقاد و پیشنهادات
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">متن پیام</th>
                                            <th scope="col">نوع</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $a = 1;
                                    $sql = "SELECT * FROM suggestions ORDER BY id DESC LIMIT 10";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {?>
                                        <tr>
                                            <th scope="row"><?= $a ?></th>
                                            <td><?= mb_strimwidth($row['text'], 0, 40, '...') ?></td>
                                            <td><span class="badge bg-primary"><?= $row['type'] ?></span></td>
                                        </tr>
                                        <?php
                                        $a++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='text-center'>هیچ پیشنهادی وجود ندارد.</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="data-table-section">
                            <div class="table-header">
                                <i class="fas fa-user-plus me-2"></i>آخرین ثبت نامی ها
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام</th>
                                            <th scope="col">دوره</th>
                                            <th scope="col">مبلغ</th>
                                            <th scope="col">وضعیت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $a = 1;
                                    $sql = "SELECT * FROM contacts ORDER BY id DESC LIMIT 10";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {?>
                                        <tr>
                                            <th scope="row"><?= $a ?></th>
                                            <td><?= $row['name'] . " " . $row['lastname'] ?></td>
                                            <td><?= $row['course'] ?></td>
                                            <td><?= number_format($row['amount']) ?> ریال</td>
                                            <td>
                                                <?php
                                                    if($row['pardakht'] == 1){
                                                        echo "<span class='badge bg-success'>پرداخت شده</span>";
                                                    } else {
                                                        echo "<span class='badge bg-danger'>پرداخت نشده</span>";
                                                    }
                                                    ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>هیچ ثبت‌نامی وجود ندارد.</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>