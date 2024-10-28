<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php");

use Components\Product\OrderDetails;

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$order_id = get_safe_value($con, $_POST['order_id']);
$product_id = get_safe_value($con, $_POST['product_id']);

$sql = "SELECT * FROM orders WHERE orderid = ? AND pid = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('ss', $order_id, $product_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $orderid, $uid, $pid, $order_date, $last_update, $status);
$stmt->fetch();
$stmt->close();

$order = [
    'id' => $id,
    'orderid' => $orderid,
    'uid' => $uid,
    'pid' => $pid,
    'order_date' => $order_date,
    'last_update' => $last_update,
    'status' => $status
];

$sql = "SELECT name, price, image1, root_name FROM product WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('s', $product_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($name, $price, $image, $root_name);
$stmt->fetch();
$stmt->close();

$image_src = PRODUCT_IMAGE_SITE_PATH . "{$root_name}/{$image}";

$product = [
    'name' => $name,
    'price' => $price,
    'image' => $image_src
];

$orderDetails = new OrderDetails($order, $product);

echo json_encode($orderDetails->body);
