<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $id = $_SESSION['id'];

    $sql = "SELECT profile_image, submissions, last_submission FROM users WHERE id = '" . $id . "'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);
    $image = $row['profile_image'];
    $submissions = $row['submissions'];
    $last_sub = $row['last_submission'];

    $submissions = reset_submission_counts($con, $submissions, $last_sub, $id);

    $going_to_delete = array($image);

    function delete_files($files)
    {
        // Delete for each file
        foreach ($files as $_file) {
            try {
                if ($_file != 'nopp.png') {
                    unlink(PRODUCT_USER_SERVER_PATH . $_file);
                }
            } catch (Exception $e) {
                send_error_response('Bir hata oluştu, lütfen daha sonra tekrar deneyin.');
            }
        }
    }

    if (isset($_SESSION['id'])) {
        if ($submissions < 8) {
            $submissions += 1;
            $sql = "UPDATE users SET profile_image = 'nopp.png', submissions ='$submissions' WHERE id = '" . $id . "'";
            try {
                mysqli_query($con, $sql);
                delete_files($going_to_delete);
                $_SESSION['profile_image'] = 'nopp.png';
                send_success_response('Profil resmi başarıyla silindi.');
            } catch (Exception $e) {
                send_error_response('Bir hata oluştu, lütfen daha sonra tekrar deneyin.');
            }
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
