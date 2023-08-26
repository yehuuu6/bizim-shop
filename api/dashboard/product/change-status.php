<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    Authorize();

    $id = get_safe_value($con, $_POST['id']);
    $status = get_safe_value($con, $_POST['status']);

    $sql = "UPDATE product SET status = '$status' WHERE id = '$id'";
    mysqli_query($con, $sql);
    sendSuccessResponse('Ürün durumu başarıyla değiştirildi.');
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
