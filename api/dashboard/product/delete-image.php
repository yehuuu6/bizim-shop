<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    Authorize();

    $image = get_safe_value($con, $_POST['image']);
    $imageNumber = get_safe_value($con, $_POST['image-number']);
    $id = get_safe_value($con, $_POST['product-id']);

    $sql = "SELECT root_name, image1, image2, image3, image4, image5, image6 FROM product WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $images = array($row['image1'], $row['image2'], $row['image3'], $row['image4'], $row['image5'], $row['image6']);

    $image = PRODUCT_IMAGE_SERVER_PATH . $row['root_name'] . '/' . $image;

    if (file_exists($image)) {
        unlink($image);
    }

    // Reorder the images (if image is different than noimg.jpg, then shift the images to the left and replace other images with noimg.jpg)
    for ($i = $imageNumber - 1; $i < count($images) - 1; $i++) {
        if ($images[$i + 1] !== 'noimg.jpg') {
            $images[$i] = $images[$i + 1];
        } else {
            $images[$i] = 'noimg.jpg';
        }
    }

    // Set the last image to noimg.jpg
    $images[count($images) - 1] = 'noimg.jpg';

    $sqlUpdate = "UPDATE product SET image1 = ?, image2 = ?, image3 = ?, image4 = ?, image5 = ?, image6 = ? WHERE id = ?";
    $stmtUpdate = mysqli_prepare($con, $sqlUpdate);
    mysqli_stmt_bind_param($stmtUpdate, "ssssssi", $images[0], $images[1], $images[2], $images[3], $images[4], $images[5], $id);
    mysqli_stmt_execute($stmtUpdate);

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmtUpdate);
    mysqli_close($con);


    sendSuccessResponse("$imageNumber. resim başarıyla silindi.");
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
