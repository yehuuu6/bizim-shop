<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $result = array();

    // Get post data

    $category_id = get_safe_value($con, $_POST['cid']);

    // Send category list to client
    if ($category_id != '') {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $category_id);
        try {
            mysqli_stmt_execute($stmt);
            $sql2 = "DELETE FROM subcats WHERE cid = ?";
            $stmt2 = mysqli_prepare($con, $sql2);
            mysqli_stmt_bind_param($stmt2, 'i', $category_id);
            try {
                mysqli_stmt_execute($stmt2);
                $sql3 = "UPDATE product SET category = 0, subcategory = 0 WHERE category = ?";
                $stmt3 = mysqli_prepare($con, $sql3);
                mysqli_stmt_bind_param($stmt3, 'i', $category_id);
                try {
                    mysqli_stmt_execute($stmt3);
                    send_success_response("Kategori ve alt kategorileri başarıyla silindi.");
                } catch (Exception $e) {
                    send_error_response("{$e->getMessage()}");
                } finally {
                    mysqli_stmt_close($stmt3);
                }
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
        send_error_response("Kategori seçilmedi.");
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
