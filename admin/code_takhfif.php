<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION["all_data"]["admin"] != 1) {
    header("Location: ../login.php");
    exit();
}

include '../config.php';

$id_admin = $_SESSION["all_data"]['id'];
$message = '';
$message_type = '';

/* ========== ثبت کد تخفیف جدید ========== */
if (isset($_POST['submit_codes'])) {
    $code_takhfif   = trim($_POST['code_takhfif'] ?? '');
    $takhfif_amount = (int)($_POST['takhfif_amount'] ?? 0);
    $applies_to     = $_POST['applies_to'] ?? 'all';
    $is_active      = isset($_POST['is_active']) ? 1 : 0;

    // اعتبارسنجی
    if ($code_takhfif === '' || $takhfif_amount <= 0) {
        $message = '❌ لطفاً کد تخفیف و مقدار تخفیف معتبر وارد کنید.';
        $message_type = 'danger';
    } elseif (!in_array($applies_to, ['radio', 'package', 'register', 'all'], true)) {
        $message = '❌ نوع کاربرد نامعتبر است.';
        $message_type = 'danger';
    } else {
        // بررسی تکراری نبودن کد
        $check = $conn->prepare("SELECT id FROM codes WHERE code = ? LIMIT 1");
        $check->bind_param("s", $code_takhfif);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $message = '❌ این کد تخفیف قبلاً ثبت شده است.';
            $message_type = 'danger';
            $check->close();
        } else {
            $check->close();

            $sql = "INSERT INTO codes (code, applies_to, takhfif_amount, is_active)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ssii", $code_takhfif, $applies_to, $takhfif_amount, $is_active);
                if ($stmt->execute()) {
                    $message = '✅ کد تخفیف با موفقیت ثبت شد.';
                    $message_type = 'success';
                } else {
                    $message = '❌ خطا در ثبت کد تخفیف: ' . $stmt->error;
                    $message_type = 'danger';
                }
                $stmt->close();
            } else {
                $message = '❌ خطای آماده‌سازی کوئری: ' . $conn->error;
                $message_type = 'danger';
            }
        }
    }
}

/* ========== حذف کد تخفیف (POST) ========== */
if (isset($_POST['delete_codes']) && isset($_POST['id_codes'])) {
    $id_codes = (int)$_POST['id_codes'];
    $stmt = $conn->prepare("DELETE FROM codes WHERE id = ?");
    $stmt->bind_param("i", $id_codes);
    if ($stmt->execute()) {
        $message = '✅ کد تخفیف حذف شد.';
        $message_type = 'success';
    } else {
        $message = '❌ خطا در حذف کد تخفیف.';
        $message_type = 'danger';
    }
    $stmt->close();
}

/* ========== تغییر وضعیت فعال/غیرفعال (POST) ========== */
if (isset($_POST['toggle_codes']) && isset($_POST['id_codes'])) {
    $id_codes = (int)$_POST['id_codes'];
    $stmt = $conn->prepare("UPDATE codes SET is_active = 1 - is_active WHERE id = ?");
    $stmt->bind_param("i", $id_codes);
    if ($stmt->execute()) {
        $message = '✅ وضعیت کد تخفیف تغییر کرد.';
        $message_type = 'success';
    } else {
        $message = '❌ خطا در تغییر وضعیت.';
        $message_type = 'danger';
    }
    $stmt->close();
}

/* ========== صفحه‌بندی و لیست کدها ========== */
$items_per_page = 10;
$current_page   = max(1, (int)($_GET['page'] ?? 1));
$offset         = ($current_page - 1) * $items_per_page;

$codes_rows = [];
$sql = "SELECT * FROM codes ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $codes_rows[] = $row;
}
$stmt->close();

$total_items = 0;
$cnt_res = $conn->query("SELECT COUNT(*) AS total FROM codes");
if ($cnt_res) {
    $total_items = (int)$cnt_res->fetch_assoc()['total'];
}
$total_pages = max(1, (int)ceil($total_items / $items_per_page));

$start_page = max(1, $current_page - 1);
$end_page   = min($total_pages, $start_page + 2);
if ($end_page - $start_page < 2 && $start_page > 1) {
    $start_page = max(1, $end_page - 2);
}

/* ========== برچسب نوع کاربرد ========== */
function applies_label($applies_to) {
    switch ($applies_to) {
        case 'radio':    return '📻 رادیو';
        case 'package':  return '📦 پکیج‌ها';
        case 'register': return '📝 ثبت‌نام';
        case 'all':
        default:         return '🌐 همه';
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت کدهای تخفیف</title>
    <link rel="icon" href="../images/logo1.ico" type="image/x-icon">
    <?php include 'includes.php'; ?>

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
        z-index: 9999;
    }

    .badge-active   { background: #198754; }
    .badge-inactive { background: #6c757d; }
    .badge-radio    { background: #0d6efd; }
    .badge-package  { background: #fd7e14; }
    .badge-register { background: #20c997; }
    .badge-all      { background: #6f42c1; }
    .code-text {
        font-family: monospace;
        font-weight: 700;
        letter-spacing: 1px;
        color: #0d1a47;
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

                <!-- ================= فرم ثبت ================= -->
                <div class="card-form">
                    <form id="codeForm" method="POST" class="p-2">
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>دقت کنید:</strong> هر کد فقط یک بار ثبت می‌شود.
                            اگر «فقط رادیو» را انتخاب کنید، کد روی <strong>همه رادیوها</strong>
                            (شب‌های تهران ۱ و ۲، کافه مه‌آلود، جمعه‌های سیمرغی) اعمال می‌شود.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code_takhfif" class="form-label">کد تخفیف: <span class="text-danger">*</span></label>
                                <input type="text" id="code_takhfif" name="code_takhfif" class="form-control"
                                    placeholder="مثال: SIMORGH150" required maxlength="64">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="takhfif_amount" class="form-label">
                                    مقدار تخفیف (تومان): <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="takhfif_amount" name="takhfif_amount" class="form-control"
                                    placeholder="مثال: 150000" min="1" required>
                                <small class="text-muted">
                                    عدد را به تومان وارد کنید. (۱۵۰٬۰۰۰ تومان = ۱۵۰ هزار تومان)
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="applies_to" class="form-label">اعمال روی: <span class="text-danger">*</span></label>
                                <select name="applies_to" id="applies_to" class="form-select" required>
                                    <option value="all">🌐 همه (رادیو + پکیج + ثبت‌نام)</option>
                                    <option value="radio">📻 فقط رادیو</option>
                                    <option value="package">📦 فقط پکیج</option>
                                    <option value="register">📝 فقط ثبت‌نام</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active"
                                        name="is_active" checked>
                                    <label class="form-check-label" for="is_active">فعال باشد</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-outline-success" type="submit" name="submit_codes">
                                <i class="fas fa-plus-circle me-2"></i>ثبت کد جدید
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ================= جدول ================= -->
                <div class="table-section">
                    <div class="table-header">
                        <i class="fas fa-list-alt me-2"></i>لیست کدهای تخفیف
                        <span class="badge bg-light text-dark ms-2"><?= number_format($total_items) ?></span>
                    </div>
                    <div class="table-responsive">
                        <?php if (count($codes_rows) > 0): ?>
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">کد</th>
                                    <th class="text-center">مقدار (تومان)</th>
                                    <th class="text-center">اعمال روی</th>
                                    <th class="text-center">استفاده</th>
                                    <th class="text-center">وضعیت</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $row_num = $offset + 1;
                                foreach ($codes_rows as $row):
                                    $is_active_now = ((int)($row['is_active'] ?? 1) === 1);
                                    $used_count    = (int)($row['used_count'] ?? 0);
                                ?>
                                <tr>
                                    <th class="text-center"><?= $row_num ?></th>
                                    <td class="text-center"><span class="code-text"><?= htmlspecialchars($row['code']) ?></span></td>
                                    <td class="text-center"><?= number_format((int)$row['takhfif_amount']) ?></td>
                                    <td class="text-center">
                                        <?php
                                        $applies = $row['applies_to'] ?? 'all';
                                        $label = applies_label($applies);
                                        $badge_class = 'badge-' . $applies;
                                        ?>
                                        <span class="badge <?= $badge_class ?>"><?= htmlspecialchars($label) ?></span>
                                    </td>
                                    <td class="text-center"><?= number_format($used_count) ?></td>
                                    <td class="text-center">
                                        <?php if ($is_active_now): ?>
                                            <span class="badge badge-active">فعال</span>
                                        <?php else: ?>
                                            <span class="badge badge-inactive">غیرفعال</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- تغییر وضعیت -->
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" value="<?= (int)$row['id'] ?>" name="id_codes">
                                            <button type="submit" name="toggle_codes"
                                                class="btn btn-sm btn-warning"
                                                title="فعال/غیرفعال">
                                                <i class="fas fa-power-off"></i>
                                            </button>
                                        </form>
                                        <!-- حذف -->
                                        <form method="POST" style="display:inline;"
                                            onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این کد تخفیف را حذف کنید؟');">
                                            <input type="hidden" value="<?= (int)$row['id'] ?>" name="id_codes">
                                            <button type="submit" name="delete_codes"
                                                class="btn btn-danger btn-sm" title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $row_num++; endforeach; ?>
                            </tbody>
                        </table>

                        <!-- صفحه‌بندی -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= max(1, $current_page - 1) ?>">قبلی</a>
                                </li>
                                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                                <?php endfor; ?>
                                <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= min($total_pages, $current_page + 1) ?>">بعدی</a>
                                </li>
                            </ul>
                        </nav>

                        <?php else: ?>
                        <div class="alert alert-warning text-center mt-3" role="alert">
                            هیچ کد تخفیفی در پایگاه داده وجود ندارد.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-container">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="3000">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">موفقیت</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">عملیات با موفقیت انجام شد!</div>
        </div>
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="3000">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">خطا</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">خطایی رخ داد!</div>
        </div>
    </div>

    <script>
    // نمایش toast بر اساس پیام PHP
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($message !== ''): ?>
            <?php if ($message_type === 'success'): ?>
                if (typeof bootstrap !== 'undefined') {
                    new bootstrap.Toast(document.getElementById('successToast')).show();
                }
            <?php else: ?>
                if (typeof bootstrap !== 'undefined') {
                    new bootstrap.Toast(document.getElementById('errorToast')).show();
                }
            <?php endif; ?>
        <?php endif; ?>
    });
    </script>
</body>

</html>