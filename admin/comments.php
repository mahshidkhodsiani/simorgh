<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

if($_SESSION["all_data"]["admin"] != 1){
    header("Location: ../login.php");
    exit();
}

include '../config.php';

$id = $_SESSION["all_data"]['id'];

// ============================================================
// ===== پردازش ثبت پاسخ ادمین =====
// ============================================================
$reply_message = '';
$reply_message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_reply'])) {
    $comment_id = intval($_POST['comment_id'] ?? 0);
    $admin_reply = trim($_POST['admin_reply'] ?? '');

    if ($comment_id <= 0 || $admin_reply === '') {
        $reply_message = '❌ لطفاً متن پاسخ را وارد کنید.';
        $reply_message_type = 'danger';
    } else {
        $update_sql = "UPDATE comments SET admin_reply = ? WHERE id = ? AND (admin_reply IS NULL OR admin_reply = '')";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $admin_reply, $comment_id);
        if ($update_stmt->execute() && $update_stmt->affected_rows > 0) {
            $reply_message = '✅ پاسخ با موفقیت ثبت شد.';
            $reply_message_type = 'success';
        } else {
            $reply_message = '❌ خطا در ثبت پاسخ (شاید قبلاً پاسخ داده شده).';
            $reply_message_type = 'danger';
        }
        $update_stmt->close();
    }
}

// ============================================================
// ===== پردازش حذف کامنت =====
// ============================================================
if (isset($_GET['delete'])) {
    $del_id = intval($_GET['delete']);
    if ($del_id > 0) {
        $del_stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
        $del_stmt->bind_param("i", $del_id);
        $del_stmt->execute();
        $del_stmt->close();
        header("Location: comments.php?deleted=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت کامنت‌ها</title>

    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <?php include 'includes.php'; ?>

    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

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
    .table-section {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 20px;
        margin-bottom: 30px;
        border: none;
    }

    .card-header-custom {
        background-color: #4a5d73;
        color: white;
        padding: 12px 20px;
        border-radius: 8px 8px 0 0;
        font-size: 1.1rem;
        font-weight: 600;
        margin: -20px -20px 20px -20px;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.03);
    }

    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
    }

    .comment-text-cell {
        max-width: 320px;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.7;
    }

    .reply-text-cell {
        max-width: 280px;
        white-space: normal;
        word-wrap: break-word;
        line-height: 1.7;
        color: #198754;
    }

    .badge-type {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .badge-article {
        background: #0d6efd;
        color: white;
    }

    .badge-radio {
        background: #6f42c1;
        color: white;
    }

    .badge-package {
        background: #fd7e14;
        color: white;
    }

    .badge-no-reply {
        background: #ffc107;
        color: #212529;
    }

    .badge-replied {
        background: #198754;
        color: white;
    }

    .filter-bar {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }

    /* استایل فرم ریپلای داخل مودال */
    .reply-form textarea {
        border-radius: 10px;
        border: 1px solid #ced4da;
        padding: 10px 14px;
        font-size: 0.95rem;
        min-height: 110px;
        resize: vertical;
    }

    .reply-form textarea:focus {
        border-color: #4a5d73;
        box-shadow: 0 0 0 3px rgba(74, 93, 115, 0.15);
    }

    .original-comment-box {
        background: #f8f9fa;
        border-right: 4px solid #4a5d73;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 15px;
    }

    .original-comment-box .author {
        font-weight: 600;
        color: #4a5d73;
    }

    .original-comment-box .text {
        margin-top: 6px;
        color: #495057;
        line-height: 1.7;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #4a5d73, #3a4a5c);
        color: white;
    }

    .modal-header-custom .btn-close {
        filter: invert(1);
    }

    .btn-reply {
        background: linear-gradient(135deg, #4a5d73, #3a4a5c);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 5px 15px;
        font-size: 0.85rem;
        transition: all 0.3s;
    }

    .btn-reply:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(74, 93, 115, 0.4);
        color: white;
    }

    .btn-reply:disabled {
        background: #adb5bd;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .pagination .page-link {
        color: #4a5d73;
    }

    .pagination .page-item.active .page-link {
        background-color: #4a5d73;
        border-color: #4a5d73;
        color: white;
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
                <h3 class="text-center mb-4">
                    <i class="fas fa-comments me-2"></i>مدیریت کامنت‌ها
                </h3>

                <!-- ============================================================ -->
                <!-- فیلترها -->
                <!-- ============================================================ -->
                <div class="filter-bar">
                    <form method="GET" action="" class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label mb-1"><i class="fas fa-filter me-1"></i>نوع محتوا</label>
                            <select name="type" class="form-select form-select-sm">
                                <option value="">همه</option>
                                <option value="article" <?= (($_GET['type'] ?? '') === 'article') ? 'selected' : '' ?>>
                                    مقاله</option>
                                <option value="radio" <?= (($_GET['type'] ?? '') === 'radio') ? 'selected' : '' ?>>رادیو
                                </option>
                                <option value="package" <?= (($_GET['type'] ?? '') === 'package') ? 'selected' : '' ?>>
                                    پکیج</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1"><i class="fas fa-reply me-1"></i>وضعیت پاسخ</label>
                            <select name="reply" class="form-select form-select-sm">
                                <option value="">همه</option>
                                <option value="no" <?= (($_GET['reply'] ?? '') === 'no') ? 'selected' : '' ?>>بدون پاسخ
                                </option>
                                <option value="yes" <?= (($_GET['reply'] ?? '') === 'yes') ? 'selected' : '' ?>>پاسخ
                                    داده شده</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1"><i class="fas fa-search me-1"></i>جستجو</label>
                            <input type="text" name="q" class="form-control form-control-sm"
                                placeholder="نام یا متن کامنت..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                <i class="fas fa-search"></i> اعمال
                            </button>
                            <a href="comments.php" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </form>
                </div>

                <?php if ($reply_message !== ''): ?>
                <div class="alert alert-<?= $reply_message_type ?> text-center">
                    <?= htmlspecialchars($reply_message) ?>
                </div>
                <?php endif; ?>

                <?php if (isset($_GET['deleted'])): ?>
                <div class="alert alert-success text-center">
                    🗑️ کامنت با موفقیت حذف شد.
                </div>
                <?php endif; ?>

                <!-- ============================================================ -->
                <!-- لیست کامنت‌ها -->
                <!-- ============================================================ -->
                <div class="table-section">
                    <div class="card-header-custom" style="background-color: #6c757d;">
                        <i class="fas fa-list-alt"></i>لیست کامنت‌ها
                    </div>

                    <div class="table-responsive">
                        <?php
                        // ===== ساخت شرط‌های فیلتر =====
                        $where = [];
                        $params = [];
                        $types = '';

                        if (!empty($_GET['type']) && in_array($_GET['type'], ['article', 'radio', 'package'])) {
                            $where[] = "for_type = ?";
                            $params[] = $_GET['type'];
                            $types .= 's';
                        }

                        if (!empty($_GET['reply'])) {
                            if ($_GET['reply'] === 'no') {
                                $where[] = "(admin_reply IS NULL OR admin_reply = '')";
                            } elseif ($_GET['reply'] === 'yes') {
                                $where[] = "(admin_reply IS NOT NULL AND admin_reply != '')";
                            }
                        }

                        if (!empty($_GET['q'])) {
                            $where[] = "(full_name LIKE ? OR comment_text LIKE ?)";
                            $search = '%' . $_GET['q'] . '%';
                            $params[] = $search;
                            $params[] = $search;
                            $types .= 'ss';
                        }

                        $where_sql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

                        // ===== Pagination =====
                        $items_per_page = 10;
                        $current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                        $offset = ($current_page - 1) * $items_per_page;

                        // تعداد کل
                        $count_sql = "SELECT COUNT(*) AS total FROM comments $where_sql";
                        if (!empty($params)) {
                            $count_stmt = $conn->prepare($count_sql);
                            $count_stmt->bind_param($types, ...$params);
                            $count_stmt->execute();
                            $count_result = $count_stmt->get_result();
                            $count_stmt->close();
                        } else {
                            $count_result = $conn->query($count_sql);
                        }
                        $total_items = $count_result->fetch_assoc()['total'];
                        $total_pages = ceil($total_items / $items_per_page);

                        // دریافت داده‌ها
                        $sql = "SELECT * FROM comments $where_sql ORDER BY created_at DESC LIMIT ? OFFSET ?";
                        $stmt = $conn->prepare($sql);

                        if (!empty($params)) {
                            $params_with_pag = array_merge($params, [$items_per_page, $offset]);
                            $types_with_pag = $types . 'ii';
                            $stmt->bind_param($types_with_pag, ...$params_with_pag);
                        } else {
                            $stmt->bind_param("ii", $items_per_page, $offset);
                        }
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $a = ($current_page - 1) * $items_per_page + 1;
                        ?>
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">نام و فامیل</th>
                                    <th class="text-center">ایمیل</th>
                                    <th class="text-center">نوع</th>
                                    <th class="text-center">متن کامنت</th>
                                    <th class="text-center">پاسخ ادمین</th>
                                    <th class="text-center">تاریخ</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) {
                                        // نوع محتوا
                                        $type_labels = [
                                            'article' => ['label' => 'مقاله', 'class' => 'badge-article'],
                                            'radio'   => ['label' => 'رادیو', 'class' => 'badge-radio'],
                                            'package' => ['label' => 'پکیج', 'class' => 'badge-package'],
                                        ];
                                        $type_info = $type_labels[$row['for_type']] ?? ['label' => $row['for_type'], 'class' => 'badge-article'];

                                        // وضعیت پاسخ
                                        $has_reply = !empty($row['admin_reply']);
                                    ?>
                                <tr>
                                    <td class="text-center"><?= $a ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['full_name']) ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($row['email'])): ?>
                                        <small dir="ltr"><?= htmlspecialchars($row['email']) ?></small>
                                        <?php else: ?>
                                        <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-type <?= $type_info['class'] ?>">
                                            <?= $type_info['label'] ?> (<?= (int)$row['for_id'] ?>)
                                        </span>
                                    </td>
                                    <td class="comment-text-cell"><?= nl2br(htmlspecialchars($row['comment_text'])) ?>
                                    </td>
                                    <td class="reply-text-cell">
                                        <?php if ($has_reply): ?>
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        <?= nl2br(htmlspecialchars($row['admin_reply'])) ?>
                                        <?php else: ?>
                                        <span class="badge badge-no-reply">بدون پاسخ</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <small><?= date('Y/m/d H:i', strtotime($row['created_at'])) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!$has_reply): ?>
                                        <button type="button" class="btn btn-reply btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#replyModal" data-comment-id="<?= (int)$row['id'] ?>"
                                            data-comment-author="<?= htmlspecialchars($row['full_name']) ?>"
                                            data-comment-text="<?= htmlspecialchars($row['comment_text']) ?>">
                                            <i class="fas fa-reply me-1"></i>پاسخ
                                        </button>
                                        <?php else: ?>
                                        <button type="button" class="btn btn-reply btn-sm" disabled
                                            title="قبلاً پاسخ داده شده">
                                            <i class="fas fa-check me-1"></i>پاسخ داده
                                        </button>
                                        <?php endif; ?>

                                        <a href="?delete=<?= (int)$row['id'] ?>" class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('آیا از حذف این کامنت مطمئن هستید؟')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $a++;
                                    } ?>
                            </tbody>
                        </table>

                        <!-- ===== Pagination ===== -->
                        <?php if ($total_pages > 1) {
                                // ساخت URL با حفظ فیلترها
                                $query_params = $_GET;
                                unset($query_params['page']);
                                $base_url = '?' . http_build_query($query_params);
                                $base_url = $base_url === '?' ? '?' : $base_url . '&';
                            ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="<?= $base_url ?>page=<?= max(1, $current_page - 1) ?>">
                                        <i class="fas fa-chevron-right"></i> قبلی
                                    </a>
                                </li>

                                <?php
                                        $start_page = max(1, $current_page - 1);
                                        $end_page = min($total_pages, $start_page + 2);
                                        if ($end_page - $start_page < 2 && $start_page > 1) {
                                            $start_page = max(1, $end_page - 2);
                                        }
                                        for ($i = $start_page; $i <= $end_page; $i++) { ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $base_url ?>page=<?= $i ?>"><?= $i ?></a>
                                </li>
                                <?php } ?>

                                <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="<?= $base_url ?>page=<?= min($total_pages, $current_page + 1) ?>">
                                        بعدی <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <?php } ?>

                        <?php } else { ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            <p>هیچ کامنتی یافت نشد!</p>
                        </div>
                        <?php } ?>
                        <?php $stmt->close(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- مودال پاسخ ادمین -->
    <!-- ============================================================ -->
    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title" id="replyModalLabel">
                        <i class="fas fa-reply me-2"></i>پاسخ به کامنت
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" class="reply-form">
                    <div class="modal-body">
                        <div class="original-comment-box">
                            <div class="author">
                                <i class="fas fa-user me-1"></i><span id="modalAuthor">—</span>
                            </div>
                            <div class="text" id="modalCommentText">—</div>
                        </div>

                        <input type="hidden" name="comment_id" id="modalCommentId" value="">

                        <div class="mb-2">
                            <label for="admin_reply" class="form-label">
                                <i class="fas fa-pen me-1"></i>متن پاسخ شما:
                            </label>
                            <textarea name="admin_reply" id="admin_reply" class="form-control"
                                placeholder="پاسخ خود را اینجا بنویسید..." required maxlength="2000"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>انصراف
                        </button>
                        <button type="submit" name="submit_reply" class="btn btn-success">
                            <i class="fas fa-paper-plane me-1"></i>ارسال پاسخ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- Toast ها -->
    <!-- ============================================================ -->
    <div class="toast-container">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">موفقیت</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">عملیات با موفقیت انجام شد!</div>
        </div>

        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-danger text-white">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong class="me-auto">خطا</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">خطایی در انجام عملیات رخ داد!</div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- Scripts -->
    <!-- ============================================================ -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <script>
    // ===== پر کردن مودال با اطلاعات کامنت انتخاب‌شده =====
    document.addEventListener('DOMContentLoaded', function() {
        var replyModal = document.getElementById('replyModal');
        if (replyModal) {
            replyModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var commentId = button.getAttribute('data-comment-id');
                var author = button.getAttribute('data-comment-author');
                var text = button.getAttribute('data-comment-text');

                document.getElementById('modalCommentId').value = commentId;
                document.getElementById('modalAuthor').textContent = author;
                document.getElementById('modalCommentText').textContent = text;
                document.getElementById('admin_reply').value = '';
            });
        }
    });
    </script>

</body>

</html>