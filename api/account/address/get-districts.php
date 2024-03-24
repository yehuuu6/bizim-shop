<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

// Pull districts from database
$sql = "SELECT * FROM districts";
$res = mysqli_query($con, $sql);
$districts = array();

while ($row = mysqli_fetch_assoc($res)) {
    $districts[] = $row;
}

echo json_encode($districts);
