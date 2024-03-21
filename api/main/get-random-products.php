<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Product\Cards\ProductCard;

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

$current_product_id = get_safe_value($con, $_POST['id']);

if (!validate_request()) {
    send_forbidden_response();
}

function get_random_products(mysqli $con)
{
    global $current_product_id;

    $did_skip = false;

    $products = get_products($con, [
        'limit' => 5,
        'order_type' => 'RAND()'
    ]);
    $product_elements = [];

    foreach ($products as $product) {
        if ($product['id'] == $current_product_id) {
            $did_skip = true;
            continue;
        }
        $product_element = new ProductCard($product);
        array_push($product_elements, $product_element->body);
    }

    // If we did not skip, we will remove the last element.

    if (!$did_skip) {
        array_pop($product_elements);
    }

    return $product_elements;
}

$result = get_random_products($con);
echo json_encode($result);
