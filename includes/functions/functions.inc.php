<?php

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

/**
 * Sanitizes the given string and returns it.
 */
function get_safe_value(mysqli $con, ?string $str)
{
    if ($str != '') {
        $str = trim($str);
        return mysqli_real_escape_string($con, $str);
    }
}

function get_date(string $raw)
{
    [$year, $month_t, $day] = explode('-', $raw);
    $month_names = [
        'Jan', 'Feb', 'March', 'April', 'May', 'June',
        'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];
    $month = $month_names[(int)$month_t - 1];
    $day_trimmed = ltrim((string)(int)$day, '0');
    return "$month $day_trimmed, $year";
}

/**
 * Checks if the user has the required permission level to access the page.
 */
function authorize_user()
{
    if ($_SESSION['membership'] < 1) {
        die();
    }
}

/**
 * Compresses the given image and saves it to the target path returns true if the image saving is successful, or false otherwise.
 */
function compress_save_image(string $source_path, string $target_path, int $max_width, int $max_height)
{
    $source_image = imagecreatefromstring(file_get_contents($source_path));
    $source_width = imagesx($source_image);
    $source_height = imagesy($source_image);

    // Calculate the new dimensions while maintaining the aspect ratio
    if ($source_width > $max_width || $source_height > $max_height) {
        $ratio = min($max_width / $source_width, $max_height / $source_height);
        $new_width = round($source_width * $ratio);
        $new_height = round($source_height * $ratio);
    } else {
        $new_width = $source_width;
        $new_height = $source_height;
    }

    // Create a new image with the desired dimensions
    $target_image = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($target_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $source_width, $source_height);

    // Clean up memory
    imagedestroy($source_image);
    imagedestroy($target_image);

    // Return true if the image saving is successful, or false otherwise
    return imagepng($target_image, $target_path);
}


/**
 * Returns a random string of the given length. (Default length is 10)
 */
function get_random_string(int $length = 10)
{
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    // Shufle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result), 0, $length);
}

/**
 * Returns the permission level of the user.
 */
function get_permission(int $perm)
{
    $result = '';
    switch ($perm) {
        case 0:
            $result = 'Üye';
            break;
        case 1:
            $result = 'Yönetici';
            break;
    }
    return $result;
}

/**
 * Converts name to a valid file name.
 */
function convert_name(?string $str)
{
    $search = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' ', '-');
    $replace = array('c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u', '_', '_');
    $str = str_replace($search, $replace, $str);
    return strtolower($str);
}

/**
 * Sends an error response to the client and terminates the script.
 */
function send_error_response(string $log, string $cause = 'none')
{
    $result = array('error', $log, $cause);
    echo json_encode($result);
    die();
}

/**
 * Sends a success response to the client and terminates the script.
 */
function send_success_response(string $log)
{
    $result = array('success', $log, 'none');
    echo json_encode($result);
    die();
}

/**
 * Resets the submission counts of the user if the last submission was more than 5 minutes ago.
 */
function reset_submission_counts(mysqli $con, int $submissions, int $last_sub, int $id)
{
    if (time() - $last_sub > 300) {
        $submissions  = 0;
        $sql = "UPDATE users SET submissions = 0, last_submission = " . time() . " WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    return $submissions;
}

/**
 * Converts sql escaped strings to normal strings.
 */
function fix_strings(array $row)
{
    $row['name'] = str_replace("\\'", "'", $row['name']);
    $row['tags'] = str_replace("\\'", "'", $row['tags']);
    $row['description'] = str_replace("\\'", "'", $row['description']);
    return $row;
}


/**
 * Gets products from the database based on the given parameters.
 * @param mysqli $con The mysqli connection object.
 * @param array $props The properties to filter the products.
 * @param string $props['id'] The id of the product if you need to get a specific product.
 * @param string $props['search'] The search query.
 * @param string $props['category'] The category of the product.
 * @param string $props['tag'] The tag of the product.
 * @param string $props['status'] The status of the product.
 * @param string $props['order_type'] The order type of the products. Example id DESC.
 * @param string $props['limit'] The limit of the products.
 * @param string $props['offset'] The offset of the products.
 * @param string $props['featured'] The featured status of the products.
 * @param string $props['shipping'] The shipping status of the products.
 * @param string $props['min_price'] The minimum price of the products.
 * @param string $props['max_price'] The maximum price of the products.
 * 
 * @return array
 */

function get_products(
    mysqli $con,
    $props = [],
) {
    $id = $props['id'] ?? '';
    $search = $props['search'] ?? '';
    $category = $props['category'] ?? '';
    $tag = $props['tag'] ?? '';
    $status = $props['status'] ?? '1';
    $order_type = $props['order_type'] ?? 'DESC';
    $limit = $props['limit'] ?? PHP_INT_MAX;
    $offset = $props['offset'] ?? 0;
    $featured = $props['featured'] ?? '';
    $shipment = $props['shipping'] ?? '';
    $min_price = $props['min_price'] ?? '0';
    $max_price = $props['max_price'] ?? PHP_INT_MAX;

    $sql = "SELECT * FROM product WHERE ";
    $sql .= "name LIKE '%$search%' AND ";
    $sql .= "category LIKE '%$category%' AND ";
    $sql .= "tags LIKE '%$tag%' AND ";
    $sql .= "status LIKE '%$status%' AND ";
    $sql .= "featured LIKE '%$featured%' AND ";
    $sql .= "price BETWEEN $min_price AND $max_price AND ";
    $sql .= "shipment LIKE '%$shipment%' ";
    $sql .= "ORDER BY $order_type ";
    $sql .= "LIMIT $limit OFFSET $offset";
    $id !== '' ? $sql = "SELECT * FROM product WHERE status LIKE '%$status%' AND id = $id" : $sql = $sql;
    $result = mysqli_query($con, $sql);
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $row = fix_strings($row);
        array_push($products, $row);
    }
    return $products;
}
