<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");

    $name = get_safe_value($con, $_POST['name']);
    $surname = get_safe_value($con, $_POST['surname']);
    $email = get_safe_value($con, $_POST['email']);
    $password = get_safe_value($con, $_POST['password']);
    $passwordConf = get_safe_value($con, $_POST['passwordConf']);

    if (empty($name)) {
        sendErrorResponse('İsim alanı boş bırakılamaz.', 'name');
    }
    if (empty($surname)) {
        sendErrorResponse('Soy isim alanı boş bırakılamaz.', 'surname');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        sendErrorResponse('Lütfen geçerli bir e-posta adresi giriniz.', 'email');
    }
    if (empty($email)) {
        sendErrorResponse('E-posta alanı boş bırakılamaz.', 'email');
    }
    if (empty($password)) {
        sendErrorResponse('Şifre alanı boş bırakılamaz.', 'password');
    }
    if ($password !== $passwordConf) {
        sendErrorResponse('Şifreler eşleşmiyor.', 'passwordConf');
    }
    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $con->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();
    if ($userCount > 0) {
        sendErrorResponse('Bu e-posta adresi zaten kayıtlı.', 'email');
    }
    if (strlen($password) < 8) {
        sendErrorResponse('Şifre minimum 8 karakter olmalıdır.', 'password');
    }
    if (strlen($name) < 2) {
        sendErrorResponse('İsim minimum 2 karakter olmalıdır.', 'name');
    } elseif (strlen($name) > 15) {
        sendErrorResponse('İsim 15 karakterden uzun olamaz.', 'name');
    }
    if (strlen($surname) < 2) {
        sendErrorResponse('Soy isim minimum 2 karakter olmalıdır.', 'surname');
    } elseif (strlen($name) > 15) {
        sendErrorResponse('Soy isim 15 karakterden uzun olamaz.', 'surname');
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
            sendVerificationEmail($email, $token);
            Register($user_id, $name, $surname, $email, $verified, $token);
            sendSuccessResponse('Kayıt başarılı. Yönlendiriliyorsunuz...');
        } else {
            sendErrorResponse('Kayıt başarısız.', 'email');
        }
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
