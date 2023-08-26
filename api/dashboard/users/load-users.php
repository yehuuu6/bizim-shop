<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    Authorize();

    $result = array();

    // Get post data

    $start = get_safe_value($con, $_POST['start']);

    $sql = "SELECT id, name, surname, email, membership,telephone FROM users LIMIT $start, 10";
    $res = mysqli_query($con, $sql);
    $user_count = mysqli_num_rows($res);

    // Send user list to client
    if ($user_count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $result[] = $row;
        }
    }
    echo json_encode($result);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
