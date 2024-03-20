<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

// Get post data

$start = get_safe_value($con, $_POST['start']);

$sql = "SELECT * FROM ORDERS LIMIT $start, 10";
$res = mysqli_query($con, $sql);
$order_count = mysqli_num_rows($res);

// Send order list to client
if ($order_count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $sql1 = "SELECT name, surname FROM users WHERE id = '{$row['uid']}'";
        $res1 = mysqli_query($con, $sql1);
        $user = mysqli_fetch_assoc($res1);
        $row['user_name'] = $user['name'] . ' ' . $user['surname'];

        $sql2 = "SELECT name, price FROM product WHERE id = '{$row['pid']}'";
        $res2 = mysqli_query($con, $sql2);
        $product = mysqli_fetch_assoc($res2);
        $row['product_name'] = $product['name'];
        $row['product_price'] = $product['price'];
        $result[] = $row;
    }
}
echo json_encode($result);
