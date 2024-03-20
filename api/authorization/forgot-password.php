<?php
define('FILE_ACCESS', TRUE);
require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$email = get_safe_value($con, $_POST['email']);

$errors = [
    'E-posta alanı boş bırakılamaz.' => empty($email),
    'Lütfen geçerli bir e-posta adresi giriniz.' => !filter_var($email, FILTER_VALIDATE_EMAIL),
];

foreach ($errors as $message => $condition) {
    if ($condition) {
        send_error_response($message, 'email');
    }
}

$email_query = "SELECT token FROM users WHERE email=? LIMIT 1";
$stmt = $con->prepare($email_query);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$userCount = $result->num_rows;
$stmt->close();
@$token = $result->fetch_assoc()['token'];

if ($userCount > 0) {
    send_password_reset_link($email, $token);
} else {
    sleep(4);
}

send_success_response('Eğer bu e-posta adresi sistemimizde kayıtlı ise, şifre sıfırlama linki gönderilmiştir.');
