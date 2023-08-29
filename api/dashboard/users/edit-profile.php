<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");
    require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

    function validatePhoneNumber($phoneNumber)
    {
        if (!ctype_digit($phoneNumber) || strlen($phoneNumber) != 10) {
            return false;
        }
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $numberProto = $phoneNumberUtil->parse($phoneNumber, 'TR');
            if ($phoneNumberUtil->isValidNumber($numberProto)) {
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

    $submissions = resetSubmissionCounts($con, $submissions, $last_sub, $id);

    if ($avatar['name'] != '') {
        $change_avatar = true;
        $avatar_ext = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));
        $avatar_size = round($avatar['size'] / 1024 / 1024, 2);
        if ($avatar_check == 'nopp.png') {
            $avatar_name = convertName($_SESSION['username'] . '-avatar-' . randomString(10) . '.' . $avatar_ext);
        } else {
            $avatar_name = $avatar_check;
        }
        $update_avatar = 'UPDATE users SET profile_image = "' . $avatar_name . '" WHERE id = "' . $id . '"';
        $max_width = 800;
        $max_height = 800;
        $source_path = $avatar['tmp_name'];
    }

    if (!validatePhoneNumber($telephone)) {
        sendErrorResponse('Lütfen geçerli bir telefon numarası girin.', 'phone');
    }
    if (strlen($apartment) > 50) {
        sendErrorResponse('Apartman adı 50 karakterden uzun olamaz.', 'apartment');
    }

    $allowed = array('jpg', 'jpeg', 'png');

    if ($id != '') {
        if ($submissions < 8) {
            if ($change_avatar) {
                if ($avatar_size > 8) {
                    sendErrorResponse('Lütfen 8MB\'dan daha küçük bir resim yükleyin.', 'avatar-label');
                }
                if (!in_array($avatar_ext, $allowed)) {
                    sendErrorResponse('Lütfen geçerli bir resim dosyası yükleyin. (jpg, jpeg, png)', 'avatar-label');
                }
                if (compressAndSaveImage($source_path, PRODUCT_USER_SERVER_PATH . $avatar_name, $max_width, $max_height) !== false) {
                    mysqli_query($con, $update_avatar);
                } else {
                    sendErrorResponse('Resim yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'avatar-label');
                }
            } else {
                $avatar_name = $avatar_check;
            }

            $submissions += 1;
            $sql = "UPDATE users SET name='$name', surname='$surname', profile_image='$avatar_name', door='$door', apartment='$apartment',floor='$floor', city='$city', district='$district', submissions='$submissions', telephone='$telephone', address='$address' WHERE id='$id'";
            mysqli_query($con, $sql);
            sendSuccessResponse("Profil bilgileriniz başarıyla güncellendi.");
        } else {
            sendErrorResponse('Çok fazla istek gönderdiniz. Lütfen 5 dakika sonra tekrar deneyin.', 'none');
        }
    } else {
        sendErrorResponse('Bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'none');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
