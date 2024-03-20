<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

$sql = "SELECT value FROM site WHERE keyword = 'maintenance'";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$old_maintenance = $result->fetch_assoc()['value'];

if ($old_maintenance == 'true') {
    $maintenance = 'false';
} else {
    $maintenance = 'true';
}

$sql = "UPDATE site SET value = ? WHERE keyword = 'maintenance'";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $maintenance);
$stmt->execute();
$stmt->close();

$_SESSION['maintenance'] = $maintenance;

$result = array('success', $maintenance, 'none');

echo json_encode($result);
