<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

// Pull districts from database
$sql = "SELECT * FROM cities";
$res = mysqli_query($con, $sql);
$cities = array();

while ($row = mysqli_fetch_assoc($res)) {
    $cities[] = $row;
}

echo json_encode($cities);
