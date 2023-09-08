<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $password = get_safe_value($con, $_POST['password']);
    $password_confirm = get_safe_value($con, $_POST['passwordConf']);

    if (empty($password) || empty($password_confirm)) {
        send_error_response('Lütfen tüm alanları doldurunuz.', 'password');
    } elseif ($password !== $password_confirm) {
        send_error_response('Şifreler eşleşmiyor.', 'password_confirm');
    } elseif (strlen($password) < 8) {
        send_error_response('Şifre minimum 8 karakter olmalıdır.', 'password');
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $email = $_SESSION['email'];
        $token1 = bin2hex(random_bytes(50));
        $sql = "UPDATE users SET password='$password', token='$token1' WHERE email = '$email'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            send_success_response("Şifreniz başarıyla güncellendi, yönlendiriliyorsunuz...");
        } else {
            send_error_response('Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.', 'password');
        }
        die();
    }

    die();
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
