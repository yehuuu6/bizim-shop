<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    Authorize();

    $image = get_safe_value($con, $_POST['image']);
    // Dosyayi bilgisayardan siliyor ancak veritabanindan silmiyor.
    for ($imageNumber = 1; $imageNumber <= 6; $imageNumber++) {
        $sql = "UPDATE product SET image{$imageNumber} = 'noimg.jpg' WHERE image{$imageNumber} = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $image);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            unlink(PRODUCT_IMAGE_SERVER_PATH . $image);
            sendSuccessResponse(`{$imageNumber}. resim başarıyla silindi.`);
        } else {
            sendErrorResponse("{$imageNumber}. resim silinemedi.", `image-label-{$imageNumber}`);
        }

        mysqli_stmt_close($stmt);
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
