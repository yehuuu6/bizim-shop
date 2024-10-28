<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$result = array();

$id = get_safe_value($con, $_POST['id']);

$query = "SELECT * FROM promotions WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $id);

// Execute the statement
if ($stmt->execute()) {
    $stmt->bind_result($id, $title, $description, $image, $vector, $main_link, $sub_link);
    $stmt->fetch();
    $stmt->close();

    $result['id'] = $id;
    $result['title'] = $title;
    $result['description'] = $description;
    $result['image'] = $image;
    $result['vector'] = $vector;
    $result['mainTarget'] = $main_link;
    $result['secondTarget'] = $sub_link;

    echo json_encode($result);
} else {
    die("Bir hata oluştu.");
}
