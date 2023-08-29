<?php

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/config/constants.php");

if (isset($_SESSION['id']) && $_SESSION['verified'] == 0) {
    header("location: /auth/verify");
    die();
}

$PAGE_TITLE = isset($PAGE_TITLE) ? $PAGE_TITLE : DEFAULT_PAGE_TITLE;
$PAGE_DESCRIPTION = isset($PAGE_DESCRIPTION) ? $PAGE_DESCRIPTION : DEFAULT_PAGE_DESCRIPTION;
$PAGE_KEYWORDS = isset($PAGE_KEYWORDS) ? $PAGE_KEYWORDS : DEFAULT_PAGE_KEYWORDS;
$PAGE_AUTHOR = isset($PAGE_AUTHOR) ? $PAGE_AUTHOR : DEFAULT_PAGE_AUTHOR;
$PAGE_FAVICON = isset($PAGE_FAVICON) ? $PAGE_FAVICON : DEFAULT_PAGE_FAVICON;

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $PAGE_DESCRIPTION ?>">
    <meta name="keywords" content="<?= $PAGE_KEYWORDS ?>">
    <meta name="author" content="<?= $PAGE_AUTHOR ?>">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/utils.css">
    <link rel="shortcut icon" href="<?= $PAGE_FAVICON ?>" type="image/x-icon">
    <script src="/global/plugins/icons.js"></script>
    <script src="/global/plugins/jquery.js"></script>
    <title><?= $PAGE_TITLE ?></title>
</head>

<body>
    <nav class="navbar flex-display justify-between align-center">
        <div class="navbar-item flex-display gap-5 align-center">
            <img class="navbar-svg large-svg no-drag" src="/global/imgs/favicon.svg" alt="">
            <h2 class="navbar-logo flex-display gap-5">Bizim <div class="blue-text bold-text">Shop</div>
            </h2>
        </div>
        <div class="navbar-item">
            <ul class="no-list-style flex-display justify-space-around align-center">
                <img class="navbar-svg medium-svg" src="/global/imgs/linksvg.svg" alt="">
                <li><a class="no-decoration navbar-btn" href="/">Ana Sayfa</a></li>
                <li><a class="no-decoration navbar-btn" href="/products">Ürünler</a></li>
                <li><a class="no-decoration navbar-btn" href="/feedbacks">Yorumlar</a></li>
            </ul>
        </div>
        <div class="navbar-item">
            <ul class="no-list-style flex-display justify-space-around align-center">
                <img class="navbar-svg small-svg" src="/global/imgs/usersvg.svg" alt="">
                <?php if (!isset($_SESSION['id'])) : ?>
                    <li><a class="no-decoration navbar-btn" href="/auth/login">Giriş Yap</a></li>
                    <li><a class="no-decoration navbar-btn" href="/auth/register">Kayıt Ol</a></li>
                <?php else : ?>
                    <li><a class="no-decoration navbar-btn" href="/dashboard">Hoşgeldin <?php echo $_SESSION['name'] ?></a></li>
                    <li><a class="no-decoration navbar-btn" href="/?logout=1">Çıkış</a></li>
                <?php endif; ?>
                <li>
                    <button class="interactive" id="cart-btn">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="interactive" id="wishlist-btn">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </li>
            </ul>
        </div>
    </nav>