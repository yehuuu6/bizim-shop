<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

// Get post data

$category_name = get_safe_value($con, $_POST['name']);

if (empty($category_name)) {
    send_error_response("Kategori adı boş olamaz.", 'new-category-name');
}
$sql = "SELECT COUNT(*) FROM categories WHERE name = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $category_name);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $count);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($count > 0) {
    send_error_response("Bu kategori zaten mevcut.", 'new-category-name');
} else if (strlen($category_name) > 50) {
    send_error_response("Kategori adı 50 karakterden uzun olamaz.", 'new-category-name');
} else if (strlen($category_name) < 3) {
    send_error_response("Kategori adı 3 karakterden kısa olamaz.", 'new-category-name');
}

$slug = convert_link_name($category_name);

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
