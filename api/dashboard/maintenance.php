<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

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
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
