<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

if (!isset($_SESSION['id'])) {
    send_forbidden_response();
}

$user_id = get_safe_value($con, $_POST['user_id']);
$product_id = get_safe_value($con, $_POST['product_id']);

if (place_order($con, $user_id, $product_id)) {
    send_success_response('Siparişiniz başarıyla alındı.');
} else {
    send_error_response('Siparişiniz alınırken bir hata oluştu.');
}
