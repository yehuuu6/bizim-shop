<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    $password = get_safe_value($con, $_POST['password']);
    $passwordConf = get_safe_value($con, $_POST['passwordConf']);

    if (empty($password) || empty($passwordConf)) {
        sendErrorResponse('Lütfen tüm alanları doldurunuz.', 'password');
    } elseif ($password !== $passwordConf) {
        sendErrorResponse('Şifreler eşleşmiyor.', 'passwordConf');
    } elseif (strlen($password) < 8) {
        sendErrorResponse('Şifre minimum 8 karakter olmalıdır.', 'password');
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $email = $_SESSION['email'];
        $token1 = bin2hex(random_bytes(50));
        $sql = "UPDATE users SET password='$password', token='$token1' WHERE email = '$email'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            sendSuccessResponse("Şifreniz başarıyla güncellendi, yönlendiriliyorsunuz...");
        } else {
            sendErrorResponse('Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.', 'password');
        }
        die();
    }

    die();
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
