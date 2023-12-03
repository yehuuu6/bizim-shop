<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $result = array();

    // Get post data

    $category_name = get_safe_value($con, $_POST['name']);
    $slug = convert_link_name($category_name);

    $check = mysqli_query($con, "SELECT * FROM categories WHERE name = '$category_name'");
    $count = mysqli_num_rows($check);

    if ($count > 0) {
        send_error_response("Bu kategori zaten mevcut.", 'new-category-name');
    }

    // Send category list to client
    if ($category_name != '') {
        $sql = "INSERT INTO categories (name, slug) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $category_name, $slug);
        try {
            mysqli_stmt_execute($stmt);
            send_success_response("Yeni kategori başarıyla eklendi.");
        } catch (Exception $e) {
            send_error_response("{$e->getMessage()}");
        } finally {
            mysqli_stmt_close($stmt);
        }
    } else {
        send_error_response("Kategori adı boş olamaz.", 'new-category-name');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
