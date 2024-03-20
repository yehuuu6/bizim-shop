<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

// Get post data

$sql = "SELECT id, name FROM categories";
$res = mysqli_query($con, $sql);
$category_count = mysqli_num_rows($res);

// Send category list to client
if ($category_count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        // Skip Uncategorized category
        if ($row['id'] == 0) {
            continue;
        }
        $result[] = $row;
    }
}
echo json_encode($result);
