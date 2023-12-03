<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $result = array();

    // Get post data

    $id = get_safe_value($con, $_POST['id']);
    $name = get_safe_value($con, $_POST['name']);
    $slug = convert_link_name($name);

    $check = mysqli_query($con, "SELECT * FROM categories WHERE name = '$name'");
    $count = mysqli_num_rows($check);

    if ($count > 0) {
        send_error_response("Bu kategori zaten mevcut.", 'update-category-name');
    }

    if ($name == '') {
        send_error_response("Yeni kategori adı boş olamaz.", 'update-category-name');
    }
    // Send category list to client
    if ($id != '') {
        $sql = "UPDATE categories SET name = ?, slug = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'ssi', $name, $slug, $id);
        try {
            mysqli_stmt_execute($stmt);
            send_success_response("Kategori başarıyla güncellendi.");
        } catch (Exception $e) {
            send_error_response("{$e->getMessage()}");
        } finally {
            mysqli_stmt_close($stmt);
        }
    } else {
        send_error_response("Kategori id'si boş olamaz.", 'update-category-name');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
