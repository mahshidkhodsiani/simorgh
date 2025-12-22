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

// دریافت آیتم‌های سبد خرید به همراه قیمت و اطلاعات تخفیف
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
                                    <th>قیمت اصلی</th>
                                    <th>کد تخفیف</th>
                                    <th>مبلغ نهایی</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_items as $index => $item): ?>
                                <tr data-cart-id="<?php echo $item['cart_id']; ?>"
                                    data-base-price="<?php echo $item['price']; ?>"
                                    data-discount-val="<?php echo $item['discount_price']; ?>"
                                    data-valid-code="<?php echo $item['discount_code']; ?>">

                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo number_format($item['price']); ?> ریال</td>
                                    <td>
                                        <?php if(!empty($item['discount_code'])): ?>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control discount-input" placeholder="کد...">
                                            <button class="btn btn-primary apply-discount-btn"
                                                type="button">اعمال</button>
                                        </div>
                                        <?php else: ?>
                                        ---
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span
                                            class="final-price-display"><?php echo number_format($item['price']); ?></span>
                                        ریال
                                    </td>
                                    <td>
                                        <form action="" method="POST" style="display:inline-block;">
                                            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                        <button onclick="payNow(<?php echo $item['cart_id']; ?>, this)"
                                            class="btn btn-success btn-sm">پرداخت</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // دکمه اعمال تخفیف
    $('.apply-discount-btn').click(function() {
        let row = $(this).closest('tr');
        let inputCode = row.find('.discount-input').val();
        let validCode = row.data('valid-code');
        let basePrice = parseInt(row.data('base-price'));
        let discountValue = parseInt(row.data('discount-val'));

        if (inputCode === validCode && validCode !== "") {
            let newPrice = basePrice - discountValue;
            if (newPrice < 0) newPrice = 0;

            row.find('.final-price-display').text(new Intl.NumberFormat().format(newPrice)).css('color',
                'green').css('font-weight', 'bold');
            row.attr('data-calculated-price', newPrice);
            alert("کد تخفیف با موفقیت اعمال شد.");
        } else {
            alert("کد تخفیف نامعتبر است.");
        }
    });

    // تابع انتقال به درگاه با مبلغ نهایی
    function payNow(cartId, btn) {
        let row = $(btn).closest('tr');
        let amount = row.attr('data-calculated-price') ? row.attr('data-calculated-price') : row.data('base-price');
        window.location.href = "checkout.php?cart_id=" + cartId + "&amount=" + amount;
    }

    // کدهای سایدبار و الرت شما بدون تغییر
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.body.classList.toggle('sidebar-toggled');
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