<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

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
        $sql2 = "UPDATE product SET category = ? WHERE subcategory = ?";
        $stmt2 = mysqli_prepare($con, $sql2);
        mysqli_stmt_bind_param($stmt2, 'ii', $cid, $sub_id);
        try {
            mysqli_stmt_execute($stmt2);
        } catch (Exception $e) {
            send_error_response("{$e->getMessage()}");
        } finally {
            mysqli_stmt_close($stmt2);
        }
        send_success_response("Alt kategori başarıyla güncellendi.");
    } catch (Exception $e) {
        send_error_response("{$e->getMessage()}");
    } finally {
        mysqli_stmt_close($stmt);
    }
} else {
    send_error_response("Alt kategori id'si boş olamaz.");
}
