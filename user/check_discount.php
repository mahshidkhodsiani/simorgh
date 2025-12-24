<?php
session_start();
include '../config.php';

if(isset($_POST['cart_id']) && isset($_POST['code'])) {
    $cart_id = intval($_POST['cart_id']);
    $code = trim($_POST['code']);

    $stmt = $conn->prepare("SELECT p.price, p.discount_code, p.discount_price FROM user_cart uc JOIN packages p ON uc.package_id = p.id WHERE uc.id = ?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if($res && $res['discount_code'] === $code && !empty($code)) {
        $new_price = $res['price'] - $res['discount_price'];
        // اصلاح $max به max
        echo json_encode(['success' => true, 'new_price' => max(0, $new_price)]);
    } else {
        echo json_encode(['success' => false]);
    }
}
// علامت } اضافی حذف شد