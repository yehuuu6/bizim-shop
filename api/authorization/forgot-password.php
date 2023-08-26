<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    $email = get_safe_value($con, $_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendErrorResponse('Lütfen geçerli bir e-posta adresi giriniz.', 'email');
    }
    if (empty($email)) {
        sendErrorResponse('E-posta alanı boş bırakılamaz.', 'email');
    }
    $emailQuery = "SELECT token FROM users WHERE email=? LIMIT 1";
    $stmt = $con->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();
    @$token = $result->fetch_assoc()['token'];
    $userCount > 0 ? sendPasswordResetLink($email, $token) : sleep(4);
    sendSuccessResponse('Eğer bu e-posta adresi sistemimizde kayıtlı ise, şifre sıfırlama linki gönderilmiştir.');
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
