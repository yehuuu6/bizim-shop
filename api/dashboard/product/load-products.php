<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

// Get post data

$offset = get_safe_value($con, $_POST['offset']);
$limit = get_safe_value($con, $_POST['limit']);

$products = get_products($con, [
    'order_type' => 'id ASC',
    'limit' => $limit,
    'offset' => $offset,
    'status' => ''
]);
echo json_encode($products);
