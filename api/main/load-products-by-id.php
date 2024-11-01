<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Product\Cards\InCart;
use Components\Product\Cards\ProductCard;

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$product_ids = get_safe_value($con, $_POST['product-ids']);
$product_type = get_safe_value($con, $_POST['product-type']);
@$limit = get_safe_value($con, $_POST['limit']);

isset($limit) ? $limit = $limit : $limit = PHP_INT_MAX;

if (!is_string($product_ids)) {
    echo json_encode(array());
    exit;
}
// Convert string to array
$product_ids = explode(",", $product_ids);

// If the cart is empty, return an empty array
if (count($product_ids) == 1 && $product_ids[0] == "") {
    echo json_encode(array());
    exit;
}

$products = array();

foreach ($product_ids as $id) {
    $product = get_products($con, [
        'status' => '1',
        'id' => $id,
    ]);
    if (count($product) == 0) {
        continue;
    }
    if ($product_type === "in-cart") {
        $p = new InCart($product[0]);
    } else if ($product_type === "default") {
        $p = new ProductCard($product[0]);
    } else {
        echo json_encode(array());
        exit;
    }
    if (!isset($limit)) {
        array_push($products, $p->body);
    } else {
        if (count($products) < $limit) {
            array_push($products, $p->body);
        } else {
            break;
        }
    }
}
echo json_encode($products);
