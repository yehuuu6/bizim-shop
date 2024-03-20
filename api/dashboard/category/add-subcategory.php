<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

// Get post data

$cat_id = get_safe_value($con, $_POST['cid']);
$sub_name = get_safe_value($con, $_POST['name']);
$slug = convert_link_name($sub_name);

// Send category list to client
if ($sub_name != '' && $cat_id != '') {
    $sql = "INSERT INTO subcats (cid, name, slug) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'iss', $cat_id, $sub_name, $slug);
    try {
        mysqli_stmt_execute($stmt);
        send_success_response("Yeni alt kategori başarıyla eklendi.");
    } catch (Exception $e) {
        send_error_response("{$e->getMessage()}");
    } finally {
        mysqli_stmt_close($stmt);
    }
} else {
    send_error_response("Alt kategori adı boş olamaz ve kategori id'si boş olamaz.", "new-subcategory-name");
}
