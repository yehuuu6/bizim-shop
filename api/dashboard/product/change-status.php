<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$id = get_safe_value($con, $_POST['id']);
$status = get_safe_value($con, $_POST['status']);

// Update the product status using stmt prepare
$sql = "UPDATE product SET status = ? WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "ii", $status, $id);

// If the product status is updated successfully, send a success response
try {
    mysqli_stmt_execute($stmt);
    send_success_response('Ürün durumu başarıyla güncellendi.');
} catch (Exception $e) {
    send_error_response("Bir hata oluştu. Lütfen daha sonra tekrar deneyin.");
}
