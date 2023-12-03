<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $result = array();

    // Get post data

    $sql = "SELECT id, name FROM categories";
    $res = mysqli_query($con, $sql);
    $category_count = mysqli_num_rows($res);

    // Send category list to client
    if ($category_count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $result[] = $row;
        }
    }
    echo json_encode($result);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
