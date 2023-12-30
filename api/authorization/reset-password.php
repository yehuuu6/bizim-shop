<?php
define('FILE_ACCESS', TRUE);

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

    $password = get_safe_value($con, $_POST['password']);
    $password_confirm = get_safe_value($con, $_POST['passwordConf']);

    $errors = [
        ['message' => 'Lütfen tüm alanları doldurunuz.', 'field' => 'none', 'condition' => empty($password) || empty($password_confirm)],
        ['message' => 'Şifreler eşleşmiyor.', 'field' => 'password_confirm', 'condition' => $password !== $password_confirm],
        ['message' => 'Şifre minimum 8 karakter olmalıdır.', 'field' => 'password', 'condition' => isset($password) && strlen($password) < 8]
    ];

    foreach ($errors as $error) {
        if ($error['condition']) {
            send_error_response($error['message'], $error['field']);
        }
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_SESSION['email'];
    $token1 = bin2hex(random_bytes(50));
    $sql = "UPDATE users SET password=?, token=? WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $password, $token1, $email);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['token'] = $token1;
        send_success_response("Şifreniz başarıyla güncellendi, yönlendiriliyorsunuz...");
    } else {
        send_error_response('Bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.');
    }
    mysqli_stmt_close($stmt);
    die();
} else {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}
