<?php
session_start();

if (!isset($_SESSION['all_data'])) {
    header("location: ../login.php");
    exit;
}

$user_id = $_SESSION['all_data']['id'];
$username = $_SESSION['all_data']['username'];
$message = null;
$message_type = null;

include '../config.php';

// پردازش فرم ارسال تیکت جدید
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_ticket'])) {
    $subject = trim($_POST['subject']);
    $ticket_message = trim($_POST['message']);
    
    if (!empty($subject) && !empty($ticket_message)) {
        $stmt = $conn->prepare("INSERT INTO tickets (user_id, subject, message, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("iss", $user_id, $subject, $ticket_message);
        
        if ($stmt->execute()) {
            $message = 'تیکت شما با موفقیت ثبت شد.';
            $message_type = 'success';
        } else {
            $message = 'خطا در ثبت تیکت. لطفاً دوباره تلاش کنید.';
            $message_type = 'danger';
        }
        $stmt->close();
    } else {
        $message = 'لطفاً تمام فیلدها را پر کنید.';
        $message_type = 'danger';
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
$conn->close();
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تیکت‌های من</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
    /* استایل‌های اختصاصی صفحه تیکت‌ها */
    .ticket-section {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 20px;
        border: 2px dashed #d1d3e2;
        transition: all 0.3s ease;
    }

    .ticket-section:hover {
        border-color: #4e73df;
        background: #f0f2f7;
    }

    .ticket-section .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .ticket-section .form-label i {
        color: #4e73df;
        margin-left: 8px;
    }

    .card-tickets {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .card-tickets .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 18px 25px;
        border: none;
    }

    .card-tickets .card-header h6 {
        color: white;
        font-weight: 600;
    }

    .card-tickets .card-header h6 i {
        margin-left: 10px;
    }

    .card-tickets .card-body {
        padding: 30px;
    }

    .btn-submit-ticket {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-submit-ticket:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-submit-ticket i {
        margin-left: 8px;
    }

    .btn-cancel-ticket {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .btn-cancel-ticket:hover {
        background: #f8f9fc;
        border-color: #d1d3e2;
    }

    .ticket-form-container {
        display: none;
        animation: slideDown 0.3s ease-out;
    }

    .ticket-form-container.show {
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

    .btn-new-ticket {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 25px;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-new-ticket:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-new-ticket i {
        margin-left: 8px;
    }

    .btn-new-ticket.active {
        background: #e74c3c;
    }

    .btn-new-ticket.active:hover {
        background: #c0392b;
    }

    .table-tickets {
        margin-bottom: 0;
    }

    .table-tickets thead th {
        background: #f8f9fc;
        color: #2d3748;
        font-weight: 600;
        font-size: 14px;
        border-bottom: 2px solid #e3e6f0;
        padding: 15px 12px;
        text-align: center;
    }

    .table-tickets tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        text-align: center;
        border-bottom: 1px solid #f0f2f7;
    }

    .table-tickets tbody tr {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .table-tickets tbody tr:hover {
        background: #f8f9fc;
        transform: translateX(-2px);
    }

    .ticket-subject {
        font-weight: 600;
        color: #2d3748;
    }

    .ticket-message-preview {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #6c757d;
        font-size: 14px;
    }

    .status-badge {
        font-size: 13px;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 500;
    }

    .status-badge.pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.answered {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.closed {
        background: #e2e3e5;
        color: #383d41;
    }

    .reply-count-badge {
        font-size: 13px;
        padding: 4px 12px;
        border-radius: 20px;
        background: #e7f3ff;
        color: #4e73df;
    }

    .btn-view-ticket {
        background: #edf2f7;
        border: none;
        color: #4a5568;
        padding: 6px 15px;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .btn-view-ticket:hover {
        background: #4e73df;
        color: white;
    }

    .btn-view-ticket i {
        margin-left: 5px;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-state i {
        font-size: 64px;
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
        margin: 0 auto;
    }

    /* Modal استایل */
    .modal-ticket .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 18px 25px;
    }

    .modal-ticket .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-ticket .modal-body {
        padding: 25px;
    }

    .modal-ticket .modal-footer {
        border-top: 1px solid #f0f2f7;
        padding: 15px 25px;
    }

    .ticket-detail-subject {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f2f7;
    }

    .ticket-detail-meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fc;
        border-radius: 10px;
    }

    .ticket-detail-meta .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6c757d;
    }

    .ticket-detail-meta .meta-item i {
        color: #4e73df;
    }

    .ticket-detail-message {
        background: #f8f9fc;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        border-right: 4px solid #4e73df;
    }

    .ticket-detail-message .message-label {
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .ticket-detail-message .message-text {
        color: #2d3748;
        line-height: 1.8;
        white-space: pre-wrap;
    }

    .reply-item {
        background: #f8f9fc;
        border-right: 3px solid #4e73df;
        padding: 15px 20px;
        margin-bottom: 12px;
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .reply-item.admin-reply {
        background: #e7f3ff;
        border-right-color: #28a745;
    }

    .reply-item .reply-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e3e6f0;
    }

    .reply-item .reply-author {
        font-weight: 600;
        color: #2d3748;
        font-size: 14px;
    }

    .reply-item .reply-author i {
        margin-left: 6px;
    }

    .reply-item .reply-author.admin {
        color: #28a745;
    }

    .reply-item .reply-date {
        font-size: 12px;
        color: #6c757d;
    }

    .reply-item .reply-text {
        color: #4a5568;
        line-height: 1.7;
        white-space: pre-wrap;
        font-size: 14px;
    }

    .no-replies {
        text-align: center;
        padding: 30px;
        color: #6c757d;
    }

    .no-replies i {
        font-size: 40px;
        color: #d1d3e2;
        margin-bottom: 10px;
        display: block;
    }

    @media (max-width: 768px) {
        .card-tickets .card-body {
            padding: 20px;
        }

        .table-tickets thead th,
        .table-tickets tbody td {
            padding: 10px 8px;
            font-size: 13px;
        }

        .ticket-message-preview {
            max-width: 100px;
        }

        .ticket-detail-meta {
            flex-direction: column;
            gap: 8px;
        }

        .btn-new-ticket {
            width: 100%;
            justify-content: center;
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
            <div id="alertMessage"
                class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show text-center" role="alert"
                style="border-radius: 12px;">
                <i
                    class="bi <?php echo $message_type == 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> me-2"></i>
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
                        <i class="bi bi-ticket-perforated me-2 text-primary"></i>تیکت‌های من
                    </h1>
                    <p class="text-muted mb-0">مشاهده و پیگیری تیکت‌های پشتیبانی</p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-primary bg-gradient p-2 px-3 rounded-pill">
                        <i class="bi bi-ticket me-1"></i>
                        <?php echo count($tickets); ?> تیکت
                    </span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <!-- دکمه ارسال تیکت جدید -->
                    <div class="mb-4">
                        <button class="btn btn-new-ticket" id="toggleTicketForm">
                            <i class="bi bi-plus-circle"></i>
                            ارسال تیکت جدید
                        </button>
                    </div>

                    <!-- فرم ارسال تیکت جدید -->
                    <div class="ticket-form-container mb-4" id="ticketForm">
                        <div class="card card-tickets shadow">
                            <div class="card-header">
                                <h6 class="m-0">
                                    <i class="bi bi-envelope"></i>
                                    ارسال تیکت جدید
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST" id="ticketFormSubmit">
                                    <div class="ticket-section">
                                        <div class="mb-3">
                                            <label for="subject" class="form-label">
                                                <i class="bi bi-topic"></i>
                                                موضوع تیکت
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="subject" name="subject" required
                                                placeholder="موضوع تیکت خود را وارد کنید">
                                        </div>
                                        <div class="mb-0">
                                            <label for="message" class="form-label">
                                                <i class="bi bi-chat-dots"></i>
                                                متن پیام
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="message" name="message" rows="5" required
                                                placeholder="متن پیام خود را وارد کنید..."></textarea>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="d-flex gap-3">
                                        <button type="submit" name="submit_ticket" class="btn btn-submit-ticket">
                                            <i class="bi bi-send"></i>
                                            ارسال تیکت
                                        </button>
                                        <button type="button" class="btn btn-cancel-ticket" id="cancelTicket">
                                            <i class="bi bi-x-circle"></i>
                                            انصراف
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- لیست تیکت‌ها -->
                    <div class="card card-tickets shadow">
                        <div class="card-header">
                            <h6 class="m-0">
                                <i class="bi bi-list-ul"></i>
                                لیست تیکت‌های من
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (count($tickets) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-tickets">
                                    <thead>
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
                                        <tr onclick="viewTicketDetails(<?php echo $ticket['id']; ?>)">
                                            <th scope="row"><?php echo $counter++; ?></th>
                                            <td>
                                                <span
                                                    class="ticket-subject"><?php echo htmlspecialchars($ticket['subject']); ?></span>
                                            </td>
                                            <td>
                                                <span class="ticket-message-preview"
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
                                                <span class="status-badge pending">
                                                    <i class="bi bi-clock me-1"></i>در انتظار پاسخ
                                                </span>
                                                <?php elseif ($ticket['status'] == 'answered'): ?>
                                                <span class="status-badge answered">
                                                    <i class="bi bi-check-circle me-1"></i>پاسخ داده شده
                                                </span>
                                                <?php else: ?>
                                                <span class="status-badge closed">
                                                    <i class="bi bi-x-circle me-1"></i>بسته شده
                                                </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($ticket['reply_count'] > 0): ?>
                                                <span class="reply-count-badge">
                                                    <i class="bi bi-chat me-1"></i>
                                                    <?php echo $ticket['reply_count']; ?>
                                                </span>
                                                <?php else: ?>
                                                <span class="text-muted small">بدون پاسخ</span>
                                                <?php endif; ?>
                                            </td>
                                            <td onclick="event.stopPropagation()">
                                                <button class="btn-view-ticket"
                                                    onclick="viewTicketDetails(<?php echo $ticket['id']; ?>)">
                                                    <i class="bi bi-eye"></i>
                                                    مشاهده
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>هیچ تیکتی ثبت نشده است</h5>
                                <p>شما تاکنون هیچ تیکتی ثبت نکرده‌اید. برای ارسال تیکت جدید روی دکمه <strong>ارسال تیکت
                                        جدید</strong> کلیک کنید.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal جزئیات تیکت -->
    <div class="modal fade modal-ticket" id="ticketDetailModal" tabindex="-1" aria-labelledby="ticketDetailModalLabel"
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="border-radius: 10px; padding: 10px 25px;">
                        <i class="bi bi-x-circle me-1"></i>بستن
                    </button>
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

    // نمایش/مخفی کردن فرم تیکت
    const toggleBtn = document.getElementById('toggleTicketForm');
    const ticketForm = document.getElementById('ticketForm');
    const cancelBtn = document.getElementById('cancelTicket');

    toggleBtn.addEventListener('click', function() {
        ticketForm.classList.toggle('show');
        if (ticketForm.classList.contains('show')) {
            toggleBtn.innerHTML = '<i class="bi bi-x-circle"></i> بستن فرم';
            toggleBtn.classList.add('active');
            ticketForm.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        } else {
            toggleBtn.innerHTML = '<i class="bi bi-plus-circle"></i> ارسال تیکت جدید';
            toggleBtn.classList.remove('active');
        }
    });

    cancelBtn.addEventListener('click', function() {
        ticketForm.classList.remove('show');
        toggleBtn.innerHTML = '<i class="bi bi-plus-circle"></i> ارسال تیکت جدید';
        toggleBtn.classList.remove('active');
        document.getElementById('subject').value = '';
        document.getElementById('message').value = '';
    });

    // اعتبارسنجی فرم با SweetAlert
    document.getElementById('ticketFormSubmit').addEventListener('submit', function(e) {
        const subject = document.getElementById('subject').value.trim();
        const message = document.getElementById('message').value.trim();

        if (!subject || !message) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'تکمیل فرم',
                text: 'لطفاً تمام فیلدهای مورد نیاز را پر کنید!',
                confirmButtonColor: '#667eea',
                confirmButtonText: 'متوجه شدم'
            });
        }
    });

    // مشاهده جزئیات تیکت
    function viewTicketDetails(ticketId) {
        const modal = new bootstrap.Modal(document.getElementById('ticketDetailModal'));
        modal.show();

        document.getElementById('ticketDetailContent').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">در حال بارگذاری...</span>
                </div>
            </div>
        `;

        fetch('get_ticket_details.php?ticket_id=' + ticketId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                document.getElementById('ticketDetailContent').innerHTML = data;
            })
            .catch(error => {
                document.getElementById('ticketDetailContent').innerHTML = `
                    <div class="alert alert-danger text-center" style="border-radius: 12px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        خطا در بارگذاری اطلاعات تیکت
                    </div>
                `;
            });
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