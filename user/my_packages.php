<?php
session_start();

if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION['all_data']['id'];

include '../config.php';

// کوئری اصلاح‌شده که از ستون 'price' به‌جای 'amount' استفاده می‌کند
$stmt_courses = $conn->prepare("SELECT up.paid, p.name AS package_name, p.price AS package_price FROM user_package up JOIN packages p ON up.package_id = p.id WHERE up.user_id = ?");
$stmt_courses->bind_param("i", $user_id);
$stmt_courses->execute();
$result_courses = $stmt_courses->get_result();

$enrolled_courses = [];
if ($result_courses->num_rows > 0) {
    while ($row = $result_courses->fetch_assoc()) {
        $enrolled_courses[] = $row;
    }
}
$stmt_courses->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره‌های من</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div id="content-wrapper">
        <?php include 'header.php'; ?>
        <div class="container-fluid">
            <div class="main">
                <div class="container py-4">
                    <h1 class="h3 mb-4 text-gray-800"><i class="bi bi-book me-2"></i>پکیج های من</h1>
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">لیست پکیج های ثبت‌نام شده</h6>
                                </div>
                                <div class="card-body">
                                    <?php if (count($enrolled_courses) > 0): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-primary">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">نام دوره</th>
                                                        <th scope="col">مبلغ</th>
                                                        <th scope="col">وضعیت پرداخت</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $counter = 1; ?>
                                                    <?php foreach ($enrolled_courses as $course): ?>
                                                        <tr>
                                                            <th scope="row"><?php echo $counter++; ?></th>
                                                            <td><?php echo htmlspecialchars($course['package_name']); ?></td>
                                                            <td><?php echo number_format($course['package_price']); ?> تومان</td>
                                                            <td>
                                                                <?php if ($course['paid'] == 1): ?>
                                                                    <span class="badge bg-success">پرداخت شده</span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-danger">در انتظار پرداخت</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info" role="alert">
                                            شما تاکنون در هیچ پکیجی  ثبت‌نام نکرده‌اید.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                document.body.classList.toggle('sidebar-toggled');
            });
        }
    </script>
</body>

</html>