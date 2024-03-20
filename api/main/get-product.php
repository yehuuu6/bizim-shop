<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Product\Cards\AddedToCart;

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$product_id = get_safe_value($con, $_POST['id']);

$product_data = get_products($con, [
    'id' => $product_id,
    'limit' => '1',
]);

$product = new AddedToCart($product_data[0]);

echo json_encode($product->body);
