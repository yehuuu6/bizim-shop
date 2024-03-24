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

if (isset($_POST['search'])) {
    $search = get_safe_value($con, $_POST['search']);
} else {
    $search = '';
}

if (isset($_POST['filter-sort'])) {
    $sort = get_safe_value($con, $_POST['filter-sort']);
} else {
    $sort = 'id ASC';
}

if (isset($_POST['filter-status'])) {
    $status = get_safe_value($con, $_POST['filter-status']);
} else {
    $status = '';
}

if (isset($_POST['filter-category'])) {
    $category = get_safe_value($con, $_POST['filter-category']);
} else {
    $category = '';
}

if (isset($_POST['filter-featured'])) {
    $featured = get_safe_value($con, $_POST['filter-featured']);
} else {
    $featured = '';
}

if (isset($_POST['filter-shipment'])) {
    $shipping = get_safe_value($con, $_POST['filter-shipment']);
} else {
    $shipping = '';
}

if (isset($_POST['filter-price-min'])) {
    $min_price = get_safe_value($con, $_POST['filter-price-min']);
} else {
    $min_price = '0';
}

if (isset($_POST['filter-price-max'])) {
    $max_price = get_safe_value($con, $_POST['filter-price-max']);
} else {
    $max_price = PHP_INT_MAX;
}

if ($category == null) {
    $category = '';
}

if ($status == null) {
    $status = '';
}

$products = get_products($con, [
    'order_type' => $sort,
    'search' => $search,
    'offset' => $offset,
    'limit' => $limit,
    'min_price' => $min_price,
    'max_price' => $max_price,
    'featured' => $featured,
    'shipping' => $shipping,
    'sub_category' => $category,
    'status' => $status,
]);

echo json_encode($products);
