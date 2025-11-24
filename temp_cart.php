<?php
// شروع نشست
session_start();
?>
<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سبد خرید شما</title>

    <?php include "includes.php"; ?>

    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
</head>

<body>

    <?php
    
    include 'header.php';
    include 'config.php';
    ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card border border-danger" style="border-radius: 40px;">
                    <div class="card-body" dir="rtl" style="text-align: right;">
                        <h3>سبد خرید شما (موقت)</h3>
                        <p>
                            برای تکمیل خرید و نگهداری دائمی اقلام، لطفا وارد حساب کاربری خود شوید یا ثبت‌نام کنید.
                        </p>
                        <br>
                        <div class="row mt-4">
                            <?php
                            $packages = [];
                            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                $package_ids = $_SESSION['cart'];

                                // استفاده از Prepared Statement برای جلوگیری از SQL Injection
                                $ids_placeholders = implode(',', array_fill(0, count($package_ids), '?'));
                                $sql = "SELECT `id`, `name`, `description`, `course` FROM `packages` WHERE `id` IN ($ids_placeholders)";
                                $stmt = $conn->prepare($sql);

                                // تعیین نوع داده‌ها (i برای integer)
                                $types = str_repeat('i', count($package_ids));
                                $stmt->bind_param($types, ...$package_ids);

                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    $packages[] = $row;
                                }
                            }

                            if (count($packages) > 0): ?>
                                <?php foreach ($packages as $package): ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <img class="card-img-top" src="../images/packages.jpg" alt="تصویر پکیج">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title"><?php echo htmlspecialchars($package['name']); ?></h5>
                                                <p class="card-text text-muted"><?php echo htmlspecialchars($package['description']); ?></p>
                                                <p class="card-text">
                                                    <strong>مدرس دوره:</strong> <?php echo htmlspecialchars($package['course']); ?><br>
                                                </p>
                                                <div class="mt-auto">
                                                    <a href="cart.php" class="btn btn-primary btn-block w-100">ورود/ثبت نام برای ادامه</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class='alert alert-warning text-center w-100'>سبد خرید شما خالی است.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>