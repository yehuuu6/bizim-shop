<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $result = array();

    // Get post data

    $sub_id = get_safe_value($con, $_POST['id']);
    $sub_name = get_safe_value($con, $_POST['name']);
    $cid = get_safe_value($con, $_POST['cid']);
    $slug = convert_link_name($sub_name);

    if ($sub_name == '') {
        send_error_response("Alt kategori adı boş olamaz.", 'new-subcat-name');
    }
    // Send category list to client
    if ($sub_id != '') {
        $sql = "UPDATE subcats SET name = ?, cid = ?, slug = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'sisi', $sub_name, $cid, $slug, $sub_id);
        try {
            mysqli_stmt_execute($stmt);
            send_success_response("Alt kategori başarıyla güncellendi.");
        } catch (Exception $e) {
            send_error_response("{$e->getMessage()}");
        } finally {
            mysqli_stmt_close($stmt);
        }
    } else {
        send_error_response("Alt kategori id'si boş olamaz.");
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
