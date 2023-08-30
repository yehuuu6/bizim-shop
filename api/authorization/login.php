<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    $email = get_safe_value($con, $_POST['email']);
    $password = get_safe_value($con, $_POST['password']);

    if (empty($email)) {
        sendErrorResponse('E-posta alanı boş bırakılamaz.', 'email');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendErrorResponse('Lütfen geçerli bir e-posta adresi giriniz.', 'email');
    } elseif (empty($password)) {
        sendErrorResponse('Şifre alanı boş bırakılamaz.', 'password');
    } else {
        $sql = "SELECT * FROM users WHERE email=? LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if (!empty($user) && password_verify($password, $user['password'])) {
            Login($user);
            sendSuccessResponse('Giriş başarılı, yönlendiriliyorsunuz...');
        } else {
            sendErrorResponse('Yanlış e-posta veya şifre.', 'none');
        }
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
