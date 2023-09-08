<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");
    require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

    function validate_phone($phone_number)
    {
        if (!ctype_digit($phone_number) || strlen($phone_number) != 10) {
            return false;
        }
        $phone_number_util = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $number_proto = $phone_number_util->parse($phone_number, 'TR');
            if ($phone_number_util->isValidNumber($number_proto)) {
                return true;
            } else {
                return false;
            }
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
    }

    define('MB', 1048576);

    $change_avatar = false;

    $id = $_SESSION['id'];
    $name = get_safe_value($con, $_POST['name']);
    $surname = get_safe_value($con, $_POST['surname']);
    $telephone = get_safe_value($con, $_POST['phone']);
    $address = get_safe_value($con, $_POST['address']);
    $city = get_safe_value($con, $_POST['city']);
    $district = @get_safe_value($con, $_POST['district']);
    $apartment = get_safe_value($con, $_POST['apartment']);
    $floor = get_safe_value($con, $_POST['floor']);
    $door = get_safe_value($con, $_POST['door']);
    $avatar = $_FILES['avatar-input'];

    $sql = "SELECT profile_image,submissions, last_submission FROM users WHERE id = '$id'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    $avatar_check = $row['profile_image'];
    $submissions = $row['submissions'];
    $last_sub = $row['last_submission'];

    $submissions = reset_submission_counts($con, $submissions, $last_sub, $id);

    if ($avatar['name'] != '') {
        $change_avatar = true;
        $avatar_ext = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));
        $avatar_size = round($avatar['size'] / 1024 / 1024, 2);
        if ($avatar_check == 'nopp.png') {
            $avatar_name = convert_name($_SESSION['username'] . '-avatar-' . get_random_string(10) . '.' . $avatar_ext);
        } else {
            $avatar_name = $avatar_check;
        }
        $update_avatar = "UPDATE users SET profile_image='$avatar_name' WHERE id='$id'"; // Update avatar name in database
        $max_width = 800;
        $max_height = 800;
        $source_path = $avatar['tmp_name'];
    }

    if (!validate_phone($telephone)) {
        send_error_response('Lütfen geçerli bir telefon numarası girin.', 'phone');
    }
    if (strlen($apartment) > 50) {
        send_error_response('Apartman adı 50 karakterden uzun olamaz.', 'apartment');
    }

    $allowed = array('jpg', 'jpeg', 'png');

    if ($id != '') {
        if ($submissions < 8) {
            if ($change_avatar) {
                if ($avatar_size > 8) {
                    send_error_response('Lütfen 8MB\'dan daha küçük bir resim yükleyin.', 'avatar-label');
                }
                if (!in_array($avatar_ext, $allowed)) {
                    send_error_response('Lütfen geçerli bir resim dosyası yükleyin. (jpg, jpeg, png)', 'avatar-label');
                }
                if (compress_save_image($source_path, PRODUCT_USER_SERVER_PATH . $avatar_name, $max_width, $max_height) !== false) {
                    mysqli_query($con, $update_avatar);
                } else {
                    send_error_response('Resim yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'avatar-label');
                }
            } else {
                $avatar_name = $avatar_check;
            }

            $submissions += 1;
            $sql = "UPDATE users SET name='$name', surname='$surname', profile_image='$avatar_name', door='$door', apartment='$apartment',floor='$floor', city='$city', district='$district', submissions='$submissions', telephone='$telephone', address='$address' WHERE id='$id'";
            mysqli_query($con, $sql);
            send_success_response("Profil bilgileriniz başarıyla güncellendi.");
        } else {
            send_error_response('Çok fazla istek gönderdiniz. Lütfen 5 dakika sonra tekrar deneyin.');
        }
    } else {
        send_error_response('Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
