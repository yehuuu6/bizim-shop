<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $action = get_safe_value($con, $_POST['action']);

    $valid_actions = ['checkLogin'];

    if (in_array($action, $valid_actions)) {
        switch ($action) {
            case 'checkLogin':
                $is_logged_in = isset($_SESSION['id']);
                echo json_encode($is_logged_in);
                break;
            default:
                header("HTTP/1.1 403 Forbidden");
                include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
                exit;
        }
    } else {
        header("HTTP/1.1 403 Forbidden");
        include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
        exit;
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
