<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Product\Cards\ProductCard;

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$result = array();

$sort = get_safe_value($con, $_POST['p-sort']);
$limit = get_safe_value($con, $_POST['limit']);
$offset = get_safe_value($con, $_POST['offset']);
@$search = get_safe_value($con, $_POST['search']);
@$category = get_safe_value($con, $_POST['category']);
@$sub_category = get_safe_value($con, $_POST['p-sub-category']);
@$featured = get_safe_value($con, $_POST['p-featured']);
@$shipment = get_safe_value($con, $_POST['p-shipment']);
@$min_price = get_safe_value($con, $_POST['min-price']);
@$max_price = get_safe_value($con, $_POST['max-price']);

isset($search) ? $search = $search : $search = '';
isset($category) ? $category = $category : $category = '';
isset($sub_category) ? $sub_category = $sub_category : $sub_category = '';
isset($featured) ? $featured = '1' : $featured = '';
isset($shipment) ? $shipment = '1' : $shipment = '';
$sub_category == 0 ? $sub_category = '' : $sub_category = $sub_category;
$min_price == '' ? $min_price = '0' : $min_price = $min_price;
$max_price == '' ? $max_price = PHP_INT_MAX : $max_price = $max_price;

$products = get_products($con, [
    'order_type' => $sort,
    'search' => $search,
    'category' => $category,
    'sub_category' => $sub_category,
    'shipping' => $shipment,
    'featured' => $featured,
    'min_price' => $min_price,
    'max_price' => $max_price,
    'limit' => $limit,
    'offset' => $offset,
]);

foreach ($products as $product) {
    // If not already in the array push it
    if (in_array($product['id'], $result)) {
        continue;
    }
    $p = new ProductCard($product);
    array_push($result, $p->body);
}

echo json_encode($result);
