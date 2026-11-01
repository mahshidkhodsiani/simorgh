<?php
session_start();

// بررسی ورود کاربر
if (!isset($_SESSION['all_data'])) {
    header("Location: ../login.php");
    exit;
}

include '../config.php';

$user_id = $_SESSION['all_data']['id'];
$username = $_SESSION['all_data']['username'];
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

// دریافت آیتم‌های سبد خرید
$sql = "SELECT uc.id AS cart_id, p.id AS package_id, p.name, p.price, p.discount_code, p.discount_price 
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

// محاسبه مجموع سبد خرید
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'];
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سبد خرید</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
    /* استایل‌های اختصاصی صفحه سبد خرید */
    .cart-section {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 20px;
        border: 2px dashed #d1d3e2;
        transition: all 0.3s ease;
    }

    .cart-section:hover {
        border-color: #4e73df;
        background: #f0f2f7;
    }

    .card-cart {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .card-cart .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 18px 25px;
        border: none;
    }

    .card-cart .card-header h6 {
        color: white;
        font-weight: 600;
    }

    .card-cart .card-header h6 i {
        margin-left: 10px;
    }

    .card-cart .card-body {
        padding: 30px;
    }

    .table-cart {
        margin-bottom: 0;
    }

    .table-cart thead th {
        background: #f8f9fc;
        color: #2d3748;
        font-weight: 600;
        font-size: 14px;
        border-bottom: 2px solid #e3e6f0;
        padding: 15px 12px;
        text-align: center;
    }

    .table-cart tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #f0f2f7;
    }

    .table-cart tbody tr {
        transition: all 0.2s ease;
    }

    .table-cart tbody tr:hover {
        background: #f8f9fc;
    }

    .package-name {
        font-weight: 600;
        color: #2d3748;
    }

    .price-tag {
        font-weight: 500;
        color: #4e73df;
    }

    .final-price-display {
        font-weight: 700;
        color: #28a745;
        font-size: 16px;
    }

    .discount-input-group {
        max-width: 200px;
        margin: 0 auto;
    }

    .discount-input-group .form-control {
        border-radius: 8px 0 0 8px;
        border: 2px solid #e3e6f0;
        font-size: 13px;
        padding: 6px 12px;
        text-align: center;
    }

    .discount-input-group .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }

    .btn-apply-discount {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        border-radius: 0 8px 8px 0;
        padding: 6px 15px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .btn-apply-discount:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-remove-item {
        background: #fee2e2;
        border: none;
        color: #dc2626;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-remove-item:hover {
        background: #dc2626;
        color: white;
        transform: scale(1.05);
    }

    .btn-remove-item i {
        margin-left: 5px;
    }

    .btn-pay-item {
        background: #d1fae5;
        border: none;
        color: #065f46;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-pay-item:hover {
        background: #065f46;
        color: white;
        transform: scale(1.05);
    }

    .btn-pay-item i {
        margin-left: 5px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 80px;
        color: #d1d3e2;
        margin-bottom: 20px;
    }

    .empty-state h5 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #6c757d;
        max-width: 400px;
        margin: 0 auto 20px;
    }

    .btn-shop-now {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 35px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-shop-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-shop-now i {
        margin-left: 8px;
    }

    .cart-summary {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 20px 25px;
        margin-top: 20px;
        border: 1px solid #e3e6f0;
    }

    .cart-summary .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
    }

    .cart-summary .summary-row:not(:last-child) {
        border-bottom: 1px solid #e3e6f0;
    }

    .cart-summary .summary-label {
        color: #6c757d;
        font-weight: 500;
    }

    .cart-summary .summary-value {
        font-weight: 700;
        color: #2d3748;
    }

    .cart-summary .summary-total {
        font-size: 18px;
        color: #4e73df;
    }

    .btn-checkout-all {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        padding: 14px 40px;
        font-weight: 700;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 15px;
    }

    .btn-checkout-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(40, 167, 69, 0.4);
    }

    .btn-checkout-all i {
        margin-left: 10px;
    }

    @media (max-width: 768px) {
        .card-cart .card-body {
            padding: 20px;
        }

        .table-cart thead th,
        .table-cart tbody td {
            padding: 10px 8px;
            font-size: 13px;
        }

        .discount-input-group {
            max-width: 150px;
        }

        .cart-summary {
            padding: 15px;
        }

        .btn-checkout-all {
            font-size: 14px;
            padding: 12px 20px;
        }
    }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">
        <?php include 'header.php'; ?>

        <!-- پیام‌های سیستم -->
        <?php if ($message): ?>
        <div class="container-fluid py-2">
            <div id="alertMessage" class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show text-center" role="alert" style="border-radius: 12px;">
                <i class="bi <?php echo $message_type == 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> me-2"></i>
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php endif; ?>

        <div class="container-fluid py-3">
            <!-- هدر صفحه -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="bi bi-cart-check me-2 text-primary"></i>سبد خرید شما
                    </h1>
                    <p class="text-muted mb-0">مشاهده و مدیریت آیتم‌های سبد خرید</p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-primary bg-gradient p-2 px-3 rounded-pill">
                        <i class="bi bi-cart me-1"></i>
                        <?php echo count($cart_items); ?> آیتم
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card card-cart shadow">
                        <div class="card-header">
                            <h6 class="m-0">
                                <i class="bi bi-list-ul"></i>
                                لیست آیتم‌های سبد خرید
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (empty($cart_items)): ?>
                            <div class="empty-state">
                                <i class="bi bi-cart-x"></i>
                                <h5>سبد خرید شما خالی است</h5>
                                <p>هنوز هیچ پکیجی به سبد خرید خود اضافه نکرده‌اید. برای مشاهده پکیج‌های موجود به صفحه محصولات مراجعه کنید.</p>
                                <a href="packages.php" class="btn btn-shop-now">
                                    <i class="bi bi-shop"></i>
                                    مشاهده پکیج‌ها
                                </a>
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-cart">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام پکیج</th>
                                            <th scope="col">قیمت اصلی</th>
                                            <th scope="col">کد تخفیف</th>
                                            <th scope="col">مبلغ نهایی</th>
                                            <th scope="col">عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cart_items as $index => $item): ?>
                                        <tr data-cart-id="<?php echo $item['cart_id']; ?>"
                                            data-base-price="<?php echo $item['price']; ?>"
                                            data-discount-val="<?php echo $item['discount_price']; ?>"
                                            data-valid-code="<?php echo $item['discount_code']; ?>">
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <span class="package-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                            </td>
                                            <td>
                                                <span class="price-tag"><?php echo number_format($item['price']); ?></span>
                                                <small class="text-muted">ریال</small>
                                            </td>
                                            <td>
                                                <?php if(!empty($item['discount_code'])): ?>
                                                <div class="discount-input-group input-group">
                                                    <input type="text" class="form-control discount-input" placeholder="کد تخفیف...">
                                                    <button class="btn btn-apply-discount apply-discount-btn" type="button">
                                                        <i class="bi bi-tag"></i>
                                                        اعمال
                                                    </button>
                                                </div>
                                                <?php else: ?>
                                                <span class="text-muted">---</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="final-price-display"><?php echo number_format($item['price']); ?></span>
                                                <small class="text-muted">ریال</small>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                    <form action="" method="POST" style="display:inline-block;">
                                                        <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                                        <button type="submit" class="btn-remove-item">
                                                            <i class="bi bi-trash"></i>
                                                            حذف
                                                        </button>
                                                    </form>
                                                    <button onclick="payNow(<?php echo $item['cart_id']; ?>, this)" class="btn-pay-item">
                                                        <i class="bi bi-credit-card"></i>
                                                        پرداخت
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- جمع‌بندی سبد خرید -->
                            <div class="cart-summary">
                                <div class="summary-row">
                                    <span class="summary-label">تعداد آیتم‌ها</span>
                                    <span class="summary-value"><?php echo count($cart_items); ?></span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">مجموع قیمت</span>
                                    <span class="summary-value summary-total">
                                        <?php echo number_format($total_price); ?>
                                        <small class="text-muted">ریال</small>
                                    </span>
                                </div>
                                <?php if (!empty($cart_items)): ?>
                                <button onclick="checkoutAll()" class="btn btn-checkout-all">
                                    <i class="bi bi-cart-check"></i>
                                    پرداخت همه آیتم‌ها
                                </button>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
    <script>
    // تاگل سایدبار
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.body.classList.toggle('sidebar-toggled');
    });

    // اعمال تخفیف
    document.querySelectorAll('.apply-discount-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            let row = this.closest('tr');
            let inputCode = row.querySelector('.discount-input').value.trim();
            let validCode = row.dataset.validCode ? row.dataset.validCode.trim() : "";
            let basePrice = parseInt(row.dataset.basePrice);
            let discountValue = parseInt(row.dataset.discountVal);

            if (inputCode === validCode && validCode !== "") {
                let newPrice = basePrice - discountValue;
                if (newPrice < 0) newPrice = 0;

                row.querySelector('.final-price-display').innerText = new Intl.NumberFormat().format(newPrice);
                row.dataset.currentPrice = newPrice;

                Swal.fire({
                    icon: 'success',
                    title: 'کد تخفیف اعمال شد!',
                    text: 'تخفیف با موفقیت اعمال گردید.',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'کد تخفیف نامعتبر',
                    text: 'لطفاً کد تخفیف معتبر را وارد کنید.',
                    confirmButtonColor: '#667eea',
                    confirmButtonText: 'متوجه شدم'
                });
            }
        });
    });

    // پرداخت یک آیتم
    function payNow(cartId, btn) {
        let row = btn.closest('tr');
        let amount = row.dataset.currentPrice ? row.dataset.currentPrice : row.dataset.basePrice;

        Swal.fire({
            icon: 'question',
            title: 'تأیید پرداخت',
            text: 'آیا برای پرداخت این آیتم اطمینان دارید؟',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc2626',
            confirmButtonText: 'بله، پرداخت',
            cancelButtonText: 'انصراف'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "checkout.php?cart_id=" + cartId + "&amount=" + amount;
            }
        });
    }

    // پرداخت همه آیتم‌ها
    function checkoutAll() {
        <?php if (!empty($cart_items)): ?>
        let cartIds = [];
        <?php foreach ($cart_items as $item): ?>
        cartIds.push(<?php echo $item['cart_id']; ?>);
        <?php endforeach; ?>
        let totalAmount = <?php echo $total_price; ?>;

        Swal.fire({
            icon: 'question',
            title: 'تأیید پرداخت همه',
            text: 'آیا برای پرداخت همه آیتم‌های سبد خرید اطمینان دارید؟',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc2626',
            confirmButtonText: 'بله، پرداخت همه',
            cancelButtonText: 'انصراف'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "checkout_all.php?cart_ids=" + cartIds.join(',') + "&amount=" + totalAmount;
            }
        });
        <?php endif; ?>
    }

    // محو شدن پیام هشدار
    setTimeout(function() {
        const alert = document.getElementById('alertMessage');
        if (alert) {
            alert.style.transition = "opacity 0.8s ease";
            alert.style.opacity = "0";
            setTimeout(() => {
                alert.style.display = "none";
            }, 800);
        }
    }, 5000);
    </script>

</body>

</html>