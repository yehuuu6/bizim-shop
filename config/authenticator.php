<?php

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    die();
}

session_start();

require_once('connection.inc.php');
require_once('emailer.php');
require_once('functions.inc.php');

$name = "";
$surname = "";
$email = "";

function Register($user_id, $name, $surname, $email, $verified, $token)
{
    $_SESSION['id'] = $user_id;
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    $_SESSION['username'] = $name . " " . $surname;
    $_SESSION['email'] = $email;
    $_SESSION['verified'] = $verified;
    $_SESSION['membership'] = 0;
    $_SESSION['token'] = $token;
}

function Login($user)
{
    $_SESSION['id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['surname'] = $user['surname'];
    $_SESSION['username'] = $user['name'] . " " . $user['surname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['token'] = $user['token'];
    $_SESSION['address'] = $user['address'];
    $_SESSION['membership'] = $user['membership'];
    $_SESSION['verified'] = $user['verified'];
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("location: http://localhost/auth/login");
    die();
}

function verifyUser($token)
{
    global $con;

    if (!ctype_xdigit($token)) {
        die("Geçersiz token.");
    }

    $selectQuery = "SELECT * FROM users WHERE token = ?";
    $selectStmt = mysqli_prepare($con, $selectQuery);

    mysqli_stmt_bind_param($selectStmt, "s", $token);
    mysqli_stmt_execute($selectStmt);

    $result = mysqli_stmt_get_result($selectStmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $newToken = bin2hex(random_bytes(50));

        $updateQuery = "UPDATE users SET verified = 1, token = ? WHERE token = ?";
        $updateStmt = mysqli_prepare($con, $updateQuery);

        mysqli_stmt_bind_param($updateStmt, "ss", $newToken, $token);
        if (mysqli_stmt_execute($updateStmt)) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = 1;
            header('location: http://localhost/');
            die();
        }
    } else {
        die("Tokenin süresi doldu veya geçersiz. Lütfen tekrar doğrulama e-postası gönderiniz.");
    }
}


function resetPassword($token)
{
    global $con;

    if (!ctype_xdigit($token)) {
        die("Geçersiz token.");
    }

    $query = "SELECT * FROM users WHERE token = ?";
    $stmt = mysqli_prepare($con, $query);

    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $user['email'];
        header('location: reset-password');
        die();
    } else {
        die("Tokenin süresi doldu veya geçersiz. Lütfen şifre sıfırlama işlemini tekrar deneyiniz.");
    }
}
