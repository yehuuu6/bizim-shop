<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

// Get post data

$offset = get_safe_value($con, $_POST['offset']);
$limit = get_safe_value($con, $_POST['limit']);

if (isset($_POST['search'])) {
    $search = get_safe_value($con, $_POST['search']);
} else {
    $search = '';
}

function get_product_data(mysqli $con, string $product_id)
{
    $sql = "SELECT name, price FROM product WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $product_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $price);
    $stmt->fetch();
    $product = [
        'name' => $name,
        'price' => $price
    ];
    $stmt->close();
    return $product;
}

function get_user_data(mysqli $con, string $user_id)
{
    $sql = "SELECT name, surname FROM users WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $surname);
    $stmt->fetch();
    $user = [
        'name' => $name,
        'surname' => $surname
    ];
    $stmt->close();
    return $user;
}

try {
    $sql = "SELECT * FROM orders LIMIT $limit OFFSET $offset";
    $res = mysqli_query($con, $sql);
    $orders = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $product = get_product_data($con, $row['pid']);
        $user = get_user_data($con, $row['uid']);
        $order = [
            'id' => $row['id'],
            'guid' => $row['orderid'],
            'username' => $user['name'] . ' ' . $user['surname'],
            'product' => $product['name'],
            'productid' => $row['pid'],
            'price' => $product['price'],
            'date' => $row['date'],
            'status' => $row['status']
        ];
        array_push($orders, $order);
    }
} catch (Exception $e) {
    $orders = [$e->getMessage()];
}

echo json_encode($orders);
