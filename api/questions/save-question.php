<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

if (!isset($_SESSION['id'])) {
    send_forbidden_response();
}

$product_id = get_safe_value($con, $_POST['product_id']);

if (!isset($product_id)) {
    send_error_response('Product ID is required');
}
