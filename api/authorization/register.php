<?php
define('FILE_ACCESS', TRUE);


require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

$name = get_safe_value($con, $_POST['name']);
$surname = get_safe_value($con, $_POST['surname']);
$email = get_safe_value($con, $_POST['email']);
$password = get_safe_value($con, $_POST['password']);
$password_confirm = get_safe_value($con, $_POST['password_confirm']);

$errors = [
    ['message' => 'İsim alanı boş bırakılamaz.', 'field' => 'name', 'condition' => empty($name)],
    ['message' => 'Soy isim alanı boş bırakılamaz.', 'field' => 'surname', 'condition' => empty($surname)],
    ['message' => 'E-posta alanı boş bırakılamaz.', 'field' => 'email', 'condition' => empty($email)],
    ['message' => 'Lütfen geçerli bir e-posta adresi giriniz.', 'field' => 'email', 'condition' => !filter_var($email, FILTER_VALIDATE_EMAIL)],
    ['message' => 'Şifre alanı boş bırakılamaz.', 'field' => 'password', 'condition' => empty($password)],
    ['message' => 'Şifreler eşleşmiyor.', 'field' => 'password_confirm', 'condition' => $password !== $password_confirm],
    ['message' => 'Şifre minimum 8 karakter olmalıdır.', 'field' => 'password', 'condition' => isset($password) && strlen($password) < 8],
    ['message' => 'İsim minimum 2 karakter olmalıdır.', 'field' => 'name', 'condition' => isset($name) && strlen($name) < 2],
    ['message' => 'İsim 15 karakterden uzun olamaz.', 'field' => 'name', 'condition' => isset($name) && strlen($name) > 15],
    ['message' => 'Soy isim minimum 2 karakter olmalıdır.', 'field' => 'surname', 'condition' => isset($surname) && strlen($surname) < 2],
    ['message' => 'Soy isim 15 karakterden uzun olamaz.', 'field' => 'surname', 'condition' => isset($surname) && strlen($surname) > 15],
];

foreach ($errors as $error) {
    if ($error['condition']) {
        send_error_response($error['message'], $error['field']);
    }
}

$email_query = "SELECT email FROM users WHERE email=? LIMIT 1";
$stmt = $con->prepare($email_query);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$userCount = $result->num_rows;
$stmt->close();

if ($userCount > 0) {
    send_error_response('Bu e-posta adresi zaten kayıtlı.', 'email');
} else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(50));
    $verified = 0;
    $sql = "INSERT INTO users(name, surname, email, verified, token, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssiss', $name, $surname, $email, $verified, $token, $password);
    if ($stmt->execute()) {
        $user_id = $con->insert_id;
        $stmt->close();
        send_verification_mail($email, $token);
        register($user_id, $name, $surname, $email, $verified, $token);
        send_success_response('Kayıt başarılı. Yönlendiriliyorsunuz...');
    } else {
        send_error_response('Kayıt başarısız.', 'email');
    }
}
