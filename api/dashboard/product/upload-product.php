<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    Authorize();

    $uid = $_SESSION['id'];

    $max_width = 800;
    $max_height = 800;
    $images = array();
    $readyToUpload = array();

    $name = get_safe_value($con, $_POST['product-name']);
    $price = get_safe_value($con, $_POST['product-price']);
    $category = get_safe_value($con, $_POST['product-category']);
    $tags = get_safe_value($con, $_POST['product-tags']);
    $description = get_safe_value($con, $_POST['product-description']);
    $shipment = get_safe_value($con, $_POST['shipment']);
    $featured = get_safe_value($con, $_POST['featured']);
    $quality = get_safe_value($con, $_POST['quality']);
    $imageCount = get_safe_value($con, $_POST['image-count']);
    $isEditing = get_safe_value($con, $_POST['edit-mode']);
    @$id = get_safe_value($con, $_POST['product-id']);

    $root_name = convertName($name);

    $sql = "SELECT name FROM product WHERE name = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0 && !$isEditing) {
        sendErrorResponse('Ürün zaten var.', 'name');
    } elseif (strlen($name) > 18) {
        sendErrorResponse('Ürün adı çok uzun. Maksimum uzunluk 18 karakterdir.', 'product-name');
    } elseif (strlen($name) < 6) {
        sendErrorResponse('Ürün adı çok kısa. Minimum uzunluk 6 karakterdir.', 'product-name');
    } elseif ($price <= 0) {
        sendErrorResponse('Lütfen geçerli bir fiyat giriniz.', 'product-price');
    } elseif (strlen($tags) < 5) {
        sendErrorResponse('Ürün etiketi çok kısa. Minimum uzunluk 5 karakterdir.', 'product-tags');
    } elseif (strlen($tags) > 50) {
        sendErrorResponse('Ürün etiketi çok uzun. Maksimum uzunluk 50 karakterdir.', 'product-tags');
    } elseif (strlen($description) < 50) {
        sendErrorResponse('Ürün açıklaması çok kısa. Minimum uzunluk 50 karakterdir.', 'product-description');
    } elseif (strlen($description) > 500) {
        sendErrorResponse('Ürün açıklaması çok uzun. Maksimum uzunluk 500 karakterdir.', 'product-description');
    } else {
        for ($i = 1; $i < $imageCount; $i++) {
            $image = $_FILES['product-image-' . $i . '']['name'];
            $image_tmp = $_FILES['product-image-' . $i . '']['tmp_name'];
            $image_size = $_FILES['product-image-' . $i . '']['size'];
            $image_error = $_FILES['product-image-' . $i . '']['error'];

            $image_ext = explode('.', $image);
            $image_ext = strtolower(end($image_ext));

            $allowed = array('jpg', 'jpeg', 'png');

            if (empty($image) && $isEditing === 'false') {
                sendErrorResponse($i . '. Resim boş bırakılamaz.', 'image-label-' . $i . '');
            } else if (in_array($image_ext, $allowed) && $isEditing === 'false') {
                if ($image_error === 0) {
                    if ($image_size <= 18874368) {
                        $image_name = rand(11111, 99999) . '_' . convertName($image);
                        $image_destination = PRODUCT_IMAGE_SERVER_PATH . $root_name . '/' . $image_name;
                        if (!array_key_exists($image_tmp, $readyToUpload)) {
                            $readyToUpload[$image_tmp] = $image_destination;
                        }
                        array_push($images, $image_name);
                    } else {
                        sendErrorResponse("Resim boyutu çok büyük. Maksimum boyut 18MB\'dır.", "image-label-$i");
                    }
                } else {
                    sendErrorResponse("Resim yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.", "image-label-$i");
                }
            } else {
                sendErrorResponse("$i. Resim formatı desteklenmiyor. Desteklenen formatlar: jpg, jpeg, png.", "image-label-$i");
            }
        }

        if ($isEditing === 'true') {
            $conclusion = updateProduct($con, $id, $category, $name, $description, $tags, $price, $shipment, $featured, $quality);
            if ($conclusion) {
                $log = 'Değişiklikler başarıyla kaydedildi.';
            } else {
                $log = 'Değişiklikler kaydedilirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.';
            }
        } else {
            $conclusion = insertProduct($con, $uid, $category, $name, $description, $tags, $price, $shipment, $featured, $quality, $images);
            if ($conclusion) {
                $log = 'Ürün başarıyla eklendi.';
            } else {
                $log = 'Ürün eklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.';
            }
        }
        sendSuccessResponse($log);
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

function insertProduct($con, $uid, $category, $name, $description, $tags, $price, $shipment, $featured, $quality, $images)
{
    global $root_name;
    global $readyToUpload;
    global $max_height;
    global $max_width;

    $images = array_pad($images, 6, "noimg.jpg");
    for ($i = 0; $i < count($images); $i++) {
        if ($images[$i] !== "noimg.jpg") {
            $images[$i] = $root_name . '/' . $images[$i];
        }
    }

    if (!file_exists(PRODUCT_IMAGE_SERVER_PATH . $root_name . '')) {
        mkdir(PRODUCT_IMAGE_SERVER_PATH . $root_name . '');
    }

    foreach ($readyToUpload as $image_tmp => $image_destination) {
        if (compressAndSaveImage($image_tmp, $image_destination, $max_height, $max_width) === false) {
            sendErrorResponse('Resim yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.', 'image');
        }
    }

    $sql = "INSERT INTO product (uid, category, name, root_name, description, tags, price, status, shipment, featured, quality, image1, image2, image3, image4, image5, image6)
    VALUES (?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "iissssdiiissssss",
        $uid,
        $category,
        $name,
        $root_name,
        $description,
        $tags,
        $price,
        $shipment,
        $featured,
        $quality,
        $images[0],
        $images[1],
        $images[2],
        $images[3],
        $images[4],
        $images[5]
    );


    return mysqli_stmt_execute($stmt);
}

function updateProduct($con, $id, $category, $name, $description, $tags, $price, $shipment, $featured, $quality)
{
    $sql = "UPDATE product SET category = ?, name = ?, description = ?, tags = ?, price = ?, shipment = ?, featured = ?, quality = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "isssdiiii",
        $category,
        $name,
        $description,
        $tags,
        $price,
        $shipment,
        $featured,
        $quality,
        $id,
    );

    return mysqli_stmt_execute($stmt);
}
