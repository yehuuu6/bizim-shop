<?php

if (!defined('FILE_ACCESS')) {
    send_forbidden_response();
}

require_once "{$_SERVER['DOCUMENT_ROOT']}/vendor/autoload.php";

use Ramsey\Uuid\Uuid;

/**
 * Sanitizes the given string and returns it.
 */
function get_safe_value(mysqli $con, ?string $str)
{
    if ($str != '') {
        $str = stripslashes($str);
        return mysqli_real_escape_string($con, $str);
    }
}

/**
 * Create a function that converts /r/n to <br> tags for example.
 * It must make the string fully readable in the textarea just like the user typed it.
 * At the moment, we use ', " and line breaks on textarea but when we pull the data back,
 * we see /'s and /"s and /r/n's. We need to convert them back to ', " and line breaks.
 */
function fix_strings(array $row)
{
    foreach ($row as $key => $value) {
        $value = str_replace("\\r\\n", "\n", $value);
        $value = stripslashes($value);
        $row[$key] = $value;
    }
    return $row;
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
    if ($_SESSION['membership'] != 1) {
        send_forbidden_response();
    }
}

/**
 * Sends a forbidden response to the client and terminates the script.
 */
function send_forbidden_response()
{
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}

function validate_request()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
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
    // if str is null, return empty string
    if ($str == null) {
        return '';
    }
    $search = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' ', '-');
    $replace = array('c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u', '_', '_');
    $str = str_replace($search, $replace, $str);
    return strtolower($str);
}

function convert_link_name(string $str)
{
    $search = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' ', '_');
    $replace = array('c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u', '-', '-');
    $str = str_replace($search, $replace, $str);
    $url_encoded_str = urlencode(urlencode($str));
    return strtolower($url_encoded_str);
}

function generate_guid()
{
    return Uuid::uuid4()->toString();
}

function get_categories()
{
    global $con;
    $sql = "SELECT id, name, slug FROM categories";
    $res = mysqli_query($con, $sql);
    $category_count = mysqli_num_rows($res);

    // Send category list to client
    if ($category_count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            // Skip Uncategorized category
            if ($row['id'] == 0) {
                continue;
            }
            $result[] = $row;
        }
        return $result;
    } else {
        return [];
    }
}

function get_sub_categories($category_slug)
{
    global $con;

    $sql = "SELECT id, name FROM categories WHERE slug = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $category_slug);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($res) > 0) {
        $category_data = mysqli_fetch_assoc($res);
        $category_id = $category_data['id'];
    } else {
        return [];
    }

    $sql = "SELECT id, name, slug FROM subcats WHERE cid = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $category_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $sub_category_count = mysqli_num_rows($res);

    if ($sub_category_count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            // Skip Uncategorized category
            if ($row['id'] == 0) {
                continue;
            }
            $result[] = $row;
        }
        return $result;
    } else {
        return [];
    }
}

function get_all_sub_categories()
{
    global $con;
    $sql = "SELECT * FROM subcats";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $sub_category_count = mysqli_num_rows($res);

    if ($sub_category_count > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            // Skip Uncategorized category
            if ($row['id'] == 0) {
                continue;
            }
            // Convert row to string
            $row['id'] = (string)$row['id'];
            $row['cid'] = (string)$row['cid'];
            $result[] = $row;
        }
        return $result;
    } else {
        return [];
    }
}

/**
 * Places order to the database (Testing purpose)
 * @param mysqli $con The mysqli connection object.
 * @param string $uid The id of the user.
 * @param string $pid The id of the product.
 * @status 0 = Beklemede, 1 = Hazırlanıyor, 2 = Kargoya Verildi, 3 = Teslim Edildi, 4 = İptal Edildi, 5 = İade Edildi, 6 = Tamamlandı, 7 = Tamamlanmadı
 * @return bool
 */
function place_order(mysqli $con, string $uid, string $pid)
{
    $status = 0;
    $guid = generate_guid();
    $sql = "INSERT INTO orders (orderid, uid, pid, status) VALUES (?, ?, ?, ?)";
    try {
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $guid, $uid, $pid, $status);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function readable_num(string $num)
{
    return number_format($num, 2, ',', '.');
}

function get_category_name(?string $category_id)
{
    global $con;
    $sql = "SELECT name FROM categories WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $category_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $category_data = mysqli_fetch_row($res);
    return $category_data[0];
}

function get_category_slug(?string $category_id)
{
    global $con;
    $sql = "SELECT slug FROM categories WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $category_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $category_data = mysqli_fetch_row($res);
    return $category_data[0];
}

function get_sub_category_name(?string $sub_category_id)
{
    global $con;
    $sql = "SELECT name FROM subcats WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $sub_category_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $sub_category_data = mysqli_fetch_row($res);
    return $sub_category_data[0];
}

function get_sub_category_slug(?string $sub_category_id)
{
    global $con;
    $sql = "SELECT slug FROM subcats WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $sub_category_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $sub_category_data = mysqli_fetch_row($res);
    return $sub_category_data[0];
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
        $submissions = 0;
        $sql = "UPDATE users SET submissions = 0, last_submission = " . time() . " WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    return $submissions;
}

/**
 * Gets products from the database based on the given parameters.
 * @param mysqli $con The mysqli connection object.
 * @param array $props The properties to filter the products.
 * @param string $props['id'] The id of the product if you need to get a specific product.
 * @param string $props['slug'] The slug of the product if you need to get a specific product.
 * @param string $props['search'] The search query.
 * @param string $props['sub_category'] The category of the product.
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

// Looks like this code is vulnerable to SQL injection. You should use prepared statements instead.
function get_products(mysqli $con, $props = [])
{
    $id = $props['id'] ?? '';
    $search = $props['search'] ?? '';
    $slug = $props['slug'] ?? '';
    $category = $props['category'] ?? '';
    $sub_category = $props['sub_category'] ?? '';
    $status = $props['status'] ?? '1';
    $order_type = $props['order_type'] ?? 'id DESC';
    $limit = $props['limit'] ?? PHP_INT_MAX;
    $offset = $props['offset'] ?? 0;
    $featured = $props['featured'] ?? '';
    $shipment = $props['shipping'] ?? '';
    $min_price = $props['min_price'] ?? '0';
    $max_price = $props['max_price'] ?? PHP_INT_MAX;

    $sql = "SELECT * ";
    $sql .= "FROM product WHERE (name LIKE '%$search%' OR root_name LIKE '%$search%' OR description LIKE '%$search%' OR tags LIKE '%$search%') ";

    if ($category !== '') {
        $sql .= "AND category = '$category' ";
    }
    if ($sub_category !== '') {
        $sql .= "AND subcategory = '$sub_category' ";
    }
    if ($status !== '') {
        $sql .= "AND status = '$status' ";
    }
    if ($featured !== '') {
        $sql .= "AND featured = '$featured' ";
    }
    if ($shipment !== '') {
        $sql .= "AND shipment = '$shipment' ";
    }

    $sql .= "AND price BETWEEN $min_price AND $max_price ";

    if ($id !== '') {
        $sql .= "AND id = $id ";
    } elseif ($slug !== '') {
        $sql .= "AND root_name = '$slug' ";
    }

    $sql .= "ORDER BY $order_type LIMIT $limit OFFSET $offset";

    $result = mysqli_query($con, $sql);
    $products = [];

    $subCategoryNames = [];
    $subCategoryIds = array_column($result->fetch_all(MYSQLI_ASSOC), 'subcategory');

    if (!empty($subCategoryIds)) {
        $subCategorySql = "SELECT id, name FROM subcats WHERE id IN (" . implode(',', $subCategoryIds) . ")";
        $subCategoryResult = mysqli_query($con, $subCategorySql);

        while ($row = mysqli_fetch_assoc($subCategoryResult)) {
            $subCategoryNames[$row['id']] = $row['name'];
        }
    }

    mysqli_data_seek($result, 0);

    while ($row = mysqli_fetch_assoc($result)) {
        $row['sub_category_name'] = $subCategoryNames[$row['subcategory']] ?? '';
        $row = fix_strings($row);
        $link = str_replace('_', '-', $row['root_name']);
        $link = urlencode(urlencode($link));
        $row['link'] = $link;
        $products[] = $row;
    }

    return $products;
}
