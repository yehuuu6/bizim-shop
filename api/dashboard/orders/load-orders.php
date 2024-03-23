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

$stmt = $con->prepare("SELECT * from orders LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$res = $stmt->get_result();
$order_count = $res->num_rows;

// Send order list to client
if ($order_count > 0) {
    while ($row = $res->fetch_assoc()) {
        $result[] = $row;
    }
}
echo json_encode($result);
