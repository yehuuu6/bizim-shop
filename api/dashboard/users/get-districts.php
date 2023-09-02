<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    // Pull districts from database
    $sql = "SELECT * FROM districts";
    $res = mysqli_query($con, $sql);
    $districts = array();

    while ($row = mysqli_fetch_assoc($res)) {
        $districts[] = $row;
    }

    echo json_encode($districts);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
