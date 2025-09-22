<?php
session_start();

// بررسی ورود کاربر
if (!isset($_SESSION['all_data'])) {
    header("Location: ../login.php");
    exit;
}

include '../config.php';

$user_id = $_SESSION['all_data']['id'];
$message = null;
$message_type = null;

// دریافت پیام از URL
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
    $message_type = isset($_GET['type']) ? $_GET['type'] : "info";
}

// حذف آیتم از سبد خرید
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
    $cart_id = intval($_POST['cart_id']);
    $stmt_del = $conn->prepare("DELETE FROM user_cart WHERE id = ? AND user_id = ?");
    $stmt_del->bind_param("ii", $cart_id, $user_id);
    if ($stmt_del->execute()) {
        $message = "آیتم با موفقیت حذف شد.";
        $message_type = "success";
    } else {
        $message = "خطا در حذف آیتم: " . $stmt_del->error;
        $message_type = "danger";
    }
    $stmt_del->close();
}

// دریافت آیتم‌های سبد خرید به همراه قیمت
$sql = "SELECT uc.id AS cart_id, p.id AS package_id, p.name, p.price 
        FROM user_cart uc 
        JOIN packages p ON uc.package_id = p.id 
        WHERE uc.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سبد خرید</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div id="content-wrapper">
        <?php include 'header.php'; ?>
        <div class="container-fluid py-2">
            <?php if ($message): ?>
                <div id="alertMessage" class="alert alert-<?php echo $message_type; ?> text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="container-fluid py-4">
            <h1 class="h3 mb-4 text-gray-800">سبد خرید شما</h1>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">لیست آیتم‌های سبد خرید</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($cart_items)): ?>
                        <div class="alert alert-info">سبد خرید شما خالی است.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام پکیج</th>
                                        <th>قیمت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $index => $item): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td><?php echo number_format($item['price']); ?> تومان</td>
                                            <td>
                                                <form action="" method="POST" style="display:inline-block;">
                                                    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                                </form>
                                                <a href="checkout.php?cart_id=<?php echo $item['cart_id']; ?>&amount=<?php echo $item['price']; ?>" class="btn btn-success btn-sm">پرداخت</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-toggled');
        });

        const navLinks = document.querySelectorAll('.sidebar .nav-item .nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const currentActive = document.querySelector('.sidebar .nav-item.active');
                if (currentActive) {
                    currentActive.classList.remove('active');
                }
                this.parentElement.classList.add('active');
            });
        });

        setTimeout(function() {
            const alert = document.getElementById('alertMessage');
            if (alert) {
                alert.style.transition = "opacity 1s ease-out";
                alert.style.opacity = "0";
                setTimeout(function() {
                    alert.style.display = "none";
                }, 1000);
            }
        }, 5000);
    </script>
</body>

</html>