<?php
define('FILE_ACCESS', TRUE);
define('BYPASS_MAINTENANCE', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $email = get_safe_value($con, $_POST['email']);
    $password = get_safe_value($con, $_POST['password']);

    $errors = [
        ['message' => 'E-posta alanı boş bırakılamaz.', 'field' => 'email', 'condition' => empty($email)],
        ['message' => 'Lütfen geçerli bir e-posta adresi giriniz.', 'field' => 'email', 'condition' => !empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)],
        ['message' => 'Şifre alanı boş bırakılamaz.', 'field' => 'password', 'condition' => empty($password)],
    ];

    foreach ($errors as $error) {
        if ($error['condition']) {
            send_error_response($error['message'], $error['field']);
        }
    }

    $sql = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!empty($user) && password_verify($password, $user['password'])) {
        login($user);
        send_success_response('Giriş başarılı, yönlendiriliyorsunuz...');
    } else {
        send_error_response('Yanlış e-posta veya şifre.');
    }
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
