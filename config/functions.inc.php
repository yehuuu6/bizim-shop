<?php

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

function get_safe_value($con, $str)
{
    if ($str != '') {
        $str = trim($str);
        return mysqli_real_escape_string($con, $str);
    }
}

function get_date($raw)
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

// Authorize function will check if the user is authorized to access the page.
function Authorize()
{
    $power = $_SESSION['membership'];
    if ($power < 1) {
        die();
    }
}

function compressAndSaveImage($source_path, $target_path, $max_width, $max_height)
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

    // Save the compressed image to the target path
    $success = imagepng($target_image, $target_path);

    // Clean up memory
    imagedestroy($source_image);
    imagedestroy($target_image);

    // Return true if the image saving is successful, or false otherwise
    return $success;
}


// Create a function that will return 10 chars long random string
function randomString($length = 10)
{
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    // Shufle the $str_result and returns substring
    // of specified length
    return substr(str_shuffle($str_result), 0, $length);
}
function getPerm($perm)
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

function convertName($str)
{
    // Replace Turkish characters with English characters
    $search = array('Ç', 'ç', 'Ğ', 'ğ', 'ı', 'İ', 'Ö', 'ö', 'Ş', 'ş', 'Ü', 'ü', ' ', '-');
    $replace = array('c', 'c', 'g', 'g', 'i', 'i', 'o', 'o', 's', 's', 'u', 'u', '_', '_');
    $str = str_replace($search, $replace, $str);
    return strtolower($str);
}

function sendErrorResponse($log, $cause)
{
    $result = array('error', $log, $cause);
    echo json_encode($result);
    die();
}

function sendSuccessResponse($log)
{
    $result = array('success', $log, 'none');
    echo json_encode($result);
    die();
}

function resetSubmissionCounts($con, $submissions, $last_sub, $id)
{
    if (time() - $last_sub > 300) {
        $sql = "UPDATE users SET submissions = 0, last_submission = " . time() . " WHERE id = '$id'";
        $submissions = 0;
        mysqli_query($con, $sql);
    }
    return $submissions;
}

function fixStrings($row)
{
    $row['name'] = str_replace("\\'", "'", $row['name']);
    $row['tags'] = str_replace("\\'", "'", $row['tags']);
    $row['description'] = str_replace("\\'", "'", $row['description']);
    return $row;
}
