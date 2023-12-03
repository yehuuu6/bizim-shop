<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Product\Product;

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $result = array();

    $sort = get_safe_value($con, $_POST['p-sort']);
    $limit = get_safe_value($con, $_POST['limit']);
    $offset = get_safe_value($con, $_POST['offset']);
    $category = get_safe_value($con, $_POST['p-category']);
    @$featured = get_safe_value($con, $_POST['p-featured']);
    @$shipment = get_safe_value($con, $_POST['p-shipment']);
    @$min_price = get_safe_value($con, $_POST['min-price']);
    @$max_price = get_safe_value($con, $_POST['max-price']);

    isset($featured) ? $featured = '1' : $featured = '';
    isset($shipment) ? $shipment = '1' : $shipment = '';
    $category == 0 ? $category = '' : $category = $category;
    $min_price == '' ? $min_price = '0' : $min_price = $min_price;
    $max_price == '' ? $max_price = PHP_INT_MAX : $max_price = $max_price;

    $products = get_products($con, [
        'order_type' => $sort,
        'category' => $category,
        'shipping' => $shipment,
        'featured' => $featured,
        'min_price' => $min_price,
        'max_price' => $max_price,
        'limit' => $limit,
        'offset' => $offset,
    ]);

    foreach ($products as $product) {
        $p = new Product($product);
        array_push($result, $p->body);
    }

    echo json_encode($result);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
