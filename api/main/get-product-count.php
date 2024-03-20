<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

if (isset($_POST['search'])) {
    $query = get_safe_value($con, $_POST['search']);
} else {
    $query = '';
}

if (isset($_POST['p-sub-category']) && $_POST['p-sub-category'] != 0) {
    $sub_category = get_safe_value($con, $_POST['p-sub-category']);
} else {
    $sub_category = '';
}

if (isset($_POST['category'])) {
    $category = get_safe_value($con, $_POST['category']);
} else {
    $category = '';
}

if (isset($_POST['p-featured'])) {
    $featured = get_safe_value($con, $_POST['p-featured']);
} else {
    $featured = '';
}

if (isset($_POST['p-shipment'])) {
    $shipment = get_safe_value($con, $_POST['p-shipment']);
} else {
    $shipment = '';
}

if (isset($_POST['min-price'])) {
    $min_price = get_safe_value($con, $_POST['min-price']);
} else {
    $min_price = '';
}

if (isset($_POST['max-price'])) {
    $max_price = get_safe_value($con, $_POST['max-price']);
} else {
    $max_price = '';
}

$products = get_products($con, [
    'search' => $query,
    'category' => $category,
    'sub_category' => $sub_category,
    'featured' => $featured,
    'shipping' => $shipment,
    'min_price' => $min_price,
    'max_price' => $max_price,
]);

// Echo length of products array
echo json_encode(count($products));
