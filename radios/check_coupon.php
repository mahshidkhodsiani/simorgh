<?php
session_start();
include '../config.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'error' => 'درخواست نامعتبر است.']);
    exit();
}

$code = trim($_POST['code'] ?? '');
if ($code === '') {
    echo json_encode(['ok' => false, 'error' => 'کد تخفیف را وارد کنید.']);
    exit();
}

$stmt = $conn->prepare("SELECT code, applies_to, takhfif_amount, is_active 
                        FROM codes WHERE code = ? LIMIT 1");
$stmt->bind_param("s", $code);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    echo json_encode(['ok' => false, 'error' => 'کد تخفیف یافت نشد.']);
    $stmt->close();
    exit();
}

$c = $res->fetch_assoc();
$stmt->close();

if ((int)$c['is_active'] !== 1) {
    echo json_encode(['ok' => false, 'error' => 'این کد غیرفعال شده است.']);
    exit();
}

if (!in_array($c['applies_to'], ['radio', 'all'], true)) {
    echo json_encode(['ok' => false, 'error' => 'این کد برای رادیو قابل استفاده نیست.']);
    exit();
}

$discount = (int)$c['takhfif_amount'];
if ($discount <= 0) {
    echo json_encode(['ok' => false, 'error' => 'مقدار تخفیف نامعتبر است.']);
    exit();
}

echo json_encode([
    'ok'       => true,
    'code'     => $c['code'],
    'discount' => $discount
], JSON_UNESCAPED_UNICODE);