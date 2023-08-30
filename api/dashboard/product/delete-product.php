<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    Authorize();

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

    $goingto_delete = array($image1, $image2, $image3, $image4, $image5, $image6);

    function deleteFiles($files, $root_name)
    {
        // Delete each image
        foreach ($files as $_file) {
            try {
                if ($_file != 'noimg.jpg') {
                    $_file = "{$root_name}_{$_file}";
                    unlink(PRODUCT_IMAGE_SERVER_PATH . $_file);
                }
            } catch (Exception $e) {
                sendErrorResponse('Bir hata oluştu, lütfen daha sonra tekrar deneyin.');
            }
        }
        try {
            rmdir(PRODUCT_IMAGE_SERVER_PATH . $root_name);
        } catch (Exception $e) {
            // Do nothing
        }
    }

    if ($_SESSION['id'] == $uid) {
        $sql = "DELETE FROM product WHERE id = '$product_id'";
        $res = mysqli_query($con, $sql);
        if ($res) {
            deleteFiles($goingto_delete, $root_name);
            sendSuccessResponse("$name isimli ürün başarıyla silindi.");
        } else {
            sendErrorResponse('Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
        }
    } else {
        sendErrorResponse('Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
