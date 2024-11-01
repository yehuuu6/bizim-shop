<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

// Get post data

$id = get_safe_value($con, $_POST['id']);

// Send category list to client
if ($id != '') {
    $sql = "DELETE FROM subcats WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    try {
        mysqli_stmt_execute($stmt);
        $sql2 = "UPDATE product SET subcategory = 0 WHERE subcategory = ?";
        $stmt2 = mysqli_prepare($con, $sql2);
        mysqli_stmt_bind_param($stmt2, 'i', $id);
        try {
            mysqli_stmt_execute($stmt2);
            send_success_response("Alt kategori başarıyla silindi.");
        } catch (Exception $e) {
            send_error_response("{$e->getMessage()}");
        } finally {
            mysqli_stmt_close($stmt2);
        }
    } catch (Exception $e) {
        send_error_response("{$e->getMessage()}");
    } finally {
        mysqli_stmt_close($stmt);
    }
} else {
    send_error_response("Alt kategori seçilmedi.");
}
