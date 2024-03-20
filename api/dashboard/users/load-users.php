<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

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
