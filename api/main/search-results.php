<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Product\Cards\InSearch;

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$query = get_safe_value($con, $_POST['search_query']);

$product_data = get_products($con, [
    'search' => $query,
    'limit' => '10',
    'order_type' => 'id DESC',
]);

$result = [];

foreach ($product_data as $product) {
    $result[] = new InSearch($product);
}

echo json_encode($result);
