<?php
session_start();

if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION['all_data']['id'];

include '../config.php';

// پردازش فرم ارسال تیکت جدید
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_ticket'])) {
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);
    
    if (!empty($subject) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO tickets (user_id, subject, message, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("iss", $user_id, $subject, $message);
        
        if ($stmt->execute()) {
            $success_message = 'تیکت شما با موفقیت ثبت شد.';
        } else {
            $error_message = 'خطا در ثبت تیکت. لطفا دوباره تلاش کنید.';
        }
        $stmt->close();
    } else {
        $error_message = 'لطفا تمام فیلدها را پر کنید.';
    }
}

// واکشی تیکت‌های کاربر
$stmt_tickets = $conn->prepare("
    SELECT 
        t.id, 
        t.subject, 
        t.message, 
        t.status, 
        t.created_at,
        (SELECT COUNT(*) FROM ticket_replies WHERE ticket_id = t.id) as reply_count
    FROM tickets t 
    WHERE t.user_id = ? 
    ORDER BY t.created_at DESC
");
$stmt_tickets->bind_param("i", $user_id);
$stmt_tickets->execute();
$result_tickets = $stmt_tickets->get_result();

$tickets = [];
if ($result_tickets->num_rows > 0) {
    while ($row = $result_tickets->fetch_assoc()) {
        $tickets[] = $row;
    }
}
$stmt_tickets->close();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تیکت های من</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles.css">
    <style>
    .table-responsive {
        margin-top: 20px;
    }

    .ticket-form {
        display: none;
        animation: slideDown 0.3s ease-out;
    }

    .ticket-form.show {
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

    .status-badge {
        font-size: 0.85rem;
    }

    .ticket-message {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .ticket-row {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .ticket-row:hover {
        background-color: #f8f9fa;
        transform: translateX(-2px);
    }

    .reply-item {
        background: #f8f9fa;
        border-right: 3px solid #0d6efd;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    .reply-item.admin-reply {
        background: #e7f3ff;
        border-right-color: #28a745;
    }

    .reply-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
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
                    <h1 class="h3 mb-4 text-gray-800"><i class="bi bi-ticket-perforated me-2"></i>تیکت های من</h1>

                    <!-- پیام‌های موفقیت و خطا -->
                    <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i><?php echo $success_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <!-- دکمه ارسال تیکت جدید -->
                            <div class="mb-3">
                                <button class="btn btn-primary" id="toggleTicketForm">
                                    <i class="bi bi-plus-circle me-2"></i>ارسال تیکت جدید
                                </button>
                            </div>

                            <!-- فرم ارسال تیکت جدید -->
                            <div class="card shadow mb-4 ticket-form" id="ticketForm">
                                <div class="card-header py-3 bg-primary text-white">
                                    <h6 class="m-0 font-weight-bold"><i class="bi bi-envelope me-2"></i>ارسال تیکت جدید
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="mb-3">
                                            <label for="subject" class="form-label">موضوع تیکت <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="subject" name="subject" required
                                                placeholder="موضوع تیکت خود را وارد کنید">
                                        </div>
                                        <div class="mb-3">
                                            <label for="message" class="form-label">پیام <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="message" name="message" rows="5" required
                                                placeholder="متن پیام خود را وارد کنید..."></textarea>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="submit" name="submit_ticket" class="btn btn-primary">
                                                <i class="bi bi-send me-2"></i>ارسال تیکت
                                            </button>
                                            <button type="button" class="btn btn-secondary" id="cancelTicket">
                                                <i class="bi bi-x-circle me-2"></i>انصراف
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- لیست تیکت‌ها -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">لیست تیکت‌های من</h6>
                                </div>
                                <div class="card-body">
                                    <?php if (count($tickets) > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">موضوع</th>
                                                    <th scope="col">پیام</th>
                                                    <th scope="col">تاریخ ثبت</th>
                                                    <th scope="col">وضعیت</th>
                                                    <th scope="col">پاسخ‌ها</th>
                                                    <th scope="col">عملیات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $counter = 1; ?>
                                                <?php foreach ($tickets as $ticket): ?>
                                                <tr class="ticket-row"
                                                    onclick="viewTicketDetails(<?php echo $ticket['id']; ?>)">
                                                    <th scope="row"><?php echo $counter++; ?></th>
                                                    <td><strong><?php echo htmlspecialchars($ticket['subject']); ?></strong>
                                                    </td>
                                                    <td>
                                                        <span class="ticket-message"
                                                            title="<?php echo htmlspecialchars($ticket['message']); ?>">
                                                            <?php echo htmlspecialchars($ticket['message']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?php 
                                                                    $date = new DateTime($ticket['created_at']);
                                                                    echo $date->format('Y/m/d H:i'); 
                                                                    ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <?php if ($ticket['status'] == 'pending'): ?>
                                                        <span class="badge bg-warning text-dark status-badge">
                                                            <i class="bi bi-clock me-1"></i>در انتظار پاسخ
                                                        </span>
                                                        <?php elseif ($ticket['status'] == 'answered'): ?>
                                                        <span class="badge bg-success status-badge">
                                                            <i class="bi bi-check-circle me-1"></i>پاسخ داده شده
                                                        </span>
                                                        <?php else: ?>
                                                        <span class="badge bg-secondary status-badge">
                                                            <i class="bi bi-x-circle me-1"></i>بسته شده
                                                        </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($ticket['reply_count'] > 0): ?>
                                                        <span class="badge bg-info">
                                                            <?php echo $ticket['reply_count']; ?> پاسخ
                                                        </span>
                                                        <?php else: ?>
                                                        <span class="text-muted small">بدون پاسخ</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center" onclick="event.stopPropagation()">
                                                        <button class="btn btn-sm btn-info"
                                                            onclick="viewTicketDetails(<?php echo $ticket['id']; ?>)">
                                                            <i class="bi bi-eye"></i> مشاهده
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-info" role="alert">
                                        <i class="bi bi-info-circle me-2"></i>شما تاکنون هیچ تیکتی ثبت نکرده‌اید. برای
                                        ارسال تیکت جدید روی دکمه بالا کلیک کنید.
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

    <!-- Modal جزئیات تیکت -->
    <div class="modal fade" id="ticketDetailModal" tabindex="-1" aria-labelledby="ticketDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketDetailModalLabel">
                        <i class="bi bi-ticket-detailed me-2"></i>جزئیات تیکت
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="ticketDetailContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">در حال بارگذاری...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>بستن
                    </button>
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

    // نمایش/مخفی کردن فرم تیکت
    const toggleBtn = document.getElementById('toggleTicketForm');
    const ticketForm = document.getElementById('ticketForm');
    const cancelBtn = document.getElementById('cancelTicket');

    toggleBtn.addEventListener('click', function() {
        ticketForm.classList.toggle('show');
        if (ticketForm.classList.contains('show')) {
            toggleBtn.innerHTML = '<i class="bi bi-dash-circle me-2"></i>بستن فرم';
            ticketForm.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        } else {
            toggleBtn.innerHTML = '<i class="bi bi-plus-circle me-2"></i>ارسال تیکت جدید';
        }
    });

    cancelBtn.addEventListener('click', function() {
        ticketForm.classList.remove('show');
        toggleBtn.innerHTML = '<i class="bi bi-plus-circle me-2"></i>ارسال تیکت جدید';
        document.getElementById('subject').value = '';
        document.getElementById('message').value = '';
    });

    // مشاهده جزئیات تیکت
    function viewTicketDetails(ticketId) {
        const modal = new bootstrap.Modal(document.getElementById('ticketDetailModal'));
        modal.show();

        // بارگذاری محتوای تیکت
        fetch('get_ticket_details.php?ticket_id=' + ticketId)
            .then(response => response.text())
            .then(data => {
                document.getElementById('ticketDetailContent').innerHTML = data;
            })
            .catch(error => {
                document.getElementById('ticketDetailContent').innerHTML =
                    '<div class="alert alert-danger">خطا در بارگذاری اطلاعات تیکت</div>';
            });
    }
    </script>
</body>

</html>

<?php
$conn->close();
?>