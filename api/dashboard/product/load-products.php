<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $result = array();
    $id = $_SESSION['id'];

    // Get post data

    $start = get_safe_value($con, $_POST['start']);

    $sql = "SELECT * FROM product LIMIT $start, 5";
    $res = mysqli_query($con, $sql);
    $product_count = mysqli_num_rows($res);

    // Send plugin list to client
    if ($product_count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            $row = fix_strings($row);
            $result[] = $row;
        }
    }
    echo json_encode($result);
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
