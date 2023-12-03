<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    // Pull districts from database
    $sql = "SELECT * FROM cities";
    $res = mysqli_query($con, $sql);
    $cities = array();

    while ($row = mysqli_fetch_assoc($res)) {
        $cities[] = $row;
    }

    echo json_encode($cities);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
