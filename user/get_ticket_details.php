<?php
session_start();

if (!isset($_SESSION['all_data'])) {
    echo '<div class="alert alert-danger">دسترسی غیرمجاز</div>';
    exit;
}

include "../PersianCalendar.php";

$user_id = $_SESSION['all_data']['id'];
$ticket_id = isset($_GET['ticket_id']) ? intval($_GET['ticket_id']) : 0;

include '../config.php';
include '../functions.php';

// واکشی اطلاعات تیکت
$stmt = $conn->prepare("
    SELECT 
        t.id, 
        t.subject, 
        t.message, 
        t.status, 
        t.created_at
    FROM tickets t 
    WHERE t.id = ? AND t.user_id = ?
");
$stmt->bind_param("ii", $ticket_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<div class="alert alert-danger">تیکت مورد نظر یافت نشد یا دسترسی ندارید.</div>';
    exit;
}

$ticket = $result->fetch_assoc();
$stmt->close();

// واکشی پاسخ‌های تیکت
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
$stmt_replies->bind_param("i", $ticket_id);
$stmt_replies->execute();
$result_replies = $stmt_replies->get_result();

$replies = [];
if ($result_replies->num_rows > 0) {
    while ($row = $result_replies->fetch_assoc()) {
        $replies[] = $row;
    }
}
$stmt_replies->close();
$conn->close();
?>

<!-- اطلاعات اصلی تیکت -->
<div class="card mb-3">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="bi bi-info-circle me-2"></i>اطلاعات تیکت
            </h6>
            <?php if ($ticket['status'] == 'pending'): ?>
            <span class="badge bg-warning text-dark">
                <i class="bi bi-clock me-1"></i>در انتظار پاسخ
            </span>
            <?php elseif ($ticket['status'] == 'answered'): ?>
            <span class="badge bg-success">
                <i class="bi bi-check-circle me-1"></i>پاسخ داده شده
            </span>
            <?php else: ?>
            <span class="badge bg-secondary">
                <i class="bi bi-x-circle me-1"></i>بسته شده
            </span>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <strong><i class="bi bi-calendar3 me-2"></i>تاریخ ثبت:</strong>
                <span class="text-muted">
                    <?php echo mds_date("j F Y , H:i", strtotime($ticket['created_at'])); ?>
                </span>
            </div>
            <div class="col-md-6">
                <strong><i class="bi bi-hash me-2"></i>شماره تیکت:</strong>
                <span class="text-muted">#<?php echo $ticket['id']; ?></span>
            </div>
        </div>

        <div class="mb-3">
            <strong><i class="bi bi-tag me-2"></i>موضوع:</strong>
            <p class="mb-0 mt-2"><?php echo htmlspecialchars($ticket['subject']); ?></p>
        </div>

        <div class="mb-0">
            <strong><i class="bi bi-chat-left-text me-2"></i>پیام شما:</strong>
            <div class="alert alert-light mt-2 mb-0">
                <?php echo nl2br(htmlspecialchars($ticket['message'])); ?>
            </div>
        </div>
    </div>
</div>

<!-- پاسخ‌های تیکت -->
<div class="card">
    <div class="card-header bg-light">
        <h6 class="mb-0">
            <i class="bi bi-chat-dots me-2"></i>پاسخ‌ها
            <?php if (count($replies) > 0): ?>
            <span class="badge bg-primary"><?php echo count($replies); ?></span>
            <?php endif; ?>
        </h6>
    </div>
    <div class="card-body">
        <?php if (count($replies) > 0): ?>
        <?php foreach ($replies as $reply): ?>
        <div class="reply-item admin-reply">
            <div class="reply-header">
                <div>
                    <strong class="text-success">
                        <i class="bi bi-person-badge me-1"></i>
                        <?php echo htmlspecialchars($reply['admin_name'] . ' ' . $reply['admin_family']); ?>
                    </strong>
                    <small class="text-muted ms-2">(پشتیبانی)</small>
                </div>
                <small class="text-muted">
                    <i class="bi bi-clock me-1"></i>
                    <?php echo mds_date("j F Y , H:i", strtotime($reply['created_at'])); ?>
                </small>
            </div>
            <div class="reply-content">
                <?php echo nl2br(htmlspecialchars($reply['message'])); ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <div class="text-center py-4 text-muted">
            <i class="bi bi-chat-square-dots fs-1 d-block mb-3"></i>
            <p class="mb-0">هنوز پاسخی برای این تیکت ثبت نشده است.</p>
            <small>لطفا منتظر بمانید، به زودی پاسخ شما داده خواهد شد.</small>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- راهنما برای کاربر -->
<?php if ($ticket['status'] == 'pending'): ?>
<div class="alert alert-info mt-3 mb-0">
    <i class="bi bi-info-circle-fill me-2"></i>
    <strong>توجه:</strong> تیکت شما در صف پاسخگویی قرار دارد. کارشناسان ما در اسرع وقت به تیکت شما پاسخ خواهند داد.
</div>
<?php endif; ?>

<?php if ($ticket['status'] == 'closed'): ?>
<div class="alert alert-secondary mt-3 mb-0">
    <i class="bi bi-lock-fill me-2"></i>
    <strong>توجه:</strong> این تیکت بسته شده است. در صورت نیاز به پیگیری بیشتر، لطفا تیکت جدیدی ارسال کنید.
</div>
<?php endif; ?>