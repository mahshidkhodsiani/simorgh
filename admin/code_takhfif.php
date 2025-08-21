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
    <title>افزودن کد تخفیف</title>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <?php
    include 'includes.php';
    include '../config.php';
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f0f2f5;
        }

        .main-content {
            padding: 20px;
        }

        .card-form {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin-bottom: 30px;
            border: none;
        }

        .table-section {
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

        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
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
                <h3 class="text-center mb-4">مدیریت کدهای تخفیف</h3>

                <div class="card-form">
                    <form id="codeForm" enctype="multipart/form-data" method="POST" class="p-2">
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i><strong>دقت کنید:</strong> هربار فقط و فقط یک کد تخفیف بگذارید. با تشکر.
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code_takhfif" class="form-label">کد تخفیف:</label>
                                <input type="text" id="code_takhfif" name="code_takhfif" class="form-control" placeholder="کد را اینجا وارد کنید" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="takhfif_amount" class="form-label">مقدار تخفیف:</label>
                                <input type="number" id="takhfif_amount" placeholder="مقدار تخفیف به ریال لطفا" name="takhfif_amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-outline-success" type="submit" name="submit_codes">
                                <i class="fas fa-plus-circle me-2"></i>ثبت کد جدید
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-section">
                    <div class="table-header">
                        <i class="fas fa-list-alt me-2"></i>لیست کدهای تخفیف
                    </div>
                    <div class="table-responsive">
                        <?php
                        // Pagination configuration
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        $sql = "SELECT * FROM codes ORDER BY id DESC LIMIT $items_per_page OFFSET $offset";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" class="text-center">کد تخفیف</th>
                                        <th scope="col" class="text-center">مقدار تخفیف (ریال)</th>
                                        <th scope="col" class="text-center">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <th scope="row" class="text-center"><?= $a ?></th>
                                            <td class="text-center"><?= htmlspecialchars($row['code']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars(number_format($row['takhfif_amount'])) ?></td>
                                            <td class="text-center">
                                                <form action="" method="GET" style="display:inline;">
                                                    <input type="hidden" value="<?= $row['id'] ?>" name="id_codes">
                                                    <button type="submit" name="delete_codes" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                                                        <i class="fas fa-trash-alt me-1"></i>حذف
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php $a++;
                                    } ?>
                                </tbody>
                            </table>
                            <?php
                            $sql_count = "SELECT COUNT(*) AS total FROM codes";
                            $result_count = $conn->query($sql_count);
                            $row_count = $result_count->fetch_assoc();
                            $total_items = $row_count['total'];
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
                                        <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php } else { ?>
                            <div class="alert alert-warning text-center" role="alert">
                                هیچ کد تخفیفی در پایگاه داده وجود ندارد.
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
            return confirm("آیا مطمئن هستید که می‌خواهید این کد تخفیف را حذف کنید؟");
        }

        <?php if (isset($_POST['submit_codes']) && $result) { ?>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(() => {
                    window.location.href = 'code_takhfif';
                }, 3000);
            });
        <?php } elseif (isset($_POST['submit_codes']) && !$result) { ?>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
            });
        <?php } ?>

        <?php if (isset($_GET['delete_codes']) && $result) { ?>
            document.addEventListener('DOMContentLoaded', function() {
                var successToast = new bootstrap.Toast(document.getElementById('successToast'));
                successToast.show();
                setTimeout(() => {
                    window.location.href = 'code_takhfif';
                }, 3000);
            });
        <?php } elseif (isset($_GET['delete_codes']) && !$result) { ?>
            document.addEventListener('DOMContentLoaded', function() {
                var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
                errorToast.show();
            });
        <?php } ?>
    </script>
</body>

</html>
<?php
// PHP logic to handle form submissions and deletions
if (isset($_POST['submit_codes'])) {
    $code_takhfif = $_POST['code_takhfif'];
    $takhfif_amount = $_POST['takhfif_amount'];
    $sql = "INSERT INTO codes (code, takhfif_amount) VALUES('$code_takhfif', $takhfif_amount)";
    $result = $conn->query($sql);
    // You can handle the success/error messages within the PHP block, but for cleaner code, the JS toast is better.
    // The previous code already has this logic, so we keep it here for full functionality.
}
if (isset($_GET['delete_codes'])) {
    $id_codes = $_GET['id_codes'];
    $sql = "DELETE FROM codes WHERE id = $id_codes";
    $result = $conn->query($sql);
    // You can handle the success/error messages within the PHP block.
}
?>