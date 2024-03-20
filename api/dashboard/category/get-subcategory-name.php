<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

$sub_category_id = get_safe_value($con, $_POST['id']);

$sql = "SELECT name FROM subcats WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 'i', $sub_category_id);

try {
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    send_success_response($row['name']);
} catch (Exception $e) {
    send_error_response($e->getMessage());
} finally {
    mysqli_stmt_close($stmt);
}
