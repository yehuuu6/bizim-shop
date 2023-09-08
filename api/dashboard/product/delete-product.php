<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    authorize_user();

    $product_id = get_safe_value($con, $_POST['id']);

    $sql = "SELECT uid,name,root_name,image1,image2,image3,image4,image5,image6 FROM product WHERE id = '$product_id'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    $uid = $row['uid'];
    $name = $row['name'];
    $image1 = $row['image1'];
    $image2 = $row['image2'];
    $image3 = $row['image3'];
    $image4 = $row['image4'];
    $image5 = $row['image5'];
    $image6 = $row['image6'];
    $root_name = $row['root_name'];

    $going_to_delete = array($image1, $image2, $image3, $image4, $image5, $image6);

    function delete_files($files, $root_name)
    {
        // Delete each image
        foreach ($files as $_file) {
            try {
                if ($_file != 'noimg.jpg') {
                    $_file = "{$root_name}/{$_file}";
                    unlink(PRODUCT_IMAGE_SERVER_PATH . $_file);
                }
            } catch (Exception $e) {
                send_error_response("Bir hata oluştu, lütfen daha sonra tekrar deneyin: {$e->getMessage()}");
            }
        }
        try {
            @rmdir(PRODUCT_IMAGE_SERVER_PATH . $root_name);
        } catch (Exception $e) {
            send_error_response("Bir hata oluştu, lütfen daha sonra tekrar deneyin: {$e->getMessage()}");
        }
    }

    if ($_SESSION['id'] == $uid) {
        $sql = "DELETE FROM product WHERE id = '$product_id'";
        $res = mysqli_query($con, $sql);
        if ($res) {
            delete_files($going_to_delete, $root_name);
            send_success_response("$name isimli ürün başarıyla silindi.");
        } else {
            $error_message = mysqli_error($con);
            send_error_response("Bir hata oluştu, lütfen daha sonra tekrar deneyin: {$error_message}");
        }
    } else {
        send_error_response("Bu ürünü silme yetkiniz bulunmamaktadır.");
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
