<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$token = $_SESSION['token'];

$sql = "SELECT submissions, last_submission FROM users WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $submissions, $last_sub);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$submissions = reset_submission_counts($con, $submissions, $last_sub, $id);

if ($submissions < 8) {
    $submissions += 1;
    $sql = "UPDATE users SET submissions = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $submissions, $id);
    if (mysqli_stmt_execute($stmt)) {
        send_verification_mail($email, $token);
        send_success_response('Doğrulama e-postası başarıyla gönderildi.');
    } else {
        send_error_response('Bir hata oluştu, lütfen daha sonra tekrar deneyin.');
    }
    mysqli_stmt_close($stmt);
} else {
    send_error_response('Çok fazla istek gönderdiniz. Lütfen 5 dakika sonra tekrar deneyin.');
}
