<?php
define('FILE_ACCESS', TRUE);
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    $id = $_SESSION['id'];

    $sql = "SELECT submissions, last_submission FROM users WHERE id = '$id'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);

    $submissions = $row['submissions'];
    $last_sub = $row['last_submission'];

    $submissions = resetSubmissionCounts($con, $submissions, $last_sub, $id);

    if ($submissions < 8) {
        sendPasswordResetLink($_SESSION['email'], $_SESSION['token']);
        $submissions += 1;
        $sql = "UPDATE users SET submissions = '$submissions' WHERE id = '$id'";
        mysqli_query($con, $sql);
        sendSuccessResponse('Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.');
    } else {
        sendErrorResponse('Çok fazla istek gönderdiniz. Lütfen 5 dakika sonra tekrar deneyin.');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
