<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

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
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
