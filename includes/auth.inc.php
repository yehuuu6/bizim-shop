<?php

if (!defined('FILE_ACCESS')) {
    send_forbidden_response();
}

ini_set('session.name', 'bss_i');
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_set_cookie_params([
    'lifetime' => 86400,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

require_once 'consts.inc.php';
require_once 'db.inc.php';
require_once 'functions/functions.inc.php';
require_once 'plugins/emailer.inc.php';

$name = "";
$surname = "";
$email = "";

# Pull site settings from database
$sql = "SELECT * FROM site";
$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$site = $result->fetch_assoc();

$_SESSION['maintenance'] = $site['value'];

if (isset($_GET['logout'])) {
    session_destroy();
    session_unset();
    header("location: http://localhost/auth/login");
    die();
}

if ($_SESSION['maintenance'] == 'true' && !defined('BYPASS_MAINTENANCE')) {
    if (@$_SESSION['membership'] < 1) {
        header("HTTP/1.1 503 Service Unavailable");
        include($_SERVER['DOCUMENT_ROOT'] . '/errors/503.php');
        die();
    }
}

function register($user_id, $name, $surname, $email, $verified, $token)
{
    $_SESSION['id'] = $user_id;
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    $_SESSION['username'] = $name . " " . $surname;
    $_SESSION['email'] = $email;
    $_SESSION['verified'] = $verified;
    $_SESSION['membership'] = 0;
    $_SESSION['token'] = $token;
    $_SESSION['profile_image'] = "nopp.png";
}

function login($user)
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
    $_SESSION['profile_image'] = $user['profile_image'];
}

function verify_user($token)
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
            $_SESSION['token'] = $newToken;
            header('location: http://localhost/');
            die();
        }
    } else {
        die("Tokenin süresi doldu veya geçersiz. Lütfen tekrar doğrulama e-postası gönderiniz.");
    }
}


function reset_password($token)
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
