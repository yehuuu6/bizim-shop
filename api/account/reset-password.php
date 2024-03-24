<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$id = $_SESSION['id'];

$sql = "SELECT submissions, last_submission, token FROM users WHERE id = '$id'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res);

$submissions = $row['submissions'];
$last_sub = $row['last_submission'];

$submissions = reset_submission_counts($con, $submissions, $last_sub, $id);

if ($submissions < 8) {
    try {
        send_password_reset_link($_SESSION['email'], $row['token']);
    } catch (Exception $e) {
        send_error_response('Bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
    }
    $submissions += 1;
    $sql = "UPDATE users SET submissions = '$submissions' WHERE id = '$id'";
    mysqli_query($con, $sql);
    send_success_response('Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.');
} else {
    send_error_response('Çok fazla istek gönderdiniz. Lütfen 5 dakika sonra tekrar deneyin.');
}
