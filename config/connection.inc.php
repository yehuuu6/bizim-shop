<?php

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

$con = mysqli_connect("localhost", "root", "", "store") or die("Connection was not established");

define('DOMAIN', 'http://localhost/');
define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] . '/assets/imgs/');
define('SITE_PATH', DOMAIN . 'assets/imgs/');
define('PRODUCT_IMAGE_SERVER_PATH', SERVER_PATH . 'dynamic/product/');
define('PRODUCT_USER_SERVER_PATH', SERVER_PATH . 'dynamic/users/');
define('PRODUCT_USER_SITE_PATH', SITE_PATH . 'dynamic/users/');
define('PRODUCT_IMAGE_SITE_PATH', SITE_PATH . 'dynamic/product/');
