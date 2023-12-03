<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $name = get_safe_value($con, $_POST['name']);
    $surname = get_safe_value($con, $_POST['surname']);
    $email = get_safe_value($con, $_POST['email']);
    $password = get_safe_value($con, $_POST['password']);
    $password_confirm = get_safe_value($con, $_POST['password_confirm']);

    if (empty($name)) {
        send_error_response('İsim alanı boş bırakılamaz.', 'name');
    }
    if (empty($surname)) {
        send_error_response('Soy isim alanı boş bırakılamaz.', 'surname');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        send_error_response('Lütfen geçerli bir e-posta adresi giriniz.', 'email');
    }
    if (empty($email)) {
        send_error_response('E-posta alanı boş bırakılamaz.', 'email');
    }
    if (empty($password)) {
        send_error_response('Şifre alanı boş bırakılamaz.', 'password');
    }
    if ($password !== $password_confirm) {
        send_error_response('Şifreler eşleşmiyor.', 'password_confirm');
    }
    $email_query = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $con->prepare($email_query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();
    if ($userCount > 0) {
        send_error_response('Bu e-posta adresi zaten kayıtlı.', 'email');
    }
    if (strlen($password) < 8) {
        send_error_response('Şifre minimum 8 karakter olmalıdır.', 'password');
    }
    if (strlen($name) < 2) {
        send_error_response('İsim minimum 2 karakter olmalıdır.', 'name');
    } elseif (strlen($name) > 15) {
        send_error_response('İsim 15 karakterden uzun olamaz.', 'name');
    }
    if (strlen($surname) < 2) {
        send_error_response('Soy isim minimum 2 karakter olmalıdır.', 'surname');
    } elseif (strlen($name) > 15) {
        send_error_response('Soy isim 15 karakterden uzun olamaz.', 'surname');
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
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
