<?php
session_start();

if (!isset($_SESSION["all_data"])) {
    header("Location: ../login.php");
    exit();
}

$id = $_SESSION["all_data"]['id'];

include '../config.php';
include '../functions.php';

// پردازش پاسخ به تیکت
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply_ticket'])) {
    $ticket_id = $_POST['ticket_id'];
    $reply_message = trim($_POST['reply_message']);
    $admin_id = $id;
    
    if (!empty($reply_message)) {
        // Insert reply
        $stmt = $conn->prepare("INSERT INTO ticket_replies (ticket_id, admin_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $ticket_id, $admin_id, $reply_message);
        
        if ($stmt->execute()) {
            // Update ticket status to answered
            $stmt_update = $conn->prepare("UPDATE tickets SET status = 'answered' WHERE id = ?");
            $stmt_update->bind_param("i", $ticket_id);
            $stmt_update->execute();
            $stmt_update->close();
            
            $success_message = 'پاسخ شما با موفقیت ثبت شد.';
        } else {
            $error_message = 'خطا در ثبت پاسخ. لطفا دوباره تلاش کنید.';
        }
        $stmt->close();
    } else {
        $error_message = 'لطفا متن پاسخ را وارد کنید.';
    }
}

// بستن تیکت
if (isset($_GET['close_ticket'])) {
    $ticket_id = $_GET['ticket_id'];
    $stmt = $conn->prepare("UPDATE tickets SET status = 'closed' WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    if ($stmt->execute()) {
        $success_message = 'تیکت با موفقیت بسته شد.';
    }
    $stmt->close();
}

// بازکردن تیکت
if (isset($_GET['open_ticket'])) {
    $ticket_id = $_GET['ticket_id'];
    $stmt = $conn->prepare("UPDATE tickets SET status = 'pending' WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    if ($stmt->execute()) {
        $success_message = 'تیکت با موفقیت بازگشایی شد.';
    }
    $stmt->close();
}

// حذف تیکت
if (isset($_GET['delete_ticket'])) {
    $ticket_id = $_GET['id_ticket'];
    $stmt = $conn->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    if ($stmt->execute()) {
        $success_message = 'تیکت با موفقیت حذف شد.';
    } else {
        $error_message = 'خطا در حذف تیکت.';
    }
    $stmt->close();
}

// Pagination
$items_per_page = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

// فیلتر وضعیت
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$where_clause = $status_filter !== 'all' ? "WHERE t.status = '$status_filter'" : "";

// واکشی تیکت‌ها
$sql = "SELECT 
            t.id, 
            t.user_id,
            t.subject, 
            t.message, 
            t.status, 
            t.created_at,
            u.name,
            u.family,
            u.mobile,
            (SELECT COUNT(*) FROM ticket_replies WHERE ticket_id = t.id) as reply_count
        FROM tickets t 
        LEFT JOIN users u ON t.user_id = u.id
        $where_clause
        ORDER BY 
            CASE 
                WHEN t.status = 'pending' THEN 1
                WHEN t.status = 'answered' THEN 2
                WHEN t.status = 'closed' THEN 3
            END,
            t.created_at DESC 
        LIMIT $offset, $items_per_page";
$result = $conn->query($sql);

$tickets = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
}

// Total pages
$sql_count = "SELECT COUNT(*) AS total FROM tickets t $where_clause";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_items = $row_count['total'];
$total_pages = ceil($total_items / $items_per_page);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت تیکت‌ها</title>
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <?php include 'includes.php'; ?>
    <style>
    .ticket-card {
        transition: all 0.3s ease;
        border-left: 4px solid;
    }

    .ticket-card.pending {
        border-left-color: #ffc107;
    }

    .ticket-card.answered {
        border-left-color: #28a745;
    }

    .ticket-card.closed {
        border-left-color: #6c757d;
    }

    .ticket-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .reply-form {
        display: none;
        animation: slideDown 0.3s ease-out;
    }

    .reply-form.show {
        display: block;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card {
        border-radius: 10px;
        padding: 20px;
        color: white;
        margin-bottom: 20px;
    }

    .stat-pending {
        background: linear-gradient(135deg, #ffc107, #ffb300);
    }

    .stat-answered {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .stat-closed {
        background: linear-gradient(135deg, #6c757d, #495057);
    }

    .user-info {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .ticket-message {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        margin: 10px 0;
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

            <div class="col-md-8 mt-5">

                <!-- آمار تیکت‌ها -->
                <div class="row mb-4">
                    <?php
                $sql_stats = "SELECT 
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
                    COUNT(CASE WHEN status = 'answered' THEN 1 END) as answered_count,
                    COUNT(CASE WHEN status = 'closed' THEN 1 END) as closed_count
                FROM tickets";
                $result_stats = $conn->query($sql_stats);
                $stats = $result_stats->fetch_assoc();
                ?>
                    <div class="col-md-4">
                        <div class="stat-card stat-pending">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3><?= $stats['pending_count'] ?></h3>
                                    <p class="mb-0">در انتظار پاسخ</p>
                                </div>
                                <i class="fas fa-clock fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card stat-answered">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3><?= $stats['answered_count'] ?></h3>
                                    <p class="mb-0">پاسخ داده شده</p>
                                </div>
                                <i class="fas fa-check-circle fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card stat-closed">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3><?= $stats['closed_count'] ?></h3>
                                    <p class="mb-0">بسته شده</p>
                                </div>
                                <i class="fas fa-times-circle fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- پیام‌های موفقیت و خطا -->
                <?php if (!empty($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- فیلتر وضعیت -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="btn-group w-100" role="group">
                            <a href="?status=all"
                                class="btn btn-<?= $status_filter === 'all' ? 'primary' : 'outline-primary' ?>">
                                <i class="fas fa-list me-1"></i>همه تیکت‌ها
                            </a>
                            <a href="?status=pending"
                                class="btn btn-<?= $status_filter === 'pending' ? 'warning' : 'outline-warning' ?>">
                                <i class="fas fa-clock me-1"></i>در انتظار
                            </a>
                            <a href="?status=answered"
                                class="btn btn-<?= $status_filter === 'answered' ? 'success' : 'outline-success' ?>">
                                <i class="fas fa-check-circle me-1"></i>پاسخ داده شده
                            </a>
                            <a href="?status=closed"
                                class="btn btn-<?= $status_filter === 'closed' ? 'secondary' : 'outline-secondary' ?>">
                                <i class="fas fa-times-circle me-1"></i>بسته شده
                            </a>
                        </div>
                    </div>
                </div>

                <!-- لیست تیکت‌ها -->
                <h4 class="mb-3"><i class="fas fa-ticket-alt me-2"></i>لیست تیکت‌ها</h4>

                <?php if (count($tickets) > 0): ?>
                <?php foreach ($tickets as $ticket): ?>
                <div class="card shadow mb-3 ticket-card <?= $ticket['status'] ?>">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">
                                <strong><?= htmlspecialchars($ticket['subject']) ?></strong>
                            </h6>
                            <small class="text-muted">
                                <?php 
                                    $date = new DateTime($ticket['created_at']);
                                    echo mds_date("j F Y , H:i", strtotime($ticket['created_at'])); 
                                    ?>
                            </small>
                        </div>
                        <div>
                            <?php if ($ticket['status'] == 'pending'): ?>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-clock me-1"></i>در انتظار پاسخ
                            </span>
                            <?php elseif ($ticket['status'] == 'answered'): ?>
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>پاسخ داده شده
                            </span>
                            <?php else: ?>
                            <span class="badge bg-secondary">
                                <i class="fas fa-times-circle me-1"></i>بسته شده
                            </span>
                            <?php endif; ?>

                            <?php if ($ticket['reply_count'] > 0): ?>
                            <span class="badge bg-info ms-2">
                                <?= $ticket['reply_count'] ?> پاسخ
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- اطلاعات کاربر -->
                        <div class="user-info">
                            <div class="row">
                                <div class="col-md-4">
                                    <i class="fas fa-user me-2"></i>
                                    <strong>نام:</strong>
                                    <?= htmlspecialchars($ticket['name'] . ' ' . $ticket['family']) ?>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-phone me-2"></i>
                                    <strong>شماره:</strong> <?= htmlspecialchars($ticket['mobile']) ?>
                                </div>
                                <div class="col-md-4">
                                    <i class="fas fa-hashtag me-2"></i>
                                    <strong>کد کاربر:</strong> <?= $ticket['user_id'] ?>
                                </div>
                            </div>
                        </div>

                        <!-- پیام تیکت -->
                        <div class="ticket-message">
                            <strong>پیام کاربر:</strong>
                            <p class="mb-0 mt-2"><?= nl2br(htmlspecialchars($ticket['message'])) ?></p>
                        </div>

                        <!-- دکمه‌های عملیات -->
                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-primary btn-sm" onclick="toggleReplyForm(<?= $ticket['id'] ?>)">
                                <i class="fas fa-reply me-1"></i>پاسخ دادن
                            </button>

                            <?php if ($ticket['reply_count'] > 0): ?>
                            <button class="btn btn-info btn-sm" onclick="viewReplies(<?= $ticket['id'] ?>)">
                                <i class="fas fa-comments me-1"></i>مشاهده پاسخ‌ها
                            </button>
                            <?php endif; ?>

                            <?php if ($ticket['status'] != 'closed'): ?>
                            <a href="?close_ticket=1&ticket_id=<?= $ticket['id'] ?>" class="btn btn-secondary btn-sm"
                                onclick="return confirm('آیا می‌خواهید این تیکت را ببندید؟')">
                                <i class="fas fa-times-circle me-1"></i>بستن تیکت
                            </a>
                            <?php else: ?>
                            <a href="?open_ticket=1&ticket_id=<?= $ticket['id'] ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-redo me-1"></i>بازگشایی
                            </a>
                            <?php endif; ?>

                            <a href="?delete_ticket=1&id_ticket=<?= $ticket['id'] ?>"
                                class="btn btn-danger btn-sm ms-auto"
                                onclick="return confirm('آیا مطمئن هستید که می‌خواهید این تیکت را حذف کنید؟')">
                                <i class="fas fa-trash me-1"></i>حذف
                            </a>
                        </div>

                        <!-- فرم پاسخ -->
                        <div class="reply-form mt-3" id="replyForm<?= $ticket['id'] ?>">
                            <hr>
                            <form method="POST" action="">
                                <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>">
                                <div class="mb-3">
                                    <label class="form-label"><strong>پاسخ شما:</strong></label>
                                    <textarea class="form-control" name="reply_message" rows="4"
                                        placeholder="پاسخ خود را بنویسید..." required></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" name="reply_ticket" class="btn btn-success">
                                        <i class="fas fa-paper-plane me-1"></i>ارسال پاسخ
                                    </button>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="toggleReplyForm(<?= $ticket['id'] ?>)">
                                        <i class="fas fa-times me-1"></i>انصراف
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- نمایش پاسخ‌ها -->
                        <div class="replies-container mt-3" id="repliesContainer<?= $ticket['id'] ?>"
                            style="display: none;">
                            <hr>
                            <h6><i class="fas fa-comments me-2"></i>پاسخ‌های قبلی:</h6>
                            <?php
                                $stmt_replies = $conn->prepare("
                                    SELECT 
                                        tr.*,
                                        u.name as admin_name,
                                        u.family as admin_family
                                    FROM ticket_replies tr
                                    LEFT JOIN users u ON tr.admin_id = u.id
                                    WHERE tr.ticket_id = ?
                                    ORDER BY tr.created_at ASC
                                ");
                                $stmt_replies->bind_param("i", $ticket['id']);
                                $stmt_replies->execute();
                                $result_replies = $stmt_replies->get_result();
                                
                                while ($reply = $result_replies->fetch_assoc()):
                                ?>
                            <div class="alert alert-light border-start border-4 border-info mb-2">
                                <div class="d-flex justify-content-between">
                                    <strong>
                                        <i class="fas fa-user-shield me-1"></i>
                                        <?= htmlspecialchars($reply['admin_name'] . ' ' . $reply['admin_family']) ?>
                                    </strong>
                                    <small class="text-muted">
                                        <?= mds_date("j F Y , H:i", strtotime($reply['created_at'])) ?>
                                    </small>
                                </div>
                                <p class="mb-0 mt-2"><?= nl2br(htmlspecialchars($reply['message'])) ?></p>
                            </div>
                            <?php 
                                endwhile;
                                $stmt_replies->close();
                                ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page - 1 ?>&status=<?= $status_filter ?>">
                                <span>&laquo; قبلی</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php
                            $start = max(1, $current_page - 2);
                            $end = min($total_pages, $current_page + 2);
                            for ($i = $start; $i <= $end; $i++):
                            ?>
                        <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&status=<?= $status_filter ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?>&status=<?= $status_filter ?>">
                                <span>بعدی &raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>

                <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <?php if ($status_filter !== 'all'): ?>
                    تیکتی با این وضعیت وجود ندارد.
                    <?php else: ?>
                    هیچ تیکتی وجود ندارد.
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script>
    function toggleReplyForm(ticketId) {
        const form = document.getElementById('replyForm' + ticketId);
        form.classList.toggle('show');
    }

    function viewReplies(ticketId) {
        const container = document.getElementById('repliesContainer' + ticketId);
        if (container.style.display === 'none') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }

    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
    </script>

</body>

</html>

<?php
$conn->close();
?>