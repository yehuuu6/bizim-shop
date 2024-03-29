<?php
define('FILE_ACCESS', TRUE);


require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$uid = $_SESSION['id'];

$max_width = 800;
$max_height = 800;
$images = array();
$ready_to_upload = array();

$name = get_safe_value($con, $_POST['product-name']);
$price = get_safe_value($con, $_POST['product-price']);
$shipping_cost = get_safe_value($con, $_POST['shipping-cost']);
$sub_category = get_safe_value($con, $_POST['product-sub-category']);
$tags = get_safe_value($con, $_POST['product-tags']);
$description = get_safe_value($con, $_POST['product-description']);
$shipment = get_safe_value($con, $_POST['shipment']);
$featured = get_safe_value($con, $_POST['featured']);
$quality = get_safe_value($con, $_POST['quality']);
$image_count = get_safe_value($con, $_POST['image-count']);

// If edit mode is true, get the product id
$is_editing = get_safe_value($con, $_POST['edit-mode']);
$is_editing === 'true' ? $is_editing = true : $is_editing = false; // Convert string to boolean
$is_editing ? $id = get_safe_value($con, $_POST['product-id']) : $id = null;

$root_name = convert_name($name);

$sql = "SELECT name FROM product WHERE name = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $name);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if ($is_editing) {
    $sql = "SELECT image1, image2, image3, image4, image5, image6 FROM product WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $filter_images = array();

    $image1 = $row['image1'];
    $image2 = $row['image2'];
    $image3 = $row['image3'];
    $image4 = $row['image4'];
    $image5 = $row['image5'];
    $image6 = $row['image6'];

    $filter_images = array($image1, $image2, $image3, $image4, $image5, $image6);

    // If image is not null, add it to the array
    foreach ($filter_images as $image) {
        if ($image !== "noimg.jpg") {
            array_push($images, $image);
        }
    }
}

$validations = [
    ['Ürün adı', $name, 6, 250, 'product-name'],
    ['Ürün etiketleri', $tags, 5, 50, 'product-tags'],
    ['Ürün açıklaması', $description, 50, 2000, 'product-description']
];

if ($sub_category <= 0) {
    send_error_response('Lütfen geçerli bir alt kategori seçiniz.', 'product-sub-category');
}

foreach ($validations as list($field, $value, $min_length, $max_length, $field_name)) {
    if (empty($value)) {
        send_error_response("$field boş bırakılamaz.", $field_name);
    } elseif (strlen($value) < $min_length) {
        send_error_response("$field çok kısa. Minimum uzunluk $min_length karakterdir.", $field_name);
    } elseif (strlen($value) > $max_length) {
        send_error_response("$field çok uzun. Maksimum uzunluk $max_length karakterdir.", $field_name);
    }
}

if (mysqli_stmt_num_rows($stmt) > 0 && !$is_editing) {
    send_error_response('Ürün zaten var.', 'product-name');
} elseif ($price <= 0) {
    send_error_response('Lütfen geçerli bir fiyat giriniz.', 'product-price');
} elseif ($shipping_cost <= 0) {
    send_error_response('Lütfen geçerli bir kargo ücreti giriniz.', 'shipping-cost');
} elseif ($sub_category <= 0) {
    send_error_response('Lütfen geçerli bir alt kategori seçiniz.', 'product-sub-category');
} else {
    for ($i = 1; $i < $image_count; $i++) {
        @$image = $_FILES["product-image-$i"]['name'];
        if ($image === null) continue;
        $image_tmp = $_FILES["product-image-$i"]['tmp_name'];
        $image_size = $_FILES["product-image-$i"]['size'];
        $image_error = $_FILES["product-image-$i"]['error'];

        $image_ext = explode('.', $image);
        $image_ext = strtolower(end($image_ext));

        $allowed = array('jpg', 'jpeg', 'png');

        if (empty($image)) {
            send_error_response("$i. Resim boş bırakılamaz.", "image-label-$i");
        } else if (in_array($image_ext, $allowed)) {
            if ($image_error === 0) {
                if ($image_size <= 18874368) {
                    $random = rand(11111, 99999);
                    $converted_name = convert_name($name);
                    $image_name = "{$random}_{$converted_name}.{$image_ext}";
                    $image_destination = PRODUCT_IMAGE_SERVER_PATH . $root_name . '/' . $image_name;
                    if (!array_key_exists($image_tmp, $ready_to_upload)) {
                        $ready_to_upload[$image_tmp] = $image_destination;
                    }
                    array_push($images, $image_name);
                } else {
                    send_error_response("Resim boyutu çok büyük. Maksimum boyut 18MB\'dır.", "image-label-$i");
                }
            } else {
                send_error_response("Resim yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.", "image-label-$i");
            }
        } else {
            send_error_response("$i. Resim formatı desteklenmiyor. Desteklenen formatlar: jpg, jpeg, png.", "image-label-$i");
        }
    }

    if ($is_editing) {
        $conclusion = update_product($con, $id, $sub_category, $name, $description, $tags, $price, $shipping_cost, $shipment, $featured, $quality, $images);
        if ($conclusion) {
            $log = "Değişiklikler başarıyla kaydedildi.";
        } else {
            $log = 'Değişiklikler kaydedilirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.';
        }
    } else {
        $conclusion = insert_product($con, $uid, $sub_category, $name, $description, $tags, $price, $shipping_cost, $shipment, $featured, $quality, $images);
        if ($conclusion) {
            $log = 'Ürün başarıyla eklendi.';
        } else {
            $log = 'Ürün eklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.';
        }
    }
    send_success_response($log);
}

function upload_images($ready_to_upload, $max_width, $max_height)
{
    foreach ($ready_to_upload as $image_tmp => $image_destination) {
        if (compress_save_image($image_tmp, $image_destination, $max_height, $max_width) === false) {
            send_error_response('Resim yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.', 'image-label-1');
        }
    }
}

function insert_product($con, $uid, $sub_category, $name, $description, $tags, $price, $shipping_cost, $shipment, $featured, $quality, $images)
{
    global $root_name;
    global $ready_to_upload;
    global $max_height;
    global $max_width;

    // Get category id
    $sql = "SELECT cid FROM subcats WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $sub_category);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $category);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!file_exists(PRODUCT_IMAGE_SERVER_PATH . $root_name . '')) {
        mkdir(PRODUCT_IMAGE_SERVER_PATH . $root_name . '');
    }

    // Replace the null images with noimg.jpg
    $images = array_pad($images, 6, 'noimg.jpg');

    upload_images($ready_to_upload, $max_width, $max_height);

    $guid = generate_guid();

    $sql = "INSERT INTO product (guid, uid, category, subcategory, name, root_name, description, tags, price, shipping_cost, status, shipment, featured, quality, image1, image2, image3, image4, image5, image6)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "siiissssddiiissssss",
        $guid,
        $uid,
        $category,
        $sub_category,
        $name,
        $root_name,
        $description,
        $tags,
        $price,
        $shipping_cost,
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

    try {
        return mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        send_error_response("{$e->getMessage()}");
    } finally {
        mysqli_stmt_close($stmt);
    }
}

function update_product($con, $id, $sub_category, $name, $description, $tags, $price, $shipping_cost, $shipment, $featured, $quality, $images)
{
    global $root_name;
    global $ready_to_upload;
    global $max_height;
    global $max_width;

    // Get category id
    $sql = "SELECT cid FROM subcats WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $sub_category);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $category);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Replace the null images with noimg.jpg
    $images = array_pad($images, 6, 'noimg.jpg');

    // Get old root name
    $sql = "SELECT root_name FROM product WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $old_root_name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Check if the folder exists
    if (!file_exists(PRODUCT_IMAGE_SERVER_PATH . $old_root_name . '')) {
        mkdir(PRODUCT_IMAGE_SERVER_PATH . $old_root_name . '');
    }

    // If root name is changed, rename the folder
    if ($old_root_name !== $root_name) {
        rename(PRODUCT_IMAGE_SERVER_PATH . $old_root_name, PRODUCT_IMAGE_SERVER_PATH . $root_name);
    }

    upload_images($ready_to_upload, $max_width, $max_height);

    $sql = "UPDATE product SET category = ?, subcategory = ?, name = ?, root_name = ?, description = ?, tags = ?, price = ?, shipping_cost = ?, shipment = ?, featured = ?,
    quality = ?, image1 = ?, image2 = ?, image3 = ?, image4 = ?, image5 = ?, image6 = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "iissssddiiissssssi",
        $category,
        $sub_category,
        $name,
        $root_name,
        $description,
        $tags,
        $price,
        $shipping_cost,
        $shipment,
        $featured,
        $quality,
        $images[0],
        $images[1],
        $images[2],
        $images[3],
        $images[4],
        $images[5],
        $id
    );

    try {
        return mysqli_stmt_execute($stmt);
    } catch (Exception $e) {
        send_error_response("{$e->getMessage()}");
    }
}
