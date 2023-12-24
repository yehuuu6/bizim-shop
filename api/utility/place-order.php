<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $user_id = get_safe_value($con, $_POST['user_id']);
    $product_id = get_safe_value($con, $_POST['product_id']);

    if (place_order($con, $user_id, $product_id)) {
        send_success_response('Siparişiniz başarıyla alındı.');
    } else {
        send_error_response('Siparişiniz alınırken bir hata oluştu.');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
