<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $result = array();

    $query = "SELECT (SELECT COUNT(*) FROM USERS) as total_users, (SELECT COUNT(*) FROM ORDERS) as total_orders";
    $stmt = $con->prepare($query);

    // Execute the statement
    if ($stmt->execute()) {
        $stmt->bind_result($total_users, $total_orders);
        $stmt->fetch();
        $stmt->close();

        $result['total_users'] = $total_users;
        $result['total_orders'] = $total_orders;
    } else {
        die("Bir hata oluştu.");
    }
    echo json_encode($result);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
