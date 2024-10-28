<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$status = get_safe_value($con, $_POST['status']);
$order_id = get_safe_value($con, $_POST['order_id']);

$last_update_date = date('Y-m-d H:i:s');

try {
    $sql = "UPDATE orders SET status = ?, last_update = ? WHERE orderid = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sss', $status, $last_update_date, $order_id);
    $stmt->execute();
    $stmt->close();
} catch (Exception $e) {
    send_error_response("Bir hata oluştu. Lütfen tekrar deneyin: " . $e->getMessage());
}

send_success_response("Sipariş durumu başarıyla güncellendi.");
