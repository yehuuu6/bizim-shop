<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $id = $_SESSION['id'];

    // Get post data

    $offset = get_safe_value($con, $_POST['offset']);
    $limit = get_safe_value($con, $_POST['limit']);

    $products = get_products($con, [
        'order_type' => 'ASC',
        'limit' => $limit,
        'offset' => $offset,
    ]);
    echo json_encode($products);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
